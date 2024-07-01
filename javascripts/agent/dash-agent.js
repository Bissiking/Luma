var uuid = $('#agent-uuid').text();
var url = "/data/" + uuid + "/";
const nDate = new Date().toLocaleString('fr-FR', {
    timeZone: 'Europe/Paris'
});

function convertTimestampToDateTime(timestamp) {
    // Crée un nouvel objet Date en utilisant le timestamp
    var date = new Date(timestamp);

    // Obtenir les différentes parties de la date
    var year = date.getFullYear();
    var month = ("0" + (date.getMonth() + 1)).slice(-2); // Les mois sont de 0 à 11
    var day = ("0" + date.getDate()).slice(-2);
    var hours = ("0" + date.getHours()).slice(-2);
    var minutes = ("0" + date.getMinutes()).slice(-2);
    var seconds = ("0" + date.getSeconds()).slice(-2);

    // Format de la date et heure en UTC
    var formattedDate = `${day}/${month}/${year} - ${hours}:${minutes}:${seconds}`;

    return formattedDate;
}

function ModelProcessor() {
    $.ajax({
        url: url + "processor-data.json",
        dataType: 'json',
        cache: false,
        success: function (response) {
            let data = response.result.status.cpu;

            // Calcule du temps d'actualisation de la sonde
            var currentTime = Date.now(nDate);
            var sondeTime = new Date(response.result.date);
            var elapsedTimeInSeconds = (currentTime - sondeTime) / 1000;

            if (elapsedTimeInSeconds > 600) {
                // Avertissement alerte sonde
                $('#config-sys').removeClass();
                $('#config-sys').addClass('sonde-error');

                // Calcule en Heure lisible
                const jours = Math.floor(elapsedTimeInSeconds / (3600 * 24));
                const heures = Math.floor((elapsedTimeInSeconds % (3600 * 24)) / 3600);
                const minutes = Math.floor((elapsedTimeInSeconds % 3600) / 60);
                const secondes = Math.floor(elapsedTimeInSeconds % 60);

                // Message d'alerte de non contact de la sonde
                $('#config-sys-alerte').text(`La sonde ne réponds plus depuis: ${jours} Jour(s), ${heures} Heure(s), ${minutes} minute(s) et ${secondes} seconde(s)`);
            } else if (elapsedTimeInSeconds > 300) {
                // Avertissement alerte sonde
                $('#config-sys').removeClass();
                $('#config-sys').addClass('sonde-warning');

                // Calcule en Heure lisible
                const jours = Math.floor(elapsedTimeInSeconds / (3600 * 24));
                const heures = Math.floor((elapsedTimeInSeconds % (3600 * 24)) / 3600);
                const minutes = Math.floor((elapsedTimeInSeconds % 3600) / 60);
                const secondes = Math.floor(elapsedTimeInSeconds % 60);

                // Message d'alerte de non contact de la sonde
                $('#config-sys-alerte').text(`La sonde ne réponds plus depuis: ${jours} Jour(s), ${heures} Heure(s), ${minutes} minute(s) et ${secondes} seconde(s)`);
            } else {
                $('#config-sys').removeClass();
                $('#config-sys-alerte').text(`RAS`);
            }

            $('#data-agent-ModelProcessor').text(data.model);
            $('#data-agent-architecture').text(data.architecture);
            $('#data-agent-Cores').text(data.cores);
            $('#data-agent-Used').text(data.usage);
            $('#data-agent-processorUpdate').text(convertTimestampToDateTime(sondeTime));
        },
        error: function (error) {
            console.error('Erreur lors du chargement du fichier JSON :', error);
            $('#data-agent-ModelProcessor').text('Information indisponible');
            $('#data-agent-architecture').text('Information indisponible');
            $('#data-agent-Cores').text('Information indisponible');
            $('#data-agent-Used').text('Information indisponible');
            $('#data-agent-processorUpdate').text('Information indisponible');
            $('#config-sys-alerte').text(`Sonde indisponible`);

        }
    });
}

