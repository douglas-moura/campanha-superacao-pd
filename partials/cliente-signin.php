<script>/*
    let cod_acesso = prompt("Código de Acesso:");
    if(cod_acesso == 1234) {
        alert("Acesso liberado");
    } else {
        let cod_acesso = prompt("Código Incorreto:");
    }*/
</script>

<?php
    include_once __DIR__ . "/../config.php";
    include_once __DIR__ . "/../partials/db.php";
    include_once __DIR__ . "/../partials/head.php";
    include_once __DIR__ . "/../partials/header-internal-cliente.php";

    $db = new Db($config);
    $participantes = $db->select("SELECT * FROM `users`");
    $desempenhos = $db->select("SELECT * FROM `goals`");
    $pedidos = $db->select("SELECT * FROM `order_item` LEFT JOIN `order` ON order_item.order_id = order.id");
?>

<style>
    div::-webkit-scrollbar {
        width: .3rem !important;
    }
    
    div::-webkit-scrollbar-track {
        background: none;
    }

    div::-webkit-scrollbar-thumb {
        display: none;
        background-color: black !important;
        border-radius: 2rem !important;
    }

    div:first-of-type:hover ::-webkit-scrollbar-thumb {
        display: block;
    }

    .bloco-assunto {
        padding: 1rem;
        /*border: .2rem solid black;*/
        margin-top: 2rem;
    }

    .bloco-assunto h4 {
        display: flex;
        align-items: center;
    }

    .bloco-assunto h4 svg {
        margin-right: .5rem;
    }

    .bloco-assunto>div {
        width: 100%;
        margin-top: 1rem;
        display: flex;
        justify-content: space-between;
    }
    
    .bloco-assunto>div>div {
        font-size: .8rem;
    }

    .tabela-cliente {
        width: 100%;
        border-collapse: collapse;
        max-height: 80vh;
    }

    .tabela-cliente tr:nth-child(odd) {
        background-color: #f0f0f0;
    }
    
    .tabela-cliente tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .tabela-cliente thead tr {
        background-color: #d0d0d0 !important;
    }

    .tabela-cliente thead tr th {
        padding: 1rem;
    }

    .tabela-cliente,
    .tabela-cliente tr td {
        /*border: .2rem solid red;*/
        padding: .5rem 1rem;
    }

    #intro ul {
        padding: 0;
        margin: 0;
        list-style-type: none;
        font-size: .8rem;
    }

    #participantes>div {
        height: 50vh;
    }

    #participantes>div div:first-of-type {
        overflow-y: scroll !important;
        width: 70% !important;
    }

    #participantes>div div:last-of-type {
        width: 28% !important;
        height: 50vh;
        background-color: #f0f0f0;
    }

    #participantes>div div:last-of-type table {
        width: 100%;
    }

    #participantes>div div:first-of-type table thead tr th:nth-child(1) {
        width: calc(30% / 1) !important;
    }

    #participantes>div div:first-of-type table thead tr th:nth-child(2),
    #participantes>div div:first-of-type table thead tr th:nth-child(3),
    #participantes>div div:first-of-type table thead tr th:nth-child(4),
    #participantes>div div:first-of-type table thead tr th:nth-child(5) {
        width: calc(70% / 4) !important;
    }

    #participantes>div div:last-of-type table tr:first-of-type td {
        font-size: 1.2rem;
        font-weight: 600;
        padding: 1rem .75rem 2rem !important;
    }

    #participantes>div div:last-of-type table tr td {
        width: 75%;
        padding: 0 .75rem 1.5rem;
    }

    #participantes>div div:last-of-type table tr td:last-of-type {
        text-align: center;
    }

    #pedidos>div>div {
        max-height: 40vh;
        overflow-y: scroll !important;
    }

    #pedidos>div>div:first-of-type {
        width: 19%;
    }

    #pedidos>div>div:last-of-type {
        width: 100%;
    }

    #pedidos>div>div:last-of-type table {
        width: 100%;
        font-size: .8rem;
        border-collapse: collapse;
    }

    #pedidos>div>div:last-of-type table thead tr th:nth-child(1) {
        width: 5% !important;
    }

    #pedidos>div>div:last-of-type table thead tr th:nth-child(4),
    #pedidos>div>div:last-of-type table thead tr th:nth-child(2) {
        width: calc(30% / 2) !important;
    }

    #pedidos>div>div:last-of-type table thead tr th:nth-child(6),
    #pedidos>div>div:last-of-type table thead tr th:nth-child(7),
    #pedidos>div>div:last-of-type table thead tr th:nth-child(8)  {
        width: calc(25% / 3) !important;
    }

    #pedidos>div>div:last-of-type table thead tr th:nth-child(3),
    #pedidos>div>div:last-of-type table thead tr th:nth-child(5)  {
        width: calc(40% / 2) !important;
    }

    #grafico-meses>div {
        width: 100%;
    }
    
    #grafico-meses>div table #barras {
        height: 40vh;
    }

    #grafico-meses>div table thead tr th {
        text-align: center !important;
    }

    #grafico-meses>div table tr td {
        width: calc(70% / 13);
    }

    #grafico-meses>div table #barras td {
        font-size: .8rem !important;
        padding: 1rem 0;
        vertical-align: bottom;
        text-align: center;
    }
    
    #grafico-meses>div table #barras td:last-of-type {
        width: calc(30% / 1);
    }

    #grafico-meses>div table #barras td:first-of-type ul {
        height: 40vh;
        padding: 0 2rem;
        margin: 0;
        text-align: right;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        list-style-type: none;
    }

    #grafico-meses>div table #barras td div {
        background: linear-gradient(#000000, #858585);
        width: .5rem;
        margin: auto;
        margin-top: .5rem;
    }

    #grafico-meses>div table #barras td span {
        margin: 1rem 0 !important;
        font-size: .6rem !important;
    }

    #grafico-meses>div table #eixo-x {
        height: 5vh;
    }

    #grafico-meses>div table #eixo-x td {
        font-size: .6rem !important;
        text-align: center;
        padding: 0;
    }
