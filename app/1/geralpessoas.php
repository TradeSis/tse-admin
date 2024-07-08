<?php
//$BANCO = "MYSQL";
$BANCO = "PROGRESS";

if ($BANCO == "MYSQL") $conexao = conectaMysql(null);

//LOG
$LOG_CAMINHO=defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL=defineNivelLog();
    $identificacao=date("dmYHis")."-PID".getmypid()."-"."geralpessoas";
    if(isset($LOG_NIVEL)) {
        if ($LOG_NIVEL>=1) {
            $arquivo = fopen(defineCaminhoLog()."admin_".date("dmY").".log","a");
        }
    }
    
}
if(isset($LOG_NIVEL)) {
    if ($LOG_NIVEL==1) {
        fwrite($arquivo,$identificacao."\n");
    }
    if ($LOG_NIVEL>=2) {
        fwrite($arquivo,$identificacao."-ENTRADA->".json_encode($jsonEntrada)."\n");
    }
}
//LOG

$pessoas = array();

if ($BANCO == "MYSQL") {

  $sql = "SELECT * FROM geralpessoas ";
  if (isset($jsonEntrada["cpfCnpj"])) {
    $sql = $sql . " where geralpessoas.cpfCnpj = " . $jsonEntrada["cpfCnpj"];
  }
  //LOG
  if(isset($LOG_NIVEL)) {
    if ($LOG_NIVEL>=3) {
        fwrite($arquivo,$identificacao."-SQL->".$sql."\n");
    }
  }
  //LOG

  $rows = 0;
  $buscar = mysqli_query($conexao, $sql);
  while ($row = mysqli_fetch_array($buscar, MYSQLI_ASSOC)) {
    array_push($pessoas, $row);
    $rows = $rows + 1;
  }
  
  if (isset($jsonEntrada["cpfCnpj"]) && $jsonEntrada["acao"] !== "filtrar" && $rows == 1) {
    $pessoas = $pessoas[0];
  }
}

if ($BANCO == "PROGRESS") {

  $progr = new chamaprogress();
  $retorno = $progr->executarprogress("admin/app/1/geralpessoas",json_encode($jsonEntrada));
  fwrite($arquivo,$identificacao."-RETORNO->".$retorno."\n");
  $pessoas = json_decode($retorno,true);
  if (isset($pessoas["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
      $pessoas = $pessoas["conteudoSaida"][0];
  } else {
    
     if (!isset($pessoas["geralpessoas"][1]) && ($jsonEntrada['cpfCnpj'] != null && $jsonEntrada["acao"] !== "filtrar")) {  // Verifica se tem mais de 1 registro
      $pessoas = $pessoas["geralpessoas"][0]; // Retorno sem array
    } else {
      $pessoas = $pessoas["geralpessoas"];  
    }

  }

}

$jsonSaida = $pessoas;


//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 2) {
    fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n\n");
  }
}
//LOG

fclose($arquivo);


?>

<?php
// Inicio

    
?>
