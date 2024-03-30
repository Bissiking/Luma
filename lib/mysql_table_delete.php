<?php
function deleteDataPDO($tableName, $condition, $pdo)
{
    try {
        // Définir le mode d'erreur PDO sur exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête SQL pour la suppression de données
        $sql = "DELETE FROM $tableName WHERE $condition LIMIT 1";

        // Préparation de la requête SQL
        $stmt = $pdo->prepare($sql);

        // Exécution de la requête
        $stmt->execute();

        return "succes";
    } catch (PDOException $e) {
        return "Erreur lors de la suppression des données de la table $tableName : " . $e->getMessage();
    }
}

// Utilisation de la fonction deleteDataPDO
// $tableName = 'ma_table';
// $condition = 'id = ?'; // Condition de suppression, par exemple : 'id = ?' où ? est remplacé par la valeur de l'identifiant à supprimer
// $data = [1]; // Valeur de l'identifiant à supprimer

// deleteDataPDO($tableName, $condition, $pdo);
