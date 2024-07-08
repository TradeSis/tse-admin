def input param vlcentrada as longchar. /* JSON ENTRADA */
def input param vtmp       as char.     /* CAMINHO PROGRESS_TMP */

def var vlcsaida   as longchar.         /* JSON SAIDA */

def var lokjson as log.                 /* LOGICAL DE APOIO */
def var hentrada as handle.             /* HANDLE ENTRADA */
def var hsaida   as handle.             /* HANDLE SAIDA */

def temp-table ttentrada no-undo serialize-name "dadosEntrada"   /* JSON ENTRADA */
    field cpfCnpj  like geralpessoas.cpfCnpj.

def temp-table ttgeralpessoas  no-undo serialize-name "geralpessoas"  /* JSON SAIDA */
    like geralpessoas.

def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as char.

def VAR vcpfCnpj like ttentrada.cpfCnpj.


hEntrada = temp-table ttentrada:HANDLE.
lokJSON = hentrada:READ-JSON("longchar",vlcentrada, "EMPTY") no-error.
find first ttentrada no-error.

vcpfCnpj = ?.
if avail ttentrada
then do:
    vcpfCnpj = ttentrada.cpfCnpj.
    if vcpfCnpj = "" then vcpfCnpj = ?.
end.

for each geralpessoas where
    (if vcpfCnpj = ?
    then true /* TODOS */
    ELSE geralpessoas.cpfCnpj = vcpfCnpj)
    no-lock.

    create ttgeralpessoas.
    BUFFER-COPY geralpessoas TO ttgeralpessoas.

end.
    

  

find first ttgeralpessoas no-error.

if not avail ttgeralpessoas
then do:
    create ttsaida.
    ttsaida.tstatus = 400.
    ttsaida.descricaoStatus = "Pessoa nao encontrada".

    hsaida  = temp-table ttsaida:handle.

    lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
    message string(vlcSaida).
    return.
end.

hsaida  = TEMP-TABLE ttgeralpessoas:handle.


lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
put unformatted string(vlcSaida).
