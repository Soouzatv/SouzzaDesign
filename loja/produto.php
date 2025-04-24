<?php
include('../includes/header.php');
include('../includes/db.php');

if (!isset($_GET['produto'])) {
    echo "Produto não encontrado.";
    exit;
}

$pasta = $_GET['produto'];
$nomePasta = basename($pasta);

$stmt = $conn->prepare("SELECT nome, descricao, preco FROM produtos WHERE pasta = ?");
$stmt->bind_param("s", $nomePasta);
$stmt->execute();
$stmt->bind_result($nome, $descricao, $preco);
$stmt->fetch();
$stmt->close();

$caminho = "../assets/produtos/$nomePasta/";
$imagens = glob($caminho . "*.png");
$downloads = glob($caminho . "*.cdr");
?>

<style>
body {
    background: #f8f9fa;
    font-family: 'Segoe UI', sans-serif;
}
.produto-container {
    display: flex;
    max-width: 1200px;
    margin: 80px auto;
    gap: 40px;
    flex-wrap: wrap;
}
.galeria-lateral {
    width: 100px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.galeria-lateral img {
    width: 100%;
    border: 2px solid #ddd;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
}
.galeria-lateral img:hover {
    border-color: #FF00FF;
}
.imagem-principal {
    flex: 1;
    min-width: 300px;
}
.imagem-principal img {
    width: 100%;
    border-radius: 8px;
    transition: transform 0.3s ease;
}
.imagem-principal img:hover {
    transform: scale(1.04);
}
.info-produto {
    flex: 1;
    min-width: 300px;
}
.info-produto h1 {
    font-size: 28px;
    margin-bottom: 10px;
}
.preco {
    font-size: 24px;
    color: #28a745;
    margin: 10px 0;
}
.download-links a {
    display: inline-block;
    margin: 10px 10px 0 0;
    padding: 10px 15px;
    background: #000;
    color: #fff;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
}
.download-links a:hover {
    background: #FF00FF;
    color: #000;
}
</style>

<div class="produto-container">
    <div class="galeria-lateral">
        <?php foreach ($imagens as $img): ?>
            <img src="<?php echo $img; ?>" onclick="document.getElementById('main-image').src='<?php echo $img; ?>'">
        <?php endforeach; ?>
    </div>

    <div class="imagem-principal">
        <img id="main-image" src="<?php echo $imagens[0]; ?>" alt="Imagem do Produto">
    </div>

    <div class="info-produto">
        <h1><?php echo $nome; ?></h1>
        <p><?php echo $descricao; ?></p>
        <div class="preco">R$ <?php echo number_format($preco, 2, ',', '.'); ?></div>
        <div class="download-links">
            <?php foreach ($downloads as $arquivo): ?>
                <a href="<?php echo $arquivo; ?>" download>Baixar CDR</a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
