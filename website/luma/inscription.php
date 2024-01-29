<link rel="stylesheet" href="css/init.css">
<script>
    document.title = "Inscription";
</script>

<h2>Formulaire d'Inscription <span class="betaPops">BETA</span></h2>

<form id="register" class="login-container" method="post">

    <label for="identifiant">Identifiant:</label>
    <input type="text" id="identifiant" name="identifiant">

    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password">

    <label for="email">Email:</label>
    <input type="email" id="email" name="email">
    <p class="info-popup">
        L'email servira à activer votre compte et avoir une double authentification quand celle-ci seront disponibles.<br>
        La possiblité de recevoir des mails quand une vidéo sort sera aussi possible .... Quand celle-ci sera aussi développer.... Quelle grosse merde ce DEV <br>
        <br>
        Par default, le mail ne sera utilisé en aucun cas, donc si vous rentrez une adresse mail bidon, bah balek 😂. En vrai, je penses même, que sa ne sera pas obligatoire. <br>
        Je dis, je penses, car l'option n'est pas encore développer 😊
    </p>

    <button type="submit">S'inscrire</button>
</form>

<script src="../javascripts/inscription.js"></script>