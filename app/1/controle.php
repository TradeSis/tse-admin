<?php

//echo "metodo=".$metodo."\n";
//echo "funcao=".$funcao."\n";
//echo "parametro=".$parametro."\n";

if ($metodo == "GET") {

  if ($funcao == "login" && $parametro == "verifica") {
    $funcao = "login/verifica";
    $parametro = null;
  }
  if ($funcao == "login" && $parametro == "token") {
    $funcao = "login/token";
    $parametro = null;
  }

  switch ($funcao) {

    case "estados":
      include 'estados.php';
      break;

    case "cidades":
      include 'cidades.php';
      break;

    case "geralpessoas":
      include 'geralpessoas.php';
      break;

    case "geralprodutos":
      include 'geralprodutos.php';
      break;
  
    case "geralfornecimento":
      include 'geralfornecimento.php';
      break;    
    
    case "grupoproduto":
      include 'grupoproduto.php';
      break;

    case "consulta_cnpj":
      include 'consulta_cnpj.php';
      break;

    default:
      $jsonSaida = json_decode(
        json_encode(
          array(
            "status" => "400",
            "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
          )
        ),
        TRUE
      );
      break;
  }
}

if ($metodo == "PUT") {
  switch ($funcao) {

    case "estados":
      include 'estados_inserir.php';
      break;

    case "cidades":
      include 'cidades_inserir.php';
      break;

    case "geralpessoas":
      include 'geralpessoas_inserir.php';
      break;

    case "geralprodutos":
      include 'geralprodutos_inserir.php';
      break;
    
    case "geralfornecimento":
      include 'geralfornecimento_inserir.php';
      break;

    case "grupoproduto":
      include 'grupoproduto_inserir.php';
      break;  
      
    default:
      $jsonSaida = json_decode(
        json_encode(
          array(
            "status" => "400",
            "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
          )
        ),
        TRUE
      );
      break;
  }
}

if ($metodo == "POST") {
  if ($funcao == "login" && $parametro == "ativar") {
    $funcao = "configuracao/ativar";
    $parametro = null;
  }

  switch ($funcao) {

    case "estados":
      include 'estados_alterar.php';
      break;

    case "cidades":
      include 'cidades_alterar.php';
      break;

    case "geralpessoas":
      include 'geralpessoas_alterar.php';
      break;
  
    case "geralprodutos":
      include 'geralprodutos_alterar.php';
      break;
  
    case "geralfornecimento":
      include 'geralfornecimento_alterar.php';
      break;
    
    case "grupoproduto":
      include 'grupoproduto_alterar.php';
      break;
        
    default:
      $jsonSaida = json_decode(
        json_encode(
          array(
            "status" => "400",
            "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
          )
        ),
        TRUE
      );
      break;
  }
}

if ($metodo == "DELETE") {
  switch ($funcao) {

   
    default:
      $jsonSaida = json_decode(
        json_encode(
          array(
            "status" => "400",
            "retorno" => "Aplicacao " . $aplicacao . " Versao " . $versao . " Funcao " . $funcao . " Invalida" . " Metodo " . $metodo . " Invalido "
          )
        ),
        TRUE
      );
      break;
  }
}
