<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "geralprodutos_inserir";
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
if (isset($jsonEntrada['nomeProduto'])) {

    $eanProduto = isset($jsonEntrada['eanProduto']) && $jsonEntrada['eanProduto'] !== "" && $jsonEntrada['eanProduto'] !== "NULL" ? "'" . $jsonEntrada['eanProduto'] . "'" : "NULL";
    $nomeProduto = isset($jsonEntrada['nomeProduto']) && $jsonEntrada['nomeProduto'] !== "" ? "'" . $jsonEntrada['nomeProduto'] . "'" : "NULL";
    $idMarca = isset($jsonEntrada['idMarca']) && $jsonEntrada['idMarca'] !== "" ? "'" . $jsonEntrada['idMarca'] . "'" : "NULL";
    $dataAtualizacaoTributaria = isset($jsonEntrada['dataAtualizacaoTributaria']) && $jsonEntrada['dataAtualizacaoTributaria'] !== "" ? "'" . $jsonEntrada['dataAtualizacaoTributaria'] . "'" : "NULL";
    $codImendes = isset($jsonEntrada['codImendes']) && $jsonEntrada['codImendes'] !== "" ? "'" . $jsonEntrada['codImendes'] . "'" : "NULL";
    $idGrupo = isset($jsonEntrada['idGrupo']) && $jsonEntrada['idGrupo'] !== "" ? "'" . $jsonEntrada['idGrupo'] . "'" : "NULL";
    $prodZFM = isset($jsonEntrada['prodZFM']) && $jsonEntrada['prodZFM'] !== "" ? "'" . $jsonEntrada['prodZFM'] . "'" : "'N'";
   
    $sql = "INSERT INTO geralprodutos (eanProduto, nomeProduto, idMarca, dataAtualizacaoTributaria, codImendes, idGrupo, prodZFM)
    VALUES ($eanProduto, $nomeProduto, $idMarca, $dataAtualizacaoTributaria, $codImendes, $idGrupo, $prodZFM)";


    //LOG
    if (isset($LOG_NIVEL)) {
        if ($LOG_NIVEL >= 3) {
            fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
        }
    }
    //LOG

    //TRY-CATCH
    try {

        $atualizar = mysqli_query($conexao, $sql);
        if (!$atualizar)
            throw new Exception(mysqli_error($conexao));

        $idGeralProdutoInserido = mysqli_insert_id($conexao);
        $jsonSaida = array(
            "status" => 200,
            "retorno" => "ok",
            "idGeralProduto" => $idGeralProdutoInserido
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
