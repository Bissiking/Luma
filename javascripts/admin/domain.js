function addDomain() {
    // Effectuer la requête AJAX
    let domain = $('#add-domain').val();
    if (domain == "") {
        showPopup("Domaine non valide", false);
        return;
    }

    $.ajax({
        type: 'POST',
        url: '/admin/domains',
        data: 'call=add&domain='+domain,
        success: function(response) {
            console.log(response);
            if (response == 'succes') {
                window.location.href = window.location.href;
            }else if(response == 'found') {
                showPopup("Domain déjà existant", false);
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

function delDomain(domain) {
    // Effectuer la requête AJAX
    console.log(domain);
    if (domain == "") {
        showPopup("Domaine non valide", false);
        return;
    }

    $.ajax({
        type: 'POST',
        url: '/admin/domains',
        data: 'call=del&domain='+domain,
        success: function(response) {
            console.log(response);
            if (response == 'succes') {
                window.location.href = window.location.href;
            }else{
                showPopup("Echec de la suppression", false);
            }
            
        },
        error: function(error) {
            console.error('Erreur de connexion:', error);
            showPopup("Une erreur inconnu est survenue. Reéssayer plus tard", false);
        }
    });
}