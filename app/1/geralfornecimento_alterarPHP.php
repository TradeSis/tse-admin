<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "geralfornecimento_alterar";
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 1) {
            $arquivo = fopen(defineCaminhoLog() . "admin_" . date("dmY") . ".log", "a");
        }
    }
}
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL == 1) {
        fwrite($arquivo, $identificacao . "\n");
    }
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-ENTRADA->" . json_encode($jsonEntrada) . "\n");
    }
}
//LOG


$conexao = conectaMysql(null);

if (isset($jsonEntrada['idFornecimento'])) {

    $idFornecimento = isset($jsonEntrada['idFornecimento']) && $jsonEntrada['idFornecimento'] !== "" ? "'" . $jsonEntrada['idFornecimento'] . "'" : "NULL";
    $Cnpj = isset($jsonEntrada['Cnpj']) && $jsonEntrada['Cnpj'] !== "" && $jsonEntrada['Cnpj'] !== "NULL" ? "'" . $jsonEntrada['Cnpj'] . "'" : "NULL";
    $refProduto = isset($jsonEntrada['refProduto']) && $jsonEntrada['refProduto'] !== "" ? "'" . $jsonEntrada['refProduto'] . "'" : "NULL";
    $idGeralProduto = isset($jsonEntrada['idGeralProduto']) && $jsonEntrada['idGeralProduto'] !== "" ? "'" . $jsonEntrada['idGeralProduto'] . "'" : "NULL";
    $valorCompra = isset($jsonEntrada['valorCompra']) && $jsonEntrada['valorCompra'] !== "" ? "'" . $jsonEntrada['valorCompra'] . "'" : "NULL";
   

    $sql = "UPDATE geralfornecimento SET Cnpj = $Cnpj, refProduto = $refProduto, idGeralProduto = $idGeralProduto, valorCompra = $valorCompra WHERE idFornecimento = $idFornecimento";

   
    //echo $sql;

    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-imgProduto->" . $imgProduto . "\n");
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
        }
    }
    //LOG

    //TRY-CATCH
    try {

        $atualizar = mysqli_query($conexao, $sql);
        if (!$atualizar)
            throw new Exception(mysqli_error($conexao));

        $jsonSaida = array(
            "status" => 200,
            "retorno" => "ok"
        );
    } catch (Exception $e) {
        $jsonSaida = array(
            "status" => 500,
            "retorno" => $e->getMessage()
        );
        if ($LOG_NIVEL >= 1) {
            fwrite($arquivo, $identificacao . "-ERRO->" . $e->getMessage() . "\n");
        }
    } finally {
        // ACAO EM CASO DE ERRO (CATCH), que mesmo assim precise
    }
    //TRY-CATCH


} else {
    $jsonSaida = array(
        "status" => 400,
        "retorno" => "Faltaram parametros"
    );
}

//LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
    }
}
//LOG
