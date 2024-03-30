<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    extract($_REQUEST);

    require './lib/mysql_table_update.php';
    require './lib/mysql_table_add.php';
    require './lib/mysql_table_select.php';
    require './lib/mysql_table_delete.php';

    $selectedOption = htmlspecialchars(trim($selectedOption));
    $selectedName = htmlspecialchars(trim($selectedName));
    $inputName = htmlspecialchars(trim($inputName));
    $tableName = "luma_statut";

    if ($selectedName == 'delete') {
        $condition = "service = '$inputName'";
        echo deleteDataPDO($tableName, $condition, $pdo);
        exit;
    }

    if ($selectedName == "srv_service") {
        // Vérification de la présence du service
        $criteria = [
            'service' => $inputName
        ];
        $rowExists = checkRowExistence($tableName, $criteria, $pdo);
        if ($rowExists === true) {
            echo "exist";
        } elseif ($rowExists === false) {
            // Création du service
            $data = [
                'service' => $inputName,
                'uuid_agent' => $selectedOption
            ];
            echo insertDataPDO($tableName, $data, $pdo);
        } else {
            echo $rowExists; // Affiche un message d'erreur

        }
    } else {
        // Vérification de la présence du service
        $criteria = [
            'service' => $inputName
        ];
        $rowExists = checkRowExistence($tableName, $criteria, $pdo);
        if ($rowExists === true) {
            $data = [
                'uuid_agent' => $selectedOption
            ];
            $condition = "service = '$inputName'";
            echo updateDataPDO($tableName, $data, $pdo, $condition);
        } elseif ($rowExists === false) {
            echo "not-found";
        } else {
            echo $rowExists; // Affiche un message d'erreur
        }
    }
}
