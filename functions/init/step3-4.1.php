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

    if (in_array('luma_users', $tablesSQL)) {

        $response = array(
            'nextStep' => "step3-5.1",
            'textStats' => "Création du compte système",
            'totalStep' => "1",
            'resultat' => 'warning',
            'message' => 'Table déjà existante'
        );
        $_SESSION['skip'] = 1;
    } else {
        // Création de la table users et des users
        try {
            // New create table
            require './lib/mysql_table_create.php';

            $tableName = "luma_users";
            $columns = [
                'id' => 'BIGINT(20) PRIMARY KEY AUTO_INCREMENT',
                'identifiant' => 'VARCHAR(255) NOT NULL',
                'password' => 'VARCHAR(255) NOT NULL',
                'account_administrator' => 'TINYINT(4) NOT NULL DEFAULT 0',
                'account_system' => 'TINYINT(4) NOT NULL DEFAULT 0',
                'users_domain' => ' VARCHAR(255) NOT NULL',
                'nomComplet' => 'VARCHAR(255) NULL',
                'groupeAcces' => 'VARCHAR(255) NULL',
                'account_create' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
                'account_edit' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
            ];

            $result_PDO = createTablePDO($tableName, $columns, $pdo);

            // Requête de UPDATE auto
            $query = "CREATE TRIGGER IF NOT EXISTS update_account_edit
                        BEFORE UPDATE ON luma_users
                        FOR EACH ROW
                        SET NEW.account_edit = CURRENT_TIMESTAMP;";

            // Exécution de la requête
            $pdo->exec($query);

            if ($result_PDO == 'succes') :
                $response = array(
                    'result_PDO' => $result_PDO,
                    'tables' => $tablesSQL,
                    'nextStep' => "step3-5.1",
                    'textStats' => "Ajout des users",
                    'totalStep' => "1.1",
                    'resultat' => 'succes',
                    'message' => 'Créaiton de la table OK'
                );
            else :
                $response = array(
                    'result_PDO' => $result_PDO,
                    'tables' => $tablesSQL,
                    'nextStep' => "step3-4.1",
                    'textStats' => "Ajout des users",
                    'totalStep' => "1.1",
                    'resultat' => 'error',
                    'message' => 'Echec de la création de la table'
                );
            endif;
        } catch (PDOException $e) {
            $response = array(
                'nextStep' => "step3-4.1",
                'textStats' => "Ajout du user 'system'",
                'totalStep' => "1",
                'resultat' => 'error',
                'message' => 'Créaction de la table ECHEC',
                'PDO' => $e->getMessage(),
            );
        }
    }
    echo json_encode($response);
}
