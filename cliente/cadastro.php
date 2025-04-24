<?php include('../includes/header.php');
include('../includes/db.php');

$mensagem = "";

function validarCPF($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) return false;

    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++)
            $d += $cpf[$c] * (($t + 1) - $c);
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) return false;
    }
    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    if (!validarCPF($cpf)) {
        $mensagem = "❌ CPF inválido. Verifique e tente novamente.";
    } else {
        $verificar = $conn->prepare("SELECT id FROM usuarios WHERE email = ? OR cpf = ?");
        $verificar->bind_param("ss", $email, $cpf);
        $verificar->execute();
        $verificar->store_result();

        if ($verificar->num_rows > 0) {
            $mensagem = "⚠️ E-mail ou CPF já estão cadastrados.";
        } else {
            $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, cpf, senha) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nome, $email, $cpf, $senha);
            if ($stmt->execute()) {
                $mensagem = "✅ Cadastro realizado com sucesso!";
            } else {
                $mensagem = "Erro ao cadastrar. Tente novamente.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Cliente</title>
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #111;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 25px rgba(0, 255, 255, 0.2);
            width: 350px;
        }

        h2 {
            text-align: center;
            color: #00FFFF;
            margin-bottom: 20px;
        }

        label {
            color: #FF00FF;
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: none;
            border-radius: 5px;
            background-color: #222;
            color: #fff;
        }

        button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background-color: #FFFF00;
            color: #000;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #FF00FF;
            color: #fff;
            transform: scale(1.03);
        }

        .mensagem {
            background-color: #222;
            color: #00FF00;
            margin-bottom: 15px;
            padding: 10px;
            border-left: 5px solid #00FF00;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Cadastro</h2>

    <?php if ($mensagem): ?>
        <div class="mensagem"><?php echo $mensagem; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required>

        <label for="email">E-mail:</label>
        <input type="email" name="email" required>

        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" placeholder="000.000.000-00" required>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" required>

        <button type="submit">Cadastrar</button>
    </form>
</div>

</body>
</html>
