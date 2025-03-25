<?php

$arquivo = "usuarios.json";
$json = file_get_contents($arquivo);

$usuarios = json_decode($json, true);

if ($usuarios) {
    foreach ($usuarios as $usuario) {
        echo "Nome: " . $usuario['nome'] . " - Email: " . $usuario['email'] . "<br>";
    }
} else {
    echo "Erro ao ler o JSON.";
}
?>