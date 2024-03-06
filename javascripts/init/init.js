// Variables
var clickConfigStart = 0,
    EtapeConfig = 0,
    progressBar = 252,
    color = '',
    DB_HOST = '',
    DB_PORT = '',
    DB_NAME = '',
    DB_USER = '',
    DB_PASSWORD = '',
    USER_ADMIN = '',
    USER_ADMIN_MDP = '';

function ResetVar() {
    clickConfigStart = 0,
        EtapeConfig = 0,
        progressBar = 252,
        color = '',
        DB_HOST = '',
        DB_PORT = '',
        DB_NAME = '',
        DB_USER = '',
        DB_PASSWORD = '',
        USER_ADMIN = '',
        USER_ADMIN_MDP = '';
}

// CHANGEMENT DE PAGE
$('.custom-button').click(function (e) {
    e.preventDefault();

    let step = $(this).data('step'),
        stepBlock = $('.step-content'),
        stepMenu = $('.step');

    if (step == "" || step == undefined || step == null || $(this).hasClass('disable')) {
        return;
    }

    // Retrait des class "active"
    stepBlock.removeClass('active');
    stepMenu.removeClass('active');

    // Ajout de la class "active" au nouvelle div
    $('#menu-step' + step).addClass('active');
    $('#step' + step).addClass('active');
})

// Bar de chargement
function LoadBar(etape, pixel, resultat) {
    if (resultat == "succes") {
        color = "rgb(32, 160, 0)";
    } else if (resultat == "error") {
        color = "rgb(255, 0, 0)";
    } else {
        color = "rgba(202, 131, 0, 0.6)";
    }

    var nouvelleOmbre = 'inset ' + pixel + 'px 0px 0px 0px ' + color;
    // Appliquez la nouvelle valeur de la propriété box-shadow à l'élément
    $('#step3-etp' + etape).css('box-shadow', nouvelleOmbre);
}

function ChangeIcoText(etape, ico, text) {
    switch (ico) {
        case "load":
            ico = "fa-spinner"
            break;

        case "succes":
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

function StartConfig(step, textStats) {
    if (clickConfigStart == 0) {
        EtapeConfig++;
        // Blocage du clique
        clickConfigStart = 1;
        // Définission des variables définitives
        DB_HOST = $('#DB_HOST').val(),
            DB_PORT = $('#DB_PORT').val(),
            DB_NAME = $('#DB_NAME').val(),
            DB_USER = $('#DB_USER').val(),
            DB_PASSWORD = $('#DB_PASSWORD').val(),
            USER_ADMIN = $('#USER_ADMIN').val(),
            USER_ADMIN_MDP = $('#USER_ADMIN_MDP').val();

        // Modification du bouton
        $('#start-check').text('Patientez');
        $('#start-check').addClass('disable');

        // Définission de la nouvelle étape
        if (!step) {
            step = "step3-1.1";
            textStats = "Tentative de connexion";
        }

        // Utilisation de la progressBar
        LoadBar(EtapeConfig, progressBar / 2);
        ChangeIcoText(EtapeConfig, 'load', textStats);

        // Lancement de la fonction
        setTimeout(() => {
            CallConfig(EtapeConfig, step);
        }, 2000);

    }
}

function CallConfig(EtapeConfig, step) {
    // Préparation de la requête Ajax
    $.ajax({
        url: './init/' + step, // Remplacer "step3..." par la variable "step"
        type: 'POST',
        data: {
            DB_HOST: DB_HOST,
            DB_PORT: DB_PORT,
            DB_NAME: DB_NAME,
            DB_USER: DB_USER,
            DB_PASSWORD: encodeURIComponent(DB_PASSWORD),
            USER_ADMIN: USER_ADMIN,
            USER_ADMIN_MDP: encodeURIComponent(USER_ADMIN_MDP)
        },
        success: function (response) {
            // PARSE De la réponse
            response = JSON.parse(response);
            console.log(response);

            if (response.nextStep === "STOP") {
                // Progression FULL
                LoadBar(EtapeConfig, '252', response.resultat);
                // Changement du logo et texte
                ChangeIcoText(EtapeConfig, response.resultat, response.message);

                $('#start-check').text('Patientez ....');

                // Changement de la page ....
                setTimeout(() => {
                    let stepBlock = $('.step-content'),
                        stepMenu = $('.step');

                    // Retrait des class "active"
                    stepBlock.removeClass('active');
                    stepMenu.removeClass('active');

                    // Ajout de la class "active" au nouvelle div
                    $('#menu-step4').addClass('active');
                    $('#step4').addClass('active');
                }, 1000);

                // Changement de la page ....
                setTimeout(() => {
                    window.location.href = window.location.href;
                }, 3000);
                // Déblocage du bouton
                clickConfigStart = 0;
                return
            }

            if (response.resultat == "succes" || response.resultat == "warning") {
                // Progression FULL
                LoadBar(EtapeConfig, '252', response.resultat);
                // Changement du logo et texte
                ChangeIcoText(EtapeConfig, response.resultat, response.message);
                // Changement d'étape
                EtapeConfig++;
                clickConfigStart = 0;
                setTimeout(() => {
                    StartConfig(response.nextStep, response.textStats);
                }, 2000);

            } else if (response.resultat == "error") {
                // Progression FULL
                LoadBar(EtapeConfig, '252', response.resultat);
                // Changement du logo et texte
                ChangeIcoText(EtapeConfig, response.resultat, response.message);
                // Rétablissement du bouton
                $('#start-check').text('Lancement');
                $('#start-check').removeClass('disable');
                $('.cancel').removeClass('disable');

                // Reset STEP
                ResetVar();
                // Déblocage du bouton
                clickConfigStart = 0;
                return;
            }
        },
        error: function (xhr, status, error) {
            // console.error(xhr.responseText);

            // Rétablissement du bouton
            $('#start-check').text('Lancement');
            $('#start-check').removeClass('disable');
            $('.cancel').removeClass('disable');

            // Déblocage du bouton
            clickConfigStart = 0;

            // Blocage de la barre
            LoadBar(EtapeConfig, '252', 'error');
            // Changement du logo et texte
            ChangeIcoText(EtapeConfig, 'error', 'Erreur interne #1000');

            // Reset STEP
            ResetVar();
        }
    });
}