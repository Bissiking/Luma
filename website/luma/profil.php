<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/profils.css?0">
</head>

<body>
    <div class="container">
        <!-- <form class="form-container" id="logoForm">
            En approche !!! 
        </form> -->
        <form class="form-container" id="profileForm">
            <div class="input-container">
                <input type="text" id="nomComplet" placeholder="" value="<?= ($_SESSION['authentification']['user']['nomComplet'] != '') ? $_SESSION['authentification']['user']['nomComplet'] : ''  ?>">
                <label for="nomComplet">Nom complet</label>
                <span class="underline"></span>
            </div>

            <div class="input-container">
                <input type="password" id="password" placeholder="">
                <label for="password">Nouveau mot de passe</label>
                <span class="underline"></span>
            </div>

            <div class="input-container">
                <input type="password" id="confirm-password" placeholder="">
                <label for="confirm-password">Confirmation du nouveau mot de passe</label>
                <span class="underline"></span>
            </div>

            <div class="input-container">
                <input type="email" id="email" placeholder="" value="<?= ($_SESSION['authentification']['user']['email'] != '') ? $_SESSION['authentification']['user']['email'] : ''  ?>">
                <label for="email">Email</label>
                <span class="underline"></span>
            </div>

            <div class="button-block">
                <button type="submit" class="custom-button">Enregistrer</button>
            </div>
        </form>
        <div id="message"></div>
    </div>
    <script src="javascripts/home/profils.js?0"></script>
</body>

</html>