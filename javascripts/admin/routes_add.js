function routesAdd(url_pattern) {
    // Effectuer la requête AJAX
    $.ajax({
        type: 'POST',
        url: '../functions/admin/routes_add.php',
        data: 'url_pattern='+url_pattern,
        success: function(response) {
            console.log(response);
            if (response == 'succes') {
                window.location.href = "/admin/routes";
            }else{
                showPopup("Echec de l'ajout", false);
            }
            
        },
        error: function(error) {
            console.error('Erreur de connexion:', error);
            showPopup("Une erreur inconnu est survenue. Reéssayer plus tard", false);
        }
    });
}