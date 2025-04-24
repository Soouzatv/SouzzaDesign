<?php
include('../includes/header.php');

// Caminho das pastas de produtos
$pastaProdutos = '../assets/produtos/';
$diretorios = array_filter(glob($pastaProdutos . '*'), 'is_dir');

// Paginação
$totalPorPagina = 9;
$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($paginaAtual - 1) * $totalPorPagina;
$produtosPaginados = array_slice($diretorios, $inicio, $totalPorPagina);
$totalPaginas = ceil(count($diretorios) / $totalPorPagina);
?>

<style>
.grid-loja {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px;
    max-width: 1200px;
    margin: 60px auto;
    padding: 20px;
}

.card-produto {
    background-color: transparent;
    padding: 15px;
    border-radius: 12px;
    text-align: center;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.card-produto .box-img {
    width: 280px;
    height: 280px;
    display: flex;
    justify-content: center;
    align-items: center;
    background: transparent;
    border-radius: 20px;
    border: 3px solid;
    border-image: linear-gradient(to right, cyan, magenta, yellow, black, cyan) 1;
    overflow: hidden;
    position: relative;
}

.card-produto .box-img img {
    max-width: 80%;
    max-height: 80%;
    object-fit: contain;
    background: transparent;
    transition: opacity 0.4s ease;
    padding: 0;
    margin: auto;
    display: block;
}

/* Efeito hover */
.card-produto .hover {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    opacity: 0;
}

.card-produto:hover .hover {
    opacity: 1;
}

.card-produto:hover .default {
    opacity: 0;
}

.card-produto h3 {
    color: cyan;
    margin-top: 10px;
}

.card-produto p {
    color: #FF00FF;
    font-weight: bold;
}

.card-produto a.botao {
    display: inline-block;
    background: yellow;
    color: black;
    padding: 8px 20px;
    margin-top: 8px;
    border-radius: 6px;
    font-weight: bold;
    text-decoration: none;
}

.paginacao {
    text-align: center;
    margin: 40px 0;
}

.paginacao a {
    display: inline-block;
    background: #222;
    color: #fff;
    padding: 8px 14px;
    margin: 2px;
    text-decoration: none;
    border-radius: 6px;
    transition: 0.2s;
}

.paginacao a:hover {
    background: #FF00FF;
    color: #000;
}
</style>

<h2 style="text-align:center; color: yellow; margin-top: 120px;">Loja de Produtos</h2>

<div class="grid-loja">
<?php foreach ($produtosPaginados as $dir): 
    $nomePasta = basename($dir);
    $nomeProduto = preg_replace('/^\d+\s*-\s*/', '', $nomePasta);
    $nomeProduto = ucwords(strtolower($nomeProduto));

    $frente = "$dir/frente.png";
    $folha = "$dir/folha.png";

    // Verifica se pelo menos uma imagem existe
    if (!file_exists($frente) && !file_exists($folha)) continue;
?>
    <div class="card-produto">
        <a href="produto.php?produto=<?php echo urlencode($nomePasta); ?>">
            <div class="box-img">
                <?php if (file_exists($frente)): ?>
                    <img src="<?php echo $frente; ?>" alt="Frente" class="default">
                <?php endif; ?>
                <?php if (file_exists($folha)): ?>
                    <img src="<?php echo $folha; ?>" alt="Folha" class="hover">
                <?php endif; ?>
            </div>
        </a>
        <h3><?php echo $nomeProduto; ?></h3>
        <p>R$ 49,90</p>
        <a class="botao" href="produto.php?produto=<?php echo urlencode($nomePasta); ?>">Ver Produto</a>
    </div>
<?php endforeach; ?>
</div>

<!-- Paginação -->
<div class="paginacao">
<?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
    <a href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
<?php endfor; ?>
</div>
