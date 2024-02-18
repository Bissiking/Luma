var ERRORJSON = 0,
  UPDATE_WEBSITE = 0;

// Fonction pour charger et afficher les informations du fichier JSON
function loadAndDisplayInfo() {
  $.ajax({
    url: 'sondes/serverInfo.json', // Assurez-vous que le chemin est correct
    dataType: 'json',
    success: function (data) {
      let used_Mem = Math.round(100 * data.usedMemory / data.totalMemory);

      // Calcule du temps d'actualisation de la sonde
      const currentTime = new Date();
      const sondeTime = new Date(data.dateTime);
      const elapsedTimeInSeconds = (currentTime - sondeTime) / 1000;
      if (elapsedTimeInSeconds >= 60) {
        // Mettez à jour la couleur de fond de la sonde en rouge
        $('.monitoring').css('background-color', 'red');
        // Calcule en Heure lisible
        const jours = Math.floor(elapsedTimeInSeconds / (3600 * 24));
        const heures = Math.floor((elapsedTimeInSeconds % (3600 * 24)) / 3600);
        const minutes = Math.floor((elapsedTimeInSeconds % 3600) / 60);
        const secondes = Math.floor(elapsedTimeInSeconds % 60);
        $('#last_update_moni').html(`La sonde ne réponds plus depuis: <br />${jours} Jour(s), ${heures} Heure(s), ${minutes} minute(s) et ${secondes} seconde(s)`);
      } else {
        $('.monitoring').css('background-color', '#3498db');
        $('#CPU_moni').text(data.cpuUsage + '%');
        $('#RAM_moni').text(used_Mem + '%');

        // Formatage de la date et affichage
        const formattedDate = formatReadableDate(data.dateTime);
        $('#last_update_moni').text(formattedDate);

      }
    },
    error: function (error) {
      ERRORJSON = ERRORJSON + 1;
      if (ERRORJSON > 3) {
        $('.monitoring').css('background-color', 'red');
        $('#CPU_moni').text('NaN');
        $('#RAM_moni').text('NaN');
        $('#last_update_moni').text('Impossible de lire le fichier JSON de la sonde');
      } else {
        console.error('Erreur lors du chargement du fichier JSON :', error);
        showPopup("error", "Petit soucis imprévu ...", "Impossible de lire le fichier JSON de la sonde");
      }
    }
  });
}

// Charger les informations initiales au chargement de la page
loadAndDisplayInfo();

// Charger et afficher les informations toutes les 10 secondes
setInterval(loadAndDisplayInfo, 10000);

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
      console.log(response); // Afficher la réponse du serveur (message de réussite ou d'erreur)
      if (response == "succes") {
        showPopup("good", "Mise à jour réussi", "Mise à jour de LUMA effectué avec succès. Veuillez patienter ....");
        setTimeout(() => {
          window.location.href = window.location.href;
        }, 4000);

      } else {
        console.error('Echec de la mise à jour:', error);
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
  }else if (urlcourante == 'pre-prod.mhemery.fr') {
    repo = 'pre-prod';
  }

  let urlGitHub = 'https://raw.githubusercontent.com/Bissiking/Luma/'+repo+'/version.json',
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