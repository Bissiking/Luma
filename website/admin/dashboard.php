<?php
if (isset($_SESSION['authentification']['user']['account_administrator']) && $_SESSION['authentification']['user']['account_administrator'] == 1):

// Charger le contenu du fichier JSON
$jsonContent = file_get_contents('./version.json');
$routes = json_decode($jsonContent, true);

if ($routes === null) {
    $versionSite = "ERR";
} else {
    $versionSite = $routes['version'];
}

?>

<link rel="stylesheet" href="<?= SITE_HTTP . "://" . SITE_URL ?>/css/admin.css">
<script>
    document.title = "Administration - Dashboard";
</script>

<div id="dashboard">
    <div class="dashboard-block dashboard-menu">
        <a class="menu-link" href="/"><i class="fas fa-home"></i> Accueil de LUMA</a>
        <a class="menu-link" href="/admin/routes"><i class="fa-solid fa-route"></i> Gestion des routes</a>
        <a class="menu-link" style="background-color: grey;" href="#"><i class="fas fa-cogs"></i> Gestion des BDD</a>
        <a class="menu-link" href="/admin/users"><i class="fa-solid fa-users"></i> Gestion des utilisateurs</a>
    </div>

    <div class="dashboard-block">
        <h2>Statut du Serveur</h2>
        <div id="server-status">
            <div class="monitoring"><i class="fa-solid fa-microchip"></i><span id="CPU_moni">***</span></div>
            <div class="monitoring"><i class="fa-solid fa-memory"></i><span id="RAM_moni">***</span></div>
        </div>
        <p class="date_moni">Dernière mise à jour: <span id="last_update_moni">***</span></p>
    </div>
    <script>
        function startSonde() {
            // Effectuer une requête Ajax vers le script PHP pour démarrer la sonde
            $.ajax({
                url: '/sondes/gestion_sonde.php',
                type: 'POST',
                success: function(response) {
                    // Afficher la réponse du serveur (succès ou erreur)
                    console.log(response);
                },
                error: function(error) {
                    // Gérer les erreurs Ajax
                    console.error('Erreur Ajax:', error);
                    alert('Erreur Ajax. Veuillez consulter la console pour plus d\'informations.');
                }
            });
        }
    </script>
    <div class="dashboard-block">
        <h2>Version du Site</h2>
        <p>Version actuelle: <?= $versionSite ?></p>
        <button style="background-color: gray;" id="update-button">Mise à jour</button>
    </div>
</div>

<script src="javascripts/admin/dashboard.js"></script>

<?php else: header('Location: /'); endif; ?>