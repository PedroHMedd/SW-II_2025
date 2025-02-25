<?php  

    function treinaphp($x){
        foreach ($x as $nome) {
            echo "$nome <br>";
        }
    }

    $vetor = ['Kasparov', 'Mikhail Tal', 'Carlsen'];

    treinaphp($vetor);
?>