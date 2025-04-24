<?php
include('../includes/db.php');

$pastaProdutos = '../assets/produtos/';
$diretorios = array_filter(glob($pastaProdutos . '*'), 'is_dir');

$inseridos = 0;

foreach ($diretorios as $dir) {
    $nomePasta = basename($dir);
    $nomeProduto = preg_replace('/^\d+\s*-\s*/', '', $nomePasta);
    $nomeProduto = ucwords(strtolower($nomeProduto));
    $imagem = 'frente.png';
    $descricao = 'Produto sincronizado automaticamente';
    $link = '';
    $preco = 49.90;
    $ativo = 1;

    // Verifica se já existe
    $stmt = $conn->prepare("SELECT id FROM produtos WHERE pasta = ?");
    $stmt->bind_param("s", $nomePasta);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        $insert = $conn->prepare("INSERT INTO produtos (nome, descricao, imagem, link_download, preco, ativo, pasta) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param("ssssdis", $nomeProduto, $descricao, $imagem, $link, $preco, $ativo, $nomePasta);
        $insert->execute();
        $inseridos++;
    }
}

echo "<h3 style='color: lime;'>$inseridos produto(s) sincronizado(s) automaticamente.</h3>";
echo "<a href='../loja/loja.php' style='color: yellow;'>← Ir para a loja</a>";
