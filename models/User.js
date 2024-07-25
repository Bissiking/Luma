const mongoose = require('mongoose');
const Schema = mongoose.Schema;

// Définition du schéma de l'utilisateur
const UserSchema = new Schema({
  name: {
    type: String,
    required: true
  },
  email: {
    type: String,
    required: true,
    unique: true
  },
  password: {
    type: String,
    required: true
  }
});

// Création du modèle
const User = mongoose.model('User', UserSchema);

module.exports = User;
