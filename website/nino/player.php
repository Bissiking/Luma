<link rel="stylesheet" href="<?= SITE_HTTP."://".SITE_URL ?>/css/nino.css">
<script>
	document.title = "Nino - Player";
</script>

<div class="video-container">
    <video id="Player" controls>
        <source src="">
        Your browser does not support the video tag.
    </video>

    <div class="video-info">
        <h1>Titre de la Vidéo</h1>
        <p>Description de la vidéo. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>

        <div class="like-buttons">
            <button><i class="far fa-thumbs-up"></i> Like</button>
            <button><i class="far fa-thumbs-down"></i> Unlike</button>
        </div>
    </div>
</div>

<div class="video-list">
    <div class="video-list-item">
        <img src="https://99designs-blog.imgix.net/blog/wp-content/uploads/2016/03/web-images.jpg?auto=format&q=60&w=1600&h=824&fit=crop&crop=faces" alt="Vidéo 1 Thumbnail">
        <div>
            <h3>Titre de la Vidéo 1</h3>
            <p>Description de la vidéo 1. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
    </div>

    <div class="video-list-item">
        <img src="https://99designs-blog.imgix.net/blog/wp-content/uploads/2016/03/web-images.jpg?auto=format&q=60&w=1600&h=824&fit=crop&crop=faces" alt="Vidéo 2 Thumbnail">
        <div>
            <h3>Titre de la Vidéo 2</h3>
            <p>Description de la vidéo 2. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
    </div>

    <!-- Ajoutez d'autres vidéos selon vos besoins -->
</div>

<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
	let url = "https://nino.mhemery.fr/<?= htmlspecialchars(trim($_GET['video'])) ?>"
						console.log(url);
						var id = new URL(url).pathname;
						console.log(id);
						const video = document.getElementById('Player');
						const videoSrc = url + '/index.m3u8';
						if (Hls.isSupported()) {
							const hls = new Hls();

							hls.loadSource(videoSrc);
							hls.attachMedia(video);
							hls.on(Hls.Events.MANIFEST_PARSED, () => {
								
							});
						} else if (video.canPlayType('application/vnd.apple.mpegurl')) {
							video.src = videoSrc;
							video.addEventListener('loadedmetadata', () => {
								
							});
						}
					</script>