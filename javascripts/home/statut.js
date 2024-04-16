function pingServer() {

    let api_nino_txt = $('#api-nino-prod-txt');
    let api_nino_cricle = $('#api-nino-prod-circle');


    api_nino_cricle.removeClass();
    api_nino_txt.text('Vérification du service');

    $.ajax({
        url: 'https://dev.nino.mhemery.fr/check',
        type: 'GET',
        timeout: 3000, // Définir un délai d'attente pour la réponse (en millisecondes)
        success: function (response) {
            console.log('Serveur accessible');
            console.log(response);
            // Faire quelque chose avec la réponse si nécessaire

            api_nino_cricle.addClass('circle-online');
            api_nino_txt.text('Service opérationnel');

        },
        error: function (xhr, status, error) {
            console.error('Erreur lors du ping du serveur : ' + error);
            // Gérer l'erreur ou afficher un message d'erreur

            api_nino_cricle.addClass('circle-offline');
            api_nino_txt.text('Service hors ligne');
        }
    });
}

function ServicesCheck() {
    let NbServiceSection = $('.serviceSection');

    for (let i = 0; i < NbServiceSection.length; i++) {
        let element = NbServiceSection[i];
        $(element).find('span.circle-stats').each(function () {

            const id = $(this).data('id');
            var service = $(this).data('service');

            let searchTerm = service.toLowerCase();

            if (searchTerm.includes("plex")) {
                service = "plex";
            } else if (searchTerm.includes("jelly")) {
                service = "jellyfin";
            } else {
                let statsTxt = 'Service hors ligne';
                let statsClass = "circle-offline";
                let $currentElement = $(this);
                $currentElement.addClass(statsClass);
                $currentElement.siblings('.txt-stats').text(statsTxt);
                return;
            }

            let $currentElement = $(this); // Stocker une référence à $(this)

            $.ajax({
                url: "/data/" + id + "/" + service + "-data.json",
                dataType: 'json',
                cache: false,
                context: $currentElement, // Définir le contexte pour utiliser $(this) dans success et error
                success: function (response) {
                    let data = response.result;
                    let Statut = data.status
                    if (Statut == 1) {
                        let statsTxt = 'Service opérationnel';
                        let statsClass = "circle-online";
                        let statsRemove = "circle-offline";
                        this.addClass(statsClass); // Utiliser this ici fait référence à $currentElement
                        this.removeClass(statsRemove);
                        this.siblings('.txt-stats').text(statsTxt);
                    } else {
                        let statsTxt = 'Service hors ligne :(';
                        let statsClass = "circle-offline";
                        let statsRemove = "circle-online";
                        this.addClass(statsClass);
                        this.removeClass(statsRemove);
                        this.siblings('.txt-stats').text(statsTxt);
                    }
                },
                error: function (error) {
                    console.log(error);
                    let statsTxt = 'Service hors ligne --';
                    let statsClass = "circle-offline";
                    this.addClass(statsClass);
                    this.siblings('.txt-stats').text(statsTxt);
                }
            });
        });
    }
}

// Fisrt Start
ServicesCheck();
pingServer();

setTimeout(() => {
    ServicesCheck();
    pingServer();
}, 60000);