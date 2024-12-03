<?php
if(!isset($_SESSION)){
    session_start();
}
require_once '../config/config.php';

include("../includes/header/header.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

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
?>

<h2>Cadastro</h2>
<form method="POST">
    <input type="text" name="nome" placeholder="Nome" required>
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <button type="submit">Cadastrar</button>
</form>

<?php if (isset($_SESSION['erro'])): ?>
    <p><?= $_SESSION['erro']; ?></p>
    <?php unset($_SESSION['erro']); ?>
<?php endif; ?>
