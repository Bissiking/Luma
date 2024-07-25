const express = require('express');
const path = require('path');
const authRoutes = require('./controllers/auth');
const router = express.Router();

// Configurer Pug comme moteur de template
const app = express();
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'pug');

// Middleware pour analyser le corps des requêtes
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Utiliser les routes d'authentification
app.use('/auth', authRoutes);

// Routes pour afficher les formulaires d'inscription et de connexion
router.get('/register', (req, res) => {
  res.render('register');
});

router.get('/login', (req, res) => {
  res.render('login');
});

app.use('/', router);

module.exports = app;
