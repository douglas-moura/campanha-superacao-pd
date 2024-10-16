<?php
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

            $grupo = null;

            switch ($_SESSION['user']['type']) {
                case 'Consultor de Trade Marketing':
                    $grupo = "users.type = 'Consultor de Trade Marketing'";
                    $limite = 5;
                    break;

                case 'Coordenador Tecnico Cientifico Digital':
                case 'Coordenador Trade':
                case 'Gerente Distrital':
                    $grupo = "users.type = 'Coordenador Trade' OR users.type = 'Coordenador Tecnico Cientifico Digital' OR users.type = 'Gerente Distrital'";
                    $limite = 3;
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
                    $grupo = "users.type = 'Representante Digital' OR users.type = 'Representante Propagandista'";
                    $limite = 10;
                    break;

                default:
                    $public['type'] = '';
                    $public['travel'] = false;
                    break;
            }

            $usuarios = $db->select("SELECT * FROM `goals` LEFT JOIN `users` ON users.cpf = goals.cod WHERE $grupo");
            
            if (count($usuarios) > 0) {
        ?>
                <table class="ranking-table">
                    <thead>
                        <tr>
                            <th class="rank">Rank</th>
                            <th class="public">Nome</th>
                            <th class="public">Público</th>
                            <!--<th class="percent">Desempenho</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                            for ($i = 0; $i < count($usuarios); $i++) {
                                $meta_acumulada = 0;
                                $venda_acumulada = 0;

                                for($m = 1; $m <= 7; $m++) {
                                    $meta_acumulada += floatval($usuarios[$i]['meta_' . $m]);
                                    $venda_acumulada += floatval($usuarios[$i]['venda_' . $m]);
                                }

                                $usuarios[$i]['venda_acum'] = $venda_acumulada;
                                $usuarios[$i]['meta_acum'] = $meta_acumulada;
                                $usuarios[$i]['desempenho_acumulado'] = ($venda_acumulada == 0 && $meta_acumulada == 0) ? 0 : ($venda_acumulada / $meta_acumulada) * 100;
                            };
                            
                            usort($usuarios, function($a, $b) {
                                if ($a['desempenho_acumulado'] > $b['desempenho_acumulado']) {
                                    return -1;
                                } elseif ($a['desempenho_acumulado'] < $b['desempenho_acumulado']) {
                                    return 1;
                                }
                                return 0;
                            });
                            
                            
                            for ($i = 0; $i < $limite; $i++) {
                                echo "
                                    <tr>
                                        <td class='rank'>" . ($i + 1) . "</td>
                                        <td class='public'>" . $usuarios[$i]['name'] . " " . $usuarios[$i]['name_extension'] . "</td>
                                        <td class='public'>" . $usuarios[$i]['type'] . "</td>
                                        <!--<td class='public'>" . number_format($usuarios[$i]['desempenho_acumulado'], 2, ',', ' ') . "%</td>-->
                                    </tr>
                                ";
                            }
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