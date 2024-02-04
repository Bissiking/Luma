<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    require './base/nexus_base.php';
    // Récupérez les vidéos depuis la base de données
    $query = $pdo->query("SELECT id_video_uuid, titre, `description`, videoThumbnail, server_url FROM luma_nino_data");
    $videos = $query->fetchAll(PDO::FETCH_ASSOC);
    // Répondre avec les vidéos au format JSON
    header('Content-Type: application/json');
    echo json_encode(['videos' => $videos]);
} else {
    // Répondre aux autres méthodes HTTP avec une erreur
    header('HTTP/1.1 405 Method Not Allowed');
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Method Not Allowed']);
}
