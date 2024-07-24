<?php
$queryUrl = parse_url($url);

// Récupération du fichier de configuration 
$ConfigFile = 'base/config.php';

if (!file_exists($ConfigFile)) {
    $route = [
        'controller' => 'InitController',
        'action' => 'show'
    ];
    // print_r($route);
    // exit();
} else {
    require_once($ConfigFile);

    if (WEB_MAINTENANCE == 'true') {
        // Si le système de maintenace est actif
        $route = [
            'controller' => 'MaintenanceController',
            'action' => 'show'
        ];
    } else {
        // Connectez-vous à votre base de données ici


        // Si la base ne réponds pas
        if ($ERROR == 1) {
            echo 'ERROR';
            $route = [
                'controller' => 'HomeControllerOffline',
                'action' => 'show'
            ];
        } else {
            // Requête SQL pour récupérer les informations de routage
            try {
                if (strpos($url, 'nino/player') !== false) {
                    $queryUrl['path'] = '/nino/player';
                }

                if (strpos($url, 'agent/uuid') !== false) {
                    $queryUrl['path'] = '/agent';
                }

                $query = "SELECT * FROM luma_routes WHERE url_pattern = :url";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':url', $queryUrl['path']);
                $stmt->execute();
                $route = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                // Gérer d'autres exceptions
                echo "An unexpected error occurred: " . $e->getMessage();
            }
        }
    }
}

if (strpos($url, 'functions') !== false) {

    // Séparation de l'URL
    $parts = explode('/', $url);
    $functions = end($parts);

    // On vérifie si il y'a un paramètre
    if (strpos($url, '?') !== false) {
        $query = explode('?', $functions);
        // On réécrit la variable avec la nouvelle valeur
        $functions = $query[0];
    }
    // On appel la function
    require_once("functions/$functions.php");
    exit;
}

if (strpos($url, 'init') !== false) {

    // Séparation de l'URL
    $parts = explode('/', $url);
    $functions = end($parts);

    // On vérifie si il y'a un paramètre
    if (strpos($url, '?') !== false) {
        $query = explode('?', $functions);
        // On réécrit la variable avec la nouvelle valeur
        $functions = $query[0];
    }
    // On appel la function
    require_once("functions/init/$functions.php");
    exit;
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
    echo "Route not found = #0001";
}
