$('#register').submit(function (e) {
    e.preventDefault();

    // UPLOAD FORM
    var formData = new FormData($('#register')[0]);

    // Effectuer la requête AJAX
    $.ajax({
        type: 'POST',
        url: '../functions/register.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);
            switch (response) {
                case 'user-exist':
                    showPopup("warning", "L'identifiant est déjà utilisé", "L'identifiant est déjà pris, veuillez en choisir un autre");
                    break;

                case 'email-exist':
                    showPopup("warning", "L'email est déjà utilisé", "L'email est déjà pris, veuillez en choisir un autre");
                    break;

                case 'error':

                    break;

                    case 'succes':

                    break;

                default:
                    showPopup("warning", "Aïe !!! Je me suis fait mal", "Une erreur inconnu est survenue.");
                    break;
            }
        },
        error: function (error) {
            console.error('Erreur de connexion:', error);
            showPopup("error", "Aïe !!! Je me suis fait mal", "Une erreur inconnu est survenue.");
        }
    });
});