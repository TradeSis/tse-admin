def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field idGeralProduto  like geralprodutos.idGeralProduto
    field buscaProduto  AS CHAR
    field filtroDataAtualizacao  AS CHAR.

def temp-table ttgeralprodutos  no-undo serialize-name "geralprodutos"  /* JSON SAIDA */
    like geralprodutos
    FIELD nomeGrupo LIKE fiscalgrupo.nomeGrupo
    FIELD codigoGrupo LIKE fiscalgrupo.codigoGrupo.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

def VAR vidGeralProduto like ttentrada.idGeralProduto.
def VAR veanProduto AS INT64.
DEF VAR vnomeGrupo AS CHAR.
DEF VAR vcodigoGrupo AS CHAR.
DEF VAR vdataAtualizacaoTributaria AS DATETIME.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.

vidGeralProduto = 0.
if avail ttentrada
then do:
    vidGeralProduto = ttentrada.idGeralProduto.
    if vidGeralProduto = ? then vidGeralProduto = 0.
end.

IF ttentrada.idGeralProduto <> ? OR (ttentrada.idGeralProduto = ? AND ttentrada.buscaProduto = ? AND ttentrada.filtroDataAtualizacao = ?)
THEN DO:
    for each geralprodutos where
    (if vidGeralProduto = 0
    then true /* TODOS */
    else geralprodutos.idGeralProduto = vidGeralProduto)
    no-lock.
    
    RUN criaProdutos.
    
    end.
END.

IF ttentrada.buscaProduto <> ? AND ttentrada.filtroDataAtualizacao = ?
THEN DO:
     veanProduto = INT64(ttentrada.buscaProduto).
     for each geralprodutos where
        geralprodutos.eanProduto = veanProduto OR
        geralprodutos.nomeProduto MATCHES "*" + ttentrada.buscaProduto + "*"
        no-lock.
       
       RUN criaProdutos.
    
    end.
END.


find first ttgeralprodutos no-error.

if not avail ttgeralprodutos
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Produto nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttgeralprodutos:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).


PROCEDURE criaProdutos.

    vnomeGrupo = ?.
    vcodigoGrupo = ?.
    vdataAtualizacaoTributaria = ?.
    
    FIND fiscalgrupo WHERE fiscalgrupo.idGrupo =  geralprodutos.idGrupo NO-ERROR.
    IF AVAIL fiscalgrupo
    THEN DO:
      vnomeGrupo = fiscalGrupo.nomeGrupo.
      vcodigoGrupo = fiscalGrupo.codigoGrupo.
    END.
    

        create ttgeralprodutos.
        BUFFER-COPY geralprodutos TO ttgeralprodutos.
        ttgeralprodutos.nomeGrupo = vnomeGrupo.
        ttgeralprodutos.codigoGrupo = vcodigoGrupo.

END.
