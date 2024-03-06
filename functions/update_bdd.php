<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Exctraction
    extract($_REQUEST);
    require_once 'base/nexus_base.php';
    require_once 'base/config.php';

    // FUNCTIONS
    function ConstEdit($BDD_CONST, $BDD_CONST_VAL)
    {
        // Charger le contenu du fichier JSON
        $DB_VERS_JSON = json_decode(file_get_contents('base/DB_VERSION.json'), true);

        if ($DB_VERS_JSON === null) {
            echo 'Récupération du Manifest des BDD impossible.';
            exit();
        }
        // Le nom du fichier à modifier
        $nomFichier = 'base/config.php';
        // Lire le contenu du fichier
        $contenuFichier = file_get_contents($nomFichier);
        // Effectuer la modification souhaitée
        $NewDBVer = $DB_VERS_JSON["$BDD_CONST"]['version_dispo'];
        $contenuModifie = str_replace(
            "define('$BDD_CONST', '$BDD_CONST_VAL');",
            "define('$BDD_CONST', '$NewDBVer');",
            $contenuFichier
        );
        // Écrire le nouveau contenu dans le fichier
        file_put_contents($nomFichier, $contenuModifie);
    }

    // SWITCH DE CHOIX DE BDD
    switch ($bdd) {
        case 'luma_users':
            $columnsToAdd = [
                "email VARCHAR(255) NULL",
                "emailValid TINYINT(1) NOT NULL DEFAULT 0",
                "emailToken VARCHAR(255) NULL",
            ];

            $BDD_CONST = "DB_LUMA_USERS_VERSION";
            $BDD_CONST_VAL = DB_LUMA_USERS_VERSION;
            break;

        case 'luma_routes':
            $columnsToAdd = [
                "email VARCHAR(255) NULL",
            ];
            $BDD_CONST = "DB_LUMA_ROUTES_VERSION";
            $BDD_CONST_VAL = DB_LUMA_ROUTES_VERSION;
            break;

        case 'luma_nino_data':
            $columnsToAdd = [
                "status VARCHAR(255) NULL",
                "nino_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
            ];
            $BDD_CONST = "DB_LUMA_NINO_DATA_VERSION";
            $BDD_CONST_VAL = DB_LUMA_NINO_DATA_VERSION;

            // Modification de la table de Nino
            if (DB_LUMA_NINO_DATA_VERSION <= "DB02") {
                try {
                    // Définir le mode d'erreur de PDO sur Exception
                    $sql = "ALTER TABLE luma_nino_data MODIFY COLUMN tag VARCHAR(255)";
                    if ($pdo->query($sql) !== TRUE) {
                        $pdo->errorInfo();
                    };
                } catch (PDOException $e) {
                    echo 'configCreateTableNino-echec --> ' . $e->getMessage();
                }
            }

            if (DB_LUMA_NINO_DATA_VERSION <= "DB03") {
                try {
                    // Définir le mode d'erreur de PDO sur Exception
                    $sql = "ALTER TABLE luma_nino_data MODIFY COLUMN description TEXT";
                    if ($pdo->query($sql) !== TRUE) {
                        $pdo->errorInfo();
                    };
                } catch (PDOException $e) {
                    echo 'configEditTableNino-echec --> ' . $e->getMessage();
                }
            }

            if (DB_LUMA_NINO_DATA_VERSION <= "DB04") {
                // Création de la table DOMAINS
                try {
                    // Définir le mode d'erreur de PDO sur Exception
                    $sql = "ALTER TABLE luma_nino_data MODIFY COLUMN tag TEXT";
                    if ($pdo->query($sql) !== TRUE) {
                        $pdo->errorInfo();
                    };
                } catch (PDOException $e) {
                    echo 'configEditTableNino-echec --> ' . $e->getMessage();
                }
            }

            if (DB_LUMA_NINO_DATA_VERSION <= "DB05") {
                $columnsToAdd = [
                    "publish TIMESTAMP NULL",
                    "`create` TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
                ];
                $BDD_CONST = "DB_LUMA_NINO_DATA_VERSION";
                $BDD_CONST_VAL = DB_LUMA_NINO_DATA_VERSION;
            }
            break;

        case 'luma_domains':
            if (DB_LUMA_DOMAINS_VERSION == "DB00") {
                // Création de la table DOMAINS
                try {
                    // Définir le mode d'erreur de PDO sur Exception
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Requête de création de table
                    $query = "CREATE TABLE IF NOT EXISTS luma_domains (
                        id INT PRIMARY KEY AUTO_INCREMENT,
                        domains VARCHAR(255) NOT NULL,
                        domains_autorized TINYINT(4) NULL
                    )";
                    // Exécution de la requête
                    $pdo->exec($query);
                    $BDD_CONST = "DB_LUMA_DOMAINS_VERSION";
                    $BDD_CONST_VAL = DB_LUMA_DOMAINS_VERSION;
                    ConstEdit($BDD_CONST, $BDD_CONST_VAL);
                    echo 'succes';
                    exit;
                } catch (PDOException $e) {
                    echo 'configCreateTableDomains-echec --> ' . $e->getMessage();
                    exit;
                }
            } else {
                $columnsToAdd = [
                    "domains VARCHAR(255) NOT NULL",
                    "domains_autorized TINYINT(4) NULL"
                ];

                $BDD_CONST = "DB_LUMA_DOMAINS_VERSION";
                $BDD_CONST_VAL = DB_LUMA_DOMAINS_VERSION;
                ConstEdit($BDD_CONST, $BDD_CONST_VAL);
            };

            break;

        case 'luma_agent':
            if (DB_LUMA_AGENT_VERSION == "DB00") {
                // Création de la table AGENT
                try {
                    require './lib/mysql_table_create.php';

                    $tableName = "luma_agent";
                    $columns = [
                        'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
                        'id_users' => 'BIGINT(20) NOT NULL',
                        'uuid_agent' => 'VARCHAR(255) NOT NULL',
                        'agent_name' => 'VARCHAR(255) NULL',
                        'agent_etat' => 'TINYINT(4) NOT NULL DEFAULT 0',
                        'token' => 'VARCHAR(255) NULL',
                        'users_autorized' => 'VARCHAR(255) NULL',
                        'agent_create' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
                        'agent_edit' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
                    ];
                    $result_PDO = createTablePDO($tableName, $columns, $pdo);

                    // Requête de UPDATE auto
                    $query = "CREATE TRIGGER IF NOT EXISTS update_agent_edit
                                BEFORE UPDATE ON luma_agent
                                FOR EACH ROW
                                SET NEW.agent_edit = CURRENT_TIMESTAMP;";

                    // Exécution de la requête
                    $pdo->exec($query);

                    $BDD_CONST = "DB_LUMA_AGENT_VERSION";
                    $BDD_CONST_VAL = DB_LUMA_AGENT_VERSION;
                    ConstEdit($BDD_CONST, $BDD_CONST_VAL);

                    echo $result_PDO;
                    exit;
                } catch (PDOException $e) {
                    echo 'configCreateTableAgent-echec --> ' . $e->getMessage();
                    exit;
                }
            };

            break;

        default:
            echo "error -> STOP CODE #001";
            exit;
    }

    // Générez la partie SET de la requête ALTER TABLE
    try {
        // Vérifier l'existence de chaque colonne avant de l'ajouter
        foreach ($columnsToAdd as $columnDefinition) {
            $columnName = explode(" ", $columnDefinition)[0];

            $checkColumnQuery = "SHOW COLUMNS FROM $bdd LIKE '$columnName'";
            $checkColumnResult = $pdo->query($checkColumnQuery);

            if ($checkColumnResult->rowCount() === 0) {
                // La colonne n'existe pas, on peut l'ajouter
                $alterTableQuery = "ALTER TABLE $bdd ADD $columnDefinition";

                if (!$pdo->query($alterTableQuery)) {
                    $errorInfo = $pdo->errorInfo();
                    echo "Erreur lors de l'ajout de la colonne $columnName : " . $errorInfo[2];
                }
            }
        }
        // Edition de la CONSTANTE
        ConstEdit($BDD_CONST, $BDD_CONST_VAL);
        echo 'succes';
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
}
