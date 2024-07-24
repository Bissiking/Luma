<?php
function insertDataPDO($tableName, $data, $pdo)
{
    try {

        // Définir le mode d'erreur PDO sur exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
        $stmt = $pdo->prepare($sql);

        // Exécution de la requête avec les valeurs des données
        $stmt->execute(array_values($data));

        logMessage($pdo, 'ERROR', 'Ajout de données à la table: '.$tableName.' effectué', getUserIdentifiant());

        return "succes";
    } catch (PDOException $e) {
        logMessage($pdo, 'ERROR', 'Echec d\'ajout de données à la table: '.$tableName.' || Erreur SQL: '.$e->getMessage(), getUserIdentifiant());
        return "Erreur lors de l'ajout des données à la table $tableName : " . $e->getMessage();
        
    }
}

// $tableName = 'ma_table';
// $data = [
//     'colonne1' => 'valeur1',
//     'colonne2' => 'valeur2',
//     // Ajoutez autant de colonnes et de valeurs que nécessaire
// ];

// insertDataPDO($tableName, $data);