function addDomain() {
    // Effectuer la requête AJAX
    let domain = $('#add-domain').val();
    if (domain == "") {
        showPopup("error", "Domaine non valide", "Le domaine n'est pas valide. As-tu renseigné un domain logique ??");
        return;
    }

    $.ajax({
        type: 'POST',
        url: '/admin/domains',
        data: 'call=add&domain='+domain,
        success: function(response) {
            if (response == 'succes') {
                window.location.href = window.location.href;
            }else if(response == 'found') {
                showPopup("warning", "Tu ne le vois pas ?", "Le domaine existe déjà");
            }else{
                showPopup("error", "Petit soucis imprévu ...", "Echec de l'ajout du domaine");
            }
            
        },
        error: function(error) {
            console.error('Erreur de connexion:', error);
            showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Reéssayer plus tard");
        }
    });
}

function delDomain(domain) {
    // Effectuer la requête AJAX
    if (domain == "") {
        showPopup("error", "Domaine non valide", "Le domaine n'est pas valide. As-tu renseigné un domain logique ??");
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
                showPopup("error", "Petit soucis imprévu ...", "Echec de la suppression du domaine");
            }
            
        },
        error: function(error) {
            console.error('Erreur de connexion:', error);
            showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Reéssayer plus tard");
        }
    });
}