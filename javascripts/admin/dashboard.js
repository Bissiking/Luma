   // Fonction pour charger et afficher les informations du fichier JSON
   function loadAndDisplayInfo() {
    $.ajax({
      url: 'sondes/serverInfo.json', // Assurez-vous que le chemin est correct
      dataType: 'json',
      success: function(data) {

        let used_Mem = Math.round(100 * data.usedMemory / data.totalMemory);

        $('#CPU_moni').text(data.cpuUsage+'%');
        $('#RAM_moni').text(used_Mem+'%');
        // Mettez à jour les éléments HTML avec les nouvelles données
        // $('#serverInfo').html(`
        //   <p>Date et Heure : ${data.dateTime}</p>
        //   <p>CPU Usage : ${data.cpuUsage}</p>
        //   <p>Total Memory : ${data.totalMemory} bytes</p>
        //   <p>Free Memory : ${data.freeMemory} bytes</p>
        //   <p>Used Memory : ${data.usedMemory} bytes</p>
        // `);
      },
      error: function(error) {
        console.error('Erreur lors du chargement du fichier JSON :', error);
      }
    });
  }

  // Charger les informations initiales au chargement de la page
  loadAndDisplayInfo();

  // Charger et afficher les informations toutes les 10 secondes
  setInterval(loadAndDisplayInfo, 10000);