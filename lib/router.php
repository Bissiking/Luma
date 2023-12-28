<?php
// Récupération du fichier de configuration 
$ConfigFile = 'base/config.php';

if (!file_exists($ConfigFile)) {
    $route = [
        'controller' => 'InitController',
        'action' => 'show'
    ];
}else{
    require_once($ConfigFile);

    if (STAT_INSTALL != 'true'){
        // Si le système d'installation est active
        $route = [
            'controller' => 'InitController',
            'action' => 'show'
        ];
    
    }else if (WEB_MAINTENANCE == 'true'){
        // Si le système de maintenace est actif
        $route = [
            'controller' => 'MaintenanceController',
            'action' => 'show'
        ];
    }else{
        // Connectez-vous à votre base de données ici
        require_once 'base/nexus_base.php';

        // Si la base ne réponds pas
        if ($ERROR == 1) {
            echo 'ERROR';
            $route = [
                'controller' => 'HomeControllerOffline',
                'action' => 'show'
            ];
        }else{
            // Requête SQL pour récupérer les informations de routage
            try {
                $query = "SELECT * FROM luma_routes WHERE url_pattern = :url";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':url', $url);
                $stmt->execute();
                $route = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                // Gérer d'autres exceptions
                echo "An unexpected error occurred: " . $e->getMessage();
            }
        }
    }
}

// Vérifiez si une route correspond à l'URL demandée
if ($route) {
    $controllerName = $route['controller'];
    $actionName = $route['action'];

    // Inclure et instancier le contrôleur
    require_once("controllers/{$controllerName}.php");
    $controller = new $controllerName();

    // Appeler l'action
    $controller->$actionName();
} else {
    // Gérer les routes non trouvées (par exemple, afficher une page d'erreur)
    echo "Route not found";
}