<link rel="stylesheet" href="css/init.css">
<script>
	document.title = "Connexion";
</script>

<div class="login-container">
	<h2>Se connecter</h2>
    <label for="identifiant">Nom d'utilisateur:</label>
    <input type="text" id="identifiant" name="identifiant" required>

    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" required>

    <button type="button" onclick="performLogin()">Connexion</button>
</div>

<!-- Afficher le résultat de la connexion ici -->
<div id="loginResult"></div>

<!-- SCRIPTS -->
<script src="javascripts/connexion.js"></script>