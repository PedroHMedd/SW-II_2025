<?php
function somandoarray($array) {
    $soma = 0;
    foreach ($array as $numero) {
        $soma += $numero;
    }
    return $soma;
}

$numeros = [1, 2, 3, 4, 5];
$resultado = somandoarray($numeros);

echo "A soma é: $resultado";
?>
