<?php
    session_start();
    $url = $_SERVER['REQUEST_URI'];

    if (isset($_SERVER['HTTP_X_FORWARDED_SCHEME'])) {
        $uriHttp = 'https://';
    }else{
        $uriHttp = 'http://';
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- LINK -->
    <?php if (strpos($url, 'nino') !== false) { ?>
        <link rel="stylesheet" href="<?= $uriHttp.$_SERVER['HTTP_HOST'] ?>/css/nino.css">
    <?php } else { ?>
        <link rel="stylesheet" href="<?= $uriHttp.$_SERVER['HTTP_HOST'] ?>/css/style.css">
    <?php } ?>
    <link rel="stylesheet" href="<?= $uriHttp.$_SERVER['HTTP_HOST'] ?>/css/all.min.css">
    <link rel="icon" type="image/png" href="<?= $uriHttp.$_SERVER['HTTP_HOST'] ?>/images/nexus30.png" />
    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Luma Projet</title>
</head>
<body>
    <header>
        <div>
            <span id="logo"><?php if (strpos($url, 'nino') !== false) { ?> <img src="/images/nino75.png"> <?php }else{ ?> LUMA <?php } ?></span>
        </div>

        <nav>
            <a href="/">Accueil</a>
            <?php if (strpos($url, 'nino') !== false) { ?>
                <a  style="color:grey" href="#">Bibliothèque</a>
                <a  style="color:grey" href="#">Historique</a>
                <a href="/nino/add">Ajouter une vidéo</a>
            <?php }else{ ?>
                <a href="/nino">Nino</a>
                <a style="color:grey" href="#">Serveur</a>
                <a style="color:grey" href="#">A propos</a>
            <?php } ?>
        </nav>

        <!-- Icône représentant un compte non connecté -->
        <img id="profileIcon" src="<?= $uriHttp.$_SERVER['HTTP_HOST'] ?>/images/user-offline.png" alt="Icône de Profil">
        
        <!-- Menu déroulant pour le profil -->
        <ul id="profileMenu">
            <i class="fa-solid fa-sort-up"></i>
            <li><a href="/admin">Administration du site</a></li>
            <?php if (isset($_SESSION['authentification']['user'])) { ?>
                <li><a style="color:grey" href="#">Configurer le Profil</a></li>
                <li><a style="color:grey" href="#">Autres Options</a></li>
            <?php }else{ ?>
                <li><a href="/connexion">Se connecter</a></li>
            <?php } ?>
        </ul>

    </header>

    <main>
        <?php require_once 'lib/router.php'; ?>
    </main>

    <!-- Popup d'erreur ou de réussite -->
    <div id="popup" class="popup">
        <div id="popup-content" class="popup-content">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <p id="popup-message"></p>
        </div>
    </div>

    <!-- Vos scripts JavaScript vont ici -->
    <script src="<?= $uriHttp.$_SERVER['HTTP_HOST'] ?>/javascripts/popup.js"></script>
    <script src="<?= $uriHttp.$_SERVER['HTTP_HOST'] ?>/javascripts/all-pages.js"></script>

    <footer>
        <p>&copy; 2023 HEMERY Mathéo</p>
    </footer>
</body>
</html>
