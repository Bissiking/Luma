<?php
$url = $_SERVER['REQUEST_URI'];
$parts = explode('/', $url);
$uuid = end($parts);

if (!isset($uuid) || $uuid == null || $uuid == "uuid") {
    echo '<h3>Agent non trouvé</h3>';
    echo '<img src="' . SITE_HTTP . SITE_URL . '/images/nino/404.jpg" style="width: 100%; height:40%">';
} else {
    require './base/nexus_base.php';
    $id_users = $_SESSION['authentification']['user']['id'];
    $v = array('uuid_agent' => $uuid);
    $sql = "SELECT * FROM luma_agent WHERE uuid_agent = :uuid_agent AND id_users = $id_users";
    $req = $pdo->prepare($sql);
    $req->execute($v);
    $result = $req->rowCount();
    if ($result == 0) {
        $agent = array('agent-name' => 'NOT FOUND');
    } else {
        foreach ($req as $agent) {
        };
    }
}
?>





<div id="Block-Section-Data" class="content-dashboard-agent">

    <?php if ($result == 0) : ?>
        <section>
            <h2>Informations Agent</h2>
            <p>L'agent n'existe pas. UUID Not found</p>
        </section>
    <?php else : ?>
        <script>
            document.title = "Agent - <?= $agent['agent_name'] ?>";
        </script>
        <section>
            <h2>Informations Agent</h2>
            <div class="agent-data">
                <p class="label">Nom de l'agent:</p>
                <p class="data-agent"><?= $agent['agent_name'] ?></p>
            </div>
            <div class="agent-data">
                <p class="label">UUID:</p>
                <p id="agent-uuid" class="data-agent"><?= $agent['uuid_agent'] ?></p>
            </div>
            <div class="agent-data">
                <p class="label">Etat de l'agent:</p>
                <p id="agent-statut" class="data-agent">Non disponible</p>
            </div>
        </section>
    <?php endif; ?>
</div>