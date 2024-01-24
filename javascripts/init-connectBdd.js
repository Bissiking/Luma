// showPopup('Opération réussie!', true);

function PopupInput(NameInput, ActionStats) {
    if (ActionStats == true) {
        $('span#SPAN-'+NameInput).show();
        $('input#'+NameInput).addClass('input-error');
    }else{
        $('span#SPAN-'+NameInput).hide();
        $('input#'+NameInput).removeClass('input-error'); 
    }

}

function testConnection(event) {
    // Variables de checkup d'erreur
    var PassForms = true;
    // Désactiver l'action de redirection par défaut
    event.preventDefault();
    $('button').text('Connexion en cours');

    // Création des variables essentielles
    let DB_HOST = $('#DB_HOST').val(),
        DB_PORT = $('#DB_PORT').val(),
        DB_NAME = $('#DB_NAME').val(),
        DB_USER = $('#DB_USER').val(),
        DB_PASSWORD = $('#DB_PASSWORD').val(),
        USER_ADMIN = $('#USER_ADMIN').val(),
        USER_ADMIN_MDP = $('#USER_ADMIN_MDP').val();  

    // Vérification de certains champs

    if(USER_ADMIN == "" || USER_ADMIN == undefined || USER_ADMIN == null){
        PassForms = false;
        PopupInput('USER_ADMIN', true);
    }else{
        PopupInput('USER_ADMIN', false);
    }

    if(USER_ADMIN_MDP == "" || USER_ADMIN_MDP == undefined || USER_ADMIN_MDP == null){
        PassForms = false;
        PopupInput('USER_ADMIN_MDP', true);
    }else{
        PopupInput('USER_ADMIN_MDP', false);
    }

    if(DB_NAME == "" || DB_NAME == undefined || DB_NAME == null){
        PassForms = false;
        PopupInput('DB_NAME', true);
    }else{
        PopupInput('DB_NAME', false);
    }

    if(DB_USER == "" || DB_USER == undefined || DB_USER == null){
        PassForms = false;
        PopupInput('DB_USER', true);
    }else{
        PopupInput('DB_USER', false);
    }

    if (PassForms == true) {
        setTimeout(() => {
            data = 'DB_HOST='+DB_HOST+
                    '&DB_PORT='+DB_PORT+
                    '&DB_NAME='+DB_NAME+
                    '&DB_USER='+DB_USER+
                    '&DB_PASSWORD='+encodeURIComponent(DB_PASSWORD)+
                    '&SYS_NAME='+SYS_NAME+
                    '&USER_ADMIN='+USER_ADMIN+
                    '&USER_ADMIN_MDP='+encodeURIComponent(USER_ADMIN_MDP);
    
            $.ajax({
                url: 'functions/InitConfigEdit.php',
                type: 'POST',
                data: data,
                success: function (response) {
                    switch (response) {
                        case "bdd-echec":
                            showPopup("error", "Base de donnée ! Tu es ou ?", "Connexion à la BDD impossible. Merci de vérifier les informations renseignés");
                            $('button').text('Se Connecter');
                            break;

                            case "configCreate-echec":
                                showPopup("error", "Merde !! J'ai pas les droits !", "Echec de la création du fichier de configuration. Merci de vérifier si les droits d\'accès au dossier sont correctes");
                                $('button').text('Se Connecter');
                                break;

                                case "configExiste-echec":
                                    showPopup("error", "Merde !! J'ai perdu un truc", "Le fichier de configuration n'existe pas, propablement une erreur de droit qui empêche la créaction");
                                    $('button').text('Se Connecter');
                                    break;

                                    case "configCreateTable01-echec":
                                        showPopup("error", "Non ! Pas les routes !", "Création de la table 'routes' en echec.");
                                        $('button').text('Se Connecter');
                                        break;

                                        case "configCreateTable02-echec":
                                            showPopup("error", "Non ! Pas les users !", "Création de la table 'users' en echec.");
                                            $('button').text('Se Connecter');
                                            break;

                        case "succes":
                            showPopup("good", "Encore un peu d'attente", "Configuration de base terminé, veuillez patientez pendant la finalisation. <br />Vous serez redirigé automatiquement.");
                            $('button').hide();
                            setTimeout(() => {
                                window.location.href = "/";
                            }, 2000);
                        break;

                        default:
                            showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Reéssayer plus tard");
                            $('button').hide();
                            break;
                    }
                    console.log(response);
                },
                error: function (error) {
                    console.log('Une erreur s\'est produite lors de la requête AJAX.');
                    showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Reéssayer plus tard");
                }
            });
        }, 1000);
    }else{
        showPopup("error", "Petit soucis imprévu ...", "Des informations sont incorrectes ou manquantes");
        $('button').text('Se Connecter');
    }

}