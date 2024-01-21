<?php
if ($_SESSION['authentification']['user']['account_administrator'] !== 1) {
    echo 'REFUSED';
	exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Détection du HTTPS
	if (isset($_SERVER['HTTP_X_FORWARDED_SCHEME'])) {
		$uriHttp = 'https';
	} else {
		$uriHttp = 'http';
	}

	// ETAPE 1 - Exctraction
	extract($_REQUEST);

	// ETAPE 2 - Vérification si les champs sont vides ou non
	if (!isset($DB_HOST) || $DB_HOST == "") {
		$DB_HOST = 'localhost';
	}
	if (!isset($DB_PORT) || $DB_PORT == "") {
		$DB_PORT = '3306';
	}

	// ETAPE 3 - Test de la connexion BDD
	try {
		$ERROR = 0;
		$pdo = new PDO('mysql:host=' . $DB_HOST . ':' . $DB_PORT . ';dbname=' . $DB_NAME . ';charset=utf8', $DB_USER, $DB_PASSWORD);
	} catch (PDOException $e) {
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
		$configContent .= "define('DB_VERSION', 'DB01');" . PHP_EOL;
		$configContent .= "define('SYS_NAME', 'SYSTEM');" . PHP_EOL;
		$configContent .= "define('STAT_INSTALL', 'false');" . PHP_EOL;
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
	} catch (\Throwable $th) {
		echo 'configCreate-echec';
		exit;
	}

	// ETAPE 4.1 - Vérification de la présence du fichier de config
	if (!file_exists($configFilePath)) {
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

	$configContent = str_replace(
		"define('STAT_INSTALL', '" . STAT_INSTALL . "');",
		"define('STAT_INSTALL', true);",
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
		CREATE TABLE IF NOT EXISTS luma_routes (
			id INT PRIMARY KEY AUTO_INCREMENT,
			routeName VARCHAR(255) NOT NULL,
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
		$urlToCheck = '/';
		$query = "SELECT * FROM luma_routes WHERE url_pattern = :url";
		$stmt = $pdo->prepare($query);
		$stmt->bindParam(':url', $urlToCheck);
		$stmt->execute();
		$route = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$route) {
			$insertRoutes1 = "
			INSERT INTO luma_routes (routeName, url_pattern, controller, action, url_domain, active)
			VALUES ('Accueil', '/', 'HomeController', 'index', '" . SITE_URL . "', 1)
		";
			$pdo->exec($insertRoutes1);
		}


		//Création de la route de connexion
		$urlToCheck = '/connexion';
		$query = "SELECT * FROM luma_routes WHERE url_pattern = :url";
		$stmt = $pdo->prepare($query);
		$stmt->bindParam(':url', $urlToCheck);
		$stmt->execute();
		$route = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$route) {
			$insertRoutes2 = "
        INSERT INTO luma_routes (routeName, url_pattern, controller, action, url_domain, active)
        VALUES ('Connexion', '/connexion', 'ConnexionController', 'show', '" . SITE_URL . "', 1)
    ";
			$pdo->exec($insertRoutes2);
		}

		//Création de la route Admin
		$urlToCheck = '/admin';
		$query = "SELECT * FROM luma_routes WHERE url_pattern = :url";
		$stmt = $pdo->prepare($query);
		$stmt->bindParam(':url', $urlToCheck);
		$stmt->execute();
		$route = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$route) {
			$insertRoutes3 = "
        INSERT INTO luma_routes (routeName, url_pattern, controller, action, url_domain, active)
        VALUES ('Admin', '/admin', 'AdminController', 'show', '" . SITE_URL . "', 1)
    ";
			$pdo->exec($insertRoutes3);
		}

		//Création de la route Admin/routes
		$urlToCheck = '/admin/routes';
		$query = "SELECT * FROM luma_routes WHERE url_pattern = :url";
		$stmt = $pdo->prepare($query);
		$stmt->bindParam(':url', $urlToCheck);
		$stmt->execute();
		$route = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$route) {
			$insertRoutes4 = "
        INSERT INTO luma_routes (routeName, url_pattern, controller, action, url_domain, active)
        VALUES ('AdminRoutes', '/admin/routes', 'AdminRoutesController', 'show', '" . SITE_URL . "', 1)
    ";
			$pdo->exec($insertRoutes4);
		}
	} catch (PDOException $e) {
		echo 'configCreateTable01-echec --> ' . $e->getMessage();
		exit;
	}

	// Création de la table users et des users
	try {
		// Définir le mode d'erreur de PDO sur Exception
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// Requête de création de table
		$query = "
		CREATE TABLE IF NOT EXISTS luma_users (
			id BIGINT(20) PRIMARY KEY AUTO_INCREMENT,
			identifiant VARCHAR(255) NOT NULL,
			password VARCHAR(255) NOT NULL,
			account_administrator TINYINT(4) NOT NULL DEFAULT 0,
			account_system TINYINT(4) NOT NULL DEFAULT 0,
			users_domain VARCHAR(255) NOT NULL,
			nomComplet VARCHAR(255) NULL,
			groupeAcces VARCHAR(255) NULL,
			account_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    		account_edit TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		)
    ";

		// Exécution de la requête
		$pdo->exec($query);

		// Création du déclancheur de mise à jour
		$query = "
		CREATE TRIGGER IF NOT EXISTS update_account_edit
		BEFORE UPDATE ON luma_users
		FOR EACH ROW
		SET NEW.account_edit = CURRENT_TIMESTAMP;
    ";

		// Exécution de la requête
		$pdo->exec($query);

		// Chargement de la LIB (password_generate)
		require_once '../lib/password_generate.php';
		$motDePasseGenere = genererMotDePasse(24);

		//Création de l'utilisateur SYSTEM
		$UserToCheck = 'system';
		$query = "SELECT * FROM luma_users WHERE identifiant = :identifiant";
		$stmt = $pdo->prepare($query);
		$stmt->bindParam(':identifiant', $UserToCheck);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$user) {
			$insertUser1Query = "
        INSERT INTO luma_users (identifiant, password, users_domain, account_system)
        VALUES ('system', '" . password_hash("" . $motDePasseGenere . "", PASSWORD_BCRYPT) . "', '" . SITE_URL . "', 1)
    ";
			$pdo->exec($insertUser1Query);
		}

		// Création de l'utilisateur (ADMINISTRATEUR)
		$query = "SELECT * FROM luma_users WHERE identifiant = :identifiant";
		$stmt = $pdo->prepare($query);
		$stmt->bindParam(':identifiant', $USER_ADMIN);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$user) {
			$insertUser2Query = "
        INSERT INTO luma_users (identifiant, password, users_domain, account_administrator)
        VALUES ('" . $USER_ADMIN . "', '" . password_hash($USER_ADMIN_MDP, PASSWORD_BCRYPT) . "', '" . SITE_URL . "', 1)
    ";
			$pdo->exec($insertUser2Query);
		}
	} catch (PDOException $e) {
		echo 'configCreateUserSystem-echec // -> ' . $e->getMessage();
		exit;
	}

	// Création de la table NINO
	try {
		// Définir le mode d'erreur de PDO sur Exception
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// Requête de création de table
		$query = "
		CREATE TABLE IF NOT EXISTS luma_nino_data (
			id INT PRIMARY KEY AUTO_INCREMENT,
			id_video_uuid VARCHAR(255) NULL,
			id_users BIGINT(20) NULL,
			titre VARCHAR(255) NULL,
			description TEXT NULL,
			videoThumbnail VARCHAR(255) NULL,
			tag VARCHAR(255) NULL,
			server_url VARCHAR(255) NULL,
			status VARCHAR(255) NULL,
			`create` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			edit TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			publish TIMESTAMP NULL
		)
    ";
		// Exécution de la requête
		$pdo->exec($query);

		// Création du déclancheur de mise à jour
		$query = "
				CREATE TRIGGER IF NOT EXISTS update_edit
				BEFORE UPDATE ON luma_nino_data
				FOR EACH ROW
				SET NEW.edit = CURRENT_TIMESTAMP;
			";

		// Exécution de la requête
		$pdo->exec($query);
	} catch (PDOException $e) {
		echo 'configCreateTableNino-echec --> ' . $e->getMessage();
		exit;
	}

		// Création de la table DOMAINS
		try {
			// Définir le mode d'erreur de PDO sur Exception
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
			// Requête de création de table
			$query = "
			CREATE TABLE IF NOT EXISTS luma_domains (
				id INT PRIMARY KEY AUTO_INCREMENT,
				domains VARCHAR(255) NULL,
				domains_autorized VARCHAR(255) NULL,

			)
		";
			// Exécution de la requête
			$pdo->exec($query);
		} catch (PDOException $e) {
			echo 'configCreateTableDomains-echec --> ' . $e->getMessage();
			exit;
		}
	echo "succes";
}
