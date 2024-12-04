<?php
$host = "autorack.proxy.rlwy.net";
$dbname = "railway"; 
$username = "root"; 
$port = 25854; 
$password = "iYiEPlaLZWrPgApaembWkybjYVoetKrs";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
