<?php
session_start();

// Redirecionar se já estiver logado
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: ver_marcacoes.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Novo login: Diogo / Diogo2007!
    $admin_username = 'Diogo';
    $admin_password = 'Diogo2007!';

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: ver_marcacoes.php');
        exit;
    } else {
        $error_message = "Nome de usuário ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Login - Administrador</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Login - Administrador</h1>

    <?php if (isset($error_message)): ?>
        <p style="color: #e74c3c;"><?= $error_message ?></p>
    <?php endif; ?>

    <form action="login.php" method="post">
        <label for="username">Nome de usuário:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Entrar</button>
    </form>

    <!-- Botão para voltar à página inicial -->
    <a href="index.html">
        <button type="button">Voltar à Página Inicial</button>
    </a>
</div>
</body>
</html>
