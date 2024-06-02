function reserveVideo(event, id) {
    event.preventDefault();
    var APIselect = $('#APIselect').val();

    if (APIselect == "" || APIselect == null || APIselect == undefined) {
        showPopup("warning", "Nino", "Selectionne l'API !");
        return;
    }
    // Effectuer la requête AJAX
    $.ajax({
        type: 'POST',
        url: "https://"+APIselect+"/createVideo/"+id,
        success: function (response) {
            console.log(response);
            if (response == 'succes') {
                window.location.href = "/nino/edit?id="+id;
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
