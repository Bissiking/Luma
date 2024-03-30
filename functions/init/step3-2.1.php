<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extraction des données
    extract($_REQUEST);
    require './lib/initConf.php';

    // Création des variables
    $DB_HOST = htmlspecialchars(trim($DB_HOST));
    $DB_PORT = htmlspecialchars(trim($DB_PORT));
    $DB_NAME = htmlspecialchars(trim($DB_NAME));
    $DB_USER = htmlspecialchars(trim($DB_USER));
    if (!isset($DB_PASSWORD)) {
        $DB_PASSWORD = urldecode($DB_PASSWORD);
    }

    // Création de la SESSION "skip"
    $_SESSION['skip'] = 0;

    try {

        // Configuration pour afficher les erreurs de PDO
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Requête SQL pour récupérer la liste des tables
        $requeteSQL = "SHOW TABLES";
        // Exécution de la requête
        $resultat = $pdo->query($requeteSQL);
        $tablesSQL = $resultat->fetchAll(PDO::FETCH_COLUMN);

        if (in_array('luma_routes', $tablesSQL)) {

            $response = array(
                'tables' => $tablesSQL,
                'nextStep' => "step3-3.1",
                'textStats' => "Ajout des routes principales",
                'totalStep' => "1",
                'resultat' => 'warning',
                'message' => 'Table déjà existante'
            );
        } else {

            // New create table
            require './lib/mysql_table_create.php';

            $tableName = "luma_routes";
            $columns = [
                'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
                'routeName' => ' VARCHAR(255) NOT NULL',
                'url_pattern' => ' VARCHAR(255) NOT NULL',
                'controller' => ' VARCHAR(255) NOT NULL',
                'action' => ' VARCHAR(255) NOT NULL',
                'url_domain' => ' VARCHAR(255) NOT NULL',
                'active' => 'TINYINT(1) NOT NULL DEFAULT 0'
            ];

            $result_PDO = createTablePDO($tableName, $columns, $pdo);

            if ($result_PDO == 'succes'):
                $response = array(
                    'result_PDO' => $result_PDO,
                    'tables' => $tablesSQL,
                    'nextStep' => "step3-3.1",
                    'textStats' => "Ajout des routes principales",
                    'totalStep' => "1.1",
                    'resultat' => 'succes',
                    'message' => 'Créaiton de la table OK'
                );
            else:
                $response = array(
                    'result_PDO' => $result_PDO,
                    'tables' => $tablesSQL,
                    'nextStep' => "step3-2.1",
                    'textStats' => "Ajout des routes principales",
                    'totalStep' => "1.1",
                    'resultat' => 'error',
                    'message' => 'Echec de la création de la table'
                );
            endif;
        }
    } catch (PDOException $e) {

        $response = array(
            'nextStep' => "step3-2.1",
            'totalStep' => "3",
            'resultat' => 'error',
            'message' => 'Echec de la création',
            'PDO' => $e->getMessage()
        );
    }

    echo json_encode($response);
}
