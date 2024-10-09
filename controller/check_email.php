<?php
// Incluir a conexão com o banco de dados
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Verifica se o email já existe no banco
    $sql = "SELECT * FROM usuario WHERE email_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Retorna 'exists' se o email já estiver cadastrado
        echo 'exists';
    } else {
        echo 'not_exists';
    }
}
?>
