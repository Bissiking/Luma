const express = require('express');
const router = express.Router();

// Définir les routes spécifiques à config
router.get('/nino', (req, res) => {
  res.render('Nino', { title: 'Nino' });
});

module.exports = router;
