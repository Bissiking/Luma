<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Exctraction
	extract($_REQUEST);
    $routesJSON = json_decode(file_get_contents('../../base/routes.json'), true);
    // TEST ENTREE
    $url_pattern = htmlspecialchars(trim($url_pattern));

    // Vérifier si l'entrée existe dans le tableau
    if (isset($routesJSON[$url_pattern])) {
        // Récupérer les données de l'entrée spécifiée
        $selectedEntry = $routesJSON[$url_pattern];

        require_once('../../base/nexus_base.php');
        require_once('../../base/config.php');

        $urlToCheck = $url_pattern;
        $query = "SELECT * FROM luma_routes WHERE url_pattern = :url";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':url', $urlToCheck);
        $stmt->execute();
        $route = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$route) {
            try {
                $insertUser1Query = " INSERT INTO luma_routes (routeName, url_pattern, controller, action, url_domain, active)
            VALUES ('" . $selectedEntry['routeName'] . "', '" . $selectedEntry['url_pattern'] . "','" . $selectedEntry['controller'] . "' ,'" . $selectedEntry['action'] . "' ,'" . SITE_URL . "' , 1)
            ";
                $pdo->exec($insertUser1Query);
            } catch (PDOException $e) {
                echo 'configCreateTable01-echec --> ' . $e->getMessage();
                exit;
            }
            echo 'succes';
        }else {
            echo 'NOK';
        }
        // Afficher les données
        print_r($route);
    } else {
        echo "L'entrée spécifiée n'existe pas dans le JSON.";
    }
}
