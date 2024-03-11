function agent_add() {
    // Effectuer la requête AJAX
    let uuid_agent = $('#uuid_agent').val(),
        agent_name = $('#agent_name').val();

    $.ajax({
        type: 'POST',
        url: './functions/agent_create',
        data: {
            uuid_agent: uuid_agent,
            agent_name: agent_name
        },
        success: function (response) {
            console.log(response);
            if (response == 'succes') {
                window.location.href = "/agent";
            } else if (response == 'empty') {
                showPopup("error", "Bah mon grand, tu as oublié un truc", "Alors !! Je penses que tu as oublié de rensiengé un nom ou celui-ci n'est pas valide.");
            } else if (response == 'exist') {
                showPopup("warning", "le nom de l'agent existe déjà", "Trouve un autre nom ...");
            } else {
                showPopup("error", "Petit soucis imprévu ...", "Ajout de l'agent en erreur");
            }
        },
        error: function (error) {
            console.error('Erreur de connexion:', error);
            showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Recommance plus tard");
        }
    });
}

function DashAgent(uuid) {
    window.location.href = "/agent/uuid/" + uuid;
}

function SatutAgentGlob() {
    var modernBoxes = $('.modern-box');
    let online = 0;
    let offline = 0;
    let promises = [];

    modernBoxes.each(function() {
        var data = $(this).data('uuidagent');
        var url = "/data/" + data + "/";
        var promise = new Promise(function(resolve, reject) {
            $.ajax({
                url: url + "agent-online-data.json",
                dataType: 'json',
                cache: false,
                success: function(response) {
                    // Calcule du temps d'actualisation de la sonde
                    var currentTime = new Date();
                    var sondeTime = new Date(response.result.date);
                    var elapsedTimeInSeconds = (currentTime - sondeTime) / 1000;
                    if (elapsedTimeInSeconds > 3600000) {
                        offline++; 
                    } else {
                        online++;
                    }
                    resolve();
                },
                error: function(error) {
                    offline++;
                    resolve();
                }
            });
        });
        promises.push(promise);
    });

    Promise.all(promises).then(function() {
        // Indication du nombre
        $('#agent-up-txt').text(online);
        $('#agent-down-txt').text(offline);
    });
}


SatutAgentGlob();

setInterval(() => {
    SatutAgentGlob();
}, 60000);