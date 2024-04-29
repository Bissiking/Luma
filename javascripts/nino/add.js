function reserveVideo(event) {
    //event.preventDefault();
    var titre = $('#videoTitle').val(),
        APIselect = $('#APIselect').val();

    // Effectuer la requête AJAX
    $.ajax({
        type: 'POST',
        url: 'functions/nino_add',
        data: { titre: titre, APIselect: APIselect },
        success: function (response) {
            console.log(response);
            if (response == 'succes') {
                window.location.href = "/nino/add";
            } else {
                showPopup("warning", "Nino !!", "Une informations à renseigner... Et tu as réussi à rater");
            }

        },
        error: function (error) {
            console.error('Erreur de connexion:', error);
            showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Reéssayer plus tard");
        }
    });
}
