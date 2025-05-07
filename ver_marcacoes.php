<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$db = new PDO("sqlite:base_dados.sqlite");
$dados = $db->query("SELECT * FROM marcacoes ORDER BY data, hora")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Marcações - Stand DF Motors</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Stand DF Motors</h1>
    <h2>Bem-vindo, Diogo</h2>
    <h3>Lista de Marcações</h3>

    <?php if (count($dados) > 0): ?>
        <table>
            <tr>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Modelo</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Contacto</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($dados as $linha): ?>
                <tr>
                    <td><?= htmlspecialchars($linha['nome'] ?? '') ?></td>
                    <td><?= htmlspecialchars($linha['servico'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($linha['modelo'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($linha['data'] ?? '') ?></td>
                    <td><?= htmlspecialchars($linha['hora'] ?? '') ?></td>
                    <td><?= htmlspecialchars($linha['contacto'] ?? '') ?></td>
                    <td>
                        <a href="apagar.php?id=<?= $linha['id'] ?>" onclick="return confirm('Tens a certeza que queres apagar esta marcação?')">
                            <button style="background-color: #e74c3c;">Apagar</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Sem marcações registadas.</p>
    <?php endif; ?>

    <div style="margin-top: 25px;">
        <a href="index.html"><button>Voltar Atrás</button></a>
        <a href="logout.php"><button>Sair</button></a>
    </div>
</div>
</body>
</html>
