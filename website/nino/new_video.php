<link rel="stylesheet" href="<?= SITE_HTTP."://".SITE_URL ?>/css/nino.css">
<script>
	document.title = "Nino - Ajouter une vidéo";
</script>

<h1>Ajouter une vidéo</h1>

<div class="nino_add">
    <form action="#" method="POST">
        <label for="videoTitle">Titre de la Vidéo :</label>
        <input type="text" id="videoTitle" name="videoTitle" required>

        <?php if (isset($_SESSION['authentification']['user'])) { ?>
            <button type="button" onclick="reserveVideo()" id="btnReserveVideo" data-id_users="<?= $_SESSION['authentification']['user']['id'] ?>">Soumettre</button>
                <?php }else{ ?>
            <button style="background-color: grey;">Connexion obligatoire</button>
        <?php } ?>
        
    </form>

    <table>
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
                            <td><button onclick="editVideo(<?= $video['id'] ?>)">Modifier</button></td>
                        </tr>
                    <?php } ?>
                        



                <?php }else{ echo 'Aucune vidéo trouvé'; }
            }else{
                echo '<tr><td></td><td style="text-align: center;">Connexion obligatoire</td><td></td></tr>';
            }
 ?>
        </tbody>
    </table>
</div>


<script>
    function editVideo(videoId) {
        window.location.href = "/nino/edit?id="+videoId;
    }
</script>

<!-- SCRIPTS SRV -->
<script src="../javascripts/nino/add.js"></script>