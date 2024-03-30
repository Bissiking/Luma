<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    // Récupération des données JSON
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
 
    // Extraction des identifiants
    $identifiant = isset($data['identifiant']) ? $data['identifiant'] : null;
    $password = isset($data['password']) ? $data['password'] : null;

    // Vérification si les champs sont vides
    if (empty($identifiant) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'ID ou mot de passe vide', 'data' => $data]);
        exit;
    }

    // Connexion à MySQL
    require 'base/nexus_base.php';

    // Requête pour récupérer le mot de passe hashé depuis la base de données
    $sql = 'SELECT * FROM luma_users WHERE identifiant = :identifiant';
    $req = $pdo->prepare($sql);
    $req->execute(['identifiant' => $identifiant]);
    $user = $req->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Vérification du mot de passe et création de la session
        if (password_verify($password, $user['password'])) {
            echo json_encode(['success' => true, 'message' => 'Connexion réussie', 'dataUser' => $user]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Identifiant ou Mot de passe incorrect --', 'data' => $data]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Identifiant ou Mot de passe incorrect -']);
    }
} else {
    echo json_encode(['error' => false, 'message' => 'POST UNIQUEMENT']);
}