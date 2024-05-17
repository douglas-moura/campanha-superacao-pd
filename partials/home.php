<?php
    if (!isset($communications[0]['visto'])) {
        if (count($communications) > 0 && isset($communications[0]['model']) && !empty($communications[0]['model']) && !empty($communications[0]['text'])) {
            $content = str_replace('[nome]', $communications[0]['nome'], $communications[0]['text']);
            $content = str_replace('[meta]', $communications[0]['meta'], $content);
            $content = str_replace('[pontos]', $communications[0]['points'], $content);
            $content = str_replace('[pontosProjecao]', $communications[0]['projecao'], $content);
            $content = str_replace('[pontosTotal]', number_format($_SESSION['user']['total'], 0, ',', '.'), $content);
            $content = str_replace('[campanha]', $config['nomeCamp'], $content);
            $content = str_replace('[email]', $config['emailCamp'], $content);
            $content = str_replace('[mes]', $meses_comu[$communications[0]['periodo']], $content);
            $content = str_replace('[produto]', $communications[0]['produto'], $content);
            $content = str_replace('[valor_produto]', number_format($communications[0]['valor_produto'], 0, ',', '.'), $content);
            $content = str_replace('[codigo_produto]', $communications[0]['codigo_produto'], $content);
            $content = str_replace('[info_01]', $communications[0]['info_01'], $content);
            $cdata = isset($communications[0]['periodo']) ? $communications[0]['periodo'] : 0;

            echo "<div class='comunicados-home wrap-comunicados'>";
                echo "<div class='comu-home-head'>";
                    echo "<span class='close' onclick='fechar_notif()'>&#10005;</span>";
                echo "</div>";
                echo "<div class='comunicados'>";
                    echo "<p class='data_comunicado'>" . $cdata . "</p>";
                    echo $content;
                echo "</div>";
            echo "</div>";
            echo "<div class='filtro_preto'></div>";

            $query = "UPDATE communications SET visto = 1 WHERE periodo = '$cdata' AND cpf = $cpf";
            $result = $db->query($query);
        }
    }
    /*
    echo "<pre>";
    echo print_r($communications);
    echo "</pre>";
    */
?>

<section class="wrapper home_box">
    <div class="quadro-home" id="pontos">
        <a class="home-box" href="<?php echo '//' . $config['baseUrl'] ?>/pontos">
            <div class="filtro"></div>
            <p><span class="home-box-title">Pontos</span></p>
        </a>
    </div>
    <?php if ($_SESSION['user']['public'] != 'televendas') : ?>
        <div class="quadro-home" id="viagem">
            <a class="home-box" href="<?php echo '//' . $config['baseUrl'] ?>/viagem">
                <div class="filtro"></div>
                <p><span class="home-box-title">Viagem</span></p>
            </a>
        </div>
    <?php endif ?>
    <div class="quadro-home" id="premios">
        <a class="home-box" href="<?php echo '//' . $config['baseUrl'] ?>/catalogo">
            <div class="filtro"></div>
            <p><span class="home-box-title">Prêmios</span></p>
        </a>
    </div>
    <div class="quadro-home" id="regulamento">
        <a class="home-box" href="<?php echo '//' . $config['baseUrl'] ?>/regulamento">
            <div class="filtro"></div>
            <p><span class="home-box-title">Regulamento</span></p>
        </a>
    </div>
    <div class="quadro-home" id="dados">
        <a class="home-box" href="<?php echo '//' . $config['baseUrl'] ?>/cadastro">
            <div class="filtro"></div>
            <p><span class="home-box-title">Seus dados</span></p>
        </a>
    </div>
    <div class="quadro-home" id="comunicados">
        <a class="home-box" href="<?php echo '//' . $config['baseUrl'] ?>/comunicados">
            <div class="filtro"></div>
            <p><span class="home-box-title">Comunicados</span></p>
        </a>
    </div>
    <?php if ($_SESSION['user']['public'] != 'televendas') : ?>
        <div class="quadro-home" id="rank">
            <a class="home-box" href="<?php echo '//' . $config['baseUrl'] ?>/ranking">
                <div class="filtro"></div>
                <p><span class="home-box-title">Ranking</span></p>
            </a>
        </div>
    <?php endif ?>
    <div class="quadro-home" id="pedidos">
        <a class="home-box" href="<?php echo '//' . $config['baseUrl'] ?>/meuspedidos">
            <div class="filtro"></div>
            <p><span class="home-box-title">Pedidos</span></p>
        </a>
    </div>
</section>
<script>
    function fechar_notif() {
        var btn_close = document.querySelector("span.close");
        var comu = document.querySelector("div.comunicados-home");
        var filtro = document.querySelector("div.filtro_preto");
        comu.style.display = 'none';
        filtro.style.display = 'none';
    };
</script>