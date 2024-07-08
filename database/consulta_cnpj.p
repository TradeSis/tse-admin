/** Carrega bibliotecas necessarias **/
using OpenEdge.Net.HTTP.IHttpClientLibrary.
using OpenEdge.Net.HTTP.ConfigBuilder.
using OpenEdge.Net.HTTP.ClientBuilder.
using OpenEdge.Net.HTTP.Credentials.
using OpenEdge.Net.HTTP.IHttpClient.
using OpenEdge.Net.HTTP.IHttpRequest.
using OpenEdge.Net.HTTP.RequestBuilder.
using OpenEdge.Net.URI.
using OpenEdge.Net.HTTP.IHttpResponse.
using Progress.Json.ObjectModel.JsonObject.
using Progress.Json.ObjectModel.JsonArray.
using Progress.Json.ObjectModel.ObjectModelParser.
USING OpenEdge.Net.HTTP.Lib.ClientLibraryBuilder.

DEFINE VARIABLE oLib AS IHttpClientLibrary NO-UNDO.

def VAR netClient        AS IHttpClient        no-undo.
def VAR netUri           as URI                no-undo.
def VAR netRequest       as IHttpRequest       no-undo.
def VAR netResponse      as IHttpResponse      no-undo.

DEF VAR joResponse       AS JsonObject NO-UNDO.
DEF VAR lcJsonRequest    AS LONGCHAR NO-UNDO.
DEF VAR lcJsonResponse   AS LONGCHAR NO-UNDO.
  
DEFINE VARIABLE joCNPJ         AS JsonObject NO-UNDO.
DEFINE VARIABLE joCNAE         AS JsonObject NO-UNDO.
RUN LOG("INICIO DATABASE CONSULTA_CNPJ").

def TEMP-TABLE ttentrada NO-UNDO serialize-name "dadosEntrada"  /* JSON ENTRADA */
    FIELD idEmpresa AS INT
    field cnpj  AS CHAR.

def temp-table ttconsultaCnpj  NO-UNDO serialize-name "consultaCnpj"  /* JSON SAIDA */
    field cnae                    as CHAR.
    
def temp-table ttsaida  no-undo serialize-name "conteudoSaida"  /* JSON SAIDA CASO ERRO */
    field tstatus        as int serialize-name "status"
    field descricaoStatus      as CHAR.

DEF VAR token AS CHAR. 

DEF INPUT PARAM TABLE FOR ttentrada.
DEF INPUT-OUTPUT PARAM TABLE FOR ttconsultaCnpj.
def input param vtmp as char.
def output param vmensagem as char.

vmensagem = ?.

find first ttentrada no-error.
IF NOT AVAIL ttentrada 
THEN DO:
    RUN montasaida (400,"Dados de entrada invalidos!").
    RETURN.
END.
   
 oLib = ClientLibraryBuilder:Build()
                            :sslVerifyHost(NO)
                            :ServerNameIndicator('gateway.apiserpro.serpro.gov.br')
                            :library.
                                      
/* INI - requisicao web */
ASSIGN netClient   = ClientBuilder:Build()
                                  :UsingLibrary(oLib)
                                  :Client       
       netUri      = new URI("https", "gateway.apiserpro.serpro.gov.br") /* URI("metodo", "dominio", "porta") */
       netUri:Path = "/consulta-cnpj-df/v2/basica/" + STRING(ttentrada.cnpj).    


RUN admin/database/bearer_serpro.p ( INPUT ttentrada.idEmpresa,
                                     OUTPUT token).


//FAZ A REQUISIÇÃO
netRequest = RequestBuilder:GET (netUri)
                     :AcceptJson()
                     :AddHeader("Accept", "application/json")
                     :AddHeader("Authorization", "Bearer " + token)
                     :REQUEST.

netResponse = netClient:EXECUTE(netRequest).

//TRATA RETORNO
if type-of(netResponse:Entity, JsonObject) then do:
    joResponse = CAST(netResponse:Entity, JsonObject).
    joResponse:Write(lcJsonResponse).
    //RUN LOG("RETORNO CNPJ " + STRING(lcJsonResponse)).
    
    joCNPJ = joResponse.
    joCNAE = joCNPJ:GetJsonObject("cnaePrincipal").

   CREATE ttconsultaCnpj.
   ttconsultaCnpj.cnae = joCNAE:GetCharacter("codigo").
   RUN LOG("Criou ttconsultaCnpj: " + ttconsultaCnpj.cnae).
END.

procedure LOG.
    DEF INPUT PARAM vmensagem AS CHAR.    
    OUTPUT TO VALUE(vtmp + "/fisnota_processar_" + string(today,"99999999") + ".log") APPEND.
        PUT UNFORMATTED 
            STRING (TIME,"HH:MM:SS")
            " progress -> " vmensagem
            SKIP.
    OUTPUT CLOSE.
    
END PROCEDURE.

