<?php
// Charger le contenu du fichier JSON
$jsonContent = file_get_contents('./version.json');
$routes = json_decode($jsonContent, true);

if ($routes === null) {
    $versionSite = "ERR";
}else {
    $versionSite = $routes['version'];
}

?>

<link rel="stylesheet" href="<?= SITE_HTTP."://".SITE_URL ?>/css/admin.css">
<script>
	document.title = "Administration - Dashboard";
</script>

<div id="dashboard">
    <div class="dashboard-block dashboard-menu">
        <a class="menu-link" href="/"><i class="fas fa-home"></i> Accueil de LUMA</a>
        <a class="menu-link" href="/admin/routes"><i class="fa-solid fa-route"></i> Gestion des routes</a>
        <a class="menu-link" style="background-color: grey;" href="#"><i class="fas fa-cogs"></i> Gestion des BDD</a>
        <a class="menu-link" style="background-color: grey;" href="#"><i class="fas fa-cogs"></i> Gestion des utilisateurs</a>
    </div>

    <div class="dashboard-block">
        <h2>Statut du Serveur</h2>
        <div id="server-status">
            <div class="monitoring"><i class="fa-solid fa-microchip"></i><span>***</span></div>
            <div class="monitoring"><i class="fa-solid fa-memory"></i><span>***</span></div>
        </div>
        <p>Information indisponible</p>
    </div>

    <div class="dashboard-block">
        <h2>Version du Site</h2>
        <p>Version actuelle: <?= $versionSite ?></p>
        <button id="update-button">Mise à jour</button>
    </div>
</div>