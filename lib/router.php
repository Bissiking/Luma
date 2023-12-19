<?php
var_dump($_SESSION);
// router.php
$url = $_SERVER['REQUEST_URI'];

// Connectez-vous à votre base de données ici
require_once 'base/nexus_base.php';

// Requête SQL pour récupérer les informations de routage
try {
    $query = "SELECT * FROM routes WHERE url_pattern = :url";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':url', $url);
    $stmt->execute();
    $route = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() == 0) {
        header("Location: /initialisation");
        exit();
    }
} catch (Exception $e) {
    // Gérer d'autres exceptions
    echo "An unexpected error occurred: " . $e->getMessage();
}