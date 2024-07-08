<?php
//$BANCO = "MYSQL";
$BANCO = "PROGRESS";

if ($BANCO == "MYSQL") $conexao = conectaMysql(null);

//LOG
$LOG_CAMINHO=defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL=defineNivelLog();
    $identificacao=date("dmYHis")."-PID".getmypid()."-"."estados";
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

$estados = array();

if ($BANCO == "MYSQL") {

    $sql = "SELECT * FROM estados ";
    if (isset($jsonEntrada["codigoEstado"])) {
      $sql = $sql . " where estados.codigoEstado = " . "'" . $jsonEntrada["codigoEstado"] . "'";
    }
    $where = " where ";
    if (isset($jsonEntrada["buscaEstado"])) {
      $sql = $sql . $where . " estados.codigoEstado = " . "'" . $jsonEntrada["buscaEstado"] . "'
        OR estados.nomeEstado like " . "'%" . $jsonEntrada["buscaEstado"] . "%'" ;
      $where = " and ";
    }
    //echo $sql;

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
      array_push($estados, $row);
      $rows = $rows + 1;
    }

    if (isset($jsonEntrada["codigoEstado"]) && $rows==1) {
      $estados = $estados[0];
    }
  
}

if ($BANCO == "PROGRESS") {

  $progr = new chamaprogress();
  $retorno = $progr->executarprogress("admin/app/1/estados",json_encode($jsonEntrada));
  fwrite($arquivo,$identificacao."-RETORNO->".$retorno."\n");
  $estados = json_decode($retorno,true);
  if (isset($estados["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
      $estados = $estados["conteudoSaida"][0];
  } else {
    
     if (!isset($estados["estados"][1]) && ($jsonEntrada['codigoEstado'] != null)) {  // Verifica se tem mais de 1 registro
      $estados = $estados["estados"][0]; // Retorno sem array
    } else {
      $estados = $estados["estados"];  
    }

  }

}



$jsonSaida = $estados;


//LOG
if(isset($LOG_NIVEL)) {
  if ($LOG_NIVEL>=2) {
      fwrite($arquivo,$identificacao."-SAIDA->".json_encode($jsonSaida)."\n\n");
  }
}
//LOG


fclose($arquivo);


?>

<?php
// Inicio

    
?>

