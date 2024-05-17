<?php
    $participante_pts = $db -> select("SELECT ((g.venda_1 +
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
                                                g.venda_12) / g.goal_13) as tot_pts, g.cod, users.name, users.name_extension, users.type
                                                FROM `goals` as g JOIN `users`
                                                WHERE g.cod = users.cpf AND users.type = '" . $_SESSION['user']['type'] . "'
                                                ORDER BY tot_pts
                                                DESC LIMIT 3");
?>

<table class="ranking-table">
    <thead>
        <tr>
            <th class="rank">Rank</th>
            <th class="public">Nome</th>
            <th class="public">Cargo</th>
            <th class="percent">% Atingimento Meta</th>
        </tr>
    </thead>
    <tbody>
        
        <?php
            
            if (count($participante_pts) > 0) {
                for ($i=0; $i < 3 ; $i++) {
                    echo "<tr>
                            <td class='rank' > " . ($i + 1) . "</td>
                            <td class='public'>" . $participante_pts[$i]['name'] . " " . $participante_pts[$i]['name_extension'] . "</td>
                            <td class='public'>" . $participante_pts[$i]['type'] .  "</td>
                            <td class='percent'>" . number_format($participante_pts[$i]['tot_pts'] * 100, 1) .  "%</td>
                        </tr>";
                };
            } else {
                echo "<p> Ranking ainda não divulgado... </p>";
            }
        ?>
    
    </tbody>
</table>