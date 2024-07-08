

def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def VAR vlcbearer as longchar. /* JSON ENTRADA */
RUN LOG("INICIO").

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hbearer as handle.             
def var hsaida   as handle.             /* HANDLE SAIDA */

def TEMP-TABLE ttentrada NO-UNDO serialize-name "dadosEntrada"  /* JSON ENTRADA */
    FIELD idEmpresa AS INT
    field cnpj  AS CHAR.

def temp-table ttconsultaCnpj  NO-UNDO serialize-name "consultaCnpj"  /* JSON SAIDA */
    field cnae                    as CHAR.
    
def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as CHAR.

DEF VAR token AS CHAR. 
def var vmensagem as char.

hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.

find first ttentrada no-error.
IF NOT AVAIL ttentrada 
THEN DO:
    RUN montasaida (400,"Dados de entrada invalidos!").
    RETURN.
END.

RUN admin/database/consulta_cnpj.p (  input table ttentrada,
                                      INPUT-OUTPUT table ttconsultaCnpj, 
                                      INPUT vtmp,
                                      output vmensagem).



find first ttconsultaCnpj no-error.

if not avail ttconsultaCnpj
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "consultaCnpj nao encontrado".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttconsultaCnpj:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).

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


procedure LOG.
    DEF INPUT PARAM vmensagem AS CHAR.    
    OUTPUT TO VALUE(vtmp + "/consulta_cnpj_" + string(today,"99999999") + ".log") APPEND.
        PUT UNFORMATTED 
            STRING (TIME,"HH:MM:SS")
            " progress -> " vmensagem
            SKIP.
    OUTPUT CLOSE.
    
END PROCEDURE.
