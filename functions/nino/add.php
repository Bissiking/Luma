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

    if (!isset($APIselect) || $APIselect == "") {
        echo 'empty';
        exit;
    }
    try {
        // Définir le mode d'erreur de PDO sur Exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Création de l'ID de la vidéo
        function generateUniqueVideoId()
        {
            if (function_exists('uuid_create')) {
                $uuid = uuid_create(UUID_TYPE_RANDOM);
                return uuid_parse($uuid);
            } else {
                // Génération d'UUID alternative si l'extension uuid n'est pas disponible
                return uniqid('video_', true);
            }
        }
        // Exemple d'utilisation
        $videoId = generateUniqueVideoId();

        $id_users = $_SESSION['authentification']['user']['id'];
        $v = array(
            'titre' => htmlspecialchars(trim($titre)), 
            'server_url' => htmlspecialchars(trim($APIselect)),
            'id_users' => $id_users,
            'id_video_uuid' => $videoId,
            'status' => 'reserved'
        );
        $sql = 'INSERT INTO luma_nino_data (
            titre, id_users, id_video_uuid, status)VALUES(
            :titre, :id_users, :id_video_uuid, :status)';
        $req = $pdo->prepare($sql);
        $req->execute($v);
        echo 'succes';

    } catch (PDOException $e) {
        echo 'echec --> '.$e->getMessage();
        exit;
    }
}
