<?php

if (!isset($_SESSION)) {
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-50 w-screen overflow-x-hidden">

    <?php include("../includes/header/header.php"); ?>

    <div class="w-screen min-h-screen flex flex-col gap-16 justify-center items-center bg-white mt-16">
        <div class="max-w-4xl mx-auto p-6">
            <h1 class="text-4xl font-bold text-gray-800 mb-6"><?php echo htmlspecialchars($receita['titulo']); ?></h1>

            <?php if ($receita['imagem']): ?>
                <img src="<?php echo htmlspecialchars($receita['imagem']); ?>" alt="Imagem da receita"
                    class="w-full h-auto rounded-lg shadow-md mb-6">
            <?php endif; ?>

            <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Descrição</h2>
                <p class="text-lg text-gray-600"><?php echo nl2br(htmlspecialchars($receita['descricao'])); ?></p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Ingredientes</h2>
                <p class="text-lg text-gray-600"><?php echo nl2br(htmlspecialchars($receita['ingredientes'])); ?></p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Modo de Preparo</h2>
                <p class="text-lg text-gray-600"><?php echo nl2br(htmlspecialchars($receita['modo_de_preparo'])); ?></p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                <p class="text-lg font-semibold text-gray-800"><strong>Categoria:</strong>
                    <?php echo htmlspecialchars($receita['categoria']); ?></p>
            </div>
        </div>
    </div>
</body>

</html>