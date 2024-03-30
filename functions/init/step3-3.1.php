<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extraction des données
    extract($_REQUEST);
    require './lib/initConf.php';
    require './lib/mysql_table_add.php';

    try {
        // AJOUT DES ROUTES
        function CheckURL($urlToCheck, $pdo)
        {
            $query = "SELECT * FROM luma_routes WHERE url_pattern = :url";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':url', $urlToCheck);
            $stmt->execute();
            $route = $stmt->fetch(PDO::FETCH_ASSOC);
            return $route;
        }
        $tableName = 'luma_routes';
        $error = 0;

        //Création de la route Accueil
        $urlToCheck = '/';
        $route = CheckURL($urlToCheck, $pdo);
        if (!$route) {
            $data = [
                'routeName' => 'Accueil',
                'url_pattern' => '/',
                'controller' => 'HomeController',
                'action' => 'index',
                'url_domain' => $_SERVER['HTTP_HOST'],
                'active' => 1
            ];
            $InsertPDO = insertDataPDO($tableName, $data, $pdo);
            if ($InsertPDO !== 'succes') {
                $error = +1;
            }
        }

        //Création de la route de connexion
        $urlToCheck = '/connexion';
        $route = CheckURL($urlToCheck, $pdo);
        if (!$route) {
            $data = [
                'routeName' => 'Connexion',
                'url_pattern' => '/connexion',
                'controller' => 'ConnexionController',
                'action' => 'show',
                'url_domain' => $_SERVER['HTTP_HOST'],
                'active' => 1
            ];
            $InsertPDO = insertDataPDO($tableName, $data, $pdo);
            if ($InsertPDO !== 'succes') {
                $error = +1;
            }
        }

        //Création de la route Admin
        $urlToCheck = '/admin';
        $route = CheckURL($urlToCheck, $pdo);
        if (!$route) {
            $data = [
                'routeName' => 'Admin',
                'url_pattern' => '/admin',
                'controller' => 'AdminController',
                'action' => 'show',
                'url_domain' => $_SERVER['HTTP_HOST'],
                'active' => 1
            ];
            $InsertPDO = insertDataPDO($tableName, $data, $pdo);
            if ($InsertPDO !== 'succes') {
                $error = +1;
            }
        }

        //Création de la route Admin/routes
        $urlToCheck = '/admin/routes';
        $route = CheckURL($urlToCheck, $pdo);
        if (!$route) {
            $data = [
                'routeName' => 'AdminRoutes',
                'url_pattern' => '/admin/routes',
                'controller' => 'AdminRoutesController',
                'action' => 'show',
                'url_domain' => $_SERVER['HTTP_HOST'],
                'active' => 1
            ];
            $InsertPDO = insertDataPDO($tableName, $data, $pdo);
            if ($InsertPDO !== 'succes') {
                $error = +1;
            }
        }

        if ($error !== 0) {
            $response = array(
                'nextStep' => "step3-3.1",
                'textStats' => "Création de la table utilisateur",
                'totalStep' => "1",
                'resultat' => 'error',
                'message' => $error . ' détecté.'
            );
        } else {
            $response = array(
                'nextStep' => "step3-4.1",
                'textStats' => "Création de la table utilisateur",
                'totalStep' => "1",
                'resultat' => 'succes',
                'message' => 'Ajouts des routes OK'
            );
        }
    } catch (PDOException $e) {
        $response = array(
            'nextStep' => "step3-3.1",
            'textStats' => "Création de la table utilisateur",
            'totalStep' => "1",
            'resultat' => 'error',
            'message' => 'Créaction de la table ECHEC',
            'PDO' => $e->getMessage(),
        );
    }
}
echo json_encode($response);
