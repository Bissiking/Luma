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
                showPopup("warning", "Nino !!", "Un champs ... Et tu as réussi à foiré");
            }
            
        },
        error: function(error) {
            console.error('Erreur de connexion:', error);
            showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Reéssayer plus tard");
        }
    });
}
