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
<link rel="stylesheet" href="/css/agent_v2.css?0">

<div id="menu-dashboard">
    <span id="agent-name" data-uuid="<?= $agent['uuid_agent'] ?>"><?= $agent['agent_name'] ?></span>
    <nav id="nav-dashboard">
        <ul>
            <li id="dashboard" class="select"><i class="fa-solid fa-table-columns"></i><span>Tableau de bord</span></li>
            <li id="configuration"><i class="fa-solid fa-wrench"></i><span>Configuration de l'agent</span></li>
            <li id="docker"><i class="fa-brands fa-docker"></i><span>Docker</span></li>
            <li style="color: grey;"><i class="fa-solid fa-cube"></i><span>Minecraft</span></li>
            <li style="color: grey;"><i class="fa-solid fa-play"></i><span>Nino (Player ou agent)</span></li>
            <li style="color: grey;"><i class="fa-solid fa-clipboard-list"></i><span>Logs</span></li>
        </ul>
    </nav>
</div>

<div class="bloc-agent" id="content-dashboard">

    <h3>Tableau de bord</h3>

    <div class="content-agent content-alerte">
        <h4>Alerte actuel</h4>
        <p><span>Fonctionnalité non disponible</span></p>
    </div>

    <div class="content-agent content-info-agent">
        <h4>Informations du processeur</h4>
        <p>Nom de l'agent: <span><?= $agent['agent_name'] ?></span></p>
        <p>UUID de l'agent: <span><?= $agent['uuid_agent'] ?></span></p>

        <?php
        $agent_states = [
            0 => ['label' => 'Non synchronisé', 'class' => ''],
            1 => ['label' => 'En ligne', 'class' => 'active'],
            99 => ['label' => 'En maintenance', 'class' => 'maintenance'],
            'default' => ['label' => 'Hors Ligne', 'class' => 'offline']
        ];

        $state = $agent_states[$agent['agent_etat']] ?? $agent_states['default'];
        ?>

        <p class="config-agent">État de l'agent: <button class="agent <?= $state['class'] ?>"><?= $state['label'] ?></button></p>

    </div>

    <div class="content-agent content-processeur">
        <h4>Informations du processeur</h4>
        <p>Processeur: <span id="ModelProcessor">Aucune information</span></p>
        <p>Architecture: <span id="architecture">Aucune information</span></p>
        <p>Nombre de Coeurs: <span id="Cores">Aucune information</span></p>
        <p>Utilisation: <span id="Used" class="bar-usage">NaN %</span></p>
    </div>

    <div class="content-agent content-ram">
        <h4>Informations de la mémoire</h4>
        <p>Mémoire total: <span id="MemTotal">Aucune information</span></p>
        <p>Mémoire utilisé: <span id="MemUsed">Aucune information</span></p>
        <p>Mémoire disponible: <span id="Memfree">Aucune information</span></p>
        <p>Utilisation: <span class="bar-usage" id="MemUsedPourcent">NaN %</span></p>
    </div>

    <div class="content-agent content-disk">
        <h4>Informations des disques</h4>
        <p>Utilisation: <span class="bar-usage">Non disponible</span></p>
    </div>

    <div class="content-agent content-plex">
        <h4>Statut de Plex</h4>
        <p class="config-agent">Statut: <button id="statut-plex" class="agent">NaN</button></p>
    </div>

    <div class="content-agent content-jellyfin">
        <h4>Statut de JellyFin</h4>
        <p class="config-agent">Statut: <button id="statut-jellyfin" class="agent">NaN</button></p>
    </div>

    <div class="content-agent content-beam-mp">
        <h4>Statut de BeamMP</h4>
        <p class="config-agent">Statut: <button id="statut-BeamMP" class="agent">NaN</button></p>
    </div>
</div>

<!-- --------------- CONFIG --------------- -->

