// Récupérer les éléments des contrôles personnalisés
var volume = document.getElementById("volume-low");
var playPauseBtn = document.getElementById("playPauseBtn");
var back10SecBtn = document.getElementById("back10SecBtn");
var skip10SecBtn = document.getElementById("skip10SecBtn");
var fullscreenBtn = document.getElementById("fullscreenBtn");
var moviesScreen = document.getElementById("movies-screen");
var myVideo = document.getElementById("Player");
var progressBar = document.getElementById('progressBar');
var progressBarLoader = document.getElementById('progressBarLoader');
// JQUERY VAR
var ProgressBarJquery = $('#progressBar');
var BlockCustomControls = $('#customControls');
var VCP = $('.video-container-player');
var MS = $('#movies-screen');
var PBP = $('#playPauseBtn'); 
// AUTRES
var idleTimeout;

// Hidden si pas de mouvement de souris
function resetIdleTimeout() {
    clearTimeout(idleTimeout); // Effacer le délai d'inactivité existant
    idleTimeout = setTimeout(function() {
        // Aucun mouvement détecté, donc réduire l'opacité de la vidéo
        BlockCustomControls.css('opacity', 0);
    }, 5000); // Temps d'inactivité en millisecondes (ici 5 secondes)
}

// Écouter les événements de la souris et du clavier pour réinitialiser le délai d'inactivité
BlockCustomControls.on('mousemove keydown', function() {
    $(this).css('opacity', 1); // Rétablir l'opacité de la vidéo
    resetIdleTimeout(); // Réinitialiser le délai d'inactivité
});

// Appeler la fonction de réinitialisation du délai d'inactivité au chargement de la page
resetIdleTimeout();

// ProgressBar
myVideo.addEventListener('timeupdate', function () {
    var value = (myVideo.currentTime / myVideo.duration) * 100;
    var widthPB = value * ProgressBarJquery.width() / 100;
    $('#progressBar').css('box-shadow', 'inset ' + widthPB + 'px 0px 0px 0px #0088a7');
});

setInterval(() => { // Barre de progression auto regul
    // Calculer la proportion de la vidéo chargée
    var bufferedEnd = myVideo.buffered.end(0);
    var duration = myVideo.duration;
    if (duration > 0) {
        // Mettre à jour la valeur de la barre de progression
        var value = (bufferedEnd / duration) * 100;
        var widthPBL = value * ProgressBarJquery.width() / 100;
        $('#progressBarLoader').css('box-shadow', 'inset ' + widthPBL + 'px 0px 0px 0px rgb(255 255 255 / 50%)');
    }
}, 500);

// Bouton pause et play
$('#playPauseBtn').click(function () {
    if (myVideo.readyState >= 2) { // Vérifier si la vidéo est chargée et prête à être lue
        if (myVideo.paused) {
            myVideo.play().then(() => {
                $(this).removeClass('fa-play').addClass('fa-pause');
            }).catch((error) => {
                console.error("Erreur lors de la lecture de la vidéo:", error);
            });
        } else {
            myVideo.pause();
            $(this).removeClass('fa-pause').addClass('fa-play');
        }
    }
});

back10SecBtn.addEventListener("click", function () {
    myVideo.currentTime -= 10;
});

skip10SecBtn.addEventListener("click", function () {
    myVideo.currentTime += 10;
});

moviesScreen.addEventListener("click", function () {
    let width = $('body').width();
    if (VCP.hasClass('movies')) {
        VCP.removeClass('movies');
        MS.css('font-size', '20px');
        $('main').css('max-width', '1200px');
    } else {
        VCP.addClass('movies');
        MS.css('font-size', '10px');
        $('main').css('max-width', width);
    }
});

setInterval(() => {
    // Check statut pause pour update btn
    if (myVideo.paused) {
        // La vidéo est en pause
        PBP.addClass('fa-play').removeClass('fa-pause');
    } else {
        // La vidéo est en lecture
        PBP.removeClass('fa-play').addClass('fa-pause');
    }

    // Check status pour cinema mode
    if (VCP.hasClass('movies')) {
        let height = $('body').height();
        let width = $('body').width();

        VCP.css('width', width);
        VCP.css('height', height / 1.5);
        $('main').css('max-width', width);
    } else {
        VCP.attr('style', '');
    }
}, 500);

// Volume
volume.addEventListener("click", function () {
    showPopup('info', 'Encore de la patience', 'Fonctionalité non disponible')
});

// BETA TEST


// Fonction pour basculer en mode plein écran
function toggleFullScreen() {
    var elem = document.getElementById("Player");
    if (elem.requestFullscreen) {
        elem.requestFullscreen();
    }
}