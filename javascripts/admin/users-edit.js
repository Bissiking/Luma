var POST = 0;

$('#editUserInfo').click(function (e) {
    e.preventDefault();
    let nom_complet = $('#nom_complet').val();
    let email = $('#email').val();

    let form = 'call=edit&nom_complet=' + nom_complet + '&email=' + email;
    if (POST == 0) {
        POST = 1;
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: form,
            success: function (response) {
                POST = 0;
                // console.log(response);
                if (response == 'succes') {
                    window.location.href = window.location.href;
                } else {
                    showPopup("error", "Petit soucis imprévu ...", "L'utilisateur n'a pas pu être modifié");
                }

            },
            error: function (error) {
                console.error('Erreur de connexion:', error);
                showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Reéssayer plus tard");
            }
        });
    }
});

// Ajout

$('.button-domain').on('click', function (e) {
    e.preventDefault();

    let val = $(this).data('domain');
    let call = $(this).data('action');

    if (call == "add-domain" || call == "delete-domain") {
        let form = 'call=' + call + '&domain=' + val;
        if (POST == 0) {
            POST = 1;
            $.ajax({
                type: 'POST',
                url: window.location.href,
                data: form,
                success: function (response) {
                    POST = 0;
                    if (response == 'succes') {
                        window.location.href = window.location.href;
                    } else {
                        showPopup("error", "Petit soucis imprévu ...", "L'utilisateur n'a pas pu être modifié");
                    }

                },
                error: function (error) {
                    console.error('Erreur de connexion:', error);
                    showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Reéssayer plus tard");
                }
            });
        }
        return;
    }
});
