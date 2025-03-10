<?php
    //FUNCTION SEM PARAMETRO E COM RETORNO  

    function treinaphp(){
        $a = "Kasparov";
        return $a;
    }
    $frase = "Oi ";
    $frase .= treinaphp();

    echo $frase;

?>