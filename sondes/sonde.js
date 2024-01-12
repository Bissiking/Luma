const fs = require('fs');
const os = require('os');
const osu = require('node-os-utils');

function addOneHourInWinter(dateString) {
    const date = new Date(dateString);

    // Ajouter une heure si l'heure d'été n'est pas en vigueur
    if (!isDaylightSavingTime(date)) {
        date.setHours(date.getHours() + 1);
    }

    return date;
}

// Fonction pour vérifier si l'heure d'été est en vigueur
function isDaylightSavingTime(date) {
    const january = new Date(date.getFullYear(), 0, 1);
    const july = new Date(date.getFullYear(), 6, 1);

    // Si la différence de temps entre janvier et juillet est égale à 1 heure,
    // alors l'heure d'été est en vigueur
    return january.getTimezoneOffset() !== july.getTimezoneOffset();
}

// Fonction pour obtenir la date et l'heure actuelles
function getCurrentDateTime() {
    const currentDate = new Date();
    // Exemple d'utilisation
    const newDate = addOneHourInWinter(currentDate);
    return newDate.toISOString(); // Format ISO pour une représentation facilement lisible
}

// Stocke les données dans un objet
let serverInfo = {
    dateTime: getCurrentDateTime(),
    cpuUsage: 0,
    totalMemory: os.totalmem(),
    freeMemory: os.freemem(),
    usedMemory: 0,
};

// Met à jour les données toutes les secondes
setInterval(() => {
    // Met à jour les informations sur l'utilisation du CPU
    var cpu = osu.cpu
    cpu.usage()
        .then(data => {
            serverInfo.cpuUsage = data;
        })
        .catch(error => {
            console.error('critical', 'CPU', 'La sonde CPU n\'a pas réussi à récupérer les informations. ERR: ' + error)
        })

    // Met à jour les informations sur l'utilisation de la mémoire
    serverInfo.usedMemory = serverInfo.totalMemory - os.freemem();

    // Met à jour la date et l'heure actuelles
    serverInfo.dateTime = getCurrentDateTime();

    // Enregistre les données dans un fichier JSON
    saveServerInfo();
}, 5000);


// Enregistre les données dans un fichier JSON
function saveServerInfo() {
    fs.writeFile('serverInfo.json', JSON.stringify(serverInfo), (err) => {
        if (err) {
            console.error('Erreur lors de l\'enregistrement des données :', err);
        }
    });
}
