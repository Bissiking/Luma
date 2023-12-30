<?php
require_once 'config.php';

try {
    $ERROR = 0;
    $pdo = new PDO ('mysql:host=' . DB_HOST.':'.DB_PORT.';dbname=' . DB_NAME . ';'. DB_USER, DB_PASSWORD);
}
catch(PDOException $e)
{
    $ERROR = 1;
    $_SESSION['error']['bdd'] = $e->getMessage();
}