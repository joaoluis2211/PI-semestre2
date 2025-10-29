<?php
session_start();
require_once __DIR__ . '/app/config/dbconection.php'; // ajuste o caminho conforme necessário

// Recebe e sanitiza os dados do formulário
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$curso = isset($_POST['curso']) ? trim($_POST['curso']) : '';
$periodo = isset($_POST['periodo']) ? trim($_POST['periodo']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';

// Validação simplificada (pode ser ampliada)
if (strlen($nome) < 3 || strlen($curso) < 2 || strlen($periodo) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($senha) < 8) {
    $_SESSION['erro_cadastro'] = "Preencha corretamente todos os campos.";
    header('Location: cadastro.php');
    exit;
}

try {
    $db = new Database();
    $pdo = $db->getConnection();

    // Verifica se email já existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $_SESSION['erro_cadastro'] = "Este email já está cadastrado.";
        header('Location: cadastro.php');
        exit;
    }

    // Prepara INSERT para múltiplas colunas
    $sql = "INSERT INTO usuarios (nome, curso, periodo, email, senha) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    // Criptografa a senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Executa inserção
    $sucesso = $stmt->execute([$nome, $curso, $periodo, $email, $senhaHash]);

    if ($sucesso) {
        $_SESSION['sucesso_cadastro'] = "Cadastro realizado com sucesso! Faça login.";
        header('Location: cadastro.php');
        exit;
    } else {
        $_SESSION['erro_cadastro'] = "Falha ao cadastrar usuário. Tente novamente.";
        header('Location: cadastro.php');
        exit;
    }

} catch (PDOException $e) {
    error_log('Erro no cadastro: ' . $e->getMessage());
    $_SESSION['erro_cadastro'] = "Erro no sistema. Tente novamente mais tarde.";
    header('Location: cadastro.php');
    exit;
}
