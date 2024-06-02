<?php
extract($_REQUEST); // Extraction des valeurs JS

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require 'base/nexus_base.php';
    require 'lib/mysql_table_add.php';
    require 'lib/mysql_table_select.php';

    // Nettoyage variable
    $agent_name = htmlspecialchars(trim($agent_name));
    // Vérification si les champs sont vides
    if (!isset($agent_name) || $agent_name == "") {
        echo 'empty';
        exit;
    }

    require './lib/uuid_gen.php';
    $uuid = generateUUID();

    // Exemple d'utilisation
    $tableName = 'luma_agent'; // Choix de la table
    $criteria = [
        'agent_name' => $agent_name,
        'id_users' => $_SESSION['authentification']['user']['id']
    ];
    $rowExists = checkRowExistence($tableName, $criteria, $pdo);
    if ($rowExists === true) {
        // correspondance
        echo "exist";
    } elseif ($rowExists === false) {   
        // Aucune correspondance
        $data = [
            'uuid_agent' => $uuid,
            'id_users' => $_SESSION['authentification']['user']['id'],
            'agent_name' => $agent_name,
            'module' => $module,
        ];

        $PDO = insertDataPDO($tableName, $data, $pdo);
        echo $PDO;
    } else {
        echo $rowExists; // Affiche un message d'erreur
    }
}
