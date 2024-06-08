$(document).ready(function () {
    $('select#srv_service').on('change', function () {
        var selectedOption = $(this).val();
        var selectDocker = $('#srv_service_docker');

        selectDocker.html('<option selected="" disabled="" hidden="">Liste des containers (Actualisation auto)</option>');

        // Recherche containers docker
        $.ajax({
            type: 'GET',
            url: '/data/' + selectedOption + '/docker-data.json',
            success: function (response) {

                let containers = response.result.containers;
                containers = JSON.parse(containers);

                for (let c = 0; c < containers.length; c++) {
                    var element = containers[c];
                    $('#srv_service_docker').append('<option value="' + element.id + '">' + element.name + '</option>')
                }

            },
            error: function (error) {
                console.log('STOP');
                console.log(error);
            }
        });
    });


    $('#btn_add_sonde').on('click', function () {
        var selectedName = $(this).attr('id');
        var inputName = $('#name_service').val();
        var selectedOption = $('#srv_service').val();
        var uuid_docker = $('#srv_service_docker').val();
    
        // Vérifier que tous les champs sont remplis
        if (!inputName || !selectedOption) {
            showPopup("error", "Bah mon grand !!!", "Faut remplir tous les champs mon copaing, sinon, c'est pété !!");
            return;
        }
    
        // Définir inputName correctement
        if (!inputName) {
            inputName = $(this).data('service');
        }
    
        // Log les valeurs pour le débogage
        console.log("selectedName:", selectedName);
        console.log("inputName:", inputName);
        console.log("selectedOption:", selectedOption);
        console.log("uuid_docker:", uuid_docker);
    
        $.ajax({
            type: 'POST',
            url: 'functions/statut',
            data: {
                selectedOption: selectedOption,
                selectedName: selectedName,
                inputName: inputName,
                uuid_docker: uuid_docker
            },
            success: function (response) {
                if (response == "exist") {
                    showPopup("warning", "On a encore eu de la chance", "Un doublon à été évité ! regarde ta liste et confirme !");
                } else if (response == "succes") {
                    showPopup("good", "Magnifique ...", "Création du service réussi");
                    window.location.reload();
                } else {
                    showPopup("error", "Mince, je me suis blessé ...", "J'ai eu une erreur non répertoriée. regarde les logs pour avoir plus d'informations");
                    console.log(response);
                }
            },
            error: function (error) {
                console.error('Erreur lors de l\'envoi de la requête:', error);
            }
        });
    });
    

    $('button.delete').on('click', function () {
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
                } else if (response == "succes") {
                    showPopup("good", "Magnifique ...", "Création du service réussi");
                    window.location.href = window.location.href;
                } else {
                    showPopup("error", "Mince, je me suis blessé ...", "J'ai eu une erreur non répertorié. regarde les logs pour avoir plus d'informations");
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
});