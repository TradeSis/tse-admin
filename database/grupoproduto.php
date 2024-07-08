<?php
// lucas 27122023 - criado
// lucas 08032024 - id876 passagem para progress
include_once __DIR__ . "/../conexao.php";

function buscaCodigoGrupos($idGrupo = null, $buscaGrupoProduto = null, $idGeralProduto = null)
{

	$grupos = array();

	$apiEntrada = array(
		'idGrupo' => $idGrupo,
		'buscaGrupoProduto' => $buscaGrupoProduto,
		'idGeralProduto' => $idGeralProduto
	);
	$grupos = chamaAPI(null, '/admin/grupoproduto', json_encode($apiEntrada), 'GET');
	return $grupos;
}

if (isset($_GET['operacao'])) {

	$operacao = $_GET['operacao'];

	if ($operacao=="inserir") {

		$apiEntrada = array(
			'codigoGrupo' => $_POST['codigoGrupo'],
			'nomeGrupo' => $_POST['nomeGrupo'],
			'codigoNcm' => $_POST['codigoNcm'],
			'codigoCest' => $_POST['codigoCest'],
			'impostoImportacao' => $_POST['impostoImportacao'],
			'piscofinscstEnt' => $_POST['piscofinscstEnt'],
			'piscofinscstSai' => $_POST['piscofinscstSai'],
			'aliqPis' => $_POST['aliqPis'],
			'aliqCofins' => $_POST['aliqCofins'],
			'nri' => $_POST['nri'],
			'ampLegal' => $_POST['ampLegal'],
			'redPIS' => $_POST['redPIS'],
			'redCofins' => $_POST['redCofins'],
			'ipicstEnt' => $_POST['ipicstEnt'],
			'ipicstSai' => $_POST['ipicstSai'],
			'aliqipi' => $_POST['aliqipi'],
			'codenq' => $_POST['codenq'],
			'ipiex' => $_POST['ipiex']
		);
		$grupoproduto = chamaAPI(null, '/admin/grupoproduto', json_encode($apiEntrada), 'PUT');
		//echo json_encode($apiEntrada);
		return $grupoproduto;

	}

	if ($operacao=="alterar") {

		$apiEntrada = array(
			'idGrupo' => $_POST['idGrupo'],
			'codigoGrupo' => $_POST['codigoGrupo'],
			'nomeGrupo' => $_POST['nomeGrupo'],
			'codigoNcm' => $_POST['codigoNcm'],
			'codigoCest' => $_POST['codigoCest'],
			'impostoImportacao' => $_POST['impostoImportacao'],
			'piscofinscstEnt' => $_POST['piscofinscstEnt'],
			'piscofinscstSai' => $_POST['piscofinscstSai'],
			'aliqPis' => $_POST['aliqPis'],
			'aliqCofins' => $_POST['aliqCofins'],
			'nri' => $_POST['nri'],
			'ampLegal' => $_POST['ampLegal'],
			'redPIS' => $_POST['redPIS'],
			'redCofins' => $_POST['redCofins'],
			'ipicstEnt' => $_POST['ipicstEnt'],
			'ipicstSai' => $_POST['ipicstSai'],
			'aliqipi' => $_POST['aliqipi'],
			'codenq' => $_POST['codenq'],
			'ipiex' => $_POST['ipiex']
		);
		$grupoproduto = chamaAPI(null, '/admin/grupoproduto', json_encode($apiEntrada), 'POST');
		//echo json_encode($apiEntrada);
		return $grupoproduto;

	}

	// lucas 08032024 - id876 união das operações filtrar e buscar
	if ($operacao == "buscar") {
		// lucas 08032024 - id876 alterado teste de entrada
		$idGrupo = isset($_POST["idGrupo"])  && $_POST["idGrupo"] !== "" && $_POST["idGrupo"] !== "null" ? $_POST["idGrupo"]  : null;
		$buscaGrupoProduto = isset($_POST["buscaGrupoProduto"])  && $_POST["buscaGrupoProduto"] !== "" && $_POST["buscaGrupoProduto"] !== "null" ? $_POST["buscaGrupoProduto"]  : null;

		$apiEntrada = array(
			'idGrupo' => $idGrupo,
			'buscaGrupoProduto' => $buscaGrupoProduto,
			'idGeralProduto' => null
		);
		$grupoproduto = chamaAPI(null, '/admin/grupoproduto', json_encode($apiEntrada), 'GET');

		echo json_encode($grupoproduto);
		return $grupoproduto;
	}

}

?>

