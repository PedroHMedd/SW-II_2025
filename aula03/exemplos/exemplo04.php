<?php
    //FUNCTION COM PARAMETRO E COM RETORNO  

    function treinaphp($x){
        $a = "Kasparov" .$x;
        return $a;
    }
    $sobrenome = ", Garry";

    $frase = "Oi ";
    $frase .= treinaphp($sobrenome);
    $frase .= " The GOAT ";

    echo $frase;

?>