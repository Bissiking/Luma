<?php
if ($_SESSION['authentification']['user']['account_administrator'] !== 1) {
    header('Location: /');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    extract($_REQUEST);

    if ($user == 'system'){
        header('Location: /admin/users?edit&user=system&refused');
        exit;
    }

    switch ($call) {
        case 'edit':
            $nomComplet = htmlspecialchars(trim($nom_complet));
            $identifiant = htmlspecialchars(trim($user));
            $email = htmlspecialchars(trim($email));

            if ($user == 'system') {
                echo 'succes';
                exit();
            }
            // UPDATE USER
            $pdo = new PDO('mysql:host=' . DB_HOST . ':' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASSWORD);
            try {
                // Création de la requête
                $sql = "UPDATE luma_users SET ";
                // Vérification de la version de la BDD pour ajout du mail
                if (defined("DB_LUMA_USERS_VERSION")) {
                    if (DB_LUMA_USERS_VERSION >= 'DB02') {
                        $sql .= " email = '$email',";
                    }
                }

                $sql .= "nomComplet = '$nomComplet' WHERE identifiant = :identifiant";
                // Execution de la requête
                $req = $pdo->prepare($sql);
                $req->execute(array('identifiant' => $identifiant));
                echo 'succes';
            } catch (PDOException $e) {
                echo 'Users update ECHEC // -> ' . $e->getMessage();
                exit;
            }
            exit;

        case 'add-domain':

            $pdo = new PDO('mysql:host=' . DB_HOST . ':' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASSWORD);
            // Assurez-vous de sécuriser les valeurs du tableau (prévention des attaques d'injection SQL)
            $newDomain = htmlspecialchars(trim($domain)); // Supprime les caractères spéciaux

            $user = htmlspecialchars(trim($user));

            // Vérifiez si le domaine existe déjà dans la table luma_users pour cet utilisateur
            $sql_checkDomain = "SELECT COUNT(*) AS count FROM luma_users WHERE users_domain = :newDomain AND identifiant = :user";
            $req_checkDomain = $pdo->prepare($sql_checkDomain);
            $req_checkDomain->bindParam(':newDomain', $newDomain, PDO::PARAM_STR);
            $req_checkDomain->bindParam(':user', $user, PDO::PARAM_STR);
            $req_checkDomain->execute();
            $count = $req_checkDomain->fetchColumn();

            if ($count == 0) {
                // Le domaine n'existe pas, nous pouvons le mettre à jour
                // Récupérez les domaines existants depuis la table luma_users pour cet utilisateur
                $sql_existingDomains = "SELECT users_domain FROM luma_users WHERE identifiant = :user";
                $req_existingDomains = $pdo->prepare($sql_existingDomains);
                $req_existingDomains->bindParam(':user', $user, PDO::PARAM_STR);
                $req_existingDomains->execute();
                $existingDomains = $req_existingDomains->fetchColumn();

                $tbldomainExist = explode(',', $existingDomains);
                $doublonDomain = in_array($newDomain, $tbldomainExist);
                if ($doublonDomain === true) {
                    echo 'Exist';
                    exit;
                }

                // Ajoutez le nouveau domaine à la liste existante
                $newDomainList = $existingDomains . ',' . $newDomain;

                // Préparez et exécutez la requête UPDATE pour mettre à jour la liste des domaines
                $sql_updateDomain = 'UPDATE luma_users SET users_domain = :newDomainList WHERE identifiant = :user';
                $req_updateDomain = $pdo->prepare($sql_updateDomain);

                // Liaison des paramètres
                $req_updateDomain->bindParam(':newDomainList', $newDomainList, PDO::PARAM_STR);
                $req_updateDomain->bindParam(':user', $user, PDO::PARAM_STR);

                // Exécution de la requête
                try {
                    $req_updateDomain->execute();
                    echo "succes";
                } catch (PDOException $e) {
                    echo "Erreur lors de l'ajout du domaine '$newDomain' : " . $e->getMessage();
                }
            } else {
                echo "Le domaine '$newDomain' existe déjà dans la table luma_users pour cet utilisateur.";
            }

            exit();

        case 'delete-domain':
            $pdo = new PDO('mysql:host=' . DB_HOST . ':' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASSWORD);
            // Assurez-vous de sécuriser les valeurs du formulaire (prévention des attaques d'injection SQL)
            $domainToDelete = htmlspecialchars(trim($domain)); // Supprime les caractères spéciaux

            $user = htmlspecialchars(trim($user));

            // Récupérez les domaines existants depuis la table luma_users pour cet utilisateur
            $sql_existingDomains = "SELECT users_domain FROM luma_users WHERE identifiant = :user";
            $req_existingDomains = $pdo->prepare($sql_existingDomains);
            $req_existingDomains->bindParam(':user', $user, PDO::PARAM_STR);
            $req_existingDomains->execute();
            $existingDomains = $req_existingDomains->fetchColumn();

            // Convertissez la liste de domaines en tableau
            $tbldomainExist = explode(',', $existingDomains);

            // Recherchez l'index du domaine à supprimer
            $indexToDelete = array_search($domainToDelete, $tbldomainExist);

            if ($indexToDelete !== false) {
                // Supprimez le domaine du tableau
                unset($tbldomainExist[$indexToDelete]);

                // Convertissez le tableau mis à jour en une chaîne de domaines
                $updatedDomainList = implode(',', $tbldomainExist);

                // Préparez et exécutez la requête UPDATE pour mettre à jour la liste des domaines
                $sql_updateDomain = 'UPDATE luma_users SET users_domain = :updatedDomainList WHERE identifiant = :user';
                $req_updateDomain = $pdo->prepare($sql_updateDomain);

                // Liaison des paramètres
                $req_updateDomain->bindParam(':updatedDomainList', $updatedDomainList, PDO::PARAM_STR);
                $req_updateDomain->bindParam(':user', $user, PDO::PARAM_STR);

                // Exécution de la requête
                try {
                    $req_updateDomain->execute();
                    echo "succes";
                } catch (PDOException $e) {
                    echo "Erreur lors de la suppression du domaine '$domainToDelete' : " . $e->getMessage();
                }
            } else {
                echo "Le domaine '$domainToDelete' n'a pas été trouvé dans la liste des domaines pour cet utilisateur.";
            }

            exit();
        default:
            echo 'STOP CODE #001';
            exit;
    }
} ?>
<script>
    document.title = "Administration - Utilisateurs";
