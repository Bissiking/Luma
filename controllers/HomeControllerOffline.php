<?php

class HomeControllerOffline {
    public function show() {
        $_GET['offline'] = true;
        require_once './website/luma/home.php';
    }
}