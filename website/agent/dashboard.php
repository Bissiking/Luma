<?php
if (isset($_SESSION['authentification']['user'])) :


    function ListAgent()
    {
        require './base/nexus_base.php';
        $id_users = $_SESSION['authentification']['user']['id'];
        $v = array('id_users' => $id_users);
        $sql = 'SELECT * FROM luma_agent WHERE id_users = :id_users';
        $req = $pdo->prepare($sql);
        $req->execute($v);
        $result = $req->rowCount();
        if ($result == 0) {
            return null;
        } else {
            return $req;
        }
    }

?>
    <script>
        document.title = "Agent - Dashboard";
    </script>

    <h3>Tableau de bord</h3>

    <section>
        <h2>Status global des agents</h2>
        <div class="agent-status">
            <span id="agent-up" class="agent-stats-global">
                <p id="agent-up-txt" class="stats-label bold">*</p>
                <p class="stats-label-little">Serveur(s) UP</p>
            </span>
            <span id="agent-down" class="agent-stats-global">
                <p id="agent-down-txt" class="stats-label bold">*</p>
                <p class="stats-label-little">Serveur(s) Offline</p>
            </span>
            <span id="agent-maintenance" class="agent-stats-global">
                <p class="stats-label bold">*</p>
                <p class="stats-label-little">Serveur(s) en maintenance(s)</p>
            </span>
        </div>
    </section>

    <section>
        <h2>Création d'un agent</h2>
        <input type="text" id="agent_name" placeholder="Nom de l'agent">
        <button onclick="agent_add()">Création de l'agent</button>
    </section>

    <section>
        <h2>Liste des agents</h2>
        <div class="agent-list">

            <?php
            $ListFunc = ListAgent();
            if ($ListFunc == null) {
                echo '<h2>Aucun agent enregistré</h2>';
            } else {
                while ($agent = $ListFunc->fetch()) {
            ?>
                    <div class="modern-box" onclick="DashAgent('<?= $agent['uuid_agent'] ?>')" data-uuidagent="<?= $agent['uuid_agent'] ?>">
                        <h2><?= $agent['agent_name'] ?></h2>
                        <p><?php if($agent['agent_etat'] == 0){
                            echo 'Non associé';
                        }else if($agent['agent_etat'] == 1){
                            echo 'En ligne';
                        }else if($agent['agent_etat'] == 10){
                            echo 'Hors ligne';
                        }else if($agent['agent_etat'] == 99){
                            echo 'En maintenance';
                        }else{
                            echo 'Etat indisponible';
                        }?></p>
                        <p><?= $agent['agent_version'] ?></p>
                    </div>
            <?php }
            } ?>

        </div>
    </section>

    <script src="javascripts/agent/dashboard.js?0"></script>

<?php else : header('Location: /');
endif; ?>