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
      console.error('Erreur lors du chargement du fichier JSON :', error);
    }
  });
}

// Charger les informations initiales au chargement de la page
loadAndDisplayInfo();

// Charger et afficher les informations toutes les 10 secondes
setInterval(loadAndDisplayInfo, 10000);

