<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SESSION['authentification']['user']['account_administrator'] !== 1) {
        echo 'not-autorized';
        exit;
    }

    require_once '../../base/config.php';
    require_once '../../lib/edit_const.php';

    // TEST FUNCTION EDIT CONST
    $const = ConstEdit('WEB_MAINTENANCE', 'true');
    var_dump($const);

    // Exemple : pull depuis le dépôt Git
    $output = shell_exec('git pull origin pre-prod'); // Assurez-vous de changer "master" si vous utilisez une autre branche

    // Afficher le résultat
    echo nl2br($output);
}
