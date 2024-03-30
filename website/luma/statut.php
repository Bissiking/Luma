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
    <p><span class="circle-offline indiq-stats"></span><span class="txt-stats">En cours de développement</span></p>
</section>

<?php while ($service = $req->fetch()): ?>
    <section class="serviceSection">
        <h5><?= $service['service'] ?></h5>
        <p><span class="circle-stats circle-offline" data-service="<?= $service['service'] ?>" data-id="<?= $service['uuid_agent'] ?>"></span><span class="txt-stats">Check en cours</span></p>
    </section>
<?php endwhile; ?>

<script src="../javascripts/home/statut.js"></script>