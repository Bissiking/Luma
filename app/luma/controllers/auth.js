const express = require('express');
const router = express.Router();
const User = require('../../../models/User');

// Route pour l'inscription
router.post('/register', async (req, res) => {
  const { username, password } = req.body;
  try {
    let user = await User.findOne({ username });
    if (user) {
      return res.status(400).json({ message: 'L\'utilisateur existe déjà' });
    }
    user = new User({ username, password });
    await user.save();
    res.status(201).json({ message: 'Utilisateur enregistré avec succès' });
  } catch (err) {
    console.error(err.message);
    res.status(500).send('Erreur du serveur');
  }
});

// Route pour la connexion
router.post('/login', async (req, res) => {
  const { username, password } = req.body;
  try {
    const user = await User.findOne({ username });
    if (!user) {
      return res.status(400).json({ message: 'Identifiants invalides' });
    }
    const isMatch = await user.matchPassword(password);
    if (!isMatch) {
      return res.status(400).json({ message: 'Identifiants invalides' });
    }
    req.session.userId = user.id;
    res.status(200).json({ message: 'Connexion réussie' });
  } catch (err) {
    console.error(err.message);
    res.status(500).send('Erreur du serveur');
  }
});

// Route pour la déconnexion
router.get('/logout', (req, res) => {
  req.session.destroy(err => {
    if (err) {
      return res.status(500).send('Erreur du serveur');
    }
    res.status(200).send('Déconnexion réussie');
  });
});

module.exports = router;
