function agent_add() {
    // Effectuer la requête AJAX
    let uuid_agent = $('#uuid_agent').val(),
        agent_name = $('#agent_name').val(),
        module = $('#module').val();

    $.ajax({
        type: 'POST',
        url: './functions/agent_create',
        data: {
            uuid_agent: uuid_agent,
            agent_name: agent_name,
            module: module
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

function DashAgent(uuid, module) {
    if (module === "agent_minecraft") {
        window.location.href = "/agent/uuid/minecraft/" + uuid;
    }else{
        window.location.href = "/agent/uuid/luma/" + uuid;
    }
}

function ColorStatut(divID, etatStats) {
    $(divID).removeClass();
    $(divID).addClass('agent-etat');
    $(divID).addClass(etatStats);
}

function SatutAgentGlob() {
    var modernBoxes = $('.modern-box');
    let online = 0;
    let offline = 0;
    let maintenance = 0;
    let promises = [];

    modernBoxes.each(function() {
        var data = $(this).data('uuidagent');
        var statut = $(this).data('statut');
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

                    if (statut == 99) {
                            maintenance++;
                            $('#agent-statut-'+data).text('En maintenance');
                            ColorStatut('#agent-statut-'+data, 'warning');
                    }else{
                        if (elapsedTimeInSeconds > 600) { // 10 Minutes
                            offline++;
                            $('#agent-statut-'+data).text('Hors ligne');
                            ColorStatut('#agent-statut-'+data, 'error');
                        } else {
                            online++;
                            $('#agent-statut-'+data).text('En ligne');
                            ColorStatut('#agent-statut-'+data, 'good');
                        }
                        
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

        console.log(online);
        console.log(offline);
        console.log(maintenance);

        $('#agent-up-txt').text(online);
        $('#agent-down-txt').text(offline);
        $('#agent-maintenance-txt').text(maintenance);
    });
}


SatutAgentGlob();

setInterval(() => {
    SatutAgentGlob();
}, 60000);