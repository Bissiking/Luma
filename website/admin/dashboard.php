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

?>
    <script>
        document.title = "Administration - Dashboard";
    </script>

    <div id="dashboard">
        <div class="dashboard-block dashboard-menu">
            <a class="menu-link" href="/"><i class="fas fa-home"></i> Accueil de LUMA</a>
            <a class="menu-link" href="/admin/routes"><i class="fa-solid fa-route"></i> Gestion des routes</a>
            <a class="menu-link" href="/admin/bdd"><i class="fas fa-cogs"></i> Gestion des BDD</a>
            <a class="menu-link" href="/admin/users"><i class="fa-solid fa-users"></i> Gestion des utilisateurs</a>
        </div>
        <div class="dashboard-block dashboard-menu">
            <a class="menu-link" href="/admin/domains"><i class="fa-solid fa-globe"></i> Gestion des domaines</a>
            <a class="menu-link" href="#"><i class="fa-solid fa-ban"></i> EMPTY</a>
            <a class="menu-link" href="#"><i class="fa-solid fa-ban"></i> EMPTY</a>
            <a class="menu-link" href="#"><i class="fa-solid fa-ban"></i> EMPTY</a>
        </div>

        <div class="dashboard-block">
            <h2>Statut du Serveur</h2>
            <div id="server-status">
                <div class="monitoring"><i class="fa-solid fa-microchip"></i><span id="CPU_moni">***</span></div>
                <div class="monitoring"><i class="fa-solid fa-memory"></i><span id="RAM_moni">***</span></div>
            </div>
            <p class="date_moni">Dernière mise à jour: <span id="last_update_moni">***</span></p>
        </div>
        <div class="dashboard-block">
            <h2>Version du Site</h2>
            <p>Version actuelle: <span id="Ver_Actuelle"><?= $versionSite ?></span></p>
            <p id="updateText">Recherche en cours</p>
            <button onclick="UpdateWebsite()" id="updateButton">***</button>
        </div>
    </div>

    <script src="javascripts/admin/dashboard.js?2"></script>

<?php else : header('Location: /');
endif; ?>