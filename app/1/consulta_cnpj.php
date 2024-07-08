<?php

$LOG_CAMINHO = defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
  $LOG_NIVEL = defineNivelLog();
  $identificacao = date("dmYHis") . "-PID" . getmypid() . "-" . "consulta_cnpj";
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



$operacao = array();

$progr = new chamaprogress();

// PASSANDO idEmpresa PARA PROGRESS
if (isset($jsonEntrada['idEmpresa'])) {
  $progr->setempresa($jsonEntrada['idEmpresa']);
}

$retorno = $progr->executarprogress("admin/app/1/consulta_cnpj",json_encode($jsonEntrada));
fwrite($arquivo,$identificacao."-RETORNO->".$retorno."\n");
$consultaCnpj = json_decode($retorno,true);
if (isset($consultaCnpj["consultaCnpj"][0])) { // Conteudo Saida - Caso de erro
  $consultaCnpj = $consultaCnpj["consultaCnpj"][0];
} else {

  $consultaCnpj = array(
    "status" => 400,
    "retorno" => "Erro na saida"
  );
}
$jsonSaida = $consultaCnpj;


//LOG
if (isset($LOG_NIVEL)) {
  if ($LOG_NIVEL >= 2) {
    fwrite($arquivo, $identificacao . "-SAIDA->" . json_encode($jsonSaida) . "\n");
  }
}
//LOG
