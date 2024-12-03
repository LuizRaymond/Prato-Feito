<?php
if(!isset($_SESSION)){
    session_start();
}
require_once '../config/config.php';

include("../includes/header/header.php");


if (!isset($_SESSION['usuario'])) {
    echo "<p>Você precisa estar logado para ver suas receitas.</p>";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM receitas WHERE usuario_id = ?");
$stmt->execute([$_SESSION['usuario']['id']]);
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h1>Blog de Receitas</h1>";

if (count($recipes) > 0) {
    foreach ($recipes as $recipe) {
        echo "<div class='recipe'>";
        echo "<h2>{$recipe['titulo']}</h2>";
        echo "<p>{$recipe['descricao']}</p>";
        echo "<p><strong>Ingredientes:</strong><br>{$recipe['ingredientes']}</p>";
        echo "<p><strong>Instruções:</strong><br>{$recipe['modo_de_preparo']}</p>";
        echo "<p><strong>Categoria:</strong> {$recipe['categoria']}</p>";
        if ($recipe['imagem']) {
            echo "<img src='{$recipe['imagem']}' alt='{$recipe['titulo']}' />";
        }
        echo "</div>";
    }
} else {
    echo "<p>Você ainda não tem receitas cadastradas.</p>";
}

require_once '../includes/footer.php';
?>
