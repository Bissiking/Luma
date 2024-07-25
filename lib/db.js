const mongoose = require('mongoose');
const fs = require('fs');
const path = require('path');

// Chemin du fichier de configuration
const configPath = path.join(__dirname, '../config/mongodb.json');

// Vérifier si le fichier de configuration existe
let mongoURI;
let configExists = false;

try {
    if (fs.existsSync(configPath)) {
        const configData = JSON.parse(fs.readFileSync(configPath, 'utf-8'));
        mongoURI = configData.mongoURI;
        configExists = true;
    } else {
        console.error('Fichier de configuration manquant. Passage en mode dégradé.');
    }
} catch (err) {
    console.error('Erreur lors de la lecture du fichier de configuration:', err.message);
}

const connectDB = async () => {
    if (!configExists) {
        return "degrade-mode";
    }

    try {
        await mongoose.connect(mongoURI);
        console.log('MongoDB connecté');
    } catch (err) {
        console.error(err.message);
        process.exit(1);
    }
};

module.exports = { connectDB, configExists };
