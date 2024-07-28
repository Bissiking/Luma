const express = require('express');
const http = require('http');
const path = require('path');
const NodeMediaServer = require('node-media-server');
const config = require('./config/rtmp');
const createMediaRoot = require('./config/createMediaRoot');

// Chemin du répertoire MediaRoot
const mediaRootPath = path.join(__dirname, 'streams');

// Vérifiez et créez le répertoire MediaRoot
createMediaRoot(mediaRootPath);

// Initialisation du serveur
const app = express();
const server = http.createServer(app);
const nms = new NodeMediaServer(config);

app.use(express.static(path.join(__dirname, 'public')));
app.use('/streams', express.static(mediaRootPath));

nms.run();

nms.on('prePublish', (id, StreamPath, args) => {
  console.log('[NodeEvent on prePublish]', `id=${id} StreamPath=${StreamPath} args=${JSON.stringify(args)}`);
});

nms.on('postPublish', (id, StreamPath, args) => {
  console.log('[NodeEvent on postPublish]', `id=${id} StreamPath=${StreamPath} args=${JSON.stringify(args)}`);
});

nms.on('donePublish', (id, StreamPath, args) => {
  console.log('[NodeEvent on donePublish]', `id=${id} StreamPath=${StreamPath} args=${JSON.stringify(args)}`);
});

nms.on('error', (err) => {
  console.error('NodeMediaServer error:', err);
});

const PORT = 80;
server.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
