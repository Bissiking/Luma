$('#uploadForm').submit(function(e) {
    e.preventDefault();
    var id = $('#btnEditVideo').data('idvideo');

    // UPLOAD FORM
    var formData = new FormData($('#uploadForm')[0]);
    formData.append('id', id);

    // Effectuer la requête AJAX
    $.ajax({
        type: 'POST',
        url: '../functions/nino/edit.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);
            if (response == "succes") {
               window.location.href = "/nino/add"; 
            }else{
                showPopup("error", "Nino pas content :(", "Il y'a des soucis avec les champs, vérifie... Formulaire en BETA, donc des bogues peuvent survenir.");
            }
        },
        error: function (error) {
            console.error('Erreur de connexion:', error);
            showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Reéssayer plus tard");
        }
    });
});