<?php
// Arquivo de conexão com o banco de dados

$host = "localhost";
$usuario = "root";         // padrão no XAMPP
$senha = "";               // sem senha no XAMPP por padrão
$banco = "kappe_db";       // nome do banco que você criou

// Criando conexão
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica se ocorreu erro
if ($conn->connect_error) {
    die("Erro na conexão com o banco: " . $conn->connect_error);
}

// Caso queira testar:
// echo "Conexão bem-sucedida!";
?>
