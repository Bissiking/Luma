document.getElementById('profileForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var formData = new FormData($('#profileForm')[0]);

    let password = $('#password').val();
    let ConfirmPassword = $('#confirm-password').val();

    // Vérification du mot de passe
    if (password !== "") {
        if (ConfirmPassword !== password) {
            showPopup("error", "Perdu !", "Les mots de passe ne correspondent pas");
            return;
        }
    }

    $.ajax({
        type: 'POST',
        url: 'functions/profils',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response == "EMPTY") {
                showPopup("error", "Bah mon grand !!!", "Faut remplir tout les champs mon copaing, sinon, c'est pété !!");
            }else if(response == "succes"){
                showPopup("good", "Magnifique ...", "Mise à jour du compte OK");
            }else{
                showPopup("error", "Mince, je me suis blessé ...", "J'ai eu une erreur non répertorié. regarde les logs pour avoir plus d'informations");
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
});

$('input').on('change', function() {
    let inputVal = $(this).val();
    let inputID = $(this).attr('id');

    if (inputVal === "") {
        $(this).removeAttr('name'); // Supprime l'attribut name si la valeur est vide
    } else {
        $(this).attr('name', inputID);
    }
});