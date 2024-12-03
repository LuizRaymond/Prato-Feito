<?php

if(!isset($_SESSION)){
    session_start();
}
require_once '../config/config.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $category = $_POST['category'];
    $image = $_POST['image']; 

    $stmt = $pdo->prepare("INSERT INTO receitas (titulo, descricao, ingredientes, modo_de_preparo, categoria, usuario_id, imagem) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $description, $ingredients, $instructions, $category, $_SESSION['usuario']['id'], $image]);

    $_SESSION['mensagem'] = "Receita cadastrada com sucesso!";
    header("Location: http://localhost/Prato-Feito/pages/blog.php");
    exit;
}
?>

<?php 
include("../includes/header/header.php");
?>

<h2>Cadastrar Receita</h2>
<form method="POST">
    <input type="text" name="title" placeholder="Título da Receita" required>
    <textarea name="description" placeholder="Descrição" required></textarea>
    <textarea name="ingredients" placeholder="Ingredientes" required></textarea>
    <textarea name="instructions" placeholder="Instruções" required></textarea>
    <input type="text" name="category" placeholder="Categoria" required>
    <input type="text" name="image" placeholder="Caminho da Imagem" />
    <button type="submit">Cadastrar Receita</button>
</form>

<?php
if (isset($_SESSION['mensagem'])) {
    echo "<p>{$_SESSION['mensagem']}</p>";
    unset($_SESSION['mensagem']);
}
?>
