<?php
    function buscar_vendas($db, $cpf) {
        $total_vendas = 0;

        $vendas = $db->select("SELECT
            venda_1,
            venda_2,
            venda_3,
            venda_4,
            venda_5,
            venda_6,
            venda_7,
            venda_8,
            venda_9,
            venda_10,
            venda_11,
            venda_12,
            venda_13
        from `goals`
        where cod = '" . $cpf . "'");

        for ($i = 1; $i <= count($vendas[0]); $i++) {
            $total_vendas += $vendas[0]['venda_' . $i];
        }

        $vendas[0]['venda_anual'] = $total_vendas;

        return $vendas ? $vendas[0] : 0;
    }
?>