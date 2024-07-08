<?php
// lucas 08032024 - id876 passagem para progress
//Lucas 29022024 - id862 Empresa Administradora
// lucas 27122023 criado
include_once(__DIR__ . '/../header.php');

?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body>
    <div class="container-fluid">

        <div class="row ">
            <!--<BR> MENSAGENS/ALERTAS -->
        </div>
        <div class="row">
            <!--<BR> BOTOES AUXILIARES -->
        </div>
        <div class="row d-flex align-items-center justify-content-center mt-1 pt-1 ">

            <div class="col-6 col-lg-6">
                <h2 class="ts-tituloPrincipal">Grupo Produto</h2>
            </div>

            
            <div class="col-6 col-lg-6">
                <div class="input-group">
                    <input type="text" class="form-control ts-input" id="buscaGrupoProduto" placeholder="Buscar por código ou nome">
                    <button class="btn btn-primary rounded" type="button" id="buscar"><i class="bi bi-search"></i></button>
                    <!-- Lucas 29022024 - condi��o Administradora -->
                    <?php if ($_SESSION['administradora'] == 1) { ?> 
                    <button type="button" class="ms-4 btn btn-success" data-bs-toggle="modal" data-bs-target="#inserirGrupoProdutoModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
                    <?php } ?>
                </div>
            </div>

        </div>

        <div class="modal fade bd-example-modal-lg" id="visualizarGrupoProdutoModal" tabindex="-1" aria-labelledby="visualizarGrupoProdutoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Grupo </h5>&nbsp;<h5 class="modal-title" id="textoCodigoGrupo"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label ts-label">codigoGrupo</label>
                                <input type="text" class="form-control ts-input" name="codigoGrupo" id="codigoGrupo" readonly>
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">nomeGrupo</label>
                                <input type="text" class="form-control ts-input" name="nomeGrupo" id="nomeGrupo" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label ts-label">codigoNcm</label>
                                <input type="text" class="form-control ts-input" name="codigoNcm" id="codigoNcm" readonly>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md">
                                <label class="form-label ts-label">codigoCest</label>
                                <input type="text" class="form-control ts-input" name="codigoCest" id="codigoCest" readonly>
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">impostoImportacao</label>
                                <input type="text" class="form-control ts-input" name="impostoImportacao" id="impostoImportacao" readonly>
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">piscofinscstEnt</label>
                                <input type="text" class="form-control ts-input" name="piscofinscstEnt" id="piscofinscstEnt" readonly>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md">
                                <label class="form-label ts-label">piscofinscstSai</label>
                                <input type="text" class="form-control ts-input" name="piscofinscstSai" id="piscofinscstSai" readonly>
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">aliqPis</label>
                                <input type="text" class="form-control ts-input" name="aliqPis" id="aliqPis" readonly>
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">aliqCofins</label>
                                <input type="text" class="form-control ts-input" name="aliqCofins" id="aliqCofins" readonly>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md">
                                <label class="form-label ts-label">nri</label>
                                <input type="text" class="form-control ts-input" name="nri" id="nri" readonly>
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">ampLegal</label>
                                <input type="text" class="form-control ts-input" name="ampLegal" id="ampLegal" readonly>
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">redPIS</label>
                                <input type="text" class="form-control ts-input" name="redPIS" id="redPIS" readonly>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md">
                                <label class="form-label ts-label">redCofins</label>
                                <input type="text" class="form-control ts-input" name="redCofins" id="redCofins" readonly>
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">ipicstEnt</label>
                                <input type="text" class="form-control ts-input" name="ipicstEnt" id="ipicstEnt" readonly>
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">ipicstSai</label>
                                <input type="text" class="form-control ts-input" name="ipicstSai" id="ipicstSai" readonly>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md">
                                <label class="form-label ts-label">aliqipi</label>
                                <input type="text" class="form-control ts-input" name="aliqipi" id="aliqipi" readonly>
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">codenq</label>
                                <input type="text" class="form-control ts-input" name="codenq" id="codenq" readonly>
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">ipiex</label>
                                <input type="text" class="form-control ts-input" name="ipiex" id="ipiex" readonly>
                            </div>
                        </div>

                    </div><!--body-->

                </div>
            </div>
        </div>

        <!--------- INSERIR --------->
        <div class="modal fade bd-example-modal-lg" id="inserirGrupoProdutoModal" tabindex="-1" aria-labelledby="inserirGrupoProdutoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Inserir Grupo Produto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="form-inserirGrupoProduto">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label ts-label">codigoGrupo</label>
                                    <input type="text" class="form-control ts-input" name="codigoGrupo">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">nomeGrupo</label>
                                    <input type="text" class="form-control ts-input" name="nomeGrupo" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label ts-label">codigoNcm</label>
                                    <input type="text" class="form-control ts-input" name="codigoNcm">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md">
                                    <label class="form-label ts-label">codigoCest</label>
                                    <input type="text" class="form-control ts-input" name="codigoCest">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">impostoImportacao</label>
                                    <input type="text" class="form-control ts-input" name="impostoImportacao">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">piscofinscstEnt</label>
                                    <input type="text" class="form-control ts-input" name="piscofinscstEnt">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md">
                                    <label class="form-label ts-label">piscofinscstSai</label>
                                    <input type="text" class="form-control ts-input" name="piscofinscstSai">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">aliqPis</label>
                                    <input type="text" class="form-control ts-input" name="aliqPis">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">aliqCofins</label>
                                    <input type="text" class="form-control ts-input" name="aliqCofins">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md">
                                    <label class="form-label ts-label">nri</label>
                                    <input type="text" class="form-control ts-input" name="nri">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">ampLegal</label>
                                    <input type="text" class="form-control ts-input" name="ampLegal">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">redPIS</label>
                                    <input type="text" class="form-control ts-input" name="redPIS">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md">
                                    <label class="form-label ts-label">redCofins</label>
                                    <input type="text" class="form-control ts-input" name="redCofins">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">ipicstEnt</label>
                                    <input type="text" class="form-control ts-input" name="ipicstEnt">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">ipicstSai</label>
                                    <input type="text" class="form-control ts-input" name="ipicstSai">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md">
                                    <label class="form-label ts-label">aliqipi</label>
                                    <input type="text" class="form-control ts-input" name="aliqipi">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">codenq</label>
                                    <input type="text" class="form-control ts-input" name="codenq">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">ipiex</label>
                                    <input type="text" class="form-control ts-input" name="ipiex">
                                </div>
                            </div>
                    </div><!--body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="btn-formInserir">Cadastrar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- lucas 08032024 - id876 modal altera��o -->
        <!-- ALterar -->
        <div class="modal fade bd-example-modal-lg" id="alterarGrupoProdutoModal" tabindex="-1" aria-labelledby="alterarGrupoProdutoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Alterar Grupo </h5>&nbsp;<h5 class="modal-title" id="textoAlterarCodigoGrupo"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="form-alterarGrupoProduto">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label ts-label">codigoGrupo</label>
                                <input type="text" class="form-control ts-input" name="codigoGrupo" id="codigoGrupo_alterar" readonly>
                                <input type="hidden" class="form-control ts-input" name="idGrupo" id="idGrupo_alterar" readonly>
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">nomeGrupo</label>
                                <input type="text" class="form-control ts-input" name="nomeGrupo" id="nomeGrupo_alterar">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label ts-label">codigoNcm</label>
                                <input type="text" class="form-control ts-input" name="codigoNcm" id="codigoNcm_alterar">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md">
                                <label class="form-label ts-label">codigoCest</label>
                                <input type="text" class="form-control ts-input" name="codigoCest" id="codigoCest_alterar">
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">impostoImportacao</label>
                                <input type="text" class="form-control ts-input" name="impostoImportacao" id="impostoImportacao_alterar">
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">piscofinscstEnt</label>
                                <input type="text" class="form-control ts-input" name="piscofinscstEnt" id="piscofinscstEnt_alterar">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md">
                                <label class="form-label ts-label">piscofinscstSai</label>
                                <input type="text" class="form-control ts-input" name="piscofinscstSai" id="piscofinscstSai_alterar">
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">aliqPis</label>
                                <input type="text" class="form-control ts-input" name="aliqPis" id="aliqPis_alterar">
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">aliqCofins</label>
                                <input type="text" class="form-control ts-input" name="aliqCofins" id="aliqCofins_alterar">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md">
                                <label class="form-label ts-label">nri</label>
                                <input type="text" class="form-control ts-input" name="nri" id="nri_alterar">
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">ampLegal</label>
                                <input type="text" class="form-control ts-input" name="ampLegal" id="ampLegal_alterar">
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">redPIS</label>
                                <input type="text" class="form-control ts-input" name="redPIS" id="redPIS_alterar">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md">
                                <label class="form-label ts-label">redCofins</label>
                                <input type="text" class="form-control ts-input" name="redCofins" id="redCofins_alterar">
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">ipicstEnt</label>
                                <input type="text" class="form-control ts-input" name="ipicstEnt" id="ipicstEnt_alterar">
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">ipicstSai</label>
                                <input type="text" class="form-control ts-input" name="ipicstSai" id="ipicstSai_alterar">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md">
                                <label class="form-label ts-label">aliqipi</label>
                                <input type="text" class="form-control ts-input" name="aliqipi" id="aliqipi_alterar">
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">codenq</label>
                                <input type="text" class="form-control ts-input" name="codenq" id="codenq_alterar">
                            </div>
                            <div class="col-md">
                                <label class="form-label ts-label">ipiex</label>
                                <input type="text" class="form-control ts-input" name="ipiex" id="ipiex_alterar">
                            </div>
                        </div>

                    </div><!--body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="btn-formInserir">Salvar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="table mt-2 ts-divTabela ts-tableFiltros text-center">
            <table class="table table-sm table-hover">
                <thead class="ts-headertabelafixo">
                    <tr class="ts-headerTabelaLinhaCima">
                        <th>id</th>
                        <th>codigoGrupo</th>
                        <th>nomeGrupo</th>
                        <th>codigoNcm</th>
                        <th>codigoCest</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody id='dados' class="fonteCorpo">

                </tbody>
            </table>
        </div>

    </div><!--container-fluid-->

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>
        buscar($("#buscaGrupoProduto").val());

        function limpar() {
            buscar(null, null, null, null);
            window.location.reload();
        }

        function buscar(buscaGrupoProduto) {
            //alert(buscaGrupoProduto);
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '<?php echo URLROOT ?>/admin/database/grupoproduto.php?operacao=buscar',
                beforeSend: function() {
                    $("#dados").html("Carregando...");
                },
                data: {
                    buscaGrupoProduto: buscaGrupoProduto
                },
                success: function(msg) {
                    //alert("segundo alert: " + msg);
                    var json = JSON.parse(msg);

                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];

                        linha = linha + "<tr>";

                        linha = linha + "<td>" + object.idGrupo + "</td>";
                        linha = linha + "<td>" + object.codigoGrupo + "</td>";
                        linha = linha + "<td>" + object.nomeGrupo + "</td>";
                        linha = linha + "<td>" + object.codigoNcm + "</td>";
                        linha = linha + "<td>" + object.codigoCest + "</td>";
                        linha = linha + "<td>"
                        linha += "<button type='button' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#visualizarGrupoProdutoModal' data-idGrupo='" + object.idGrupo + "'><i class='bi bi-eye'></i></button> ";
                        // Lucas 31052024 - condi��o Administradora 
                        <?php if ($_SESSION['administradora'] == 1) { ?>
                        linha += "<button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#alterarGrupoProdutoModal' data-idGrupo='" + object.idGrupo + "'><i class='bi bi-pencil-square'></i></button> ";
                        linha = linha + "</td>"
                        <?php } ?>
                        linha = linha + "</tr>";
                    }
                    $("#dados").html(linha);
                }
            });
        }

        $("#buscar").click(function() {
            buscar($("#buscaGrupoProduto").val());
        })

        document.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                buscar($("#buscaGrupoProduto").val());
            }
        });

        $(document).on('click', 'button[data-bs-target="#visualizarGrupoProdutoModal"]', function() {
            var idGrupo = $(this).attr("data-idGrupo");

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/admin/database/grupoproduto.php?operacao=buscar',
                data: {
                    idGrupo: idGrupo
                },
                success: function(data) {
                    //alert(data)
                    $('#codigoGrupo').val(data.codigoGrupo);
                    $vcodigoGrupo = data.codigoGrupo;
                    var texto = $("#textoCodigoGrupo");
                    texto.html($vcodigoGrupo);

                    $('#nomeGrupo').val(data.nomeGrupo);
                    $('#codigoNcm').val(data.codigoNcm);
                    $('#codigoCest').val(data.codigoCest);
                    $('#impostoImportacao').val(data.impostoImportacao);
                    $('#piscofinscstEnt').val(data.piscofinscstEnt);
                    $('#piscofinscstSai').val(data.piscofinscstSai);
                    $('#aliqPis').val(data.aliqPis);
                    $('#aliqCofins').val(data.aliqCofins);
                    $('#nri').val(data.nri);
                    $('#ampLegal').val(data.ampLegal);
                    $('#redPIS').val(data.redPIS);
                    $('#redCofins').val(data.redCofins);
                    $('#ipicstEnt').val(data.ipicstEnt);
                    $('#ipicstSai').val(data.ipicstSai);
                    $('#aliqipi').val(data.aliqipi);
                    $('#codenq').val(data.codenq);
                    $('#ipiex').val(data.ipiex);
                    $('#visualizarGrupoProdutoModal').modal('show');
                },
                error: function(xhr, status, error) {
                    alert("ERRO=" + JSON.stringify(error));
                }
            });
        });


        $(document).on('click', 'button[data-bs-target="#alterarGrupoProdutoModal"]', function() {
            var idGrupo = $(this).attr("data-idGrupo");

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/admin/database/grupoproduto.php?operacao=buscar',
                data: {
                    idGrupo: idGrupo
                },
                success: function(data) {
                    //alert(data)
                    $('#idGrupo_alterar').val(data.idGrupo);
                    $('#codigoGrupo_alterar').val(data.codigoGrupo);
                    $v2codigoGrupo = data.codigoGrupo;
                    var texto = $("#textoAlterarCodigoGrupo");
                    texto.html($v2codigoGrupo);

                    $('#nomeGrupo_alterar').val(data.nomeGrupo);
                    $('#codigoNcm_alterar').val(data.codigoNcm);
                    $('#codigoCest_alterar').val(data.codigoCest);
                    $('#impostoImportacao_alterar').val(data.impostoImportacao);
                    $('#piscofinscstEnt_alterar').val(data.piscofinscstEnt);
                    $('#piscofinscstSai_alterar').val(data.piscofinscstSai);
                    $('#aliqPis_alterar').val(data.aliqPis);
                    $('#aliqCofins_alterar').val(data.aliqCofins);
                    $('#nri_alterar').val(data.nri);
                    $('#ampLegal_alterar').val(data.ampLegal);
                    $('#redPIS_alterar').val(data.redPIS);
                    $('#redCofins_alterar').val(data.redCofins);
                    $('#ipicstEnt_alterar').val(data.ipicstEnt);
                    $('#ipicstSai_alterar').val(data.ipicstSai);
                    $('#aliqipi_alterar').val(data.aliqipi);
                    $('#codenq_alterar').val(data.codenq);
                    $('#ipiex_alterar').val(data.ipiex);
                    $('#alterarGrupoProdutoModal').modal('show');
                },
                error: function(xhr, status, error) {
                    alert("ERRO=" + JSON.stringify(error));
                }
            });
        });

        $(document).ready(function() {
            $("#form-inserirGrupoProduto").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/grupoproduto.php?operacao=inserir",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                    error: function(xhr, status, error) {
                        alert("ERRO=" + JSON.stringify(error));
                    }
                });
            });

            $("#form-alterarGrupoProduto").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/grupoproduto.php?operacao=alterar",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                    error: function(xhr, status, error) {
                        alert("ERRO=" + JSON.stringify(error));
                    }
                });
            });


            function refreshPage() {
                window.location.reload();
            }

        });
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>