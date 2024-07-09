// Variables
var uuid = $('#agent-name').data('uuid');
var url = "/data/" + uuid + "/";
const nDate = new Date().toLocaleString('fr-FR', {
    timeZone: 'Europe/Paris'
});

// Function
function getElementSize($element) {
    if ($element.length === 0) {
        console.error('L\'élément n\'existe pas');
        return null;
    }

    // Utilise jQuery pour obtenir la taille de l'élément
    const width = $element.outerWidth();
    const height = $element.outerHeight();

    return {
        width: width,
        height: height
    };
}

function convertTimestampToDateTime(timestamp) {
    // Crée un nouvel objet Date en utilisant le timestamp
    var date = new Date(timestamp);

    // Obtenir les différentes parties de la date
    var year = date.getFullYear();
    var month = ("0" + (date.getMonth() + 1)).slice(-2); // Les mois sont de 0 à 11
    var day = ("0" + date.getDate()).slice(-2);
    var hours = ("0" + date.getHours()).slice(-2);
    var minutes = ("0" + date.getMinutes()).slice(-2);
    var seconds = ("0" + date.getSeconds()).slice(-2);

    // Format de la date et heure en UTC
    var formattedDate = `${day}/${month}/${year} - ${hours}:${minutes}:${seconds}`;

    return formattedDate;
}

function HiddenAllContent() {
    $('.bloc-agent').addClass('hidden');
}

function ShowContent(id) {
    $('#content-'+id).removeClass('hidden');
}

function RemoveSelectMenu() {
    let nav = $('#nav-dashboard').children('ul').children('li')
    nav.removeClass('select');
}

function AddSelectMenu(id) {
    $('li#'+id).addClass('select');
}

// Au clique
$('li').click(function(e) {
    // Récupération de l'ID
    let id = $(this).attr('id');

    // Retrait de tous les blocs visibles et suppression du surlignement menu
    HiddenAllContent();
    RemoveSelectMenu();

    // Affichage du menu sélectionné et surlignement du menu
    ShowContent(id);
    AddSelectMenu(id);
});