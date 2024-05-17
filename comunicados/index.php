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
    <div class="descr">
        <h2>COMUNICADOS</h2><br>
        <p>Aqui você pode sempre rever as comunicações da campanha!</p>
    </div>
    <div class="comunicados-bloco">
        <?php

        if (count($communications) > 0) {
            for ($i = 0; $i < count($communications); $i++) {
                $content = str_replace('[nome]', $communications[$i]['nome'], $communications[$i]['text']);
                $content = str_replace('[meta]', $communications[$i]['meta'], $content);
                $content = str_replace('[pontos]', $communications[$i]['points'], $content);
                $content = str_replace('[pontosProjecao]', $communications[$i]['projecao'], $content);
                $content = str_replace('[pontosTotal]', number_format($_SESSION['user']['total'], 0, ',', '.'), $content);
                $content = str_replace('[campanha]', $config['nomeCamp'], $content);
                $content = str_replace('[email]', $config['emailCamp'], $content);
                $content = str_replace('[produto]', $communications[$i]['produto'], $content);
                $content = str_replace('[valor_produto]', number_format($communications[$i]['valor_produto'], 0, ',', '.'), $content);
                $content = str_replace('[codigo_produto]', $communications[$i]['codigo_produto'], $content);
                $content = str_replace('[info_01]', $communications[0]['info_01'], $content);
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

<?php
include_once __DIR__ . "/../partials/footer.php";
include_once __DIR__ . "/../partials/foot.php";
?>