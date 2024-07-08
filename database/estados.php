<?php
//Lucas 26122023 criado
include_once __DIR__ . "/../conexao.php";

function buscaEstados($codigoEstado = null)
{

	$estados = array();

	$apiEntrada = array(
		'codigoEstado' => $codigoEstado
	);
	$estados = chamaAPI(null, '/admin/estados', json_encode($apiEntrada), 'GET');
	return $estados;
}

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao == "inserir") {

		$apiEntrada = array(
			'codigoEstado' => $_POST['codigoEstado'],
			'nomeEstado' => $_POST['nomeEstado']
		);
	
		$estados = chamaAPI(null, '/admin/estados', json_encode($apiEntrada), 'PUT');
	}

	if ($operacao == "alterar") {

		$apiEntrada = array(
			'codigoEstado' => $_POST['codigoEstado'],
			'nomeEstado' => $_POST['nomeEstado']
		);
	
		$estados = chamaAPI(null, '/admin/estados', json_encode($apiEntrada), 'POST');
	}

	// Lucas 05032024 - alterado operação buscar para enviar apenas um apiEntrada, usada para filtrar e trazer dados para alteração
	if ($operacao == "buscar") {

		$codigoEstado = isset($_POST["codigoEstado"])  && $_POST["codigoEstado"] !== "" && $_POST["codigoEstado"] !== "null" ? $_POST["codigoEstado"]  : null;
		$buscaEstado = isset($_POST["buscaEstado"])  && $_POST["buscaEstado"] !== "" && $_POST["buscaEstado"] !== "null" ?  $_POST["buscaEstado"]  : null;

		$apiEntrada = array(
			'codigoEstado' => $codigoEstado,
			'buscaEstado' => $buscaEstado
		);

		$estados = chamaAPI(null, '/admin/estados', json_encode($apiEntrada), 'GET');

		echo json_encode($estados);
		return $estados;
	}


	header('Location: ../geral/estados.php');
}
