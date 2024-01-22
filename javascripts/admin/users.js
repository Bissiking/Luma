var POST = 0;
$('.edit-user').click(function () {
    let user = $(this).data('identifiant');
    if (user !== 'system') {
        window.location.href = '/admin/users?edit&user=' + user;
    }
});

// ADD USER
function addUser() {

    let add = "add-";

    let nomComplet = $("#" + add + "nomComplet"),
        identifiant = $("#" + add + "identifiant"),
        email = $("#" + add + "email"),
        account_administrator = $("#" + add + "account_administrator");

        if (identifiant.val() == ""){
            showPopup("Identifiant non renseigné", false);
            return;
        }

        if (email.val() == ""){
            showPopup("Email non renseigné", false);
            return;
        }

    if (POST == 0) {
        POST = 1;
        // Effectuer une requête AJAX
        $.ajax({
            url: '../functions/admin/user_add.php', // Remplacez par votre script côté serveur qui gère l'ajout
            type: 'POST',
            data: {
                nomComplet: nomComplet.val(),
                identifiant: identifiant.val(),
                email: email.val(),
                account_administrator: account_administrator.val()
        },
            success: function (response) {
                if (response == "succes") {
                    window.location.href = window.location.href;
                }else if (response == "user-found") {
                    showPopup("Utilisateur déjà présent", false);
                }else{
                    showPopup("Tous les champs ne sont pas valide", false);
                }
                POST = 0;
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

}