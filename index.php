<?php
session_start();
date_default_timezone_set('Europe/Paris');
header('Content-Type: text/html; charset=utf-8');
// Récupération de l'URL
$url = $_SERVER['REQUEST_URI'];

if (strpos($url, 'api') !== false) {
    // Autoriser toutes les origines
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type');
    require 'lib/router.php';
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
    <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/all-page.css?v=4">
    <?php if (strpos($url, 'nino') !== false) : ?>
        <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/nino.css?v=1">
        <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/mobile/nino.css?v=0">
    <?php elseif (strpos($url, 'agent') !== false) : ?>
        <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/agent.css?v=2">
    <?php elseif (strpos($url, 'admin') !== false) : ?>
        <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/admin.css?v=2">
        <!-- PROVISOIRE -->
        <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/style.css?v=3">
    <?php else : ?>
        <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/style.css?v=3">
    <?php endif; ?>
    <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/popupv2.css?v=0">
    <link rel="stylesheet" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/css/all.min.css?v=0">
    <link rel="icon" type="image/png" href="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/images/luma/luma75.png" />
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
            <div id="menu-luma" onclick="BtnMenu('menu-luma')" data-windows="MenuLUMA">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>

        <!-- Icône représentant un compte non connecté -->
        <img id="profileIcon" src="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/images/user-offline.png" alt="Icône de Profil">

        <!-- Menu déroulant pour le profil -->
        <ul id="profileMenu">
            <i class="fa-solid fa-sort-up"></i>

            <!-- NINO MENU -->
            <?php if (strpos($url, 'nino') !== false) : ?>
                <li><a href="/">Retour à LUMA</a></li>
            <?php endif; ?>
        </ul>

        <div id="MenuLUMA" data-open="close">
            <h4>Nouveau menu !!</h4>
            <a href="/" class="block-url">
                <img src="/images/luma/luma75.png">
                <p>LUMA</p>
            </a>
            <a href="/nino" class="block-url">
                <img src="/images/nino75.png">
                <p>Nino</p>
            </a>

            <?php if (isset($_SESSION['authentification']['user'])) : ?>
                <h4>Options</h4>
                <?php if (strpos($url, 'nino') !== false) : ?>
                    <a href="/nino/add" class="block-url">
                        <i class="fa-solid fa-square-plus"></i>
                        <p>Ajouter une vidéo</p>
                    </a>
                <?php elseif (strpos($url, 'admin') !== false) : ?>
                    <a href="#" class="block-url">
                        <i style="color:grey" class="fa-solid fa-bell"></i>
                        <p>Admin Notification</p>
                    </a>
                    <a href="#" class="block-url">
                        <i style="color:grey" class="fa-regular fa-file-lines"></i>
                        <p>Log système</p>
                    </a>
                <?php else : ?>
                    <!-- Si connecté et url n'est pas 'NINO' -->
                    <a href="/agent" class="block-url">
                        <i class="fa-solid fa-jug-detergent"></i>
                        <p>Gestion des agents</p>
                    </a>

                    <a href="#" class="block-url">
                        <i style="color:grey" class="fa-regular fa-address-card"></i>
                        <p>Configurer le Profil</p>
                    </a>
                <?php endif; ?>
                <?php if ($_SESSION['authentification']['user']['account_administrator'] === 1) : ?>
                    <!-- Si Administrateur -->
                    <a href="/admin" class="block-url">
                        <i class="fa-solid fa-toolbox"></i>
                        <p>LUMA Administration</p>
                    </a>
                <?php endif; ?>
                <h4>Déconnexion</h4>
                <a href="/connexion?logout" class="block-url">
                    <i class="fa-solid fa-door-open"></i>
                    <p>Se déconnecter</p>
                </a>
            <?php else : ?>
                <h4>Connexion</h4>
                <a href="/connexion" class="block-url">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <p>Se connecter</p>
                </a>
            <?php endif; ?>

        </div>
    </header>

    <!-- MOBILE MENU -->
    <header id="mobile-header">
        <nav>
            <a href="/nino"><i class="fa-solid fa-house"></i></a>
            <a style="color: grey"><i class="fa-solid fa-bookmark"></i></a>
            <a style="color: grey"><i class="fa-solid fa-clock-rotate-left"></i></a>
            <div id="btnMenuMobile" onclick="BtnMenu('btnMenuMobile')" data-windows="MenuMobile">
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
    <script src="<?= $uriHttp . $_SERVER['HTTP_HOST'] ?>/javascripts/all-pages.js?3"></script>

    <footer>
        &copy; 2023 HEMERY Mathéo
    </footer>
</body>

</html>