function Memory() {
    $.ajax({
        url: url + "memory-data.json",
        dataType: 'json',
        cache: false,
        success: function (response) {
            let data = response.result.status.memory;
            var currentTime = Date.now(nDate);
            var sondeTime = new Date(response.result.date);
            var elapsedTimeInSeconds = (currentTime - sondeTime) / 1000;

            if (elapsedTimeInSeconds > 300) {
                // Avertissement alerte sonde
                $('#memory-sys').removeClass();
                $('#memory-sys').addClass('sonde-error');

                // Calcule en Heure lisible
                const jours = Math.floor(elapsedTimeInSeconds / (3600 * 24));
                const heures = Math.floor((elapsedTimeInSeconds % (3600 * 24)) / 3600);
                const minutes = Math.floor((elapsedTimeInSeconds % 3600) / 60);
                const secondes = Math.floor(elapsedTimeInSeconds % 60);

                // Message d'alerte de non contact de la sonde
                $('#memory-sys-alerte').text(`La sonde ne réponds plus depuis: ${jours} Jour(s), ${heures} Heure(s), ${minutes} minute(s) et ${secondes} seconde(s)`);
            } else if (elapsedTimeInSeconds > 120) {
                // Avertissement alerte sonde
                $('#memory-sys').removeClass();
                $('#memory-sys').addClass('sonde-warning');

                // Calcule en Heure lisible
                const jours = Math.floor(elapsedTimeInSeconds / (3600 * 24));
                const heures = Math.floor((elapsedTimeInSeconds % (3600 * 24)) / 3600);
                const minutes = Math.floor((elapsedTimeInSeconds % 3600) / 60);
                const secondes = Math.floor(elapsedTimeInSeconds % 60);

                // Message d'alerte de non contact de la sonde
                $('#memory-sys-alerte').text(`La sonde ne réponds plus depuis: ${jours} Jour(s), ${heures} Heure(s), ${minutes} minute(s) et ${secondes} seconde(s)`);
            } else {
                $('#memory-sys').removeClass();
                $('#memory-sys-alerte').text(`RAS`);
            }

            let memoryFree = Math.round(data.free / (1024 * 1024));
            let memoryTotal = Math.round(data.total / (1024 * 1024));

            $('#data-agent-Memfree').text(memoryFree+ " MB");
            $('#data-agent-MemTotal').text(memoryTotal+ " MB");
            $('#data-agent-memoryUpdate').text(convertTimestampToDateTime(sondeTime))
        },
        error: function (error) {
            console.error('Erreur lors du chargement du fichier JSON :', error);

            $('#data-agent-Memfree').text('Information indisponible');
            $('#data-agent-MemTotal').text('Information indisponible');
            $('#data-agent-memoryUpdate').text('Information indisponible');
            $('#memory-sys-alerte').text(`Sonde indisponible`);
        }
    });
}

