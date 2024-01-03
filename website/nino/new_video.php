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
                <th>ID</th>
                <th>Titre de la Vidéo</th>
                <th>Éditer</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if (!isset($_SESSION['authentification']['user']['id'])) {
                $id_users = null;
            }else{
                $id_users = $_SESSION['authentification']['user']['id'];
            }
            // URL de l'API YouTube Data v3 pour récupérer les vidéos de la chaîne
            $apiUrl = 'https://nino.mhemery.fr/api/videos/list/reserved?id_users='.$id_users.'&token='.NINO_TOKEN;

            // Effectuez la requête vers l'API YouTube
            $response = file_get_contents($apiUrl);
            $data = json_decode($response);

            if ($data == null) {
                echo "<tr>";
                echo "<td>#001</td>";
                echo "<td>Aucune vidéo en attente</td>";
                echo "<td><button>Edition impossible</button></td>";
                echo "</tr>";
            }else{
                // Vérifiez si la requête a réussi
                if ($data) {
                    if (isset($data->error)) {
                        if ($data->error == 'Accès refusé') {
                            echo "<tr>";
                            echo "<td>#002</td>";
                            echo "<td>Aucune vidéo en attente</td>";
                            echo "<td><button>Edition impossible</button></td>";
                            echo "</tr>";
                            return;
                        }
            
                        if ($data->error == 'Accès refusé') {
                            echo "<tr>";
                            echo "<td>#003</td>";
                            echo "<td>Aucune vidéo en attente</td>";
                            echo "<td><button>Edition impossible</button></td>";
                            echo "</tr>";
                            return;
                        }
                    }
                    // Affichez les vidéos
                    foreach ($data as $video) {
                         echo "<tr>";
                        echo "<td>".$video->id."</td>";
                        echo "<td>".$video->title."</td>";
                        echo "<td><button onclick='editVideo(".$video->id.")'>Edité</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "Erreur lors de la récupération des vidéos. Soit il n'y a pas de vidéo, soit l'API est en maintenance. Retente plus tard";
                }
            }
 ?>
        </tbody>
    </table>
</div>


<script>
    function editVideo(videoId) {
        // Vous pouvez rediriger vers la page d'édition avec le videoId, ou effectuer d'autres actions d'édition.
        alert("Édition de la vidéo avec l'ID " + videoId);
        window.location.href = "/nino/edit?id="+videoId;
    }
</script>

<!-- SCRIPTS SRV -->
<script src="../javascripts/nino/add.js"></script>