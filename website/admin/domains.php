<?php
if ($_SESSION['authentification']['user']['account_administrator'] !== 1) {
    header('Location: /');
}

function addDomain($domain)
{
    require 'base/nexus_base.php';
    // Vérification d'un domain déjà présent
    $sql = "SELECT * FROM luma_domains WHERE domains = '$domain'";
    $req = $pdo->prepare($sql);
    $req->execute();
    $result = $req->rowCount();
    if ($result === 0) :
        try {
            // Définir le mode d'erreur de PDO sur Exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $v = array('domains' => $domain);
            $sql = 'INSERT INTO luma_domains (domains) VALUES (:domains)';
            $req = $pdo->prepare($sql);
            $req->execute($v);
            echo 'succes';
            exit;
        } catch (PDOException $e) {
            echo 'echec --> ' . $e->getMessage();
            exit;
        }
    else :
        echo 'found';
        exit;
    endif;
}

function delDomain($domain)
{
    require 'base/nexus_base.php';
    // Vérification d'un domain déjà présent
    $sql = "SELECT * FROM luma_domains WHERE domains = '$domain'";
    $req = $pdo->prepare($sql);
    $req->execute();
    $result = $req->rowCount();
    if ($result !== 0) :

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'DELETE FROM luma_domains WHERE domains = :domains';
        $req = $pdo->prepare($sql);
        // Liaison des paramètres
        $req->bindParam(':domains', $domain, PDO::PARAM_STR);

        try {
            $req->execute();
            echo 'succes';
            exit;
        } catch (PDOException $e) {
            echo 'echec --> ' . $e->getMessage();
            exit;
        }
    else :
        echo 'not_found';
        exit;
    endif;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    extract($_REQUEST);
    switch ($call) {
        case 'add':
            addDomain(htmlspecialchars(trim($domain)));
            break;

        case 'del':
            delDomain(htmlspecialchars(trim($domain)));
            break;

        default:
            echo 'STOP CODE #001';
            exit;
    }
}

?>
<script>
    document.title = "Administration des domaines";
</script>
<?php if (defined('DB_LUMA_DOMAINS_VERSION') && DB_LUMA_DOMAINS_VERSION >= "DB01") :
    // Connexion à la base de données
    require 'base/nexus_base.php';
    // Récupérer les routes depuis la base de données
    $sql_dom = "SELECT * FROM luma_domains";
    $req_dom = $pdo->prepare($sql_dom);
    $req_dom->execute();

    $result_dom = $req_dom->rowCount();
    // Afficher le bouton "Ajouter" si des routes peuvent être ajoutées
    $afficherBoutonAjouter = !empty($routesToAdd);
?>
    <table>
        <thead>
            <tr>
                <th>Domaine</th>
                <th>Domaine Autorisé</th>
                <th>Option</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_dom < 1) :
                $sql = "SELECT users_domain FROM luma_users WHERE identifiant = 'system'";
                $req = $pdo->prepare($sql);
                $req->execute();
                $result = $req->rowCount();
                foreach ($req as $user) {
                }
            ?>
                <!-- FORM domain quand celui-ci est vide -->
                <td><input id="add-domain" type="text" value="<?= $user['users_domain'] ?>"></td>
                <td>Non disponible</td>
                <td><button id="add-domain-btn" onclick="addDomain()">Ajouter</button></td>

            <?php else : ?>

                <tr>
                    <!-- FORM domain quand celui-ci comporte des valeurs -->
                    <td><input id="add-domain" type="text" value="" placeholder="domain"></td>
                    <td>Non disponible</td>
                    <td><button id="add-domain-btn" onclick="addDomain()">Ajouter</button></td>
                </tr>
            <?php endif; ?>
            <?php if ($result_dom >= 1) :
                while ($domain = $req_dom->fetch()) { ?>
                    <tr>
                        <td><?= $domain['domains'] ?></td>
                        <td><?= $domain['domains_autorized'] ?></td>
                        <td><button class="delete-button" onclick="delDomain('<?= $domain['domains'] ?>')">Supprimé</button></td>
                    </tr>
            <?php }
            endif; ?>
        </tbody>
    </table>
<?php else : ?>
    <table>
        <thead>
            <tr>
                <th>Domaine erreur</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>La Base de donnée est innexistante ou une mise à jour est en attente.<br />
                    Veuillez vous rendre dans "<a href="/admin/bdd">Gestion des BDD</a>" puis mettre à jour la base domaines</td>
            </tr>
        </tbody>
    </table>
<?php endif; ?>

<script src="/javascripts/admin/domain.js?0"></script>