<script>
    document.title = "Nino - Ajouter une vidéo";
</script>

<h1>Ajouter une vidéo</h1>

<div class="nino_add">
    <?php     // URL de l'API que vous souhaitez interroger

    // switch ($_SERVER['HTTP_HOST']) {
    //     case 'mhemery.fr':
    //         $apiUrl = 'https://nino.mhemery.fr/check';
    //         break;

    //     case 'dev.mhemery.fr':
    //     case 'pre-prod.mhemery.fr':
    //         $apiUrl = 'https://dev.nino.mhemery.fr/check';
    //         break;

    //     case 'luma.enerzein.fr':
    //         $apiUrl = 'https://nino.enerzein.fr/check';
    //         break;

    //     default:
    //         $apiUrl = null;
    //         break;
    // }

    // if ($apiUrl !== null) :

    //     $options = [
    //         'http' => [
    //             'timeout' => 1, // Timeout en secondes
    //         ],
    //     ];

    //     // Création du contexte
    //     $context = stream_context_create($options);

    //     // Récupération du contenu avec gestion du timeout
    //     $content = @file_get_contents($apiUrl, false, $context);

    //     if ($content === false) {
    //         // Gérer les erreurs en fonction de la raison de l'échec
    //         $error = error_get_last();
    //         if ($error !== null && strpos($error['message'], 'timed out') !== false) {
    //             // Gérer le timeout
    //             $message_Error = "L\'API à mis trop de temps à répondre.\n";
    //         } else {
    //             // Gérer d'autres erreurs
    //             $message_Error = "Une erreur s'est produite lors de la récupération de la version de l'API = " . $apiUrl;
    //         }
    //         $data['version'] = '0.0.0';
    //     } else {
    //         // Utiliser le contenu récupéré
    //         $data = json_decode($content, true);
    //     }
    // else :
    //     $data['version'] == '0.0.0';
    //     $message_Error = 'Ajout de vidéo impossible, version de l\'API requis "1.0.0"';
    // endif;
?>
        <p class="info-popup error" style="justify-content: center;">
            Cette page est obselète. <br> 
            L'ajout de vidéo est actuellement impossible. <br> 
            La page n'utilisant pas encore l'API, les données affiché ne sont pas correct et viennent de la base de donnée non maintenu à jour. <br>
            L'API gère la gestion des données, se que le formulaire ne fait actuellement.
        </p>
        <form action="#" method="POST">
            <label for="APIselect">Choix de l'API</label>
            <select name="" id="">
                <option selected disabled hidden>FORM EN UPDATE</option>
                <!-- <option value="dev.nino.mhemery.fr">API de Nino DEV</option>
                <option selected value="nino.mhemery.fr">API de Nino PROD</option>
                <option value="enerzein.mhemery.fr">API de Nino (ENERZIN)</option> -->
            </select>
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
                            <td>Edition non disponible</td>
                        </tr>
                    <?php } ?>
                <?php }else{ ?>
                <tr>
                    <tr><td>***</td><td style="text-align: center;">Aucune vidéo trouvé</td><td>***</td></tr>
                </tr>
            <?php }} else {
                echo '<tr><td></td><td style="text-align: center;">Connexion obligatoire</td><td></td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>


<script>
    function editVideo(videoId) {
        window.location.href = "/nino/edit?id=" + videoId;
    }
</script>

<!-- SCRIPTS SRV -->
<script src="../javascripts/nino/add.js?1"></script>