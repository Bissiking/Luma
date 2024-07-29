$(document).ready(function() {
    var videoContainer = $("#videoContainer");

    $(document).on('fullscreenchange', function() {
        if (document.fullscreenElement) {
            // Passer en mode paysage
            enterLandscapeMode();
        } else {
            // Retourner en mode portrait
            exitLandscapeMode();
        }
    });

    function enterLandscapeMode() {
        if (window.screen.orientation) {
            if (window.screen.orientation.lock) {
                window.screen.orientation.lock('landscape').then(function() {
                    console.log('Passé en mode paysage');
                }).catch(function(error) {
                    console.error('Erreur lors du passage en mode paysage:', error);
                });
            } else {
                console.warn('La fonction lock() n\'est pas prise en charge.');
            }
        } else {
            console.warn('API Screen Orientation non prise en charge.');
        }
    }

    function exitLandscapeMode() {
        if (window.screen.orientation) {
            if (window.screen.orientation.unlock) {
                window.screen.orientation.unlock().then(function() {
                    console.log('Retour en mode portrait');
                }).catch(function(error) {
                    console.error('Erreur lors du retour en mode portrait:', error);
                });
            } else {
                console.warn('La fonction unlock() n\'est pas prise en charge.');
            }
        } else {
            console.warn('API Screen Orientation non prise en charge.');
        }
    }
});
