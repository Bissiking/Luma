var POST = 0;

$('.UPBDDVer').click(function(e) {
    e.preventDefault();
    if (POST == 0) {
        POST = 1;
        $.ajax({
            type: 'POST',
            url: window.location.href,
            success: function() {
                showPopup("Base de donnée à jour", true);
                setTimeout(() => {
                    window.location.href = window.location.href;
                }, 1000);
            },
            error: function(error) {
                console.error('Erreur de connexion:', error);
                showPopup("Une erreur inconnu est survenue. Reéssayer plus tard", false);
            }
        });
    }
});

$('.update').click(function(e) {
    e.preventDefault();
    let bdd = $(this).data('bdd');
    let forms = 'bdd='+bdd;
    if (POST == 0) {
        POST = 1;
        $.ajax({
            type: 'POST',
            url: '../functions/admin/update_bdd.php',
            data: forms,
            success: function(response) {
            console.log(response);
                           
                if (response == 'succes') {
                   window.location.href = window.location.href;
                   POST = 0;
                }   
            },
            error: function(error) {
                console.error('Erreur de connexion:', error);
                showPopup("Une erreur inconnu est survenue. Reéssayer plus tard", false);
            }
        });
    }
});