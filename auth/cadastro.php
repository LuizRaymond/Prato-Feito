<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once '../config/config.php';

include("../includes/header/header.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['erro'] = "E-mail inválido!";
    } else {

        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $_SESSION['erro'] = "E-mail já cadastrado!";
        } else {

            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            $stmt->execute([$nome, $email, password_hash($senha, PASSWORD_DEFAULT)]);

            $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
            header("Location: login.php");
            exit;
        }
    }
}
?>

<div class="flex justify-center items-center h-screen bg-gray-100 mt-12 ">
    <div class="w-96 bg-white p-8 unded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Cadastro</h2>

        <?php if (isset($_SESSION['erro'])): ?>
            <div class="mb-4 text-red-500 text-center">
                <?= $_SESSION['erro']; ?>
            </div>
            <?php unset($_SESSION['erro']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="mb-4 text-green-500 text-center">
                <?= $_SESSION['mensagem']; ?>
            </div>
            <?php unset($_SESSION['mensagem']); ?>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label for="nome" class="block text-sm font-semibold text-gray-700">Nome</label>
                <input type="text" name="nome" id="nome" placeholder="Nome" required
                    class="w-full p-3 border border-gray-300 rounded-lg">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-gray-700">E-mail</label>
                <input type="email" name="email" id="email" placeholder="E-mail" required
                    class="w-full p-3 border border-gray-300 rounded-lg">
            </div>

            <div class="mb-6">
                <label for="senha" class="block text-sm font-semibold text-gray-700">Senha</label>
                <input type="password" name="senha" id="senha" placeholder="Senha" required
                    class="w-full p-3 border border-gray-300 rounded-lg">
            </div>

            <button type="submit" class="w-full p-3 0 text-white font-semibold rounded-lg transition-colors"
                style="background-color: #28a745; transition: all .3s"
                onmouseover="this.style.backgroundColor='#218838';" onmouseout="this.style.backgroundColor='#28a745';">
                Cadastrar
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="login.php" class=" hover:underline" style="color: #28a745;">Já tem uma conta? Faça login</a>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>