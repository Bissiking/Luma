<link rel="stylesheet" href="<?= SITE_HTTP."://".SITE_URL ?>/css/nino.css">
<script>
	document.title = "Nino - Édition d'une vidéo";
</script>

<?php 

echo '<pre>';
print_r($_GET);
echo'</pre>';

    $apiUrl = "https://nino.mhemery.fr/api/videos";

    $response = file_get_contents($apiUrl);
    $data = json_decode($response);

    if ($data) {
        foreach ($data as $video) {}
    }

?>

<form action="#" method="POST" enctype="multipart/form-data">
    <label for="videoTitle">Titre de la Vidéo :</label>
    <input type="text" id="videoTitle" name="videoTitle" required>

    <label for="videoDescription">Description :</label>
    <textarea id="videoDescription" name="videoDescription" rows="4" required></textarea>

    <label for="videoThumbnail">Upload miniature :</label>
    <input type="file" id="videoThumbnail" name="videoThumbnail" accept="image/*">

    <label for="videoTags">Tags (séparés par des virgules) :</label>
    <input type="text" id="videoTags" name="videoTags">

    <button id="btnEditVideo" data-id_users="<?= $_SESSION['authentification']['user']['id'] ?>">Enregistrer les modifications</button>
</form>

<!-- SCRIPTS SRV -->
<script src="../javascripts/nino/edit.js"></script>