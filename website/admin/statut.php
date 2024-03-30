<?php
if ($_SESSION['authentification']['user']['account_administrator'] !== 1) {
    header('Location: /');
}

require './base/nexus_base.php';

$query = "SELECT uuid_agent, agent_name FROM luma_agent WHERE agent_etat = 1";
$statement = $pdo->query($query);
$data = $statement->fetchAll(PDO::FETCH_ASSOC);

// Extraction des services
$sql = 'SELECT * FROM luma_statut';
$req = $pdo->prepare($sql);
$req->execute();
$result = $req->rowCount();


?>

<script>
    document.title = "Administration de la page des statut";
</script>

<table>
    <thead>
        <tr>
            <th>Statut</th>
            <th>Agent à surveiller</th>
            <th>Option</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><input id="name_service" type="text" placeholder="Nom du service"></td>
            <td>
                <select id="srv_service">
                    <option selected disabled hidden>Liste d'agent(s) disponible(s)</option>
                    <?php foreach ($data as $row) : ?>
                        <option value="<?= $row['uuid_agent'] ?>"><?= $row['agent_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                Aucune option disponible
            </td>
        </tr>
        <?php while ($service = $req->fetch()): ?>
        <tr>
            <td  id="name-<?= $service['uuid_agent'] ?>" class="editService"><?= $service['service'] ?></td>
            <td>
                <select class="select-editService" id="<?= $service['uuid_agent'] ?>">
                    <option selected disabled hidden><?= $service['uuid_agent'] ?></option>
                    <?php foreach ($data as $row) : ?>
                        <option value="<?= $row['uuid_agent'] ?>"><?= $row['agent_name'] ?> - <?= $row['uuid_agent'] ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td><button class="delete" data-id="<?= $service['service'] ?>">Supression</button></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<script src="../javascripts/admin/statut.js?0"></script>