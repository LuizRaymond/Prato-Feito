<?php
if(!isset($_SESSION)){
    session_start();
}
require_once '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
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
<?php 
include("../includes/header/header.php");
?>

<h2>Login</h2>
<form method="POST">
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <button type="submit">Entrar</button>
</form>

<?php if (isset($_SESSION['erro'])): ?>
    <p><?= $_SESSION['erro']; ?></p>
    <?php unset($_SESSION['erro']); ?>
<?php endif; ?>
