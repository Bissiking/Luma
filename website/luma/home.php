<link rel="stylesheet" href="css/home.css">
<script>
	document.title = "Accueil";
</script>

<section class="server-status">
    <h2>État des Serveurs</h2>
    <div class="server-block">
        <!-- Ajoutez ici des éléments pour afficher l'état du serveur -->
        <div class="server" id="luma BDD" >
            <div class="server-name">Base de donnée de Luma</div>
            <div class="status-container">
                <div class="ping-circle warning" id="ping_bdd_luma">***</div>
            </div>
            <div class="status online" id="status_bdd_luma">En ligne</div>
        </div>

        <div class="server" id="Nino BDD">
            <div class="server-name">Base de donnée de Nino</div>
            <div class="status offline" id="status_bdd_nino">Hors ligne</div>
        </div>

        <div class="server" id="Nino API">
            <div class="server-name">API de Nino</div>
            <div class="status offline" id="status_api_nino">Hors ligne</div>
        </div>
    </div>
</section>

<section class="latest-videos">
    <h2>Dernières Vidéos</h2>
    <!-- Ajoutez ici des éléments pour afficher les dernières vidéos -->
</section>

<!-- SCRIPTS SRV -->
<script src="javascripts/home.js"></script>