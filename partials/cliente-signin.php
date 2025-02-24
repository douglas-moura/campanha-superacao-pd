<?php
    include_once __DIR__ . "/../config.php";
    include_once __DIR__ . "/../partials/db.php";
    include_once __DIR__ . "/../partials/head.php";
    include_once __DIR__ . "/../partials/header-internal-cliente.php";

    $db = new Db($config);
    $participantes = $db->select("SELECT
                                    users.id AS user_id,
                                    users.codigo,
                                    users.email,
                                    users.cpf,
                                    users.name,
                                    users.name_extension,
                                    users.phone,
                                    users.type,
                                    users.viagem,
                                    users_address.id AS address_id,
                                    users_address.postal_code,
                                    users_address.street,
                                    users_address.city,
                                    users_address.region,
                                    users_address.complement,
                                    users_address.district,
                                    users_address.number,
                                    users_address.reference
                                        FROM `users` LEFT JOIN `users_address` ON users.id = users_address.user_id WHERE users.type <> 'Teste' AND users.type <> 'Inativo' ORDER BY users.name");
    $theraskin = $db->select("SELECT * FROM `goals` WHERE cod = 11122233344");
    $desempenhos = $db->select("SELECT * FROM `goals` WHERE name <> 'Teste'");
    $pedidos = $db->select("SELECT *, order_item.status AS item_status FROM `order_item` LEFT JOIN `order` ON order_item.order_id = order.id"); 
    $pedidosGeral = $db->select("SELECT * FROM `order`");    

    $mesesAcumulados = 12;
    
    $desempenhoCamp = [
        0 => [
            'mes' => 'Janeiro',
            'valor' => $theraskin[0]['realizado_1'],
            'meta' => $theraskin[0]['meta_1'],
            'venda' => $theraskin[0]['venda_1'],
        ],
        1 => [
            'mes' => 'Fevereiro',
            'valor' => $theraskin[0]['realizado_2'],
            'meta' => $theraskin[0]['meta_2'],
            'venda' => $theraskin[0]['venda_2'],
        ],
        2 => [
            'mes' => 'Março',
            'valor' => $theraskin[0]['realizado_3'],
            'meta' => $theraskin[0]['meta_3'],
            'venda' => $theraskin[0]['venda_3'],
        ],
        3 => [
            'mes' => 'Abril',
            'valor' => $theraskin[0]['realizado_4'],
            'meta' => $theraskin[0]['meta_4'],
            'venda' => $theraskin[0]['venda_4'],
        ],
        4 => [
            'mes' => 'Maio',
            'valor' => $theraskin[0]['realizado_5'],
            'meta' => $theraskin[0]['meta_5'],
            'venda' => $theraskin[0]['venda_5'],
        ],
        5 => [
            'mes' => 'Junho',
            'valor' => $theraskin[0]['realizado_6'],
            'meta' => $theraskin[0]['meta_6'],
            'venda' => $theraskin[0]['venda_6'],
        ],
        6 => [
            'mes' => 'Julho',
            'valor' => $theraskin[0]['realizado_7'],
            'meta' => $theraskin[0]['meta_7'],
            'venda' => $theraskin[0]['venda_7'],
        ],
        7 => [
            'mes' => 'Agosto',
            'valor' => $theraskin[0]['realizado_8'],
            'meta' => $theraskin[0]['meta_8'],
            'venda' => $theraskin[0]['venda_8'],
        ],
        8 => [
            'mes' => 'Setembro',
            'valor' => $theraskin[0]['realizado_9'],
            'meta' => $theraskin[0]['meta_9'],
            'venda' => $theraskin[0]['venda_9'],
        ],
        9 => [
            'mes' => 'Outubro',
            'valor' => $theraskin[0]['realizado_10'],
            'meta' => $theraskin[0]['meta_10'],
            'venda' => $theraskin[0]['venda_10'],
        ],
        10 => [
            'mes' => 'Novembro',
            'valor' => $theraskin[0]['realizado_11'],
            'meta' => $theraskin[0]['meta_11'],
            'venda' => $theraskin[0]['venda_11'],
        ],
        11 => [
            'mes' => 'Dezembro',
            'valor' => $theraskin[0]['realizado_12'],
            'meta' => $theraskin[0]['meta_12'],
            'venda' => $theraskin[0]['venda_12'],
        ],
        12 => [
            'mes' => 'Meta Anual',
            'valor' => $theraskin[0]['realizado_13'],
            'meta' => $theraskin[0]['meta_13'],
            'venda' => $theraskin[0]['venda_13'],
        ]
    ];

    function compare_by_percent($a, $b) {
        if(isset($a['percent']) && isset($b['percent'])) {
            if ($a['percent'] == $b['percent']) {
                return 0;
            }
            return ($a['percent'] < $b['percent']) ? 1 : -1;
        }
    }
?>

<style>
    :root {
        --cinza-1: #F9F9F9;
        --cinza-2: #F0F0F0;
        --cinza-3: #CDCDCD;
        --cor-1: #5C1BFA;
        --cor-1-claro: #CBB4FA;
        --cor-1-filtro: #F4EFFF;
        --cor-2: #F1B90E;
        --cor-2-claro: #FFEDB6;
    }

    html {
        scroll-behavior: smooth;
    }

    #grafico-meses>div table tr #grafico-valores ul::-webkit-scrollbar,
    div::-webkit-scrollbar {
        width: .3rem !important;
    }
    
    #grafico-meses>div table tr #grafico-valores ul::-webkit-scrollbar-track,
    div::-webkit-scrollbar-track {
        background: none;
    }

    #grafico-meses>div table tr #grafico-valores ul::-webkit-scrollbar-thumb,
    div::-webkit-scrollbar-thumb {
        background-color: var(--cor-1) !important;
        border-radius: 2rem !important;
    }
    
    div::-webkit-scrollbar-thumb {
        display: none;
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

    .box-vazio {
        background-color: var(--cinza-1);
        padding: 1rem;
        margin: 0;
    }

    .tabela-cliente {
        width: 100%;
        border-collapse: collapse;
        max-height: 60vh;
    }

    .tabela-cliente tr:nth-child(odd) {
        background-color: var(--cinza-2);
    }

    .tabela-cliente tr:nth-child(even) {
        background-color: var(--cinza-1);
    }

    .tabela-cliente .linha-superior {
        background-color: var(--cinza-2) !important;
    }
    
    .tabela-cliente .drop-down {
        background-color: var(--cor-1-filtro) !important;
    }

    .tabela-cliente thead tr {
        background-color: var(--cor-1) !important;
    }

    .tabela-cliente thead tr th {
        color: white;
        padding: 1rem;
    }

    .tabela-cliente,
    .tabela-cliente tr td {
        /*border: .2rem solid red;*/
        padding: .5rem 1rem;
    }

    #pelicula-cliente {
        position: fixed;
        z-index: 99999;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-color: rgb(0 0 0 / 75%);
        /* opacity: .9; */
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }

    #intro ul {
        padding: 0;
        margin: 0;
        list-style-type: none;
        font-size: .8rem;
    }

    #participantes>div {
        height: 65vh;
    }

    #participantes>div div {
        overflow-y: scroll !important;
        width: 70% !important;
    }    

    #participantes>div div:first-of-type table tbody .linha-superior {
        border-top: .1rem solid var(--cinza-3);
    }
    
    #participantes>div div:first-of-type table thead tr th:nth-child(1) {
        width: calc(35% / 1) !important;
    }

    #participantes>div div:first-of-type table thead tr th:nth-child(2),
    #participantes>div div:first-of-type table thead tr th:nth-child(3),
    #participantes>div div:first-of-type table thead tr th:nth-child(4) {
        width: calc(60% / 3) !important;
        padding-left: 0rem;
    }

    #participantes>div div:first-of-type table thead tr th:nth-child(5) {
        width: 5% !important;
    }

    #participantes>div div:first-of-type table .drop-down {
        display: none;
        min-height: 50rem;
        vertical-align: top;
        transition: .2s;
    }

    #participantes>div div:first-of-type table .drop-down:not(.drop-down-infos) {
        border-top: .1rem solid var(--cinza-3);
    }

    #participantes>div div:first-of-type table .drop-down-infos {
        border-bottom: .2rem solid var(--cor-1);
    }

    #participantes>div div:first-of-type table .drop-down td {
        padding: 2rem;
        width: 40% !important;
    }

    #participantes>div div:first-of-type table .drop-down td>span {
        display: flex;
    }

    #participantes>div div:first-of-type table .drop-down td .drop-down-resultados{
        margin-bottom: 1rem;
    }

    #participantes>div div:first-of-type table .drop-down td .drop-down-resultados ul li {
        border-bottom: 1px solid var(--cinza-3) !important;
    }

    #participantes>div div:first-of-type table .drop-down td>span ul {
        width: 50% !important;
    }

    #participantes>div div:first-of-type table .drop-down td h5,
    #participantes>div div:first-of-type table .drop-down td h6 {
        align-items: center;
        display: flex;
        color: var(--cor-1);
    }

    #participantes>div div:first-of-type table .drop-down td h5 svg,
    #participantes>div div:first-of-type table .drop-down td h6 svg {
        margin-right: .5rem;
        transition: .2s;
        color: var(--cor-1);
    }

    #participantes>div div:first-of-type table tr td {
        cursor: pointer;
    }

    #participantes>div div:first-of-type table tr td ul {
        margin: 0;
        padding: 0;
    }

    #participantes>div div:first-of-type table tr td ul li {
        padding: .5rem 0;
        margin: 0;
        list-style-type: none;
    }

    #participantes>div div:last-of-type {
        width: 28% !important;
        height: 65vh;
        background-color: var(--cinza-2);
        padding: 1.5rem;
    }

    #participantes>div div:last-of-type table {
        width: 100%;
    }

    #participantes>div div:last-of-type table tr th {
        font-size: 1.2rem;
        font-weight: 600;
        padding-bottom: 1rem;
        border-bottom: .1rem solid var(--cor-1);
        text-align: center;
        color: var(--cor-1);
    }

    #participantes>div div:last-of-type table tr td {
        width: 75%;
        padding: .5rem 0;
    }

    #participantes>div div:last-of-type table tr td:last-of-type {
        text-align: right;
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

    #pedidos>div>div:last-of-type table tbody tr:hover {
        background-color: #cdcdcd;
    }

    #pedidos>div>div:last-of-type table tbody tr td img {
        width: 13rem;
        position: absolute;
        margin-left: -14rem;
        margin-top: -6rem;
        padding: 1rem;
        background-color: white;
        display: none;
        border-radius: .5rem;
        box-shadow: 1px 1px 15px var(--cinza-3);
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
        width: calc(70% / 13) !important;
    }

    #grafico-meses>div table #barras td {
        font-size: .8rem !important;
        padding: 0;
        vertical-align: bottom;
        text-align: center;
        /*border: .2rem solid red;*/
    }
    
    #grafico-meses>div table #barras td:last-of-type {
        width: calc(30% / 1) !important;
    }

    #grafico-meses>div table #barras #eixo-y ul {
        height: 40vh;
        padding: 0;
        margin: 0;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        list-style-type: none;
    }

    #grafico-meses>div table #barras #eixo-y ul li {
        z-index: 9999;
        background-color: var(--cinza-2);
    }

    #grafico-meses>div table #barras #eixo-y .grade-grafico {
        border-top: .1rem solid var(--cinza-3);
        width: 1300%;
        margin: 0;
        margin-top: -2vh;
    }
    
    #grafico-meses>div table #barras #eixo-y #linha-100 {
        border-top: .2rem solid var(--cor-1);
    }

    #grafico-meses>div table #barras td div {
        background: linear-gradient(var(--cor-1), var(--cor-2));
        width: .5rem;
        margin: auto;
        margin-top: 0;
        z-index: 9999;
        position: relative;
    }

    #grafico-meses>div table #barras td span {
        font-weight: 700;
        margin: 1rem 0 !important;
        font-size: .8rem !important;
        z-index: 9999;
        position: relative;
    }

    #grafico-meses>div table #eixo-x {
        height: 5vh;
        background-color: var(--cinza-2) !important;
    }

    #grafico-meses>div table #eixo-x td {
        font-size: .6rem !important;
        text-align: center;
        padding: 0;
    }

    #grafico-meses>div table tr #grafico-valores ul {
        max-height: 45vh;
        overflow-y: scroll !important;
        list-style-type: none;
        text-align: left;
        padding: 2rem;
        border-radius: .5rem;
        margin: 1.5rem;
        background-color: white;
    }

    #grafico-meses>div table tr #grafico-valores ul h5 {
        font-weight: 700;
        color: var(--cor-1);
    }

    #grafico-meses>div table tr #grafico-valores ul li {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        font-size: .8rem !important;
    }

    #grafico-meses>div table tr #grafico-valores ul li p {
        margin: 0 1rem;
    }

    #grafico-meses>div table tr #grafico-valores ul li h6 {
        font-weight: 500;
        width: 100%;
        padding: .5rem 0;
        border-top: .1rem solid var(--cinza-3);
    }

    #viagem>div div:first-of-type {
        width: 65%;
    }

    #viagem>div .viajante {
        background-color: var(--cor-2) !important;
        font-weight: 700;
    }
    
    #viagem>div .viajante-2 {
        background-color: var(--cor-2-claro) !important;
        font-weight: 700;
    }

    #viagem>div div:first-of-type table thead th:nth-child(1) {
        width: 15% !important;
    }

    #viagem>div div:first-of-type table thead th:nth-child(4) {
        width: 20% !important;
    }

    #viagem>div div:first-of-type table thead th:nth-child(2),
    #viagem>div div:first-of-type table thead th:nth-child(3) {
        width: 30% !important;
    }

    #viagem>div div:first-of-type table tbody .viajante:nth-child(odd) {
        border-top: 0 !important;
    }

    #viagem>div div:last-of-type {
        width: 33%;
        box-sizing: border-box;
        padding: 2rem;
        background: var(--cinza-1);
    }

    #viagem>div div:last-of-type hr {
        border-top: .1rem solid var(--cinza-3);
        margin: 2rem 0;
    }

    #viagem>div div:last-of-type #barra-progresso {
        position: relative;
        width: 100%;
        margin: 1rem 0;
        height: .25rem;
        padding: 0;
        overflow: hidden;
    }

    #viagem>div div:last-of-type #barra-progresso div:first-of-type {
        position: absolute;
        height: .5rem;
        background: var(--cor-1);
        z-index: 100;
        border-radius: 0 !important;
    }

    #viagem>div div:last-of-type #barra-progresso div:last-of-type {
        position: absolute;
        width: 100%;
        height: .5rem;
        background: var(--cor-1-claro);
        border-radius: 0 !important;
    }
