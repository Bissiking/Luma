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

// NMS

nms.on('preConnect', (id, args) => {
    console.log('[NodeEvent on preConnect]', `id=${id} args=${JSON.stringify(args)}`);
    // let session = nms.getSession(id);
    // session.reject();
  });
  
  nms.on('postConnect', (id, args) => {
    console.log('[NodeEvent on postConnect]', `id=${id} args=${JSON.stringify(args)}`);
  });
  
  nms.on('doneConnect', (id, args) => {
    console.log('[NodeEvent on doneConnect]', `id=${id} args=${JSON.stringify(args)}`);
  });
  
  nms.on('prePublish', (id, StreamPath, args) => {
    console.log('[NodeEvent on prePublish]', `id=${id} StreamPath=${StreamPath} args=${JSON.stringify(args)}`);
    // let session = nms.getSession(id);
    // session.reject();
  });
  
  nms.on('postPublish', (id, StreamPath, args) => {
    console.log('[NodeEvent on postPublish]', `id=${id} StreamPath=${StreamPath} args=${JSON.stringify(args)}`);
  });
  
  nms.on('donePublish', (id, StreamPath, args) => {
    console.log('[NodeEvent on donePublish]', `id=${id} StreamPath=${StreamPath} args=${JSON.stringify(args)}`);
  });
  
  nms.on('prePlay', (id, StreamPath, args) => {
    console.log('[NodeEvent on prePlay]', `id=${id} StreamPath=${StreamPath} args=${JSON.stringify(args)}`);
    // let session = nms.getSession(id);
    // session.reject();
  });
  
  nms.on('postPlay', (id, StreamPath, args) => {
    console.log('[NodeEvent on postPlay]', `id=${id} StreamPath=${StreamPath} args=${JSON.stringify(args)}`);
  });
  
  nms.on('donePlay', (id, StreamPath, args) => {
    console.log('[NodeEvent on donePlay]', `id=${id} StreamPath=${StreamPath} args=${JSON.stringify(args)}`);
  });
  
  nms.on('logMessage', (...args) => {
    // custom logger log message handler
  });
  
  nms.on('errorMessage', (...args) => {
    // custom logger error message handler
  });
  
  nms.on('debugMessage', (...args) => {
    // custom logger debug message handler
  });
  
  nms.on('ffDebugMessage', (...args) => {
    // custom logger ffmpeg debug message handler
  });

// ----------------------------------------

const PORT = 80;
server.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
