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
                showPopup("Tous les champs ne sont pas valides.", false);
            }
        },
        error: function (error) {
            console.error('Erreur de connexion:', error);
            showPopup("Une erreur inconnu est survenue. Reéssayer plus tard", false);
        }
    });
});