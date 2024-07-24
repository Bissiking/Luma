<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Exctraction
    extract($_REQUEST);
    $createTable = 0;
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
            $createTable = 1;
            $columnsToAdd = [
                "email VARCHAR(255) NULL",
                "emailValid TINYINT(1) NOT NULL DEFAULT 0",
                "emailToken VARCHAR(255) NULL",
                "master TINYINT(1) NULL",
                "users_master BIGINT(20) NULL",
                "iconsProfils VARCHAR(255) NULL DEFAULT 'default'"
            ];

            $BDD_CONST = "DB_LUMA_USERS_VERSION";
            $BDD_CONST_VAL = DB_LUMA_USERS_VERSION;

            break;

        case 'luma_routes':
            $createTable = 1;
            $columnsToAdd = [
                "email VARCHAR(255) NULL",
            ];
            $BDD_CONST = "DB_LUMA_ROUTES_VERSION";
            $BDD_CONST_VAL = DB_LUMA_ROUTES_VERSION;
            break;

        case 'luma_nino_data':

            // Modification Colonne TAG
            try {
                // Définir le mode d'erreur de PDO sur Exception
                $sql = "ALTER TABLE luma_nino_data MODIFY COLUMN tag TEXT";
                if ($pdo->query($sql) !== TRUE) {
                    $pdo->errorInfo();
                };
            } catch (PDOException $e) {
                echo 'configEditTableNino-echec --> ' . $e->getMessage();
            }

            // Modification Colonne DESCRIPTION
            try {
                // Définir le mode d'erreur de PDO sur Exception
                $sql = "ALTER TABLE luma_nino_data MODIFY COLUMN description TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
                if ($pdo->query($sql) !== TRUE) {
                    $pdo->errorInfo();
                };

                $sql = "ALTER TABLE luma_nino_data CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";
                if ($pdo->query($sql) !== TRUE) {
                    $pdo->errorInfo();
                };
            } catch (PDOException $e) {
                echo 'configEditTableNino-echec --> ' . $e->getMessage();
            }


            if (DB_LUMA_NINO_DATA_VERSION >= "DB06") {
                $createTable = 1;
                $columnsToAdd = [
                    "status VARCHAR(255) NULL",
                    "nino_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
                    "publish TIMESTAMP NULL",
                    "`create` TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
                ];
            }
            $BDD_CONST = "DB_LUMA_NINO_DATA_VERSION";
            $BDD_CONST_VAL = DB_LUMA_NINO_DATA_VERSION;



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
                $createTable = 1;
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

            // Création de la table AGENT
            try {
                require './lib/mysql_table_create.php';

                $tableName = "luma_agent";
                $BDD_CONST = "DB_LUMA_AGENT_VERSION";
                $BDD_CONST_VAL = DB_LUMA_AGENT_VERSION;

                if (DB_LUMA_AGENT_VERSION == "DB00") {
                    $columns = [
                        'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
                        'id_users' => 'BIGINT(20) NOT NULL',
                        'uuid_agent' => 'VARCHAR(255) NOT NULL',
                        'agent_name' => 'VARCHAR(255) NULL',
                        'agent_etat' => 'TINYINT(4) NOT NULL DEFAULT 0',
                        'agent_version' => 'VARCHAR(255) NOT NULL DEFAULT "0.0.0"',
                        'module' => 'VARCHAR(255) NOT NULL DEFAULT `agent_luma`',
                        'token' => 'VARCHAR(255) NULL',
                        'MemoryModule_autostart' => 'TINYINT(1) NOT NULL DEFAULT 1',
                        'MemoryModule_autorestart' => 'TINYINT(1) NOT NULL DEFAULT 0',
                        'ProcessorModule_autostart' => 'TINYINT(1) NOT NULL DEFAULT 1',
                        'ProcessorModule_autorestart' => 'TINYINT(1) NOT NULL DEFAULT 0',
                        'DiskModule_autostart' => 'TINYINT(1) NOT NULL DEFAULT 1',
                        'DiskModule_autorestart' => 'TINYINT(1) NOT NULL DEFAULT 1',
                        'PlexProcessCheck_autostart' => 'TINYINT(1) NOT NULL DEFAULT 0',
                        'PlexProcessCheck_autorestart' => 'TINYINT(1) NOT NULL DEFAULT 0',
                        'JellyFinProcessCheck_autostart' => 'TINYINT(1) NOT NULL DEFAULT 1',
                        'JellyFinProcessCheck_autorestart' => 'TINYINT(1) NOT NULL DEFAULT 0',
                        'DockerModule_autostart' => 'TINYINT(1) NOT NULL DEFAULT 1',
                        'DockerModule_autorestart' => 'TINYINT(1) NOT NULL DEFAULT 0',
                        'Minecraft_minMemory' => 'INT(4) NULL DEFAULT 1024',
                        'Minecraft_maxMemory' => 'INT(4) NULL DEFAULT 2048',
                        'BeamMPProcessCheck_autostart' => 'TINYINT(1) NOT NULL DEFAULT 0',
                        'BeamMPProcessCheck_autorestart' => 'TINYINT(1) NOT NULL DEFAULT 0',
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
                    echo $result_PDO;

                    exit;
                } else {
                    $createTable = 1;
                    $columnsToAdd = [
                        "module VARCHAR(255) NOT NULL DEFAULT ''",
                        "Minecraft_minMemory INT(4) NULL DEFAULT 1024", // Supprimer les quotes simples
                        "Minecraft_maxMemory INT(4) NULL DEFAULT 2048",
                        'BeamMPProcessCheck_autostart TINYINT(1) NOT NULL DEFAULT 0',
                        'BeamMPProcessCheck_autorestart TINYINT(1) NOT NULL DEFAULT 0'
                    ];
                }
            } catch (PDOException $e) {
                echo 'configCreateTableAgent-echec --> ' . $e->getMessage();
                exit;
            }


            break;

        case 'luma_statut':

            $tableName = "luma_statut";
            $BDD_CONST = "DB_LUMA_STATUT_VERSION";
            $BDD_CONST_VAL = DB_LUMA_STATUT_VERSION;

            // Création de la table STATUT
            try {
                if (DB_LUMA_STATUT_VERSION == "DB00") {
                    require './lib/mysql_table_create.php';

                    $columns = [
                        'id' => 'INT PRIMARY KEY AUTO_INCREMENT',
                        'service' => 'VARCHAR(255) NOT NULL',
                        'uuid_agent' => 'VARCHAR(255) NOT NULL',
                        'uuid_docker' => 'VARCHAR(255) NULL',
                    ];
                    $result_PDO = createTablePDO($tableName, $columns, $pdo);

                    echo $result_PDO;
                } else {

                    $createTable = 1;
                    $columnsToAdd = [
                        "uuid_docker varchar(255) NULL"
                    ];
                }
            } catch (PDOException $e) {
                echo 'configCreateTableSTATUT-echec --> ' . $e->getMessage();
                exit;
            }


            break;

        case 'luma_logs':

            $tableName = "luma_logs";
            $BDD_CONST = "DB_LUMA_LOGS";
            $BDD_CONST_VAL = DB_LUMA_LOGS;

            // Création de la table STATUT
            try {
                if (DB_LUMA_LOGS == "DB00") {
                    require './lib/mysql_table_create.php';


                    $columns = [
                        'id' => 'BIGINT PRIMARY KEY AUTO_INCREMENT',
                        'log_level' => 'VARCHAR(50) NOT NULL',
                        'log_message' => 'TEXT NOT NULL',
                        'username' => 'VARCHAR(255) DEFAULT \'système\'',
                        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
                    ];
                    $result_PDO = createTablePDO($tableName, $columns, $pdo);

                    echo $result_PDO;
                }
            } catch (PDOException $e) {
                echo 'configCreateTableSTATUT-echec --> ' . $e->getMessage();
                exit;
            }


            break;

        default:
            echo "error -> STOP CODE #001";
            exit;
    }

    // Générez la partie SET de la requête ALTER TABLE
    try {
        if ($createTable == 1) {
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
        }
        // Edition de la CONSTANTE
        ConstEdit($BDD_CONST, $BDD_CONST_VAL);
        echo 'succes';

        logMessage($pdo, 'INFO', 'Mise à jour de la base de donnée avec l\'utilisateur: '.getUserIdentifiant().'');

    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
}