function ServicesPlex() {
    $.ajax({
        url: url + "plex-data.json",
        dataType: 'json',
        cache: false,
        success: function (response) {
            let data = response.result;
            var currentTime = Date.now(nDate);
            var sondeTime = new Date(response.result.date);
            var elapsedTimeInSeconds = (currentTime - sondeTime) / 1000;
            // Calcule en Heure lisible
            const jours = Math.floor(elapsedTimeInSeconds / (3600 * 24));
            const heures = Math.floor((elapsedTimeInSeconds % (3600 * 24)) / 3600);
            const minutes = Math.floor((elapsedTimeInSeconds % 3600) / 60);
            const secondes = Math.floor(elapsedTimeInSeconds % 60);

            if (elapsedTimeInSeconds > 900) { // 15 Minutes
                // Avertissement alerte sonde
                $('#plex-sys').removeClass();
                $('#plex-sys').addClass('sonde-error');

                // Message d'alerte de non contact de la sonde
                $('#plex-sys-alerte').text(`La sonde ne réponds plus depuis: ${jours} Jour(s), ${heures} Heure(s), ${minutes} minute(s) et ${secondes} seconde(s)`);
            } else if (elapsedTimeInSeconds > 600) { // 10 Minutes
                // Avertissement alerte sonde
                $('#plex-sys').removeClass();
                $('#plex-sys').addClass('sonde-warning');

                // Message d'alerte de non contact de la sonde
                $('#plex-sys-alerte').text(`La sonde ne réponds plus depuis: ${jours} Jour(s), ${heures} Heure(s), ${minutes} minute(s) et ${secondes} seconde(s)`);
            } else {
                $('#plex-sys').removeClass();
                $('#plex-sys-alerte').text(`RAS`);
            }

            if (data.status == 1) {
                statsTxt = 'En fonctionnement';
            } else {
                statsTxt = 'Service stoppé'
            }

            $('#data-agent-plex').text(statsTxt)
            $('#data-agent-servicesUpdate').text(convertTimestampToDateTime(sondeTime))
        },
        error: function (error) {
            console.error('Erreur lors du chargement du fichier JSON :', error);
            $('#data-agent-plex').text('Information indisponible');
            $('#data-agent-servicesUpdate').text('Information indisponible');
            $('#plex-sys-alerte').text(`Sonde indisponible`);

        }
    });
}

function LoadDisk() {
    let NbDisk = 0;
    $.ajax({
        url: url + "disk-data.json",
        dataType: 'json',
        cache: false,
        success: function (response) {
            data = response.result.status.disk;
            NbDisk = data.length; // Attribution du nombre de disque

            $('#nb-disque').text('Disques: ' + data.length);
            for (let i = 0; i < data.length; i++) {
                $("#block-disk").append(
                    '<div id="disk-' + i + '" class="box gauge--3 diskBox">' +
                    '<div class="mask">' +
                    '<div class="semi-circle">' +
                    '<span id="disk-' + i + '-text" class="pourcent">...</span>' +
                    '</div>' +
                    '<div id="disk-' + i + '-mask" class="semi-circle--mask"></div>' +
                    '</div>' +
                    '<p>' + data[i].mount + '</p>' +
                    '</div>');
            }
        },
        error: function (error) {
            console.error('Erreur lors du chargement du fichier JSON :', error);
            $('#block-disk').hide()
        }
    });
}

function ReqDisk(i) {
    $.ajax({
        url: url + "disk-data.json",
        dataType: 'json',
        cache: false,
        success: function (response) {
            let data = response.result.status.disk
            // Affichage des gauges
            let val = (Math.round(data[i].use) * 180) / 100;
            $('#disk-' + i + '-mask').attr({
                style: '-webkit-transform: rotate(' + val + 'deg);' +
                    '-moz-transform: rotate(' + val + 'deg);' +
                    'transform: rotate(' + val + 'deg);'
            });
            if (data == "stop") {
                $('#disk-' + i + '-text').text("Indisponible");
            } else {
                $('#disk-' + i + '-text').text(Math.round(data[i].use) + "%");
            }
        },
        error: function (error) {
            console.error('Erreur lors du chargement du fichier JSON :', error);
        }
    });
}

function CheckDisk() {
    let NbDiskLength = $('.diskBox').length;
    for (let i = 0; i < NbDiskLength; i++) {
        ReqDisk(i);
    }
}

