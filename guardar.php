<?php
// Conectar à base de dados SQLite
$db = new PDO("sqlite:base_dados.sqlite");

// Criar tabela se não existir
$db->exec("CREATE TABLE IF NOT EXISTS marcacoes (
id INTEGER PRIMARY KEY AUTOINCREMENT,
nome TEXT,
servico TEXT,
modelo TEXT,
data TEXT,
hora TEXT,
contacto TEXT
)");

// Obter os dados do formulário
$nome = $_POST['nome'];
$servico = $_POST['servico'];
$modelo = isset($_POST['modelo']) ? $_POST['modelo'] : '';  // Modelo só se Test-Drive
$data = $_POST['data'];
$hora = $_POST['hora'];
$contacto = $_POST['contacto'];

// Validar data e hora no servidor
$hoje = new DateTime(); // Data e hora atuais
$dataEscolhida = new DateTime($data . ' ' . $hora); // Converter data + hora escolhida

// Se a data escolhida for anterior a hoje ou a hora for anterior à hora atual no mesmo dia
if ($dataEscolhida < $hoje) {
    die("Erro: A data e/ou hora não pode ser anterior à data/hora atual.");
}

// Verificar se já existe uma marcação para a mesma data e hora
$verificar = $db->prepare("SELECT COUNT(*) FROM marcacoes WHERE data = :data AND hora = :hora");
$verificar->bindParam(':data', $data);
$verificar->bindParam(':hora', $hora);
$verificar->execute();

$existe = $verificar->fetchColumn();

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Resultado do Agendamento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Stand DF Motors</h1>

    <?php if ($existe > 0): ?>
        <h2 style="color: #e74c3c;">Horário Ocupado</h2>
        <p>Já existe uma marcação para <strong><?= $data ?> às <?= $hora ?></strong>.</p>
        <a href="index.html"><button>Tentar Outro Horário</button></a>
    <?php else:
        // Inserir dados na base de dados
        $stmt = $db->prepare("INSERT INTO marcacoes (nome, tipo, modelo, data, hora, contacto) 
            VALUES (:nome, :servico, :modelo, :data, :hora, :contacto)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':servico', $servico);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':hora', $hora);
        $stmt->bindParam(':contacto', $contacto);
        $stmt->execute();
        ?>
        <h2 style="color: #2ecc71;">Marcação Confirmada</h2>
        <p>Tipo de Agendamento: <strong><?= $servico ?></strong></p>
        <?php if ($servico === 'Test-Drive'): ?>
            <p>Modelo do Carro: <strong><?= $modelo ?></strong></p>
        <?php endif; ?>
        <p>Data: <strong><?= $data ?></strong> às <strong><?= $hora ?></strong></p>
        <!-- Apenas mostrar o botão "Voltar Atrás" -->
        <a href="index.html"><button>Voltar Atrás</button></a>
    <?php endif; ?>
</div>
</body>
</html>
