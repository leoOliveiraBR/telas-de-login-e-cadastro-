<?php
$usuario = 'root'; // Insira seu usuário do banco de dados
$senha = ''; // Insira sua senha do banco de dados
$banco = 'db_xo_bagunca'; // Insira o nome do seu banco de dados

// Criar a conexão
$conn = new mysqli('localhost',$usuario, $senha, $banco);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
