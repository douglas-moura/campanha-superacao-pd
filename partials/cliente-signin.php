<script>
    auth = sessionStorage.getItem("sessao_iniciada")
    if(auth == 555) {        
    } else {
        let cod_acesso = prompt("Código de Acesso:")
        if(cod_acesso == 1234) {
            alert("Acesso liberado");
            sessionStorage.setItem("sessao_iniciada", 555)
        } else {
            let cod_acesso = alert("Código Incorreto:")
            window.location.reload(true);
        }
    }

    function abrirDrop(id) {
        let linha = document.querySelector("tr#linha-drop-" + id)
        let seta = document.querySelector("svg#seta-" + id)
        let linha_geral = document.getElementsByClassName("drop-down")
        let seta_geral = document.getElementsByClassName("seta")

        if(linha.style.display != "table-row") {
            linha.style.display = "table-row"
            seta.style.transform = "rotate(90deg)"


            for(let i = 0; i < linha_geral.length; i++) {
                if(linha_geral[i].getAttribute("id") != linha.id) {
                    linha_geral[i].style.display = "none"
                    seta_geral[i].style.transform = "rotate(0)"
                }
            }
        } else {
            linha.style.display = "none"
            seta.style.transform = "rotate(0)"
        }
    }

    function mostrarImgProd(id) {
        let img_pedido = document.querySelector("img.img-pedido-" + id)

        if(img_pedido.style.display != "block") {
            img_pedido.style.display = "block"
        } else {
            img_pedido.style.display = "none"
        }
    }
