<?php
if ($_SESSION['authentification']['user']['account_administrator'] !== 1) {
    header('Location: /');
}
// Charger le contenu du fichier JSON
$routesJSON = json_decode(file_get_contents('./base/routes.json'), true);

if ($routesJSON === null) {
    echo 'Erreur lors de la lecture du fichier JSON.';
    exit();
} else {
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=' . DB_HOST . ':' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASSWORD);

    // Récupérer les routes depuis la base de données
    $sql = "SELECT * FROM luma_routes";
    $req = $pdo->prepare($sql);
    $req->execute();
    $routesBDD = $req->fetchAll(PDO::FETCH_ASSOC);

    // Afficher le bouton "Ajouter" si des routes peuvent être ajoutées
    $afficherBoutonAjouter = !empty($routesToAdd);
}

?>

<link rel="stylesheet" href="<?= SITE_HTTP . "://" . SITE_URL ?>/css/admin.css">
<script>
    document.title = "Administration des routes";
</script>

<table>
    <thead>
        <tr>
            <th>Url Pattern</th>
            <th>Controller</th>
            <th>Action</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($routesJSON as $route) { ?>
            <tr>
                <td><?= $route['url_pattern'] ?></td>
                <td><?= $route['controller'] ?></td>
                <td><?= $route['action'] ?></td>
                <td>
                    <?php 
                        // Extraire la colonne 'url_pattern' du tableau de routes en base de données
                        $urlPatternsBDD = array_column($routesBDD, 'url_pattern');
                        
                        // Vérifier si l'url_pattern est présent dans le tableau extrait
                        if (in_array($route['url_pattern'], $urlPatternsBDD)) : ?>
                            <button style="background-color: grey;">Option en DEV</button>
                    <?php else : ?>
                            <button onclick="routesAdd('<?= $route['routeName'] ?>')">Ajouter le site</button>
                    <?php endif; ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<!-- SCRIPTS SRV -->
<script src="../javascripts/admin/routes_add.js"></script>