function makeid(length) { // Générateur aléatoire
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

function showPopup(type, titre, description) {
    CreateDivPopup();
    var id = makeid(20);
        div = '<div id="'+id+'" class="popup-flash '+type+'">'+
                '<h3>'+titre+'</h3>'+
                '<p>'+description+'</p>'+
                '<div class="timer-bar"></div>'+
            '</div>';
    if (id == "stop") {
        div = '<div id="StatusStop" class="popup-flash error">'+
                '<h3>POPUP ERROR</h3>'+
                '<p>Une erreur est survenue en affichant les POPUPs</p>'+
                '<div class="timer-bar"></div>'+
            '</div>';
            $(div).appendTo('#popup-container');
            return; 
    }
    $(div).appendTo('#popup-container');

    let timerbar = $('#'+id).children('.timer-bar');
    $(timerbar).animate({
        width: "0%"
    }, 4000, function() {
        $('#'+id).remove();
        setTimeout(() => {
            DeleteDivPopup();
        }, 100);
    });
}


function CreateDivPopup() {
    let PopUpContainer = $('#popup-container');
    if (PopUpContainer.length == 0) {
        div = '<div id="popup-container"></div>';
        $(div).appendTo('body'); 
    }
}

function DeleteDivPopup() {
    if ($('.popup-flash').length == 0) {
          $('#popup-container').remove();   
    }
}