<?php
if ($_SESSION['authentification']['user']['account_administrator'] !== 1) {
    header('Location: /');
}

// Ajout des versions de BASE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ouvrir le fichier en mode écriture (ajout)
    $file = fopen('base/config.php', 'a+');

    if (!defined("DB_LUMA_USERS_VERSION")) {
        fwrite($file, "\ndefine('DB_LUMA_USERS_VERSION', 'DB01');\n");
    }

    if (!defined("DB_LUMA_USERS_VERSION")) {
        fwrite($file, "define('DB_LUMA_ROUTES_VERSION', 'DB01');\n");
    }

    if (!defined("DB_LUMA_USERS_VERSION")) {
        fwrite($file, "define('DB_LUMA_NINO_DATA_VERSION', 'DB01');\n");
    }

    if (!defined("DB_LUMA_DOMAINS_VERSION")) {
        fwrite($file, "define('DB_LUMA_DOMAINS_VERSION', 'DB00');\n");
    }

    if (!defined("DB_LUMA_AGENT_VERSION")) {
        fwrite($file, "define('DB_LUMA_AGENT_VERSION', 'DB00');\n");
    }

    if (!defined("DB_LUMA_STATUT_VERSION")) {
        fwrite($file, "define('DB_LUMA_STATUT_VERSION', 'DB00');\n");
    }

    if (!defined("DB_LUMA_LOGS")) {
        fwrite($file, "define('DB_LUMA_LOGS', 'DB00');\n");
    }


    // Fermer le fichier
    fclose($file);
    echo 'succes';
}


// Charger le contenu du fichier JSON
$DB_VERS_JSON = json_decode(file_get_contents('./base/DB_VERSION.json'), true);

if ($DB_VERS_JSON === null) {
    echo 'Récupération du Manifest des BDD impossible.';
    exit();
} else {
    require './base/nexus_base.php';
    // Configuration pour afficher les erreurs de PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Requête SQL pour récupérer la liste des tables
    $requeteSQL = "SHOW TABLES";
    // Exécution de la requête
    $resultat = $pdo->query($requeteSQL);
    $tablesSQL = $resultat->fetchAll(PDO::FETCH_COLUMN);
}

?>
<script>
    document.title = "Administration - Base de donnée";
</script>

<!-- <pre><?= print_r($_SESSION) ?></pre> -->

<table>
    <thead>
        <tr>
            <th>Nom de la table</th>
            <th>Version de la table/JSON</th>
            <th>Option</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Afficher les tables présentes dans le JSON mais absentes du résultat SQL
        foreach ($DB_VERS_JSON as $tableJson) {
            $tableName = $tableJson['DB_USE'];
            if (!in_array($tableName, $tablesSQL)) {
                // Afficher ces tables
        ?>
                <tr>
                    <td><?= $tableName; ?></td>
                    <td>
                        <?php if (!defined($tableJson['DB_NAME'])) : ?>
                            Version non trouvé
                        <?php elseif (constant($tableJson['DB_NAME']) == $tableJson['version_dispo']) : ?>
                            <?= constant($tableJson['DB_NAME']) . ' - ' . $tableJson['version_dispo'] ?>
                        <?php else : ?>
                            Mise à jour disponible<br /><?= constant($tableJson['DB_NAME']) . ' => ' . $tableJson['version_dispo'] ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!defined($tableJson['DB_NAME'])) : ?>
                            <button class="UPBDDVer" data-BDD="<?= $tableName ?>">Mettre à jour</button>
                        <?php elseif (constant($tableJson['DB_NAME']) == $tableJson['version_dispo']) : ?>
                            <button>Pas de mise à jour</button>
                        <?php else : ?>
                            <button class="update" data-BDD="<?= $tableName ?>">Mettre à jour</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php
            } else {
            ?>
                <tr>
                    <td><?= $tableName; ?></td>
                    <td>
                        <?php if (!defined($tableJson['DB_NAME'])) : ?>
                            Version non trouvé
                        <?php elseif (constant($tableJson['DB_NAME']) == $tableJson['version_dispo']) : ?>
                            <?= constant($tableJson['DB_NAME']) . ' - ' . $tableJson['version_dispo'] ?>
                        <?php else : ?>
                            Mise à jour disponible<br /><?= constant($tableJson['DB_NAME']) . ' => ' . $tableJson['version_dispo'] ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!defined($tableJson['DB_NAME'])) : ?>
                            <button class="UPBDDVer" data-BDD="<?= $tableName ?>">Mettre à jour</button>
                        <?php elseif (constant($tableJson['DB_NAME']) == $tableJson['version_dispo']) : ?>
                            <button>Pas de mise à jour</button>
                        <?php else : ?>
                            <button class="update" data-BDD="<?= $tableName ?>">Mettre à jour</button>
                        <?php endif; ?>
                    </td>
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>
<script src="/javascripts/admin/bdd.js?1"></script>