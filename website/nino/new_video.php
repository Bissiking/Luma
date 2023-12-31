<link rel="stylesheet" href="<?= SITE_HTTP."://".SITE_URL ?>/css/nino.css">
<script>
	document.title = "Nino - Ajouter une vidéo";
</script>

<h1>Ajouter une vidéo</h1>
<form action="#" method="POST">
    <label for="videoTitle">Titre de la Vidéo :</label>
    <input type="text" id="videoTitle" name="videoTitle" required>

    <?php if (isset($_SESSION['authentification']['user'])) { ?>
        <button type="button" onclick="reserveVideo()" id="btnReserveVideo" data-id_users="<?= $_SESSION['authentification']['user']['id'] ?>">Soumettre</button>
            <?php }else{ ?>
        <button style="background-color: grey;">Connexion obligatoire</button>
    <?php } ?>
    
</form>

<div id="result"></div>

<!-- SCRIPTS SRV -->
<script src="../javascripts/nino/add.js"></script>