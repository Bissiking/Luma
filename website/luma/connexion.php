<link rel="stylesheet" href="css/init.css?0">
<link rel="stylesheet" href="css/connexion.css?0">
<script>
    document.title = "Connexion";
</script>

<?php if (!isset($_SESSION['authentification']['user'])) : ?>

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
            <button id="inscription" class="custom-button">Inscription</button>
            <button type="button" onclick="performLogin()" class="custom-button">Connexion</button>
        </div>
    </div>

<?php else : ?>

    <div class="login-container step-content">
        <h2>Se connecter</h2>

        <?php if (isset($_GET['logout'])) :
            session_destroy();
        ?>
            <div class="input-container">
                <p style="text-align: center;">Déconnexion en cours</p>
            </div>
            <script>
                setTimeout(() => {
                    showPopup("info", "Déconnexion", "Vous êtes déconnecté");
                    setTimeout(() => {
                        window.location.href = "/";
                    }, 4000);
                }, 1000);
            </script>
        <?php else : ?>
            <div class="input-container">
                <p style="text-align: center;">Vous êtes déjà connecté</p>
            </div>
        <?php endif; ?>

    </div>

<?php endif; ?>


<!-- SCRIPTS -->
<script src="javascripts/connexion.js?0"></script>