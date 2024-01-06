// function EditVideo(event) {


//     alert('CHECK');

// }


$('#uploadForm').submit(function(e) {
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
            // window.location.href = "/nino/add";
        },
        error: function (error) {
            console.error('Erreur de connexion:', error);
            showPopup("Une erreur inconnu est survenue. Reéssayer plus tard", false);
        }
    });
});

$('#uploadImageButton').click(function() {
    $('#videoImage').click();
});

// $('#videoImage').change(function() {
//     var fileInput = $(this)[0];
//     var file = fileInput.files[0];

//     if (file) {
//         var reader = new FileReader();

//         reader.onload = function(e) {
//             $('#imagePreview').html('<img src="' + e.target.result + '" alt="Preview">');
//         };

//         reader.readAsDataURL(file);
//     }
// });

// TEST UPLOAD IMAGE
$(document).ready(function() {
    $('#uploadButton').click(function(e) {
        e.preventDefault();
        var formData = new FormData($('#imageUploadForm')[0]);

        $.ajax({
            type: 'POST',
            url: '../functions/nino/upload.php', // Remplacez par le chemin de votre script serveur
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('Upload réussi :', response);
                $('#imagePreview').html('<img src="' + response + '" alt="Uploaded Image">');
            },
            error: function(error) {
                console.error('Erreur lors de l\'upload :', error);
            }
        });
    });
});