<link rel="stylesheet" href="<?= SITE_HTTP . "://" . SITE_URL ?>/css/nino-edit.css?1">
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
        // URL de l'API que vous souhaitez interroger
        $apiUrl = 'https://dev.nino.mhemery.fr/check';

        // Effectuer la requête API avec file_get_contents
        $response = file_get_contents($apiUrl);

        // Vérifier si la requête a réussi
        if ($response === false) {
            // Gérer les erreurs, par exemple :
            die('API en erreur. Vérifier si celle-ci répond');
        }

        // Convertir la réponse JSON en tableau associatif
        $data = json_decode($response, true);

        if ($data['version'] < '1.0.0') {
            die('l\'API n\'est pas de la bonne version. Version requis 1.0.0');
        }
    } else {
        $ERROR_EDIT = 1;
    }
} else {
    header('Location: /');
}
?>

<?php if(!isset($ERROR_EDIT)): ?>
<form id="uploadForm" enctype="multipart/form-data">
    <p class="pops-api-use"><span id="apiuse"><?= $video['server_url']; ?></span></p>
    <p class="info-popup">La plupart des champs, sont en enregistrement automatiques. Vous avez juste à cliquer en dehors du champs</p>

    <input id="videoTitle" type="text" name="videoTitle" placeholder="Titre de la vidéo" value="<?= $video['titre']; ?>"></input>

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
        <video id="Player" src="" controls>

        </video>
        <div class="thumbnail-video">
            <img class="upload-image-select" id="imagePreview" style="display: none; max-width: 100%; max-height: 200px;">
            <!-- BTN UPLOAD miniature -->
            <span id="upload-image">
                <input style="display: none;" type="file" name="imageInput" id="imageInput">
                <i class="fa-solid fa-plus"></i>
            </span>
        </div>
    </div>

    <textarea name="videoDescription" id="videoDescription" cols="30" rows="5" placeholder="Ma description trop cool ici"><?= $video['description']; ?></textarea>

    <input id="tagInput" type="text" placeholder="Renseigne ton tag, puis fait entrée">
    <div id="tag-container">
        <?php
        if ($video['tag'] != "") :
            $tags = json_decode($video['tag']);

            if ($tags === null && json_last_error() !== JSON_ERROR_NONE) :
                // La conversion a échoué, gérer l'erreur ici
                echo 'Récupération des tag impossible';
            else :
                foreach ($tags as $tag) { ?>
                    <div class="tag"><?php if ($tag != "") {
                                            echo $tag;
                                        } ?></div>
        <?php }
            endif;
        endif; ?>
    </div>

    <div class="timezone-publication">
        <input type="datetime-local" id="datetimepicker" value="<?php
                                                                if (isset($video['publish'])) {
                                                                    echo date('Y-m-d\TH:i', strtotime($video['publish']));
                                                                }
                                                                ?>">
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
<?php else: ?>
    <h1>Aucune vidéo trouvé</h1>
<?php endif; ?>
<!-- SCRIPTS SRV -->
<script defer src="../javascripts/nino/edit_v2.js?3"></script>