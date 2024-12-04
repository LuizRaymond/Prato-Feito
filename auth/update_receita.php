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
    $stmt = $pdo->prepare("SELECT * FROM receitas WHERE id = ?");
    $stmt->execute([$id]);
    $receita = $stmt->fetch();

    if (!$receita) {
        echo "Receita não encontrada!";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $ingredients = $_POST['ingredients'];
        $instructions = $_POST['instructions'];
        $category = $_POST['category'];
        $image = $_POST['image'];

        $stmt = $pdo->prepare("UPDATE receitas SET titulo = ?, descricao = ?, ingredientes = ?, modo_de_preparo = ?, categoria = ?, imagem = ? WHERE id = ?");
        $stmt->execute([$title, $description, $ingredients, $instructions, $category, $image, $id]);

        $_SESSION['mensagem'] = "Receita atualizada com sucesso!";
        header("Location: http://localhost/Prato-Feito/pages/blog.php");
        exit;
    }
}
?>

<div class="w-screen min-h-screen flex flex-col gap-16 justify-center items-center bg-white py-11">
    <h2>Editar Receita</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Título da Receita" value="<?= $receita['titulo'] ?>" required>
        <textarea name="description" placeholder="Descrição" required><?= $receita['descricao'] ?></textarea>
        <textarea name="ingredients" placeholder="Ingredientes" required><?= $receita['ingredientes'] ?></textarea>
        <textarea name="instructions" placeholder="Instruções" required><?= $receita['modo_de_preparo'] ?></textarea>
        <input type="text" name="category" placeholder="Categoria" value="<?= $receita['categoria'] ?>" required>
        <input type="text" name="image" placeholder="Caminho da Imagem" value="<?= $receita['imagem'] ?>" />
        <button type="submit">Atualizar Receita</button>
    </form>
</div>
