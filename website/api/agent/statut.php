<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require 'base/nexus_base.php';
    require 'lib/mysql_table_select.php';
    $json = file_get_contents('php://input');

    // Convertir le JSON en tableau associatif
    $data = json_decode($json, true);

    if ($data !== null) {
        $uuid = $data['result']['uuid'];
        $processName = $data['result']['processName'];
        var_dump($data['result']['uuid']);
        $tableName = 'luma_agent'; // Choix de la table
        $criteria = [
            'uuid_agent' => $uuid,
        ];
        $rowExists = checkRowExistence($tableName, $criteria, $pdo);
        if ($rowExists === true) {
            // correspondance
            // Chemin du fichier JSON
            $filePath = $processName.'-data.json';
            $agentDocs = "data/$uuid";
            
            // Convertir les données en format JSON
            $jsonData = json_encode($data, JSON_PRETTY_PRINT);

            // Vérification de la présence du dossier
            if (!is_dir($agentDocs)) {
                if (!mkdir($agentDocs, 0777)) {
                    header('Content-Type: application/json');
                    echo json_encode(['ERROR' => 'ECHEC DOCS CREATE']);
                    exit;
                }
            }

            // Écrire les données JSON dans un fichier
            if (file_put_contents($agentDocs.'/'.$filePath, $jsonData)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false]);
            }
        } elseif ($rowExists === false) {
            // Aucune correspondance
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Agent No-Exist']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'ECHEC-PDO']);
        }
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
