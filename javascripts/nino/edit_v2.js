var isProcessing = false;
var isThumbnailUpload = false;
SearchImage('https://dev.nino.mhemery.fr/Thumbnail/1');

$('#uploadForm').submit(function (e) {
    e.preventDefault();
    var id = $('#btnEditVideo').data('idvideo');

    // UPLOAD FORM
    var formData = new FormData($('#uploadForm')[0]);
    formData.append('id', id);

    // Effectuer la requête AJAX
    $.ajax({
        type: 'POST',
        url: '../functions/nino/edit.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);
            if (response == "succes") {
                window.location.href = "/nino/add";
            } else {
                showPopup("error", "Nino pas content :(", "Il y'a des soucis avec un ou plusieurs champs, vérifie... Formulaire en BETA, donc des bogues peuvent survenir.");
            }
        },
        error: function (error) {
            console.error('Erreur de connexion:', error);
            showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Reéssayer plus tard");
        }
    });
});


function CheckVideoAPI() {
    let loadPops = $('.loadPopsIco');
    let loadPopsTxt = $('.loadText');
    let divApi = $('.checkApi');
    $.ajax({
        type: 'GET',
        url: 'https://' + divApi.attr('data-UrlAPI') + '/video/' + divApi.attr('data-idAPI'),
        success: function (response) {
            console.log(response);
            loadPops.removeClass('loader');
            if (response == "exist") {
                loadPops.html('<i class="fa-regular fa-circle-check good-txt"></i>');
                loadPopsTxt.text('Dossier trouvé, upload de la vidéo possible');
            } else if (response == "no-exist") {
                $('.checkApi').addClass('pointerClick');
                loadPopsTxt.text('Dossier non trouvé, vous pouvez cliquer sur la popup pour déclancher la création');
                loadPops.html('<i class="fa-solid fa-triangle-exclamation warning-txt"></i>');
            } else {
                loadPops.html('<i class="fa-solid fa-xmark error-txt"></i>');
                loadPopsTxt.text('Une erreur est survenu');
                showPopup("error", "l'API parle chelou", "L'API a renvoyé aucune valeur, ou une valeur incorrecte. Il se peut que votre site ne soit pas à jour");
            }
        },
        error: function (error) {
            loadPops.removeClass('loader');
            console.error('Erreur de connexion:', error);
            loadPopsTxt.text('Echec de la vérification');
            showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Reéssayer plus tard");
        }
    });
}

function SendDemCreation() {
    let divApi = $('.checkApi');
    if (divApi.hasClass('pointerClick')) {
        $.ajax({
            type: 'POST',
            url: 'https://' + divApi.attr('data-UrlAPI') + '/createVideo/' + divApi.attr('data-idAPI'),
            success: function (response) {
                console.log(response);
                if (response == "succes") {
                    location.reload();
                } else {
                    showPopup("error", "l'API a des petits raté parfois", "La création du dossier à échoué. Réactualise pour vérifier, sinon recommence dans 5 minutes");
                }
            },
            error: function (error) {
                console.error('Erreur de connexion:', error);
                showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Reéssayer plus tard");
            }
        });
    }
}

// NEW CODE

function ResizePopupNoVideo() {
    const videoPlayer = $('video');
    const width = videoPlayer.width();
    const height = videoPlayer.height();

    const divToResize = $('#no-video');

    divToResize.css({
        width: `${width}px`,
        height: `${height}px`,
    });
}

// Appel initial pour redimensionner la popup
ResizePopupNoVideo();

// Utilisation de l'événement "resize" de la fenêtre pour redimensionner la popup
$(window).on('resize', function () {
    ResizePopupNoVideo();
});


// REZISE DESCRIPTION
const textarea = $('#videoDescription');

// Attachez un gestionnaire d'événements 'input' pour détecter les changements de contenu
textarea.on('input', function () {
    // Ajustez la hauteur du textarea en fonction de son contenu
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
});

// AJOUT DE TAGS
const tagInput = $('#tagInput');
const tagContainer = $('#tag-container');

tagInput.on('keydown', function (event) {
    // Vérifier si la touche est "Entrée" ou "Espace" et si le champ n'est pas vide
    if ((event.key === 'Enter' || event.key === ' ') && tagInput.val().trim() !== '') {
        // Ajouter le tag à la liste
        addTag(tagInput.val().trim());

        // Ajout du tag en BDD
        doneTyping();

        // Effacer le champ de saisie
        tagInput.val('');

        // Empêcher le formulaire de se soumettre
        event.preventDefault();
    }
});

// UPLOAD DE L'IMAGE
$('#upload-image').click(function () {
    if (!isProcessing) {
        isProcessing = true;
        $('#imageInput').click();
    }
});

