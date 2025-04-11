<?php
    function soma($n) {
        $soma = 0;
        foreach ($n as $numero) {
            $soma += $numero;
        }
        return $soma;
    }
    $num = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
    echo "A soma dos 10 números é " . soma($num);

?>