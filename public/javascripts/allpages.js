$('.button-connexion-deconnexion').click(function(){
    let id = $(this).attr('id');
    if (id === 'login') {
        window.location.href = '/connexion';
    }else if (id === 'logout'){
        window.location.href = '/deconnexion';
    }else{
        console.log('ERROR -> ID:  '+id);
    }
});

function OpenMenuMobile(OpenMenuBtn, OpenMenu) {
    $('#'+OpenMenuBtn).data('open', 'open');
    $('#'+OpenMenu).css('display', 'flex');
    $('#'+OpenMenuBtn).addClass('ferme');
}

function CloseMenuMobile(OpenMenuBtn, OpenMenu) {
    $('#'+OpenMenuBtn).data('open', 'close');
    $('#'+OpenMenu).hide();
    $('#'+OpenMenuBtn).removeClass('ferme');
}

function BtnMenu(id) {
    let OpenMenu = $('#'+id).data('windows');
    // Détection du status du menu
    if ($('#'+id).data('open') === "open") {
        CloseMenuMobile(id,OpenMenu);
    } else {
        OpenMenuMobile(id,OpenMenu);
    }
}