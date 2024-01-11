<link rel="stylesheet" href="../css/home.css">
<script>
	document.title = "Accueil";
</script>

<section class="server-status">
    <h2>État des Serveurs <span class="betaPops">BETA</span></h2>
    <div class="server-block">
        <!-- BDD -->
        <div class="ServerBlock server" id="bdd_luma" data-ip="<?php if($_GET['offline'] === true ){ echo 'offline'; }else{ echo SITE_URL; } ?>">
            <div class="server-name">Base de donnée de Luma</div>
            <div class="status-container">
                <div class="ping-circle warning" id="ping_bdd_luma">***</div>
            </div>
            <div class="status" id="status_bdd_luma">Checking ...</div>
        </div>

        <!-- API DEV -->
        <div class="ServerBlock server" id="api_nino_dev" data-ip="dev.nino.mhemery.fr/check">
            <div class="server-name">API Nino (DEV)</div>
                        <div class="status-container">
                <div class="ping-circle warning" id="ping_api_nino_dev">***</div>
            </div>
            <div class="status" id="status_api_nino_dev">Checking ...</div>
        </div>

        <!-- API Principal -->
        <div class="ServerBlock server" id="api_nino" data-ip="nino.mhemery.fr/check">
            <div class="server-name">API Nino</div>
                        <div class="status-container">
                <div class="ping-circle warning" id="ping_api_nino">***</div>
            </div>
            <div class="status" id="status_api_nino">Checking ...</div>
        </div>

        <!-- API Enerzein -->
        <div class="ServerBlock server" id="api_nino_enerzein" data-ip="">
            <div class="server-name">API Nino (Enerzein)</div>
                        <div class="status-container">
                <div class="ping-circle warning" id="ping_api_nino_enerzein">***</div>
            </div>
            <div class="status" id="status_api_nino_enerzein">Checking ...</div>
        </div>
    </div>
</section>

<section class="latest-videos">
    <h2>Dernières Vidéos <span class="betaPops">Pas encore disponible</span></h2>
    <h5>Encore un peu de patience</h5>
    <!-- Ajoutez ici des éléments pour afficher les dernières vidéos -->
</section>

<!-- SCRIPTS SRV -->
<script src="../javascripts/home.js"></script>