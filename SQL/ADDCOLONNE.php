<?php
$servername = "localhost";
$username = "votre_nom_utilisateur";
$password = "votre_mot_de_passe";
$dbname = "votre_base_de_données";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Définir les noms et les types de colonnes à ajouter
$columnsToAdd = [
    "nouvelle_colonne1 INT",
    "nouvelle_colonne2 VARCHAR(255)",
    // Ajoutez d'autres colonnes selon vos besoins
];

// Générez la partie SET de la requête ALTER TABLE
$alterTableQuery = "ALTER TABLE votre_table ADD " . implode(", ADD ", $columnsToAdd);

// Exécutez la requête ALTER TABLE
if ($conn->query($alterTableQuery) === TRUE) {
    echo "Les colonnes ont été ajoutées avec succès.";
} else {
    echo "Erreur lors de l'ajout des colonnes : " . $conn->error;
}

// Fermez la connexion
$conn->close();
?>
