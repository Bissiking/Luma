<link rel="stylesheet" href="<?= SITE_HTTP . "://" . SITE_URL ?>/css/nino.css">
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
    echo 'Connexion obligatoire';
}
?>

<form id="uploadForm" enctype="multipart/form-data">

    <label for="serveurURL">Ou se trouve la vidéo ?</label>
    <select name="serveurURL" id="serveurURL" class="custom-select">
        <option value="nino.mhemery.fr">Nino PROD</option>
        <option value="dev.nino.mhemery.fr">Nino DEV</option>
        <option value="nino.enerzein.fr">Nino EXT 2 (Steven)</option>
    </select>

    <input type="text" id="UUID_nino" name="UUID_nino" value="<?= $video['id_video_uuid']; ?>" hidden>

    <label for="videoTitle">Titre de la Vidéo :</label>
    <input type="text" id="videoTitle" name="videoTitle" value="<?= $video['titre']; ?>" required>

    <label for="videoDescription">Description :</label>
    <textarea id="videoDescription" name="videoDescription" rows="4"><?= $video['description']; ?></textarea>
    <!-- 
    <label for="videoThumbnail">Upload miniature :</label>
    <input type="file" id="videoThumbnail" name="videoThumbnail" accept="image/*"> -->

    <label for="imageInput">Sélectionnez une image :</label>
    <input type="file" name="image" id="imageInput" accept="image/*" value="<?= $video['videoThumbnail']; ?>">
    <!-- <button type="button" id="uploadButton">Uploader l'image</button> -->

    <label for="videoTags">Tags (séparés par des virgules) :</label>
    <input type="text" id="videoTags" name="videoTags" value="<?= $video['tag']; ?>">

    <button type="submit" id="btnEditVideo" data-idvideo="<?= $_GET['id'] ?>">Enregistrer les modifications</button>
</form>

<!-- SCRIPTS SRV -->
<script src="../javascripts/nino/edit.js"></script>