<?php
function createTablePDO($servername, $username, $password, $dbname, $tableName, $columns) {
    try {
        // Connexion à la base de donnée
        require './base/nexus_base.php';
        
        // Définir le mode d'erreur PDO sur exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Requête SQL pour créer une table
        $sql = "CREATE TABLE $tableName (";
        
        foreach ($columns as $columnName => $columnDefinition) {
            $sql .= "$columnName $columnDefinition, ";
        }

        $sql = rtrim($sql, ", "); // Supprimer la virgule finale
        $sql .= ")";

        // Utiliser exec() car aucune valeur de retour attendue
        $conn->exec($sql);
        
        echo "La table $tableName a été créée avec succès.";
    } catch (PDOException $e) {
        echo "Erreur lors de la création de la table $tableName : " . $e->getMessage();
    }

    // Fermer la connexion
    $conn = null;
}


// Exemple d'utilisation
$tableName = "users";
$columns = [
    'id' => 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
    'firstname' => 'VARCHAR(30) NOT NULL',
    'lastname' => 'VARCHAR(30) NOT NULL',
    'email' => 'VARCHAR(50) NOT NULL',
    'reg_date' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
];

createTablePDO($servername, $username, $password, $dbname, $tableName, $columns);
?>
