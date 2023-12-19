<?php
session_start();
require 'lib/router.php';



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