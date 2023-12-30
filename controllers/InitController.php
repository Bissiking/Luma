<?php

$RedirHome = 'Location: /';

if ($_SERVER['REQUEST_URI'] !== "/") {
    header($RedirHome);
}

if (defined('STAT_INSTALL')) {
    if (STAT_INSTALL != 'false') {
        header($RedirHome);
    }
    header($RedirHome);
}

class InitController {
    public function show() {
        require_once 'website/admin/init.php';
    }
}