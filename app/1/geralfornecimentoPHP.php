<?php
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "geralfornecimento";
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
$fornecedor = array();

$sql = "SELECT geralfornecimento.*, geralpessoas.nomePessoa, geralprodutos.nomeProduto FROM geralfornecimento 
        LEFT JOIN geralpessoas on geralpessoas.cpfCnpj = geralfornecimento.Cnpj
        LEFT JOIN geralprodutos on geralprodutos.idGeralProduto = geralfornecimento.idGeralProduto";
if (isset($jsonEntrada["idFornecimento"])) {
  $sql = $sql . " where geralfornecimento.idFornecimento = " . $jsonEntrada["idFornecimento"];
  $where = " and ";
}
if (isset($jsonEntrada["eanProduto"])) {
  $sql = $sql . " where geralfornecimento.eanProduto = " . $jsonEntrada["eanProduto"];
  $where = " and ";
}
$where = " where ";
if (isset($jsonEntrada["Cnpj"])) {
  $sql = $sql . " where geralfornecimento.Cnpj = " . $jsonEntrada["Cnpj"];
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
  array_push($fornecedor, $row);
  $rows = $rows + 1;
}

if (isset($jsonEntrada["idFornecimento"]) && $rows == 1) {
  $fornecedor = $fornecedor[0];
}
$jsonSaida = $fornecedor;


//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 2) {
    fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
  }
}
//LOG
