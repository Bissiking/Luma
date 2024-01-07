<?php
function isNodeModulesPresent($directoryPath) {
    $nodeModulesPath = rtrim($directoryPath, '/') . '/node_modules';
    return is_dir($nodeModulesPath);
}

function installDependencies($directoryPath) {
    // Exécuter la commande npm install
    $output = [];
    $returnCode = 0;
    exec("cd $directoryPath && npm install", $output, $returnCode);

    // Vérifier le code de retour
    if ($returnCode === 0) {
        echo 'Les dépendances ont été installées avec succès.';
    } else {
        echo 'Erreur lors de l\'installation des dépendances.';
        // Afficher la sortie de la commande pour le débogage
        echo implode(PHP_EOL, $output);
    }
}

$directoryToCheck = '/chemin/vers/votre/repertoire';

if (isNodeModulesPresent($directoryToCheck)) {
    echo 'Le dossier node_modules est présent dans le répertoire.';
    StartSonde();
} else {
    echo 'Le dossier node_modules n\'est pas présent dans le répertoire.';
    // Vérifier la présence du fichier package.json
    if (file_exists("$directoryToCheck/package.json")) {
        // Le fichier package.json est présent, installer les dépendances
        installDependencies($directoryToCheck);
        StartSonde();
    } else {
        echo 'Le fichier package.json n\'est pas présent. Impossible d\'installer les dépendances.';
    }
}

function StartSonde(){
    // start_sonde.php
    shell_exec('node ./sonde.js > /dev/null 2>&1 &');
    echo 'Sonde démarrée';
}
function StopSonde(){
    // stop_sonde.php
    shell_exec('pkill -f "node /sonde.js"');
    echo 'Sonde arrêtée';
}

?>
