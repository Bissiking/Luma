<link rel="stylesheet" href="css/init.css?0">
<script>
    document.title = "Inscription";
</script>

<h2>Formulaire d'Inscription <span class="betaPops">BETA</span></h2>

<form id="register" class="content">
    <div class="step-content active">

        <div class="input-container">
            <input type="text" id="identifiant" name="identifiant" placeholder="">
            <label for="identifiant">Identifiant:</label>
            <span class="underline"></span>
        </div>

        <div class="input-container">
            <input type="password" id="password" name="password" placeholder="">
            <label for="password">Mot de passe:</label>
            <span class="underline"></span>
        </div>

        <?php if (isset($_SESSION['authentification']['user'])) : ?>
            <div class="input-container">
                <div class="custom-select">
                    <select name="master"></select>
                    <div class="select-styled">Choix du type de compte</div>
                    <div class="select-options">
                        <option value="kids_account">Compte enfant (Vous gérez ce nouveau compte)</option>
                        <option value="0">Le compte fonctionne séparément de celui-ci</option>
                    </div>
                </div>
            </div>
        <?php endif; ?>


        <div class="button-block">
            <?php if (!isset($_SESSION['authentification']['user'])) : ?><button id="connect" class="custom-button">Déjà un compte</button><?php endif; ?>
            <button type="submit" class="custom-button">S'enregistrer</button>
        </div>

    </div>
</form>


<script src="../javascripts/inscription.js"></script>