function ContainerCheck() {
    $.ajax({
        url: url + "docker-data.json",
        dataType: 'json',

        cache: false,
        success: function (response) {

            let containers = response.result.containers;

            if (containers.docker === "no-data") {
                console.log('Pas de container');
                return;
            }

            containers = JSON.parse(containers);
            NbContainers = containers.length;

            for (let i = 0; i < NbContainers; i++) {
                var currentTime = Date.now(nDate);
                // Vérification du temps de mise à jour
                sondeTime = new Date(response.result.date);
                var elapsedTimeInSeconds = (currentTime - sondeTime) / 1000;
                // Calcule en Heure lisible
                const jours = Math.floor(elapsedTimeInSeconds / (3600 * 24));
                const heures = Math.floor((elapsedTimeInSeconds % (3600 * 24)) / 3600);
                const minutes = Math.floor((elapsedTimeInSeconds % 3600) / 60);
                const secondes = Math.floor(elapsedTimeInSeconds % 60);
                var sectionAlerte = "RAS";
                var txtSonde = "";

                if (elapsedTimeInSeconds > 600) {
                    // Avertissement alerte sonde
                    sectionAlerte = "sonde-error"
                    // Message d'alerte de non contact de la sonde
                    txtSonde = `La sonde ne réponds plus depuis: ${jours} Jour(s), ${heures} Heure(s), ${minutes} minute(s) et ${secondes} seconde(s)`;
                } else if (elapsedTimeInSeconds > 300) {
                    // Avertissement alerte sonde
                    sectionAlerte = "sonde-warning"
                    // Message d'alerte de non contact de la sonde
                    txtSonde = `La sonde ne réponds plus depuis: ${jours} Jour(s), ${heures} Heure(s), ${minutes} minute(s) et ${secondes} seconde(s)`;
                } else {
                    txtSonde = convertTimestampToDateTime(sondeTime)
                }



                // On vérifie si la section existe déjà
                if ($('#' + containers[i].id).length > 0) {

                    let Check = CheckService(containers[i].status);
                    if (!Check) {
                        sectionAlerte = "sonde-error";
                    }

                    // L'ID existe déjà dans la section
                    $('#' + containers[i].id).removeClass()
                    $('#' + containers[i].id).addClass('container ' + sectionAlerte)
                    $('#alerte-' + containers[i].id).text(containers[i].status);
                    $('#servicesUpdate-' + containers[i].id).text(txtSonde);
                } else {
                    let Check = CheckService(containers[i].status);
                    if (!Check) {
                        sectionAlerte = "sonde-error";
                    }
                    // Création du block
                    $("#Block-Section-Data").append(
                        '<section id="' + containers[i].id + '" class="containers ' + sectionAlerte + '">' +
                        '<h2>' + containers[i].name + '</h2>' +
                        '<div class="agent-data">' +
                        '<p class="label">Nom du container:</p>' +
                        ' <p class="data-agent">' + containers[i].name + '</p>' +
                        '</div>' +
                        '<div class="agent-data">' +
                        '<p class="label">Statut:</p>' +
                        ' <p id="alerte-' + containers[i].id + '" class="data-agent alert">' + containers[i].status + '</p>' +
                        '</div>' +
                        '<div class="agent-data">' +
                        '<p class="label">Dernière mise à jour:</p>' +
                        '<p id="servicesUpdate-' + containers[i].id + '" class="data-agent alert">' + txtSonde + '</p>' +
                        '</div>' +
                        '</section>'
                    );
                }
            }
        },
        error: function (error) {
            console.error('Erreur lors du chargement du fichier JSON :', error);
        }
    });
}

function CheckService(status) {
    if (status == 'running') {
        return true;
    } else {
        return false
    }
}

