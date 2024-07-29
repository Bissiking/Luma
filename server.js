const express = require('express');
const path = require('path');
const session = require('express-session');
const MongoStore = require('connect-mongo');
const { connectDB } = require('./lib/db');
const { getMongoConfig, getLumaConfig } = require('./lib/config');
const setupRoutes = require('./app/routes');
const app = express();
const port = 80;

// Middleware pour analyser le corps des requêtes
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Configurer Pug comme moteur de template
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'pug');

// Servir les fichiers statiques
app.use(express.static('public'));

// Lire les configurations
const mongoConfig = getMongoConfig();
const lumaConfig = getLumaConfig() || { install: false };

// Connexion à MongoDB et initialisation des sessions
connectDB().then(() => {
    // Configurer les sessions seulement si la configuration existe
    if (mongoConfig) {
        app.use(session({
            secret: mongoConfig.secretOrKey,
            resave: false,
            saveUninitialized: false,
            store: MongoStore.create({ mongoUrl: mongoConfig.mongoURI })
        }));
    }

    // Configurer les routes
    setupRoutes(app);

    // Démarrer le serveur
    app.listen(port, () => {
        console.log(`Serveur en écoute sur http://localhost:${port}`);
    });
}).catch(err => {
    console.error('Erreur de connexion à MongoDB:', err.message);
    process.exit(1);
});
