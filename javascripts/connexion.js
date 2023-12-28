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
        },
        error: function(error) {
            console.error('Erreur de connexion:', error);
        }
    });
}