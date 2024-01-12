<link rel="stylesheet" href="<?= SITE_HTTP . "://" . SITE_URL ?>/css/admin.css">
<script>
    document.title = "Administration - Utilisateurs";
</script>

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
            if ($result >= 1):
                while ($user = $req->fetch()) {
        ?>
        <tr>
            <td><?php if($user['nomComplet'] == ''){echo 'Unknown';}else{echo $user['nomComplet'];} ?></td>
            <td><?= $user['identifiant'] ?></td>
            <td><?= $user['users_domain'] ?></td>
            <td><?php if($user['account_administrator'] == 0){echo 'Non';}else{echo 'Oui';} ?></td>
            <td class="options">
                <i class="fa-solid fa-user-pen"></i>
            </td>
        </tr>
        <?php }else: ?>
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