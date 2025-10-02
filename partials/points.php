<?php
    $db = new Db($config);
    $points = $db->select("SELECT g.* from `goals` as g where g.cod = '" . $_SESSION['user']['cpf'] . "'");
    $mesesAcumulados = 4;
?>

<div class="wrapper wrap-tables">
    <?php
    if (
        isset($points[0]) &&
        count($points[0]) > 0 &&
        ((isset($points[0]['label_1']) && !empty($points[0]['label_1'])) ||
        (isset($points[0]['label_2']) && !empty($points[0]['label_2'])) ||
        (isset($points[0]['label_3']) && !empty($points[0]['label_3'])))
    ) {
        $p = $points[0];
    ?>
        <table class="table table-pontos pontos_simples">
            <thead>
                <tr class="cabecalho_table">
                    <th class="coluna-mes">Período</th>
                    <th class="coluna-dinheiro">Metas</th>
                    <th class="coluna-dinheiro">Vendas</th>
                    <th class="coluna-percent">Desempenho</th>
                    <?php if (!$_SESSION['user']['travel']) : ?>
                        <th class="coluna-pontos">Pontuação</th>
                    <?php endif ?>
                </tr>
            </thead>
            <tbody>
            <?php
                $totalPoints = 0;
                $totalTrocados = 0;
                $totalSaldo = 0;
                $totalVendas = 0;

                /*
                echo "<pre>";
                echo print_r($p);
                echo "</pre>";
                */

                for ($i = 1; $i <= 4; $i++) :

                    if ($p['label_' . $i]) :
                        $metas = $p['meta_' . $i];
                        $vendas = $p['venda_' . $i];
                        $totalVendas += $p['venda_' . $i];
                        $desempenhos = $p['realizado_' . $i];
                        $points_base = $p['points_e1_' . $i];       /* pontos base */
                        $points_bonus1 = $p['points_e2_' . $i];     /* desativado */
                        $points_bonus2 = $p['points_e3_' . $i];     /* desativado */
                        $total = ($points_base ? $points_base : 0);

                        $totalPoints = $totalPoints + $total;
                        if ($p['label_' . $i] !== "Retroativos") :
            ?>
                        <tr class="row-<?php echo $i ?>">
                            <td class="col-periodo" colspan="">
                                <?php
                                    echo ucfirst(str_replace('-', '/', $p['label_' . $i]))
                                ?>
                            </td>
                            <td class="col-pts">
                                <?php
                                    echo $metas ? 'R$ ' . number_format($metas, 2, ',', '.') : '-';
                                ?>
                            </td>
                            <td class="col-pts">
                                <?php
                                    echo $vendas ? 'R$ ' . number_format($vendas, 2, ',', '.') : '-';
                                ?>
                            </td>
                            <td class="col-pts"">
                                <?php
                                    echo $desempenhos ? number_format($desempenhos, 2, ',', '.') . '%' : '-';
                                ?>
                            </td>
                            <!--
                            <td class=" col-pts">
                                <?php
                                    echo $points_bonus2 ? number_format($points_bonus2, 0, ',', '.') : '-';
                                ?>
                            </td>
                            -->
                            <?php if (!$_SESSION['user']['travel']) : ?>
                                <td class="col-pts">
                                    <?php
                                        echo $total ? number_format($total, 0, ',', '.') : '-';
                                    ?>
                                </td>
                            <?php endif ?>
                        </tr>
            <?php
                        endif;
                    endif;
                endfor;
                /* Retorativos e Multiplicadores desativados */
                /*
                echo '
                    <tr class="row-14">
                        <td class="col-periodo" colspan="">Retorativos</td>
                        <td class="col-pts"></td>
                        <td class="col-pts"></td>
                        <td class="col-pts""></td>
                        <td class=" col-pts"></td>
                        <td class="col-pts">' . number_format($p['points_e2_2'], 0, ',', '.') . '</td>
                    </tr>
                    <tr class="row-14">
                        <td class="col-periodo" colspan="">Multiplicadores</td>
                        <td class="col-pts"></td>
                        <td class="col-pts"></td>
                        <td class="col-pts""></td>
                        <td class=" col-pts"></td>
                        <td class="col-pts">' . number_format($p['points_e2_3'], 0, ',', '.') . '</td>
                    </tr>
                ';
                */
            ?>
            </tbody>
            <tfoot>
                <?php 
                    if($p['meta_13'] == "0.00") {
                        $p['meta_13'] = 0;
                    }
                ?>
                
                <tr class="rodape_tab">
                    <td colspan=""> Total Acumulado</td>
                    <td>
                        <p>Meta Anual</p>
                        <?php
                        
                            $metaAcumulada = 0;

                            for($m = 1; $m <= $mesesAcumulados; $m++) {
                                $metaAcumulada += $p['meta_' . $m];
                            }

                            echo 'R$ ' . number_format($metaAcumulada, 2, ',', '.');
                            
                        ?>
                    </td>
                    <td>
                        <p>Venda Acumulada</p><?php echo $totalVendas ? 'R$ ' . number_format($totalVendas - $p['venda_13'], 2, ',', '.') : '-'; ?>
                    </td>
                    <td>
                        <p>Desempenho Anual</p>
                        <?php
                            if($metaAcumulada > 0) {
                                echo number_format(($totalVendas / $metaAcumulada) * 100, 2, ',', '.') . '%';
                            } else {
                                echo '-';
                                /* echo '<p>Desempenho Anual</p>' . $totalVendas ? number_format((($totalVendas / $p['meta_13']) * 100), 2, ',', '.') . '%' : '-'; */
                            }

                        ?>
                    </td>
                        <?php if (!$_SESSION['user']['travel']) : ?>
                            <td>
                                <p>Total de Pontos</p><?php echo $totalPoints ? number_format($totalPoints, 0, ',', '.') : '-'; ?>
                            </td>
                        <?php endif ?>
                    </tr>
            </tfoot>
        </table>
    <?php
    } else {
        echo "<p class='nao-divulgado'> Não divulgado </p>";
    }
    ?>
</div>
</div>