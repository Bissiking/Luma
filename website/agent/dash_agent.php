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

$urlNewDash = explode('/', $url);
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
                <p id="agent-statut" class="data-agent">[EN DEV]</p>
            </div>
            <?php if ($agent['agent_etat'] !== 0) : ?>
                <button id="agent_etat" <?php if ($agent['agent_etat'] == 99) {
                            echo 'class="warning"';
                        } ?> data-maintenance="<?= $agent['agent_etat'] ?>" onclick="MaintenanceMode('agent_etat')"><?php if ($agent['agent_etat'] == 99) {
                            echo 'Mode maintenance activé';
                        }else{
                            echo 'Mode maintenance désactivé';
                        } ?></button>
                <a href="/agent/uuid/new/luma/<?= $urlNewDash[4] ?>"><button>New dashboard</button></a>
            <?php endif; ?>
        </section>
        <?php if ($agent['agent_etat'] !== 0) : ?>
            <section id="config-sys" <?php if ($agent['ProcessorModule_autostart'] != 1) {
                                            echo 'style="background-color: grey"';
                                        } ?>>
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
                <div class="agent-data">
                    <p class="label">Alerte:</p>
                    <p id="config-sys-alerte" class="data-agent alert">RAS</p>
                </div>
                <div class="agent-data">

                    <button <?php if ($agent['ProcessorModule_autostart'] == 1) {
                                echo 'class="delete"';
                            } ?> id="ProcessorModule_autostart" data-autostart="<?= $agent['ProcessorModule_autostart'] ?>" onclick="AutoStart('ProcessorModule_autostart')"><?php if ($agent['ProcessorModule_autostart'] == 1) {
                                                                                                                                                                                    echo 'Désactivé';
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo 'Activé';
                                                                                                                                                                                } ?> AutoStart</button>

                    <button <?php if ($agent['ProcessorModule_autorestart'] == 1) {
                                echo 'class="delete"';
                            } ?> id="ProcessorModule_autorestart" data-autorestart="<?= $agent['ProcessorModule_autorestart'] ?>" style="margin-left: 15px;" onclick="AutoRestart('ProcessorModule_autorestart')"><?php if ($agent['ProcessorModule_autorestart'] == 1) {
                                                                                                                                                                                                                        echo 'Désactivé';
                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                        echo 'Activé';
                                                                                                                                                                                                                    } ?> AutoRestart</button>

                </div>
            </section>

            <section id="memory-sys" <?php if ($agent['MemoryModule_autostart'] != 1) {
                                            echo 'style="background-color: grey"';
                                        } ?>>
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
                <div class="agent-data">
                    <p class="label">Alerte:</p>
                    <p id="memory-sys-alerte" class="data-agent alert">RAS</p>
                </div>
                <div class="agent-data">

                    <button <?php if ($agent['MemoryModule_autostart'] == 1) {
                                echo 'class="delete"';
                            } ?> id="MemoryModule_autostart" data-autostart="<?= $agent['MemoryModule_autostart'] ?>" onclick="AutoStart('MemoryModule_autostart')"><?php if ($agent['MemoryModule_autostart'] == 1) {
                                                                                                                                                                        echo 'Désactivé';
                                                                                                                                                                    } else {
                                                                                                                                                                        echo 'Activé';
                                                                                                                                                                    } ?> AutoStart</button>

                    <button <?php if ($agent['MemoryModule_autorestart'] == 1) {
                                echo 'class="delete"';
                            } ?> id="MemoryModule_autorestart" data-autorestart="<?= $agent['MemoryModule_autorestart'] ?>" style="margin-left: 15px;" onclick="AutoRestart('MemoryModule_autorestart')"><?php if ($agent['MemoryModule_autorestart'] == 1) {
                                                                                                                                                                                                                echo 'Désactivé';
                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                echo 'Activé';
                                                                                                                                                                                                            } ?> AutoRestart</button>

                </div>
            </section>

            <section id="plex-sys" <?php if ($agent['PlexProcessCheck_autostart'] != 1) {
                                        echo 'style="background-color: grey"';
                                    } ?>>
                <h2>Plex</h2>
                <div class="agent-data">
                    <p class="label">Etat du service :</p>
                    <p id="data-agent-plex" class="data-agent">Chargement des données</p>
                </div>
                <div class="agent-data">
                    <p class="label">Dernière mise à jour:</p>
                    <p id="data-agent-servicesUpdate" class="data-agent">Chargement des données</p>
                </div>
                <div class="agent-data">
                    <p class="label">Alerte:</p>
                    <p id="plex-sys-alerte" class="data-agent alert">RAS</p>
                </div>
                <div class="agent-data">

                    <button <?php if ($agent['PlexProcessCheck_autostart'] == 1) {
                                echo 'class="delete"';
                            } ?> id="PlexProcessCheck_autostart" data-autostart="<?= $agent['PlexProcessCheck_autostart'] ?>" onclick="AutoStart('PlexProcessCheck_autostart')"><?php if ($agent['PlexProcessCheck_autostart'] == 1) {
                                                                                                                                                                                    echo 'Désactivé';
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo 'Activé';
                                                                                                                                                                                } ?> AutoStart</button>

                    <button <?php if ($agent['PlexProcessCheck_autorestart'] == 1) {
                                echo 'class="delete"';
                            } ?> id="PlexProcessCheck_autorestart" data-autorestart="<?= $agent['PlexProcessCheck_autorestart'] ?>" style="margin-left: 15px;" onclick="AutoRestart('PlexProcessCheck_autorestart')"><?php if ($agent['PlexProcessCheck_autorestart'] == 1) {
                                                                                                                                                                                                                            echo 'Désactivé';
                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                            echo 'Activé';
                                                                                                                                                                                                                        } ?> AutoRestart</button>

                </div>
            </section>
            <section id="JellyFin-sys" <?php if ($agent['JellyFinProcessCheck_autostart'] != 1) {
                                            echo 'style="background-color: grey"';
                                        } ?>>
                <h2>JellyFin</h2>
                <div class="agent-data">
                    <p class="label">Etat du service :</p>
                    <p id="data-agent-JellyFin" class="data-agent">Chargement des données</p>
                </div>
                <div class="agent-data">
                    <p class="label">Dernière mise à jour:</p>
                    <p id="data-agent-servicesJellyFinUpdate" class="data-agent">Chargement des données</p>
                </div>
                <div class="agent-data">
                    <p class="label">Alerte:</p>
                    <p id="JellyFin-sys-alerte" class="data-agent alert">RAS</p>
                </div>
                <div class="agent-data">

                    <button <?php if ($agent['JellyFinProcessCheck_autostart'] == 1) {
                                echo 'class="delete"';
                            } ?> id="JellyFinProcessCheck_autostart" data-autostart="<?= $agent['JellyFinProcessCheck_autostart'] ?>" onclick="AutoStart('JellyFinProcessCheck_autostart')"><?php if ($agent['JellyFinProcessCheck_autostart'] == 1) {
                                                                                                                                                                                                echo 'Désactivé';
                                                                                                                                                                                            } else {
                                                                                                                                                                                                echo 'Activé';
                                                                                                                                                                                            } ?> AutoStart</button>

                    <button <?php if ($agent['JellyFinProcessCheck_autorestart'] == 1) {
                                echo 'class="delete"';
                            } ?> id="JellyFinProcessCheck_autorestart" data-autorestart="<?= $agent['JellyFinProcessCheck_autorestart'] ?>" style="margin-left: 15px;" onclick="AutoRestart('JellyFinProcessCheck_autorestart')"><?php if ($agent['JellyFinProcessCheck_autorestart'] == 1) {
                                                                                                                                                                                                                                        echo 'Désactivé';
                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                        echo 'Activé';
                                                                                                                                                                                                                                    } ?> AutoRestart</button>

                </div>
            </section>
            <section id="BeamMP-sys" <?php if ($agent['BeamMPProcessCheck_autostart'] != 1) {
                                            echo 'style="background-color: grey"';
                                        } ?>>
                <h2>BeamMP</h2>
                <div class="agent-data">
                    <p class="label">Etat du service :</p>
                    <p id="data-agent-BeamMP" class="data-agent">Chargement des données</p>
                </div>
                <div class="agent-data">
                    <p class="label">Dernière mise à jour:</p>
                    <p id="data-agent-servicesBeamMPUpdate" class="data-agent">Chargement des données</p>
                </div>
                <div class="agent-data">
                    <p class="label">Alerte:</p>
                    <p id="BeamMP-sys-alerte" class="data-agent alert">RAS</p>
                </div>
                <div class="agent-data">

                    <button <?php if ($agent['BeamMPProcessCheck_autostart'] == 1) {
                                echo 'class="delete"';
                            } ?> id="BeamMPProcessCheck_autostart" data-autostart="<?= $agent['BeamMPProcessCheck_autostart'] ?>" onclick="AutoStart('BeamMPProcessCheck_autostart')"><?php if ($agent['BeamMPProcessCheck_autostart'] == 1) {
                                                                                                                                                                                            echo 'Désactivé';
                                                                                                                                                                                        } else {
                                                                                                                                                                                            echo 'Activé';
                                                                                                                                                                                        } ?> AutoStart</button>

                    <button <?php if ($agent['BeamMPProcessCheck_autorestart'] == 1) {
                                echo 'class="delete"';
                            } ?> id="BeamMPProcessCheck_autorestart" data-autorestart="<?= $agent['BeamMPProcessCheck_autorestart'] ?>" style="margin-left: 15px;" onclick="AutoRestart('BeamMPProcessCheck_autorestart')"><?php if ($agent['BeamMPProcessCheck_autorestart'] == 1) {
                                                                                                                                                                                                                                echo 'Désactivé';
                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                echo 'Activé';
                                                                                                                                                                                                                            } ?> AutoRestart</button>

                </div>
            </section>
</div>

<section id="block-disk" class="content-dashboard-agent-disk">
    <h4 id="nb-disque" style="color: black">Chargement des disques</h4>
</section>

<?php else : ?>
    <section class="info-popup">
        <p>L'agent n'est pas encore associé. Si vous l'avez démarré et renseigné sont UUID, alors vous n'avez simplement qu'a patientez le temps de la synchro.</p>
    </section>
<?php endif;
        if ($agent['module'] === 'agent_luma' || $agent['module'] === null) { ?>
    <script src="<?= SITE_HTTP . SITE_URL ?>/javascripts/agent/dash-agent.js?3"></script>
<?php }
    endif; ?>