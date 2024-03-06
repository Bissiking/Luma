var uuid = $('#agent-uuid').text();
var url = "/data/" + uuid + "/";

const currentTime = new Date();


function ModelProcessor() {
    $.ajax({
        url: url + "processor-data.json",
        dataType: 'json',
        success: function (response) {
            let data = response.result.status.cpu;

            // Calcule du temps d'actualisation de la sonde

            var sondeTime = new Date(response.result.status.date);
            var elapsedTimeInSeconds = (currentTime - sondeTime) / 1000;

            if (elapsedTimeInSeconds > 180) {
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
            } else if (elapsedTimeInSeconds > 60) {
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
            $('#data-agent-processorUpdate').text(response.result.status.date);
        },
        error: function (error) {
            console.error('Erreur lors du chargement du fichier JSON :', error);
        }
    });
}

function Memory() {
    $.ajax({
        url: url + "memory-data.json",
        dataType: 'json',
        success: function (response) {
            let data = response.result.status.memory;

            var sondeTime = new Date(response.result.status.date);
            var elapsedTimeInSeconds = (currentTime - sondeTime) / 1000;

            if (elapsedTimeInSeconds > 180) {
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
            } else if (elapsedTimeInSeconds > 60) {
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


            $('#data-agent-Memfree').text(data.free)
            $('#data-agent-MemTotal').text(data.total)
            $('#data-agent-memoryUpdate').text(response.result.status.date)
        },
        error: function (error) {
            console.error('Erreur lors du chargement du fichier JSON :', error);
        }
    });
}

function ServicesPlex() {
    $.ajax({
        url: url + "plex-data.json",
        dataType: 'json',
        success: function (response) {
            let data = response.result;

            var sondeTime = new Date(response.result.date);
            var elapsedTimeInSeconds = (currentTime - sondeTime) / 1000;
            // Calcule en Heure lisible
            const jours = Math.floor(elapsedTimeInSeconds / (3600 * 24));
            const heures = Math.floor((elapsedTimeInSeconds % (3600 * 24)) / 3600);
            const minutes = Math.floor((elapsedTimeInSeconds % 3600) / 60);
            const secondes = Math.floor(elapsedTimeInSeconds % 60);

            if (elapsedTimeInSeconds > 180) {
                // Avertissement alerte sonde
                $('#plex-sys').removeClass();
                $('#plex-sys').addClass('sonde-error');

                // Message d'alerte de non contact de la sonde
                $('#plex-sys-alerte').text(`La sonde ne réponds plus depuis: ${jours} Jour(s), ${heures} Heure(s), ${minutes} minute(s) et ${secondes} seconde(s)`);
            } else if (elapsedTimeInSeconds > 60) {
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
            $('#data-agent-servicesUpdate').text(data.date)
        },
        error: function (error) {
            console.error('Erreur lors du chargement du fichier JSON :', error);
        }
    });
}

// function Disk() {
//     $.ajax({
//         url: url + "memory-data.json",
//         dataType: 'json',
//         success: function (response) {
//             let data = response.result.status.memory;
//             $('#data-agent-Memfree').text(data.free)
//             $('#data-agent-MemTotal').text(data.total)
//             $('#data-agent-memoryUpdate').text(response.result.status.date)
//         },
//         error: function (error) {
//             console.error('Erreur lors du chargement du fichier JSON :', error);
//         }
//     });
// }

function LoadDisk() {
    let NbDisk = 0;
    $.ajax({
        url: url + "disk-data.json",
        dataType: 'json',
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
        }
    });
}

function ReqDisk(i) {
    $.ajax({
        url: url + "disk-data.json",
        dataType: 'json',
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

// FISRT START
ModelProcessor();
ServicesPlex();
Memory();
LoadDisk();

setInterval(() => {
    CheckDisk();
}, 3000);

setInterval(() => {
    ModelProcessor();
    ServicesPlex();
    Memory();
    CheckDisk();
}, 10000);