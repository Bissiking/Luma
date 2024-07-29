const fs = require('fs');
const path = require('path');

const configPath = path.join(__dirname, '../config/mongodb.json');
const lumaConfigPath = path.join(__dirname, '../config/luma.json');

const getMongoConfig = () => {
    try {
        if (fs.existsSync(configPath)) {
            return JSON.parse(fs.readFileSync(configPath, 'utf-8'));
        }
    } catch (err) {
        console.error('Erreur lors de la lecture du fichier de configuration MongoDB:', err.message);
    }
    return null;
};

const getLumaConfig = () => {
    try {
        if (fs.existsSync(lumaConfigPath)) {
            return JSON.parse(fs.readFileSync(lumaConfigPath, 'utf-8'));
        }
    } catch (err) {
        console.error('Erreur lors de la lecture du fichier de configuration Luma:', err.message);
    }
    return null;
};

module.exports = { getMongoConfig, getLumaConfig };
