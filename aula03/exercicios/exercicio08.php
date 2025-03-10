<?php
function gerandonumeros()
{
    $array = [];

    for ($i = 0; $i < 10; $i++) {
        $array[] = rand(1, 999);
    }

    return $array;
}

$numeros = gerandonumeros();

foreach ($numeros as $numero) {
    echo $numero . " ";
}


//CODIGO QUE PODERIA SER USADO COM O CODE PRINTR
//function gerandonumeros()
//{
    //$array = [];

    //for ($i = 0; $i < 10; $i++) {
        //$array[] = rand(1, 100);
    //}

    //return $array;
//}

//$numeros = gerandonumeros();
//print_r($numeros);

//print r é mais usual em array