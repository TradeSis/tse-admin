<?php
// lucas 26122023 criado
//echo "-ENTRADA->".json_encode($jsonEntrada)."\n";
//$BANCO = "MYSQL";
$BANCO = "PROGRESS";

if ($BANCO == "MYSQL") $conexao = conectaMysql(null);

//LOG
$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "cidades";
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

$cidades = array();

if ($BANCO == "MYSQL") {
  $sql = "SELECT * FROM cidades ";
  if (isset($jsonEntrada["codigoCidade"])) {
    $sql = $sql . " where cidades.codigoCidade = " . $jsonEntrada["codigoCidade"];
  }
  $where = " where ";
  if (isset($jsonEntrada["buscaCidade"])) {
    $sql = $sql . $where . " cidades.codigoCidade like " . "'%" . $jsonEntrada["buscaCidade"] . "%'
      OR cidades.nomeCidade like " . "'%" . $jsonEntrada["buscaCidade"] . "%'
      OR cidades.	codigoEstado like " . "'%" . $jsonEntrada["buscaCidade"] . "%'" ;
    $where = " and ";
  }
/*   if (isset($jsonEntrada["buscaCidade"])) {
    $sql = $sql . $where . " cidades.codigoCidade = " . $jsonEntrada["buscaCidade"] . " 
    OR cidades.nomeCidade like " . "'%" . $jsonEntrada["buscaCidade"] . "%'
    OR cidades.	codigoEstado = " . "'" . $jsonEntrada["buscaCidade"] . "'"; 
    $where = " and ";
  } */
  if (isset($jsonEntrada["codigoEstado"])) {
    $sql = $sql . $where . " cidades.	codigoEstado = " . "'" . $jsonEntrada["codigoEstado"] . "'"; 
    $where = " and ";
  }
//echo $sql;

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
    array_push($cidades, $row);
    $rows = $rows + 1;
  }

  if (isset($jsonEntrada["codigoCidade"]) && $rows == 1) {
    $cidades = $cidades[0];
  }
}


if ($BANCO == "PROGRESS") {

  $progr = new chamaprogress();
  $retorno = $progr->executarprogress("admin/app/1/cidades",json_encode($jsonEntrada));
  fwrite($arquivo,$identificacao."-RETORNO->".$retorno."\n");
  $cidades = json_decode($retorno,true);
  if (isset($cidades["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
      $cidades = $cidades["conteudoSaida"][0];
  } else {
    
    if (!isset($cidades["cidades"][1]) && ($jsonEntrada['codigoCidade'] != null)) {  // Verifica se tem mais de 1 registro
      $cidades = $cidades["cidades"][0]; // Retorno sem array
    } else {
      $cidades = $cidades["cidades"];  
    }

  }

}

$jsonSaida = $cidades;


//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 2) {
    fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
  }
}
//LOG

fclose($arquivo);

?>