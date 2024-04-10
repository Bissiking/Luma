// Récupérer les éléments des contrôles personnalisés
// var volume = document.getElementById("volume-low");
var playPauseBtn = document.getElementById("playPauseBtn");
var back10SecBtn = document.getElementById("back10SecBtn");
var skip10SecBtn = document.getElementById("skip10SecBtn");
var fullscreenBtn = document.getElementById("fullscreenBtn");
var myVideo = document.getElementById("Player");
var videoContainer = document.getElementById("videoContainer");
var progressBar = document.getElementById('progressBar');
var progressBarLoader = document.getElementById('progressBarLoader');
// JQUERY VAR
var ProgressBarJquery = $('#progressBar');
var BlockCustomControls = $('#customControls');
var VCP = $('.video-container-player');
var MS = $('#movies-screen');
var PBP = $('#playPauseBtn');
var volumeIcon = $('#volume-mute');
// AUTRES
var idleTimeout;

// Hidden si pas de mouvement de souris
function resetIdleTimeout() {
    clearTimeout(idleTimeout); // Effacer le délai d'inactivité existant
    idleTimeout = setTimeout(function () {
        // Aucun mouvement détecté, donc réduire l'opacité de la vidéo
        BlockCustomControls.css('opacity', 0);
    }, 5000); // Temps d'inactivité en millisecondes (ici 5 secondes)
}

// Écouter les événements de la souris et du clavier pour réinitialiser le délai d'inactivité
VCP.on('mousemove keydown', function () {
    BlockCustomControls.css('opacity', 1); // Rétablir l'opacité de la vidéo
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
$('.slider').on('input', function() {
    let volume = $(this).val();
    updateVolume(volume);
});

$('#volume-mute').click(function() {
    Player.muted = !Player.muted;

    // Mettez à jour le texte du bouton en fonction de l'état de la sourdine
    if (!Player.muted) {
        updateVolume(sessionStorage.getItem('PlayerVolume'));
    } else {
        volumeIcon.removeClass('fa-volume-low fa-volume-high fa-volume-off fa-volume-xmark');
        volumeIcon.addClass('fa-volume-xmark');
    }
});

function EditIcoVol(volume) {
    volumeIcon.removeClass('fa-volume-low fa-volume-high fa-volume-off fa-volume-xmark');

    if (Player.muted) {
        volume = 0;
    }

    if (volume === 0) {
        volumeIcon.addClass('fa-volume-xmark');
    }else if (volume < 33) {
        volumeIcon.addClass('fa-volume-off');
    }else if (volume < 77) {
        volumeIcon.addClass('fa-volume-low');
    }else{
        volumeIcon.addClass('fa-volume-high');
    }
}

function updateVolume(VolUP) {
    const volNew = VolUP/100;
    const volume = Math.min(Math.max(volNew, 0), 1);
    myVideo.volume = volume;
    // Stockez la valeur du volume dans sessionStorage
    sessionStorage.setItem('PlayerVolume', VolUP);
    // Modification du logo
    EditIcoVol(VolUP);
}

// Au chargement du Player
if(sessionStorage.getItem('PlayerVolume') !== undefined || sessionStorage.getItem('PlayerVolume') !== "" || sessionStorage.getItem('PlayerVolume') !== null){
    updateVolume(sessionStorage.getItem('PlayerVolume'));
    $('.slider').attr('value', sessionStorage.getItem('PlayerVolume'))
}else{
    updateVolume(50);
}

// BETA TEST
videoContainer.addEventListener("fullscreenchange", function () {
    if (document.fullscreenElement) {
        $('video').css('height', "100vh");
        $('video').removeClass('VideoHeightMax');
        BlockCustomControls.data('fullscreen', true)
    } else {
        $('video').css('height', "auto");
        $('video').addClass('VideoHeightMax');
        BlockCustomControls.data('fullscreen', false)
    }
});

// Fin de vidéo
Player.addEventListener("loadedmetadata", function() {
    const duration = Player.duration;
    const currentTime = new Date();
    const endTime = new Date(currentTime.getTime() + duration * 1000);

    $('#TimeEndVideo').text(formatTime(endTime));
});

setInterval(() => {
    const currentTime = Player.currentTime;
    const duration = Player.duration;

    const remainingTime = duration - currentTime;
    const endTime = new Date(Date.now() + remainingTime * 1000);

    $('#TimeEndVideo').text(formatTime(endTime));
}, 1000);

function formatTime(date) {
    const hours = pad(date.getHours());
    const minutes = pad(date.getMinutes());
    const seconds = pad(date.getSeconds());
    return hours + ":" + minutes;
}

function pad(number) {
    if (number < 10) {
        return "0" + number;
    }
    return number;
}