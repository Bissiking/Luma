<link rel="stylesheet" href="<?= SITE_HTTP . "://" . SITE_URL ?>/css/admin.css">
<script>
    document.title = "Administration - Utilisateurs";
</script>

<h1>Gestion des Utilisateurs</h1>

<!-- Formulaire pour ajouter un utilisateur -->
<form action="gestion_utilisateurs.php" method="post">
    <label for="nom">Nom:</label>
    
    <label for="email">Email:</label>
    
    <button type="submit" name="ajouterUtilisateur">Ajouter Utilisateur</button>
</form>

<!-- Liste des utilisateurs -->
<table>
    <thead>
        <tr>
            <th>Nom complet</th>
            <th>Identifiant</th>
            <th>Domaine</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><input type="text" name="nom" require></td>
            <td><input type="email" name="email" require></td>
            <td><input type="domain" name="domain" placeholder="<?= SITE_URL ?>"></td>
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
            <td>OPTION</td>
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