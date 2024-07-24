<?php
function updateDataPDO($tableName, $data, $pdo, $condition)
{
    try {
        // Définir le mode d'erreur PDO sur exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête SQL pour la mise à jour des données
        $sql = "UPDATE $tableName SET ";

        // Construction de la liste des colonnes à mettre à jour
        $columnsToUpdate = array_keys($data);
        $updateString = implode(' = ?, ', $columnsToUpdate) . ' = ?';
        $sql .= $updateString;

        // Ajout de la condition WHERE à la requête SQL
        $sql .= " WHERE $condition";

        // Préparation de la requête SQL
        $stmt = $pdo->prepare($sql);

        // Exécution de la requête avec les valeurs des données
        $stmt->execute(array_values($data));

        logMessage($pdo, 'INFO', 'Mise à jour de la table: '.$tableName.' réussi.', getUserIdentifiant()); // Username will be 'système'
        return "succes";
    } catch (PDOException $e) {
        logMessage($pdo, 'ERROR', 'Echec de la mise à jour de la table: '.$tableName.' réussi. || SQL ERROR: '.$e->getMessage(), getUserIdentifiant());
        return "Erreur lors de la mise à jour des données dans la table $tableName : " . $e->getMessage();
    }
}

// // Exemple d'utilisation :
// $tableName = 'ma_table';
// $data = [
//     'colonne1' => 'nouvelle_valeur1',
//     'colonne2' => 'nouvelle_valeur2',
//     // Ajoutez autant de colonnes et de nouvelles valeurs que nécessaire
// ];
// $condition = 'id = ?'; // Ajoutez la condition pour la mise à jour, par exemple, 'id = ?' ou 'nom = ?'

// // Utilisation de la fonction pour mettre à jour les données
// updateDataPDO($tableName, $data, $pdo, $condition);
