<?php
// controllers/HomeController.php

class HomeController {
    public function index() {
        $_GET['offline'] = false;
        require_once './website/luma/home.php';
    }
}