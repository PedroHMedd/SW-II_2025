<?php
    $boletim = array("Paulo" => "9", "Pedro" => "8", "Iago" => "8", "Tizao" => "9");
    $soma = 0;
    foreach ($boletim as $key => $value) {
        $soma += $value;
    }
    $media = $soma / count($boletim);
    echo "A média é " . $media;
?>
