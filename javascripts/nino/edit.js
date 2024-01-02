function EditVideo(event) {
    //event.preventDefault();

    var title = $('#videoTitle').val();
    var id_users = $('#btnEditVideo').data('id_users');

    // Effectuer la requête AJAX
    $.ajax({
        type: 'POST',
        url: 'https://nino.mhemery.fr/api/videos/edit',
        data: { title: title, id_users: id_users, video_status: "wait upload" },
        success: function(response) {
            window.location.href = "/nino/add";
        },
        error: function(error) {
            console.error('Erreur de connexion:', error);
            showPopup("Une erreur inconnu est survenue. Reéssayer plus tard", false);
        }
    });
}