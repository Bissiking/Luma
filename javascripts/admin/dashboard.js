var ERRORJSON = 0,
  UPDATE_WEBSITE = 0;

$('#updateButton').on('click', function () {
  if (UPDATE_WEBSITE !== 1) {
    return;
  }
  // Retrait du bouton
  $('#updateButton').hide();
  // Effectuer une requête AJAX pour déclencher la mise à jour
  $.ajax({
    url: 'functions/admin/update_website', // Remplacez par le chemin vers votre script de mise à jour côté serveur
    timeout: 2000,
    type: 'POST',
    success: function (response) {
      if (response == "succes") {
        showPopup("good", "Mise à jour réussi", "Mise à jour de LUMA effectué avec succès. Veuillez patienter ....");
        setTimeout(() => {
          window.location.href = window.location.href;
        }, 4000);

      } else {
        console.error('Echec de la mise à jour:', response);
        showPopup("error", "Echec de la mise à jour", "La commande STASH n'a retourné aucune information. Vérifie les droits du dossier");

      }
    },
    error: function (xhr, status, error) {
      console.error(xhr.responseText + ' - ' + error);
      showPopup("error", "Echec de la mise à jour", "Une erreur inconnu est survenu -> ERROR:" + error);
    }
  });
});

function VerifUpdate() {
  var urlcourante = window.location.hostname;
  let repo = "main"
  if (urlcourante == 'dev.mhemery.fr') {
    repo = 'dev';
  } else if (urlcourante == 'pre-prod.mhemery.fr') {
    repo = 'pre-prod';
  }

  let urlGitHub = 'https://raw.githubusercontent.com/Bissiking/Luma/' + repo + '/version.json',
    LocalVersion = $('#Ver_Actuelle').text(),
    BtnUpdate = $('#updateButton'),
    TextUpdate = $('#updateText');
  $.ajax({
    url: urlGitHub,
    type: 'GET',
    dataType: 'json',
    cache: false, // Désactive le cache dans jQuery
    success: function (response) {
      if (response.version === LocalVersion) {
        TextUpdate.hide();
        BtnUpdate.text('Pas de mise à jour');
      } else {
        UPDATE_WEBSITE = 1;
        showPopup("warning", "Mise en jour en attente", "Une mise à jour de LUMA est en attente");
        TextUpdate.text('Nouvelle version: ' + response.version);
        BtnUpdate.text('Mettre à jour');
      }
    },
    error: function (xhr, status, error) {
      console.error(xhr.responseText);
    }
  });
}

setTimeout(() => {
  VerifUpdate();
}, 1000);



// https://github.com/Bissiking/Luma/blob/main/version.json