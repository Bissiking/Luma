<?php
// Création des variables
    $DB_HOST = htmlspecialchars(trim($DB_HOST));
    $DB_PORT = htmlspecialchars(trim($DB_PORT));
    $DB_NAME = htmlspecialchars(trim($DB_NAME));
    $DB_USER = htmlspecialchars(trim($DB_USER));
    if (!isset($DB_PASSWORD)) {
        $DB_PASSWORD = urldecode($DB_PASSWORD);
    }

    if (!isset($DB_HOST) || $DB_HOST == "") {
		$DB_HOST = 'localhost';
	}
	if (!isset($DB_PORT) || $DB_PORT == "") {
		$DB_PORT = '3306';
	}

    $pdo = new PDO('mysql:host=' . $DB_HOST . ':' . $DB_PORT . ';dbname=' . $DB_NAME . ';charset=utf8', $DB_USER, $DB_PASSWORD);