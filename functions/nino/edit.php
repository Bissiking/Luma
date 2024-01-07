<?php
// login.php
session_start(); // Toujours appeler session_start() au début du script qui utilise des sessions
extract($_REQUEST); // Extraction des valeurs JS

// En attente de nettoyage
$titre = $videoTitle;
$description = $videoDescription;
$tag = $videoTags;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification et Génération UUID vidéo
    if (!isset($UUID_nino) || $UUID_nino == "") {
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
    }else{
        $videoId = $UUID_nino;
    }


    require '../../base/nexus_base.php';

    $folderPath = '../../images/nino/Thumbnail';

    // Vérifier si le dossier n'existe pas déjà
    if (!is_dir($folderPath)) {
        // Créer le dossier
        if (!mkdir($folderPath, 0755))  {
            echo 'Erreur lors de la création du dossier.';
        }
    }

    $uploadDir = '../../images/nino/Thumbnail/';

    $nomImage = $uploadDir."Thumbnail_".$videoId."_Nino.jpg";
    if (file_exists($nomImage)) {
        $videoThumbnail = $nomImage;
    } else {
        if (isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])) {
            // Nom du nouveau fichier
            $uploadFile = $uploadDir . basename('Thumbnail_' . $videoId . '_Nino.jpg');
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $videoThumbnail = $uploadFile;
            } else {
                echo 'Erreur lors de l\'upload de l\'image.';
            }
        }else  echo 'upload_img_echec'; 
    }


    // Vérification si les champs sont vides
    if (!isset($titre) || $titre == "") {
        echo 'empty 01';
        exit;
    }

    if (!isset($description) || $description == "") {
        echo 'empty 02';
        exit;
    }

    if (!isset($tag) || $tag == "") {
        echo 'empty 03';
        exit;
    }

    if (!isset($serveurURL) || $serveurURL == "") {
        echo 'empty 04';
        exit;
    }

    try {
        // Définir le mode d'erreur de PDO sur Exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $id_users = $_SESSION['authentification']['user']['id'];

        $v = array(
            'id_video_uuid' => $videoId,
            'id_users' => $id_users,
            'titre' => $titre,
            'description' => $description,
            'tag' => $tag,
            'videoThumbnail' => $videoThumbnail,
            'server_url' => $serveurURL,
            'id' => $id
        );
        $sql = 'UPDATE luma_nino_data 
        SET 
        id_video_uuid = :id_video_uuid,
        id_users = :id_users, 
        titre = :titre, 
        description = :description, 
        tag = :tag, 
        videoThumbnail = :videoThumbnail, 
        server_url = :server_url WHERE id = :id';
        $req = $pdo->prepare($sql);
        $req->execute($v);
        echo 'succes';
    } catch (PDOException $e) {
        echo 'echec --> ' . $e->getMessage();
        exit;
    }
}
