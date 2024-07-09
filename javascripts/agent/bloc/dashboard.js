var rgb = null;

function GaugeRemplissage(Element, pourcent) {
    if (Element.length > 0) {
        const size = getElementSize(Element);

        // Retirer le % et convertir en nombre décimal
        let usageDecimal = parseFloat(pourcent);

        // Calculer la largeur utilisée en pixels
        let UsedPixel = size.width * usageDecimal / 100;

        if (usageDecimal >= 85) {
            rgb = '200, 30, 0' // Rouge
        } else if (usageDecimal >= 51) {
            rgb = '255, 200, 0' // Orange
        } else {
            rgb = '0, 181, 43' // Vert
        }
        Element.css('box-shadow', 'inset ' + UsedPixel + 'px 0px 0px 0px rgb(' + rgb + ')'); // Orange
        Element.css('box-shadow', 'inset ' + UsedPixel + 'px 0px 0px 0px rgb(' + rgb + ')'); // Vert
        Element.css('box-shadow', 'inset ' + UsedPixel + 'px 0px 0px 0px rgb(' + rgb + ')'); // Rouge

    } else {
        console.error('L\'élément span avec l\'id spécifié n\'existe pas');
    }
}

function formatBytes(bytes, decimals = 2) {
    if (bytes === 0) return '0 octets';
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['octets', 'Ko', 'Mo', 'Go', 'To'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

function calculateUsedMemory(jsonData) {
    const totalMemory = jsonData.status.memory.total;
    const freeMemory = jsonData.status.memory.free;
    return totalMemory - freeMemory;
}

function fetchData(url, onSuccess, onError) {
    $.ajax({
        url: url,
        dataType: 'json',
        cache: false,
        success: function (response) {
            let currentTime = Date.now();
            let sondeTime = new Date(response.result.date);
            let elapsedTimeInSeconds = (currentTime - sondeTime) / 1000;

            onSuccess(response, elapsedTimeInSeconds, sondeTime);
        },
        error: function (error) {
            console.error('Erreur lors du chargement du fichier JSON :', error);
            onError();
        }
    });
}

function getReadableTime(elapsedTimeInSeconds) {
    const jours = Math.floor(elapsedTimeInSeconds / (3600 * 24));
    const heures = Math.floor((elapsedTimeInSeconds % (3600 * 24)) / 3600);
    const minutes = Math.floor((elapsedTimeInSeconds % 3600) / 60);
    const secondes = Math.floor(elapsedTimeInSeconds % 60);

    return `${jours} Jour(s), ${heures} Heure(s), ${minutes} minute(s) et ${secondes} seconde(s)`;
}

function updateAlert(elapsedTimeInSeconds, selector) {
    let alertClass, alertMessage;
    if (elapsedTimeInSeconds > 900) {
        alertClass = 'sonde-error';
        alertMessage = `La sonde ne réponds plus depuis: ${getReadableTime(elapsedTimeInSeconds)}`;
    } else if (elapsedTimeInSeconds > 600) {
        alertClass = 'sonde-warning';
        alertMessage = `La sonde ne réponds plus depuis: ${getReadableTime(elapsedTimeInSeconds)}`;
    } else {
        alertClass = '';
        alertMessage = `RAS`;
    }
    $(selector).removeClass().addClass(alertClass);
    $(`${selector}-alerte`).text(alertMessage);
}

function ModelProcessor() {
    fetchData(url + "processor-data.json",
        function (response, elapsedTimeInSeconds, sondeTime) {
            let data = response.result.status.cpu;
            let DivGauge = $('#Used')
            updateAlert(elapsedTimeInSeconds, '#config-sys');

            $('#ModelProcessor').text(data.model);
            $('#architecture').text(data.architecture);
            $('#Cores').text(data.cores);
            DivGauge.text(Math.round(data.usage) + "%");

            // Remplissage de la gauge
            GaugeRemplissage(DivGauge, data.usage)

        },
        function () {
            $('#ModelProcessor').text('Information indisponible');
            $('#architecture').text('Information indisponible');
            $('#Cores').text('Information indisponible');
            DivGauge.text('Information indisponible');
        }
    );
}

function Memory() {
    fetchData(url + "memory-data.json",
        function (response, elapsedTimeInSeconds, sondeTime) {
            let data = response.result;
            let dataStatut = response.result.status.memory;
            let DivMemoryPourcent = $('#MemUsedPourcent')
            // Calcul de la mémoire utilisée
            const usedMemory = calculateUsedMemory(data);

            $('#Memfree').text(formatBytes(dataStatut.free));
            $('#MemUsed').text(formatBytes(usedMemory));
            $('#MemTotal').text(formatBytes(dataStatut.total));

            // Calcule du pourcentage utilisé
            let UsedMemeryPourcent = 100 * usedMemory / dataStatut.total
            DivMemoryPourcent.text(Math.round(UsedMemeryPourcent) + "%");

            // Remplissage de la gauge
            GaugeRemplissage(DivMemoryPourcent, UsedMemeryPourcent)
        },
        function () {
            $('#Memfree').text('Information indisponible');
            $('#MemTotal').text('Information indisponible');
            $('#memoryUpdate').text('Information indisponible');
        }
    );
}



function ServicesCheck(service) {
    fetchData(url + service+"-data.json",
        function (response, elapsedTimeInSeconds, sondeTime) {
            let data = response.result;

            // Reset Class
            $('#statut-'+service).removeClass();
            $('#statut-'+service).addClass('agent');

            let statsTxt = (data.status == 1) ? 'En fonctionnement' : 'Service stoppé';
            let classService = (data.status == 1) ? 'active' : 'offline';
            $('#statut-'+service).text(statsTxt);
            $('#statut-'+service).addClass(classService);
        },
        function () {
            $('#statut-'+service).text("Sonde non active");
        }
    );
}

// First Start
ModelProcessor();
Memory();

// Timer de 25 secondes
setInterval(() => {
    ModelProcessor();
    Memory();
}, 25000);

// Timer de 1 minutes
ServicesCheck('plex');
ServicesCheck('jellyfin');
ServicesCheck('BeamMP');
setInterval(() => {
    ServicesCheck('plex');
    ServicesCheck('jellyfin');
    ServicesCheck('BeamMP');
}, 60000);