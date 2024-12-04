<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once '../config/config.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM receitas WHERE id = ?");
    $stmt->execute([$id]);

    $_SESSION['mensagem'] = "Receita excluída com sucesso!";
    header("Location: http://localhost/Prato-Feito/pages/blog.php");
    exit;
}
?>
