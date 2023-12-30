<?php
// login.php
session_start(); // Toujours appeler session_start() au début du script qui utilise des sessions
extract($_REQUEST); // Extraction des valeurs JS

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérification si les champs sont vides
    if (!isset($identifiant) || $identifiant == "") {
        echo 'ID VIDE';
        exit;
    }

    if (!isset($password) || $password == "") {
        echo 'PASS VIDE';
        exit;
    }

    // Connexion à MySQL
    require_once '../base/nexus_base.php';

    // Requête pour récupérer le mot de passe hashé depuis la base de données
    extract($_REQUEST);
    $identifiant = htmlspecialchars(trim($identifiant));
    $password = htmlspecialchars(trim($password));

    if(!empty($_POST)){
        $v = array('identifiant' => $identifiant);
        $sql = 'SELECT id, identifiant, users_domain, password FROM luma_users WHERE identifiant = :identifiant';
        $req = $pdo->prepare($sql);
        $req->execute($v);
        $result = $req->rowCount();
    
        if ($result == 1) {
            foreach($req as $user){}
            // Vérification du bon domaine
            if($_SERVER['HTTP_HOST'] !== $user['users_domain']){
                echo 'error_domain';
                exit;
            }

            // Vérification du mot de passe et création de la session
            if(password_verify($password, $user['password']) && $identifiant == $user['identifiant']){
                // INTEGRATION DES SESSIONS
                $_SESSION['authentification']['user'] = $user;
                echo 'succes';    
            } else { echo 'error'; }
        }else{ echo 'error'; }
    }else{ echo 'empty'; }

} else {
    // Méthode de requête incorrecte
    echo 'Méthode de requête incorrecte.';
}
?>
