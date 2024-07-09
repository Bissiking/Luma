// Configuration commune pour les boutons
const COMMON_CONFIG = {
    endpoint: 'functions/update_statut_container',
    initialText: "Désactivé",
    toggleText: "Activé",
    initialClass: "offline",
    toggleClass: "active"
};

const BUTTON_CONFIG = {
    "autostart": { ...COMMON_CONFIG },
    "autorestart": { ...COMMON_CONFIG }
};

// Fonction générique pour basculer l'état d'un bouton
function toggleButtonState(id, buttonType, uuid) {
    let button = $(`#${buttonType}-${id}`);
    let currentState = button.data('button');
    let config = BUTTON_CONFIG[buttonType];
    let newState, textBtn;

    if (currentState === config.initialClass) {
        newState = config.toggleClass;
        textBtn = config.toggleText;
    } else {
        newState = config.initialClass;
        textBtn = config.initialText;
    }

    // Convertir l'état en entier
    let etat = newState === config.toggleClass ? 1 : 0;

    // Construire l'ID du module en fonction du type de bouton
    let moduleSonde;
    if (id.includes('plex') || id.includes('jellyfin') || id.includes('beammp')) {
        moduleSonde = id + "ProcessCheck_" + buttonType;
    } else {
        moduleSonde = id + "Module_" + buttonType;
    }

    // Effectuer la requête AJAX
    $.ajax({
        type: 'POST',
        url: config.endpoint,
        data: {
            id: moduleSonde,
            etat: etat,
            uuid_agent: uuid
        },
        success: function (response) {
            button.removeClass(); // RESET Des classes
            button.addClass('agent edit-Config'); // Ajout de la classe de base

            button.data('button', newState);
            button.addClass(newState);
            button.text(textBtn);
        },
        error: function (error) {
            console.error('Erreur de connexion:', error);
            showPopup("error", "Petit souci imprévu ...", "Une erreur inconnue est survenue. Réessayez plus tard");
        }
    });
}

// Fonction pour activer/désactiver la sonde
function AutoStart(id) {
    toggleButtonState(id, 'autostart', uuid);
}

// Fonction pour activer/désactiver le redémarrage automatique
function AutoRestart(id) {
    toggleButtonState(id, 'autorestart', uuid);
}

// Gestionnaire d'événements pour les boutons
$('button').on('click', function (e) {
    if ($(this).hasClass('edit-Config')) {
        let id = $(this).attr('id').replace('autostart-', '').replace('autorestart-', '');
        if ($(this).attr('id').includes('autostart')) {
            AutoStart(id);
        } else if ($(this).attr('id').includes('autorestart')) {
            AutoRestart(id);
        }
    }
});
