<?php
// controllers/InitController.php

class InitController {
    public function show() {
        $titre = "Initialisation du site";
        require_once 'website/admin/init.php';
    }
}