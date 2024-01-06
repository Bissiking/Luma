function reserveVideo(event) {
    //event.preventDefault();
    var titre = $('#videoTitle').val();

    // Effectuer la requête AJAX
    $.ajax({
        type: 'POST',
        url: '../functions/nino/add.php',
        data: { titre: titre },
        success: function(response) {
            console.log(response);
            if (response == 'succes') {
                window.location.href = "/nino/add";
            }else{
                showPopup("Le titre n'est pas valide", false);
            }
            
        },
        error: function(error) {
            console.error('Erreur de connexion:', error);
            showPopup("Une erreur inconnu est survenue. Reéssayer plus tard", false);
        }
    });
}
