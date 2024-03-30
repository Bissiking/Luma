<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Extraction des données
    extract($_REQUEST);
    
    try {

        require_once './lib/initConf.php';
        $response = array(
            'nextStep' => "step3-2.1",
            'textStats' => "Création de la table",
            'totalStep' => "1",
            'resultat' => 'succes',
            'message' => 'Connexion OK'
        );
    } catch (PDOException $e) {
        $response = array(
            'nextStep' => "step3-1.1",
            'totalStep' => "1",
            'resultat' => 'error',
            'message' => 'Echec de connexion',
            'PDO' => $e->getMessage(),
            'PDO-REQ' => 'mysql:host=' . $DB_HOST . ':' . $DB_PORT . ';dbname=' . $DB_NAME . ';charset=utf8', $DB_USER, $DB_PASSWORD
        );
    }

    echo json_encode($response);
}