</script>

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
                                    users_address.id AS address_id,
                                    users_address.postal_code,
                                    users_address.street,
                                    users_address.city,
                                    users_address.region,
                                    users_address.complement,
                                    users_address.district,
                                    users_address.number,
                                    users_address.reference
                                        FROM `users` LEFT JOIN `users_address` ON users.id = users_address.user_id WHERE users.type <> 'Teste' ORDER BY users.name");
    $theraskin = $db->select("SELECT * FROM `goals` WHERE cod = 11122233344");
    $desempenhos = $db->select("SELECT * FROM `goals` WHERE name <> 'Teste'");
    $pedidos = $db->select("SELECT * FROM `order_item` LEFT JOIN `order` ON order_item.order_id = order.id");    

    
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
        background-color: black !important;
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
        background-color: #f1f1f1;
        padding: 1rem;
        margin: 0;
    }

    .tabela-cliente {
        width: 100%;
        border-collapse: collapse;
        max-height: 60vh;
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
        height: 65vh;
    }

    #participantes>div div {
        overflow-y: scroll !important;
        width: 70% !important;
    }    

    #participantes>div div:first-of-type table tbody tr:nth-child(odd) {
        border-top: .1rem solid #dddddd;
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
        min-height: 35rem;
        vertical-align: top;
        transition: .2s;
    }

    #participantes>div div:first-of-type table .drop-down td {
        padding: 2rem 1.5rem;
    }

    #participantes>div div:first-of-type table .drop-down td h5 {
        align-items: center;
        display: flex;
    }

    #participantes>div div:first-of-type table .drop-down td h5 svg {
        margin-right: .5rem;
        transition: .2s;
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
        background-color: #f0f0f0;
        padding: 1.5rem;
    }

    #participantes>div div:last-of-type table {
        width: 100%;
    }

    #participantes>div div:last-of-type table tr th {
        font-size: 1.2rem;
        font-weight: 600;
        padding-bottom: 1rem;
        border-bottom: .1rem solid #858585;
        text-align: center;
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

    #pedidos>div>div:last-of-type table tbody tr td img {
        width: 13rem;
        position: absolute;
        margin-left: -14rem;
        margin-top: -6rem;
        padding: 1rem;
        background-color: white;
        display: none;
        border-radius: .5rem;
        box-shadow: 1px 1px 15px #cdcdcd;
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
        padding: 1rem 0;
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

    #grafico-meses>div table #barras #eixo-y .grade-grafico {
        border-top: .1rem solid #cdcdcd;
        width: 1300%;
        margin: 0;
    }

    #grafico-meses>div table #barras td div {
        background: linear-gradient(#000000, #858585);
        width: .5rem;
        margin: auto;
        margin-top: 0;
        z-index: 9999;
        position: relative;
    }

    #grafico-meses>div table #barras td span {
        margin: 1rem 0 !important;
        font-size: .6rem !important;
        z-index: 9999;
        position: relative;
    }

    #grafico-meses>div table #eixo-x {
        height: 5vh;
    }

    #grafico-meses>div table #eixo-x td {
        font-size: .6rem !important;
        text-align: center;
        padding: 0;
    }

    #grafico-meses>div table tr #grafico-valores ul {
        max-height: 40vh;
        overflow-y: scroll !important;
        list-style-type: none;
        text-align: left;
        padding: 0rem 4rem 0rem 3rem;
        margin: 0;
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
        font-weight: 800;
        width: 100%;
        padding: .5rem 0;
        border-top: .1rem solid #cdcdcd;
    }

    #viagem>div div:first-of-type {
        width: 65%;
    }

    #viagem>div .viajante {
        background-color: #5b5b5b !important;
        color: white;
    }

    #viagem>div .viajante td {
        border-top: .025rem solid #777;
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
        background: #f1f1f1;
    }

    #viagem>div div:last-of-type hr {
        border-top: .1rem solid #bdbdbd;
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
        background: black;
        z-index: 100;
        border-radius: 0 !important;
    }

    #viagem>div div:last-of-type #barra-progresso div:last-of-type {
        position: absolute;
        width: 100%;
        height: .5rem;
        background: #cbcbcb;
        border-radius: 0 !important;
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
                                <th>Vendas</th>
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

                                for($i = 0; $i < count($participantes); $i++) {
                                    if(isset($participantes[$i]['type'])) {
                                        $participantes[$i]['venda_total'] = 0;
                                        $participantes[$i]['pontos_total'] = 0;
                                        $participantes[$i]['qtd_pedidos'] = 0;
                                                                                
                                        for($d = 0; $d < count($desempenhos); $d++) {
                                            if($participantes[$i]['cpf'] == $desempenhos[$d]['cod']) {
                                                
                                                for($v = 1; $v <= 13; $v++) {
                                                    $participantes[$i]['venda_total'] += $desempenhos[$d]['venda_' . $v];
                                                    $participantes[$i]['pontos_total'] += $v < 13 ? $desempenhos[$d]['points_e1_' . $v] : 0;
                                                    
                                                    $participantes[$i]['metas'][$v] = $desempenhos[$d]['meta_' . $v];
                                                    $participantes[$i]['vendas'][$v] = $desempenhos[$d]['venda_' . $v];
                                                    $participantes[$i]['realizado'][$v] = $desempenhos[$d]['realizado_' . $v] * 100;
                                                    $participantes[$i]['pontos'][$v] = $v < 13 ? $desempenhos[$d]['points_e1_' . $v] : 0;
                                                }
                                                
                                                $participantes[$i]['percent'] = $participantes[$i]['venda_total'] / $desempenhos[$d]['meta_13'] * 100;
                                            }

                                        }

                                        for($p = 0; $p < count($pedidos); $p++) {
                                            if($pedidos[$p]['user_cod'] == $participantes[$i]['cpf']) {
                                                $participantes[$i]['qtd_pedidos'] += 1;
                                            }
                                        }
    
                                        echo '<tr class="linha-' . $i . '" onclick="abrirDrop(' . $i . ')">';
                                            echo '<td>' . $participantes[$i]['name'] . ' ' . $participantes[$i]['name_extension'] . '</td>';
                                            //echo '<td>' . substr($participantes[$i]['cpf'], 0, 3) . '.' . substr($participantes[$i]['cpf'], 3, 3) . '.' . substr($participantes[$i]['cpf'], 6, 3) . '-' . substr($participantes[$i]['cpf'], 9, 2) . '</td>';
                                            echo '<td>' . 'R$ ' . number_format($participantes[$i]['venda_total'], 2, ",", ".") . '</td>';
                                            echo '<td>' . number_format($participantes[$i]['pontos_total'], 0, ",", ".") . '</td>';
                                            echo '<td>' . $participantes[$i]['qtd_pedidos'] . '</td>';
                                            echo '<td><svg class="seta" id="seta-' . $i . '" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></td>';
                                        echo '</tr>';
                                        echo '<tr class="drop-down" id="linha-drop-' . $i . '">';
                                            echo '<td   >
                                                <h5>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                                    Informações Pessoais
                                                </h5><br>
                                                <ul>
                                                    <li><strong>Matricula</strong><br> ' . $participantes[$i]['codigo'] . '</li>
                                                    <li><strong>E-mail</strong><br> ' . $participantes[$i]['email'] . '</li>
                                                    <li><strong>Público</strong><br> ' . $participantes[$i]['type'] . '</li>
                                                    <li><strong>Telefone</strong><br> ' . $participantes[$i]['phone'] . '</li>
                                                </ul>
                                                <br><br>
                                                <ul>
                                                    <li><strong>Endereço</strong><br> ' . $participantes[$i]['street'] . ', ' . $participantes[$i]['number'] . '</li>
                                                    <li><strong>Complemento</strong><br> ' . $participantes[$i]['complement'] . '</li>
                                                    <li><strong>Referência</strong><br> ' . $participantes[$i]['reference'] . '</li>
                                                    <li><strong>Bairro</strong><br> ' . $participantes[$i]['district'] . '</li>
                                                    <li><strong>CEP</strong><br> ' . $participantes[$i]['postal_code'] . '</li>
                                                    <li><strong>Cidade</strong><br> ' . $participantes[$i]['city'] . ' - ' . $participantes[$i]['region'] . '</li>
                                                </ul>
                                            </td>';
                                            echo '<td>';
                                                echo '<h5>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                                        Vendas
                                                    </h5><br>';
                                                for($v = 1; $v <= 12; $v++) {
                                                    if(isset($participantes[$i]['vendas'])) {
                                                        echo '<li style="list-style-type:none;padding:.5rem 0;"><strong>' . $desempenhoCamp[$v - 1]['mes'] . "</strong><br>" . 'R$ ' . number_format($participantes[$i]['vendas'][$v], 2, ",", ".") . '</li>';
                                                    } else {
                                                        echo '<li style="list-style-type:none;padding:.5rem 0;"><strong>' . $desempenhoCamp[$v - 1]['mes'] . "</strong><br>" . 'R$ ' . number_format(0, 2, ",", ".") . '</li>';
                                                    }
                                                }
                                            echo '</td>';
                                            echo '<td>';
                                                echo '<h5>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-percent"><line x1="19" y1="5" x2="5" y2="19"></line><circle cx="6.5" cy="6.5" r="2.5"></circle><circle cx="17.5" cy="17.5" r="2.5"></circle></svg>
                                                        Realizado
                                                    </h5><br>';
                                                for($v = 1; $v <= 12; $v++) {
                                                    if(isset($participantes[$i]['vendas'])) {
                                                        echo '<li style="list-style-type:none;padding:.5rem 0;"><strong>' . $desempenhoCamp[$v - 1]['mes'] . "</strong><br>" . number_format($participantes[$i]['realizado'][$v] / 100, 2, ",", ".") . '%</li>';
                                                    } else {
                                                        echo '<li style="list-style-type:none;padding:.5rem 0;"><strong>' . $desempenhoCamp[$v - 1]['mes'] . "</strong><br>" . number_format(0, 2, ",", ".") . '%</li>';
                                                    }
                                                }
                                            echo '</td>';
                                            echo '<td colspan="2">';
                                                echo '<h5>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                        Maxx Pontos
                                                    </h5><br>';
                                                for($v = 1; $v <= 12; $v++) {
                                                    if(isset($participantes[$i]['vendas'])) {
                                                        echo '<li style="list-style-type:none;padding:.5rem 0;"><strong>' . $desempenhoCamp[$v - 1]['mes'] . "</strong><br>" . number_format($participantes[$i]['pontos'][$v], 0, ",", ".") . '</li>';
                                                    } else {
                                                        echo '<li style="list-style-type:none;padding:.5rem 0;"><strong>' . $desempenhoCamp[$v - 1]['mes'] . "</strong><br>" . number_format(0, 0, ",", ".") . '</li>';
                                                    }
                                                }
                                            echo '</td>';
                                        echo '</tr>';
                                    }

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
                                $qtd_pontosTrocados += $pedidos[$p]['total'];
                            }
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
                            <td><?php echo $publicosQtd['Consultor de Trade Marketing']; ?></td>
                        </tr>
                        <tr>
                            <td>Coordenador Trade</td>
                            <td><?php echo $publicosQtd['Coordenador Trade']; ?></td>
                        </tr>
                        <tr>
                            <td>Coordenador Técnico Digital</td>
                            <td><?php echo $publicosQtd['Coordenador Tecnico Cientifico Digital']; ?></td>
                        </tr>
                        <tr>
                            <td>Gerente Distritais</td>
                            <td><?php echo $publicosQtd['Gerente Distrital']; ?></td>
                        </tr>
                        <tr>
                            <td>Gerente de Contas</td>
                            <td><?php echo $publicosQtd['Gerente de Contas']; ?></td>
                        </tr>
                        <tr>
                            <td>Gerente de Produto</td>
                            <td><?php echo $publicosQtd['Gerente de Produto']; ?></td>
                        </tr>
                        <tr>
                            <td>Representante Propagandista</td>
                            <td><?php echo $publicosQtd['Representante Propagandista']; ?></td>
                        </tr>
                        <tr>
                            <td>Representante Digital</td>
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
                    <?php if(count($pedidos) > 0) { ?>
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
                                            if(isset($pedidos[$p]['usuario'])) {
                                                echo '<tr class="linha-pedido-' . $p . '" onmouseenter="mostrarImgProd(' . $p . ')" onmouseleave="mostrarImgProd(' . $p . ')">';
                                                    echo '<td>#' . $pedidos[$p]['id'] . '</td>';
                                                    echo '<td>' . date('d.m.Y', strtotime($pedidos[$p]['data'])) . '</td>';
                                                    echo '<td><img src="../img/p/' . $pedidos[$p]['cod'] . '.jpg" class="img-pedido-' . $p . '">' . $pedidos[$p]['title'] . '</td>';
                                                    echo '<td>' . substr($pedidos[$p]['usuario']['cpf'], 0, 3) . '.' . substr($pedidos[$p]['usuario']['cpf'], 3, 3) . '.' . substr($pedidos[$p]['usuario']['cpf'], 6, 3) . '-' . substr($pedidos[$p]['usuario']['cpf'], 9, 2) . '</td>';
                                                    echo '<td>' . $pedidos[$p]['usuario']['name'] . ' ' . $pedidos[$p]['usuario']['name_extension'] . '</td>';
                                                    echo '<td>' . number_format($pedidos[$p]['subtotal'], 0, ",", ".") . '</td>';
                                                    echo '<td>' . number_format($pedidos[$p]['frete'], 0, ",", ".") . '</td>';
                                                    echo '<td>' . number_format($pedidos[$p]['total'], 0, ",", ".") . '</td>';
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
                    <thead>
                        <tr>
                            <th colspan="14">Comparativo Mensal Vendas Gerais TheraSkin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="barras">
                            <td id="eixo-y">
                                <ul>
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
                                    <hr class="grade-grafico">
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
                                    $proporcao = $desempenhoCamp[$m]['valor'] / 150;
                                    echo '<td><span>' . $desempenhoCamp[$m]['valor'] . '%</span><div style="height: ' . 40 * $proporcao . 'vh;"></div></td>';
                                }
                            ?>
                            <td id="grafico-valores">
                                <ul>
                                    <h4>Resultados Mensais</h4>
                                    <br>
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
                            <td></td>
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
                                <th>Realizado Anual</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                isset($publico_001) ? usort($publico_001, 'compare_by_percent') : [];
                                for($i = 0; $i < 2; $i++) {
                                    echo $i < 1 ? '<tr class="viajante">' : '<tr>';
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
                                <th>Realizado Anual</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                isset($publico_002) ? usort($publico_002, 'compare_by_percent') : [];
                                for($i = 0; $i < 2; $i++) {
                                    echo $i < 1 ? '<tr class="viajante">' : '<tr>';
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
                                <th>Realizado Anual</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                isset($publico_003) ? usort($publico_003, 'compare_by_percent') : [];
                                for($i = 0; $i < 3; $i++) {
                                    echo $i < 1 ? '<tr class="viajante">' : '<tr>';
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
                                <th>Realizado Anual</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                isset($publico_004) ? usort($publico_004, 'compare_by_percent') : [];
                                for($i = 0; $i < 5; $i++) {
                                    echo $i < 2 ? '<tr class="viajante">' : '<tr>';
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
                                <th>Realizado Anual</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                isset($publico_005) ? usort($publico_005, 'compare_by_percent') : [];
                                for($i = 0; $i < 8; $i++) {
                                    echo $i < 6 ? '<tr class="viajante">' : '<tr>';
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
                    <?php
                        $vendas_thera = 0;

                        for($i = 1; $i <= 12; $i++) {
                            $vendas_thera += ($theraskin[0]['venda_' . $i]);
                        }
                    ?>
                    <h6>Objetivo TheraSkin</h6>
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
                        <div style="width:.5rem;height:.5rem;border-radius:50%!important;padding:.5rem;margin-right:.5rem;" class="viajante"></div>
                        <p>Participante Viajante</p>
                    </span>
                    <p>Se a campanha terminasse hoje, estes seriam os participantes que viajariam com a Diretoria da TheraSkin na Viagem dos Campeões para Cancún, no México.</p>
                    <hr>
                    <h6>Públicos:</h6>
                    <br>
                    <p><strong>Grupo 001 - 1 vaga</strong><br>Gerente de Produto</p>
                    <p><strong>Grupo 002 - 1 vaga</strong><br>Gerente de Contas</p>
                    <p><strong>Grupo 003 - 1 vaga</strong><br>Consultor de Trade Marketing</p>
                    <p><strong>Grupo 004 - 2 vagas</strong><br>Coordenador Trade, Coordenador Técnico Digital, ou Gerente Distrital</p>
                    <p><strong>Grupo 005 - 6 vagas</strong><br>Representante Propagandista ou Representante Digital</p>
                    <br>
                    <p><strong>Total - 11 vagas</strong></p>
                </div>
            </div>
            
        </div>
    </div>
    <?php
    /*
        echo "<pre>";
        echo print_r($desempenhos);
        echo "</pre>";
    */
    ?>
</section>