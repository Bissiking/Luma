<?php

// ATTENTE CREATION TOKEN ET AUTRES INFORMATIONS



// Assurez-vous de sécuriser votre API selon vos besoins (par exemple, en utilisant une authentification appropriée)

// Accepter uniquement les requêtes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer le contenu JSON de la requête
    $json = file_get_contents('php://input');

    // Convertir le JSON en tableau associatif
    $data = json_decode($json, true);

    if ($data !== null) {
        // Vous avez maintenant les données du fichier JSON dans le tableau $data
        // Faites ce que vous devez faire avec les données (par exemple, enregistrez-les en base de données)

        // Répondre avec un message de succès
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    } else {
        // En cas d'erreur de décodage JSON
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Invalid JSON']);
    }
} else {
    // Répondre aux autres méthodes HTTP avec une erreur
    header('HTTP/1.1 405 Method Not Allowed');
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Method Not Allowed']);
}
