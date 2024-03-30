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

    if (in_array('luma_nino_data', $tablesSQL)) {

        $response = array(
            'nextStep' => "step3-8.1",
            'textStats' => "Création de la table domains",
            'totalStep' => "1",
            'resultat' => 'warning',
            'message' => 'Table déjà existante'
        );
    } else {
        // Création de la table users et des users
        try {
            // New create table
            require './lib/mysql_table_create.php';

            $tableName = "luma_nino_data";
            $columns = [
                'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
                'id_video_uuid' => 'VARCHAR(255) NULL',
                'id_users' => 'BIGINT(20) NULL',
                'titre' => 'VARCHAR(255) NULL',
                'description' => 'TEXT NULL',
                'videoThumbnail' => 'VARCHAR(255) NULL',
                'tag' => 'VARCHAR(255) NULL',
                'server_url' => 'VARCHAR(255) NULL',
                'status' => 'VARCHAR(255) NULL',
                'nino_create' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
                'edit' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            ];

            $result_PDO = createTablePDO($tableName, $columns, $pdo);

            // Création du déclancheur de mise à jour
            $query = "
				CREATE TRIGGER IF NOT EXISTS update_edit
				BEFORE UPDATE ON luma_nino_data
				FOR EACH ROW
				SET NEW.edit = CURRENT_TIMESTAMP;
			";

            // Exécution de la requête
            $pdo->exec($query);

            if ($result_PDO == 'succes') :
                $response = array(
                    'result_PDO' => $result_PDO,
                    'tables' => $tablesSQL,
                    'nextStep' => "step3-7.1",
                    'textStats' => "Création de la table des domaines",
                    'totalStep' => "1.1",
                    'resultat' => 'succes',
                    'message' => 'Créaiton de la table OK'
                );
            else :
                $response = array(
                    'result_PDO' => $result_PDO,
                    'tables' => $tablesSQL,
                    'nextStep' => "step3-6.1",
                    'textStats' => "Création de la table des domaines",
                    'totalStep' => "1.1",
                    'resultat' => 'error',
                    'message' => 'Echec de la création de la table'
                );
            endif;

        } catch (PDOException $e) {
            $response = array(
                'nextStep' => "step3-6.1",
                'textStats' => "Création de la table des domaines",
                'totalStep' => "1",
                'resultat' => 'error',
                'message' => 'Créaction de la table ECHEC',
                'PDO' => $e->getMessage(),
            );
        }
    }
    echo json_encode($response);
}
