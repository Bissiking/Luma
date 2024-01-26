<?php
session_start();
// Récupération de l'URL
$url = $_SERVER['REQUEST_URI'];

if (isset($_SERVER['HTTP_X_FORWARDED_SCHEME']) || isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] = "on") {
    $uriHttp = 'https://';
} else {
    $uriHttp = 'http://';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'lib/router.php';
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- LINK -->
    <?php if (strpos($url, 'nino') !== false) : ?>
        <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/nino.css?v=0">
    <?php elseif(strpos($url, 'admin') !== false): ?>
        <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/admin.css?v=0">
    <?php else: ?>
        <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/style.css?v=0">
    <?php endif; ?>
    <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/popupv2.css?v=0">
    <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/all.min.css?v=0">
    <link rel="icon" type="image/png" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/images/nexus30.png" />
    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- TITLE -->
    <title>Luma Projet</title>
</head>

<body>
    <header>
        <div>
            <span id="logo"><?php if (strpos($url, 'nino') !== false) { ?> <img src="/images/nino75.png"> <?php } else { ?> LUMA <?php } ?></span>
        </div>

        <nav>
            <?php if (strpos($url, 'admin') !== false) : ?>
                <a href="/admin">Dashboard</a>
            <?php elseif (strpos($url, 'nino') !== false) : ?>
                <a href="/nino">Accueil Nino</a>
                <a style="color:grey" href="#">Bibliothèque</a>
                <a style="color:grey" href="#">Historique</a>
            <?php else : ?>
                <a href="/">Accueil LUMA</a>
                <a href="/nino">Nino</a>
                <a style="color:grey" href="#">Serveur</a>
                <a style="color:grey" href="#">A propos</a>
            <?php endif; ?>
        </nav>

        <!-- Icône représentant un compte non connecté -->
        <img id="profileIcon" src="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/images/user-offline.png" alt="Icône de Profil">

        <!-- Menu déroulant pour le profil -->
        <ul id="profileMenu">
            <i class="fa-solid fa-sort-up"></i>

            <?php if (isset($_SESSION['authentification']['user'])) : ?>
                <?php if (strpos($url, 'nino') !== false) : ?>
                    <li><a href="/nino/add">Ajouter une vidéo</a></li>
                <?php elseif (strpos($url, 'admin') !== false) : ?>
                    <li><a style="color:grey" href="#">Admin Notification</a></li>
                    <li><a style="color:grey" href="#">Log système</a></li>
                <?php else: ?>
                    <li><a href="/admin">Administration du site</a></li>
                    <li><a style="color:grey" href="#">Configurer le Profil</a></li>
                <?php endif; ?>
                <li><a href="/connexion?logout">Se déconnecter</a></li>
            <?php else : ?>
                <li><a href="/connexion">Se connecter</a></li>
            <?php endif; ?>

            <!-- NINO MENU -->
            <?php if (strpos($url, 'nino') !== false) : ?>
                <li><a href="/">Retour à LUMA</a></li>
            <?php endif; ?>
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
    <script src="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/javascripts/popupv2.js"></script>
    <script src="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/javascripts/all-pages.js"></script>

    <footer>
        <p>&copy; 2023 HEMERY Mathéo</p>
    </footer>
</body>

</html>