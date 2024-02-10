<?php
    require_once ('./lib/truncateText.php');
?>
<script>
    document.title = "Nino - Accueil";
</script>

<!-- <h1>Mes Vidéos</h1> -->

<div class="video-bloc">
    <?php
    require './base/nexus_base.php';
    $sql = 'SELECT * FROM luma_nino_data WHERE status = "publique" ORDER BY publish DESC';
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
            <div class="video" data-idVideo="<?= $video['id_video_uuid'] ?>" data-status="<?= $publish ?>">
                <img <?php if ($publish != 1) {
                            echo 'class="blur"';
                        } ?> src="<?= 'https://'.$video['server_url'].'/Thumbnail/'.$video['id_video_uuid'] ?>" alt="Thumbnail Nino">
                <div class="video-info">
                    <?php if ($publish != 1) : ?>
                        <div class="timer-dispo">
                            <span class="bold">Disponible dans</span>
                            <span class="timer bold Cr-Video-Home" id="cr-<?= $video['id'] ?>" data-dateSortie="<?= $video['publish'] ?>" data-idVid="<?= $video['id'] ?>">*****</span>
                        </div>
                    <?php else : ?>
                        <div class="video-title"><?= truncateText($video['titre'], 30) ?></div>
                        <div class="video-description"><?= truncateText($video['description'], 50) ?></div>
                    <?php endif; ?>
                </div>
            </div>
    <?php }
    } else {
        echo 'Aucune vidéo trouvé';
    }
    ?>
</div>

<script src="../javascripts/nino/cr_nino.js?0"></script>
<script type="text/javascript">
    document.querySelectorAll(".Cr-Video-Home").forEach((el, idx) => {
        setInterval(function() {
            let DateVid = $('#' + el.id).attr('data-dateSortie');
            compte_a_rebours(DateVid, "", "", el.id);
        }, 1000);
    });
</script>
<script src="../javascripts/nino/home.js?0"></script>