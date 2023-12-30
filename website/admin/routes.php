<?php

// Charger le contenu du fichier JSON
$jsonContent = file_get_contents('./base/routes.json');
$routes = json_decode($jsonContent, true);

if ($routes === null) {
    echo 'Erreur lors de la lecture du fichier JSON.';
}else {
    // Connexion à la base de données
    require_once './base/nexus_base.php';

    // Liste pour stocker les routes manquantes en base de données
    $routesManquantes = [];
    
    echo $pdo;
    foreach ($routes as $route) {
        
        print_r($route);
        $urlPattern = $route['url_pattern'];
    
        // Requête pour vérifier si la route est présente en base de données
        $query = "SELECT COUNT(*) FROM luma_routes WHERE url_pattern = :url";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':url', $urlPattern);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    
        // Si la route n'est pas présente, l'ajouter à la liste des routes manquantes
        if ($count === 0) {
            $routesManquantes[] = $urlPattern;
        }
    }

// Afficher les routes manquantes
echo "Routes manquantes en base de données :<br>";
foreach ($routesManquantes as $routeManquante) {
    echo $routeManquante . "<br>";
}
    
}




?>

<link rel="stylesheet" href="<?= $uriHttp.$_SERVER['HTTP_HOST'] ?>/css/AdminRoutes.css">
<script>
	document.title = "Administration des routes";
</script>

<h1>ROUTES</h1>

<!-- SCRIPTS SRV -->