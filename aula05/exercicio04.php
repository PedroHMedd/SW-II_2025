<?php

$emailBuscado = isset($_GET['email']) ? $_GET['email'] : "maria@email.com";

$arquivo = "usuarios.json";
$json = file_get_contents($arquivo);
$usuarios = json_decode($json, true);

$usuarioEncontrado = null;
foreach ($usuarios as $usuario) {
    if ($usuario['email'] === $emailBuscado) {
        $usuarioEncontrado = $usuario;
        break;
    }
}

if ($usuarioEncontrado) {
    echo "Usuário encontrado:<br>";
    echo "ID: " . $usuarioEncontrado['id'] . "<br>";
    echo "Nome: " . $usuarioEncontrado['nome'] . "<br>";
    echo "Email: " . $usuarioEncontrado['email'] . "<br>";
} else {
    echo "Usuário não encontrado.";
}
?>