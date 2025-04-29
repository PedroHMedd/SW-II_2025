<?php
// Define que a resposta será em JSON e usa UTF-8 para acentuação correta
header("Content-Type: application/json; charset=UTF-8");

// Captura o método HTTP da requisição (GET, POST, PUT, DELETE, etc.)
$metodo = $_SERVER['REQUEST_METHOD'];

// Nome do arquivo onde os dados dos usuários serão armazenados
$arquivo = 'usuarios.json';

// Se o arquivo não existir, cria um novo com um array vazio
if (!file_exists($arquivo)) {
    file_put_contents($arquivo, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Lê os dados do arquivo JSON e converte em array associativo
$usuarios = json_decode(file_get_contents($arquivo), true);

// Início da estrutura condicional com base no método HTTP
switch ($metodo) {

    // ==============================================
    // MÉTODO GET: Retorna todos os usuários ou um por ID
    // ==============================================
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']); // Converte o ID para número inteiro
            $usuario_encontrado = null;

            // Procura o usuário com o ID correspondente
            foreach ($usuarios as $usuario) {
                if ($usuario['id'] == $id) {
                    $usuario_encontrado = $usuario;
                    break;
                }
            }

            // Se encontrar, retorna o usuário
            if ($usuario_encontrado) {
                echo json_encode($usuario_encontrado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                // Caso contrário, retorna erro 404
                http_response_code(404);
                echo json_encode(["erro" => "Usuário não encontrado."], JSON_UNESCAPED_UNICODE);
            }
        } else {
            // Sem ID: retorna todos os usuários
            echo json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        break;

    // ==============================================
    // MÉTODO POST: Cadastra um novo usuário
    // ==============================================
    case 'POST':
        // Lê o corpo da requisição (JSON enviado)
        $dados = json_decode(file_get_contents('php://input'), true);

        // Verifica se nome e email foram enviados
        if (!isset($dados["nome"]) || !isset($dados["email"])) {
            http_response_code(400); // Erro de requisição inválida
            echo json_encode(["erro" => "Nome e email são obrigatórios."], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Gera novo ID automático
        $novo_id = 1;
        if (!empty($usuarios)) {
            $ids = array_column($usuarios, 'id'); // Coleta todos os IDs
            $novo_id = max($ids) + 1; // Novo ID = maior ID + 1
        }

        // Cria novo usuário
        $novo_usuario = [
            "id" => $novo_id,
            "nome" => $dados["nome"],
            "email" => $dados["email"],
        ];

        // Adiciona ao array
        $usuarios[] = $novo_usuario;

        // Salva no arquivo
        file_put_contents($arquivo, json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Retorna confirmação
        echo json_encode([
            "mensagem" => "Usuário inserido com sucesso!",
            "usuario" => $novo_usuario
        ], JSON_UNESCAPED_UNICODE);
        break;

    // ==============================================
    // MÉTODO PUT: Atualiza um usuário por ID
    // ==============================================
    case 'PUT':
        // Verifica se o ID foi passado na URL
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(["erro" => "ID não informado para atualização."], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $id = intval($_GET['id']);
        $dados = json_decode(file_get_contents('php://input'), true); // Lê corpo da requisição

        $atualizado = false;

        // Procura o usuário com o ID correspondente e atualiza
        foreach ($usuarios as &$usuario) {
            if ($usuario['id'] == $id) {
                if (isset($dados['nome'])) $usuario['nome'] = $dados['nome'];
                if (isset($dados['email'])) $usuario['email'] = $dados['email'];
                $atualizado = true;
                break;
            }
        }

        // Se atualizou, salva e retorna mensagem
        if ($atualizado) {
            file_put_contents($arquivo, json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo json_encode(["mensagem" => "Usuário atualizado com sucesso."], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode(["erro" => "Usuário não encontrado."], JSON_UNESCAPED_UNICODE);
        }
        break;

    // ==============================================
    // MÉTODO DELETE: Exclui um usuário por ID
    // ==============================================
    case 'DELETE':
        // Verifica se o ID foi informado
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(["erro" => "ID não informado para exclusão."], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $id = intval($_GET['id']);
        $encontrado = false;

        // Procura o usuário com ID e remove do array
        foreach ($usuarios as $index => $usuario) {
            if ($usuario['id'] == $id) {
                unset($usuarios[$index]);
                $usuarios = array_values($usuarios); // Reorganiza os índices
                $encontrado = true;
                break;
            }
        }

        // Se deletado, salva novo array
        if ($encontrado) {
            file_put_contents($arquivo, json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo json_encode(["mensagem" => "Usuário deletado com sucesso."], JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode(["erro" => "Usuário não encontrado."], JSON_UNESCAPED_UNICODE);
        }
        break;

    // ==============================================
    // MÉTODO NÃO PERMITIDO
    // ==============================================
    default:
        http_response_code(405); // Método não permitido
        echo json_encode(["erro" => "Método não permitido!"], JSON_UNESCAPED_UNICODE);
        break;
}
?>
