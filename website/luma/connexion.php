<link rel="stylesheet" href="css/init.css?0">
<link rel="stylesheet" href="css/connexion.css?0">
<script>
    document.title = "Connexion";
</script>

<div class="login-container step-content">
    <h2>Se connecter</h2>

    <div class="input-container">
        <input type="text" id="identifiant" name="identifiant" placeholder="" required>
        <label for="identifiant">Identifiant</label>
        <span class="underline"></span>
    </div>

    <div class="input-container">
        <input type="password" id="password" name="password" placeholder="" required>
        <label for="password">Mot de passe</label>
        <span class="underline"></span>
    </div>

    <div class="button-block">
        <button class="custom-button disable">Inscription</button>
        <button type="button" onclick="performLogin()" class="custom-button">Connexion</button>
    </div>
</div>

<!-- SCRIPTS -->
<script src="javascripts/connexion.js?0"></script>