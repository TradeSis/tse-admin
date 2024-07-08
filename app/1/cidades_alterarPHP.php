<?php
//Lucas 04032024 - criacao

//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

$conexao = conectaMysql(null);

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "cidades_alterar";
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

if (isset($jsonEntrada['codigoCidade'])) {
    $codigoCidade = isset($jsonEntrada['codigoCidade'])  && $jsonEntrada['codigoCidade'] !== "" && $jsonEntrada['codigoCidade'] !== "null" ? "'". $jsonEntrada['codigoCidade']."'"  : "null";
    $codigoEstado = isset($jsonEntrada['codigoEstado'])  && $jsonEntrada['codigoEstado'] !== "" && $jsonEntrada['codigoEstado'] !== "null" ? "'". $jsonEntrada['codigoEstado']."'"  : "null";
    $nomeCidade = isset($jsonEntrada['nomeCidade'])  && $jsonEntrada['nomeCidade'] !== "" && $jsonEntrada['nomeCidade'] !== "null" ? "'". $jsonEntrada['nomeCidade']."'"  : "null";

    $sql = "UPDATE cidades SET codigoEstado = $codigoEstado, nomeCidade = $nomeCidade WHERE codigoCidade = $codigoCidade ";

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
