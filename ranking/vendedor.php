<?php
    $nome = [
        'Nome',
    
    
    ];
    
    $meta = [
        '%',
    
    
    ];
    
    $pontos = [
        '999.999',
    
    ];
    
    
    $participante_pts = $db -> select(
                                        "SELECT (
                                                    (
                                                        g.venda_1 +
                                                        g.venda_2 +
                                                        g.venda_3 +
                                                        g.venda_4 +
                                                        g.venda_5 +
                                                        g.venda_6 +
                                                        g.venda_7 +
                                                        g.venda_8 +
                                                        g.venda_9 +
                                                        g.venda_10 +
                                                        g.venda_11 +
                                                        g.venda_12
                                                    ) / g.meta_13
                                            ) as total_desemp, g.cod, users.name, users.name_extension, users.type
                                        FROM `goals` as g JOIN `users`
                                        WHERE g.cod = users.cpf AND users.type = '" . $_SESSION['user']['type'] . "'
                                        ORDER BY total_desemp
                                        DESC LIMIT 5"
                                    );
?>

<table class="ranking-table">
    <thead>
        <tr>
            <th class="rank">Rank</th>
            <th class="public">Nome</th>
            <th class="public">Cargo</th>
            <th class="percent">Vendas</th>
        </tr>
    </thead>
    <tbody>
        
        <?php
            
            echo "<pre>";
            echo print_r($participante_pts);
            echo "</pre>";
            
            if (count($participante_pts) > 0) {
                $qtd = count($participante_pts) < 5 ? count($participante_pts) : 5;
                for ($i=0; $i < $qtd ; $i++) {
                    echo "<tr>
                            <td class='rank' > " . ($i + 1) . "º</td>
                            <td class='public'>" . $participante_pts[$i]['name'] . " " . $participante_pts[$i]['name_extension'] . "</td>
                            <td class='public'>" . $participante_pts[$i]['type'] .  "</td>
                            <td class='percent'>" . str_replace(".", ",", number_format($participante_pts[$i]['total_desemp'] * 100, 2)) .  "%</td>
                        </tr>";
                };
            } else {
                echo "<h3>Não divulgado.</h3>";
            }
        ?>
    
    </tbody>
</table>
