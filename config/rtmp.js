const NodeMediaServer = require('node-media-server');

const config = {
  rtmp: {
    port: 1935,
    chunk_size: 60000,
    gop_cache: true,
    ping: 30,
    ping_timeout: 60
  },
  http: {
    port: 8000,
    allow_origin: '*',
    mediaroot: './media',
    webroot: './www',
    api: true
  },
  trans: {
    ffmpeg: 'C:/ffmpeg/bin/ffmpeg.exe',
    tasks: [
      {
        app: 'live',
        vc: 'copy',
        ac: 'aac',
        hls: true,
        hlsFlags: '[hls_time=4:hls_list_size=6:hls_flags=delete_segments]',
        dash: false
      },
      {
        app: 'live',
        vc: 'copy',
        ac: 'aac',
        mp4: true,
        mp4Flags: '[movflags=frag_keyframe+empty_moov]',
        flv: true
      }
    ]
  }
};

const nms = new NodeMediaServer(config);
nms.run();