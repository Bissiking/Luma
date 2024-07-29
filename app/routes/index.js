const axios = require('axios');
const fs = require('fs');
const url = "https://api.nino.mhemery.fr";

// const authRoutes = require('../controllers/auth');

module.exports = (app) => {


    // Page d'accueil
    app.get('/', (req, res) => {
        res.render('index', { title: 'Accueil', message: 'Bienvenue !' });
    });

    // Nino - Accueil
    app.get('/nino', async (req, res) => {
        try {
            // Récupérer les vidéos depuis votre API
            const response = await axios.get(url + '/videos/manifest');
            const videos = response.data;

            // Convertir l'objet en tableau
            const videosArray = Object.values(videos);

            // Rendre le template EJS avec les vidéos converties en tableau
            res.render('nino/videos', { videos: videosArray, url: url });
        } catch (error) {
            console.error('Erreur lors de la récupération des vidéos :', error);
            res.status(500).send('Erreur lors de la récupération des vidéos');
        }
    });

    // Route des détails de la vidéo
    app.get('/details/:id', async (req, res) => {
        let id = req.params.id;
        try {
            // Récupérer la vidéo depuis votre API en fonction de l'ID
            const response = await axios.get(url + '/video/data/' + id);
            const video = response.data[0];

            // Rendre le template Pug avec la vidéo récupérée
            res.render('nino/details', { video: video, url: url });
        } catch (error) {
            console.error('Erreur lors de la récupération de la vidéo :', error);
            res.status(500).send('Erreur lors de la récupération de la vidéo');
        }
    });

    // Route des détails de la vidéo
    app.get('/play/:id', async (req, res) => {
        let id = req.params.id;
        try {
            // Récupérer la vidéo depuis votre API en fonction de l'ID
            const response = await axios.get(url + '/video/data/' + id);
            const video = response.data[0];

            // Rendre le template Pug avec la vidéo récupérée
            res.render('nino/play', { video: video, url: url });
        } catch (error) {
            console.error('Erreur lors de la récupération de la vidéo :', error);
            res.status(500).send('Erreur lors de la récupération de la vidéo');
        }
    });








    // Routes d'authentification
    // app.use('/auth', authRoutes);
};
