<?php

if (!isset($_SESSION)) {
    session_start();
}
include("../config/config.php");
try {
    $sql = "SELECT * FROM receitas";
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
    <title>Prato Feito</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

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

<body>

    <?php
    include("../includes/header/header.php");
    ?>

    <div class="flex flex-col min-h-screen  w-screen items-center">

        <div class="w-screen h-screen flex justify-center items-center relative">

            <div class="absolute inset-0 bg-black bg-opacity-70"></div>

            <div
                class="flex flex-col gap-4 items-start w-2/3 absolute left-[50%] top-[50%] translate-y-[-50%] translate-x-[-50%] text-white">
                <h1 class="text-7xl font-bold">Prato Feito</h1>

                <h2 class="text-2xl font-semibold">Receitas Compartilhadas por todos.</h2>

                <button class="p-4 font-bold text-xl rounded" style="background-color: #32aa27; transition: all .3s"
                    onmouseover="this.style.backgroundColor='#278720';"
                    onmouseout="this.style.backgroundColor='#32aa27';">
                    Participe
                </button>
            </div>
        </div>

        <div class="w-screen min-h-screen flex justify-center items-center bg-white">
            <div class="flex gap-28 items-center">
                <div class="w-96 flex flex-col gap-4">
                    <h3 class="text-xl font-semibold" style="color:#32aa27;">Compartilhe suas receitas</h3>
                    <h1 class="text-3xl font-bold tracking-wide">Junte-se à Comunidade dos Amantes da Comida</h1>
                    <p style="color:#595959;" class="font-medium text-xl">No Prato Feito, todo amante da comida tem voz.
                        Compartilhe suas receitas favoritas, descubra novas delícias culinárias e se conecte com outros
                        entusiastas da culinária. Seja você um chef experiente ou um cozinheiro iniciante, o Prato Feito
                        te recebe para mostrar suas criações. Vamos criar memórias deliciosas juntos!</p>
                </div>

                <div class="w-72">
                    <img style="height: 450px;" class="object-cover"
                        src="../assets/images/df44c478-b197-11ef-a605-0242ac110002-jpg-hero_image.jpeg">
                </div>
            </div>
        </div>

        <div class="w-screen min-h-screen flex justify-center items-center " style="background-color:#f5f5f5;">
            <div class="flex gap-16 items-center justify-center">
                <div class="flex flex-col gap-2 bg-white h-96 shadow-2xl overflow-hidden">
                    <img class="h-1/2 object-cover"
                        src="../assets/images/e2b8a656-b197-11ef-a605-0242ac110002-jpg-regular_image.jpeg" alt=""
                        srcset="">

                    <div class="w-56 p-2 px-4 flex flex-col gap-2">
                        <a href="#" class="font-semibold" style="color:#32aa27;">Compartilhe Receitas</a>
                        <p>Divida suas criações culinárias com o mundo!</p>
                    </div>
                </div>
                <div class="flex flex-col gap-2 bg-white h-96 shadow-2xl overflow-hidden">
                    <img class="h-1/2 object-cover"
                        src="../assets/images/e20adb3e-b197-11ef-a605-0242ac110002-jpg-regular_image.jpeg" alt=""
                        srcset="">

                    <div class="w-56 p-2 px-4 flex flex-col gap-2">
                        <a href="#" class="font-semibold" style="color:#32aa27;">Explore Receitas Diversas</a>
                        <p>Descubra um mundo de sabores ao seu alcance.</p>
                    </div>
                </div>
                <div class="flex flex-col gap-2 bg-white h-96 shadow-2xl overflow-hidden">
                    <img class="h-1/2 object-cover"
                        src="../assets/images/e24ae120-b197-11ef-a605-0242ac110002-jpg-regular_image.jpeg" alt=""
                        srcset="">

                    <div class="w-56 p-2 px-4 flex flex-col gap-2">
                        <a href="#" class="font-semibold" style="color:#32aa27;">Junte-se à Comunidade de
                            Cozinheiros</a>
                        <p>Conecte-se com outros amantes da culinária e compartilhe dicas.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-screen min-h-screen flex flex-col gap-16 justify-center items-center bg-white py-11">
            <?php foreach ($receitas as $receita):
                if ($receita["id"] < 5) { ?>
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
                <?php } ?>
            <?php endforeach; ?>

            <div class="flex gap-4 items-center justify-center"> <h1>Quer ver mais Receitas?</h1> <a href="blog.php" class="p-2 font-bold text-sm rounded text-white"
                    style="background-color: #32aa27; transition: all .3s; "
                    onmouseover="this.style.backgroundColor='#278720';"
                    onmouseout="this.style.backgroundColor='#32aa27';">Clique Aqui!</a></div>

        </div>
    </div>

    <?php
    include("../includes/footer.php")
        ?>
</body>

</html>