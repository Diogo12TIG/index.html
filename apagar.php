<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $db = new PDO("sqlite:base_dados.sqlite");
    $stmt = $db->prepare("DELETE FROM marcacoes WHERE id = :id");
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
}

header("Location: ver_marcacoes.php");
exit;