</script>

<?php if (isset($_GET["edit"]) && isset($_GET["user"]) && $_GET["user"] != "") :
    require './base/nexus_base.php';
    $user = htmlspecialchars(trim($_GET['user']));
    $sql = "SELECT * FROM luma_users WHERE identifiant = '$user'";
    $req = $pdo->prepare($sql);
    $req->execute();
    $result = $req->rowCount();
    if ($result == 1) {
        foreach ($req as $user) {
        }
        $ERROR_USER = 0;
    } else {
        $user = array(
            'identifiant'  => 'Utilisateur invalide',
            'nom_complet'  => 'Utilisateur invalide',
            'email'  => 'Utilisateur invalide',
            'account_administrator' => 0,
            'account_system' => 0
        );
        $ERROR_USER = 1;
    }

    function checkAuthorization($userDomain, $domain)
    {
        $userDomains = $userDomain;

        // Divisez la chaîne en un tableau de domaines
        $userDomainArray = explode(",", $userDomains);

        // Vérifiez si le domaine est présent dans le tableau
        return in_array($domain, $userDomainArray);
    }
?>
    <!-- Formulaire d'édition d'utilisateur -->
    <div class="container">
        <form id="editUserForm" method="post">
            <?php if ($ERROR_USER == 1) : ?>
                <span class="user-invalid">L'utilisateur recherché est invalide ou innexistant</span>
            <?php else : ?>
                <label for="identifiant">Identifiant :</label>
                <input type="text" id="identifiant" name="identifiant" placeholder="<?= $user['identifiant'] ?>">

                <label for="nom_complet">Nom complet :</label>
                <input type="text" id="nom_complet" name="nom_complet" value="<?php if (isset($user['nomComplet']) == "") {
                                                                                    echo '';
                                                                                } else {
                                                                                    echo $user['nomComplet'];
                                                                                }
                                                                                ?>">
                <?php if (defined("DB_LUMA_USERS_VERSION")) :
                    if (DB_LUMA_USERS_VERSION >= 'DB02') : ?>
                        <label for="email">Adresse e-mail :</label>
                        <input type="email" id="email" name="email" value="<?php if (isset($user['email']) == "") {
                                                                                echo '';
                                                                            } else {
                                                                                echo $user['email'];
                                                                            }
                                                                            ?>">
                <?php endif;
                endif; ?>
                <ul class="domain-list" id="domainList">
                    <?php if (defined("DB_LUMA_DOMAINS_VERSION")) :
                        if (DB_LUMA_DOMAINS_VERSION >= 'DB01') :
                            // Récupérer la liste de domaines depuis la base de données
                            $sql_domains = "SELECT DISTINCT domains FROM luma_domains";
                            $result_domains = $pdo->query($sql_domains);

                            // Fonction pour retirer les doublons de la chaîne de domaine
                            while ($domain = $result_domains->fetch()) {
                                $currentDomain = $domain['domains'];
                                $userDom = $user['users_domain'];

                                echo "<li class='domain-list-item' data-domain='" . $currentDomain . "' data-authorized='";

                                // Vérifiez si le domaine actuel est présent dans la chaîne user_domain
                                $isDomainInUser = strpos($userDom, $currentDomain) !== false;
                                echo ($isDomainInUser ? 'Refusé' : 'Autorisé') . "'>";
                                echo "<span>" . $currentDomain . "</span>";

                                if ($isDomainInUser == true) : ?>
                                    <button class='button-domain delete-button' data-action="delete-domain" data-domain="<?= $currentDomain ?>">Suppression de l'accès au domaine</button>
                                <?php else : ?>
                                    <button class='button-domain' data-action="add-domain" data-domain="<?= $currentDomain ?>">Autorisé l'accès au domaine</button>
                                <?php endif; ?>
                    <?php }
                        endif;
                    endif;
                    ?>
                </ul>
                <?php if($user['account_system'] !== 1): ?>
                <button id="editUserInfo">Enregistrer les modifications</button>
                <?php endif; ?>
            <?php endif; ?>

        </form>
    </div>
    <div class="container groupe-container">
        <h3>Groupes actifs/inactifs</h3>
        <span class="betaPops">Fonctionnalités non disponible</span>
        <?php if ($user['account_system'] == 1) : ?>
            <p class="system-warning">Le compte est un compte système. Les droits, ne peuvent pas être modifié</p>
        <?php else : ?>
            <span class="groupes <?php if ($user['account_administrator'] == 1) {
                                        echo 'active';
                                    } ?>">Administateur</span>
            <span class="groupes disable">Modérateur</span>
            <span class="groupes disable">Nino Upload</span>
            <script src="/javascripts/admin/users-edit.js"></script>
        <?php endif; ?>



        <!-- <script src="./switch.js"></script> -->
    </div>

