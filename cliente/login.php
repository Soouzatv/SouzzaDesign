<?php 
include('../includes/header.php');
session_start();
include('../includes/db.php');

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $nome, $senha_hash);
        $stmt->fetch();

        if (password_verify($senha, $senha_hash)) {
            $_SESSION['usuario_id'] = $id;
            $_SESSION['usuario_nome'] = $nome;
            header("Location: ../minha-conta.php");
            exit;
        } else {
            $mensagem = "❌ Senha incorreta.";
        }
    } else {
        $mensagem = "❌ E-mail não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <style>
    body {
      margin: 0;
      padding-top: 100px; /* espaço pro header */
      background-color: #fff;
      font-family: 'Segoe UI', sans-serif;
    }

    .login-wrapper {
      max-width: 400px;
      margin: 60px auto;
      background-color: #111;
      padding: 40px;
      border-radius: 12px;
      color: white;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      color: #FFFF00;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-top: 15px;
      color: #00FFFF;
      font-weight: bold;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      background-color: #222;
      border: none;
      border-radius: 6px;
      color: #fff;
    }

    button {
      width: 100%;
      margin-top: 25px;
      padding: 12px;
      background-color: #00FFFF;
      border: none;
      color: #000;
      font-weight: bold;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s ease;
    }

    button:hover {
      background-color: #FF00FF;
      color: white;
    }

    .mensagem {
      background-color: #2a0000;
      color: #ff4a4a;
      margin-bottom: 15px;
      padding: 10px;
      border-left: 5px solid #ff4a4a;
      border-radius: 5px;
      text-align: center;
    }

    .link {
      margin-top: 18px;
      text-align: center;
    }

    .link a {
      color: #00FFFF;
      text-decoration: none;
      font-weight: bold;
    }

    .link a:hover {
      color: #FFFF00;
    }
  </style>
</head>
<body>

<div class="login-wrapper">
  <h2>Login</h2>

  <?php if ($mensagem): ?>
    <div class="mensagem"><?php echo $mensagem; ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <label for="email">E-mail:</label>
    <input type="email" name="email" id="email" required>

    <label for="senha">Senha:</label>
    <input type="password" name="senha" id="senha" required>

    <button type="submit">Entrar</button>
  </form>

  <div class="link">
    Ainda não tem conta? <a href="cadastro.php">Cadastre-se aqui</a>
  </div>
</div>

</body>
</html>
