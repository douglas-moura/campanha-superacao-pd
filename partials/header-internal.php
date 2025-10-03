<?php include_once __DIR__ . "/../partials/order.php"; ?>
<header class="header-internal">
    <div class="header-conteudo">
        <div class="logos">
            <a href="<?php echo '//' . $config['baseUrl'] ?>" class="logo-campanha">
                <img src="<?php echo '//' . $config['baseUrl'] . '/img/c/logo-campanha.png'; ?>">
            </a>
        </div>
        <div class="links">
            <div>
                <ul style="width: 60%; padding: 0; display: flex; flex-direction: column; justify-content: center;">
                    <li style="margin: auto 0;">
                        <span>Olá <?php echo $_SESSION['user']['name'] ?>,</span>
                        <br>
                        Bem-vind<?php echo $_SESSION['user']['gender'] === 'F' ? 'a' : 'o'; ?> a <b><?php echo $config['nomeCamp'] ?></b>
                    </li>
                </ul>
                <ul style="width: 40%; padding: 0;">
                    <?php if (!$_SESSION['user']['travel']) : ?>
                        <li style="text-align: right; margin: .25rem 0;">
                            Total de pontos:
                            <strong><?php echo isset($_SESSION['user']['total']) ? number_format($_SESSION['user']['total'], 0, ',', '.') : 0 ?></strong>
                        </li>
                        <li style="text-align: right; margin: .25rem 0;">
                            Pontos trocados:
                            <strong><?php echo isset($_SESSION['user']['exchanged']) ? number_format($_SESSION['user']['exchanged'], 0, ',', '.') : 0 ?></strong>
                        </li>
                        <li style="text-align: right; margin: .25rem 0;">
                            Saldo de pontos:
                            <strong><?php echo isset($_SESSION['user']['balance']) ? number_format($_SESSION['user']['balance'], 0, ',', '.') : 0 ?></strong>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
            <div class="menu">
                <?php if (!$_SESSION['user']['travel']) : ?>
                    <a class="nav-link" href="<?php echo '//' . $config['baseUrl'] ?>/catalogo">Prêmios</a>
                <?php endif ?>
                <?php if ($_SESSION['user']['travel']) : ?>
                    <a class="nav-link" href="<?php echo '//' . $config['baseUrl'] ?>/viagem">Viagem</a>
                <?php endif ?>
                <a class="nav-link" href="<?php echo '//' . $config['baseUrl'] ?>/regulamento">Regulamento</a>
                <a class="nav-link" href="<?php echo '//' . $config['baseUrl'] ?>/pontos"><?php echo ($_SESSION['user']['travel']) ? 'Desempenho' : 'Pontos e Desempenho' ?></a>
                <?php if ($_SESSION['user']['travel']) : ?>
                    <a class="nav-link" href="<?php echo '//' . $config['baseUrl'] ?>/equipe">Minha Equipe</a>
                <?php endif ?>
                <a class="nav-link" href="<?php echo '//' . $config['baseUrl'] ?>/comunicados">Comunicados</a>
                <?php if ($_SESSION['user']['travel']) : ?>
                    <a class="nav-link" href="<?php echo '//' . $config['baseUrl'] ?>/ranking">Ranking</a>
                <?php endif ?>
                <a class="nav-link" href="<?php echo '//' . $config['baseUrl'] ?>/cadastro">Seus Dados</a>
                <?php if (!$_SESSION['user']['travel']) : ?>
                    <a class="nav-link" href="<?php echo '//' . $config['baseUrl'] ?>/meuspedidos">Pedidos</a>
                <?php endif ?>
                <a class="nav-link" href="<?php echo '//' . $config['baseUrl'] ?>/sair">Sair</a>
            </div>
        </div>
    </div>
</header>
<main class="site-wrapper clearfix">
    <?php
        if (isset($page) && count($page) > 0 && isset($page['name']) && isset($page['title'])) {
    ?>
        <section class="forehead forehead-<?php echo $page['name'] ?>">
            <h2><?php echo $page['title'] ?></h2>
        </section>
    <?php
        /*
            echo '<pre>';
                echo print_r($_SESSION['user']);
            echo '</pre>';
        */

        }

    $meses_comu = [
        'Jan/25' => 'Janeiro',
        'Fev/25' => 'Fevereiro',
        'Mar/25' => 'Março',
        'Abr/25' => 'Abril',
        'Mai/25' => 'Maio',
        'Jun/25' => 'Junho',
        'Jul/25' => 'Julho',
        'Ago/25' => 'Agosto',
        'Set/25' => 'Setembro',
        'Out/25' => 'Outubro',
        'Nov/25' => 'Novembro',
        'Dez/25' => 'Dezembro'
    ];
    ?>