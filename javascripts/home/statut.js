// var url = "/data/1a0c7cba-cd1f-438e-8750-3d566cd81fdc/";

function ServicesCheck() {
    let NbServiceSection = $('.serviceSection');

    console.log(NbServiceSection);
    console.log(NbServiceSection.length);

    for (let i = 0; i < NbServiceSection.length; i++) {
        let element = NbServiceSection[i];
        $(element).find('span.circle-stats').each(function () {
            console.log($(this).attr('class'));

            const id = $(this).data('id');
            var service = $(this).data('service');

            let searchTerm = service.toLowerCase();

            console.log(searchTerm);

            if (searchTerm.includes("plex")) {
                service = "plex";
            } else if (searchTerm.includes("jelly")) {
                service = "jellyfin";
            } else {
                console.log('DEBUG');
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

                    console.log(response);
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

setTimeout(() => {
    ServicesCheck();
}, 60000);