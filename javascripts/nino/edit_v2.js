var isProcessing = false,
    isProcessing1 = false,
    isThumbnailUpload = false,
    idVid = getParameterByName('id'),
    APIURL = 'https://'+$('#apiuse').text();
SearchImage(APIURL+'/Thumbnail/' + idVid);


function CheckVideoAPI() {
    $.ajax({
        type: 'GET',
        url: APIURL+'/video/check/'+idVid,
        success: function (response) {
            console.log(response);
            if (response == "exist") {
                $('#no-video').hide();
                showPopup("error", "Ok ...", "Une vidéo à été trouvé. Focntionnalité supplémentaire indisponible pour l'instant");

                // Ajout de la vidéo dans le player
                let url = APIURL+'/'+idVid
                var id = new URL(url).pathname;
                const video = document.getElementById('Player');
                const videoSrc = url + '/nino.m3u8';
                if (Hls.isSupported()) {
                    const hls = new Hls();
                    hls.loadSource(videoSrc);
                    hls.attachMedia(video);
                    hls.on(Hls.Events.MANIFEST_PARSED, () => {});
                } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                    video.src = videoSrc;
                    video.addEventListener('loadedmetadata', () => {});
                }
            } else {
                showPopup("error", "l'API parle chelou", "Fichier non trouver, ou ton API pète un câble. Toi qui choisi ...");
            }
        },
        error: function (error) {
            showPopup("error", "Petit soucis imprévu ...", "Une erreur inconnu est survenue. Reéssayer plus tard");
        }
    });
}
CheckVideoAPI();
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
            url: APIURL+'/upload/' + idVid,
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
    var titre = $('#videoTitle').val(),
        description = $('#videoDescription').val(),
        datetimepicker = $('#datetimepicker').val(),
        tags = getTagsFromContainer();
    videoStatus = $('#videoStatus').val();

    // Envoyer une requête AJAX pour mettre à jour en base de données
    $.ajax({
        type: 'POST',
        url: '../functions/nino/edit_v2.php?id=' + idVid, // Remplacez par l'URL de votre script serveur
        data: {
            titre: titre,
            description: description,
            datetimepicker: datetimepicker,
            tags: tags,
            videoStatus: videoStatus
        },
        success: function (response) {
            response = JSON.parse(response);
            if (response.success == true) {
               showPopup("good", "The save is saving ...", "Changements sauvegardés"); 
            }else{
                showPopup("error", "Echec de la sauvegarde", "Une erreur est survenue pendant la sauvegarde, vérifie ta connexion .... on sait jamais ... #0001");
            }
        },
        error: function (error) {
            console.error('Erreur lors de la mise à jour des données:', error);
            showPopup("error", "Echec de la sauvegarde", "Une erreur est survenue pendant la sauvegarde, vérifie ta connexion .... on sait jamais ... #0002");
        }
    });
}

// UPLOAD VIDEO - SINGLE

$('#upload-video-btn-1').click(function () {
    if (!isProcessing1) {
        isProcessing1 = true;
        $('#videoUP01').click();
    }
});

$('#videoUP01').change(function () {
    isProcessing = true;
    const fileInput = this.files[0];
    if (fileInput) {
        const reader = new FileReader();
        reader.onload = function (e) {
            // $('#imagePreview').attr('src', e.target.result).show();
            uploadVideo();
            isProcessing = false;
        };
        reader.readAsDataURL(fileInput);
    }
});

function uploadVideo() {
    var fileInput = $('#videoUP01')[0].files[0];
    if (fileInput) {
        var formDataVideo = new FormData();
        formDataVideo.append('video', fileInput);
        console.log(fileInput);

        // const allowedExtensions = ['mp4', 'mkv'];
        // const fileExtension = fileInput.split('.').pop().toLowerCase();
        // if (!allowedExtensions.includes(fileExtension)) {
        //     alert('Seuls les fichiers MP4 et MKV sont autorisés.');
        //     return;
        // }

        // Modifie l'URL de la requête Axios
        const uploadUrl = APIURL+`/upload/video/${idVid}`;
        axios.post(uploadUrl, formDataVideo, {
            params: { encoded: false },
          })
            .then(response => {
                console.log(response.data);
                alert('Vidéo envoyée avec succès!');
            })
            .catch(error => {
                console.error('Erreur lors de l\'envoi de la vidéo:', error);
                alert('Une erreur est survenue lors de l\'envoi de la vidéo.');
            });
    } else {
        console.log('ERROR');
    }
}
