<?php
//Lucas 26122023 criado
include_once __DIR__ . "/../conexao.php";

function buscaAplicativos($idAplicativo = null)
{

	$app = array();

	$apiEntrada = array(
		'idAplicativo' => $idAplicativo
	);
	$app = chamaAPI(null, '/admin/aplicativo', json_encode($apiEntrada), 'GET');
	return $app;
}


if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {

		$apiEntrada = array(
			'codigoCidade' => $_POST['codigoCidade'],
			'nomeCidade' => $_POST['nomeCidade'],
			'codigoEstado' => $_POST['codigoEstado']

		);

		$app = chamaAPI(null, '/admin/cidades', json_encode($apiEntrada), 'PUT');
	}

	if ($operacao == "alterar") {

		$apiEntrada = array(
			'codigoCidade' => $_POST['codigoCidade'],
			'nomeCidade' => $_POST['nomeCidade'],
			'codigoEstado' => $_POST['codigoEstado']

		);

		$app = chamaAPI(null, '/admin/cidades', json_encode($apiEntrada), 'POST');
	}

	// Lucas 05032024 - alterado operação buscar para enviar apenas um apiEntrada, usada para filtrar e trazer dados para alteração
	if ($operacao == "buscar") {

		$codigoCidade = isset($_POST["codigoCidade"])  && $_POST["codigoCidade"] !== "" && $_POST["codigoCidade"] !== "null" ? $_POST["codigoCidade"]  : null;
		$buscaCidade = isset($_POST["buscaCidade"])  && $_POST["buscaCidade"] !== "" && $_POST["buscaCidade"] !== "null" ? $_POST["buscaCidade"]  : null;
		$codigoEstado =  isset($_POST["codigoEstado"])  && $_POST["codigoEstado"] !== "" && $_POST["codigoEstado"] !== "null" ? $_POST["codigoEstado"]  : null;

		$apiEntrada = array(
			'codigoCidade' => $codigoCidade,
			'buscaCidade' => $buscaCidade,
			'codigoEstado' => $codigoEstado
		);

		$cidades = chamaAPI(null, '/admin/cidades', json_encode($apiEntrada), 'GET');

		echo json_encode($cidades);
		return $cidades;
	}


	header('Location: ../geral/cidades.php');
}
