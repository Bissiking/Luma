function performLogin() {
    var identifiant = $('#identifiant').val();
    var password = $('#password').val();

    // Effectuer la requête AJAX
    $.ajax({
        type: 'POST',
        url: 'functions/login', // Remplacez ceci par le chemin de votre script côté serveur
        data: { identifiant: identifiant, password: password },
        success: function (response) {
            // Afficher le résultat de la connexion
            if (response == "succes") {
                showPopup("good", "YOUHOU !!", "Vous êtes connecté, Redirection dans 4 Secondes, pas 3, pas 5, 4 ! ... Ouais je suis précis.");
                setTimeout(() => {
                    window.location.href = '/';
                }, 4000);
            } else if (response == "error_domain") {
                showPopup("error", "Ah merde !!", "Tu n'es pas autorisé à te connecter sur ce domaine");
            } else {
                showPopup("error", "Euh ... Petit soucis là", "Identifiant ou mot de passe incorrect.... Je suppose ....");
            }
        },
        error: function (error) {
            console.error('Erreur de connexion:', error);
            showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Reéssayer plus tard");
            $('button').hide();

        }
    });
}

$('#identifiant, #password').keydown(function (event) {
    if (event.key === 'Enter') {
        performLogin();
    }
});

$('#inscription').click(function (e) {
    e.preventDefault();
    window.location.href = "/inscription";
});