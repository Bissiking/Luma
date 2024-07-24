<?php
function createTablePDO($tableName, $columns, $pdo) {
    try {       
        // Définir le mode d'erreur PDO sur exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Requête SQL pour créer une table avec le moteur InnoDB
        $sql = "CREATE TABLE $tableName (";
        
        foreach ($columns as $columnName => $columnDefinition) {
            $sql .= "$columnName $columnDefinition, ";
        }

        $sql = rtrim($sql, ", "); // Supprimer la virgule finale
        $sql .= ") ENGINE=InnoDB"; // Spécifier le moteur InnoDB

        // Utiliser exec() car aucune valeur de retour attendue
        $pdo->exec($sql);

        return "";
    } catch (PDOException $e) {
        return "Erreur lors de la création de la table $tableName : " . $e->getMessage();
    }
}



// Exemple d'utilisation
// $tableName = "users";
// $columns = [
//     'id' => 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
//     'firstname' => 'VARCHAR(30) NOT NULL',
//     'lastname' => 'VARCHAR(30) NOT NULL',
//     'email' => 'VARCHAR(50) NOT NULL',
//     'reg_date' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
// ];

// createTablePDO($tableName, $columns);