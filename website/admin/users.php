<?php
if ($_SESSION['authentification']['user']['account_administrator'] !== 1) {
    header('Location: /');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require './base/nexus_base.php';
    extract($_REQUEST);

    $nomComplet = htmlspecialchars(trim($nom_complet));
    $identifiant = htmlspecialchars(trim($user));
    $email = htmlspecialchars(trim($email));

    // UPDATE USER
    try {
        // Création de la requête
        $sql = "UPDATE luma_users SET ";
        // Vérification de la version de la BDD pour ajout du mail
        if (DB_VERSION >= 'DB02') {
            $sql .= " email = '$email',";
            echo 'out';
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
} ?>

<link rel="stylesheet" href="<?= SITE_HTTP . "://" . SITE_URL ?>/css/admin.css">
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
?>
    <!-- Formulaire d'édition d'utilisateur -->
    <div class="container">
        <form id="editUserForm" action="#" method="post">
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

                <label for="email">Adresse e-mail :</label>
                <input type="email" id="email" name="email" placeholder="<?php if (isset($user['email']) == "") {
                                                                                echo '';
                                                                            } else {
                                                                                echo $user['email'];
                                                                            }
                                                                            ?>">
                <!-- Bouton de soumission du formulaire -->
                <button id="editUserInfo">Enregistrer les modifications</button>
            <?php endif; ?>

        </form>
    </div>
    <div class="container groupe-container">
        <h3>Groupes actifs/inactifs</h3>
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
                <th>Domaine</th>
                <th>Administrateur du Domaine</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="text" name="nom_complet" placeholder="SMITH John" require></td>
                <td><input type="identifiant" name="identifiant" placeholder="jsmith44" require></td>
                <td><input type="domain" name="domain" placeholder="<?= SITE_URL ?>"></td>
                <td><select type="account_administrator" name="account_administrator">
                        <option value="1">Oui</option>
                        <option value="0" selected>Non</option>
                    </select></td>
                <td><button style="color: grey;">Ajouter</button></td>
            </tr>
            <?php
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
                        <td><?= $user['users_domain'] ?></td>
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