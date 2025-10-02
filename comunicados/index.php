<?php
include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/../partials/check.php";
include_once __DIR__ . "/../partials/db.php";
$db = new Db($config);
$cpf = $_SESSION['user']['cpf'];

// $communications = $db -> select("SELECT c.* from `vb_communications` as c where c.cpf = '" . $_SESSION['user']['cpf'] . "'");
$communications = $db->select("SELECT c.*, m.* FROM `communications` as c LEFT JOIN communication_model as m on c.model = m.model WHERE c.cpf = '$cpf' order by c.id desc LIMIT 4");

include_once __DIR__ . "/../partials/head.php";
include_once __DIR__ . "/../partials/header-internal.php";

/*
echo '<pre>';
echo print_r($communications);
echo '</pre>';
*/

?>


<div class="wrapper wrap-comunicados">
    <div class="comunicados-bloco" style="width:100% !important;">
        <h2>COMUNICADOS</h2><br>
        <p>Aqui você pode sempre rever as comunicações da campanha!</p>
        <?php

        if (count($communications) > 0) {
            for ($i = 0; $i < count($communications); $i++) {
                $content = str_replace('[nome]', $_SESSION['user']['name'], $communications[$i]['text']);
                $content = str_replace('[meta]', $communications[$i]['meta'], $content);
                $content = str_replace('[pontos]', $communications[$i]['points'], $content);
                $content = str_replace('[pontosProjecao]', $communications[$i]['projecao'], $content);
                $content = str_replace('[pontosTotal]', number_format($_SESSION['user']['total'], 0, ',', '.'), $content);
                $content = str_replace('[campanha]', $config['nomeCamp'], $content);
                $content = str_replace('[email]', $config['emailCamp'], $content);
                $content = str_replace('[produto]', $communications[$i]['produto'], $content);
                $content = str_replace('[valor_produto]', number_format($communications[$i]['valor_produto'], 0, ',', '.'), $content);
                $content = str_replace('[codigo_produto]', $communications[$i]['codigo_produto'], $content);
                $content = str_replace('[info_01]', $communications[$i]['info_01'], $content);
                $content = str_replace('[info_02]', $communications[$i]['info_02'], $content);
                $content = str_replace('[info_03]', $communications[$i]['info_03'], $content);
                $content = str_replace('[info_04]', $communications[$i]['info_04'], $content);
                $content = str_replace('[info_05]', $communications[$i]['info_05'], $content);
                $content = str_replace('[info_06]', $communications[$i]['info_06'], $content);
                $content = str_replace('[info_07]', $communications[$i]['info_07'], $content);
                $content = str_replace('[info_08]', $communications[$i]['info_08'], $content);
                $content = str_replace('[info_09]', $communications[$i]['info_09'], $content);
                $content = str_replace('[info_10]', $communications[$i]['info_10'], $content);
                $content = str_replace('[info_11]', $communications[$i]['info_11'], $content);
                $content = str_replace('[info_12]', $communications[$i]['info_12'], $content);
                $content = str_replace('[info_13]', $communications[$i]['info_13'], $content);
                $content = str_replace('[info_14]', $communications[$i]['info_14'], $content);
                $content = str_replace('[info_15]', $communications[$i]['info_15'], $content);
                $content = str_replace('[info_16]', $communications[$i]['info_16'], $content);
                $content = str_replace('[info_17]', $communications[$i]['info_17'], $content);
                $content = str_replace('[info_18]', $communications[$i]['info_18'], $content);
                $content = str_replace('[info_19]', $communications[$i]['info_19'], $content);
                $content = str_replace('[info_20]', $communications[$i]['info_20'], $content);
                $content = str_replace('[info_21]', $communications[$i]['info_21'], $content);
                $content = str_replace('[info_22]', $communications[$i]['info_22'], $content);
                $content = str_replace('[info_23]', $communications[$i]['info_23'], $content);
                $content = str_replace('[info_24]', $communications[$i]['info_24'], $content);
                $content = str_replace('[info_25]', $communications[$i]['info_25'], $content);
                $content = str_replace('[mes]', $meses_comu[$communications[$i]['periodo']], $content);

                echo "<div class='comunicados'>";
                    echo "<p class='data_comunicado'>" . $communications[$i]['periodo'] . "</p>";
                    echo $content;
                echo "</div>";
            }
        } else {
            echo "<p class='nao-divulgado'> Não divulgado </p>";
        }
        ?>
    </div>
</div>

<?php if(1 == 0) { ?>
    <br>
    <h2><strong>Bem-vindo(a) à Campanha Maxx Prêmios!</strong></h2>
    <br>
    <p>É com grande entusiasmo que damos as boas-vindas a você, que está acessando a plataforma da campanha Maxx Prêmios pela primeira vez! Estamos muito felizes por tê-lo conosco e queremos ressaltar o quão valioso você é como colaborador.</p>
    <br>
    <p>Na nossa plataforma, você encontrará diversas oportunidades para acumular MaxxPontos e trocar por prêmios incríveis. Sua dedicação e esforço são fundamentais para o sucesso da sua equipe, e estamos aqui para apoiá-lo em cada etapa da sua jornada.</p>
    <br>
    <p>Explore as funcionalidades disponíveis, conheça nossos produtos e participe ativamente das campanhas para maximizar suas conquistas!</p>
    <br>
    <br>
    <h4><strong>Desejamos todo sucesso,<br>CAMPANHA MAXX THERASKIN 2024</strong></h4>

<?php } ?>

<?php
include_once __DIR__ . "/../partials/footer.php";
include_once __DIR__ . "/../partials/foot.php";
?>