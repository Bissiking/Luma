const express = require('express');
const router = express.Router();

// Définir les routes spécifiques à config
router.get('/config', (req, res) => {
  res.render('config', { title: 'Application Config', message: 'Bienvenue sur l\'application Config' });
});

module.exports = router;
