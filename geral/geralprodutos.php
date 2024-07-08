<?php
//Lucas 27122023 - id747 cadastros, alterado estrutura do programa
//Helio 05102023 padrao novo
//Lucas 04042023 criado
include_once(__DIR__ . '/../header.php');
include_once(ROOT . '/cadastros/database/marcas.php');
include_once('../database/grupoproduto.php');
$marcas = buscaMarcas();
$buscagrupos = buscaCodigoGrupos(null, null, null);
if (!isset($buscagrupos['status'])) {
    $grupos = $buscagrupos;
}

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

            <div class="col-3 col-lg-3">
                <h2 class="ts-tituloPrincipal">Produtos</h2>
            </div>

            <div class="col-3">
                <form id="form-atualizaFornecimento" method="post">
                    <div class="col-md-3">
                        <input type="hidden" class="form-control ts-input" name="idFornecimento" value="null">
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-warning" id="atualizaFornecimento-btn">Atualizar Produtos
                            <span class="spinner-border-sm span-load" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="col-6 col-lg-6">
                <div class="input-group">
                    <input type="text" class="form-control ts-input" id="buscaProduto" placeholder="Buscar por nome ou eanProduto">
                    <button class="btn btn-primary rounded" type="button" id="buscar"><i class="bi bi-search"></i></button>
                    <button type="button" class="ms-4 btn btn-success" data-bs-toggle="modal" data-bs-target="#inserirPessoaModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
                </div>
            </div>

        </div>

        <div class="table mt-2 ts-divTabela ts-tableFiltros text-center">
            <table class="table table-sm table-hover">
                <thead class="ts-headertabelafixo">
                    <tr>
                        <th>ID</th>
                        <th>eanProduto</th>
                        <th>nomeProduto</th>
                        <th>Marca</th>
                        <th>Imendes</th>
                        <th>idGrupo</th>
                        <th>nomeGrupo</th>
                        <th>prodZFM</th>
                        <th colspan="2">Ação</th>
                    </tr>
                </thead>

                <tbody id='dados' class="fonteCorpo">

                </tbody>
            </table>
        </div>


        <!--------- INSERIR --------->
        <div class="modal fade bd-example-modal-lg" id="inserirPessoaModal" tabindex="-1" aria-labelledby="inserirPessoaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Inserir Produtos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="form-inserirProdutos">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label ts-label">eanProduto</label>
                                    <input type="text" class="form-control ts-input" name="eanProduto">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">nomeProduto</label>
                                    <input type="text" class="form-control ts-input" name="nomeProduto">
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md">
                                    <label class="form-label ts-label">Grupo</label>
                                    <select class="form-select ts-input" name="idGrupo">
                                        <?php
                                        foreach ($grupos as $grupo) {
                                        ?>
                                            <option value="<?php echo $grupo['idGrupo'] ?>"><?php echo $grupo['idGrupo'] . " - " . $grupo['nomeGrupo']  ?></option>
                                        <?php  } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md">
                                    <label class="form-label ts-label">codImendes</label>
                                    <input type="text" class="form-control ts-input" name="codImendes">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">prodZFM</label>
                                    <input type="text" class="form-control ts-input" name="prodZFM">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">Marca</label>
                                    <select class="form-select ts-input" name="idMarca">
                                        <?php
                                        foreach ($marcas as $marca) {
                                        ?>
                                            <option value="<?php echo $marca['idMarca'] ?>"><?php echo $marca['nomeMarca']  ?></option>
                                        <?php  } ?>
                                    </select>
                                </div>
                            </div>
                    </div><!--body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Cadastrar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!--------- ALTERAR --------->
        <div class="modal fade bd-example-modal-lg" id="alterarProdutoModal" tabindex="-1" aria-labelledby="alterarProdutoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alterar Produto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body">
                        <form method="post" id="form-alterarProdutos">
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="form-label ts-label">idGeralProduto</label>
                                    <input type="text" class="form-control ts-input" name="idGeralProduto" id="idGeralProduto" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label ts-label">eanProduto</label>
                                    <input type="text" class="form-control ts-input" name="eanProduto" id="eanProduto">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">nomeProduto</label>
                                    <input type="text" class="form-control ts-input" name="nomeProduto" id="nomeProduto">
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md">
                                    <label class="form-label ts-label">Grupo</label>
                                    <select class="form-select ts-input" name="idGrupo" id="idGrupo">
                                        <?php
                                        foreach ($grupos as $grupo) {
                                        ?>
                                            <option value="<?php echo $grupo['idGrupo'] ?>"><?php echo $grupo['idGrupo'] . " - " . $grupo['nomeGrupo']  ?></option>
                                        <?php  } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md">
                                    <label class="form-label ts-label">codImendes</label>
                                    <input type="text" class="form-control ts-input" name="codImendes" id="codImendes">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">prodZFM</label>
                                    <input type="text" class="form-control ts-input" name="prodZFM" id="prodZFM">
                                </div>
                                <div class="col-md">
                                    <label class="form-label ts-label">Marca</label>
                                    <select class="form-select ts-input" name="idMarca" id="idMarca">
                                        <?php
                                        foreach ($marcas as $marca) {
                                        ?>
                                            <option value="<?php echo $marca['idMarca'] ?>"><?php echo $marca['nomeMarca']  ?></option>
                                        <?php  } ?>
                                    </select>
                                </div>
                            </div>
                    </div><!--body-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Fornecimento Inserir-->
        <?php include 'modalFornecimento_inserir.php'; ?>

        <!-- Modal Fornecimento Alterar-->
        <?php include 'modalFornecimento_Alterar.php'; ?>

    </div><!--container-fluid-->

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>
        buscar($("#buscaProduto").val());

        function buscar(buscaProduto) {

            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '<?php echo URLROOT ?>/admin/database/geral.php?operacao=buscarGeralProduto',
                beforeSend: function() {
                    $("#dados").html("Carregando...");
                },
                data: {
                    buscaProduto: buscaProduto
                },
                success: function(msg) {
                    //alert("segundo alert: " + msg);
                    var json = JSON.parse(msg);

                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];

                        linha = linha + "<tr>";
                        linha = linha + "<td class='ts-click' data-idGeralProduto='" + object.idGeralProduto + "'>" + (object.idGeralProduto ? object.idGeralProduto : "--") + "</td>";
                        linha = linha + "<td class='ts-click' data-idGeralProduto='" + object.idGeralProduto + "'>" + (object.eanProduto ? object.eanProduto : "--") + "</td>";
                        linha = linha + "<td class='ts-click' data-idGeralProduto='" + object.idGeralProduto + "'>" + (object.nomeProduto ? object.nomeProduto : "--") + "</td>";
                        linha = linha + "<td class='ts-click' data-idGeralProduto='" + object.idGeralProduto + "'>" + (object.idMarca ? object.idMarca : "--") + "</td>";
                        linha = linha + "<td class='ts-click' data-idGeralProduto='" + object.idGeralProduto + "'>" + (object.codImendes ? object.codImendes : "--") + "</td>";
                        linha = linha + "<td class='ts-click' data-idGeralProduto='" + object.idGeralProduto + "'>" + (object.idGrupo ? object.idGrupo : "--") + "</td>";
                        linha = linha + "<td class='ts-click' data-idGeralProduto='" + object.idGeralProduto + "'>" + (object.nomeGrupo ? object.nomeGrupo : "--") + "</td>";
                        linha = linha + "<td class='ts-click' data-idGeralProduto='" + object.idGeralProduto + "'>" + (object.prodZFM ? object.prodZFM : "--") + "</td>";
                        linha = linha + "<td>" + "<button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#alterarProdutoModal' data-idGeralProduto='" + object.idGeralProduto + "'><i class='bi bi-pencil-square'></i></button> ";
                        linha = linha + "</tr>";
                    }
                    $("#dados").html(linha);
                }
            });
        }

        $(document).on('click', '.ts-click', function() {
            var idGeralProduto = $(this).attr("data-idGeralProduto");

            var collapseId = 'collapse_' + idGeralProduto;

            var conteudoCollapse = "<tr class='collapse-row bg-light'><td colspan='15'><div class='collapse show' id='" + collapseId + "'>" +
                "<table class='table table-sm table-hover table-warning ts-tablecenter'>" +
                "<thead>" +
                "<tr>" +
                "<th>Cnpj</th>" +
                "<th>Fornecedor</th>" +
                "<th>idProduto</th>" +
                "<th>refProduto</th>" +
                "<th>Valor</th>" +
                "<th>cfop</th>" +
                "<th>origem</th>" +
                "<th>Att Trib.</th>" +
                "<th>Ação</th>" +
                "</tr>" +
                "</thead>" +
                "<tbody id='produto_" + idGeralProduto + "' class='fonteCorpo'></tbody>" +
                "</table>" +
                "</div></td></tr>";

            if ($('#' + collapseId).length === 0) {
                $('.collapse-row').remove();
                $(this).closest('tr').after(conteudoCollapse);


                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '<?php echo URLROOT ?>/admin/database/geral.php?operacao=buscarGeralFornecimento',
                    data: {
                        idGeralProduto: idGeralProduto,
                    },
                    success: function(data) {
                        //console.log(JSON.stringify(data, null, 2));
                        var linha = "";
                        linha = linha + "<tr>";
                        linha = linha + "<td colspan='9' class='text-end pe-1'>" + "<button type='button' class='btn btn-success btn-sm' title='Adicionar Fornecimento' data-bs-toggle='modal' data-bs-target='#inserirFornecedorModal' data-idGeralProduto='" + idGeralProduto + "'><i class='bi bi-plus-square'></i>&nbsp Novo Fornecimento</button> ";
                        linha = linha + "</tr>";

                        for (var i = 0; i < data.length; i++) {
                            var object = data[i];
                            vnomeFantasia = object.nomeFantasia
                            if (object.nomeFantasia == null) {
                                vnomeFantasia = object.nomePessoa
                            }

                            linha = linha + "<tr>";
                            linha = linha + "<td>" + object.Cnpj + "</td>";
                            linha = linha + "<td>" + vnomeFantasia + "</td>";
                            linha = linha + "<td>" + object.idGeralProduto + "</td>";
                            linha = linha + "<td>" + object.refProduto + "</td>";
                            linha = linha + "<td>" + object.valorCompra + "</td>";
                            linha = linha + "<td>" + object.cfop + "</td>";
                            linha = linha + "<td>" + object.origem + "</td>";
                            linha = linha + "<td>" + (object.dataAtualizacaoTributaria ? formatarData(object.dataAtualizacaoTributaria) : "--") + "</td>";
                            linha = linha + "<td><button type='button' class='btn btn-warning btn-sm' title='Alterar Fornecimento' data-bs-toggle='modal' data-bs-target='#alterarFornecedorModal' data-idFornecimento='" + object.idFornecimento + "'><i class='bi bi-pencil-square'></i></button></td>";
                            linha = linha + "</tr>";
                        }

                        $("#produto_" + idGeralProduto).html(linha);
                    }
                });
            } else {
                $('#' + collapseId).collapse('toggle');
                $(this).closest('tr').nextAll('.collapse-row').remove();
            }
        });

        function formatarData(data) {
            var d = new Date(data);
            var dia = d.getDate().toString().padStart(2, '0');
            var mes = (d.getMonth() + 1).toString().padStart(2, '0');
            var ano = d.getFullYear();
            var hora = d.getHours().toString().padStart(2, '0');
            var minutos = d.getMinutes().toString().padStart(2, '0');
            return dia + '/' + mes + '/' + ano + ' ' + hora + ':' + minutos;
        }

        $("#buscar").click(function() {
            buscar($("#buscaProduto").val());
        })

        document.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                buscar($("#buscaProduto").val());
            }
        });

        $(document).on('click', 'button[data-bs-target="#inserirFornecedorModal"]', function() {
            var idGeralProduto = $(this).attr("data-idGeralProduto");

            $('#fornecimento_idGeralProduto').val(idGeralProduto);
            $('#inserirFornecedorModal').modal('show');

        });

        $(document).on('click', 'button[data-bs-target="#alterarProdutoModal"]', function() {
            var idGeralProduto = $(this).attr("data-idGeralProduto");
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../database/geral.php?operacao=buscarGeralProduto',
                data: {
                    idGeralProduto: idGeralProduto
                },
                success: function(data) {
                    console.log(JSON.stringify(data, null, 2));
                    $('#idGeralProduto').val(data.idGeralProduto);
                    $('#eanProduto').val(data.eanProduto);
                    $('#nomeProduto').val(data.nomeProduto);
                    $('#idMarca').val(data.idMarca);
                    $('#codImendes').val(data.codImendes);
                    $('#codigoGrupo').val(data.codigoGrupo);
                    $('#idGrupo').val(data.idGrupo);
                    $('#prodZFM').val(data.prodZFM);

                    $('#alterarProdutoModal').modal('show');
                }

            });
        });

        $(document).ready(function() {
            $("#form-inserirProdutos").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/geral.php?operacao=geralProdutosInserir",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

            $("#form-alterarProdutos").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/geral.php?operacao=geralProdutosAlterar",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

            $("#form-atualizaFornecimento").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/geral.php?operacao=atualizarGeralFornecimento",
                    beforeSend: function() {
                        setTimeout(function() {
                            $("#atualizaFornecimento-btn").prop('disabled', true);
                            $(".span-load").addClass("spinner-border");

                        }, 500);
                    },
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

            $("#form-alterarFornecedor").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/geral.php?operacao=geralFornecedorAlterar",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

            $("#form-inserirFornecedor").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/geral.php?operacao=geralFornecedorInserir",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });

        });

        $(document).on('click', 'button[data-bs-target="#alterarFornecedorModal"]', function() {
            var idFornecimento = $(this).attr("data-idFornecimento");
            //alert(idFornecimento)
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '../database/geral.php?operacao=buscarGeralFornecimento',
                data: {
                    idFornecimento: idFornecimento
                },
                success: function(data) {
                    $('#idFornecimento').val(data.idFornecimento);
                    $('#Cnpj').val(data.Cnpj);
                    $('#refProdutoFOR').val(data.refProduto);
                    $('#idGeralProdutoFOR').val(data.idGeralProduto);
                    $('#valorCompra').val(data.valorCompra);
                    $('#nomePessoa').val(data.nomePessoa);
                    $('#nomeProdutoFOR').val(data.nomeProduto);
                    $('#eanProdutoFOR').val(data.eanProduto);
                    $('#origem').val(data.origem);
                    $('#cfop').val(data.cfop);
                    vdataFormatada = (data.dataAtualizacaoTributaria ? formatarData(data.dataAtualizacaoTributaria) : "");
                    $('#dataAtualizacaoTributaria').val(vdataFormatada);

                    $('#alterarFornecedorModal').modal('show');
                }
            });
        });

        function refreshPage() {
            window.location.reload();
        }
    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>