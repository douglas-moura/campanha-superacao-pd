<?php
    $db = new Db($config);
    
    $filtro = 0;
    $filtro_emp = 0;

    $pontos_ = $db -> select("SELECT * FROM `points` INNER JOIN `produtos` ON points.cod_produto = produtos.cod_produto INNER JOIN `fabricantes` ON produtos.cod_fabricante = fabricantes.cod_fabricante WHERE points.cod_user = '" . $_SESSION['user']['cpf'] . "'"); /* SELECÃO GERAL */
    $pontosBonus_ = $db -> select("SELECT * FROM `points_bonus` WHERE cod_user = '" . $_SESSION['user']['cpf'] . "'"); /* SELECÃO DE PONTOS DE BÔNUS */

    // INCLUIR COLUNA MÊS NO ARRAY
    for ($id = 0; $id < count($pontos_); $id++) {
        $pontos_[$id]['mes'] = substr($pontos_[$id]['data'], 5, -3);
    }

    // INCLUIR COLUNA MÊS NO ARRAY BÔNUS
    for ($id = 0; $id < count($pontosBonus_); $id++) {
        $pontosBonus_[$id]['mes'] = substr($pontosBonus_[$id]['data'], 5, -3);
    }

?>
    <div class="wrap-tables pts">        
        <h2>Extrato de pontos</h2><br>
        <?php
            if (count($pontos_) > 0) {   

                // MESES DO ANO NA ORDEM DA CAMPANHA 
                $meses_ordemCamp = [
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
                                /*
                                echo "<pre>";
                                echo print_r($pontos_);
                                echo "</pre>";
                                */
                                $num_mesesComVendas = [];
                                $pts_baseMesAtual = 0;
                                $pts_bonusMesAtual_1 = 0;
                                $pts_bonusMesAtual_2 = 0;
                                $totalPontos_base = 0;
                                $totalPontos_bonus = 0;

                                for ($id = 0; $id < count($pontos_); $id++) {
                                    // CRIANDO ARRAY COM MESES ONDE HOUVERAM VENDAS
                                    array_push($num_mesesComVendas, $pontos_[$id]['mes']);

                                    // SOMANDO PONTOS BASE GERAL
                                    $totalPontos_base = $totalPontos_base + $pontos_[$id]['pontos_base'];
                                }
                                
                                for ($id = 0; $id < count($pontosBonus_); $id++) {
                                    // SOMANDO PONTOS BONUS 1 GERAL
                                    $pts_bonusMesAtual_1 = $pts_bonusMesAtual_1 + $pontosBonus_[$id]['bonus_1'];

                                    // SOMANDO PONTOS BONUS 2 GERAL
                                    $pts_bonusMesAtual_2 = $pts_bonusMesAtual_2 + $pontosBonus_[$id]['bonus_2'];
                                }

                                // SOMANDO PONTOS TOTAIS
                                $totalPontos = $totalPontos_base + $pts_bonusMesAtual_1 + $pts_bonusMesAtual_2;
                                
                                // CRIANDO LINHAS DA TABELA COM MESES NA ORDEM DA CAMPANHA
                                for ($cont = 0; $cont < count($meses_ordemCamp); $cont++) {
                                    
                                    // CRIANDO ARRAY COM MESES NA ORDEM DA CAMPANHA
                                    $num_mesAtual = substr($meses_ordemCamp[$cont], 0, -6);

                                    // SOMA DE PONTOS DO MÊS EM QUESTÃO 
                                    $pts_baseMesAtual = 0;
                                    $pts_bonus1MesAtual = 0;
                                    $pts_bonus2MesAtual = 0;
                                    $pts_totalMesAtual = 0;
                                    $qtd = 0;

                                    for ($index = 0; $index < count($pontos_); $index++) {
                                        // SOMANDO PONTOS DO MÊS EM QUESTÃO
                                        if ($pontos_[$index]['mes'] == $num_mesAtual) {
                                            $pts_baseMesAtual += $pontos_[$index]['pontos_base'];
                                            $qtd += $pontos_[$index]['quantidade'];
                                        }
                                    }

                                    for ($index = 0; $index < count($pontosBonus_); $index++) {
                                        if ($pontosBonus_[$index]['mes'] == $num_mesAtual) {
                                            $pts_bonus1MesAtual += $pontosBonus_[$index]['bonus_1'];
                                            $pts_bonus2MesAtual += $pontosBonus_[$index]['bonus_2'];
                                        }
                                    }               
                                    
                                    // SOMANDO PONTOS GERAL DO MÊS EM QUESTÃO
                                    $pts_totalMesAtual += $pts_baseMesAtual + $pts_bonus1MesAtual + $pts_bonus2MesAtual;
                                    
                                    echo '
                                        <tr id="linha" class="row-'. $cont . '">
                                            <td colspan="7">
                                                <div class="accordions">
                                                    <div>
                                                        <label for="accordion-' . $cont . '">
                                                            <li>' . substr($meses_ordemCamp[$cont], 2) . '</li>
                                                            <li>' . $qtd . '</li>
                                                            <li>' . ($pts_baseMesAtual != 0 ? number_format($pts_baseMesAtual, 0, ' ', '.') : '-') . '</li>
                                                            <li>' . ($pts_bonus1MesAtual != 0 ? number_format($pts_bonus1MesAtual, 0, ' ', '.') : '-') . '</li>
                                                            <li>' . ($pts_bonus2MesAtual != 0 ? number_format($pts_bonus2MesAtual, 0, ' ', '.') : '-') . '</li>
                                                            <li>' . ($pts_totalMesAtual != 0 ? number_format($pts_totalMesAtual, 0, ' ', '.') : '-') . '</li>
                                                            <svg class="seta_' . $cont . '" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                                        </label>
                                                        <input class="accordion-item" onclick="abrirAcordeao(id)" type="radio" name="accordion" id="accordion-' . $cont . '" />
                                                        <div class="accordion-content">
                                                            <div class="sub_accordions">
                                                                <div class="conteudo_pontos">
                                                                    ';

                                                                    $linhasProd_mesAtual = [];

                                                                    for ($index = 0; $index < count($pontos_); $index++) {

                                                                        // SE O MES DA VENDA ATUAL FOR IGUAL AO MES ATUAL DO FOR
                                                                        // SEPARA LINHA POR MES                                                                 
                                                                        if ($pontos_[$index]['mes'] == $num_mesAtual) {
                                                                            // CRIA ARRAY COM AS LINHAS DE PRODUTOS DO MES EM QUESTÃO
                                                                            for ($index = 0; $index < count($pontos_); $index++) {
                                                                                if ($pontos_[$index]['mes'] == $num_mesAtual) {
                                                                                    array_push($linhasProd_mesAtual, $pontos_[$index]['fabricante']);
                                                                                }                                                                            
                                                                            }
                                                                            $linhasProd = array_values(array_unique($linhasProd_mesAtual));

                                                                            for ($l = 0; $l < count($linhasProd); $l++) { 
                                                                                // SOMANDO O TOTAL DE PONTOS DE CADA LINHA DE PRODUTOS
                                                                                $totalPontosLinhaProd = 0;
                                                                                for ($k = 0; $k < count($pontos_); $k++) {
                                                                                    if ($pontos_[$k]['fabricante'] == $linhasProd[$l] && $pontos_[$k]['mes'] == $num_mesAtual) {
                                                                                        $totalPontosLinhaProd += $pontos_[$k]['pontos_base'];
                                                                                    }
                                                                                }

                                                                                echo '
                                                                                <div class="accordions_linhaProdutos">
                                                                                    <div class="linhaProdutos">
                                                                                        <label for="acc' . $cont . '_Prod-' . $l . '">
                                                                                            <li>' . $linhasProd[$l] . '</li>
                                                                                            <li>' . number_format($totalPontosLinhaProd, 0, ' ', '.') . ' pontos</li>
                                                                                        </label>
                                                                                        <input class="accordion-item" onclick="abrirAcordeao(id)" type="radio" name="accordion" id="acc' . $cont . '_Prod-' . $l . '" />
                                                                                        <div class="accordion_linhaProd-content">
                                                                                            <div class="prod-linha">
                                                                                                <li class="head_tab col-1">Produto</li>
                                                                                                <li class="head_tab col-2">Quantidade</li>
                                                                                                <li class="head_tab col-2 col-pts">Pontos</li>
                                                                                            </div>
                                                                                            ';

                                                                                            $linhasProdAgrupados = [];

                                                                                            for ($m = 0; $m < count($pontos_); $m++) {                                                                                                
                                                                                                if ($pontos_[$m]['mes'] == $num_mesAtual && $pontos_[$m]['fabricante'] == $linhasProd[$l]) {
                                                                                                    array_push($linhasProdAgrupados, $pontos_[$m]);
                                                                                                    echo '
                                                                                                    <div class="prod-linha">
                                                                                                        <li class="col-1">' . $pontos_[$m]['produto'] . '</li>
                                                                                                        <li class="col-2">' . $pontos_[$m]['quantidade'] . '</li>
                                                                                                        <li class="col-2 col-pts">' . number_format($pontos_[$m]['pontos_base'], 0, ' ', '.') . '</li>
                                                                                                    </div>
                                                                                                    ';
                                                                                                }
                                                                                            }
                                                                                            echo '
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                ';
                                                                            }
                                                                        }
                                                                    }
                                                                    echo '
                                                                </div>
                                                                <div class="conteudo_pontos">
                                                                    <div class="accordions_linhaProdutos">
                                                                        ';
                                                                        for ($b = 0; $b < count($pontosBonus_); $b++) {
                                                                            if ($num_mesAtual == $pontosBonus_[$b]['mes'] && $pontosBonus_[$b]['bonus_1'] > 0) {
                                                                                echo '
                                                                                <div class="linhaProdutos">
                                                                                    <label for="acc' . $cont . '_bon1-' . $l . '">
                                                                                        <li>Bônus 1</li>
                                                                                    </label>
                                                                                    <input class="accordion-item" onclick="abrirAcordeao(id)" type="radio" name="accordion" id="acc' . $cont . '_bon1-' . $l . '" />
                                                                                    <div class="accordion_linhaProd-content">
                                                                                        <div class="prod-linha">
                                                                                            <li class="head_tab col-3">Descrição</li>
                                                                                            <li class="head_tab col-2 col-pts">Pontos</li>
                                                                                        </div>
                                                                                        ';
                                                                                        for ($m = 0; $m < count($pontosBonus_); $m++) {                                                                                                
                                                                                            if ($pontosBonus_[$m]['mes'] == $num_mesAtual && $pontosBonus_[$m]['bonus_2'] == 0) {
                                                                                                echo'
                                                                                                <div class="prod-linha">
                                                                                                    <li class="col-3">' . $pontosBonus_[$m]['descricao'] . '</li>
                                                                                                    <li class="col-2 col-pts">' . number_format($pontosBonus_[$m]['bonus_1'], 0, ' ', '.') . '</li>
                                                                                                </div>
                                                                                                ';
                                                                                            }
                                                                                        }
                                                                                        echo '
                                                                                    </div>
                                                                                </div>
                                                                                ';
                                                                                break;
                                                                            }
                                                                        }
                                                                        echo '
                                                                    </div>
                                                                </div>
                                                                <div class="conteudo_pontos">
                                                                    <div class="accordions_linhaProdutos">
                                                                        ';
                                                                        for ($b = 0; $b < count($pontosBonus_); $b++) {
                                                                            if ($num_mesAtual == $pontosBonus_[$b]['mes'] && $pontosBonus_[$b]['bonus_2'] > 0) {                                                                                
                                                                                echo '
                                                                                <div class="linhaProdutos">
                                                                                    <label for="acc' . $cont . '_bon2-' . $l . '">
                                                                                        <li>Bônus 2</li>
                                                                                    </label>
                                                                                    <input class="accordion-item" onclick="abrirAcordeao(id)" type="radio" name="accordion" id="acc' . $cont . '_bon2-' . $l . '" />
                                                                                    <div class="accordion_linhaProd-content">
                                                                                        <div class="prod-linha">
                                                                                            <li class="head_tab col-3">Descrição</li>
                                                                                            <li class="head_tab col-2 col-pts">Pontos</li>
                                                                                        </div>
                                                                                        ';
                                                                                        for ($m = 0; $m < count($pontosBonus_); $m++) {                                                                                                
                                                                                            if ($pontosBonus_[$m]['mes'] == $num_mesAtual && $pontosBonus_[$m]['bonus_1'] == 0) {
                                                                                                echo'
                                                                                                <div class="prod-linha">
                                                                                                    <li class="col-3">' . $pontosBonus_[$m]['descricao'] . '</li>
                                                                                                    <li class="col-2 col-pts">' . number_format($pontosBonus_[$m]['bonus_2'], 0, ' ', '.') . '</li>
                                                                                                </div>
                                                                                                ';
                                                                                            }
                                                                                        }
                                                                                        echo '
                                                                                    </div>
                                                                                </div>
                                                                                ';
                                                                                break;
                                                                            }
                                                                        }
                                                                        echo '
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    ';
                                }         
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