function ServicesJellyFin() {
    $.ajax({
        url: url + "JellyFin-data.json",
        dataType: 'json',
        cache: false,
        success: function (response) {
            let data = response.result;
            var currentTime = Date.now(nDate);
            var sondeTime = new Date(response.result.date);
            var elapsedTimeInSeconds = (currentTime - sondeTime) / 1000;
            // Calcule en Heure lisible
            const jours = Math.floor(elapsedTimeInSeconds / (3600 * 24));
            const heures = Math.floor((elapsedTimeInSeconds % (3600 * 24)) / 3600);
            const minutes = Math.floor((elapsedTimeInSeconds % 3600) / 60);
            const secondes = Math.floor(elapsedTimeInSeconds % 60);

            if (elapsedTimeInSeconds > 900) { // 15 Minutes
                // Avertissement alerte sonde
                $('#JellyFin-sys').removeClass();
                $('#JellyFin-sys').addClass('sonde-error');

                // Message d'alerte de non contact de la sonde
                $('#JellyFin-sys-alerte').text(`La sonde ne réponds plus depuis: ${jours} Jour(s), ${heures} Heure(s), ${minutes} minute(s) et ${secondes} seconde(s)`);
            } else if (elapsedTimeInSeconds > 600) { // 10 Minutes 
                // Avertissement alerte sonde
                $('#JellyFin-sys').removeClass();
                $('#JellyFin-sys').addClass('sonde-warning');

                // Message d'alerte de non contact de la sonde
                $('#JellyFin-sys-alerte').text(`La sonde ne réponds plus depuis: ${jours} Jour(s), ${heures} Heure(s), ${minutes} minute(s) et ${secondes} seconde(s)`);
            } else {
                $('#JellyFin-sys').removeClass();
                $('#JellyFin-sys-alerte').text(`RAS`);
            }

            if (data.status == 1) {
                statsTxt = 'En fonctionnement';
            } else {
                statsTxt = 'Service stoppé'
            }

            $('#data-agent-JellyFin').text(statsTxt)
            $('#data-agent-servicesJellyFinUpdate').text(convertTimestampToDateTime(sondeTime))
        },
        error: function (error) {
            console.error('Erreur lors du chargement du fichier JSON :', error);

            $('#data-agent-JellyFin').text('Information indisponible');
            $('#data-agent-servicesJellyFinUpdate').text('Information indisponible');
            $('#JellyFin-sys-alerte').text(`Sonde indisponible`);
        }
    });
}

function ServicesBeamMP() {
    $.ajax({
        url: url + "BeamMP-data.json",
        dataType: 'json',
        cache: false,
        success: function (response) {
            let data = response.result;
            var currentTime = Date.now(nDate);
            var sondeTime = new Date(response.result.date);
            var elapsedTimeInSeconds = (currentTime - sondeTime) / 1000;
            // Calcule en Heure lisible
            const jours = Math.floor(elapsedTimeInSeconds / (3600 * 24));
            const heures = Math.floor((elapsedTimeInSeconds % (3600 * 24)) / 3600);
            const minutes = Math.floor((elapsedTimeInSeconds % 3600) / 60);
            const secondes = Math.floor(elapsedTimeInSeconds % 60);

            if (elapsedTimeInSeconds > 900) { // 15 Minutes
                // Avertissement alerte sonde
                $('#BeamMP-sys').removeClass();
                $('#BeamMP-sys').addClass('sonde-error');

                // Message d'alerte de non contact de la sonde
                $('#BeamMP-sys-alerte').text(`La sonde ne réponds plus depuis: ${jours} Jour(s), ${heures} Heure(s), ${minutes} minute(s) et ${secondes} seconde(s)`);
            } else if (elapsedTimeInSeconds > 600) { // 10 Minutes 
                // Avertissement alerte sonde
                $('#BeamMP-sys').removeClass();
                $('#BeamMP-sys').addClass('sonde-warning');

                // Message d'alerte de non contact de la sonde
                $('#BeamMP-sys-alerte').text(`La sonde ne réponds plus depuis: ${jours} Jour(s), ${heures} Heure(s), ${minutes} minute(s) et ${secondes} seconde(s)`);
            } else {
                $('#BeamMP-sys').removeClass();
                $('#BeamMP-sys-alerte').text(`RAS`);
            }

            if (data.status == 1) {
                statsTxt = 'En fonctionnement';
            } else {
                statsTxt = 'Service stoppé'
            }

            $('#data-agent-BeamMP').text(statsTxt)
            $('#data-agent-servicesBeamMPUpdate').text(convertTimestampToDateTime(sondeTime))

        },
        error: function (error) {
            console.error('Erreur lors du chargement du fichier JSON :', error);
            $('#data-agent-BeamMP').text('Information indisponible');
            $('#data-agent-servicesBeamMPUpdate').text('Information indisponible');
            $('#BeamMP-sys-alerte').text(`Sonde indisponible`);
        }
    });
}

