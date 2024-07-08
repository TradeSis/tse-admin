<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL = defineNivelLog();
    $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "geralprodutos";
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
$produtos = array();

$sql = "SELECT *, '' AS dataAtualizacaoTributariaFormatada FROM geralprodutos ";
if (isset($jsonEntrada["idGeralProduto"])) {
    $sql = $sql . " where geralprodutos.idGeralProduto = " . $jsonEntrada["idGeralProduto"];
    $where = " and ";
}
$where = " where ";
if (isset($jsonEntrada["buscaProduto"])) {
    $sql = $sql . $where . " geralprodutos.nomeProduto like " . "'%" . $jsonEntrada["buscaProduto"] . "%'
      OR geralprodutos.eanProduto like " . "'%" . $jsonEntrada["buscaProduto"] . "%' ";
    $where = " and ";
}


//LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 3) {
        fwrite($arquivo, $identificacao . "-SQL->" . $sql . "\n");
    }
}
//LOG

$rows = 0;
$buscar = mysqli_query($conexao, $sql);
while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
    array_push($produtos, $row);

    $dataAtualizacaoTributariaFormatada = null;
    if (isset($produtos[$rows]["dataAtualizacaoTributaria"])) {
        $dataAtualizacaoTributariaFormatada = date('d/m/Y H:i', strtotime($produtos[$rows]["dataAtualizacaoTributaria"]));
    }

    $produtos[$rows]["dataAtualizacaoTributariaFormatada"] = $dataAtualizacaoTributariaFormatada;

    $rows = $rows + 1;
}


if (isset($jsonEntrada["idGeralProduto"]) && $rows == 1) {
    $produtos = $produtos[0];
}
$jsonSaida = $produtos;


//LOG
if (isset($LOG_NIVEL)) {
    if ($LOG_NIVEL >= 2) {
        fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
    }
}
//LOG

