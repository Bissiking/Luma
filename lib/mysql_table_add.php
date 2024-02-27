<?php
function insertDataPDO($tableName, $data) {
    try {
        // Connexion à la base de données
        require './base/nexus_base.php';
        
        // Définir le mode d'erreur PDO sur exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Requête SQL pour l'insertion de données
        $sql = "INSERT INTO $tableName (";

        // Construction de la liste des colonnes
        $columns = array_keys($data);
        $sql .= implode(', ', $columns);

        $sql .= ") VALUES (";

        // Construction de la liste des valeurs avec des paramètres de liaison
        $placeholders = array_fill(0, count($columns), '?');
        $sql .= implode(', ', $placeholders);

        $sql .= ")";

        // Préparation de la requête SQL
        $stmt = $conn->prepare($sql);

        // Exécution de la requête avec les valeurs des données
        $stmt->execute(array_values($data));
        
        echo "Les données ont été ajoutées avec succès à la table $tableName.";
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout des données à la table $tableName : " . $e->getMessage();
    }

    // Fermer la connexion
    $conn = null;
}

// $tableName = 'ma_table';
// $data = [
//     'colonne1' => 'valeur1',
//     'colonne2' => 'valeur2',
//     // Ajoutez autant de colonnes et de valeurs que nécessaire
// ];

// insertDataPDO($tableName, $data);