<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Exctraction
    extract($_REQUEST);
    require_once 'base/nexus_base.php';
    require_once 'base/config.php';
    require 'lib/mysql_table_update.php';

    $id = htmlspecialchars(trim($id));
    $etat = htmlspecialchars(trim($etat));

    $tableName = 'luma_agent';
    $dataPDO = [
        "$id" => $etat
    ];
    $condition = "uuid_agent = '".$uuid_agent."'";
    
    // Utilisation de la fonction pour mettre à jour les données
    $update = updateDataPDO($tableName, $dataPDO, $pdo, $condition);

    $response = array(
        'resultat' => $update,
        'REQUEST' => $_REQUEST
    );
    echo json_encode($response);
}


