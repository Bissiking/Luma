<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extraction des données
    extract($_REQUEST);
    require './lib/initConf.php';

    // Configuration pour afficher les erreurs de PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Requête SQL pour récupérer la liste des tables
    $requeteSQL = "SHOW TABLES";
    // Exécution de la requête
    $resultat = $pdo->query($requeteSQL);
    $tablesSQL = $resultat->fetchAll(PDO::FETCH_COLUMN);

    if (in_array('luma_domains', $tablesSQL)) {

        $response = array(
            'nextStep' => "step3-9.1",
            'textStats' => "Création du fichier",
            'totalStep' => "1",
            'resultat' => 'warning',
            'message' => 'Table déjà existante'
        );
    } else {
        // Création de la table users et des users
        try {
            require './lib/mysql_table_create.php';

            $tableName = "luma_domains";
            $columns = [
                'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
                'domains' => 'VARCHAR(255) NULL',
                'domains_autorized' => 'VARCHAR(255) NULL',
            ];
            $result_PDO = createTablePDO($tableName, $columns, $pdo);

            $response = array(
                'nextStep' => "step3-8.1",
                'textStats' => "Création du fichier",
                'totalStep' => "1",
                'resultat' => 'succes',
                'message' => 'Création de la table OK'
            );
        } catch (PDOException $e) {
            $response = array(
                'nextStep' => "step3-7.1",
                'textStats' => "Création du fichier",
                'totalStep' => "1",
                'resultat' => 'error',
                'message' => 'Créaction de la table ECHEC',
                'PDO' => $e->getMessage(),
            );
        }
    }
    echo json_encode($response);
}
