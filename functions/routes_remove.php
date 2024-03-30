<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require './base/nexus_base.php';
    require './lib/mysql_table_delete.php';
    extract($_REQUEST);
    $url_pattern = htmlspecialchars(trim($url_pattern));


    if ($url_pattern === '/admin/routes') {
        echo 'refused-delete-route';
        exit();
    }

    // Valeur à supprimer
    $tableName = 'luma_routes';

    $condition = "url_pattern = '$url_pattern'"; // Condition de suppression, par exemple : 'id = ?' où ? est remplacé par la valeur de l'identifiant à supprimer

    $deletePDO = deleteDataPDO($tableName, $condition, $pdo);
    echo $deletePDO;
}
