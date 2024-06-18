<?php
    require('./base/nexus_base.php');

    // Extraction des services
    $sql = 'SELECT * FROM luma_statut';
    $req = $pdo->prepare($sql);
    $req->execute();
    $result = $req->rowCount();
?>
<link rel="stylesheet" href="../css/statut.css?1">
<script>
    document.title = "Status";
</script>





<section>
    <h5>API Nino (PROD)</h5>
    <p><span id="api-nino-prod-circle" class="circle-offline"></span><span id="api-nino-prod-txt">Hors ligne</span></p>
</section>

<?php while ($service = $req->fetch()): ?>
    <section class="serviceSection">
        <h5><?= $service['service'] ?></h5>
        <p><span class="circle-stats circle-offline" data-service="<?= $service['service'] ?>" data-id="<?= $service['uuid_agent'] ?>" data-uuiddocker="<?= $service['uuid_docker'] ?>"></span><span class="txt-stats">Check en cours</span></p>
    </section>
<?php endwhile; ?>

<script src="../javascripts/home/statut.js?3"></script>