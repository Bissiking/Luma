<?php

// Chemin vers le fichier de configuration
$configFilePath = 'chemin/vers/config.php';

// Lire le contenu actuel du fichier
$configContent = file_get_contents($configFilePath);

// Effectuer les modifications nécessaires
$newConfigContent = str_replace(
    "define('DB_HOST', 'ancienne_valeur');",
    "define('DB_HOST', 'nouvelle_valeur');",
    $configContent
);

// Réécrire le fichier avec le nouveau contenu
file_put_contents($configFilePath, $newConfigContent);

echo "Le fichier de configuration a été modifié avec succès.";

?>