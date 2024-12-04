<?php
if (!isset($_SESSION)) {
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
$receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h1>Blog de Receitas</h1>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background-image: url(../assets/images/feijao-tropeiro-brasil-3-1024x683.webp);
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            background-clip: content-box;
            background-attachment: fixed;
            width: 100vw;
            overflow-x: hidden;
        }
    </style>
</head>

<body>

    <div class="w-screen flex justify-center items-center relative mt-12" style="height: 400px;">

        <div class="absolute inset-0 bg-black bg-opacity-70"></div>

        <div
            class="flex flex-col gap-4 items-start w-2/3 absolute left-[50%] top-[50%] translate-y-[-50%] translate-x-[-50%] text-white">
            <h1>Suas Noticias</h1>
        </div>
    </div>

    <div class="w-screen min-h-screen flex flex-col gap-16 justify-center items-center bg-white py-11">

        <?php
        if (count($receitas) > 0) {
            foreach ($receitas as $receita) {
                ?>
                <div class="flex gap-4 h-52 w-[700px] shadow-2xl">
                    <div>
                        <img class=" h-52 object-cover" src="<?php echo $receita['imagem']; ?>">
                    </div>
                    <div class="flex flex-col h-full justify-between w-96 px-6 py-6">
                        <a class="outline-none no-underline text-xl font-semibold"
                            href="receita.php?id=<?php echo $receita['id']; ?>"><?php echo $receita['titulo']; ?></a>
                        <h3 style="color:#595959;" class="text-lg"><?php echo $receita['descricao']; ?></h3>


                        <div class="flex w-full gap-4 font-light text-sm">
                            <span><?php echo $receita['categoria']; ?></span>
                            <span>|</span>
                            <p>
                                <?php
                                try {
                                    $sql = "SELECT nome FROM usuarios where id = :usuario_id";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->bindParam(':usuario_id', $receita['usuario_id'], PDO::PARAM_INT);
                                    $stmt->execute();
                                    $usuario = $stmt->fetch();
                                    echo "Por " . $usuario["nome"];
                                } catch (PDOException $e) {
                                    echo "" . $e->getMessage();
                                }

                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>Você ainda não tem receitas cadastradas.</p>";
        }

        ?>
    </div>
    <?php

    require_once '../includes/footer.php';
    ?>