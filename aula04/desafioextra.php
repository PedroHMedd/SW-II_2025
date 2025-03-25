<?php
    $boletim = array("Wesley" => "8", "Pedro" => "10", "Lucas" => "9", "Tiago" => "7");
    foreach ($boletim as $key => $value) {
        sort($value);
        $maior = $value[count($boletim) - 1];
    }
    echo "O maior é " . $maior;
?>