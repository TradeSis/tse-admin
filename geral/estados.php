<?php
// lucas 2612023 criado
// lucas 04032024 - adicionado modal de alterar

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
            <!--<BR>  BOTOES AUXILIARES -->
        </div>
        <div class="row d-flex align-items-center justify-content-center mt-1 pt-1 ">

            <div class="col-6 col-lg-6">
                <h2 class="ts-tituloPrincipal">Estados</h2>
            </div>
         
            <div class="col-6 col-lg-6">
                <div class="input-group">
                    <input type="text" class="form-control ts-input" id="buscaEstado" placeholder="Buscar por código ou nome">
                    <button class="btn btn-primary rounded" type="button" id="buscar"><i class="bi bi-search"></i></button>
                    <button type="button" class="ms-4 btn btn-success" data-bs-toggle="modal" data-bs-target="#inserirEstados"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
                </div>
            </div>

        </div>

        <div class="table mt-2 ts-divTabela ts-tableFiltros">
            <table class="table table-sm table-hover">
                <thead class="ts-headertabelafixo">
                    <tr>
                        <th>codigoEstado</th>
                        <th>nomeEstado</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody id='dados' class="fonteCorpo">

                </tbody>
            </table>
        </div>


        <!--------- INSERIR --------->
        <div class="modal fade bd-example-modal-lg" id="inserirEstados" tabindex="-1" aria-labelledby="inserirEstadosLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Inserir Estados</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="form-inserirEstados"> <!-- action="../database/estados.php?operacao=inserir" -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label class='form-label ts-label'>codigoEstado</label>
                                    <input type="text" class="form-control ts-input" name="codigoEstado" autocomplete="off" required>
                                </div>
                                <div class="col-md-6">
                                    <label class='form-label ts-label'>nomeEstado</label>
                                    <input type="text" class="form-control ts-input" name="nomeEstado" autocomplete="off" required>
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
        <div class="modal fade bd-example-modal-lg" id="alterarEstados" tabindex="-1" aria-labelledby="alterarEstadosLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alterar Estado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="form-alterarEstados">
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label class='form-label ts-label'>codigoEstado</label>
                                    <input type="text" class="form-control ts-input" name="codigoEstado" id="codigoEstado" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class='form-label ts-label'>nomeEstado</label>
                                    <input type="text" class="form-control ts-input" name="nomeEstado" id="nomeEstado">
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

    <script>
        buscar($("#buscaEstado").val());

        function limpar() {
            buscar(null, null, null, null);
            window.location.reload();
        }

        function buscar(buscaEstado) {
            //alert (buscaEstado);
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '<?php echo URLROOT ?>/admin/database/estados.php?operacao=buscar',
                beforeSend: function() {
                    $("#dados").html("Carregando...");
                },
                data: {
                    buscaEstado: buscaEstado
                },
                success: function(msg) {
                    //alert("segundo alert: " + msg);
                    var json = JSON.parse(msg);

                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];


                        linha = linha + "<tr>";
                        linha = linha + "<td>" + object.codigoEstado + "</td>";
                        linha = linha + "<td>" + object.nomeEstado + "</td>";
                        linha = linha + "<td>" + "<button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#alterarEstados' data-codigoEstado='" + object.codigoEstado + "'><i class='bi bi-pencil-square'></i></button>"

                        linha = linha + "</tr>";
                    }
                    $("#dados").html(linha);
                }
            });
        }

        $("#buscar").click(function() {
            buscar($("#buscaEstado").val());
        })

        document.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                buscar($("#buscaEstado").val());
            }
        });

        $(document).ready(function() {
            $("#form-inserirEstados").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/estados.php?operacao=inserir",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

            $("#form-alterarEstados").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/estados.php?operacao=alterar",
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


        $(document).on('click', 'button[data-bs-target="#alterarEstados"]', function() {
            var codigoEstado = $(this).attr("data-codigoEstado");
            //alert(codigoEstado)
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo URLROOT ?>/admin/database/estados.php?operacao=buscar',
                data: {
                    codigoEstado: codigoEstado
                },
                success: function(data) {
                    $('#codigoEstado').val(data.codigoEstado);
                    $('#nomeEstado').val(data.nomeEstado);
                   
                    $('#alterarEstados').modal('show');
                }
            });
        });

    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>