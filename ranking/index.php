<?php

use function PHPSTORM_META\type;

include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/../partials/check.php";
include_once __DIR__ . "/../partials/db.php";
$db = new Db($config);

include_once __DIR__ . "/../partials/head.php";
$page = [
    'name' => 'ranking',
    'title' => 'Ranking'
];

include_once __DIR__ . "/../partials/header-internal.php";
?>


<section class="wrapper ranking">
    <div class="col-md-3 ranking-col">
        <h2>RANKING</h2>
        <p class="info">
            Veja quais são os melhores colocados da <strong>Campanha <?php echo $config['nomeCamp']; ?></strong>!<br>
            Acompanhe sempre seu desempenho e conquiste novas posições!
        </p>
        <p class="disclaimer">
            Se a campanha acabasse hoje, estes seriam os participantes que receberiam o convite para participar da comitiva que iria para a Grande Viagem dos Campeões.
        </p>
    </div>

    <div class="col-md-9">
        <?php
        switch ($_SESSION['user']['type']) {
            case 'Consultor de Trade Marketing':
                $grupo = "users.type = 'Consultor de Trade Marketing'";
                $limite = 5;
                break;
            
            case 'Coordenador Tecnico Cientifico Digital':
            case 'Coordenador Trade':
            case 'Gerente Distrital':
                $grupo = "users.type = 'Coordenador Trade' OR users.type = 'Coordenador Tecnico Cientifico Digital' OR users.type = 'Gerente Distrital'";
                $limite = 5;
                break;

            case 'Gerente de Contas':
                $grupo = "users.type = 'Gerente de Contas'";
                $limite = 3;
                break;

            case 'Gerente de Produto':
                $grupo = "users.type = 'Gerente de Produto'";
                $limite = 2;
                break;

            case 'Representante Propagandista':
            case 'Representante Digital':
                $grupo = "users.type = 'Representante Propagandista' OR users.type = 'Representante Digital'";
                $limite = 10;
                break;

            default:
                $public['type'] = '';
                $public['travel'] = false;
                break;
        }

            $participante_pts = $db->select(
                "SELECT
                    ((g.venda_1 + g.venda_2 + g.venda_3 + g.venda_4 + g.venda_5 + g.venda_6 + g.venda_7 + g.venda_8 + g.venda_9 + g.venda_10 + g.venda_11 + g.venda_12) / g.meta_13) as tot_pts,
                    g.cod,
                    users.name,
                    users.name_extension,
                    users.type
                        FROM `goals` as g JOIN `users`
                        WHERE g.cod = users.cpf
                        AND ($grupo)
                        ORDER BY tot_pts DESC"
            );

            $limite = count($participante_pts) < $limite ? count($participante_pts) : $limite;
/*
            echo '<pre>';
            echo print_r($limite);
            echo '</pre>';
*/
            if (count($participante_pts) > 0) {
        ?>
                <table class="ranking-table">
                    <thead>
                        <tr>
                            <th class="rank">Rank</th>
                            <th class="public">Nome</th>
                            <th class="public">Público</th>
                            <th class="percent">Desempenho Anual</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            for ($i = 0; $i < $limite; $i++) {
                                echo "
                                    <tr>
                                        <td class='rank' > " . ($i + 1) . "</td>
                                        <td class='public'>" . $participante_pts[$i]['name'] . " " . $participante_pts[$i]['name_extension'] . "</td>
                                        <td class='public'>" . $participante_pts[$i]['type'] .  "</td>
                                        <td class='percent'>" . number_format($participante_pts[$i]['tot_pts'] * 100, 2) .  "%</td>
                                    </tr>
                                ";
                            };
                        ?>
                    </tbody>
                </table>
        <?php
            } else {
                echo "<p>Não divulgado.</p>";
            }
        ?>
    </div>
</section>

<?php
include_once __DIR__ . "/../partials/footer.php";
include_once __DIR__ . "/../partials/foot.php";
?>