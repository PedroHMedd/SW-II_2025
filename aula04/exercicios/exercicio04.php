<?php
    $n = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
    $quantidapar = 0;
    $quantidaimpar = 0;

    for($i = $n[0]; $i < 11; $i ++){
        if($i % 2 == 0){
            $quantidapar += 1;
        }
        else {
            $quantidaimpar += 1;
        }
    }

    echo "A quantidade de números pares é de " . $quantidapar"<br>";
    echo "A quantidade de números impares é de " . $quantidaimpar;

?>