</style>

<section class="wrapper">
    <div>
        <h2>Painel Cliente</h2>
        <div class="bloco-assunto" id="intro">
            <ul>
                <li><strong>Cliente:</strong> Theraskin Farmaceutica Ltda</li>
                <li><strong>Campanha:</strong> <?php echo $config['nomeCamp']; ?></li>
                <li><strong>Suporte:</strong> <?php echo $config['emailCamp']; ?></li>
                <li><strong>Data:</strong> <?php date_default_timezone_set('America/Sao_Paulo'); echo date('d.m.Y | H:i', time()); ; ?></li>
            </ul>
        </div>
        <div class="bloco-assunto" id="participantes">
            <h4>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                Participantes Cadastrados
            </h4>
            <div>
                <div>
                    <table class="tabela-cliente">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                
                                <th>Público</th>


                                <th>Vendas</th>
                                <th>Maxx Pontos</th>
                                <th>Prêmios</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                for($i = 0; $i < count($participantes); $i++) {
                                    if(isset($participantes[$i]['type'])) {
                                        $venda_total = 0;
                                        $pontos_total = 0;
                                        $qtd_pedidos = 0;
                                        
                                        for($d = 0; $d < count($desempenhos); $d++) {
                                            if(isset($desempenhos[$d]) && isset($participantes[$i]) && $desempenhos[$d]['cod'] == $participantes[$i]['cpf']) {
    
                                                for($v = 1; $v <= 12; $v++) {
                                                    $venda_total += $desempenhos[$d]['venda_' . $v];
                                                    $pontos_total += $desempenhos[$d]['points_e1_' . $v];
                                                }
                                            }
                                        }

                                        for($p = 0; $p < count($pedidos); $p++) {
                                            if($pedidos[$p]['user_cod'] == $participantes[$i]['cpf']) {
                                                $qtd_pedidos += 1;
                                            }
                                        }
    
                                        echo '<tr>';
                                            echo '<td>' . $participantes[$i]['name'] . ' ' . $participantes[$i]['name_extension'] . '</td>';
                                            //echo '<td>' . substr($participantes[$i]['cpf'], 0, 3) . '.' . substr($participantes[$i]['cpf'], 3, 3) . '.' . substr($participantes[$i]['cpf'], 6, 3) . '-' . substr($participantes[$i]['cpf'], 9, 2) . '</td>';
                                            echo '<td>' . $participantes[$i]['type'] . '</td>';
                                            /*echo '<td>' . $participantes[$i]['email'] . '</td>';*/
                                            /*echo '<td>' . $participantes[$i]['phone'] . '</td>';*/
                                            echo '<td>' . 'R$ ' . number_format($venda_total, 2, ",", ".") . '</td>';
                                            echo '<td>' . number_format($pontos_total, 0, ",", ".") . '</td>';
                                            echo '<td>' . $qtd_pedidos . '</td>';
                                        echo '</tr>';
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div>
                    <?php 
                        $publicosGeral = [];

                        for($p = 0; $p < count($participantes); $p++) {
                            if(isset($participantes[$p]['type']) && $participantes[$p]['type'] != null) {
                                $publicosGeral[$p] = $participantes[$p]['type'];
                            }
                        }
                            
                        $publicosQtd = array_count_values($publicosGeral);
                    ?>
                    <table>
                        <tr>
                            <td>Total de Participantes</td>
                            <td><?php echo count($publicosGeral); ?></td>
                        </tr>
                        <tr>
                            <td>Consultor de Trade Marketing</td>
                            <td><?php echo $publicosQtd['Consultor de Trade Marketing']; ?></td>
                        </tr>
                        <tr>
                            <td>Coordenador Trade</td>
                            <td><?php echo $publicosQtd['Coordenador Trade']; ?></td>
                        </tr>
                        <tr>
                            <td>Coordenador Tecnico Digital</td>
                            <td><?php echo $publicosQtd['Coordenador Tecnico Cientifico Digital']; ?></td>
                        </tr>
                        <tr>
                            <td>Gerentes Distritais</td>
                            <td><?php echo $publicosQtd['Gerente Distrital']; ?></td>
                        </tr>
                        <tr>
                            <td>Gerente de Contas</td>
                            <td><?php echo $publicosQtd['Gerente de Contas']; ?></td>
                        </tr>
                        <tr>
                            <td>Gerente de Produtos</td>
                            <td><?php echo $publicosQtd['Gerente de Produto']; ?></td>
                        </tr>
                        <tr>
                            <td>Representantes Propagandistas</td>
                            <td><?php echo $publicosQtd['Representante Propagandista']; ?></td>
                        </tr>
                        <tr>
                            <td>Representantes Digital</td>
                            <td><?php echo $publicosQtd['Representante Digital']; ?></td>
                        </tr>
                        <tr>
                            <td>Televendas</td>
                            <td><?php echo $publicosQtd['Televendas']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="bloco-assunto" id="pedidos">
            <h4>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                Prêmios Solicitados
            </h4>
            <div>
                <div>
                    <table class="tabela-cliente">
                        <thead>
                            <tr>
                                <th>Pedido</th>
                                <th>Data Pedido</th>
                                <th>Item</th>
                                <th>CPF</th>  
                                <th>Participante</th>                     
                                <th>Valor</th>
                                <th>Frete</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                for($p = 0; $p < count($pedidos); $p++) {
                                    for($i = 0; $i < count($participantes); $i++) {
                                        if($participantes[$i]['cpf'] == $pedidos[$p]['user_cod']) {
                                            $pedidos[$p]['usuario'] = $participantes[$i];
                                        }
                                    }

                                    echo '<tr>';
                                        echo '<td>#' . $pedidos[$p]['id'] . '</td>';
                                        echo '<td>' . date('d.m.Y', strtotime($pedidos[$p]['data'])) . '</td>';
                                        echo '<td>' . $pedidos[$p]['title'] . '</td>';
                                        echo '<td>' . substr($pedidos[$p]['usuario']['cpf'], 0, 3) . '.' . substr($pedidos[$p]['usuario']['cpf'], 3, 3) . '.' . substr($pedidos[$p]['usuario']['cpf'], 6, 3) . '-' . substr($pedidos[$p]['usuario']['cpf'], 9, 2) . '</td>';
                                        echo '<td>' . $pedidos[$p]['usuario']['name'] . ' ' . $pedidos[$p]['usuario']['name_extension'] . '</td>';
                                        echo '<td>' . number_format($pedidos[$p]['subtotal'], 0, ",", ".") . '</td>';
                                        echo '<td>' . number_format($pedidos[$p]['frete'], 0, ",", ".") . '</td>';
                                        echo '<td>' . number_format($pedidos[$p]['subtotal'] + $pedidos[$p]['frete'], 0, ",", ".") . '</td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="bloco-assunto" id="grafico-meses">
            <h4>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>
                Desempenho TheraSkin
            </h4>
            <div>
                <table class="tabela-cliente">
                    <thead>
                        <tr>
                            <th colspan="14">Comparativo Mensal Vendas Gerais TheraSkin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="barras">
                            <td>
                                <ul>
                                    <li>150%</li>
                                    <li>140%</li>
                                    <li>130%</li>
                                    <li>120%</li>
                                    <li>110%</li>
                                    <li>100%</li>
                                    <li>90%</li>
                                    <li>80%</li>
                                    <li>70%</li>
                                    <li>60%</li>
                                    <li>50%</li>
                                    <li>40%</li>
                                    <li>30%</li>
                                    <li>20%</li>
                                    <li>10%</li>
                                    <li>0%</li>
                                </ul>
                            </td>
                            <?php
                                $desempenhoCamp = [
                                    0 => 100.28,
                                    1 => 125.9,
                                    2 => 144.2,
                                    3 => 134.7,
                                    4 => 99.7,
                                    5 => 129.5,
                                    6 => 0,
                                    7 => 0,
                                    8 => 0,
                                    9 => 0,
                                    10 => 0,
                                    11 => 0,
                                ];

                                for($m = 0; $m < count($desempenhoCamp); $m++) {
                                    $proporcao = $desempenhoCamp[$m] / 150;
                                    echo '<td><span>' . $desempenhoCamp[$m] . '%</span><div style="height: ' . 40 * $proporcao . 'vh;"></div></td>';
                                }
                            ?>
                            <td>
                                Teste
                            </td>
                        </tr>
                        <tr id="eixo-x">
                            <td></td>
                            <td>Jan<br>2024</td>
                            <td>Fev<br>2024</td>
                            <td>Mar<br>2024</td>
                            <td>Abr<br>2024</td>
                            <td>Mai<br>2024</td>
                            <td>Jun<br>2024</td>
                            <td>Jul<br>2024</td>
                            <td>Ago<br>2024</td>
                            <td>Set<br>2024</td>
                            <td>Out<br>2024</td>
                            <td>Nov<br>2024</td>
                            <td>Dez<br>2024</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
    /*
        echo "<pre>";
        echo print_r($pedidos);
        echo "</pre>";
    */
    ?>
</section>