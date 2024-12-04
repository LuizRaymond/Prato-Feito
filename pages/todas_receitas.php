<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background-image: url(../assets/images/e5fcf0f6-b197-11ef-a195-0242ac110002-jpg-hero_image.jpeg);
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            background-clip: content-box;
            background-attachment: fixed;
            width: 100vw;
            overflow-x: hidden;
        }

        html {
            width: 100vw;
            overflow-x: hidden;
        }
    </style>
</head>

<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once '../config/config.php';

include("../includes/header/header.php");


if (!isset($_SESSION['usuario'])) {
    ?>
    <div class="w-screen  h-screen overflow-x-hidden flex justify-center items-center relative mt-12 bg-gray-100">

        <div class="w-96 bg-white p-8 rounded-lg shadow-lg text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Você ainda não está logado.</h2>
            <p class="text-lg text-gray-600 mb-4">Para acessar essa funcionalidade, é necessário fazer login.</p>
            <p class="text-sm text-gray-500">Se ainda não tem uma conta, você pode se cadastrar rapidamente e começar a
                aproveitar todas as vantagens.</p>
            <div class="mt-6 flex justify-center gap-4">
                <a href="../auth/login.php"
                    class="w-full p-3 text-white font-semibold rounded-lg transition-colors text-center"
                    style="background-color: #28a745; transition: all .3s"
                    onmouseover="this.style.backgroundColor='#218838';"
                    onmouseout="this.style.backgroundColor='#28a745';">Fazer Login</a>
            </div>
        </div>
    </div>

    <?php
    exit;
}

$sql = "SELECT * FROM receitas";
$stmt = $pdo->query($sql);
$receitas = $stmt->fetchAll();

echo "<h1>Blog de Receitas</h1>";
?>


<body>

    <div class="w-screen flex justify-center items-center relative mt-12" style="height: 400px;">

        <div class="absolute inset-0 bg-black bg-opacity-70"></div>

        <div
            class="flex flex-col gap-4 items-start w-2/3 absolute left-[50%] top-[50%] translate-y-[-50%] translate-x-[-50%] text-white">
            <h1 class="font-bold text-4xl">Todas as receitas</h1>
            <h3 class="font-medium text-lg">Desfrute de todas essas receitas deliciosas gratuitamente!</h3>
        </div>
    </div>

    <div class="w-screen min-h-screen flex flex-col gap-16 justify-center items-center bg-white py-11">

        <?php
        if (count($receitas) > 0) {
            foreach ($receitas as $receita) {
                ?>
                <div class="flex gap-4 h-52 w-[700px] shadow-2xl">
                    <div>
                        <img class=" h-52  w-72 object-cover" src="<?php echo $receita['imagem']; ?>">
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