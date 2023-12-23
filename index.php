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
    <link rel="icon" type="image/png" href="images/nexus30.png" />
    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Luma Projet</title>
</head>
<body>
    <header>
        <h1>LUMA</h1>
        <nav>
            <ul>
                <li><a href="/">Accueil</a></li>
                <li><a href="/serveurs">Serveurs</a></li>
                <li><a href="/nino">Vidéos</a></li>
                <li><a href="#">À propos</a></li>
            </ul>
        </nav>
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

    <footer>
        <p>&copy; 2023 HEMERY Mathéo</p>
    </footer>
</body>
</html>
