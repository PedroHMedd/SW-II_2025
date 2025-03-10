<?php

function fatorial($valor)
{
    $resultado = 1;
    for ($i = 1; $i <= $valor; $i++) {
        $resultado *= $i;
    }
    echo $resultado;
}
fatorial(3);