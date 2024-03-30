<?php
if (isset($_SESSION['authentification']['user']['account_administrator']) && $_SESSION['authentification']['user']['account_administrator'] == 1) :

    // Charger le contenu du fichier JSON
    $jsonContent = file_get_contents('./version.json');
    $routes = json_decode($jsonContent, true);

    if ($routes === null) {
        $versionSite = "ERR";
    } else {
        $versionSite = $routes['version'];
    }

    // Vérification mise à jour BDD
    $DB_VERS_JSON = json_decode(file_get_contents('base/DB_VERSION.json'), true);

    if ($DB_VERS_JSON === null) {
        echo 'Récupération du Manifest des BDD impossible.';
        exit();
    } else {
        require 'base/nexus_base.php';
        // Configuration pour afficher les erreurs de PDO
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Requête SQL pour récupérer la liste des tables
        $requeteSQL = "SHOW TABLES";
        // Exécution de la requête
        $resultat = $pdo->query($requeteSQL);
        $tablesSQL = $resultat->fetchAll(PDO::FETCH_COLUMN);
        // Afficher les tables présentes dans le JSON mais absentes du résultat SQL
        $updateBDD = 0;
        foreach ($DB_VERS_JSON as $tableJson) {
            $tableName = $tableJson['DB_USE'];
            if (in_array($tableName, $tablesSQL)) {
                // Afficher ces tables
                if (!defined($tableJson['DB_NAME'])) {
                    $updateBDD += 1;
                } elseif (constant($tableJson['DB_NAME']) != $tableJson['version_dispo']) {
                    $updateBDD += 1;
                }
            }
        }
    }
?>
    <script>
        document.title = "Administration - Dashboard";
    </script>

    <div id="dashboard">
        <div class="dashboard-block dashboard-menu">
            <a class="menu-link" href="/"><i class="fas fa-home"></i> Accueil de LUMA</a>
            <a class="menu-link" href="/admin/routes"><i class="fa-solid fa-route"></i> Gestion des routes</a>
            <a class="menu-link" href="/admin/bdd"><i class="fas fa-cogs"></i> Gestion des BDD<?php if($updateBDD > 0): ?><span class="betaPops version_Update_Menu">Mise à jour disponible</span><?php endif; ?></a>
            <a class="menu-link" href="/admin/users"><i class="fa-solid fa-users"></i> Gestion des utilisateurs</a>
        </div>
        <div class="dashboard-block dashboard-menu">
            <a class="menu-link" href="/admin/domains"><i class="fa-solid fa-globe"></i> Gestion des domaines</a>
            <a class="menu-link" href="/admin/statut"><i class="fa-solid fa-list-check"></i> Configuration de la page statut</a>
            <a class="menu-link" href="#"><i class="fa-solid fa-ban"></i> EMPTY</a>
            <a class="menu-link" href="#"><i class="fa-solid fa-ban"></i> EMPTY</a>
        </div>

        <div class="dashboard-block">
            <h2>IN PROGRESS</h2>
            <p>En cours de développement</p>
        </div>
        <div class="dashboard-block">
            <h2>Version du Site</h2>
            <p>Version actuelle: <span id="Ver_Actuelle"><?= $versionSite ?></span></p>
            <p id="updateText">Recherche en cours</p>
            <button id="updateButton">***</button>
        </div>
    </div>

    <script src="javascripts/admin/dashboard.js?6"></script>

<?php else : header('Location: /');
endif; ?>