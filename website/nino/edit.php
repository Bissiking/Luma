<link rel="stylesheet" href="<?= SITE_HTTP . SITE_URL ?>/css/nino-edit.css?2">
<script>
    document.title = "Nino - Édition d'une vidéo";
</script>
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>

<?php
if (isset($_SESSION['authentification']['user'])) {
    require './base/nexus_base.php';
    $id_users = $_SESSION['authentification']['user']['id'];
    $id = $_GET['id'];
    $v = array('id_users' => $id_users, 'id_video_uuid' => $id);
    $sql = 'SELECT * FROM luma_nino_data WHERE id_users = :id_users AND id_video_uuid = :id_video_uuid';
    $req = $pdo->prepare($sql);
    $req->execute($v);
    $result = $req->rowCount();

    if ($result >= 1) {
        foreach ($req as $video) {
        }
        $apiUrl = "https://".$video['server_url']."/check";

        $options = [
            'http' => [
                'timeout' => 1, // Timeout en secondes
            ],
        ];

        // Création du contexte
        $context = stream_context_create($options);

        // Récupération du contenu avec gestion du timeout
        $content = @file_get_contents($apiUrl, false, $context);

        if ($content === false) {
            // Gérer les erreurs en fonction de la raison de l'échec
            $error = error_get_last();
            if ($error !== null && strpos($error['message'], 'timed out') !== false) {
                // Gérer le timeout
                $ERROR_EDIT = 1;
                $message_Error = "L\'API à mis trop de temps à répondre.\n";
            } else {
                // Gérer d'autres erreurs
                $ERROR_EDIT = 1;
                $message_Error = "Une erreur s'est produite lors de la récupération de la version de l'API = " . $apiUrl;
            }
        } else {
            // Utiliser le contenu récupéré
            $data = json_decode($content, true);
            if ($data['version'] < '1.0.0') {
                $ERROR_EDIT = 1;
                $message_Error = 'l\'API n\'est pas de la bonne version. <br>Version minimal exigé: 1.0.0';
            }
        }
    } else {
        $ERROR_EDIT = 1;
        $message_Error = 'Aucune vidéo trouvé';
    }
} else {
    header('Location: /');
}
?>

<?php if (!isset($ERROR_EDIT)) : ?>
    <form id="uploadForm" enctype="multipart/form-data">
        <p class="pops-api-use"><span id="apiuse"><?= $video['server_url']; ?></span></p>
        <p class="info-popup">La plupart des champs, sont en enregistrement automatiques. Vous avez juste à cliquer en dehors du champs</p>

        <input id="videoTitle" type="text" name="videoTitle" placeholder="Titre de la vidéo" placeholder="Récupération des informations ...."></input>

        <div class="player-thumbnail">
            <div id="no-video">
                <p>L'API n'a détecté aucune vidéo. <!-- Vous pouvez uploader votre vidéo ici maintenant ! --></p>
                <div class="btn-upload-video">
                    <span id="upload-video-btn-1" class="upload" data-encoded="false">
                        <i class="fa-solid fa-upload"></i>
                        <input type="file" id="videoUP01" name="videoUP01" accept="video/*" style="display: none;">
                        Vidéo non encodé
                    </span>
                    <span class="upload" data-encoded="true">
                        <i class="fa-solid fa-upload"></i>
                        Vidéo encodé (Non disponible)
                    </span>
                </div>
            </div>
            <video id="Player" src="" poster="https://<?= $video['server_url']; ?>/Thumbnail/<?= $video['id_video_uuid']; ?>" controls width="85%"></video>
            <div class="thumbnail-video">
                <img class="upload-image-select" id="imagePreview" style="display: none; max-width: 100%; max-height: 200px;">
                <!-- BTN UPLOAD miniature -->
                <span id="upload-image">
                    <input style="display: none;" type="file" name="imageInput" id="imageInput">
                    <i class="fa-solid fa-plus"></i>
                </span>
            </div>
        </div>

        <textarea name="videoDescription" id="videoDescription" cols="30" rows="5" placeholder="Récupération des informations ...."></textarea>

        <input id="tagInput" type="text" placeholder="Renseigne ton tag, puis fait entrée ou espace">
        <div id="tag-container"></div>

        <div class="timezone-publication">
            <input type="datetime-local" id="datetimepicker">
            <select name="videoStatus" id="videoStatus">
                <option selected hidden value="<?= $video['status']; ?>">Choisir si la vidéo est visible ou non</option>
                <?php if ($video['status'] !== "") : ?>
                    <option selected value="<?= $video['status']; ?>"><?= ucfirst($video['status']); ?></option>
                <?php endif;
                if ($video['status'] === "publique") : ?>
                    <option value="hide">Ne plus publier la vidéo</option>
                <?php else : ?>
                    <option value="publique">Publier la vidéo</option>
                <?php endif; ?>
                <option value="reserved">Privé</option>
            </select>
        </div>
    </form>
    <!-- SCRIPTS SRV -->
    <script defer src="../javascripts/nino/edit_v2.js?6"></script>
<?php else : ?>
    <h1 class="error"><?= $message_Error ?></h1>
<?php endif; ?>