<?php
// Verifica se o formulário foi enviado
$cep = isset($_GET['cep']) ? preg_replace('/[^0-9]/', '', $_GET['cep']) : '';
$dados = null;
$erro = '';

// Se o CEP tiver 8 dígitos, busca na API
if ($cep && strlen($cep) == 8) {
  // Busca na API ViaCEP
  $url = "https://viacep.com.br/ws/$cep/json/";
  $resposta = file_get_contents($url);
  $dados = json_decode($resposta, true);

  // Verifica se a API retornou erro
  if (isset($dados['erro'])) {
    $erro = "CEP não encontrado.";
    $dados = null;
  }
} elseif ($cep) {
  // Erro
  $erro = "Digite um CEP válido com 8 dígitos.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Consulta de Endereço via CEP</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <h1>Consulta de Endereço via CEP</h1>

  <form method="GET">
    <input type="text" name="cep" placeholder="Digite o CEP (ex: 01001000)" value="<?= htmlspecialchars($cep) ?>">
    <button type="submit">Consultar</button>
  </form>

  <?php if ($erro): ?>
    <p class="erro"><?= $erro ?></p>
  <?php elseif ($dados): ?>
    <div class="resultado">
      <p><strong>CEP:</strong> <?= $cep ?></p>
      <p><strong>Logradouro:</strong> <?= $dados['logradouro'] ?></p>
      <p><strong>Bairro:</strong> <?= $dados['bairro'] ?></p>
      <p><strong>Localidade:</strong> <?= $dados['localidade'] ?></p>
      <p><strong>UF:</strong> <?= $dados['uf'] ?></p>
      <p><strong>Estado:</strong> <?= $dados['uf'] ?></p>
      <p><strong>Região:</strong> <?= regioPorUF($dados['uf']) ?></p>
    </div>
  <?php endif; ?>

</body>

</html>

<?php
// Função para determinar a região com base na UF
function regioPorUF($uf)
{
  $regioes = [
    'Norte' => ['AC', 'AP', 'AM', 'PA', 'RO', 'RR', 'TO'],
    'Nordeste' => ['AL', 'BA', 'CE', 'MA', 'PB', 'PE', 'PI', 'RN', 'SE'],
    'Centro-Oeste' => ['DF', 'GO', 'MT', 'MS'],
    'Sudeste' => ['ES', 'MG', 'RJ', 'SP'],
    'Sul' => ['PR', 'RS', 'SC'],
  ];

  foreach ($regioes as $regiao => $ufs) {
    if (in_array($uf, $ufs)) return $regiao;
  }

  return 'desconhecida';
}
?>