<?php
// controllers/InitController.php

class MaintenanceController {
    public function show() {
        $titre = "Maintenance du site";
        require_once 'website/nexus/maintenance.php';
    }
}