</style>

<div id="pelicula-cliente"></div>

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
                                <th>Vendas</th>
                                <th>Desemp. Acumulado</th>
                                <th>Maxx Pontos</th>
                                <th>Prêmios Solicitados</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $publico_001 = [];
                                $publico_002 = null;
                                $publico_003 = null;
                                $publico_004 = null;
                                $publico_005 = null;

                                $qtd_pontosLiberados = 0;

                                for($i = 0; $i < count($participantes); $i++) {
                                    if(isset($participantes[$i]['type'])) {
                                        $participantes[$i]['venda_total'] = 0;
                                        $participantes[$i]['pontos_total'] = 0;
                                        $participantes[$i]['qtd_pedidos'] = 0;
                                        $participantes[$i]['percent'] = 0;

                                        $meta_acum = 0;
                                        $venda_acum = 0;
                                        $pontos_acum = 0;
                                                                                
                                        for($d = 0; $d < count($desempenhos); $d++) {
                                            if($participantes[$i]['cpf'] == $desempenhos[$d]['cod']) {
                                                
                                                for($v = 1; $v <= 13; $v++) {
                                                    $participantes[$i]['venda_total'] += $desempenhos[$d]['venda_' . $v];
                                                    $participantes[$i]['pontos_total'] += $v < 13 ? $desempenhos[$d]['points_e1_' . $v] : 0;
                                                    
                                                    $participantes[$i]['metas'][$v] = $desempenhos[$d]['meta_' . $v];
                                                    $participantes[$i]['vendas'][$v] = $desempenhos[$d]['venda_' . $v];
                                                    $participantes[$i]['realizado'][$v] = $desempenhos[$d]['realizado_' . $v] * 100;
                                                                                                        
                                                    $participantes[$i]['pontos'][$v] = $v < 13 && isset($desempenhos[$d]['points_e1_' . $v]) ? $desempenhos[$d]['points_e1_' . $v] : 0;
                                                }

                                                for($m = 1; $m <= $mesesAcumulados; $m++) {
                                                    $meta_acum += $participantes[$i]['metas'][$m];
                                                    $venda_acum += $participantes[$i]['vendas'][$m];
                                                    $pontos_acum += $participantes[$i]['pontos'][$m];
                                                }

                                                $participantes[$i]['percent'] = isset($venda_acum) && $venda_acum > 0 ? (($venda_acum / $meta_acum) * 100) : 0;
                                            }
                                        }


                                        if(!isset($participantes[$i]['pontos'])) {
                                            $participantes[$i]['pontos'] = [];
                                        }

                                        for($p = 0; $p < count($pedidos); $p++) {
                                            if($pedidos[$p]['user_cod'] == $participantes[$i]['cpf']) {
                                                $participantes[$i]['qtd_pedidos'] += 1;
                                            }
                                        }
    
                                        echo '<tr class="linha-superior" id="linha-' . $i . '" onclick="abrirDrop(' . $i . ')">';
                                            echo '<td>' . $participantes[$i]['name'] . ' ' . $participantes[$i]['name_extension'] . '</td>';
                                            //echo '<td>' . substr($participantes[$i]['cpf'], 0, 3) . '.' . substr($participantes[$i]['cpf'], 3, 3) . '.' . substr($participantes[$i]['cpf'], 6, 3) . '-' . substr($participantes[$i]['cpf'], 9, 2) . '</td>';
                                            echo '<td>' . 'R$ ' . number_format($participantes[$i]['venda_total'], 2, ",", ".") . '</td>';
                                            echo '<td>' . number_format($participantes[$i]['percent'], 2, ",", ".") . '%</td>';
                                            echo '<td>' . number_format($participantes[$i]['pontos_total'], 0, ",", ".") . '</td>';
                                            echo '<td>' . $participantes[$i]['qtd_pedidos'] . '</td>';
                                            echo '<td><svg class="seta" id="seta-' . $i . '" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></td>';
                                        echo '</tr>';
                                        echo '<tr class="drop-down drop-down-dados" id="linha-drop-A-' . $i . '">';
                                            echo '<td colspan="6">
                                                <h4>Dados do Participante</h4>
                                                <br><br>
                                                <span style="width: 100% !important;">
                                                    <ul>
                                                        <h6>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                                            Informações Pessoais
                                                        </h6>
                                                        <br>
                                                        <li><strong>Matricula</strong><br> ' . $participantes[$i]['codigo'] . '</li>
                                                        <li><strong>E-mail</strong><br> ' . $participantes[$i]['email'] . '</li>
                                                        <li><strong>Público</strong><br> ' . $participantes[$i]['type'] . '</li>
                                                        <li><strong>Telefone</strong><br> ' . $participantes[$i]['phone'] . '</li>
                                                    </ul>
                                                    <ul>
                                                        <h6>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                                            Endereço Residencial
                                                        </h6>
                                                        <br>';
                                                        if(
                                                            isset($participantes[$i]['street']) &&
                                                            isset($participantes[$i]['postal_code']) &&
                                                            isset($participantes[$i]['city']) &&
                                                            isset($participantes[$i]['region'])
                                                        ) {
                                                            echo '
                                                                <li><strong>Endereço</strong><br> ' . $participantes[$i]['street'] . ', ' . $participantes[$i]['number'] . ' - ' . $participantes[$i]['district'] . '</li>
                                                                <li><strong>Complemento</strong><br> ' . $participantes[$i]['complement'] . '</li>
                                                                <li><strong>CEP</strong><br> ' . $participantes[$i]['postal_code'] . '</li>
                                                                <li><strong>Cidade</strong><br> ' . $participantes[$i]['city'] . ' - ' . $participantes[$i]['region'] . '</li>';
                                                        } else {
                                                            echo '<li><strong>Endereço não cadastrado</strong></li>';
                                                        }
                                                    echo '
                                                    </ul>
                                                </span>
                                            </td>
                                        </tr>';
                                        echo '<tr class="drop-down drop-down-infos" id="linha-drop-B-' . $i . '">
                                            <td colspan="6">
                                                <h4>Resultados Mensais</h4>
                                                <br><br>
                                                <span class="drop-down-resultados">
                                                    <ul>
                                                        <h6>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                                            Mês
                                                        </h6>
                                                        <br>';
                                                        for($v = 1; $v <= 12; $v++) {
                                                            echo '<li style="list-style-type:none;padding:.5rem 0;"><strong>' . $desempenhoCamp[$v - 1]['mes'] . "</strong>";
                                                        }
                                                        echo '<li style="list-style-type:none;padding:.75rem 0;color: var(--cor-1) !important;"><strong>Acumulado</strong></li>'
                                                    . '</ul>';
                                                echo '<ul>
                                                        <h6>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                                            Vendas
                                                        </h6>
                                                        <br>';
                                                        for($v = 1; $v <= 12; $v++) {
                                                            if(isset($participantes[$i]['vendas'])) {
                                                                echo '<li style="list-style-type:none;padding:.5rem 0;">R$ ' . number_format($participantes[$i]['vendas'][$v], 2, ",", ".") . '</li>';
                                                            } else {
                                                                echo '<li style="list-style-type:none;padding:.5rem 0;">R$ ' . number_format(0, 2, ",", ".") . '</li>';
                                                            }
                                                        }
                                                        echo '<li style="list-style-type:none;padding:.75rem 0;color: var(--cor-1) !important;"><strong>R$ ' . number_format($venda_acum, 2, ",", ".") . '</strong></li>'
                                                    . '</ul>';
                                                echo '<ul>
                                                        <h6>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg>
                                                            Metas
                                                        </h6>
                                                        <br>';
                                                        for($v = 1; $v <= 12; $v++) {
                                                            if(isset($participantes[$i]['vendas'])) {
                                                                echo '<li style="list-style-type:none;padding:.5rem 0;">R$ ' . number_format($participantes[$i]['metas'][$v], 2, ",", ".") . '</li>';
                                                            } else {
                                                                echo '<li style="list-style-type:none;padding:.5rem 0;">R$ ' . number_format(0, 2, ",", ".") . '</li>';
                                                            }
                                                        }
                                                        echo '<li style="list-style-type:none;padding:.75rem 0;color: var(--cor-1) !important;"><strong>R$ ' . number_format($meta_acum, 2, ",", ".") . '</strong></li>'
                                                    . '</ul>';
                                                echo '<ul>
                                                        <h6>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-percent"><line x1="19" y1="5" x2="5" y2="19"></line><circle cx="6.5" cy="6.5" r="2.5"></circle><circle cx="17.5" cy="17.5" r="2.5"></circle></svg>
                                                            Realizado
                                                        </h6>
                                                        <br>';
                                                        for($v = 1; $v <= 12; $v++) {
                                                            if(isset($participantes[$i]['vendas'])) {
                                                                echo '<li style="list-style-type:none;padding:.5rem 0;">' . number_format($participantes[$i]['realizado'][$v] / 100, 2, ",", ".") . '%</li>';
                                                            } else {
                                                                echo '<li style="list-style-type:none;padding:.5rem 0;">' . number_format(0, 2, ",", ".") . '%</li>';
                                                            }
                                                        }
                                                        echo '<li style="list-style-type:none;padding:.75rem 0;color: var(--cor-1) !important;"><strong>' . number_format($participantes[$i]['percent'], 2, ",", ".") . '%</strong></li>'
                                                    . '</ul>';
                                                echo '<ul>
                                                        <h6>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                            Maxx Pontos
                                                        </h6>
                                                        <br>';
                                                        for($v = 1; $v <= 12; $v++) {
                                                            if(isset($participantes[$i]['vendas'])) {
                                                                echo '<li style="list-style-type:none;padding:.5rem 0;">' . number_format($participantes[$i]['pontos'][$v], 0, ",", ".") . '</li>';
                                                            } else {
                                                                echo '<li style="list-style-type:none;padding:.5rem 0;">' . number_format(0, 0, ",", ".") . '</li>';
                                                            }
                                                        }
                                                        echo '<li style="list-style-type:none;padding:.75rem 0;color: var(--cor-1) !important;"><strong>' . number_format($pontos_acum, 0, ",", ".") . '</strong></li>'
                                                    . '</ul>
                                                </span>
                                            </td>';
                                        echo '</tr>';
                                    }

                                    if($participantes[$i]['viagem'] == 1) {
                                        switch($participantes[$i]['type']) {
                                            case 'Gerente de Contas':
                                                $publico_001[] = $participantes[$i];
                                                break;
    
                                            case 'Gerente de Produto':
                                                $publico_002[] = $participantes[$i];
                                                break;
    
                                            case 'Consultor de Trade Marketing':
                                                $publico_003[] = $participantes[$i];
                                                break;
    
                                            case 'Coordenador Trade':
                                            case 'Coordenador Tecnico Cientifico Digital':
                                            case 'Gerente Distrital':
                                                $publico_004[] = $participantes[$i];
                                                break;
    
                                            case 'Representante Propagandista':
                                            case 'Representante Digital':
                                                $publico_005[] = $participantes[$i];
                                                break;
                                        }
                                    }

                                    $qtd_pontosLiberados += isset($participantes[$i]['pontos'][1]) ? $participantes[$i]['pontos'][1] : 0;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div>
                    <?php 
                        $publicosGeral = [];
                        $qtd_pontosGeral = 0;
                        $qtd_pontosTrocados = 0;

                        for($p = 0; $p < count($participantes); $p++) {
                            if(isset($participantes[$p]['type']) && $participantes[$p]['type'] != null) {
                                $publicosGeral[$p] = $participantes[$p]['type'];
                            }
                        }

                        for($d = 0; $d < count($desempenhos); $d++) {
                            for($v = 1; $v <= 12; $v++) {
                                $qtd_pontosGeral += $desempenhos[$d]['points_e1_' . $v];
                            }
                        }

                        for($p = 0; $p < count($pedidos); $p++) {
                            for($i = 0; $i < count($participantes); $i++) {
                                if($participantes[$i]['cpf'] == $pedidos[$p]['user_cod']) {
                                    $pedidos[$p]['usuario'] = $participantes[$i];
                                }
                            }

                            if(isset($pedidos[$p]['usuario'])) {
                                //$qtd_pontosTrocados += $pedidos[$p]['total'];
                            }
                        }

                        for($p = 0; $p < count($pedidosGeral); $p++) {
                            $qtd_pontosTrocados += $pedidosGeral[$p]['total'];
                        }
                            
                        $publicosQtd = array_count_values($publicosGeral);
                    ?>
                    <table>
                        <tr>
                            <th colspan="2">Maxx Pontos</th>
                        </tr>
                        <tr>
                            <td>Maxx Pontos Distribuidos</td>
                            <td><?php echo number_format($qtd_pontosGeral, 0, ",", "."); ?></td>
                        </tr>
                        <tr>
                            <td>Maxx Pontos Liberados</td>
                            <td><?php echo number_format($qtd_pontosLiberados, 0, ",", "."); ?></td>
                        </tr>
                        <tr>
                            <td>Maxx Pontos Trocados</td>
                            <td><?php echo number_format($qtd_pontosTrocados, 0, ",", "."); ?></td>
                        </tr>
                        <tr>
                            <td>Maxx Pontos Não Trocados</td>
                            <td><?php echo number_format($qtd_pontosGeral - $qtd_pontosTrocados, 0, ",", "."); ?></td>
                        </tr>
                    </table>

                    <br><br>

                    <table>
                        <tr>
                            <th colspan="2">Participantes</th>
                        </tr>
                        <tr>
                            <td>Total de Participantes</td>
                            <td><?php echo count($publicosGeral); ?></td>
                        </tr>
                        <tr>
                            <td>Consultor de Trade Marketing</td>
                            <td><?php echo isset($publicosQtd['Consultor de Trade Marketing']) ? $publicosQtd['Consultor de Trade Marketing'] : 0; ?></td>
                        </tr>
                        <tr>
                            <td>Coordenador Trade</td>
                            <td><?php echo isset($publicosQtd['Coordenador Trade']) ? $publicosQtd['Coordenador Trade'] : 0; ?></td>
                        </tr>
                        <tr>
                            <td>Coordenador Técnico Digital</td>
                            <td><?php echo isset($publicosQtd['Coordenador Tecnico Cientifico Digital']) ? $publicosQtd['Coordenador Tecnico Cientifico Digital'] : 0; ?></td>
                        </tr>
                        <tr>
                            <td>Gerente Distritais</td>
                            <td><?php echo isset($publicosQtd['Gerente Distrital']) ? $publicosQtd['Gerente Distrital'] : 0; ?></td>
                        </tr>
                        <tr>
                            <td>Gerente de Contas</td>
                            <td><?php echo isset($publicosQtd['Gerente de Contas']) ? $publicosQtd['Gerente de Contas'] : 0; ?></td>
                        </tr>
                        <tr>
                            <td>Gerente de Produto</td>
                            <td><?php echo isset($publicosQtd['Gerente de Produto']) ? $publicosQtd['Gerente de Produto'] : 0; ?></td>
                        </tr>
                        <tr>
                            <td>Representante Propagandista</td>
                            <td><?php echo isset($publicosQtd['Representante Propagandista']) ? $publicosQtd['Representante Propagandista'] : 0; ?></td>
                        </tr>
                        <tr>
                            <td>Representante Digital</td>
                            <td><?php echo isset($publicosQtd['Representante Digital']) ? $publicosQtd['Representante Digital'] : 0; ?></td>
                        </tr>
                        <tr>
                            <td>Televendas</td>
                            <td><?php echo isset($publicosQtd['Televendas']) ? $publicosQtd['Televendas'] : 0; ?></td>
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
                    <?php if(count($pedidos) > 0) { ?>
                        <table class="tabela-cliente">
                            <thead>
                                <tr>
                                    <th>Pedido</th>
                                    <th>Data Pedido</th>
                                    <th>Item</th>
                                    <th>CPF</th>
                                    <th>Participante</th>
                                    <th>Status</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                        for($p = 0; $p < count($pedidos); $p++) {        
                                            if(isset($pedidos[$p]['usuario'])) {
                                                echo '<tr class="linha-pedido-' . $p . '" onmouseenter="mostrarImgProd(' . $p . ')" onmouseleave="mostrarImgProd(' . $p . ')">';
                                                    echo '<td>#' . $pedidos[$p]['id'] . '</td>';
                                                    echo '<td>' . date('d.m.Y', strtotime($pedidos[$p]['data'])) . '</td>';
                                                    echo '<td><img src="../img/p/' . $pedidos[$p]['cod'] . '.jpg" class="img-pedido-' . $p . '">' . $pedidos[$p]['title'] . '</td>';
                                                    echo '<td>' . substr($pedidos[$p]['usuario']['cpf'], 0, 3) . '.' . substr($pedidos[$p]['usuario']['cpf'], 3, 3) . '.' . substr($pedidos[$p]['usuario']['cpf'], 6, 3) . '-' . substr($pedidos[$p]['usuario']['cpf'], 9, 2) . '</td>';
                                                    echo '<td>' . $pedidos[$p]['usuario']['name'] . ' ' . $pedidos[$p]['usuario']['name_extension'] . '</td>';
                                                    //echo '<td>' . number_format($pedidos[$p]['subtotal'], 0, ",", ".") . '</td>';
                                                    //echo '<td>' . number_format($pedidos[$p]['frete'], 0, ",", ".") . '</td>';
                                                    echo '<td>' . $pedidos[$p]['item_status'] . '</td>';
                                                    echo '<td>' . number_format($pedidos[$p]['points'], 0, ",", ".") . '</td>';
                                                echo '</tr>';
                                            }
                                        }
                                ?>
                            </tbody>
                        </table>
                    <?php } else { echo '<p class="box-vazio">Nenhum pedido encontrado...</p>'; } ?>
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
                    <?php
                        $meta_acumulada_thera = 0;
                        $vendas_thera = 0;

                        for($i = 1; $i <= 12; $i++) {
                            $meta_acumulada_thera += ($theraskin[0]['meta_' . $i]);
                            $vendas_thera += ($theraskin[0]['venda_' . $i]);
                        }
                    ?>
                    <thead>
                        <tr>
                            <th colspan="14">Comparativo Mensal Vendas Gerais TheraSkin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="barras">
                            <td id="eixo-y">
                                <ul>
                                    <li>200%</li>
                                    <hr class="grade-grafico">
                                    <li>190%</li>
                                    <hr class="grade-grafico">
                                    <li>180%</li>
                                    <hr class="grade-grafico">
                                    <li>170%</li>
                                    <hr class="grade-grafico">
                                    <li>160%</li>
                                    <hr class="grade-grafico">
                                    <li>150%</li>
                                    <hr class="grade-grafico">
                                    <li>140%</li>
                                    <hr class="grade-grafico">
                                    <li>130%</li>
                                    <hr class="grade-grafico">
                                    <li>120%</li>
                                    <hr class="grade-grafico">
                                    <li>110%</li>
                                    <hr class="grade-grafico">
                                    <li>100%</li>
                                    <hr class="grade-grafico" id="linha-100">
                                    <li>90%</li>
                                    <hr class="grade-grafico">
                                    <li>80%</li>
                                    <hr class="grade-grafico">
                                    <li>70%</li>
                                    <hr class="grade-grafico">
                                    <li>60%</li>
                                    <hr class="grade-grafico">
                                    <li>50%</li>
                                    <hr class="grade-grafico">
                                    <li>40%</li>
                                    <hr class="grade-grafico">
                                    <li>30%</li>
                                    <hr class="grade-grafico">
                                    <li>20%</li>
                                    <hr class="grade-grafico">
                                    <li>10%</li>
                                    <hr class="grade-grafico">
                                    <li>0%</li>
                                </ul>
                            </td>
                            <?php
                                for($m = 0; $m < count($desempenhoCamp) - 1; $m++) {
                                    $proporcao = $desempenhoCamp[$m]['valor'] / 200;
                                    echo '<td><span>' . $desempenhoCamp[$m]['valor'] . '%</span><div style="height: ' . 40 * $proporcao . 'vh;"></div></td>';
                                }
                            ?>
                            <td id="grafico-valores" rowspan="2">
                                <ul>
                                    <h5>Resultados Mensais</h5>
                                    <br>
                                    <li><h6><strong>ACUMULADO</strong> - outubro 2024</h6></li>
                                    <li><p><strong>Meta</strong></p><p><?php echo 'R$ ' . number_format($meta_acumulada_thera, 2, ",", "."); ?></p></li>
                                    <li><p><strong>Venda</strong></p><p><?php echo 'R$ ' . number_format($vendas_thera, 2, ",", "."); ?></p></li>
                                    <li><p><strong>Realizado</strong></p><p><?php echo number_format(($vendas_thera / $meta_acumulada_thera) * 100 , 2, ",", ".") . "%"; ?></p></li>
                                    <br><br>
                                    <?php
                                        for($m = 0; $m < count($desempenhoCamp); $m++) {
                                            echo '<li><h6>' . $desempenhoCamp[$m]['mes'] . ' de 2024</h6></li>';
                                            echo $desempenhoCamp[$m]['meta'] > 0 ? '<li><p><strong>Meta</strong></p> <p>R$ ' . number_format($desempenhoCamp[$m]['meta'], 2, ",", ".") . '</p></li>' : null;
                                            echo $desempenhoCamp[$m]['venda'] > 0 ? '<li><p><strong>Venda</strong></p> <p>R$ ' . number_format($desempenhoCamp[$m]['venda'], 2, ",", ".") . '</p></li>' : null;
                                            echo $desempenhoCamp[$m]['valor'] > 0 ? '<li><p><strong>Realizado</strong></p> <p>' . number_format($desempenhoCamp[$m]['valor'], 2, ",", ".") . '%</p></li>' : null;
                                            echo '<br>';
                                        }
                                    ?>
                                </ul>
                            </td>
                        </tr>
                        <tr id="eixo-x">
                            <td></td>
                            <?php
                                for($m = 0; $m < count($desempenhoCamp) - 1; $m++) {
                                    echo '<td>' . substr($desempenhoCamp[$m]['mes'], 0, 3) . '<br>2024</td>';
                                }
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="bloco-assunto" id="viagem">
            <h4>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
                Viagem dos Campeões
            </h4>
            <div>
                <div>
                    <table class="tabela-cliente">
                        <thead>
                            <tr>
                                <th>Grupo 001</th>
                                <th>Participante</th>
                                <th>Público</th>
                                <th>Desemp. Acumulado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                isset($publico_001) ? usort($publico_001, 'compare_by_percent') : [];
                                for($i = 0; $i < count($publico_001); $i++) {
                                    echo $i < 1 ? ($publico_001[$i]['percent'] > 100 ? '<tr class="viajante">' : '<tr class="viajante-2">') : '<tr>';
                                        echo '<td>#' . $i + 1 . '</td>';
                                        echo isset($publico_001[$i]['name']) ? '<td>' . $publico_001[$i]['name'] . ' ' . $publico_001[$i]['name_extension'] . '</td>' : '<td></td>';
                                        echo isset($publico_001[$i]['type']) ? '<td>' . $publico_001[$i]['type'] . '</td>' : '<td></td>';
                                        echo isset($publico_001[$i]['metas'][13]) > 0 ? '<td>' . number_format($publico_001[$i]['percent'], 2, ",", ".") . '%</td>' : '<td></td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                    <br><br>
                    <table class="tabela-cliente">
                        <thead>
                            <tr>
                                <th>Grupo 002</th>
                                <th>Participante</th>
                                <th>Público</th>
                                <th>Desemp. Acumulado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                isset($publico_002) ? usort($publico_002, 'compare_by_percent') : [];
                                for($i = 0; $i < count($publico_002); $i++) {
                                    echo $i < 1 ? ($publico_002[$i]['percent'] > 100 ? '<tr class="viajante">' : '<tr class="viajante-2">') : '<tr>';
                                        echo '<td>#' . $i + 1 . '</td>';
                                        echo isset($publico_002[$i]['name']) ? '<td>' . $publico_002[$i]['name'] . ' ' . $publico_002[$i]['name_extension'] . '</td>' : '<td></td>';
                                        echo isset($publico_002[$i]['type']) ? '<td>' . $publico_002[$i]['type'] . '</td>' : '<td></td>';
                                        echo isset($publico_002[$i]['metas'][13]) > 0 ? '<td>' . number_format($publico_002[$i]['percent'], 2, ",", ".") . '%</td>' : '<td></td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                    <br><br>
                    <table class="tabela-cliente">
                        <thead>
                            <tr>
                                <th>Grupo 003</th>
                                <th>Participante</th>
                                <th>Público</th>
                                <th>Desemp. Acumulado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                isset($publico_003) ? usort($publico_003, 'compare_by_percent') : [];
                                for($i = 0; $i < count($publico_003); $i++) {
                                    echo $i < 1 ? ($publico_003[$i]['percent'] > 100 ? '<tr class="viajante">' : '<tr class="viajante-2">') : '<tr>';
                                        echo '<td>#' . $i + 1 . '</td>';
                                        echo isset($publico_003[$i]['name']) ? '<td>' . $publico_003[$i]['name'] . ' ' . $publico_003[$i]['name_extension'] . '</td>' : '<td></td>';
                                        echo isset($publico_003[$i]['type']) ? '<td>' . $publico_003[$i]['type'] . '</td>' : '<td></td>';
                                        echo isset($publico_003[$i]['metas'][13]) > 0 ? '<td>' . number_format($publico_003[$i]['percent'], 2, ",", ".") . '%</td>' : '<td></td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                    <br><br>
                    <table class="tabela-cliente">
                        <thead>
                            <tr>
                                <th>Grupo 004</th>
                                <th>Participante</th>
                                <th>Público</th>
                                <th>Desemp. Acumulado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                isset($publico_004) ? usort($publico_004, 'compare_by_percent') : [];
                                for($i = 0; $i < count($publico_004); $i++) {
                                    echo $i < 2 ? ($publico_004[$i]['percent'] > 100 ? '<tr class="viajante">' : '<tr class="viajante-2">') : '<tr>';
                                        echo '<td>#' . $i + 1 . '</td>';
                                        echo isset($publico_004[$i]['name']) ? '<td>' . $publico_004[$i]['name'] . ' ' . $publico_004[$i]['name_extension'] . '</td>' : '<td></td>';
                                        echo isset($publico_004[$i]['type']) ? '<td>' . $publico_004[$i]['type'] . '</td>' : '<td></td>';
                                        echo isset($publico_004[$i]['metas'][13]) > 0 ? '<td>' . number_format($publico_004[$i]['percent'], 2, ",", ".") . '%</td>' : '<td></td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                    <br><br>
                    <table class="tabela-cliente">
                        <thead>
                            <tr>
                                <th>Grupo 005</th>
                                <th>Participante</th>
                                <th>Público</th>
                                <th>Desemp. Acumulado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                isset($publico_005) ? usort($publico_005, 'compare_by_percent') : [];
                                for($i = 0; $i < count($publico_005); $i++) {
                                    echo $i < 6 ? ($publico_005[$i]['percent'] > 100 ? '<tr class="viajante">' : '<tr class="viajante-2">') : '<tr>';
                                        echo '<td>#' . $i + 1 . '</td>';
                                        echo isset($publico_005[$i]['name']) ? '<td>' . $publico_005[$i]['name'] . ' ' . $publico_005[$i]['name_extension'] . '</td>' : '<td></td>';
                                        echo isset($publico_005[$i]['type']) ? '<td>' . $publico_005[$i]['type'] . '</td>' : '<td></td>';
                                        echo isset($publico_005[$i]['metas'][13]) > 0 ? '<td>' . number_format($publico_005[$i]['percent'], 2, ",", ".") . '%</td>' : '<td></td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div>
                    <h6 style="margin-bottom:.5rem !important;">Objetivo TheraSkin</h6>
                    <h3><strong><?php echo 'R$ ' . number_format($theraskin[0]['meta_13'], 2, ",", "."); ?></strong></h3>
                    <div id="barra-progresso">
                        <div style="width: <?php echo ($vendas_thera / $theraskin[0]['meta_13']) * 100; ?>% !important;"></div>
                        <div></div>
                    </div>
                    <h5><strong><?php echo 'R$ ' . number_format($vendas_thera, 2, ",", "."); ?></strong></h5>
                    <hr>
                    <h6>Legenda:</h6>
                    <br>
                    <span style="display:flex;">
                        <div style="width:.5rem;height:.5rem;border-radius:50%!important;padding:.5rem;margin-right:.5rem;box-shadow:0 0 1px gray;" class="viajante"></div>
                        <p>Participante viajante</p>
                    </span>
                    <span style="display:flex;">
                        <div style="width:.5rem;height:.5rem;border-radius:50%!important;padding:.5rem;margin-right:.5rem;box-shadow:0 0 1px gray;" class="viajante-2"></div>
                        <p>Participante com chance de viajar se superar a meta</p>
                    </span>
                    <br>
                    <p>Se a campanha terminasse hoje, estes seriam os participantes que viajariam com a Diretoria da TheraSkin na Viagem dos Campeões para Cancún, no México.</p>
                    <p>Serão elegíveis para a viagem, somente novos colaboradores que forem admitidos até o mês de abril/24.</p>
                    <hr>
                    <h6>Públicos:</h6>
                    <br>
                    <p><strong>Grupo 001 - 1 vaga</strong><br>Gerente de Contas</p>
                    <p><strong>Grupo 002 - 1 vaga</strong><br>Gerente de Produto</p>
                    <p><strong>Grupo 003 - 1 vaga</strong><br>Consultor de Trade Marketing</p>
                    <p><strong>Grupo 004 - 2 vagas</strong><br>Coordenador Trade, Coordenador Técnico Digital, ou Gerente Distrital</p>
                    <p><strong>Grupo 005 - 6 vagas</strong><br>Representante Propagandista ou Representante Digital</p>
                    <br>
                    <p><strong>Total - 11 vagas</strong></p>
                </div>
            </div>
        </div>
            <?php
            /*
                echo "<pre>";
                echo print_r($participantes);
                echo "</pre>";
                */
            ?>
    </div>
</section>