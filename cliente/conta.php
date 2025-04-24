<?php include('../includes/header.php');
session_start();
include('../includes/db.php');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$nome = $_SESSION['usuario_nome'];

// Buscar pedidos do cliente
$pedidos = [];
$sql = "SELECT pedidos.id, pedidos.data, produtos.nome AS produto, produtos.link_download 
        FROM pedidos 
        JOIN produtos ON pedidos.id = produtos.id
        WHERE pedidos.id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $pedidos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Minha Conta</title>
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background-color: #111;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 0 25px rgba(0, 255, 255, 0.2);
        }

        h2 {
            color: #FFFF00;
            text-align: center;
            margin-bottom: 20px;
        }

        .user-info {
            text-align: center;
            margin-bottom: 30px;
        }

        .user-info p {
            font-size: 18px;
            color: #00FFFF;
        }

        .logout {
            display: block;
            text-align: center;
            margin-bottom: 30px;
        }

        .logout a {
            background-color: #FF00FF;
            color: #fff;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .logout a:hover {
            background-color: #FFFF00;
            color: #000;
        }

        .pedido {
            background-color: #222;
            border-left: 4px solid #00FFFF;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
        }

        .pedido strong {
            color: #FFFF00;
        }

        .pedido a {
            color: #00FFFF;
            font-weight: bold;
            text-decoration: none;
        }

        .pedido a:hover {
            color: #FF00FF;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Área do Cliente</h2>

    <div class="user-info">
        <p>Olá <strong><?php echo $nome; ?></strong>, seja bem-vindo(a)!</p>
    </div>

    <div class="logout">
        <a href="logout.php">Sair da conta</a>
    </div>

    <h3>Seus pedidos:</h3>

    <?php if (count($pedidos) > 0): ?>
        <?php foreach ($pedidos as $pedido): ?>
            <div class="pedido">
                <p><strong>Pedido #<?php echo $pedido['id']; ?></strong> em <?php echo date('d/m/Y H:i', strtotime($pedido['data'])); ?></p>
                <p>Produto: <?php echo $pedido['produto']; ?></p>
                <p><a href="<?php echo $pedido['link_download']; ?>" target="_blank">📥 Baixar Produto</a></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Você ainda não fez nenhum pedido.</p>
    <?php endif; ?>

</div>

</body>
</html>
