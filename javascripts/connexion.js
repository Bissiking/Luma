function performLogin() {
    var identifiant = $('#identifiant').val();
    var password = $('#password').val();

    // Effectuer la requête AJAX
    $.ajax({
        type: 'POST',
        url: 'functions/login.php', // Remplacez ceci par le chemin de votre script côté serveur
        data: { identifiant: identifiant, password: password },
        success: function(response) {
            // Afficher le résultat de la connexion
            $('#loginResult').html(response);
            if (response == "succes") {
                showPopup("Vous êtes connecté, Redirection dans 3 Secondes", true);
                setTimeout(() => {
                    window.location.href = '/';
                }, 3000);
            }else{
                showPopup("Identitifant ou mot de passe incorrect", false)
            }
        },
        error: function(error) {
            console.error('Erreur de connexion:', error);
            showPopup("Une erreur inconnu est survenue. Reéssayer plus tard", false);
            $('button').hide();

        }
    });
}