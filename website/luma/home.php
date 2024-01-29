<link rel="stylesheet" href="../css/home.css?0">
<script>
    document.title = "Accueil";
</script>

<section class="server-status">
    <h2>Informations</h2>
    <p class="info-popup">
        Le site LUMA et les modules qu'ils embarquent, sont en constantes évolutions. Tous les outils, options et autres services prennent du temps à être développer (pour certains). 😰<br>
        J'améliore constament le site et fonctionnalités, les parties visible, comme invisible. C'est la raison, pour laquel le site à une fonction de mise à jour intégré. <br>
        Exemple, le service Nino (Youtube maison), me coûte de l'espace de stockage, ce n'est pas pour ceci, que le service sera payant ou qu'une demande d'argent sera faite. Nan mais sans déconner !! 3Go de moyenne pour une vidéo, les 1To de disque qui on envie de crever à chaque copie ..... Merde je me suis perdu. 🤨 <br>
        Bref, je suis vraiment désolé pour le retard et les délais d'attentes sur certaines options, je fait de mon mieux entre vie pro, vie perso, et ma non vie 😝 <br>
        Sur la partie LUMA, le site fait très simpliste, car étant très très très nul en design, j'ai fait le plus simple possible. Bah ChatGPT 🙄 .... <br>
        J'ai prévilégié un aspect fonctionnel au site et le design sera amélioré plus tard, quand les fonctionnalités de base, seront enfin stable.
    </p>
</section>

<section class="server-status">
    <h2>État des Serveurs <span class="betaPops">BETA</span></h2>
    <div class="server-block">
        <!-- BDD -->
        <div class="ServerBlock server" id="bdd_luma" data-ip="<?php if ($_GET['offline'] === true) {
                                                                    echo 'offline';
                                                                } else {
                                                                    echo SITE_URL;
                                                                } ?>">
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
        <div class="ServerBlock server" id="api_nino_enerzein" data-ip="nino.enerzein.fr/check">
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