$('#imageInput').change(function () {
    isProcessing = true;
    const fileInput = this.files[0];
    if (fileInput) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $('#imagePreview').attr('src', e.target.result).show();
            uploadingThumbnail();
            isProcessing = false;
        };
        reader.readAsDataURL(fileInput);
    }
});

$('.upload-image-select').on('click', uploadingThumbnail);

function uploadingThumbnail() {
    let srcThumbnail = $(this).attr('src'),
        thisThumbnail = $(this);
    if (!isThumbnailUpload) {
        isThumbnailUpload = true;
        thisThumbnail.toggleClass('uploading-Thumbnail', true);
        UploadThumbnailAjax(thisThumbnail)
    }
}

function SearchImage(url) {
    $.ajax({
        url: url,  // Mettez le chemin correct vers votre script de téléchargement
        type: 'GET',
        data: { checkImage: true },
        success: function (response) {
            if (response.success === true) {
                $('#imagePreview').attr('src', url);
                $('#imagePreview').show();
            }
        },
        error: function (error) {
            console.error('Error search image:', error);
        }
    });
}

// URL A CHANGER
function UploadThumbnailAjax(thisThumbnail) {
    var fileInput = $('#imageInput')[0].files[0];
    if (fileInput) {
        var formData = new FormData();
        formData.append('image', fileInput);
        $.ajax({
            url: 'https://dev.nino.mhemery.fr/upload/1',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    thisThumbnail.addClass('valid-Thumbnail');
                    if (thisThumbnail.hasClass('uploading-Thumbnail')) {
                        thisThumbnail.removeClass('uploading-Thumbnail', true);
                    }
                    showPopup("good", "Oh mon image ...", "Upload de l'image réussi");
                    setTimeout(() => {
                        if (thisThumbnail.hasClass('valid-Thumbnail')) {
                            thisThumbnail.removeClass('valid-Thumbnail', true);
                        }
                        isThumbnailUpload = false;
                    }, 1000);
                }
                // $('#imagePreview').html('<img src="' + response.url + '" alt="Uploaded Image">');
            },
            error: function (error) {
                // Gérer les erreurs ici
                console.error('Error uploading image:', error);
                isThumbnailUpload = false;
            }
        });
    } else {
        console.error('No file selected.');
        thisThumbnail.removeClass('uploading-Thumbnail', true);
        isThumbnailUpload = false;
        showPopup("error", "Image ?? Tu ne pars pas ?", "Aucune image selectionné. Il se peut que l'image à déjà été uploadé");
    }
}

$('.tag').on('click', function () {
    var clickedTag = $(this).text();
    console.log(clickedTag);

    // Supprimer l'élément du DOM
    $(this).remove();
    doneTyping();
    // Vous pouvez maintenant utiliser la variable 'clickedTag' pour effectuer d'autres opérations si nécessaire
});

function addTag(tagText) {
    const tag = $('<div>').addClass('tag').text(tagText);
    // Supprimer le tag lorsque l'utilisateur clique dessus
    tag.on('click', function () {
        $(this).remove();
    });
    tagContainer.append(tag);
}


// ADD TO BDD
var typingTimer;
var doneTypingInterval = 1000; // 1 seconde de délai après la fin de la saisie

// Fonction pour détecter la fin de la saisie
$('#videoTitle, #videoDescription, #datetimepicker, #videoStatus').on('input, change', function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(doneTyping, doneTypingInterval);
});

function getTagsFromContainer() {
    const tags = [];
    $('#tag-container .tag').each(function () {
        tags.push($(this).text().trim());
    });
    return tags;
}

function doneTyping() {
    // Récupérer les valeurs des champs
    var id = getParameterByName('id'),
        titre = $('#videoTitle').val(),
        description = $('#videoDescription').val(),
        datetimepicker = $('#datetimepicker').val(),
        tags = getTagsFromContainer();
        videoStatus = $('#videoStatus').val();

    // Envoyer une requête AJAX pour mettre à jour en base de données
    $.ajax({
        type: 'POST',
        url: '../functions/nino/edit_v2.php?id=' + id, // Remplacez par l'URL de votre script serveur
        data: { 
            titre: titre, 
            description: description, 
            datetimepicker: datetimepicker,
            tags: tags,
            videoStatus: videoStatus
        },
        success: function (response) {
            console.log('Données mises à jour avec succès:', response);
            showPopup("good", "The save is saving ...", "Changements sauvegardés");

        },
        error: function (error) {
            console.error('Erreur lors de la mise à jour des données:', error);
            showPopup("error", "Echec de la sauvegarde", "Une erreur esu survenue pendant la sauvegarde, vérifie ta connexion .... on sait jamais ...");
        }
    });
}