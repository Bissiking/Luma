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
            showPopup("error", "Y'a une logique ...", "Si tu ne renseigne pas d'identifiant, sa ne fonctionnera pas, et puis comment il va se connecter le gars ou la dame ?");
            return;
        }

        if (email.val() == ""){
            showPopup("warning", "Email non renseigné", "Merci de rensiengné un email valide");
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
                    showPopup("warning", "Doublon évité, on a encore eu de la chance", "L'identifiant existe déjà, et tout le monde sait que deux identifiant va foutre un sacré bordel");
                }else{
                    showPopup("error", "Petit soucis imprévu ...", "Raison de l'erreur ?? Regarde les log.... si il y'en a");
                }
                POST = 0;
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

}