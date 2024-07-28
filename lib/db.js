const mongoose = require('mongoose');
const fs = require('fs');
const path = require('path');

// Chemin du fichier de configuration
const configPath = path.join(__dirname, '../config/mongodb.json');

// Vérifier si le fichier de configuration existe
let mongoDB;
let configExists = false;

try {
    if (fs.existsSync(configPath)) {
        const configData = JSON.parse(fs.readFileSync(configPath, 'utf-8'));
        mongoDB = configData;
        configExists = true;
    } else {
        console.error('Fichier de configuration manquant. Passage en mode dégradé.');
    }
} catch (err) {
    console.error('Erreur lors de la lecture du fichier de configuration:', err.message);
}

// Fonction pour créer un timeout de 3 secondes
const timeout = (ms) => new Promise((resolve, reject) => {
    setTimeout(() => {
        reject(new Error('Timeout de la connexion MongoDB'));
    }, ms);
});

const connectDB = async () => {
    if (!configExists) {
        return "degrade-mode";
    }
    
    if (!mongoDB.mongoActive){
        return null
    }

    try {
        await Promise.race([
            mongoose.connect(mongoDB.mongoURI),
            timeout(3000)
        ]);
        console.log('MongoDB connecté');
    } catch (err) {
        console.error(err.message);
        return null;
    }
};

module.exports = { connectDB, configExists };
