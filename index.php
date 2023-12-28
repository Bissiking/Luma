<?php
    session_start();
    $url = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- LINK -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="icon" type="image/png" href="images/nexus30.png" />
    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Luma Projet</title>
</head>
<body>
    <header>
        <div>
            <span id="projectName">LUMA</span>
        </div>

        <nav>
            <a href="/">Accueil</a>
            <a href="#">Nino</a>
            <a style="color:grey" href="#">Serveur</a>
            <a style="color:grey" href="#">A propos</a>
        </nav>

        <!-- Icône représentant un compte non connecté -->
        <img id="profileIcon" src="images/user-offline.png" alt="Icône de Profil">
        
        <!-- Menu déroulant pour le profil -->
        <ul id="profileMenu">
            <i class="fa-solid fa-sort-up"></i>
            <?php if (isset($_SESSION['auth'])) { ?>
                <li><a href="#">Configurer le Profil</a></li>
                <li><a href="#">Autres Options</a></li>
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
    <script src="javascripts/popup.js"></script>
    <script src="javascripts/all-pages.js"></script>

    <footer>
        <p>&copy; 2023 HEMERY Mathéo</p>
    </footer>
</body>
</html>
