
// Programa especializado em CRAR a tabela geralprodutos
def temp-table ttentrada no-undo serialize-name "geralprodutos"   /* JSON ENTRADA */
    LIKE geralprodutos.

  
def input param vAcao as char.
DEF INPUT PARAM TABLE FOR ttentrada.
def output param vidGeralProduto as int.
def output param vmensagem as char.

vmensagem = ?.

find first ttentrada no-error.
if not avail ttentrada then do:
    vmensagem = "Dados de Entrada nao encontrados".
    return.    
end.


if ttentrada.idMarca = 0
then do:
    ttentrada.idMarca = ?.
end.
if ttentrada.idGrupo = 0
then do:
    ttentrada.idGrupo = ?.
end.
if ttentrada.prodZFM = "" or ttentrada.prodZFM = ?
then do:
    ttentrada.prodZFM = "N".
end.


if vAcao = "PUT"
THEN DO:

    if ttentrada.nomeProduto = ? or ttentrada.nomeProduto = ""
    then do:
        vmensagem = "Dados de Entrada Invalidos".
        return.
    end.

    if ttentrada.eanProduto = 0
    then do:
        ttentrada.eanProduto = ?.
    end.
    if ttentrada.codImendes = ""
    then do:
        ttentrada.codImendes = ?.
    end.

    if ttentrada.eanProduto <> ? 
    then do:
        find geralprodutos where geralprodutos.eanProduto = ttentrada.eanProduto no-lock no-error.
        if avail geralprodutos
        then do:
            vmensagem = "Produto ja cadastrado".
            return.
        end.
    end.


    do on error undo:
        create geralprodutos.
        vidGeralProduto = geralprodutos.idGeralProduto.
        geralprodutos.eanProduto   = ttentrada.eanProduto.
        geralprodutos.nomeProduto   = ttentrada.nomeProduto.
        geralprodutos.idMarca   = ttentrada.idMarca.
        geralprodutos.codImendes   = ttentrada.codImendes.
        geralprodutos.idGrupo   = ttentrada.idGrupo.
        geralprodutos.prodZFM   = ttentrada.prodZFM.
    end.
END.
IF vAcao = "POST" 
THEN DO:

    if ttentrada.idGeralProduto = ? or ttentrada.idGeralProduto = 0
    then do:
        vmensagem = "Dados de Entrada Invalidos".
        return.
    end.

    find geralprodutos where geralprodutos.idGeralProduto = ttentrada.idGeralProduto no-lock no-error.
    if not avail geralprodutos
    then do:
        vmensagem = "Produto nao cadastrado".
        return.
    end.

    do on error undo:   
        find geralprodutos where geralprodutos.idGeralProduto = ttentrada.idGeralProduto exclusive no-error.
        geralprodutos.nomeProduto = ttentrada.nomeProduto.
        if ttentrada.idMarca <> ?
        then do:
            geralprodutos.idMarca = ttentrada.idMarca.
        end.
        if ttentrada.idGrupo <> ?
        then do:
            geralprodutos.idGrupo = ttentrada.idGrupo.
        end.
        if ttentrada.prodZFM <> ?
        then do:
            geralprodutos.prodZFM = ttentrada.prodZFM.
        end.
    end.
        
END.
   
