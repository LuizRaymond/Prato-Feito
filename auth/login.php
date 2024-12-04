<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once '../config/config.php';

if (isset($_SESSION['usuario'])) {
    header("Location: ../pages/blog.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];


    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario'] = $usuario;
        header("Location: ../pages/blog.php");
        exit;
    } else {
        $_SESSION['erro'] = "Usuário ou senha inválidos!";
    }
}
?>
<?php include("../includes/header/header.php"); ?>

<div class="flex justify-center items-center h-screen bg-gray-100 mt-12">
    <div class="w-96 bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Login</h2>

        <?php if (isset($_SESSION['erro'])): ?>
            <div class="mb-4 text-red-500 text-center">
                <?= $_SESSION['erro']; ?>
            </div>
            <?php unset($_SESSION['erro']); ?>
        <?php endif; ?>

        <form method="POST">
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

            <button type="submit" class="w-full p-3  text-white font-semibold rounded-lg  transition-colors"
                style="background-color: #28a745; transition: all .3s"
                onmouseover="this.style.backgroundColor='#218838';" onmouseout="this.style.backgroundColor='#28a745';">
                Entrar
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="cadastro.php" class="hover:underline" style="color: #28a745;" >Não tem uma conta? Cadastre-se</a>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>