<link rel="stylesheet" href="<?= SITE_HTTP . "://" . SITE_URL ?>/css/nino.css">
<script>
    document.title = "Nino - Player";
</script>

<?php

if (!isset($_GET['video']) || $_GET['video'] == null) {
    echo '<h3>Vidéo non trouvé</h3>';
    echo '<img src="' . SITE_HTTP . '://' . SITE_URL . '/images/nino/404.jpg" style="width: 100%; height:40%">';
    // exit;
} else {

    require './base/nexus_base.php';
    $id = htmlspecialchars(trim($_GET['video']));
    $sql = "SELECT * FROM luma_nino_data WHERE id = $id";
    $req = $pdo->prepare($sql);
    $req->execute();
    $result = $req->rowCount();
    foreach ($req as $video) {
    }

    if ($video['videoThumbnail'] == '' || $video['videoThumbnail'] == null) {
        $video['videoThumbnail'] = SITE_HTTP . "://" . SITE_URL . "/images/nino/no_image.jpg";
    }
?>

    <div class="video-container">
        <video id="Player" poster="<?= $video['videoThumbnail']; ?>" controls></video>

        <div class="video-info">
            <h1><?= $video['titre']; ?></h1>
            <p><?= $video['description']; ?></p>

            <div class="like-buttons">
                <button><i class="far fa-thumbs-up"></i> Like</button>
                <button><i class="far fa-thumbs-down"></i> Unlike</button>
            </div>
        </div>
    </div>
    <!-- FEATURES -->
    <!-- <div class="video-list">
    <div class="video-list-item">
        <img src="https://99designs-blog.imgix.net/blog/wp-content/uploads/2016/03/web-images.jpg?auto=format&q=60&w=1600&h=824&fit=crop&crop=faces" alt="Vidéo 1 Thumbnail">
        <div>
            <h3>Titre de la Vidéo 1</h3>
            <p>Description de la vidéo 1. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
    </div>

    <div class="video-list-item">
        <img src="https://99designs-blog.imgix.net/blog/wp-content/uploads/2016/03/web-images.jpg?auto=format&q=60&w=1600&h=824&fit=crop&crop=faces" alt="Vidéo 2 Thumbnail">
        <div>
            <h3>Titre de la Vidéo 2</h3>
            <p>Description de la vidéo 2. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
    </div> -->

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script>
        let url = "https://nino.mhemery.fr/<?= htmlspecialchars(trim($_GET['video'])) ?>"
        var id = new URL(url).pathname;
        const video = document.getElementById('Player');
        const videoSrc = url + '/nino.m3u8';
        if (Hls.isSupported()) {
            const hls = new Hls();
            hls.loadSource(videoSrc);
            hls.attachMedia(video);
            hls.on(Hls.Events.MANIFEST_PARSED, () => {});
        } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
            video.src = videoSrc;
            video.addEventListener('loadedmetadata', () => {});
        }
    </script>
<?php } ?>