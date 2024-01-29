<?php
if (isset($_SESSION['authentification']['user'])) {
    header('Location: /?connected');
}

class InscriptionController {
    public function show() {
        require_once 'website/luma/inscription.php';
    }
}