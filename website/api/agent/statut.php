<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require 'base/nexus_base.php';
    require 'lib/mysql_table_select.php';
    require 'lib/mysql_table_update.php';
    $json = file_get_contents('php://input');

    // Convertir le JSON en tableau associatif
    $data = json_decode($json, true);
    if ($data !== null) {

        if (isset($data['config']) && $data['config'] == true) {
            // Vérification de la présence de l'agent
            $tableName = "luma_agent";
            $criteria = [
                'uuid_agent' => $data['uuid']
            ];
            $rowExists = checkRowExistence($tableName, $criteria, $pdo);
            if ($rowExists === true) {

                // Récupération des datas agents
                $sql = 'SELECT * FROM luma_agent WHERE uuid_agent = :uuid_agent';
                $req = $pdo->prepare($sql);
                $req->bindParam(':uuid_agent', $data['uuid']);
                $req->execute();
                $agent = $req->fetch(PDO::FETCH_ASSOC);

                // Mise à jour de l'agent dans l'interface
                // Exemple d'utilisation :
                $dataPDO = [
                    'agent_etat' => 1
                ];
                $condition = "uuid_agent = '".$data['uuid']."'";

                // Utilisation de la fonction pour mettre à jour les données
                $update = updateDataPDO($tableName, $dataPDO, $pdo, $condition);
                if ($update == 'succes') {
                    // Envoie de la config à l'agent
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true,
                        'data' => $agent
                    ]);
                    exit;
                }
                // Envoie de la config à l'agent
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'PDO ERR' => $update
                ]);
            } elseif ($rowExists === false) {
                // Non identifié
                header('Content-Type: application/json');
                echo json_encode(['success' => false]);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['ERROR' => 'STOP: ' . $rowExists]);
            }
        } else {
            $uuid = $data['result']['uuid'];
            $processName = $data['result']['processName'];
            $tableName = 'luma_agent';
            $criteria = [
                'uuid_agent' => $uuid,
            ];
            $rowExists = checkRowExistence($tableName, $criteria, $pdo);
            if ($rowExists === true) {
                // correspondance
                // Chemin du fichier JSON
                $filePath = $processName . '-data.json';
                $agentDocs = "data/$uuid";

                // Convertir les données en format JSON
                $jsonData = json_encode($data, JSON_PRETTY_PRINT);

                // Vérification de la présence du dossier
                if (!is_dir($agentDocs)) {
                    if (!mkdir($agentDocs, 0777, true)) {
                        header('Content-Type: application/json');
                        echo json_encode(['ERROR' => 'ECHEC DOCS CREATE - SRV']);
                        exit;
                    }
                }

                // Écrire les données JSON dans un fichier
                if (file_put_contents($agentDocs . '/' . $filePath, $jsonData)) {
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
