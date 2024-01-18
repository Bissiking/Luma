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
                            showPopup('Connexion à la BDD impossible. Merci de vérifier les informations renseignés', false);
                            $('button').text('Se Connecter');
                            break;

                            case "configCreate-echec":
                                showPopup('Echec de la création du fichier de configuration. Merci de vérifier si les droits d\'accès au dossier sont correctes', false);
                                $('button').text('Se Connecter');
                                break;

                                case "configExiste-echec":
                                    showPopup('Fichier de configuration non trouvé', false);
                                    $('button').text('Se Connecter');
                                    break;

                                    case "configCreateTable01-echec":
                                        showPopup('Création de la table "route" en echec.', false);
                                        $('button').text('Se Connecter');
                                        break;

                                        case "configCreateTable02-echec":
                                            showPopup('Création de la table "users" en echec.', false);
                                            $('button').text('Se Connecter');
                                            break;

                        case "succes":
                            showPopup('Configuration de base terminé, veuillez patientez pendant la finalisation. <br />Vous serez redirigé automatiquement.', true);
                            $('button').hide();
                            setTimeout(() => {
                                window.location.href = "/";
                            }, 2000);
                        break;

                        default:
                            showPopup('Une erreur est survenue, Merci de recommencer ultérieurement.', false);
                            $('button').hide();
                            break;
                    }
                    console.log(response);
                },
                error: function (error) {
                    console.log('Une erreur s\'est produite lors de la requête AJAX.');
                }
            });
        }, 1000);
    }else{
        showPopup('Des informations sont manquantes ou incorrectes', false);
        $('button').text('Se Connecter');
    }

}