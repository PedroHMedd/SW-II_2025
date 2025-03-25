<?php
    $boletim = array("Kasparov" => "8", "Karpov" => "10", "Tal" => "9", "Boris" => "7");
    foreach ($boletim as $key => $value) {
        sort($value);
        $maior = $value[count($boletim) - 1];
    }
    echo "O maior é " . $maior;
?>
