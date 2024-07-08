<?php
// helio 31012023 criacao
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "geralpessoas_alterar";
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
if (isset($jsonEntrada['cpfCnpj'])) {
    $tipoPessoa = isset($jsonEntrada['tipoPessoa']) && $jsonEntrada['tipoPessoa'] !== "" ? "'" . $jsonEntrada['tipoPessoa'] . "'" : "NULL";
    $cpfCnpj = isset($jsonEntrada['cpfCnpj']) && $jsonEntrada['cpfCnpj'] !== "" ? "'" . $jsonEntrada['cpfCnpj'] . "'" : "NULL";
    $nomePessoa = isset($jsonEntrada['nomePessoa']) && $jsonEntrada['nomePessoa'] !== "" ? "'" . $jsonEntrada['nomePessoa'] . "'" : "NULL";
    $IE = isset($jsonEntrada['IE']) && $jsonEntrada['IE'] !== "" ? "'" . $jsonEntrada['IE'] . "'" : "NULL";
    $municipio = isset($jsonEntrada['municipio']) && $jsonEntrada['municipio'] !== "" ? "'" . $jsonEntrada['municipio'] . "'" : "NULL";
    $codigoCidade = isset($jsonEntrada['codigoCidade']) && $jsonEntrada['codigoCidade'] !== "" ? "'" . $jsonEntrada['codigoCidade'] . "'" : "NULL";
    $codigoEstado = isset($jsonEntrada['codigoEstado']) && $jsonEntrada['codigoEstado'] !== "" ? "'" . $jsonEntrada['codigoEstado'] . "'" : "NULL";
    $pais = isset($jsonEntrada['pais']) && $jsonEntrada['pais'] !== "" ? "'" . $jsonEntrada['pais'] . "'" : "NULL";
    $bairro = isset($jsonEntrada['bairro']) && $jsonEntrada['bairro'] !== "" ? "'" . $jsonEntrada['bairro'] . "'" : "NULL";
    $endereco = isset($jsonEntrada['endereco']) && $jsonEntrada['endereco'] !== "" ? "'" . $jsonEntrada['endereco'] . "'" : "NULL";
    $endNumero = isset($jsonEntrada['endNumero']) && $jsonEntrada['endNumero'] !== "" ? "'" . $jsonEntrada['endNumero'] . "'" : "NULL";
    $cep = isset($jsonEntrada['cep']) && $jsonEntrada['cep'] !== "" ? "'" . $jsonEntrada['cep'] . "'" : "NULL";
    $email = isset($jsonEntrada['email']) && $jsonEntrada['email'] !== "" ? "'" . $jsonEntrada['email'] . "'" : "NULL";
    $telefone = isset($jsonEntrada['telefone']) && $jsonEntrada['telefone'] !== "" ? "'" . $jsonEntrada['telefone'] . "'" : "NULL";
    $crt = isset($jsonEntrada['crt']) && $jsonEntrada['crt'] !== "" ? "'" . $jsonEntrada['crt'] . "'" : "NULL";
    $regimeTrib = isset($jsonEntrada['regimeTrib']) && $jsonEntrada['regimeTrib'] !== "" ? "'" . $jsonEntrada['regimeTrib'] . "'" : "NULL";
    $cnae = isset($jsonEntrada['cnae']) && $jsonEntrada['cnae'] !== "" ? "'" . $jsonEntrada['cnae'] . "'" : "NULL";
    $regimeEspecial = isset($jsonEntrada['regimeEspecial']) && $jsonEntrada['regimeEspecial'] !== "" ? "'" . $jsonEntrada['regimeEspecial'] . "'" : "NULL";
    $caracTrib = isset($jsonEntrada['caracTrib']) && $jsonEntrada['caracTrib'] !== "" ? "'" . $jsonEntrada['caracTrib'] . "'" : "NULL";
    $origem = isset($jsonEntrada['origem']) && $jsonEntrada['origem'] !== "" ? "'" . $jsonEntrada['origem'] . "'" : "NULL";

    $sql = "UPDATE geralpessoas SET tipoPessoa=$tipoPessoa, nomePessoa=$nomePessoa, IE=$IE, 
        municipio=$municipio, codigoCidade=$codigoCidade, codigoEstado=$codigoEstado, pais=$pais, bairro=$bairro, endereco=$endereco,
        endNumero=$endNumero, cep=$cep, email=$email, telefone=$telefone,crt=$crt,regimeTrib=$regimeTrib, cnae=$cnae,
        regimeEspecial=$regimeEspecial, caracTrib=$caracTrib, origem=$origem WHERE cpfCnpj = $cpfCnpj";

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
