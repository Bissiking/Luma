<?php

$RedirHome = 'Location: /';

if ($_SERVER['REQUEST_URI'] !== "/") {
    header($RedirHome);
}

class InitController {
    public function show() {
        require_once 'website/admin/initV2.php';
    }
}