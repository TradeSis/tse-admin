<?php
//Helio 05102023 padrao novo
//Lucas 04042023 criado
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

            <div class="col-1 col-lg-1">
                <h2 class="ts-tituloPrincipal">Fornecimento</h2>
            </div>

            <div class="col-3">
                <form id="form-atualizaFornecimento" method="post">
                    <div class="col-md-3">
                        <input type="hidden" class="form-control ts-input" name="idFornecimento"  value="null">
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-warning" id="atualizaFornecimento-btn">Atualizar Produtos
                        <span class="spinner-border-sm span-load"  role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="col-2 pt-2">
                <!-- FILTROS -->
                <form method="post">
                    <select class="form-select ts-input" name="filtroDataAtualizacao" id="filtroDataAtualizacao">
                        <option value="">Todos</option>
                        <option value="dataAtualizada">Atualizados</option>
                        <option value="dataNaoAtualizada">Nao Atualizados</option>
                    </select>
                </form>
            </div>
     
            <div class="col-6 col-lg-6">
                <div class="input-group">
                    <input type="text" class="form-control ts-input" id="buscaFornecimento" placeholder="Buscar por cpf/cnpj ou nome">
                    <button class="btn btn-primary rounded" type="button" id="buscar"><i class="bi bi-search"></i></button>
                    <button type="button" class="ms-4 btn btn-success" data-bs-toggle="modal" data-bs-target="#inserirFornecedorModal"><i class="bi bi-plus-square"></i>&nbsp Novo</button>
                </div>
            </div>

        </div>

        <div class="table mt-2 ts-divTabela ts-tableFiltros text-center">
            <table class="table table-sm table-hover">
                <thead class="ts-headertabelafixo">
                    <tr class="ts-headerTabelaLinhaCima">
                        <th>Cnpj</th>
                        <th>Fornecedor</th>
                        <th>idProduto</th>
                        <th>refProduto</th>
                        <th>eanProduto</th>
                        <th>Produto</th>
                        <th>Valor</th>
                        <th>cfop</th>
                        <th>origem</th>
                        <th>Att Trib.</th>
                        <th colspan="2">Ação</th>
                    </tr>
                </thead>

                <tbody id='dados' class="fonteCorpo">

                </tbody>
            </table>
        </div>

        <!-- Modal Fornecimento Inserir-->
        <?php include 'modalFornecimento_inserir.php'; ?>

        <!-- Modal Fornecimento Alterar-->
        <?php include 'modalFornecimento_Alterar.php'; ?>

    </div><!--container-fluid-->

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script>
        buscar($("#buscaFornecimento").val(), $("#filtroDataAtualizacao").val());

        function limpar() {
            buscar(null, null, null, null);
            window.location.reload();
        }

        function buscar(buscaFornecimento, filtroDataAtualizacao) {
            //alert (buscaFornecimento);
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: '<?php echo URLROOT ?>/admin/database/geral.php?operacao=buscarGeralFornecimento',
                beforeSend: function() {
                    $("#dados").html("Carregando...");
                },
                data: {
                    filtroDataAtualizacao: filtroDataAtualizacao,
                    buscaFornecimento: buscaFornecimento
                },
                success: function(msg) {
                    //alert("segundo alert: " + msg);
                    var json = JSON.parse(msg);

                    var linha = "";
                    for (var $i = 0; $i < json.length; $i++) {
                        var object = json[$i];

                        vnomeFantasia = object.nomeFantasia
                        if(object.nomeFantasia == null){
                            vnomeFantasia = object.nomePessoa
                        }

                        linha = linha + "<tr>";
                        linha = linha + "<td>" + object.Cnpj + "</td>";
                        linha = linha + "<td>" + vnomeFantasia + "</td>";
                        linha = linha + "<td>" + object.idGeralProduto + "</td>";
                        linha = linha + "<td>" + object.refProduto + "</td>";
                        linha = linha + "<td>" + (object.eanProduto ? object.eanProduto : "--")+ "</td>";
                        linha = linha + "<td>" + object.nomeProduto + "</td>";   
                        linha = linha + "<td>" + object.valorCompra + "</td>";
                        linha = linha + "<td>" + object.cfop + "</td>";
                        linha = linha + "<td>" + object.origem + "</td>";
                        linha = linha + "<td>" + (object.dataAtualizacaoTributaria ? formatarData(object.dataAtualizacaoTributaria) : "--") + "</td>";

                        linha = linha + "<td>" + "<button type='button' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#alterarFornecedorModal' data-idFornecimento='" + object.idFornecimento + "'><i class='bi bi-pencil-square'></i></button> "
                        linha = linha + "</tr>";
                    }
                    $("#dados").html(linha);
                }
            });
        }

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
            buscar($("#buscaFornecimento").val(), $("#filtroDataAtualizacao").val());
        })

        $("#filtroDataAtualizacao").change(function() {
            buscar($("#buscaFornecimento").val(), $("#filtroDataAtualizacao").val());
        })

        document.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                buscar($("#buscaFornecimento").val(), $("#filtroDataAtualizacao").val());
            }
        });
        
        $(document).on('click', 'button[data-bs-target="#atualizaFornecedorModal"]', function() {

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '../database/geral.php?operacao=atualizar',
            data: {
                idFornecimento: idFornecedorAtualiza
            }
        });
        window.location.reload();

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
                        idFornecedorAtualiza = data.idFornecimento;
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

        $(document).ready(function() {
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


            $("#form-atualizaFornecimento").submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: "../database/geral.php?operacao=atualizarGeralFornecimento",
                    beforeSend: function() {
                        setTimeout(function(){
                            $("#atualizaFornecimento-btn").prop('disabled', true);
                            $(".span-load").addClass("spinner-border");
                            
                        },500);
                    },
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: refreshPage,
                });
            });
        });
     

        function refreshPage() {
            window.location.reload();
        }

    </script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>