function MaintenanceMode(id) {
    let etat = $('#' + id).data('maintenance');
    let uuid_agent = $('#agent-uuid').text();

    if (etat == 0) {
        showPopup("error", "L'agent n'est pas d'accord", "Veuillez initialiser l'agent avant de la passer en mode maintenance");
    } else if (etat == 1) {
        etat = 99;
        textBtn = "Mode maintenance activé";
        Class = "warning"
    } else {
        etat = 1;
        textBtn = "Mode maintenance désactivé";
        Class = ""
    }
    // Effectuer la requête AJAX
    $.ajax({
        type: 'POST',
        url: 'functions/update_statut_container',
        data: 'id=' + id + "&etat=" + etat + "&uuid_agent=" + uuid_agent,
        success: function (response) {
            $('#' + id).data('autostart', etat);
            $('#' + id).text(textBtn);
            if (Class == 'warning') {
                $('#' + id).addClass('warning');
            } else {
                $('#' + id).removeClass();
            }
        },
        error: function (error) {
            console.error('Erreur de connexion:', error);
            showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Reéssayer plus tard");
        }
    });
}

function AutoStart(id) {
    let etat = $('#' + id).data('autostart');
    let uuid_agent = $('#agent-uuid').text();

    if (etat == 0) {
        etat = 1;
        textBtn = "Désactivé AutoStart";
        Class = "Delete"
    } else {
        etat = 0;
        textBtn = "Activé AutoStart";
        Class = ""
    }
    // Effectuer la requête AJAX
    $.ajax({
        type: 'POST',
        url: 'functions/update_statut_container',
        data: 'id=' + id + "&etat=" + etat + "&uuid_agent=" + uuid_agent,
        success: function (response) {
            $('#' + id).data('autostart', etat);
            $('#' + id).text(textBtn);
            if (Class == 'Delete') {
                $('#' + id).addClass('delete');
            } else {
                $('#' + id).removeClass();
            }
        },
        error: function (error) {
            console.error('Erreur de connexion:', error);
            showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Reéssayer plus tard");
        }
    });
}

function AutoRestart(id) {
    let etat = $('#' + id).data('autorestart');
    let uuid_agent = $('#agent-uuid').text();

    if (etat == 0) {
        etat = 1;
        textBtn = "Désactivé AutoRestart";
        Class = "Delete"
    } else {
        etat = 0;
        textBtn = "Activé AutoRestart";
        Class = ""
    }
    // Effectuer la requête AJAX
    $.ajax({
        type: 'POST',
        url: 'functions/update_statut_container',
        data: 'id=' + id + "&etat=" + etat + "&uuid_agent=" + uuid_agent,
        success: function (response) {
            $('#' + id).data('autorestart', etat);
            $('#' + id).text(textBtn);
            if (Class == 'Delete') {
                $('#' + id).addClass('delete');
            } else {
                $('#' + id).removeClass();
            }
        },
        error: function (error) {
            console.error('Erreur de connexion:', error);
            showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Reéssayer plus tard");
        }
    });
}


// FISRT START
ContainerCheck();
ModelProcessor();
ServicesPlex();
ServicesJellyFin();
ServicesBeamMP();
Memory();
LoadDisk();

setTimeout(() => {
    CheckDisk();
}, 1000);

setInterval(() => {
    ModelProcessor();
    Memory();
}, 10000);

setInterval(() => {
    ServicesPlex();
    ServicesJellyFin();
    ServicesBeamMP();
    ContainerCheck();
}, 150000);

setInterval(() => {
    CheckDisk();
}, 3600000);