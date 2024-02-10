<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_SESSION['authentification']['user']['account_administrator'] !== 1) {
        echo 'not-autorized';
        exit;
    }

    require_once 'base/config.php';
    extract($_REQUEST);
    // ADD USER
    

    // USERS DOMAIN EN AUTO (PREDEFINI)
    try {
        // Connexion à la base de données avec PDO
        require_once 'base/nexus_base.php';
        
        // Définir l'attribut PDO pour générer des exceptions en cas d'erreur
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // Récupérer les données du formulaire
        $identifiant = htmlspecialchars(trim($identifiant));
        $password = "LE MOT DE PASSE DU TURFU 64q69sgr4sd4g6dsfrg/dgfg/r*f/gfr*/rfg/*edgfd6g54dsfg65s4f6g4sd6g54";
        $nomComplet = htmlspecialchars(trim($nomComplet));
        $email = htmlspecialchars(trim($email));
        $users_domain = SITE_URL;
        $account_administrator = htmlspecialchars(trim($account_administrator));
    
        // Vérifier si l'utilisateur existe déjà
        $checkUserQuery = "SELECT * FROM luma_users WHERE identifiant = :identifiant";
        $checkUserStmt = $pdo->prepare($checkUserQuery);
        $checkUserStmt->bindParam(':identifiant', $identifiant);
        $checkUserStmt->execute();
    
        if ($checkUserStmt->rowCount() > 0) {
            echo "user-found";
        } else {
            // Requête SQL pour insérer un nouvel utilisateur
            $insertUserQuery = "INSERT INTO luma_users (identifiant, password, nomComplet, users_domain, account_administrator, email) VALUES (:identifiant, :password, :nomComplet, :users_domain, :account_administrator, :email)";
    
            // Préparation de la requête
            $insertUserStmt = $pdo->prepare($insertUserQuery);
    
            // Liaison des paramètres
            $insertUserStmt->bindParam(':identifiant', $identifiant);
            $insertUserStmt->bindParam(':password', $password);
            $insertUserStmt->bindParam(':nomComplet', $nomComplet);
            $insertUserStmt->bindParam(':users_domain', $users_domain);
            $insertUserStmt->bindParam(':account_administrator', $account_administrator);
            $insertUserStmt->bindParam(':email', $email);
    
            // Exécution de la requête
            $insertUserStmt->execute();
    
            echo "succes";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}