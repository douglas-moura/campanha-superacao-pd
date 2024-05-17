<?php
session_start();
if (!isset($_SESSION['admin'])) {
    $redirect = "/";
    header("location:$redirect");
}
header('Content-Type: text/html; charset=utf-8');

include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/../partials/db.php";
$db = new Db($config);

include_once __DIR__ . "/../partials/head.php";
?>

<header class="header-operacao">
    <div class="container">
        <div class="col-sm-12">
            <div class="row">
                <a href="//www.maxxpremios.com.br/vb/" class="logo">
                    <img src="https://res.cloudinary.com/maxxpremios/image/upload/c_scale,f_auto,q_auto,w_90/v1518002711/i/logo.png">
                </a>
                <a href="https://www.gtx100.com.br/" target="_blank" class="logo-campanha-vb">
                    <img src="https://res.cloudinary.com/maxxpremios/image/upload/c_scale,f_auto,q_auto,w_100/v1533479807/i/gtx100.svg">
                </a>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="collapsed navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-9" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="#" class="navbar-brand">Admin</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-9">
                <ul class="nav navbar-nav">

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            Participantes <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="./participantes.php">Lista</a></li>
                            <li><a href="./add_participantes.php">Adicionar</a></li>
                            <li><a href="./acessos.php">Acessos</a></li>
                            <li><a href="./pontos.php">Pontos</a></li>
                        </ul>
                    </li>

                    <li><a href="./produtos.php">Lista de produtos</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Regulamentos <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="./regulamento.php?publico=agendadores">agendadores</a></li>
                            <li><a href="./regulamento.php?publico=back-office">back-office</a></li>
                            <li><a href="./regulamento.php?publico=executivo-de-vendas">executivo-de-vendas</a></li>
                            <li><a href="./regulamento.php?publico=gerente">gerente</a></li>
                            <li><a href="./regulamento.php?publico=implantacao">implantacao</a></li>
                            <li><a href="./regulamento.php?publico=marketing">marketing</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Comunicados <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="./comunicados.php">lista</a></li>
                            <li><a href="./add_comunicado.php">criar</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="./regulamentos.php">Regulamentos </a>
                    </li>

                    <li class="dropdown">
                        <a href="./pedidos.php">Pedidos </a>
                    </li>

                    <li><a href="<?php echo '//' . $config['baseUrl'] ?>/sair">Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>