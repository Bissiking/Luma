<?php

// ETAPE 1 - Exctraction
extract($_REQUEST);

// ETAPE 2 - Vérification si les champs sont vides ou non
if(isset($DB_HOST) || $DB_HOST == ""){
	$DB_HOST = 'localhost';
}
if(isset($DB_PORT) || $DB_PORT == ""){
	$DB_PORT = '3306';
}

// ETAPE 3 - Test de la connexion BDD
try {
	$ERROR = 0;
	$pdo = new PDO ('mysql:host=' . $DB_HOST.':'.$DB_PORT.';dbname=' . $DB_NAME . ';charset=utf8', $DB_USER, $DB_PASSWORD);
}catch(PDOException $e){
	echo 'bdd-echec';
	exit;
}

// ETAPE 4 - Création du fichier de config
$configFilePath = '../base/config.php';

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
	$configContent .= "define('SYS_NAME', 'SYSTEM');" . PHP_EOL;
	$configContent .= "define('STAT_INSTALL', 'false');" . PHP_EOL;
	$configContent .= "define('WEB_MAINTENANCE', 'false');" . PHP_EOL;
	$configContent .= PHP_EOL;
	

	// Autres paramètres de configuration
	$configContent .= "define('DEBUG_MODE', true);" . PHP_EOL;
	$configContent .= "define('SITE_URL', '".$_SERVER['HTTP_HOST']."');" . PHP_EOL;
	$configContent .= PHP_EOL;

	// Fin du fichier
	$configContent .= '?>' . PHP_EOL;

	// Écriture du contenu dans le fichier
	file_put_contents($configFilePath, $configContent);
	sleep(1);
} catch (\Throwable $th) {
	echo 'configCreate-echec';
	exit;
}

// ETAPE 4.1 - Vérification de la présence du fichier de config
if(!file_exists($configFilePath)){
	echo 'configExist-echec';
	exit;	
}

// ETAPE 5 - Edition du fichier de config

// Récupération de la config

require_once '../base/config.php';

// Transformation des POST en variable nettoyé
$DB_HOST = htmlspecialchars(trim($DB_HOST));
$DB_PORT = htmlspecialchars(trim($DB_PORT));
$DB_NAME = htmlspecialchars(trim($DB_NAME));
$DB_USER = htmlspecialchars(trim($DB_USER));
$DB_PASSWORD = htmlspecialchars(trim($DB_PASSWORD));
$USER_ADMIN = htmlspecialchars(trim($USER_ADMIN));
$USER_ADMIN_MDP = htmlspecialchars(trim($USER_ADMIN_MDP));

// Lire le contenu actuel du fichier
$configContent = file_get_contents($configFilePath);

// Appliquer les modifications
$configContent = str_replace(
	"define('DB_HOST', '".DB_HOST."');", "define('DB_HOST', '$DB_HOST');",
	$configContent
);

$configContent = str_replace(
	"define('DB_PORT', '".DB_PORT."');", "define('DB_PORT', '$DB_PORT');",
	$configContent
);

$configContent = str_replace(
	"define('DB_NAME', '".DB_NAME."');", "define('DB_NAME', '$DB_NAME');",
	$configContent
);

$configContent = str_replace(
	"define('DB_USER', '".DB_USER."');", "define('DB_USER', '$DB_USER');",
	$configContent
);

$configContent = str_replace(
	"define('DB_PASSWORD', '".DB_PASSWORD."');", "define('DB_PASSWORD', '$DB_PASSWORD');",
	$configContent
);

$configContent = str_replace(
	"define('STAT_INSTALL', '".STAT_INSTALL."');", "define('STAT_INSTALL', true);",
	$configContent
);

// // Réécrire le fichier avec le nouveau contenu
file_put_contents($configFilePath, $configContent);

// Création de la table users
try {
    // Définir le mode d'erreur de PDO sur Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête de création de table
    $query = "
		CREATE TABLE luma_routes (
			id INT PRIMARY KEY AUTO_INCREMENT,
			url_pattern VARCHAR(255) NOT NULL,
			controller VARCHAR(255) NOT NULL,
			action VARCHAR(255) NOT NULL,
			url_domain VARCHAR(255) NOT NULL,
			active TINYINT(1) NOT NULL DEFAULT 0
		)
    ";

    // Exécution de la requête
    $pdo->exec($query);

	//Création de la route Accueil
	$insertRoutes1 = "
        INSERT INTO luma_routes (url_pattern, controller, action, url_domain)
        VALUES ('/', 'HomeController', 'index', '".SITE_URL."')
    ";
    $pdo->exec($insertRoutes1);

	//Création de la route de connexion
	$insertRoutes2 = "
        INSERT INTO luma_routes (url_pattern, controller, action, url_domain)
        VALUES ('/connexion', 'ConnexionController', 'show', '".SITE_URL."')
    ";
    $pdo->exec($insertRoutes2);

	//Création de la route Admin
	$insertRoutes3 = "
        INSERT INTO luma_routes (url_pattern, controller, action, url_domain)
        VALUES ('/admin', 'AdminController', 'show', '".SITE_URL."')
    ";
    $pdo->exec($insertRoutes3);

	//Création de la route Admin/routes
	$insertRoutes3 = "
        INSERT INTO luma_routes (url_pattern, controller, action, url_domain)
        VALUES ('/admin/routes', 'AdminRoutesController', 'show', '".SITE_URL."')
    ";
    $pdo->exec($insertRoutes3);


} catch (PDOException $e) {
    echo 'configCreateTable01-echec';
}

// Création de la table users
try {
    // Définir le mode d'erreur de PDO sur Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête de création de table
    $query = "
		CREATE TABLE luma_users (
			id BIGINT(20) PRIMARY KEY AUTO_INCREMENT,
			identifiant VARCHAR(255) NOT NULL,
			password VARCHAR(255) NOT NULL,
			system TINYINT(4) NOT NULL,
			users_domain VARCHAR(255) NOT NULL
		)
    ";

    // Exécution de la requête
    $pdo->exec($query);

	// Chargement de la LIB (password_generate)

	$motDePasseGenere = genererMotDePasse(24);

	//Création de l'utilisateur SYSTEM
	$insertUser1Query = "
        INSERT INTO luma_users (identifiant, password)
        VALUES ('system', '" . password_hash("".$motDePasseGenere."", PASSWORD_BCRYPT) . "')
    ";

    // Exécution de la requête d'insertion pour le premier utilisateur 
    $pdo->exec($insertUser1Query);

	// Création de l'utilisateur (ADMINISTRATEUR)
    $insertUser2Query = "
        INSERT INTO users (identifiant, password)
        VALUES ('".$USER_ADMIN."', '" . password_hash($USER_ADMIN_MDP, PASSWORD_BCRYPT) . "')
    ";

    // Exécution de la requête d'insertion pour le deuxième utilisateur
    $pdo->exec($insertUser2Query);


} catch (PDOException $e) {
    echo 'configCreateTable02-echec';
}

// Création du compte system et admin
try {


} catch (PDOException $e) {
    echo 'configCreateUserSystem-echec';
}


echo "succes";