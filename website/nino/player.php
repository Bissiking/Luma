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
        <link rel="stylesheet" href="<?= SITE_HTTP . SITE_URL ?>/css/player.css?V2">



        <div class="block-player-data">
            <!-- 
            <figure id="videoContainer">
                <video id="video" preload="metadata" poster="https://dev.nino.mhemery.fr/Thumbnail/video_65e4138e872a66.23638586">
                </video>
                <ul id="video-controls" class="controls">
                    <li><button id="playpause" type="button">Play/Pause</button></li>
                    <li><button id="stop" type="button">Stop</button></li>
                    <li class="progress">
                        <progress id="progress" value="0" min="0">
                            <span id="progress-bar"></span>
                        </progress>
                    </li>
                    <li><button id="mute" type="button">Mute/Unmute</button></li>
                    <li><button id="volinc" type="button">Vol+</button></li>
                    <li><button id="voldec" type="button">Vol-</button></li>
                    <li><button id="fs" type="button">Fullscreen</button></li>
                </ul>
            </figure> -->

            <!-- OLD -->
            <figure id="videoContainer" class="video-container-player">
                <video class="video-player VideoHeightMax" id="Player" poster="https://<?= htmlspecialchars(trim($video['server_url'])) ?>/Thumbnail/<?= htmlspecialchars(trim($video['id_video_uuid'])) ?>">
                </video>
                <div id="customControls" data-fullscreen="false">
                    <span id="progressBar" class="progress-bar progress-bar-fill-player">
                        <span id="timer-player-progress-video" class="timer-player">0:00</span>
                        <span id="timer-player-total-video" class="timer-player">0:00</span>
                    </span>
                    <span id="progressBarLoader" class="progress-bar progress-bar-fill-loader"></span>
                    <div class="controls-btn controls-left">
                        <i id="volume-mute" class="fa-solid fa-volume-low"></i>
                        <div class="slider-container">
                            <input type="range" min="0" max="100" value="50" class="slider" id="volumeSlider">
                        </div>
                    </div>
                    <div class="controls-btn controls-center">
                        <i id="back10SecBtn" class="fa-solid fa-clock-rotate-left"></i>
                        <i id="playPauseBtn" class="fas fa-play"></i>
                        <i id="skip10SecBtn" class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <div class="controls-btn controls-right">
                        <span class="TimeEnd">Se termine à <span id="TimeEndVideo">**:**</span></span>
                        <i id="PiP" class="fa-solid fa-window-restore"></i>
                        <i id="fullscreenBtn" class="fas fa-expand"></i>
                    </div>
                </div>
            </figure>

            <script>
                // Fonction pour basculer en mode plein écran
                document.addEventListener("DOMContentLoaded", function() {
                    var videoContainer = document.getElementById("videoContainer");
                    var fsButton = document.getElementById("fullscreenBtn");

                    fsButton.addEventListener("click", function() {
                        if (document.fullscreenElement) {
                            document.exitFullscreen();
                        } else {
                            if (videoContainer.requestFullscreen) {
                                videoContainer.requestFullscreen();
                            } else if (videoContainer.webkitRequestFullscreen) {
                                /* Safari */
                                videoContainer.webkitRequestFullscreen();
                            } else if (videoContainer.msRequestFullscreen) {
                                /* IE11 */
                                videoContainer.msRequestFullscreen();
                            }
                        }
                    });
                });
            </script>

            <div class="video-info">
                <h1><?= $video['titre']; ?></h1>
                <p class="description"><?= nl2br($video['description']); ?></p>

                <!-- <div class="like-buttons">
                <button><i class="far fa-thumbs-up"></i> Like</button>
                <button><i class="far fa-thumbs-down"></i> Unlike</button>
            </div> -->
            </div>
        </div>
        <div class="block-video-list">
            <div class="video-bloc">
                <?php
                $sql_reco = 'SELECT * FROM luma_nino_data WHERE status = "publique" ORDER BY publish DESC LIMIT 5';
                $req_reco = $pdo->prepare($sql_reco);
                $req_reco->execute();
                $result_reco = $req_reco->rowCount();
                if ($result_reco >= 1) {
                    require_once('./lib/truncateText.php');
                    while ($video_reco = $req_reco->fetch()) {
                        $PublishVid_reco = $video_reco['publish'];
                        $HeureLocal_reco = date('Y-m-d H:i:s');
                        if ($HeureLocal_reco <= $PublishVid_reco) {
                            $publish_reco = 0;
                        } else {
                            $publish_reco = 1;
                            if ($video_reco['videoThumbnail'] == '' || $video_reco['videoThumbnail'] == null) {
                                $video_reco['videoThumbnail'] = SITE_HTTP . "://" . SITE_URL . "/images/nino/no_image.jpg";
                            }
                ?>
                            <a href="<?= SITE_HTTP . SITE_URL . "/nino/player/" . $video_reco['id_video_uuid'] ?>" class="video" data-idVideo="<?= $video_reco['id_video_uuid'] ?>" data-status="<?= $publish_reco ?>">
                                <img <?php if ($publish_reco != 1) {
                                            echo 'class="blur"';
                                        } ?> src="<?= 'https://' . $video_reco['server_url'] . '/Thumbnail/' . $video_reco['id_video_uuid'] ?>" alt="Thumbnail Nino">
                                <div class="video-info">
                                    <div class="video-title"><?= truncateText($video_reco['titre'], 30) ?></div>
                                </div>
                            </a>
                        <?php
                        }

                        ?>
                <?php }
                } else {
                    echo 'Aucune vidéo trouvé';
                }
                ?>
            </div>
        </div>
        <!-- SCRIPTS -->
        <script>
            document.title = "Nino - <?= $video['titre'] ?>";
        </script>
        <script defer src="<?= SITE_HTTP . SITE_URL ?>/javascripts/nino/player.js?1"></script>
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