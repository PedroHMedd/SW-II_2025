<?php
// Passo a: Ler o JSON do arquivo e converter para um array
$arquivo = "produtos.json";
$json = file_get_contents($arquivo);
$produtos = json_decode($json, true);

// Verifica se a conversão foi bem-sucedida
if (!is_array($produtos)) {
    $produtos = [];
}

// b: Adicionar um novo produto ao array
$novoProduto = [
    "nome" => "Monitor",
    "preco" => 800.00,
    "quantidade" => 10
];
$produtos[] = $novoProduto;

//   c: Converter o array atualizado para JSON e salvar de volta no arquivo
$jsonAtualizado = json_encode($produtos, JSON_PRETTY_PRINT);
file_put_contents($arquivo, $jsonAtualizado);

echo "Novo produto adicionado com sucesso!";
?>
