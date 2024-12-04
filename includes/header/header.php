<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: "Montserrat", sans-serif;
        }

        .box-links {
            margin-top: 4px;
        }

        .box-links div {
            height: 2px;
            width: 0px;
            background-color: black;
            transition: all .3s;
        }

        .box-links:hover div {
            width: 100%;
        }
    </style>

</head>
<header class="flex flex-row w-screen justify-around items-center py-5 fixed left-0 top-0 z-20 bg-white">
    <button onclick="redirecionar('../pages/index.php')" class="font-bold from-neutral-900 text-xl">PRATO FEITO</button>
    <div class="flex gap-4 items-center justify-center">
        <div class="box-links">
            <a href="../pages/index.php">Início</a>
            <div></div>
        </div>
        <div class="box-links">
            <a href="../pages/sobre.php">Sobre</a>
            <div></div>
        </div>
        <div class="box-links">
            <a href="../pages/blog.php">Suas de Receitas</a>
            <div></div>
        </div>

        <div class="box-links">
            <a href="../pages/todas_receitas.php">Tudo</a>
            <div></div>
        </div>
        <?php if (!isset($_SESSION['usuario'])): ?>

            <button class="border border-black py-1 px-4" onclick="redirecionar('../auth/login.php')">Login</button>
        <?php else: ?>

            <button class="border border-black py-1 px-4" onclick="redirecionar('../auth/logout.php')">Sair</button>
        <?php endif; ?>
        </>
</header>

<script>
    function redirecionar(link) {
        window.location.href = link
    }
</script>