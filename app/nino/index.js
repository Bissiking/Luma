const express = require('express');
const path = require('path');
const router = require('./routes');

const app = express();

// Configurer Pug comme moteur de template
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'pug');

// Middleware ou configurations spécifiques à config
app.use(express.json());

// Utiliser les routes définies dans routes.js
app.use('/nino', router);

module.exports = app;
