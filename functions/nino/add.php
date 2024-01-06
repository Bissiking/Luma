<?php 
// login.php
session_start(); // Toujours appeler session_start() au début du script qui utilise des sessions
extract($_REQUEST); // Extraction des valeurs JS

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require '../../base/nexus_base.php';

    // Vérification si les champs sont vides
    if (!isset($titre) || $titre == "") {
        echo 'empty';
        exit;
    }

    try {
        // Définir le mode d'erreur de PDO sur Exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $id_users = $_SESSION['authentification']['user']['id'];
        $v = array('titre' => $titre, 'id_users' => $id_users, 'status' => 'reserved');
        $sql = 'INSERT INTO luma_nino_data (titre, id_users, status)VALUES(:titre, :id_users, :status)';
        $req = $pdo->prepare($sql);
        $req->execute($v);
        echo 'succes';

    } catch (PDOException $e) {
        echo 'echec --> '.$e->getMessage();
        exit;
    }
}
