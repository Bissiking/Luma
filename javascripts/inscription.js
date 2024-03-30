$('#register').submit(function (e) {
    e.preventDefault();

    // UPLOAD FORM
    var formData = new FormData($('#register')[0]);

    // Effectuer la requête AJAX
    $.ajax({
        type: 'POST',
        url: 'functions/register',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);
            switch (response) {
                case 'user-exist':
                    showPopup("warning", "L'identifiant est déjà utilisé", "L'identifiant est déjà pris, veuillez en choisir un autre");
                    break;

                case 'empty':
                    showPopup("warning", "Petit oublie ???", "Tous les champs ne sont pas bien remplie ...");

                    break;

                    case 'succes':
                        showPopup("good", "Oh le petit boutchou !!", "Ah bah qui voilà !! C'est "+formData.get('identifiant'));
                    break;

                default:
                    showPopup("error", "Aïe !!! Je me suis fait mal", "Une erreur inconnu est survenue.");
                    break;
            }
        },
        error: function (error) {
            console.error('Erreur de connexion:', error);
            showPopup("error", "Aïe !!! Je me suis fait mal", "Une erreur inconnu est survenue.");
        }
    });
});

$(document).ready(function() {
    // Gérer le clic sur une option
    $('.select-options option').click(function() {
        // Récupérer la valeur et le texte de l'option sélectionnée
        var value = $(this).val();
        var text = $(this).text();

        // Mettre à jour le texte du conteneur personnalisé avec le texte de l'option sélectionnée
        $('.select-styled').text(text);
        
        // Mettre à jour la valeur du menu déroulant caché
        $('select').html('<option value="'+value+'">'+text+'</option>');
    });
});


$('#connect').click(function (e) {
    e.preventDefault();
    window.location.href = "/connexion";
});
