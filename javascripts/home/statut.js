var url = "/data/1a0c7cba-cd1f-438e-8750-3d566cd81fdc/";

function StatsEdit(idDiv, StatsClass, StatsTxt) {
    if (idDiv == 1) {
        statsTxt = 'Service opérationnel';
        statsClass = "circle-online"
    } else {
        statsTxt = 'Service hors ligne';
        statsClass = "circle-offline"
    }

    $('#' + StatsClass).addClass(statsClass);
    $('#' + StatsTxt).text(statsTxt);
}

function ServicesPlex() {
    $.ajax({
        url: url + "plex-data.json",
        dataType: 'json',
        cache: false,
        success: function (response) {
            let data = response.result;
            StatsEdit(data.status, 'plex-indiq-stats', 'plex-txt-stats');

        },
        error: function (error) {
            StatsEdit(0, 'plex-indiq-stats', 'plex-txt-stats');
        }
    });
}

function api_nino_prod() {
    $.ajax({
        type: 'GET',
        url: 'https://nino.mhemery.fr/check/',
        success: function (response) {
            if (response.status == "ok") {
                StatsEdit(1, 'api-nino-indiq-stats', 'api-nino-txt-stats');
            } else {
                StatsEdit(0, 'api-nino-indiq-stats', 'plex-txt-stats');
            }
        },
        error: function (error) {
            StatsEdit(0, 'api-nino-indiq-stats', 'api-nino-txt-stats');
        }
    });
}


// Fisrt Start
ServicesPlex();
api_nino_prod();

setTimeout(() => {
    ServicesPlex();
    api_nino_prod();
}, 60000);