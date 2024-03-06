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
        return null;
    } else {
        foreach ($req as $agent) {
        };
    }
}
?>

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
</section>

<section>
    <h2>Configuration Système</h2>
    <div class="agent-data">
        <p class="label">Model Processor:</p>
        <p id="data-agent-ModelProcessor" class="data-agent">Chargement des données</p>
    </div>
    <div class="agent-data">
        <p class="label">Architecture:</p>
        <p id="data-agent-architecture" class="data-agent">Chargement des données</p>
    </div>
    <div class="agent-data">
        <p class="label">Coeurs:</p>
        <p id="data-agent-Cores" class="data-agent">Chargement des données</p>
    </div>
    <div class="agent-data">
        <p class="label">Utiliation:</p>
        <p id="data-agent-Used" class="data-agent">Chargement des données</p>
    </div>
    <div class="agent-data">
        <p class="label">Dernière mise à jour:</p>
        <p id="data-agent-processorUpdate" class="data-agent">Chargement des données</p>
    </div>
</section>

<section>
    <h2>Mémoire système</h2>
    <div class="agent-data">
        <p class="label">Mémoire restante:</p>
        <p id="data-agent-Memfree" class="data-agent">Chargement des données</p>
    </div>
    <div class="agent-data">
        <p class="label">Mémoire total:</p>
        <p id="data-agent-MemTotal" class="data-agent">Chargement des données</p>
    </div>
    <div class="agent-data">
        <p class="label">Dernière mise à jour:</p>
        <p id="data-agent-memoryUpdate" class="data-agent">Chargement des données</p>
    </div>
</section>

<section>
    <h2>Disque système</h2>
    <div class="agent-data">
        <p class="label">Disques :</p>
        <p id="data-agent-Memfree" class="data-agent">Non disponible</p>
    </div>
    <div class="agent-data">
        <p class="label">Dernière mise à jour:</p>
        <p id="data-agent-memoryUpdate" class="data-agent">Non disponible</p>
    </div>
</section>

<section>
    <h2>Services</h2>
    <div class="agent-data">
        <p class="label">Plex :</p>
        <p id="data-agent-plex" class="data-agent">Chargement des données</p>
    </div>
    <div class="agent-data">
        <p class="label">Dernière mise à jour:</p>
        <p id="data-agent-servicesUpdate" class="data-agent">Chargement des données</p>
    </div>
</section>

<script src="<?= SITE_HTTP . SITE_URL ?>/javascripts/agent/dash-agent.js?0"></script>