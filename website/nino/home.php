<link rel="stylesheet" href="<?= SITE_HTTP."://".SITE_URL ?>/css/nino.css">
<script>
	document.title = "Nino - Accueil";
</script>

<!-- <h1>Mes Vidéos</h1> -->

<div class="video-bloc">
    <?php $apiUrl = "https://nino.mhemery.fr/api/videos";

    // Effectuez la requête vers l'API YouTube
    $response = file_get_contents($apiUrl);
    $data = json_decode($response);

    // Vérifiez si la requête a réussi
    if ($data) {
        // Affichez les vidéos
        foreach ($data as $video) {

            $videoId = $video->id;
            $videoTitle = $video->title;
            $videoDescription = $video->description;
            $videoThumbnail = "https://99designs-blog.imgix.net/blog/wp-content/uploads/2016/03/web-images.jpg?auto=format&q=60&w=1600&h=824&fit=crop&crop=faces";
            // URL Image

            echo "<div class='video'>";
            echo "<img src='{$videoThumbnail}' alt='{$videoTitle}'>";
            echo "<div class='video-info'>";
            echo "<div class='video-title'>{$videoTitle}</div>";
            echo "<div class='video-description'>{$videoDescription}</div>";
            echo "</div></div>";
        }
    } else {
        echo "Erreur lors de la récupération des vidéos. Soit il n'y a pas de vidéo, soit l'API est en maintenance. Retente plus tard";
    } ?> 
</div>


<!-- <div class="video">
    <img src="https://99designs-blog.imgix.net/blog/wp-content/uploads/2016/03/web-images.jpg?auto=format&q=60&w=1600&h=824&fit=crop&crop=faces" alt="Vidéo 1 Thumbnail">
    <div class="video-info">
        <div class="video-title">Titre de la Vidéo 1</div>
        <div class="video-description">Description de la vidéo 1. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
        <button class="subscribe-button">Regarder la vidéo</button>
    </div>
</div> -->