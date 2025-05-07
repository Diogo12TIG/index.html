<?php
$host = "localhost";
$user = "root";
$senha = "";
$banco = "df_motors";

$conn = new mysqli($host, $user, $senha, $banco);

if ($conn->connect_error) {
  die("Erro na ligação: " . $conn->connect_error);
}
?>
