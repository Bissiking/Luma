<?php
// login.php
session_start(); // Toujours appeler session_start() au début du script qui utilise des sessions
extract($_REQUEST); // Extraction des valeurs JS

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // En attente de nettoyage
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID invalide']);
        exit;
    }
    $titre = htmlspecialchars(trim($titre));
    $description = htmlspecialchars(trim($description));
    $description = htmlspecialchars(trim($videoStatus));
    $publishFull = isset($datetimepicker) ? date('Y-m-d H:i:00', strtotime($datetimepicker)) : null;

    $tags = isset($tags) ? json_encode($tags) : null;

    if ($publishFull < date('Y-m-d H:i:s')) {
        $publishFull = null;
    }

    echo json_encode(['success' => 'TEST', 'message' => $tags]);
    // Utilisez ces valeurs pour mettre à jour la base de données
    // Exemple avec PDO :
    try {
        require '../../base/nexus_base.php';
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("UPDATE luma_nino_data SET 
        titre = ?,
        description = ?,
        publish = ?,
        tag = ?,
        status = ?
        WHERE id = ?");
        $stmt->execute([$titre, $description, $publishFull, $tags, $videoStatus,  $id]);

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
