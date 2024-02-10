<script>
    document.title = "Nino - Player";
</script>

<?php
$url = $_SERVER['REQUEST_URI'];
$parts = explode('/', $url);
$id = end($parts);

if (!isset($id) || $id == null) {
    echo '<h3>Vidéo non trouvé</h3>';
    echo '<img src="' . SITE_HTTP . '://' . SITE_URL . '/images/nino/404.jpg" style="width: 100%; height:40%">';
    // exit;
} else {
    require './base/nexus_base.php';
    $id = htmlspecialchars(trim($id));
    $sql = 'SELECT * FROM luma_nino_data WHERE id_video_uuid = :id_video_uuid && publish < "'.date('Y-m-d H:i:s').'" && status = "publique" ORDER BY publish DESC LIMIT 1';
    $req = $pdo->prepare($sql);
    $req->bindParam(':id_video_uuid', $id);
    $req->execute();
    $result = $req->rowCount();

    if ($result === 1) :
        foreach ($req as $video) {
        }
?>

        <div class="video-container">
            <video id="Player" poster="https://<?= htmlspecialchars(trim($video['server_url'])) ?>/Thumbnail/<?= htmlspecialchars(trim($video['id_video_uuid'])) ?>" controls></video>

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
            let url = "https://<?= htmlspecialchars(trim($video['server_url'])) ?>/<?= htmlspecialchars(trim($video['id_video_uuid'])) ?>"
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
    <?php else : ?>
        <div class="video-container">
            <video id="Player" poster="<?= SITE_HTTP . "://" . SITE_URL . "/images/nino/404.jpg" ?>" controls></video>

            <div class="video-info">
                <h1>Vidéo non disponible</h1>
                <p>Aucune vidéo disponible ici. Vous êtes perdu dans les petits tréfond de Nino ?</p>
            </div>
        </div>
<?php endif;
} ?>