<script>
    document.title = "Nino - Ajouter une vidéo";
</script>

<h1>Ajouter une vidéo</h1>

<div class="nino_add">
    <?php
        // Création de l'ID de la vidéo
        function generateUniqueVideoId()
        {
            if (function_exists('uuid_create')) {
                $uuid = uuid_create(UUID_TYPE_RANDOM);
                return uuid_parse($uuid);
            } else {
                // Génération d'UUID alternative si l'extension uuid n'est pas disponible
                return uniqid('video_', true);
            }
        }
        // Exemple d'utilisation
        $videoId = generateUniqueVideoId();
    ?>
    <p class="info-popup error" style="justify-content: center;">
        Cette page est obselète. <br>
        L'ajout de vidéo est possible seulement par l'API de developpement
    </p>
    <form action="#" method="POST">
        <select name="APIselect" id="APIselect">
            <option selected disabled hidden>Choix de l'API</option>
            <option value="dev.nino.mhemery.fr">API de Nino DEV</option>
            <!-- <option selected value="nino.mhemery.fr">API de Nino PROD</option> -->
            <!-- <option value="enerzein.mhemery.fr">API de Nino (ENERZIN)</option> -->
        </select>
        <button onclick="reserveVideo(event, '<?= $videoId ?>')">Ajouter la vidéo</button>
    </form>
    <!-- <table>
        <thead>
            <tr>
                <th>Identifiant de la vidéo</th>
                <th>Titre de la Vidéo</th>
                <th>Éditer</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_SESSION['authentification']['user'])) {
                require './base/nexus_base.php';
                $id_users = $_SESSION['authentification']['user']['id'];
                $v = array('id_users' => $id_users);
                $sql = 'SELECT * FROM luma_nino_data WHERE id_users = :id_users';
                $req = $pdo->prepare($sql);
                $req->execute($v);
                $result = $req->rowCount();

                if ($result >= 1) {
                    while ($video = $req->fetch()) { ?>
                        <tr>
                            <td><?= $video['id_video_uuid'] ?></td>
                            <td><?= $video['titre'] ?></td>
                            <td>Edition non disponible</td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                    <tr>
                        <td>***</td>
                        <td style="text-align: center;">Aucune vidéo trouvé</td>
                        <td>***</td>
                    </tr>
                    </tr>
            <?php }
            } else {
                echo '<tr><td></td><td style="text-align: center;">Connexion obligatoire</td><td></td></tr>';
            }
            ?>
        </tbody>
    </table> -->
    <table>
        <thead>
            <tr>
                <th>Identifiant de la vidéo</th>
                <th>Titre de la Vidéo</th>
                <th>Éditer</th>
            </tr>
        </thead>
        <tbody id="video-table-body">
            <!-- Les données de la vidéo seront ajoutées ici -->
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            // Faire une requête AJAX pour récupérer les données depuis l'API
            $.ajax({
                type: 'GET',
                url: 'https://dev.nino.mhemery.fr/videos/manifest', // Remplacez par l'URL de votre API
                success: function(response) {
                    // Récupérer les clés des vidéos et les trier dans l'ordre décroissant
                    const videoIds = Object.keys(response).sort().reverse();
                    // Parcourir les vidéos dans l'ordre inversé
                    for (const videoId of videoIds) {
                        const video = response[videoId];
                        // Ajouter une ligne au tableau pour chaque vidéo
                        $('tbody').append(`
                    <tr>
                        <td>${video.id}</td>
                        <td>${video.titre}</td>
                        <td><button onclick="editVideo('${video.id}')">Edition</button></td>
                    </tr>
                `);
                    }
                },
                error: function(error) {
                    console.error('Erreur lors de la récupération des données:', error);
                }
            });
        });
    </script>

</div>


<script>
    function editVideo(videoId) {
        window.location.href = "/nino/edit?id=" + videoId;
    }
</script>

<!-- SCRIPTS SRV -->
<script src="../javascripts/nino/add.js?1"></script>