<link rel="stylesheet" href="css/init.css">
<script>
	document.title = "Connexion à une base de donnée";
</script>

<div class="login-container">
	<h2>Information essentielles</h2>
	<label for="URL_HOST">Domaine utilisé:</label>
	<span id="SPAN-URL_HOST" class="info-popup">Le domaine utilisé permet de voir sur qu'elle domain, le site va renseigné s'initialisé. Ceci permet au routeur de plus facilement attribué les pages essentielles au bon fonctionnement.</span>
	<input type="text" id="URL_HOST" name="URL_HOST" placeholder="<?= $_SERVER['HTTP_HOST'] ?>" disabled>

	<h2>Création d'un compte Admin</h2>
	<label for="SYS_NAME">Identifiant Nexus:</label>
	<span id="SPAN-SYS_NAME" class="info-popup">L'identifiant "system" permet au site d'effectué des actions essentielles même si votre compte n'est pas autorisé.</span>
	<input type="text" id="SYS_NAME" name="SYS_NAME" placeholder="system" disabled>
	
	<label for="USER_ADMIN">Identifiant administrateur (Compte administrateur):</label>
	<span id="SPAN-USER_ADMIN" class="error-popup">Identifiant administrateur non conforme</span>
	<input type="text" id="USER_ADMIN" name="USER_ADMIN">

	<label for="USER_ADMIN_MDP">Mot de passe administrateur:</label>
	<span id="SPAN-USER_ADMIN_MDP" class="error-popup">Mot de passe administrateur non conforme</span>
	<input type="USER_ADMIN_MDP" id="USER_ADMIN_MDP" name="USER_ADMIN_MDP">

	<h2>Connexion à la base de donnée</h2>
	<label for="DB_HOST">IP ou domaine de la BDD:</label>
	<input type="text" id="DB_HOST" name="DB_HOST" placeholder="Default: localhost">

	<label for="DB_PORT">Port de la BDD:</label>
	<input type="DB_PORT" id="DB_PORT" name="DB_PORT" placeholder="Default: 3306">

	<label for="DB_NAME">Nom de la BDD:</label>
	<span id="SPAN-DB_NAME" class="error-popup">Nom de la BDD non conforme</span>
	<input type="DB_NAME" id="DB_NAME" name="DB_NAME" required>

	<label for="DB_USER">Utilisateur de la BDD:</label>
	<span id="SPAN-DB_USER" class="error-popup">Utilisateur BDD non conforme</span>
	<input type="DB_USER" id="DB_USER" name="DB_USER" required>

	<label for="DB_PASSWORD">Mot de passe de la BDD:</label>
	<input type="DB_PASSWORD" id="DB_PASSWORD" name="DB_PASSWORD">

	<button onclick="testConnection(event)" id="testButton">Se Connecter</button>
</div>
<script src="javascripts/init-connectBdd.js"></script>