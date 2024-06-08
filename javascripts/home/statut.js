function pingServer() {

    let api_nino_txt = $('#api-nino-prod-txt');
    let api_nino_cricle = $('#api-nino-prod-circle');


    api_nino_cricle.removeClass();
    api_nino_txt.text('Vérification du service');

    $.ajax({
        url: 'https://api.nino.mhemery.fr/check',
        type: 'GET',
        timeout: 3000, // Définir un délai d'attente pour la réponse (en millisecondes)
        success: function (response) {
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
            let $currentElement = $(this);
            let DockerUUID = $(this).data('uuiddocker');

            if (DockerUUID == "" || DockerUUID == null || DockerUUID == undefined) {

                var service = $(this).data('service');

                let searchTerm = service.toLowerCase();
    
                if (searchTerm.includes("plex")) {
                    service = "plex";
                } else if (searchTerm.includes("jelly")) {
                    service = "jellyfin";
                } else if (searchTerm.includes("beammp")) {
                    service = "beammp";
                } else {
                    let statsTxt = 'Service hors ligne';
                    let statsClass = "circle-offline";
                    $currentElement.addClass(statsClass);
                    $currentElement.siblings('.txt-stats').text(statsTxt);
                    return;
                }

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

                return;
            } else {
                DockerSonde(id, $currentElement, DockerUUID);
            }
            
        });
    }
}

function DockerSonde(id, currentElement, DockerUUID) {

    $.ajax({
        url: "/data/" + id + "/docker-data.json",
        dataType: 'json',
        cache: false,
        context: currentElement, // Définir le contexte pour utiliser $(this) dans success et error
        success: function (response) {
            // Supposons que les données se trouvent dans response.result.containers
            let data = response.result.containers;
            // Convertir en objet JSON si c'est une chaîne
            if (typeof data === "string") {
                data = JSON.parse(data);
            }

            let found = data.find(data => data.id === DockerUUID);

            if (found) {
                if(found.status == 'running'){
                    Statut = 1;
                }else{
                    Statut = 0;
                }
            } else {
                Statut = 0;
            }

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
}



// Fisrt Start
ServicesCheck();
pingServer();

setTimeout(() => {
    ServicesCheck();
    pingServer();
}, 60000);