<?php
// 1) Connexion à la base de données avec PDO
$host = 'localhost';
$dbname = 'vote_electronique_db';
$username = 'root'; // À adapter selon ton environnement (XAMPP/WAMP)
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Activer les exceptions pour mieux gérer les erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>