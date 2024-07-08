<?php
// lucas 2612023 criado
// lucas 04032024 - adicionado modal de alterar

include_once(__DIR__ . '/../header.php');
include_once('../database/estados.php');

$estados = buscaEstados();
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

            <div class="col-2 col-lg-1 order-lg-1">
                <button class="btn btn-outline-secondary ts-btnFiltros" type="button"><i class="bi bi-funnel"></i></button>
            </div>

            <div class="col-4 col-lg-3 order-lg-2">
                <h2 class="ts-tituloPrincipal">Cidades</h2>
            </div>

            <div class="col-6 col-lg-2 order-lg-3">
                <!-- BOTÂO OPCIONAL -->
            </div>

            <div class="col-12 col-lg-6 order-lg-4">
                <div class="input-group">
                    <input type="text" class="form-control ts-input" id="buscaCidade" placeholder="Buscar por código, nome ou estado">
                    <button class="btn btn-primary rounded" type="button" id="buscar"><i class="bi bi-search"></i></button>
                    <button type="button" class="ms-4 btn btn-success" data-bs-toggle="modal" data-bs-target="#inserirCidades"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
                </div>
            </div>

        </div>

        <!-- MENUFILTROS -->
        <div class="ts-menuFiltros mt-2 px-3">
            <label>Filtrar estados:</label>

            <div class="ls-label col-sm-12">
                <select class="form-control" name="codigoEstado " id="FiltroEstado">
                    <option value="<?php echo null ?>"><?php echo "Todos"  ?></option>
                    <?php
                    foreach ($estados as $estado) {
                    ?>
                        <option value="<?php echo $estado['codigoEstado'] ?>"><?php echo $estado['nomeEstado']  ?></option>
                    <?php  } ?>
                </select>
            </div>

            <div class="col-sm text-end mt-2">
                <a onClick="limpar()" role=" button" class="btn btn-sm bg-info text-white">Limpar</a>
            </div>
        </div>

        <div class="table mt-2 ts-divTabela ts-tableFiltros">
            <table class="table table-sm table-hover">
                <thead class="ts-headertabelafixo">
                    <tr>
                        <th>codigoCidade</th>
                        <th>nomeCidade</th>
                        <th>codigoEstado</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody id='dados' class="fonteCorpo">

                </tbody>
            </table>
        </div>


        <!--------- INSERIR --------->
        <div class="modal fade bd-example-modal-lg" id="inserirCidades" tabindex="-1" aria-labelledby="inserirCidadesLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Inserir Cidade</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="form-inserirCidades">
                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <label class='form-label ts-label'>codigoCidade</label>
                                    <input type="text" class="form-control ts-input" name="codigoCidade" autocomplete="off" required>
                                </div>
                                <div class="col-md-6">
                                    <label class='form-label ts-label'>nomeCidade</label>
                                    <input type="text" class="form-control ts-input" name="nomeCidade" autocomplete="off" required>
                                </div>

                                <div class="col-md-3">
                                    <label class='form-label ts-label'>codigoEstado</label>
                                    <select class="form-select ts-input" name="codigoEstado">
                                        <option value="<?php echo null ?>"><?php echo "Todos"  ?></option>
                                        <?php
                                        foreach ($estados as $estado) {
                                        ?>
                                            <option value="<?php echo $estado['codigoEstado'] ?>"><?php echo $estado['nomeEstado']  ?></option>
                                        <?php  } ?>
                                    </select>
                                </div>

                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Cadastrar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- lucas 04032024 - adicionado modal de alterar -->
        <!--------- ALTERAR --------->
        <div class="modal fade bd-example-modal-lg" id="alterarCidade" tabindex="-1" aria-labelledby="alterarCidadeLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alterar Cidade</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="form-alterarCidade">
                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <label class='form-label ts-label'>codigoCidade</label>
                                    <input type="text" class="form-control ts-input" name="codigoCidade" id="codigoCidade" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class='form-label ts-label'>nomeCidade</label>
                                    <input type="text" class="form-control ts-input" name="nomeCidade" id="nomeCidade">
                                </div>

                                <div class="col-md-3">
                                    <label class='form-label ts-label'>codigoEstado</label>
                                    <select class="form-select ts-input" name="codigoEstado" id="codigoEstado">
                                        <option value="null"></option>
                                        <?php
                                        foreach ($estados as $estado) {
                                        ?>
                                            <option value="<?php echo $estado['codigoEstado'] ?>">
                                                <?php echo $estado['nomeEstado'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div><!--container-fluid-->

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>
    <!-- script para menu de filtros -->
    <script src="<?php echo URLROOT ?>/sistema/js/filtroTabela.js"></script>

    <script>
        buscar($("#buscaCidade").val(), $("#FiltroEstado").val());

        function limpar() {
            buscar(null, null);
            window.location.reload();
        }

        function buscar(buscaCidade, codigoEstado) {
            //alert (codigoEstado);
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '<?php echo URLROOT ?>/admin/database/cidades.php?operacao=buscar',
                beforeSend: function() {
                    $("#dados").html("Carregando...");
                },
                data: {
                    buscaCidade: buscaCidade,
                    codigoEstado: codigoEstado
                },
                success: function(msg) {
                    //alert("segundo alert: " + msg);
                    var json = JSON.parse(msg);

                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];


                        linha = linha + "<tr>";
                        linha = linha + "<td>" + object.codigoCidade + "</td>";
                        linha = linha + "<td>" + object.nomeCidade + "</td>";
                        linha = linha + "<td>" + object.codigoEstado + "</td>";
                        linha = linha + "<td>" + "<button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#alterarCidade' data-codigoCidade='" + object.codigoCidade + "'><i class='bi bi-pencil-square'></i></button>"

                        linha = linha + "</tr>";
                    }
                    $("#dados").html(linha);
                }
            });
        }

        $("#buscar").click(function() {
            buscar($("#buscaCidade").val(), $("#FiltroEstado").val());
        })

        $("#FiltroEstado").change(function() {
            buscar($("#buscaCidade").val(), $("#FiltroEstado").val());
        })

        document.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                buscar($("#buscaCidade").val(), $("#FiltroEstado").val());
            }
        });

        $(document).ready(function() {
            $("#form-inserirCidades").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/cidades.php?operacao=inserir",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

            $("#form-alterarCidade").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/cidades.php?operacao=alterar",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

            function refreshPage() {
                window.location.reload();
            }
        });

        $(document).on('click', 'button[data-bs-target="#alterarCidade"]', function() {
            var codigoCidade = $(this).attr("data-codigoCidade");
            //alert(codigoCidade)
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/admin/database/cidades.php?operacao=buscar',
                data: {
                    codigoCidade: codigoCidade
                },
                success: function(data) {
                    $('#codigoCidade').val(data.codigoCidade);
                    $('#codigoEstado').val(data.codigoEstado);
                    $('#nomeCidade').val(data.nomeCidade);

                    $('#alterarCidade').modal('show');
                }
            });
        });
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>