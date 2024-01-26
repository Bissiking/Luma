$('#uploadForm').submit(function (e) {
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
            } else {
                showPopup("error", "Nino pas content :(", "Il y'a des soucis avec un ou plusieurs champs, vérifie... Formulaire en BETA, donc des bogues peuvent survenir.");
            }
        },
        error: function (error) {
            console.error('Erreur de connexion:', error);
            showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Reéssayer plus tard");
        }
    });
});


function CheckVideoAPI() {
    let loadPops = $('.loadPopsIco');
    let loadPopsTxt = $('.loadText');
    let divApi = $('.checkApi');
    $.ajax({
        type: 'GET',
        url: 'https://'+divApi.attr('data-UrlAPI')+'/video/'+divApi.attr('data-idAPI'),
        success: function (response) {
            console.log(response);
            loadPops.removeClass('loader');
            if (response == "exist") {
                loadPops.html('<i class="fa-regular fa-circle-check good-txt"></i>');
                loadPopsTxt.text('Dossier trouvé, upload de la vidéo possible');
            } else if (response == "no-exist") {
                $('.checkApi').addClass('pointerClick');
                loadPopsTxt.text('Dossier non trouvé, vous pouvez cliquer sur la popup pour déclancher la création');
                loadPops.html('<i class="fa-solid fa-triangle-exclamation warning-txt"></i>');
            } else {
                loadPops.html('<i class="fa-solid fa-xmark error-txt"></i>');
                loadPopsTxt.text('Une erreur est survenu');
                showPopup("error", "l'API parle chelou", "L'API a renvoyé aucune valeur, ou une valeur incorrecte. Il se peut que votre site ne soit pas à jour");
            }
        },
        error: function (error) {
            loadPops.removeClass('loader');
            console.error('Erreur de connexion:', error);
            loadPopsTxt.text('Echec de la vérification');
            showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Reéssayer plus tard");
        }
    });
}

function SendDemCreation() {
    let divApi = $('.checkApi');
    if (divApi.hasClass('pointerClick')) {
        $.ajax({
            type: 'POST',
            url: 'https://'+divApi.attr('data-UrlAPI')+'/createVideo/'+divApi.attr('data-idAPI'),
            success: function (response) {
                console.log(response);
                if (response == "succes") {
                    location.reload();
                } else {
                    showPopup("error", "l'API a des petits raté parfois", "La création du dossier à échoué. Réactualise pour vérifier, sinon recommence dans 5 minutes");
                }
            },
            error: function (error) {
                console.error('Erreur de connexion:', error);
                showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Reéssayer plus tard");
            }
        });  
    }

}

setTimeout(() => {
    CheckVideoAPI()
}, 2000);