<?php
    if (!isset($communications[0]['visto'])) {
        
        if (count($communications) > 0 && isset($communications[0]['model']) && !empty($communications[0]['model']) && !empty($communications[0]['text'])) {
            echo "<pre>";
            echo "chegou";
            echo "</pre>";
            
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
            $content = str_replace('[info_02]', $communications[0]['info_02'], $content);
            $content = str_replace('[info_03]', $communications[0]['info_03'], $content);
            $content = str_replace('[info_04]', $communications[0]['info_04'], $content);
            $content = str_replace('[info_05]', $communications[0]['info_05'], $content);
            $content = str_replace('[info_06]', $communications[0]['info_06'], $content);
            $content = str_replace('[info_07]', $communications[0]['info_07'], $content);
            $content = str_replace('[info_08]', $communications[0]['info_08'], $content);
            $content = str_replace('[info_09]', $communications[0]['info_09'], $content);
            $content = str_replace('[info_10]', $communications[0]['info_10'], $content);
            $content = str_replace('[info_11]', $communications[0]['info_11'], $content);
            $content = str_replace('[info_12]', $communications[0]['info_12'], $content);
            $content = str_replace('[info_13]', $communications[0]['info_13'], $content);
            $content = str_replace('[info_14]', $communications[0]['info_14'], $content);
            $content = str_replace('[info_15]', $communications[0]['info_15'], $content);
            $content = str_replace('[info_16]', $communications[0]['info_16'], $content);
            $content = str_replace('[info_17]', $communications[0]['info_17'], $content);
            $content = str_replace('[info_18]', $communications[0]['info_18'], $content);
            $content = str_replace('[info_19]', $communications[0]['info_19'], $content);
            $content = str_replace('[info_20]', $communications[0]['info_20'], $content);
            $content = str_replace('[info_21]', $communications[0]['info_21'], $content);
            $content = str_replace('[info_22]', $communications[0]['info_22'], $content);
            $content = str_replace('[info_23]', $communications[0]['info_23'], $content);
            $content = str_replace('[info_24]', $communications[0]['info_24'], $content);
            $content = str_replace('[info_25]', $communications[0]['info_25'], $content);
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