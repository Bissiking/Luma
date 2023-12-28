<?php
// login.php
session_start(); // Toujours appeler session_start() au début du script qui utilise des sessions
extract($_REQUEST); // Extraction des valeurs JS

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    var_dump($identifiant);

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
    $v = array('identifiant' => $identifiant);
    $query = "SELECT id, username, email FROM utilisateurs WHERE identifiant = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute($v);
    $result = $stmt->fetch();

    echo $result;

    // Vérifier si le mot de passe est correct en utilisant Bcrypt
    if (password_verify($password, $hashedPassword)) {
        // Stocker les informations du compte en session
        $_SESSION['auth']['user_id'] = $id;
        $_SESSION['auth']['identifiant'] = $fetchedUsername;


        echo 'Connexion réussie!';
    } else {
        echo 'Nom d\'utilisateur ou mot de passe incorrect.';
    }

} else {
    // Méthode de requête incorrecte
    echo 'Méthode de requête incorrecte.';
}
?>
