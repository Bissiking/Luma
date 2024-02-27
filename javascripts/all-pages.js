// // Récupérer les éléments du DOM
// var profileIcon = document.getElementById('menu-luma');
// var profileMenu = document.getElementById('MenuLUMA');

// // Ajouter un écouteur d'événement pour le clic sur l'icône de profil
// profileIcon.addEventListener('click', function () {
//     // Basculer la visibilité du menu
//     profileMenu.style.display = (profileMenu.style.display === 'none' || profileMenu.style.display === '') ? 'block' : 'none';
// });

// document.addEventListener('click', function (event) {
//     if (event.target !== profileMenu && event.target !== profileIcon && !profileMenu.contains(event.target)) {
//         profileMenu.style.display = 'none';
//     }
// });

function formatReadableDate(dateString) {
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');
    const seconds = date.getSeconds().toString().padStart(2, '0');

    // Format final : "YYYY-MM-DD HH:mm:ss"
    const formattedDate = `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;

    return formattedDate;
}

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

// URL Dispatch
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

// BTN