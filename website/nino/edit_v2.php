<link rel="stylesheet" href="<?= SITE_HTTP . "://" . SITE_URL ?>/css/nino-edit_v2.css?0">
<script>
    document.title = "Nino - Édition d'une vidéo";
</script>

<?php
if (isset($_SESSION['authentification']['user'])) {
    require './base/nexus_base.php';
    $id_users = $_SESSION['authentification']['user']['id'];
    $id = $_GET['id'];
    $v = array('id_users' => $id_users, 'id' => $id);
    $sql = 'SELECT * FROM luma_nino_data WHERE id_users = :id_users AND id = :id';
    $req = $pdo->prepare($sql);
    $req->execute($v);
    $result = $req->rowCount();

    if ($result >= 1) {
        foreach ($req as $video) {
        }
    } else {
        echo 'Aucune vidéo trouvé';
    }
} else {
    header('Location: /');
}
?>

<!-- <div class="checkApi" data-UrlAPI="<?= $video['server_url']; ?>" data-idAPI="<?= $video['id_video_uuid']; ?>" data-Video="FALSE" onclick="SendDemCreation()">
    <div class="loadPopsIco loader"></div>
    <p class="loadText">
        Vérification de la présence du dossier dans l'API Nino
    </p>
</div> -->

<form id="uploadForm" enctype="multipart/form-data">

    <p class="info-popup">La plupart des champs, sont en enregistrement automatiques.</p>


    <input id="videoTitle" type="text" name="videoTitle" placeholder="Titre de la vidéo" value="<?= $video['titre']; ?>"></input>

    <div class="player-thumbnail">
        <div id="no-video">
            <p>L'API n'a détecté aucune vidéo. Vous pouvez uploader votre vidéo ici maintenant !</p>
            <div class="btn-upload-video">
                <span class="upload" data-encoded="false">
                    <i class="fa-solid fa-upload"></i>
                    Vidéo encodé
                </span>
                <span class="upload" data-encoded="true">
                    <i class="fa-solid fa-upload"></i>
                    Vidéo non encodé
                </span>
            </div>
        </div>
        <video src="" controls>

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
    <div id="tag-container"></div>

    <div class="timezone-publication">
        <input type="date" id="datepicker" value="<?php
                                                    if (isset($video['publish'])) {
                                                        echo date('Y-m-d', strtotime($video['publish']));
                                                    }
                                                    ?>">

        <input type="time" id="timepicker" value="<?php
                                                    if (isset($video['publish'])) {
                                                        echo date('H:i', strtotime($video['publish']));
                                                    }
                                                    ?>">
        <select name="videoStatus" id="videoStatus">
            <option selected hidden value="<?= $video['status']; ?>">Choisir si la vidéo est visible ou non</option>
            <?php if ($video['status'] !== "") : ?>
                <option selected value="<?= $video['status']; ?>"><?= ucfirst($video['status']); ?></option>
            <?php endif; if ($video['status'] === "publique") : ?>
                <option value="hide">Ne plus publier la vidéo</option>
            <?php else : ?>
                <option value="publique">Publier la vidéo</option>
            <?php endif; ?>
            <option value="reserved">Privé</option>
        </select>
    </div>
    <!-- <script>
        $(document).ready(function() {
            $('#datepicker, #timepicker').on('input', function() {
                // Gérer la logique lorsque la date ou l'heure change
                const selectedDate = $('#datepicker').val();
                const selectedTime = $('#timepicker').val();

                console.log("Date sélectionnée:", selectedDate);
                console.log("Heure sélectionnée:", selectedTime);
            });
        });
    </script> -->
</form>





<!-- <form id="uploadForm" enctype="multipart/form-data">

    <p class="info-popup">L'upload automatiques des vidéos n'est pas encore disponible depuis le site.<br> Vous devez utiliser le module d'encodage pour procéder à l'upload des vidéos... quand celui-ci sera fonctionnel.</p>

    <label for="serveurURL">Ou se trouve la vidéo ?</label>
    <select name="serveurURL" id="serveurURL" class="custom-select">
        <option value="<?= $video['server_url']; ?>"><?= $video['server_url']; ?> || Provisoire</option>
        <option value="nino.mhemery.fr">Nino PROD</option>
        <option value="dev.nino.mhemery.fr">Nino DEV</option>
        <option value="nino.enerzein.fr">Nino EXT 2 (Steven)</option>
    </select>

    <label for="UUID_nino">ID de la vidéo</label>
    <p class="input_text"><?= $video['id_video_uuid']; ?></p>
    <input type="text" id="UUID_nino" name="UUID_nino" value="<?= $video['id_video_uuid']; ?>" hidden>

    <label for="videoTitle">Titre de la Vidéo :</label>
    <input type="text" id="videoTitle" name="videoTitle" value="<?= $video['titre']; ?>" required>

    <label for="videoDescription">Description :</label>
    <textarea id="videoDescription" name="videoDescription" rows="4"><?= $video['description']; ?></textarea>

    <label for="imageInput">Sélectionnez une image :</label>
    <?php if (isset($video['videoThumbnail']) && $video['videoThumbnail'] !== "") : ?>
        <img width="100%" src="<?= $video['videoThumbnail'] ?>" alt="Thumbnail Nino">
    <?php endif; ?>
    
    <input type="file" name="image" id="imageInput" accept="image/*" value="<?= $video['videoThumbnail']; ?>">

    <label for="videoTags">Tags (séparés par des virgules) :</label>
    <input type="text" id="videoTags" name="videoTags" value="<?= $video['tag']; ?>">

    <label for="videoStatus">Status de la vidéo</label>
    <select name="videoStatus" id="videoStatus" class="custom-select">
        <option selected hidden value="<?= $video['status']; ?>">Choisir si la vidéo est visible ou non</option>
        <?php if ($video['status'] === "publique") : ?>
        <option value="hide">Ne plus publier la vidéo</option>
        <?php else : ?>
        <option value="publique">Publier la vidéo</option>
        <?php endif; ?>
        <option value="reserved">Réservé</option>
    </select>

    <label for="videoPublish">Date de publication (Heure par default: 12h00) :</label>
    <input type="date" id="videoPublish" name="videoPublish" value="<?php if (isset($video['publish']) || $video['publish'] != "" || $video['publish'] != null) {
                                                                        echo date('Y-m-d', strtotime($video['publish']));
                                                                    } ?>">

    <button type="submit" id="btnEditVideo" data-idvideo="<?= $_GET['id'] ?>">Enregistrer les modifications</button>
</form> -->

<!-- SCRIPTS SRV -->
<script src="../javascripts/nino/edit_v2.js?0"></script>