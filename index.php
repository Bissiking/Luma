<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
// Récupération de l'URL
$url = $_SERVER['REQUEST_URI'];

if (strpos($url, 'api') !== false) {
    // Autoriser toutes les origines
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type');
    require_once 'lib/router';
    exit;
}

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
    <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/all-page.css?v=2">
    <?php if (strpos($url, 'nino') !== false) : ?>
        <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/nino.css?v=1">
        <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/mobile/nino.css?v=0">
    <?php elseif (strpos($url, 'agent') !== false) : ?>
        <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/agent.css?v=1">
    <?php elseif (strpos($url, 'admin') !== false) : ?>
        <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/admin.css?v=1">
        <!-- PROVISOIRE -->
        <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/style.css?v=1">
    <?php else : ?>
        <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/style.css?v=1">
    <?php endif; ?>
    <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/popupv2.css?v=0">
    <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/all.min.css?v=0">
    <link rel="icon" type="image/png" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/images/nexus30.png" />
    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- TITLE -->
    <title>Luma Projet</title>
</head>

<body>
    <header id="desktop-header">
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
                <?php else : ?>
                    <li><a href="/admin">Administration du site</a></li>
                    <li><a href="/agent">Gestions des agents</a></li>
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

    <!-- MOBILE MENU -->
    <header id="mobile-header">
        <nav>
            <a href="/nino"><i class="fa-solid fa-house"></i></a>
            <a style="color: grey"><i class="fa-solid fa-bookmark"></i></a>
            <a style="color: grey"><i class="fa-solid fa-clock-rotate-left"></i></a>
            <div id="btnMenuMobile" onclick="BtnMenuMobile()">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
        <div id="MenuMobile" data-open="close">
            <?php if (strpos($url, 'nino') !== false) { ?> <img src="/images/nino75.png"> <?php } ?>
            <?php if (isset($_SESSION['authentification']['user'])) : ?>
                <a href="/nino/add">Ajouter une vidéo</a>
                <a href="/connexion?logout">Se déconnecter</a>
            <?php else : ?>
                <a href="/connexion">Se connecter</a>
            <?php endif; ?>
            <a href="/">Retour à LUMA</a>
        </div>
    </header>

    <main id="main">
        <?php require_once 'lib/router.php'; ?>
    </main>

    <!-- Vos scripts JavaScript vont ici -->
    <script src="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/javascripts/popupv2.js"></script>
    <script src="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/javascripts/all-pages.js?2"></script>

    <footer>
        &copy; 2023 HEMERY Mathéo
    </footer>
</body>

</html>