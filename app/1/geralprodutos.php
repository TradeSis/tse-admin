<?php
//$BANCO = "MYSQL";
$BANCO = "PROGRESS";

if ($BANCO == "MYSQL") $conexao = conectaMysql(null);

//LOG
$LOG_CAMINHO=defineCaminhoLog();
if (isset($LOG_CAMINHO)) {
    $LOG_NIVEL=defineNivelLog();
    $identificacao=date("dmYHis")."-PID".getmypid()."-"."geralprodutos";
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

$produtos = array();

if ($BANCO == "MYSQL") {

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
}

if ($BANCO == "PROGRESS") {

  $progr = new chamaprogress();
  $retorno = $progr->executarprogress("admin/app/1/geralprodutos",json_encode($jsonEntrada));
  fwrite($arquivo,$identificacao."-RETORNO->".$retorno."\n");
  $produtos = json_decode($retorno,true);
  if (isset($produtos["conteudoSaida"][0])) { // Conteudo Saida - Caso de erro
      $produtos = $produtos["conteudoSaida"][0];
  } else {
    
     if (!isset($produtos["geralprodutos"][1]) && ($jsonEntrada['idGeralProduto'] != null) ) {  // Verifica se tem mais de 1 registro
      $produtos = $produtos["geralprodutos"][0]; // Retorno sem array
    }else {
      $produtos = $produtos["geralprodutos"];  
    }

  }

}

$jsonSaida = $produtos;


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