<?php else : ?>
    <!-- Liste des utilisateurs -->
    <table>
        <thead>
            <tr>
                <th>Nom complet</th>
                <th>Identifiant</th>
                <th>Email</th>
                <th>Administrateur du Domaine</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <?php if (defined('DB_LUMA_USERS_VERSION') && DB_LUMA_USERS_VERSION >= 'DB02'): ?>
                <!-- FORMULAIRE D'AJOUT DE COMPTE (FORCED) -->
                <td><input id="add-nomComplet" type="text" name="nom_complet" placeholder="SMITH John" require></td>
                <td><input id="add-identifiant" type="identifiant" name="identifiant" placeholder="jsmith44" require></td>
                <td><input id="add-email" type="email" name="email" placeholder="smith.john@mhemery.fr"></td>
                <td><select id="add-account_administrator" type="account_administrator" name="account_administrator">
                        <option value="1">Oui</option>
                        <option value="0" selected>Non</option>
                    </select></td>
                <td><button id="add-btn" onclick="addUser()">Ajouter</button></td>
            </tr>
            <?php endif;
            require './base/nexus_base.php';
            $sql = 'SELECT * FROM luma_users';
            $req = $pdo->prepare($sql);
            $req->execute();
            $result = $req->rowCount();
            if ($result >= 1) :
                while ($user = $req->fetch()) {
            ?>
                    <tr>
                        <td><?php if ($user['nomComplet'] == '') {
                                echo 'Unknown';
                            } else {
                                echo $user['nomComplet'];
                            } ?></td>
                        <td><?= $user['identifiant'] ?></td>
                        <td><?php if (defined('DB_LUMA_USERS_VERSION') && DB_LUMA_USERS_VERSION >= 'DB02') {
                            if(!isset($user['email']) || $user['email'] == ""){
                                echo 'Unknown';
                            }else{
                                echo $user['email'];
                            }
                        }else{ echo "Votre base de donnée n'est pas à jour"; } ?></td>
                        <td><?php if ($user['account_administrator'] == 0) {
                                echo 'Non';
                            } else {
                                echo 'Oui';
                            } ?></td>
                        <td class="options">
                            <i class="fa-solid fa-user-pen edit-user" data-identifiant="<?= $user['identifiant'] ?>"></i>
                        </td>
                    </tr>
                <?php }
            else : ?>
                <tr>
                    <td>####</td>
                    <td>NO USER</td>
                    <td>####</td>
                    <td>####</td>
                </tr>
            <?php endif; ?>

            <!-- Ajoutez d'autres lignes pour chaque utilisateur -->
        </tbody>
    </table>
<?php endif;  ?>
<script src="/javascripts/admin/users.js"></script>