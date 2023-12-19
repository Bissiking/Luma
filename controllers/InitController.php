<?php
// controllers/InitController.php

class InitController {
    public function index() {
        $content = "Initialisation du site";
        echo json_encode(['content' => $content]);
    }
}