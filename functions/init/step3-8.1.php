<?php
extract($_REQUEST);
$configFilePath = './base/config.php';
require './lib/initConf.php';

try {
    // Paramètres de configuration à inclure dans le fichier
    $configContent = '<?php' . PHP_EOL;
    $configContent .= PHP_EOL;

    // Paramètres de connexion à la base de données (remplacez par les valeurs appropriées)
    $configContent .= "define('DB_HOST', '');" . PHP_EOL;
    $configContent .= "define('DB_PORT', '');" . PHP_EOL;
    $configContent .= "define('DB_NAME', '');" . PHP_EOL;
    $configContent .= "define('DB_USER', '');" . PHP_EOL;
    $configContent .= "define('DB_PASSWORD', '');" . PHP_EOL;
    $configContent .= "define('DB_VERSION', 'DB01');" . PHP_EOL;
    $configContent .= "define('SYS_NAME', 'SYSTEM');" . PHP_EOL;
    $configContent .= "define('WEB_MAINTENANCE', 'false');" . PHP_EOL;
    $configContent .= PHP_EOL;


    // Autres paramètres de configuration
    $configContent .= "define('DEBUG_MODE', true);" . PHP_EOL;
    // LOGGING LVL = Correspond à l'intensité des logs du site.
    // 0 = Pas de logs
    // 1 = Log seulement les actions avec le compte Système
    // 2 = Log les actions Administrateur et Système
    // 3 = Log toutes les interactions avec le site (Connexion, Envoie de mail, insription)
    $configContent .= "define('LOGGING_LVL', 0);" . PHP_EOL;
    $configContent .= "define('SITE_URL', '" . $_SERVER['HTTP_HOST'] . "');" . PHP_EOL;
    $configContent .= "define('SITE_HTTP', '" . $uriHttp . "');" . PHP_EOL;
    $configContent .= PHP_EOL;

    $configContent .= "//VERSION TABLES BDD" . PHP_EOL;
    $configContent .= "define('DB_LUMA_USERS_VERSION', 'DB01');" . PHP_EOL;
    $configContent .= "define('DB_LUMA_ROUTES_VERSION', 'DB01');" . PHP_EOL;
    $configContent .= "define('DB_LUMA_NINO_DATA_VERSION', 'DB01');" . PHP_EOL;
    $configContent .= PHP_EOL;
    // Fin du fichier

    // Écriture du contenu dans le fichier
    file_put_contents($configFilePath, $configContent);
    sleep(1);

    require_once './base/config.php';

    // Lire le contenu actuel du fichier
    $configContent = file_get_contents($configFilePath);

    // Appliquer les modifications
    $configContent = str_replace(
        "define('DB_HOST', '" . DB_HOST . "');",
        "define('DB_HOST', '$DB_HOST');",
        $configContent
    );

    $configContent = str_replace(
        "define('DB_PORT', '" . DB_PORT . "');",
        "define('DB_PORT', '$DB_PORT');",
        $configContent
    );

    $configContent = str_replace(
        "define('DB_NAME', '" . DB_NAME . "');",
        "define('DB_NAME', '$DB_NAME');",
        $configContent
    );

    $configContent = str_replace(
        "define('DB_USER', '" . DB_USER . "');",
        "define('DB_USER', '$DB_USER');",
        $configContent
    );

    $configContent = str_replace(
        "define('DB_PASSWORD', '" . DB_PASSWORD . "');",
        "define('DB_PASSWORD', '$DB_PASSWORD');",
        $configContent
    );

    // // Réécrire le fichier avec le nouveau contenu
    file_put_contents($configFilePath, $configContent);

    $response = array(
        'nextStep' => "STOP",
        'textStats' => "----END----",
        'totalStep' => "1",
        'resultat' => 'succes',
        'message' => 'Création du fichier OK'
    );
} catch (\Throwable $th) {
    $response = array(
        'nextStep' => "STOP",
        'textStats' => "----END----",
        'totalStep' => "1",
        'resultat' => 'error',
        'message' => 'Echec de la création'
    );
}

echo json_encode($response);