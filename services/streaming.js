const ffmpeg = require('fluent-ffmpeg');
const path = require('path');
const fs = require('fs');

const streamsPath = path.join(__dirname, '../streams');
if (!fs.existsSync(streamsPath)) {
  fs.mkdirSync(streamsPath);
}

function startStreaming(streamKey, inputStream) {
  const streamOutput = `${streamsPath}/${streamKey}.m3u8`;

  // Démarrer le flux avec FFmpeg pour créer les segments HLS
  const ffmpegProcess = ffmpeg()
    .input(inputStream)
    .inputFormat('mpegts') // Format d'entrée
    .output(streamOutput)
    .videoCodec('libx264')
    .audioCodec('aac')
    .format('hls')
    .outputOptions([
      '-hls_time 8',  // Durée de chaque segment (en secondes)
      '-hls_list_size 3',  // Nombre maximum de segments dans la playlist
      '-hls_flags delete_segments+append_list' // Supprimer les anciens segments
    ])
    .on('start', () => {
      console.log('FFmpeg process started');
    })
    .on('error', (err) => {
      console.error('FFmpeg error:', err);
    })
    .on('end', () => {
      console.log('FFmpeg process finished');
    })
    .run();

  return ffmpegProcess;
}

function stopStreaming(ffmpegProcess) {
  if (ffmpegProcess) {
    ffmpegProcess.kill('SIGKILL');
  }
}

module.exports = {
  startStreaming,
  stopStreaming
};
