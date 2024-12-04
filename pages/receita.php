<?php

if(!isset($_SESSION)){
    session_start();
}

include("../config/config.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {

        $sql = "SELECT * FROM receitas WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $receita = $stmt->fetch();
        
        if (!$receita) {
            echo "Receita não encontrada.";
            exit;
        }

    } catch (PDOException $e) {
        echo "Erro ao buscar a receita: " . $e->getMessage();
    }
} else {
    echo "ID da receita não fornecido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receita Completa</title>
</head>
<body>
<?php 
include("../includes/header/header.php");
?>
    <h1><?php echo htmlspecialchars($receita['titulo']); ?></h1>
    
    <?php if ($receita['imagem']): ?>
        <img src="<?php echo htmlspecialchars($receita['imagem']); ?>" alt="Imagem da receita" width="300">
    <?php endif; ?>

    <h2>Descrição</h2>
    <p><?php echo nl2br(htmlspecialchars($receita['descricao'])); ?></p>

    <h2>Ingredientes</h2>
    <p><?php echo nl2br(htmlspecialchars($receita['ingredientes'])); ?></p>

    <h2>Modo de Preparo</h2>
    <p><?php echo nl2br(htmlspecialchars($receita['modo_de_preparo'])); ?></p>

    <p><strong>Categoria:</strong> <?php echo htmlspecialchars($receita['categoria']); ?></p>
</body>
</html>
