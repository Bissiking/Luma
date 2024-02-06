<?php
    require_once ('./lib/truncateText.php');
?>
<!-- <link rel="stylesheet" href="../css/home.css?0"> -->
<link rel="stylesheet" href="../css/home_V2.css?0">
<script>
    document.title = "Accueil";
</script>

<div class="right-column">
    <section class="information">
        <h2>Informations</h2>
        <p class="info-popup">
            Version 4.5.1 du site. <br>
            Cette version corrige beaucoup de bugs sur l'éditeur de Nino. <br>
            Celui-ci, comme vous le voyez, teste une nouvelle mise en page et un nouvelle disposition du site ...  <br>Bon c'est une BETA et je penses que les couleurs vont dégagés. <br>
            - Une mise à jour BDD est aussi en attente la DB05, elle augmente change le type de colonne 'varchar' en 'text' pour pouvoir stocker plus de tag <br>
            - Ajout d'un indicateur de mise à jour de BDD dans le dashboard <br>
            - Activation de l'affichage des trois dernières vidéos <br>
            - Limitation de 20 Caractères du titre des vidéos <br>
            - Amélioration de certaines fonctionnalités de l'éditeur
        </p>
        <p class="info-popup">
            Le site LUMA et les modules qu'ils embarquent, sont en constantes évolutions. Tous les outils, options et autres services prennent du temps à être développer (pour certains). 😰<br>
            J'améliore constament le site et fonctionnalités, les parties visible, comme invisible. C'est la raison, pour laquel le site à une fonction de mise à jour intégré. <br>
            Exemple, le service Nino (Youtube maison), me coûte de l'espace de stockage, ce n'est pas pour ceci, que le service sera payant ou qu'une demande d'argent sera faite. Nan mais sans déconner !! 3Go de moyenne pour une vidéo, les 1To de disque qui on envie de crever à chaque copie ..... Merde je me suis perdu. 🤨 <br>
            Bref, je suis vraiment désolé pour le retard et les délais d'attentes sur certaines options, je fait de mon mieux entre vie pro, vie perso, et ma non vie 😝 <br>
            Sur la partie LUMA, le site fait très simpliste, car étant très très très nul en design, j'ai fait le plus simple possible. Bah ChatGPT 🙄 .... <br>
            J'ai prévilégié un aspect fonctionnel au site et le design sera amélioré plus tard, quand les fonctionnalités de base, seront enfin stable.
        </p>
    </section>
</div>
<div class="left-column">
    <section class="api-status">
        <h2>État des API's <span class="betaPops">BETA</span></h2>
        <div class="api-block">

            <?php if ($_SERVER['HTTP_HOST'] == 'dev.mhemery.fr') : ?>
                <!-- API DEV -->
                <div class="apiBlock api" id="api_nino_dev" data-ip="dev.nino.mhemery.fr/check">
                    <div class="api-name">API Nino (DEV)</div>
                    <div class="status-container">
                        <div class="ping-circle" id="ping_api_nino_dev">***</div>
                    </div>
                    <div class="status" id="status_api_nino_dev">Checking ...</div>
                </div>
            <?php endif; ?>

            <!-- API Principal -->
            <div class="apiBlock api" id="api_nino" data-ip="nino.mhemery.fr/check">
                <div class="api-name">API Nino</div>
                <div class="status-container">
                    <div class="ping-circle" id="ping_api_nino">***</div>
                </div>
                <div class="status" id="status_api_nino">Checking ...</div>
            </div>

            <!-- API Enerzein -->
            <div class="apiBlock api" id="api_nino_enerzein" data-ip="nino.enerzein.fr/check">
                <div class="api-name">API Nino (Enerzein)</div>
                <div class="status-container">
                    <div class="ping-circle" id="ping_api_nino_enerzein">***</div>
                </div>
                <div class="status" id="status_api_nino_enerzein">Checking ...</div>
            </div>
        </div>
    </section>

    <section class="latest-videos">
        <h2>3 Dernières Vidéos <span class="betaPops">BETA</span></h2>
        <div class="video-bloc">
    <?php
    require './base/nexus_base.php';
    $sql = 'SELECT * FROM luma_nino_data WHERE publish < "'.date('Y-m-d H:i:s').'" && status = "publique" ORDER BY publish DESC LIMIT 3';
    $req = $pdo->prepare($sql);
    $req->execute();
    $result = $req->rowCount();
    if ($result >= 1) {
        while ($video = $req->fetch()) {
            $PublishVid = $video['publish'];
            $HeureLocal = date('Y-m-d H:i:s');
            if ($HeureLocal <= $PublishVid) {
                $publish = 0;
            } else {
                $publish = 1;
            }

            if ($video['videoThumbnail'] == '' || $video['videoThumbnail'] == null) {
                $video['videoThumbnail'] = SITE_HTTP . "://" . SITE_URL . "/images/nino/no_image.jpg";
            }
    ?>
            <div class="video" data-idVideo="<?= $video['id'] ?>" data-status="<?= $publish ?>">
                <img <?php if ($publish != 1) {
                            echo 'class="blur"';
                        } ?> src="<?= 'https://'.$video['server_url'].'/Thumbnail/'.$video['id_video_uuid'] ?>" alt="Thumbnail Nino">
                <div class="video-info">
                    <div class="video-title"><?= truncateText($video['titre'], 30) ?></div>
                </div>
            </div>
    <?php }
    } else {
        echo '<h5>Aucune vidéo trouvé</h5>';
    }
    ?>
</div>
    </section>
</div>
<!-- SCRIPTS SRV -->
<script src="../javascripts/home.js?0"></script>