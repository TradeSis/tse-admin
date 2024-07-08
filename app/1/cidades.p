def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "cidades"   /* JSON ENTRADA */
    field codigoCidade like cidades.codigoCidade
    field buscaCidade  AS CHAR
    field codigoEstado like cidades.codigoEstado.

def temp-table ttcidades  no-undo serialize-name "cidades"  /* JSON SAIDA */
    field codigoCidade   like cidades.codigoCidade
    field codigoEstado   like cidades.codigoEstado
    field nomeCidade     like cidades.nomeCidade.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

def VAR vcodigoCidade like ttentrada.codigoCidade.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.

vcodigoCidade = 0.
if avail ttentrada
then do:
    vcodigoCidade = ttentrada.codigoCidade.
    if vcodigoCidade = ? then vcodigoCidade = 0.
end.

IF ttentrada.codigoCidade <> ? OR (ttentrada.codigoCidade = ? AND ttentrada.buscaCidade = ? AND ttentrada.codigoEstado = ?)
THEN DO:
    for each cidades where
        (if vcodigoCidade = 0
         then true /* TODOS */
         else cidades.codigoCidade = vcodigoCidade)
         no-lock.

        RUN criaCidades.

    end.
END.

IF ttentrada.buscaCidade <> ?
THEN DO:
      vcodigoCidade = INT(ttentrada.buscaCidade) no-error.  
      for each cidades WHERE 
        cidades.codigoCidade = vcodigoCidade OR 
        cidades.nomeCidade MATCHES "*" + ttentrada.buscaCidade + "*" OR 
        cidades.codigoEstado = ttentrada.buscaCidade
        no-lock.
        
        RUN criaCidades.

    end.
END.

IF ttentrada.codigoEstado <> ?
THEN DO:
      for each cidades WHERE 
        cidades.codigoEstado = ttentrada.codigoEstado
        no-lock.
        
        RUN criaCidades.

    end. 
END.


find first ttcidades no-error.

if not avail ttcidades
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Cidade nao encontrada".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttcidades:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
return string(vlcSaida).

PROCEDURE criaCidades.

    create ttcidades.
    ttcidades.codigoCidade = cidades.codigoCidade.
    ttcidades.codigoEstado = cidades.codigoEstado.
    ttcidades.nomeCidade   = cidades.nomeCidade.

END.
