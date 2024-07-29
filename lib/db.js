const mongoose = require('mongoose');
const { getMongoConfig } = require('./config');

const connectDB = async () => {
    const mongoConfig = getMongoConfig();
    if (!mongoConfig) {
        console.log('Mode dégradé activé. Page de configuration nécessaire.');
        return;
    }

    try {
        await mongoose.connect(mongoConfig.mongoURI, {
            useNewUrlParser: true,
            useUnifiedTopology: true
        });
        console.log('MongoDB connecté');
    } catch (err) {
        console.error('Erreur de connexion à MongoDB:', err.message);
        process.exit(1);
    }
};

module.exports = { connectDB };
