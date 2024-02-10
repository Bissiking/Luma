<?php
// Fonction pour vérifier si un identifiant est déjà utilisé
function isUsernameTaken($username, $pdo) {
    $query = $pdo->prepare("SELECT COUNT(*) FROM luma_users WHERE identifiant = ?");
    $query->execute([$username]);
    return $query->fetchColumn() > 0;
}

// Fonction pour vérifier si un e-mail est déjà utilisé
function isEmailTaken($email, $pdo) {
    $query = $pdo->prepare("SELECT COUNT(*) FROM luma_users WHERE email = ?");
    $query->execute([$email]);
    return $query->fetchColumn() > 0;
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_REQUEST);

    echo '<pre>';
    print_r($_REQUEST);
    echo '</pre>';

    // Récupérer les données du formulaire
    $identifiant = htmlspecialchars(trim($identifiant));
    $password = password_hash($password, PASSWORD_BCRYPT); // Hacher le mot de passe
    $email = htmlspecialchars(trim($email));

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
    require_once 'base/nexus_base.php';

    // Valider et traiter les données (exemple simple de validation)
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Les données sont valides, vous pouvez les utiliser comme bon vous semble
        


    // Vérifier si l'identifiant est déjà pris
    if (isUsernameTaken($identifiant, $pdo)) {
        echo "user-exist";
    } else {
        // Vérifier si l'e-mail est déjà pris
        if (isEmailTaken($email, $pdo)) {
            echo "email-exist";
        } else {
            // Les données sont valides, vous pouvez les utiliser comme bon vous semble
            // ... (traitement d'inscription, hachage du mot de passe, etc.)
            echo "ok";
        }
    }



        // Exemple d'affichage des données (à adapter selon votre besoin)
        // echo "Identifiant: " . $identifiant . "<br>";
        // echo "Mot de passe (haché): " . $motDePasse . "<br>";
        // echo "Email: " . $email . "<br>";
    } else {
        // Les données ne sont pas valides
        echo "Adresse email non valide.";
    }
} else {
    // Le formulaire n'a pas été soumis
    echo "Accès non autorisé.";
}
