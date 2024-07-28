const path = require('path');

module.exports = {
  rtmp: {
    port: 1935,
    chunk_size: 60000,
    gop_cache: true,
    ping: 30,
    ping_timeout: 60
  },
  http: {
    port: 8000,
    allow_origin: '*'
  },
  trans: {
    ffmpeg: '/usr/local/bin/ffmpeg', // Chemin correct vers votre installation FFmpeg
    tasks: [
      {
        app: 'live', // Assurez-vous que l'application est 'live'
        hls: true,
        hlsFlags: '[hls_time=8:hls_list_size=3:hls_flags=delete_segments+append_list]',
        dash: false
      }
    ]
  },
  mediaRoot: path.join(__dirname, '..', 'streams') // Chemin absolu du répertoire MediaRoot
};
