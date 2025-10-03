<?php
    require_once __DIR__ . "/../functions/buscar_pontos.php";
    require_once __DIR__ . "/../functions/buscar_metas.php";
    require_once __DIR__ . "/../functions/buscar_vendas.php";
    require_once __DIR__ . "/../functions/formato_percentual.php";
    require_once __DIR__ . "/../functions/formato_reais.php";
    
    /** @var array $equipe */
    $db = new Db($config);
    $equipe = $db->select("SELECT g.* from `users` as g where g.boss = '" . $_SESSION['user']['codigo'] . "'");
    if (!$equipe || !is_array($equipe)) {
        $equipe = [];
    } else {
        usort($equipe, function($a, $b) {
            return $a['codigo'] <=> $b['codigo'];
        });
    }
    
    $mesesAcumulados = 4;
?>

<div class="wrapper wrap-tables wrap-equipes">
    <div class="col-md-3" style="width: 100%;">
        <h2>MINHA EQUIPE</h2>
        <table style="width: 100%; margin-top: 1rem;">
            <thead>
                <tr class="linha-titulo">
                    <th style="width: 10%;">Código</th>
                    <th style="width: 30%;">Nome</th>
                    <th style="width: 15%;">Meta Anual</th>
                    <th style="width: 15%;">Vendas Anuais</th>
                    <th style="width: 15%;">Desemp. Anual</th>
                    <th style="width: 15%;">Cargo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    for ($i = 0; $i < count($equipe); $i++) {
                        $participante_equipe = $equipe[$i];
                        $participante_equipe['pontos'] = buscar_pontos($db, $participante_equipe['cpf']);
                        $participante_equipe['metas'] = buscar_metas($db, $participante_equipe['cpf']);
                        $participante_equipe['vendas'] = buscar_vendas($db, $participante_equipe['cpf']);
                        if ($participante_equipe['metas']['meta_anual'] > 0 && $participante_equipe['vendas']['venda_anual'] > 0) {
                            $participante_equipe['desemp_anual'] = ($participante_equipe['vendas']['venda_anual'] / $participante_equipe['metas']['meta_anual']) * 100;
                        } else {
                            $participante_equipe['desemp_anual'] = 0;
                        };

                        echo '<tr class="' . ( $_SESSION['user']['type'] == "gerente" ? "linha-supervisor" : "linha-representante" ) . '">';
                            echo '<td>' . $participante_equipe['codigo'] . '</td>';
                            echo '<td>' . ucwords(strtolower($participante_equipe['name'])) . " " . ucwords(strtolower($participante_equipe['name_extension'])) . '</td>';
                            echo '<td>' . formato_reais($participante_equipe['metas']['meta_anual']) . '</td>';
                            echo '<td>' . formato_reais($participante_equipe['vendas']['venda_anual']) . '</td>';
                            echo '<td>' . formato_percentual($participante_equipe['desemp_anual']) . '</td>';
                            echo '<td>' . ucwords(strtolower($participante_equipe['type'])) . '</td>';
                        echo '</tr>';

                        // TABELA DE REPRESENTANTES
                        if ($_SESSION['user']['type'] == 'gerente') {
                            // Buscar representantes da equipe
                            $equipe_rep = $db->select("SELECT g.* from `users` as g where g.boss = '" . $participante_equipe['codigo'] . "'");
                            
                            // Checa o array e ordenar representantes por código
                            if (!$equipe_rep || !is_array($equipe_rep)) {
                                $equipe_rep = [];
                            } else {
                                usort($equipe_rep, function($a, $b) {
                                    return $a['codigo'] <=> $b['codigo'];
                                });
                            }

                            // Loop para cada representante
                            for ($j = 0; $j < count($equipe_rep); $j++) {
                                $participante_rep = $equipe_rep[$j];
                                $participante_rep['pontos'] = buscar_pontos($db, $participante_rep['cpf']);
                                $participante_rep['metas'] = buscar_metas($db, $participante_rep['cpf']);
                                $participante_rep['vendas'] = buscar_vendas($db, $participante_rep['cpf']);
                                if ($participante_rep['metas']['meta_anual'] > 0 && $participante_rep['vendas']['venda_anual'] > 0) {
                                    $participante_rep['desemp_anual'] = ($participante_rep['vendas']['venda_anual'] / $participante_equipe['metas']['meta_anual']) * 100;
                                } else {
                                    $participante_rep['desemp_anual'] = 0;
                                };
                                
                                echo '<tr>';
                                    echo '<td>' . $participante_rep['codigo'] . '</td>';
                                    echo '<td>' . ucwords(strtolower($participante_rep['name'])) . " " . ucwords(strtolower($participante_rep['name_extension'])) . '</td>';
                                    echo '<td>' . formato_reais($participante_rep['metas']['meta_anual']) . '</td>';
                                    echo '<td>' . formato_reais($participante_rep['vendas']['venda_anual']) . '</td>';
                                    echo '<td>' . formato_percentual($participante_rep['desemp_anual']) . '</td>';
                                    echo '<td>' . ucwords(strtolower($participante_rep['type'])) . '</td>';
                                echo '</tr>';
                            }
                        }
                        /*;
                        echo '<pre>';
                        echo print_r($participante_equipe);
                        echo '</pre>';
                        */
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>