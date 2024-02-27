// Variables
var clickConfigStart = 0;
var EtapeConfig = 0;

// CHANGEMENT DE PAGE
$('.custom-button').click(function (e) {
    e.preventDefault();

    let step = $(this).data('step'),
        stepBlock = $('.step-content'),
        stepMenu = $('.step');

    if (step == "" || step == undefined || step == null) {
        return;
    }
    // Retrait des class "active"
    stepBlock.removeClass('active');
    stepMenu.removeClass('active');

    // Ajout de la class "active" au nouvelle div
    $('#menu-step' + step).addClass('active');
    $('#step' + step).addClass('active');
})

function LoadBar(etape, pixel) {
    console.log('click');
    var nouvelleOmbre = 'inset ' + pixel + 'px 0px 0px 0px rgba(202, 131, 0, 0.6)';
    // Appliquez la nouvelle valeur de la propriété box-shadow à l'élément
    $('#step3-etp' + etape).css('box-shadow', nouvelleOmbre);
}

function ChangeIcoText(etape, ico, text) {
    switch (ico) {
        case "spinner":
            ico = "fa-spinner"
            break;

        case "good":
            ico = "fa-circle-check"
            break;

        case "warning":
            ico = "fa-triangle-exclamation"
            break;

        case "error":
            ico = "fa-circle-exclamation"
            break;
        default:
            ico = "fa-solid fa-circle-question"
            break;
    }

    // Rtrait classe étape
    $('#step3-etp' + etape).children('i').removeClass();
    $('#step3-etp' + etape).children('i').addClass('fa-solid ' + ico);
    $('#step3-etp' + etape).children('span').text(text);
}

function StartConfig() {
    clickConfigStart = 1;
    EtapeConfig = EtapeConfig++;
    if (clickConfigStart == 0) {
        $('#start-check').text('Patientez');
        $('#start-check').addClass('disable');
    }
    CallConfig();
}

function ChangeConfig() {

    switch (key) {
        case 'check-bdd-connect':
            // Page 3, Etape 1, Première relance
            FunctResponse = CallConfig('3-1.1');

            // Fonction d'action 
            function name(params) {
                
            }

            // Réponse en json avec ok, warning, ou error.
            // ok = Passage à l'étape suivante
            // warning = Erreur non bloquante. Potentiellement un skip (Ex: BDD déjà créé)
            // error = Erreur bloquante, arrêt du script et des étape.
            break;
    
        default:
            break;
    }


    LoadBar('125', '')
    ChangeIcoText(etape, 'spinner', 'TEST');
}

function CallConfig() {
    $.ajax({
        url: './init/step3-1.1', // Remplacez par votre script côté serveur qui gère l'ajout
        type: 'POST',
    //     data: {
    //         nomComplet: nomComplet.val(),
    //         identifiant: identifiant.val(),
    //         email: email.val(),
    //         account_administrator: account_administrator.val()
    // },
        success: function (response) {
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}