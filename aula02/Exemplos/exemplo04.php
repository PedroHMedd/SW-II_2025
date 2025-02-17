<?php
    $contador = 0;
    while ($contador < 5) {
        echo "Número: $contador";
        $contador++;
    }

    for ($i = 0; $i < 5; $i++) {
        echo "Número: $i ";
    }

    $nomes = ["ANA", "bruno", "carlos"];
    foreach ($nomes as $nome) {
        echo "Nome: $nome";
    }

?>