def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field idFornecimento  like geralfornecimento.idFornecimento
    field buscaFornecimento  AS CHAR
    field filtroDataAtualizacao  AS CHAR
    field idGeralProduto  like geralfornecimento.idGeralProduto.

def temp-table ttgeralfornecimento  no-undo serialize-name "geralfornecimento"  /* JSON SAIDA */
    like geralfornecimento
    FIELD nomePessoa AS CHAR
    FIELD eanProduto AS INT64
    FIELD nomeFantasia AS CHAR.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

def VAR vidFornecimento like ttentrada.idFornecimento.
def VAR veanProduto AS INT.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.

vidFornecimento = 0.
if avail ttentrada
then do:
    vidFornecimento = ttentrada.idFornecimento.
    if vidFornecimento = ? then vidFornecimento = 0.
end.

IF ttentrada.idFornecimento <> ? OR (ttentrada.idFornecimento = ? AND ttentrada.buscaFornecimento = ? AND ttentrada.filtroDataAtualizacao = ? AND ttentrada.idGeralProduto = ?)
THEN DO:
    for each geralfornecimento where
        (if vidFornecimento = 0
         then true /* TODOS */
         else geralfornecimento.idFornecimento = vidFornecimento)
         no-lock.

         RUN criaFornecimento.

    end.
END.

IF ttentrada.idGeralProduto <> ?
THEN DO:
    for each geralfornecimento where geralfornecimento.idGeralProduto = ttentrada.idGeralProduto
     no-lock.
     
     FIND geralpessoas WHERE geralpessoas.cpfCnpj = geralfornecimento.Cnpj NO-LOCK NO-ERROR.
     IF NOT AVAIL geralpessoas
     THEN DO:
        RUN montasaida (400,"geralpessoas.cpfCnpj nao encontrado").
        RETURN.
     END.
     
     FIND geralprodutos WHERE geralprodutos.idGeralProduto = geralfornecimento.idGeralProduto NO-LOCK NO-ERROR.
     IF NOT AVAIL geralprodutos
     THEN DO:
        RUN montasaida (400,"geralprodutos.idGeralProduto nao encontrado").
        RETURN.
     END.

     //RUN criaFornecimento.
     create ttgeralfornecimento.
     ttgeralfornecimento.idFornecimento = geralfornecimento.idFornecimento.
     ttgeralfornecimento.Cnpj = geralfornecimento.Cnpj.
     ttgeralfornecimento.refProduto = geralfornecimento.refProduto.
     ttgeralfornecimento.idGeralProduto = geralfornecimento.idGeralProduto.
     ttgeralfornecimento.valorCompra = geralfornecimento.valorCompra.
     ttgeralfornecimento.origem = geralfornecimento.origem.
     ttgeralfornecimento.cfop = geralfornecimento.cfop.
     ttgeralfornecimento.nomePessoa = geralpessoas.nomePessoa.
     ttgeralfornecimento.nomeProduto = geralfornecimento.nomeProduto.
     ttgeralfornecimento.eanProduto = geralprodutos.eanProduto.
     ttgeralfornecimento.nomeFantasia = geralpessoas.nomeFantasia.
     ttgeralfornecimento.dataAtualizacaoTributaria = geralfornecimento.dataAtualizacaoTributaria.

    end.
END.


IF ttentrada.buscaFornecimento <> ? AND ttentrada.filtroDataAtualizacao = ?
THEN DO:
    veanProduto = INT(ttentrada.buscaFornecimento) no-error.
    FIND geralprodutos WHERE geralprodutos.eanProduto = veanProduto NO-LOCK NO-ERROR.
    
    IF AVAILABLE geralprodutos 
    THEN DO:
        FOR EACH geralfornecimento WHERE
            geralfornecimento.idGeralProduto = geralprodutos.idGeralProduto
            NO-LOCK.

            RUN criaFornecimento.
        END.
    END.

    FIND geralpessoas WHERE geralpessoas.cpfCnpj = ttentrada.buscaFornecimento NO-LOCK NO-ERROR.
    IF AVAILABLE geralpessoas 
    THEN DO:
        FOR EACH geralfornecimento WHERE
            geralfornecimento.Cnpj = ttentrada.buscaFornecimento 
            NO-LOCK.

            RUN criaFornecimento.
        END.
    END.
END.

IF ttentrada.filtroDataAtualizacao = "dataAtualizada"
THEN DO:
    for each geralfornecimento where
        geralfornecimento.dataAtualizacaoTributaria <> ?
        no-lock.
       
        RUN criaFornecimento.
    
    end.
END. 

IF ttentrada.filtroDataAtualizacao = "dataNaoAtualizada"
THEN DO:
    for each geralfornecimento where
        geralfornecimento.dataAtualizacaoTributaria = ?
        no-lock.
        
       RUN criaFornecimento.
    
    end.
END.  

find first ttgeralfornecimento no-error.

if not avail ttgeralfornecimento
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Produto nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttgeralfornecimento:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).


PROCEDURE criaFornecimento.

    FIND geralpessoas WHERE geralpessoas.cpfCnpj = geralfornecimento.Cnpj NO-LOCK NO-ERROR.
    IF NOT AVAIL geralpessoas
    THEN DO:
        RUN montasaida (400,"geralpessoas.cpfCnpj nao encontrado").
            RETURN.
        END.
         
    FIND geralprodutos WHERE geralprodutos.idGeralProduto = geralfornecimento.idGeralProduto NO-LOCK NO-ERROR.
    IF NOT AVAIL geralprodutos
    THEN DO:
        RUN montasaida (400,"geralprodutos.idGeralProduto nao encontrado").
        RETURN.
    END.
         
    create ttgeralfornecimento.
    ttgeralfornecimento.idFornecimento = geralfornecimento.idFornecimento.
    ttgeralfornecimento.Cnpj = geralfornecimento.Cnpj.
    ttgeralfornecimento.refProduto = geralfornecimento.refProduto.
    ttgeralfornecimento.idGeralProduto = geralfornecimento.idGeralProduto.
    ttgeralfornecimento.valorCompra = geralfornecimento.valorCompra.
    ttgeralfornecimento.origem = geralfornecimento.origem.
    ttgeralfornecimento.cfop = geralfornecimento.cfop.
    ttgeralfornecimento.nomePessoa = geralpessoas.nomePessoa.
    ttgeralfornecimento.nomeProduto = geralprodutos.nomeProduto.
    ttgeralfornecimento.eanProduto = geralprodutos.eanProduto.
    ttgeralfornecimento.nomeFantasia = geralpessoas.nomeFantasia.
    ttgeralfornecimento.dataAtualizacaoTributaria = geralfornecimento.dataAtualizacaoTributaria.

END.

procedure montasaida.
    DEF INPUT PARAM tstatus AS INT.
    DEF INPUT PARAM tdescricaoStatus AS CHAR.

    create ttsaida.
    ttsaida.tstatus = tstatus.
    ttsaida.descricaoStatus = tdescricaoStatus.

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    put unformatted string(vlcSaida).

END PROCEDURE.



