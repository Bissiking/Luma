<?php
require('./base/nexus_base.php');

// Extraction des services
$sql_services = 'SELECT * FROM luma_statut';
$req_services = $pdo->prepare($sql_services);
$req_services->execute();
$result = $req_services->rowCount();

// Extraction de la liste des agents
$sql_agent = 'SELECT uuid_agent, agent_etat FROM luma_agent';
$req_agent = $pdo->prepare($sql_agent);
$req_agent->execute();
$result_agent = $req_agent->fetchAll(PDO::FETCH_ASSOC);

function getAgentEtat($uuid, $agents)
{
    foreach ($agents as $agent) {
        if ($agent['uuid_agent'] === $uuid) {
            return $agent['agent_etat'];
        }
    }
    return null;
}

// Extraire uniquement les uuid_agent dans un tableau
$agent_uuids = array_column($result_agent, 'uuid_agent');
?>

<link rel="stylesheet" href="../css/statut.css?3">
<script>
    document.title = "Status";
</script>

<section>
    <h5>API Nino (PROD)</h5>
    <p><span id="api-nino-prod-circle" class="circle-offline"></span><span id="api-nino-prod-txt">Hors ligne</span></p>
</section>

<?php while ($service = $req_services->fetch(PDO::FETCH_ASSOC)) :
    if (in_array($service['uuid_agent'], $agent_uuids)) {
        $agent_etat = getAgentEtat($service['uuid_agent'], $result_agent);
    } else {
        $agent_etat = 'empty';
    };
?>
    <section class="serviceSection">
        <h5><?= htmlspecialchars($service['service']) ?></h5>
        <p>
            <span class="circle-stats circle-offline" data-service="<?= htmlspecialchars($service['service']) ?>" data-id="<?= htmlspecialchars($service['uuid_agent']) ?>" data-uuiddocker="<?php if (!empty($service['uuid_docker'])) {
                                                                                                                                                                                                    echo htmlspecialchars($service['uuid_docker']);
                                                                                                                                                                                                } ?>" data-statut="<?= htmlspecialchars($agent_etat) ?>"></span>
            <span class="txt-stats">Check en cours</span>
        </p>
    </section>
<?php endwhile; ?>

<script src="../javascripts/home/statut.js?5"></script>