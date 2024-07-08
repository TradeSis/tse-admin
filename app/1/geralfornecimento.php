<?php
//$BANCO = "MYSQL";
$BANCO = "PROGRESS";

if ($BANCO == "MYSQL") $conexao = conectaMysql(null);

//LOG
$LOG_CAMINHO=defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL=defineNivelLog();
    $identificacao=date("dmYHis")."-PID".getmypid()."-"."geralfornecimento";
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

$fornecedor = array();

if ($BANCO == "MYSQL") {

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
}

if ($BANCO == "PROGRESS") {

  $progr = new chamaprogress();
  $retorno = $progr->executarprogress("admin/app/1/geralfornecimento",json_encode($jsonEntrada));
  fwrite($arquivo,$identificacao."-RETORNO->".$retorno."\n");
  $fornecedor = json_decode($retorno,true);
  if (isset($fornecedor["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
      $fornecedor = $fornecedor["conteudoSaida"][0];
  } else {
    
     if (!isset($fornecedor["geralfornecimento"][1]) && ($jsonEntrada['idFornecimento'] != null)) {  // Verifica se tem mais de 1 registro
      $fornecedor = $fornecedor["geralfornecimento"][0]; // Retorno sem array
    } else if($jsonEntrada['filtroDataAtualizacao'] != null){
      $fornecedor = $fornecedor["geralfornecimento"];
    }else {
      $fornecedor = $fornecedor["geralfornecimento"];  
    }

  }

}

$jsonSaida = $fornecedor;


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
