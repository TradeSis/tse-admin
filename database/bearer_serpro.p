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
  
DEFINE VARIABLE joToken         AS JsonObject NO-UNDO.


DEF INPUT PARAM idEmpresa AS INT.
DEF OUTPUT PARAM token AS CHAR.

/* APIFISCAL */
FIND apifiscal WHERE apifiscal.idEmpresa = idEmpresa AND apifiscal.fornecedor = "serpro" NO-LOCK. 

oLib = ClientLibraryBuilder:Build()
                            :sslVerifyHost(NO)
                            :ServerNameIndicator('gateway.apiserpro.serpro.gov.br') 
                            :library.
                                        
/* INI - requisicao web */
ASSIGN netClient   = ClientBuilder:Build():UsingLibrary(oLib):Client 
        netUri      = new URI("https", "gateway.apiserpro.serpro.gov.br") 
        netUri:Path = "/token?grant_type=client_credentials".
    


//FAZ A REQUISIÇÃO
netRequest = RequestBuilder:POST (netUri)
                        :AcceptJson()
                        :AddHeader("Authorization", apifiscal.chavesDeAcesso)
                        :AddHeader("Content-Type", "application/x-www-form-urlencoded")
                        :REQUEST.

netResponse = netClient:EXECUTE(netRequest).

//TRATA RETORNO
if type-of(netResponse:Entity, JsonObject) then do:
    joResponse = CAST(netResponse:Entity, JsonObject).
    joResponse:Write(lcJsonResponse).
    //RUN LOG("RETORNO Token BEARER " + STRING(lcJsonResponse)).
    
    joToken = joResponse.
    
    token = joToken:GetCharacter("access_token").

END.







