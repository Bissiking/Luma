<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SESSION['authentification']['user']['account_administrator'] !== 1) {
        echo 'not-autorized';
        exit;
    }

    require_once 'lib/edit_const.php';

    try {
        if (PHP_OS === 'Linux') {
            // $gitPath = '/usr/bin/git';
            chmod('/', 0777);
        } else {
            $gitPath = 'C:/Program Files/Git/bin/git.exe';
            putenv("PATH=" . getenv("PATH") . ";" . dirname($gitPath));
        }
        $output = shell_exec('git clean -d -f && git stash && git pull 2>&1');

        if (PHP_OS === 'Linux') {
            chmod('/', 0777);
        } 

        if ($output === null) {
            throw new Exception('La commande git stash n\'a pas retourné de sortie.');
        }
        echo 'succes';
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
}
