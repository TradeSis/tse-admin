<?php
include_once __DIR__ . "/../config.php";
include_once "header.php";
include_once ROOT . "/sistema/database/loginAplicativo.php";

$nivelMenuLogin = buscaLoginAplicativo($_SESSION['idLogin'], 'Cadastros');

$nivelMenu = $nivelMenuLogin['nivelMenu'];
?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>
    <title>Admin</title>

</head>

<body>
    <?php include_once  ROOT . "/sistema/painelmobile.php"; ?>

    <div class="d-flex">

        <?php include_once  ROOT . "/sistema/painel.php"; ?>

        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-10 d-none d-md-none d-lg-block pr-0 pl-0 ts-bgAplicativos">
                    <ul class="nav a" id="myTabs">


                        <?php
                        $tab = '';

                        if (isset($_GET['tab'])) {
                            $tab = $_GET['tab'];
                        }
                        ?>
                        <?php if ($nivelMenu >= 2) {
                            if ($tab == '') {
                                $tab = 'estados';
                            } ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link 
                                <?php if ($tab == "estados") {echo " active ";} ?>" 
                                href="?tab=estados" role="tab">Estados</a>
                            </li>
                        <?php }
                        if ($nivelMenu >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "cidades") {echo " active ";} ?>"
                                href="?tab=cidades" role="tab">Cidades</a>
                            </li>
                        <?php }
                        if ($nivelMenu >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "pessoas") {echo " active ";} ?>" 
                                href="?tab=pessoas" role="tab">Pessoas</a>
                            </li>
                        <?php }
                        if ($nivelMenu >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "produtos") {echo " active ";} ?>" 
                                href="?tab=produtos" role="tab">Produtos</a>
                            </li>
                        <?php }
                        if ($nivelMenu >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "grupoproduto") {echo " active ";} ?>" 
                                href="?tab=grupoproduto" role="tab">Grupo Produto</a>
                            </li>
                        <?php }
                        if ($nivelMenu >= 2) { ?>
                            <li class="nav-item mr-1">
                                <a class="nav-link <?php if ($tab == "fornecimento") {echo " active ";} ?>" 
                                href="?tab=fornecimento" role="tab">Fornecimento</a>
                            </li>
                        <?php } ?>
                    </ul>

                </div>
                <!--Essa coluna só vai aparecer em dispositivo mobile-->
                <div class="col-7 col-md-9 d-md-block d-lg-none ts-bgAplicativos">
                    <!--atraves do GET testa o valor para selecionar um option no select-->
                    <?php if (isset($_GET['tab'])) {
                        $getTab = $_GET['tab'];
                    } else {
                        $getTab = '';
                    } ?>
                    <select class="form-select mt-2 ts-selectSubMenuAplicativos" id="subtabAdmin"> <!-- AJUSTAR -->
                        <option value="<?php echo URLROOT ?>/admin/?tab=estados" 
                        <?php if ($getTab == "estados") {echo " selected ";} ?>>Estados</option>

                        <option value="<?php echo URLROOT ?>/admin/?tab=cidades" 
                        <?php if ($getTab == "cidades") {echo " selected ";} ?>>Cidades</option>

                        <option value="<?php echo URLROOT ?>/admin/?tab=pessoas" 
                        <?php if ($getTab == "pessoas") {echo " selected ";} ?>>Pessoas</option>

                        <option value="<?php echo URLROOT ?>/admin/?tab=produtos" 
                        <?php if ($getTab == "produtos") {echo " selected ";} ?>>Produtos</option>

                        <option value="<?php echo URLROOT ?>/admin/?tab=grupoproduto" 
                        <?php if ($getTab == "grupoproduto") {echo " selected ";} ?>>Grupo Produto</option>

                        <option value="<?php echo URLROOT ?>/admin/?tab=fornecimento" 
                        <?php if ($getTab == "fornecimento") {echo " selected ";} ?>>Fornecimento</option>

                     </select>
                </div>

                <?php include_once  ROOT . "/sistema/novoperfil.php"; ?>

            </div>



            <?php
            $src = "";

            if ($tab == "estados") {
                $src = "geral/estados.php";
            }
            if ($tab == "cidades") {
                $src = "geral/cidades.php";
            }
            if ($tab == "pessoas") {
                $src = "geral/geralpessoas.php";
            }
            if ($tab == "produtos") {
                $src = "geral/geralprodutos.php";
            }
            if ($tab == "grupoproduto") {
                $src = "geral/grupoproduto.php";
            }
            if ($tab == "fornecimento") {
                $src = "geral/geralfornecimento.php";
            } 
          

            if ($src !== "") {
            ?>
                <div class="container-fluid p-0 m-0">
                    <iframe class="row p-0 m-0 ts-iframe" src="<?php echo URLROOT ?>/admin/<?php echo $src ?>"></iframe>
                </div>
            <?php
            }
            ?>
        </div><!-- div container -->
    </div><!-- div class="d-flex" -->

    <!-- LOCAL PARA COLOCAR OS JS -->

    <?php include_once ROOT . "/vendor/footer_js.php"; ?>

    <script src="<?php echo URLROOT ?>/sistema/js/mobileSelectTabs.js"></script>

    <!-- LOCAL PARA COLOCAR OS JS -FIM -->

</body>

</html>