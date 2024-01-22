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
    try {
        $gitPath = 'C:/Program Files/Git/bin/git.exe';  // Remplacez par le chemin réel de l'exécutable Git

        // Ajoutez le chemin de Git au PATH
        putenv("PATH=" . getenv("PATH") . ";" . dirname($gitPath));
        // Changer le répertoire de travail
        chdir("../../");

        // Exécuter la commande Git
        $output = shell_exec('git stash && git pull 2>&1');
    
        if ($output === null) {
            throw new Exception('La commande git stash n\'a pas retourné de sortie.');
        }
        // Afficher la sortie
        echo 'succes';
    } catch (Exception $e) {
        // Gérer les exceptions
        echo 'Erreur : ' . $e->getMessage();
    }
    $const = ConstEdit('WEB_MAINTENANCE', 'false');

    // Afficher le résultat
    echo nl2br('OUT: ' . $output);
}

$const = ConstEdit('WEB_MAINTENANCE', 'false');