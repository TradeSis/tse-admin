def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "fiscalgrupo"   /* JSON ENTRADA */
    field idGrupo  like fiscalgrupo.idGrupo
    field codigoGrupo  like fiscalgrupo.codigoGrupo
    FIELD buscaGrupoProduto AS CHAR
    FIELD idGeralProduto LIKE geralprodutos.idGeralProduto.

def temp-table ttfiscalgrupo  no-undo serialize-name "fiscalgrupo"  /* JSON SAIDA */
    LIKE fiscalgrupo
    field idGeralProduto   like geralprodutos.idGeralProduto.
    
def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

def VAR vidGrupo like ttentrada.idGrupo.


hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.

vidGrupo = 0.
if avail ttentrada
then do:
    vidGrupo = ttentrada.idGrupo.  
    if vidGrupo = ? then vidGrupo = 0. 
end.
 
IF ttentrada.idGrupo <> ? OR (ttentrada.idGrupo = ? AND ttentrada.buscaGrupoProduto = ? AND ttentrada.idGeralProduto = ?)
THEN DO:
      for EACH fiscalgrupo WHERE
      (if vidGrupo = 0
        then true /* TODOS */
        ELSE fiscalgrupo.idGrupo = vidGrupo) 
        no-lock.
        
        RUN criaGrupos.

    end. 
END.

IF ttentrada.buscaGrupoProduto <> ?
THEN DO: 
      for each fiscalgrupo WHERE 
        fiscalgrupo.codigoGrupo = ttentrada.buscaGrupoProduto OR 
        fiscalgrupo.nomeGrupo MATCHES "*" + ttentrada.buscaGrupoProduto + "*"
        no-lock.
        
        RUN criaGrupos.

    end.
END.

IF ttentrada.idGeralProduto <> ? 
THEN DO:

    FIND geralprodutos WHERE geralprodutos.idGeralProduto = ttentrada.idGeralProduto NO-LOCK no-error.
    IF NOT AVAIL geralprodutos
    THEN DO:
        create ttsaida.
        ttsaida.tstatus = 400.
        ttsaida.descricaoStatus = "geralprodutos fiscal nao encontrado".

        hsaida  = temp-table ttsaida:handle.

        lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
        message string(vlcSaida).
        return.
    END.
            
    FIND fiscalgrupo WHERE fiscalgrupo.idGrupo = geralprodutos.idGrupo NO-LOCK NO-ERROR.

    create ttfiscalgrupo.
    if AVAIL fiscalgrupo then do:
        BUFFER-COPY fiscalgrupo TO ttfiscalgrupo.
    end.
    ttfiscalgrupo.idGeralProduto = geralprodutos.idGeralProduto.
            
END. 

find first ttfiscalgrupo no-error.

if not avail ttfiscalgrupo
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Grupo fiscal nao encontrada".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttfiscalgrupo:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).

PROCEDURE criaGrupos.

    create ttfiscalgrupo.
    BUFFER-COPY fiscalgrupo TO ttfiscalgrupo.
    

END.

