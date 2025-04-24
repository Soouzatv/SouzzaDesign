<?php
include('../includes/header.php'); // cabeçalho padrão do site
?>

<style>
.painel-container {
    max-width: 600px;
    margin: 120px auto;
    text-align: center;
    font-family: 'Segoe UI', sans-serif;
}
.botao-atualizar {
    background-color: yellow;
    color: black;
    padding: 12px 30px;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
}
.botao-atualizar:hover {
    background-color: #ff0;
}
</style>

<div class="painel-container">
    <h1>Painel do Administrador</h1>
    <p>Você pode atualizar os produtos clicando no botão abaixo:</p>

    <form method="POST" action="sincronizar-produtos.php">
        <button type="submit" class="botao-atualizar">Atualizar Produtos</button>
    </form>
</div>
