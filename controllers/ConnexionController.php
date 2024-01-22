<?php

if (isset($_GET['logout'])) {
    session_destroy();
}

if (isset($_SESSION['authentification']['user'])) {
    header('Location: /');
}

class ConnexionController {
    public function show() {
        require_once 'website/luma/connexion.php';
    }
}