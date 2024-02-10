function routesAdd(url_pattern) {
    // Effectuer la requête AJAX
    $.ajax({
        type: 'POST',
        url: './functions/routes_add',
        data: 'url_pattern='+url_pattern,
        success: function(response) {
            if (response == 'succes') {
                window.location.href = "/admin/routes";
            }else{
                showPopup("error", "Petit soucis imprévu ...", "Ajout de la route en erreur");
            }
            
        },
        error: function(error) {
            console.error('Erreur de connexion:', error);
            showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Recommance plus tard");
        }
    });
}