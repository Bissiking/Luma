const fs = require('fs');
const path = require('path');

const readConfig = (configPath) => {
  try {
    if (fs.existsSync(configPath)) {
      return JSON.parse(fs.readFileSync(configPath, 'utf-8'));
    }
    return null;
  } catch (err) {
    console.error(`Erreur lors de la lecture du fichier ${configPath}:`, err.message);
    return null;
  }
};

const getMongoConfig = () => {
  const configPath = path.join(__dirname, '../config/mongodb.json');
  console.log(configPath);
  return readConfig(configPath);
};

const getLumaConfig = () => {
  const configPath = path.join(__dirname, '../config/luma.json');
  return readConfig(configPath);
};

module.exports = { getMongoConfig, getLumaConfig };
