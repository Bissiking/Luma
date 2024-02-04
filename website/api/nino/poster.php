<?php
// Vérifier si le paramètre 'image' est fourni dans l'URL
if (isset($_GET['image'])) {
    $imagePath = './images/nino/Thumbnail/Thumbnail_'.$_GET['image'].'_Nino.jpg';
    // Vérifier si le fichier existe
    if (file_exists($imagePath)) {
        // Définir le type de contenu de la réponse en tant qu'image
        header('Content-Type: image/jpeg');
        readfile($imagePath);
        exit();
    } else {
        // Si le fichier n'existe pas, renvoyer une image par défaut ou une erreur
        header('Content-Type: application/json');
        echo json_encode(['error' => '404']);
        exit();
    }
} else {
    // Si le paramètre 'image' n'est pas fourni, renvoyer une erreur
    header('Content-Type: application/json');
    echo json_encode(['error' => '404']);
}