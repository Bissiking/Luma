$(document).ready(function () {
    $('select').on('change', function () {
        var selectedOption = $(this).val();
        var selectedName = $(this).attr('id');
        var inputName = $('#name_service').attr('name');



        if (selectedName === "srv_service") {
            // Si le "select" est celui de création
            if (inputName == "" || inputName == null || inputName == undefined) {
                showPopup("error", "Bah mon grand !!!", "Faut remplir tout les champs mon copaing, sinon, c'est pété !!");
                return;
            }
        } else {
            inputName = $(this).data('service');
        }

        $.ajax({
            type: 'POST',
            url: 'functions/statut',
            data: 'selectedOption=' + selectedOption+'&selectedName=' + selectedName+'&inputName=' + inputName,
            success: function (response) {
                if (response == "exist") {
                    showPopup("warning", "On a encore eu de la chance", "Un doublon à été évité ! regarde ta liste et confirme !");
                }else if(response == "succes"){
                    showPopup("good", "Magnifique ...", "Création du service réussi");
                    window.location.href = window.location.href;
                }else{
                    showPopup("error", "Mince, je me suis blessé ...", "J'ai eu une erreur non répertorié. regarde les logs pour avoir plus d'informations");
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
});

$('button.delete').on('click', function() {
    inputName = $(this).attr('data-id');
    console.log(inputName);

    $.ajax({
        type: 'POST',
        url: 'functions/statut',
        data: 'selectedOption=' + 'delete&selectedName=delete&inputName=' + inputName,
        success: function (response) {
            console.log(response);
            if (response == "exist") {
                showPopup("warning", "On a encore eu de la chance", "Un doublon à été évité ! regarde ta liste et confirme !");
            }else if(response == "succes"){
                showPopup("good", "Magnifique ...", "Création du service réussi");
                window.location.href = window.location.href;
            }else{
                showPopup("error", "Mince, je me suis blessé ...", "J'ai eu une erreur non répertorié. regarde les logs pour avoir plus d'informations");
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
});

$('#name_service').on('keyup', function () {
    let valInput = $(this).val();
    $(this).attr('name', valInput);
});