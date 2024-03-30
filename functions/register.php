<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'lib/mysql_table_select.php';
    require 'lib/mysql_table_add.php';
    extract($_REQUEST);

    // Récupérer les données du formulaire
    $identifiant = htmlspecialchars(trim($identifiant));

    // // Vérification si les champs sont vides
    if (!isset($identifiant) || $identifiant == "") {
        echo 'empty';
        exit;
    }

    if (!isset($password) || $password == "") {
        echo 'empty';
        exit;
    }

    if (isset($master)) :
        if ($master == "") {
            echo 'empty';
            exit;
        } else {
            $master = htmlspecialchars(trim($master));
        }
    else :
        $master = NULL;
    endif;
    // // Connexion à MySQL
    require_once 'base/nexus_base.php';

    // Vérification USER
    $tableName = 'luma_users';
    $criteria = ['identifiant' => $identifiant];
    $rowExists = checkRowExistence($tableName, $criteria, $pdo);

    if ($rowExists === false) {

        if ($master == "kids_account") {
            $master = 1;
            $users_master = $_SESSION['authentification']['user']['id'];
        } else {
            $master = NULL;
            $users_master = NULL;
        }

        $data = [
            'identifiant' => $identifiant,
            'password' => password_hash("" . $password . "", PASSWORD_BCRYPT),
            'master' => $master,
            'users_master' => $users_master,
            'users_domain' => $_SERVER['HTTP_HOST'],
            // Ajoutez autant de colonnes et de valeurs que nécessaire
        ];

        $InsertPDO = insertDataPDO($tableName, $data, $pdo);
        echo $InsertPDO;
    } elseif ($rowExists === true) {
        echo "user-exist"; // correspondance
    } else {
        echo $rowExists; // Affiche un message d'erreur
    }
} else {
    echo "Accès non autorisé.";
}
