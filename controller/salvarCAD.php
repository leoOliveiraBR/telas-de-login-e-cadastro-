<?php
// Incluir a conexão com o banco de dados
include 'conexao.php';

$errorMessage = ''; // Variável para armazenar mensagens de erro

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['name'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Verifica se o email já está cadastrado no banco
    $sql = "SELECT * FROM usuario WHERE email_usuario = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // Exibe o erro SQL para ajudar a identificar o problema
        die("Erro na preparação da consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Definindo mensagem de erro em vez de popup
        $errorMessage = 'E-mail já cadastrado! Tente outro.';
    } else {
        // Se não estiver cadastrado, insere o novo usuário
        $sql = "INSERT INTO usuario (nome_usuario, data_nasc_usuario, email_usuario, senha_usuario) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            // Exibe o erro SQL para ajudar a identificar o problema
            die("Erro na preparação da consulta de inserção: " . $conn->error);
        }

        $stmt->bind_param("ssss", $nome, $dob, $email, $senha);

        if ($stmt->execute()) {
            echo "<script>alert('Usuário cadastrado com sucesso!'); window.location.href = '../explicacoes.php';</script>";
        } else {
            $errorMessage = 'Erro ao cadastrar usuário.';
        }
    }
}
?>
