<?php
    function buscar_pontos($db, $cpf) {
        $total_pontos = 0;

        $pontos = $db->select("SELECT
            points_e1_1,
            points_e1_2,
            points_e1_3,
            points_e1_4,
            points_e1_5,
            points_e1_6,
            points_e1_7,
            points_e1_8,
            points_e1_9,
            points_e1_10,
            points_e1_11,
            points_e1_12,
            points_e1_13
        from `goals`
        where cod = '" . $cpf . "'");

        for ($i = 1; $i <= count($pontos[0]); $i++) {
            $total_pontos += $pontos[0]['points_e1_' . $i];
        }

        $pontos[0]['total_pontos'] = $total_pontos;

        return $pontos ? $pontos[0] : 0;
    }
?>