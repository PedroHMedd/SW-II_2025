<?php
$arquivo = "produtos.json";
$json = file_get_contents($arquivo);
$produtos = json_decode($json, true);

if (!is_array($produtos)) {
    echo "Erro ao ler o arquivo JSON.";
    exit;
}

$nomeProdutoRemover = "Mouse"; 
$produtos = array_filter($produtos, function($produto) use ($nomeProdutoRemover) {
    return $produto['nome'] !== $nomeProdutoRemover;
});

$produtos = array_values($produtos);

$jsonAtualizado = json_encode($produtos, JSON_PRETTY_PRINT);
file_put_contents($arquivo, $jsonAtualizado);

echo "Produto removido com sucesso!";
?>