<?php
if (isset($_SESSION['authentification']['user'])) :
?>
    <script>
        document.title = "Agent - Dashboard";
    </script>

    <h3>Tableau de bord</h3>

    <section>
        <h2>Status global des agents</h2>
        <div class="agent-status">
            <span id="agent-up" class="agent-stats-global">
                <p class="stats-label bold">*</p>
                <p class="stats-label-little">Serveur(s) UP</p>
            </span>
            <span id="agent-down" class="agent-stats-global">
                <p class="stats-label bold">*</p>
                <p class="stats-label-little">Serveur(s) Offline</p>
            </span>
            <span id="agent-maintenance" class="agent-stats-global">
                <p class="stats-label bold">*</p>
                <p class="stats-label-little">Serveur(s) en maintenance(s)</p>
            </span>
        </div>
    </section>


    <!-- <script src="javascripts/agent/dashboard.js?0"></script> -->

<?php else : header('Location: /');
endif; ?>