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
    $date = date('Y-m-d H:i:s');
    $status = 'publique';
    $sql = 'SELECT * FROM luma_nino_data WHERE id_video_uuid = :id_video_uuid && publish < :publish && status = :status ORDER BY publish DESC LIMIT 1';
    $req = $pdo->prepare($sql);
    $req->bindParam(':id_video_uuid', $id);
    $req->bindParam(':publish', $date);
    $req->bindParam(':status', $status);
    $req->execute();
    $result = $req->rowCount();

    if ($result === 1) :
        foreach ($req as $video) {
        }
?>
        <link rel="stylesheet" href="<?= SITE_HTTP . SITE_URL ?>/css/player.css?V0">
        <div class="video-container-player">
            <p class="info-popup">Fonction cinéma en ALPHA !! Des soucis d'affichages peuvent survenirs</p>
            <video class="video-player" id="Player" poster="https://<?= htmlspecialchars(trim($video['server_url'])) ?>/Thumbnail/<?= htmlspecialchars(trim($video['id_video_uuid'])) ?>">
            </video>
            <div id="customControls">
                <span id="progressBar" class="progress-bar progress-bar-fill-player"></span>
                <span id="progressBarLoader" class="progress-bar progress-bar-fill-loader"></span>
                <div class="controls-btn controls-left">
                    <i id="volume-low" class="fa-solid fa-volume-low disable"></i>
                </div>
                <div class="controls-btn controls-center">
                    <i id="back10SecBtn" class="fa-solid fa-clock-rotate-left"></i>
                    <i id="playPauseBtn" class="fas fa-play"></i>
                    <i id="skip10SecBtn" class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div class="controls-btn controls-right">
                    <i id="movies-screen" class="fa-solid fa-tv"></i>
                    <i id="fullscreenBtn" class="fas fa-expand disable" onclick="toggleFullScreen()"></i>
                </div>


            </div>
        </div>
   
        <div class="video-info">
            <h1><?= $video['titre']; ?></h1>
            <p class="description"><?= nl2br($video['description']); ?></p>

            <!-- <div class="like-buttons">
                <button><i class="far fa-thumbs-up"></i> Like</button>
                <button><i class="far fa-thumbs-down"></i> Unlike</button>
            </div> -->
        </div>

        <!-- SCRIPTS -->
        <script>
            document.title = "Nino - <?= $video['titre'] ?>";
        </script>
        <script src="<?= SITE_HTTP . SITE_URL ?>/javascripts/nino/player.js"></script>
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