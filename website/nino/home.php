<link rel="stylesheet" href="<?= SITE_HTTP . "://" . SITE_URL ?>/css/nino.css">
<script>
    document.title = "Nino - Accueil";
</script>

<!-- <h1>Mes Vidéos</h1> -->

<div class="video-bloc">
    <?php
    require './base/nexus_base.php';
    $sql = 'SELECT * FROM luma_nino_data';
    $req = $pdo->prepare($sql);
    $req->execute();
    $result = $req->rowCount();

    if ($result >= 1) {
        while ($video = $req->fetch()) {
            if ($video['videoThumbnail'] == '' || $video['videoThumbnail'] == null) {
                $video['videoThumbnail'] = SITE_HTTP . "://" . SITE_URL . "/images/nino/no_image.jpg";
            }
    ?>
            <div class="video" data-idVideo="<?= $video['id'] ?>">
                <img src="<?= $video['videoThumbnail'] ?>" alt="Thumbnail Nino">
                <div class="video-info">
                    <div class="video-title"><?= $video['titre'] ?></div>
                    <div class="video-description"><?= $video['description'] ?></div>
                </div>
            </div>
    <?php }
    } else {
        echo 'Aucune vidéo trouvé';
    }
    ?>
</div>

<script src="../javascripts/nino/home.js"></script>


<!-- <div class="video">
    <img src="https://99designs-blog.imgix.net/blog/wp-content/uploads/2016/03/web-images.jpg?auto=format&q=60&w=1600&h=824&fit=crop&crop=faces" alt="Vidéo 1 Thumbnail">
    <div class="video-info">
        <div class="video-title">Titre de la Vidéo 1</div>
        <div class="video-description">Description de la vidéo 1. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
        <button class="subscribe-button">Regarder la vidéo</button>
    </div>
</div> -->