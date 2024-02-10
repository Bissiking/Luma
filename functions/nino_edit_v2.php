<?php
extract($_REQUEST); // Extraction des valeurs JS

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // En attente de nettoyage
    if(!isset($_GET['id'])){
        $id = null;
        exit;
    };
    $id_video_uuid = htmlspecialchars(trim($_GET['id']));
    $titre = htmlspecialchars(trim($titre));
    $description = htmlspecialchars(trim($description));
    $videoStatus = htmlspecialchars(trim($videoStatus));
    $publishFull = isset($datetimepicker) ? date('Y-m-d H:i:00', strtotime($datetimepicker)) : null;
    $tags = isset($tags) ? json_encode($tags) : null;

    if ($publishFull < date('Y-m-d H:i:s')) {
        $publishFull = null;
    }

    try {
        require 'base/nexus_base.php';
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("UPDATE luma_nino_data SET 
        titre = ?,
        description = ?,
        publish = ?,
        tag = ?,
        status = ?
        WHERE id_video_uuid = ?");
        $stmt->execute([$titre, $description, $publishFull, $tags, $videoStatus,  $id_video_uuid]);
        // Réponse JSON pour indiquer le succès
        echo json_encode(['success' => true, 'message' => 'Données mises à jour avec succès']);
    } catch (PDOException $e) {
        // Réponse JSON en cas d'erreur
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour des données: ' . $e->getMessage()]);
    }
} else {
    // Réponse JSON pour une méthode non autorisée
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
}
