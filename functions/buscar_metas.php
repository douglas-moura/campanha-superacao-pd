<?php
    function buscar_metas($db, $cpf) {
        $meta_anual = 0;

        $metas = $db->select("SELECT
            meta_1,
            meta_2,
            meta_3,
            meta_4,
            meta_5,
            meta_6,
            meta_7,
            meta_8,
            meta_9,
            meta_10,
            meta_11,
            meta_12,
            meta_13
        from `goals`
        where cod = '" . $cpf . "'");

        for ($i = 1; $i <= count($metas[0]); $i++) {
            $meta_anual += $metas[0]['meta_' . $i];
        }

        $metas[0]['meta_anual'] = $meta_anual;

        return $metas ? $metas[0] : 0;
    }
?>