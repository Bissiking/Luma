<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extraction des données
    extract($_REQUEST);
    require './lib/initConf.php';
    require './lib/mysql_table_add.php';

    try {
        function CheckURL($UserToCheck, $pdo)
        {
            $query = "SELECT * FROM luma_users WHERE identifiant = :identifiant";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':identifiant', $UserToCheck);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        }
        $tableName = 'luma_users';
        $error = 0; // Compteur d'erreur d'ajout
        $skip = 0; // Compteur de compte qui n'ont pas été créé. Cause: Déjà existant


        // Création du compte system
        $UserToCheck = 'system';
        $user = CheckURL($UserToCheck, $pdo);

        if (!$user) {
            require './lib/password_generate.php';
            $motDePasseGenere = genererMotDePasse(24);

            $data = [
                'identifiant' => 'system',
                'password' => password_hash("" . $motDePasseGenere . "", PASSWORD_BCRYPT),
                'users_domain' => $_SERVER['HTTP_HOST'],
                'account_system' => '1'
            ];
            $InsertPDO = insertDataPDO($tableName, $data, $pdo);
            if ($InsertPDO !== 'succes') {
                $error = +1;
                $PDOError = $InsertPDO;
            }
        }else{
            $skip = +1;
        }

        // Création du compte administrateur
        $USER_ADMIN = htmlspecialchars(trim($USER_ADMIN));
        $USER_ADMIN_MDP = urldecode($USER_ADMIN_MDP);

        $UserToCheck = $USER_ADMIN;
        $user = CheckURL($UserToCheck, $pdo);
        if (!$user) {
            $data = [
                'identifiant' => $USER_ADMIN,
                'password' => password_hash("" . $USER_ADMIN_MDP . "", PASSWORD_BCRYPT),
                'users_domain' => $_SERVER['HTTP_HOST'],
                'account_administrator' => '1'
            ];
            $InsertPDO = insertDataPDO($tableName, $data, $pdo);
            if ($InsertPDO !== 'succes') {
                $error = +1;
                $PDOError = $InsertPDO;
            }
        }else{
            $skip = +1;
        }

        if ($skip != 0) {
            $response = array(
                'nextStep' => "step3-6.1",
                'textStats' => "Création de la table de Nino",
                'totalStep' => "1",
                'resultat' => 'warning',
                'message' => $skip.' compte déjà existant'
            );
        }else if ($error != 0) {
            $response = array(
                'nextStep' => "step3-5.1",
                'textStats' => "Création de la table de Nino",
                'totalStep' => "1",
                'resultat' => 'error',
                'message' => $error.' echec de la création des users',
                'PDO' => $PDOError
            );
        }else{
            $response = array(
                'nextStep' => "step3-6.1",
                'textStats' => "Création de la table de Nino",
                'totalStep' => "1",
                'resultat' => 'succes',
                'message' => 'Création des users OK'
            );
        }

    } catch (PDOException $e) {
        $response = array(
            'nextStep' => "step3-5.1",
            'textStats' => "Création de la table de Nino",
            'totalStep' => "1",
            'resultat' => 'error',
            'message' => 'Créaction des utilisateurs: ECHEC',
            'PDO' => $e->getMessage(),
        );
    }
}
echo json_encode($response);
