<?php
    $db = new Db($config);
    
    $filtro = 0;
    $filtro_emp = 0;

    $pontos_ = $db -> select("SELECT * FROM `points` INNER JOIN `produtos` ON points.cod_produto = produtos.cod_produto INNER JOIN `fabricantes` ON produtos.cod_fabricante = fabricantes.cod_fabricante WHERE points.cod_user = '" . $_SESSION['user']['cpf'] . "'"); /* SELECÃO GERAL */
    for ($id = 0; $id < count($pontos_); $id++) {
        $pontos_[$id]['mes'] = substr($pontos_[$id]['data'], 5, -3);
    }
?>
    <div class="wrap-tables pts">        
        <h2>Extrato de pontos</h2><br>
        <?php
            if (count($pontos_) > 0) {
                
                /*
                echo "<pre>";
                echo print_r($pontos_);
                echo "</pre>";
                */

                $meses_camp = [
                    '0' => '05Mai/23',
                    '1' => '06Jun/23',
                    '2' => '07Jul/23',
                    '3' => '08Ago/23',
                    '4' => '09Set/23',
                    '5' => '10Out/23',
                    '6' => '11Nov/23',
                    '7' => '12Dez/23',
                    '8' => '01Jan/24',
                    '9' => '02Fev/24',
                    '10' => '03Mar/24',
                    '11' => '04Abr/24'
                ];
        ?>                
                    <table class="table table-pontos">
                        
                        <thead>
                            <tr class="cabecalho_table">
                                <th>Mês</th>
                                <th>Qtd. Vendas</th>
                                <th>Pontos</th>
                                <th>Bônus 1</th>
                                <th>Bônus 2</th>
                                <th>Total</th>
                                <th style="width: 2% !important; padding: 0 !important;"></th>
                            </tr>
                        </thead>
                        
                        <tbody>

                            <?php
                                $meses_vendas = [];
                                $pts_base = 0;
                                $totalPontos_base = 0;
                                $totalPontos_bonus = 0;

                                for ($id = 0; $id < count($pontos_); $id++) {
                                    array_push($meses_vendas, $pontos_[$id]['mes']);
                                    $totalPontos_base = $totalPontos_base + $pontos_[$id]['pontos_base'];
                                    $totalPontos_bonus = $totalPontos_bonus + $pontos_[$id]['bonus_1'] + $pontos_[$id]['bonus_2'];
                                }

                                $totalPontos = $totalPontos_base + $totalPontos_bonus;
                                
                                for ($cont = 0; $cont < count($meses_camp); $cont++) {

                                    $mes_campanha = substr($meses_camp[$cont], 0, -6);
                                    
                                    // Soma de Quantidades
                                    if (in_array($mes_campanha, $meses_vendas)) {
                                        $meses_qtd = array_count_values($meses_vendas);
                                        $qtd = $meses_qtd[$mes_campanha];
                                    } else {
                                        $qtd = "-";
                                    }

                                    // Soma de Pontos 
                                    $pts_base = 0;
                                    $pts_bonus1 = 0;
                                    $pts_bonus2 = 0;
                                    $pts_total = 0;

                                    for ($index = 0; $index < count($pontos_); $index++) {
                                        if ($pontos_[$index]['mes'] == $mes_campanha) {
                                            $pts_base += $pontos_[$index]['pontos_base'];
                                            $pts_bonus1 += $pontos_[$index]['bonus_1'];
                                            $pts_bonus2 += $pontos_[$index]['bonus_2'];
                                        }
                                    }
                                    
                                    $pts_total += $pts_base + $pts_bonus1 + $pts_bonus2;
                                    
                                    echo '
                                        <tr class="row-'. $cont . '">
                                            <td colspan="7">
                                                <div class="accordions">
                                                    <div>
                                                        <label for="accordion-' . $cont . '">
                                                            <li>' . substr($meses_camp[$cont], 2) . '</li>
                                                            <li>' . $qtd . '</li>
                                                            <li>' . ($pts_base != 0 ? number_format($pts_base, 0, ' ', '.') : '-') . '</li>
                                                            <li>' . ($pts_bonus1 != 0 ? number_format($pts_bonus1, 0, ' ', '.') : '-') . '</li>
                                                            <li>' . ($pts_bonus2 != 0 ? number_format($pts_bonus2, 0, ' ', '.') : '-') . '</li>
                                                            <li>' . ($pts_total != 0 ? number_format($pts_total, 0, ' ', '.') : '-') . '</li>
                                                            <svg class="seta_' . $cont . '" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                                        </label>
                                                        <input class="accordion-item" onclick="abrirAcordeao(id)" type="radio" name="accordion" id="accordion-' . $cont . '" />
                                                        <div class="accordion-content">
                                                            <div class="conteudo_pontos">
                                    ';
                                                                for ($index = 0; $index < count($pontos_); $index++) {
                                                                    if ($pontos_[$index]['mes'] == $mes_campanha) {                                                           
                                    echo '
                                                                        <div class="prod-linha">
                                                                            <li class="head_tab">Data</li>
                                                                            <li class="head_tab">Produto</li>
                                                                            <li class="head_tab">Fabricante</li>
                                                                            <li class="head_tab">Pontos</li>
                                                                        </div>
                                    ';
                                                                        for ($index = 0; $index < count($pontos_); $index++) {
                                                                            if ($pontos_[$index]['mes'] == $mes_campanha) {  
                                                                                $date = new DateTimeImmutable($pontos_[$index]['data']);
                                    echo '
                                                                                <div class="prod-linha">
                                                                                    <li>' . $date->format('d/m/Y') . '</li>
                                                                                    <li>' . $pontos_[$index]['produto'] . '</li>
                                                                                    <li>' . $pontos_[$index]['fabricante'] . '</li>
                                                                                    <li>' . number_format($pontos_[$index]['pontos_base'] + $pontos_[$index]['bonus_1'] + $pontos_[$index]['bonus_2'], 0, ',', '.') . '</li>
                                                                                </div>
                                    ';
                                                                            }
                                                                        }
                                                                    } 
                                                                }
                                    echo '
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    ';
                                }

                                /*
                                echo "<pre>";
                                print_r($totalPontos);
                                echo "</pre>";
                                */ 
                            ?>      
                        </tbody>
                        
                        <tfoot>
                            <tr class="rodape_tab">
                                <td class="" colspan="5"> Total Geral </td>                                
                                <td class="" colspan="2"><?php echo $totalPontos ? number_format($totalPontos, 0, ',', '.') : '-'; ?> pontos</td>
                            </tr>
                        </tfoot>                        
                    </table>
        <?php               
            } else {
                echo "<p> Não encontrado </p>";
            }            
        ?>
    </div>
    
</div>
