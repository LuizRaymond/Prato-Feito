<?php

if (!isset($_SESSION)) {
    session_start();
}
include("../config/config.php");
try {
    $sql = "SELECT id, titulo FROM receitas";
    $stmt = $pdo->query($sql);
    $receitas = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Erro ao buscar receitas: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Receitas</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>

    <?php
    include("../includes/header/header.php");
    ?>
    <div class="flex flex-col min-h-screen">

        <ul>
            <?php foreach ($receitas as $receita): ?>
                <li>
                    <a href="receita.php?id=<?php echo $receita['id']; ?>"><?php echo $receita['titulo']; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <?php
    include("../includes/footer.php")
        ?>
</body>

</html>