<?php
// CABEÇALHO: Define que o tipo de resposta será JSON e o conjunto de caracteres será UTF-8
header("Content-Type: application/json; charset=UTF-8");

// Captura o método da requisição HTTP (GET, POST, etc.)
$metodo = $_SERVER['REQUEST_METHOD'];

// Define o nome do arquivo onde os dados dos usuários ficarão armazenados
$arquivo = 'usuarios.json';

// Verifica se o arquivo 'usuarios.json' existe
// Se não existir, cria um novo arquivo com um array vazio como conteúdo
if (!file_exists($arquivo)) {
    file_put_contents($arquivo, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Lê o conteúdo do arquivo JSON e converte para array associativo em PHP
$usuarios = json_decode(file_get_contents($arquivo), true);

// Inicia o controle de fluxo baseado no método da requisição
switch ($metodo) {
    case 'GET':
        // Verifica se existe um parâmetro "id" na URL (ex: ?id=3)
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']); // Converte o ID recebido para inteiro
            $usuario_encontrado = null;

            // Percorre o array de usuários para encontrar o usuário com o ID correspondente
            foreach ($usuarios as $usuario) {
                if ($usuario['id'] == $id) {
                    $usuario_encontrado = $usuario;
                    break; // Para o loop ao encontrar o usuário
                }
            }

            // Se encontrou o usuário, retorna ele em JSON
            if ($usuario_encontrado) {
                echo json_encode($usuario_encontrado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                // Se não encontrou, retorna erro 404 (não encontrado)
                http_response_code(404);
                echo json_encode(["erro" => "Usuário não encontrado."], JSON_UNESCAPED_UNICODE);
            }
        } else {
            // Se nenhum ID foi passado, retorna todos os usuários cadastrados
            echo json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        break;

    case 'POST':
        // Lê o corpo da requisição (normalmente JSON) e converte em array
        $dados = json_decode(file_get_contents('php://input'), true);

        // Verifica se os campos obrigatórios "nome" e "email" foram enviados
        if (!isset($dados["nome"]) || !isset($dados["email"])) {
            http_response_code(400); // Código de erro de requisição inválida
            echo json_encode(["erro" => "Nome e email são obrigatórios."], JSON_UNESCAPED_UNICODE);
            exit; // Interrompe o script
        }

        // Define o novo ID automaticamente:
        // Se o array de usuários não estiver vazio, pega o maior ID existente e soma 1
        $novo_id = 1;
        if (!empty($usuarios)) {
            $ids = array_column($usuarios, 'id'); // Pega todos os IDs existentes
            $novo_id = max($ids) + 1; // Novo ID é o maior ID + 1
        }

        // Cria um novo usuário com os dados recebidos
        $novo_usuario = [
            "id" => $novo_id,
            "nome" => $dados["nome"],
            "email" => $dados["email"],
        ];

        // Adiciona o novo usuário ao array de usuários
        $usuarios[] = $novo_usuario;

        // Salva o novo array atualizado no arquivo JSON
        file_put_contents($arquivo, json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Retorna uma mensagem de sucesso junto com os dados do novo usuário
        echo json_encode([
            "mensagem" => "Usuário inserido com sucesso!",
            "usuario" => $novo_usuario
        ], JSON_UNESCAPED_UNICODE);
        break;

    default:
        // Se o método usado não for GET ou POST, retorna erro 405 (Método não permitido)
        http_response_code(405);
        echo json_encode(["erro" => "Método não permitido!"], JSON_UNESCAPED_UNICODE);
        break;
}
?>
