function CheckService(status) {
    if (status == 'running') {
        return true;
    } else {
        return false;
    }
}

function convertTimestampToDateTime(timestamp) {
    // Supposons que cette fonction formate l'horodatage en chaîne date-heure lisible
    return new Date(timestamp).toLocaleString();
}

function ContainerCheck() {
    $.ajax({
        url: url + "docker-data.json",
        dataType: 'json',
        cache: false,
        success: function (response) {

            // Arrêt du chergement en cas de non sonde active
            if (response.result.containers.docker === "no-data") {
                console.log('Pas de container');
                $("#content-docker").append(
                    '<div id="no-data" class="content-agent config-agent-docker">' +
                    '<h4>Aucun container</h4>' +
                    '<p class="config-agent">Statut du container <button class="agent offline not-allowed">' + 'Aucun container' + '</button></p>' +
                    '</div>'
                );
                clearInterval(ContainerCheckFun);
                return;
            }

            let containersString = response.result.containers;
            let containers = JSON.parse(containersString);

            let NbContainers = containers.length;

            for (let i = 0; i < NbContainers; i++) {
                let currentTime = Date.now();
                let sondeTime = new Date(response.result.date);
                let elapsedTimeInSeconds = (currentTime - sondeTime) / 1000;

                const jours = Math.floor(elapsedTimeInSeconds / (3600 * 24));
                const heures = Math.floor((elapsedTimeInSeconds % (3600 * 24)) / 3600);
                const minutes = Math.floor((elapsedTimeInSeconds % 3600) / 60);
                const secondes = Math.floor(elapsedTimeInSeconds % 60);
                let sectionAlerte = "RAS";
                let txtSonde = "";
                let ClassBtn = "";

                if (elapsedTimeInSeconds > 600) {
                    sectionAlerte = "sonde-error";
                    txtSonde = `La sonde ne répond plus depuis : ${jours} Jour(s), ${heures} Heure(s), ${minutes} minute(s) et ${secondes} seconde(s)`;
                } else if (elapsedTimeInSeconds > 300) {
                    sectionAlerte = "sonde-warning";
                    txtSonde = `La sonde ne répond plus depuis : ${jours} Jour(s), ${heures} Heure(s), ${minutes} minute(s) et ${secondes} seconde(s)`;
                } else {
                    txtSonde = convertTimestampToDateTime(sondeTime);
                }

                if ($('#' + containers[i].id).length > 0) {
                    let Check = CheckService(containers[i].status);

                    $('#' + containers[i].id).removeClass().addClass('content-agent config-agent-docker');
                    $('#' + containers[i].id).find('button').removeClass("offline active");

                    if (!Check) {
                        txtSonde = "Stoppé";
                        ClassBtn = "offline";
                    }

                    $('#' + containers[i].id).find('button').text(txtSonde).addClass(ClassBtn);
                } else {
                    let Check = CheckService(containers[i].status);
                    if (!Check) {
                        sectionAlerte = "sonde-error";
                    }
                    $("#content-docker").append(
                        '<div id="' + containers[i].id + '" class="content-agent config-agent-docker ' + sectionAlerte + '">' +
                        '<h4>' + containers[i].name + '</h4>' +
                        '<p class="config-agent">Statut du container <button class="agent not-allowed">' + 'Mise à jour' + '</button></p>' +
                        '</div>'
                    );
                }
            }
        },
        error: function (error) {
            console.error('Erreur lors du chargement du fichier JSON :', error);
            clearInterval(ContainerCheckFun);
        }
    });
}

ContainerCheck();
var ContainerCheckFun = setInterval(ContainerCheck, 10000);
