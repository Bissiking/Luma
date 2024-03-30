<?php
function checkRowExistence($tableName, $criteria, $pdo) {
    try {
        // Construction de la requête SQL SELECT avec une clause WHERE
        $sql = "SELECT COUNT(*) FROM $tableName WHERE ";
        $conditions = [];
        foreach ($criteria as $column => $value) {
            $conditions[] = "$column = ?";
        }
        $sql .= implode(' AND ', $conditions);

        // Préparation de la requête SQL
        $stmt = $pdo->prepare($sql);
        
        // Exécution de la requête avec les valeurs des critères
        $stmt->execute(array_values($criteria));
        
        // Récupération du résultat (nombre de lignes correspondant aux critères)
        $rowCount = $stmt->fetchColumn();
        
        // Vérifier si des lignes correspondent aux critères
        return $rowCount > 0; // Retourne true si des lignes correspondent, sinon false
    } catch (PDOException $e) {
        // En cas d'erreur, retourner un message d'erreur
        return "Erreur lors de la vérification de l'existence de la ligne dans la table $tableName : " . $e->getMessage();
    }
}

// Exemple d'utilisation
// $tableName = "users";
// $criteria = [
//     'username' => 'john_doe',
//     'email' => 'john@example.com'
// ];
// $rowExists = checkRowExistence($tableName, $criteria, $pdo);
// if ($rowExists === true) {
//     echo "La ligne correspondant aux critères existe dans la table $tableName.";
// } elseif ($rowExists === false) {
//     echo "Aucune ligne correspondant aux critères n'existe dans la table $tableName.";
// } else {
//     echo $rowExists; // Affiche un message d'erreur
// }
