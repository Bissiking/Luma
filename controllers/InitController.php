<?php

if (STAT_INSTALL != 'false') {
    header('Location: /');
}

class InitController {
    public function show() {
        require_once 'website/admin/init.php';
    }
}