<div class="bloc-agent hidden" id="content-configuration">
    <h3>Configuration de l'agent</h3>

    <?php
    $agent_module = [
        0 => ['label' => 'Désactivé', 'class' => 'offline'],
        1 => ['label' => 'Activé', 'class' => 'active']
    ];

    // Les informations de chaque module avec les colonnes spécifiques
    $modules = [
        'processor' => [
            'name' => 'Sonde du processeur',
            'autostart' => 'ProcessorModule_autostart',
            'autorestart' => 'ProcessorModule_autorestart'
        ],
        'memory' => [
            'name' => 'Sonde de la mémoire',
            'autostart' => 'MemoryModule_autostart',
            'autorestart' => 'MemoryModule_autorestart'
        ],
        'disk' => [
            'name' => 'Sonde des disques',
            'autostart' => 'DiskModule_autostart',
            'autorestart' => 'DiskModule_autorestart'
        ],
        'jellyfin' => [
            'name' => 'Sonde de JellyFin',
            'autostart' => 'JellyFinProcessCheck_autostart',
            'autorestart' => 'JellyFinProcessCheck_autorestart'
        ],
        'plex' => [
            'name' => 'Sonde de Plex',
            'autostart' => 'PlexProcessCheck_autostart',
            'autorestart' => 'PlexProcessCheck_autorestart'
        ],
        'beammp' => [
            'name' => 'Sonde de BeamMP',
            'autostart' => 'BeamMPProcessCheck_autostart',
            'autorestart' => 'BeamMPProcessCheck_autorestart'
        ],
        'docker' => [
            'name' => 'Sonde docker',
            'autostart' => 'DockerModule_autostart',
            'autorestart' => 'DockerModule_autorestart'
        ]
    ];

    // La fonction pour générer le HTML de chaque module
    function generateModuleHtml($module_key, $module_info, $agent_module, $agent)
    {
        $autostart_state = $agent[$module_info['autostart']];
        $autorestart_state = $agent[$module_info['autorestart']];

        $autostart_button = $agent_module[$autostart_state];
        $autorestart_button = $agent_module[$autorestart_state];

        echo "
    <div class='content-agent config-agent-$module_key'>
        <h4>{$module_info['name']}</h4>
        <p class='config-agent'>Activer/Désactiver la sonde: <button id='autostart-$module_key' class='edit-Config agent {$autostart_button['class']}' data-button='{$autostart_button['class']}'>{$autostart_button['label']}</button></p>
        <p class='config-agent'>Activer/Désactiver le redémarrage auto en cas d'échec: <button id='autorestart-$module_key' class='edit-Config agent {$autorestart_button['class']}' data-button='{$autorestart_button['class']}'>{$autorestart_button['label']}</button></p>
    </div>";
    }

    // Générer le HTML pour chaque module
    foreach ($modules as $module_key => $module_info) {
        generateModuleHtml($module_key, $module_info, $agent_module, $agent);
    }
    ?>


    <!-- <?php
            $agent_module = [
                0 => ['label' => 'Désactivé', 'class' => 'offline'],
                1 => ['label' => 'Activé', 'class' => 'active']
            ];

            $state = $agent_states[$agent['agent_etat']] ?? $agent_states['default'];
            ?>

    <div class="content-agent config-agent-processeur">
        <h4>Sonde du processeur</h4>
        <p class="config-agent">Activer/Désactiver la sonde: <button class="agent active" data-button="active">Activé</button></p>
        <p class="config-agent">Activer/Désactiver le redémarrage auto en cas d'échec: <button class="agent offline">Désactivé</button></p>
        <p>Mettre à jour toutes les : <span>Option non disponible</span></p>
    </div>

    <div class="content-agent config-agent-memoire">
        <h4>Sonde de la mémoire</h4>
        <p class="config-agent">Activer/Désactiver la sonde: <button class="agent offline" data-button="offline">Désactivé</button></p>
        <p class="config-agent">Activer/Désactiver le redémarrage auto en cas d'échec: <button class="agent offline">Désactivé</button></p>
    </div>

    <div class="content-agent config-agent-disques">
        <h4>Sonde des disques</h4>
        <p class="config-agent">Activer/Désactiver la sonde: <button class="agent offline" data-button="offline">Désactivé</button></p>
        <p class="config-agent">Activer/Désactiver le redémarrage auto en cas d'échec: <button class="agent offline">Désactivé</button></p>
    </div>

    <div class="content-agent config-agent-jellyfin">
        <h4>Sonde de JellyFin</h4>
        <p class="config-agent">Activer/Désactiver la sonde: <button class="agent offline" data-button="offline">Désactivé</button></p>
        <p class="config-agent">Activer/Désactiver le redémarrage auto en cas d'échec: <button class="agent offline">Désactivé</button></p>
    </div>

    <div class="content-agent config-agent-plex">
        <h4>Sonde de Plex</h4>
        <p class="config-agent">Activer/Désactiver la sonde: <button class="agent offline" data-button="offline">Désactivé</button></p>
        <p class="config-agent">Activer/Désactiver le redémarrage auto en cas d'échec: <button class="agent offline">Désactivé</button></p>
    </div>

    <div class="content-agent config-agent-beammp">
        <h4>Sonde de BeamMP</h4>
        <p class="config-agent">Activer/Désactiver la sonde: <button class="agent offline" data-button="offline">Désactivé</button></p>
        <p class="config-agent">Activer/Désactiver le redémarrage auto en cas d'échec: <button class="agent offline">Désactivé</button></p>
    </div>

    <div class="content-agent config-agent-docker">
        <h4>Sonde docker</h4>
        <p class="config-agent">Activer/Désactiver la sonde: <button class="agent offline" data-button="offline">Désactivé</button></p>
        <p class="config-agent">Activer/Désactiver le redémarrage auto en cas d'échec: <button class="agent offline">Désactivé</button></p>
    </div> -->
</div>

<!-- --------------- DOCKER --------------- -->

<div class="bloc-agent hidden" id="content-docker">
    <h3>Containers docker</h3>
</div>

<script src="<?= SITE_HTTP . SITE_URL ?>/javascripts/agent/new-dash.js?0"></script>
<script src="<?= SITE_HTTP . SITE_URL ?>/javascripts/agent/bloc/dashboard.js?0"></script>
<script src="<?= SITE_HTTP . SITE_URL ?>/javascripts/agent/bloc/configuration.js?0"></script>
<script src="<?= SITE_HTTP . SITE_URL ?>/javascripts/agent/bloc/docker.js?0"></script>