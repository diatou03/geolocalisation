<?php
$host = '127.0.0.1';
$db   = 'geo';         // ← Mets ici le vrai nom de ta base
$user = 'root';            // ← Mets ici ton nom d'utilisateur (souvent "root")
$pass = '';           // ← Mets ici ton mot de passe MySQL
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     echo "Connexion réussie";
} catch (\PDOException $e) {
     echo "Erreur : " . $e->getMessage();
}
?>
