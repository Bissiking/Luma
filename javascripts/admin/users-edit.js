var POST = 0;

$('#editUserInfo').click(function(e) {
    e.preventDefault();
    let nom_complet = $('#nom_complet').val();
    let email = $('#email').val();

    let form = 'nom_complet='+nom_complet+'&email='+email;
    if (POST == 0) {
        POST = 1;
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: form,
            success: function(response) {
                console.log(response);
                POST = 0;
                if (response == 'succes') {
                    window.location.href = window.location.href;    
                }else{
                    showPopup("Echec de l'édition", false);
                }
                
            },
            error: function(error) {
                console.error('Erreur de connexion:', error);
                showPopup("Une erreur inconnu est survenue. Reéssayer plus tard", false);
            }
        });
    }
});


