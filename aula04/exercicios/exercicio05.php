<?php
    $boletim = array("Vinicius" => "9", "Lucas" => "8", "Pedro" => "8", "Tiago" => "9");
    $soma = 0;
    foreach ($boletim as $key => $value) {
        $soma += $value;
    }
    $media = $soma / count($boletim);
    echo "A média é " . $media;
?>
