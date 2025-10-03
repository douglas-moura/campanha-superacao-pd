<?php
    function formato_reais($valor) {
        return "R$ " . number_format($valor, 2, ',', '.');
    }
?>