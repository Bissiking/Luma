<?php
// Fonction pour obtenir l'utilisation du CPU (compatible avec Windows et Linux)
function getCPUUsage() {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        // Windows
        $cpuUsage = shell_exec('wmic cpu get loadpercentage');
    } else {
        // Linux
        $cpuUsage = shell_exec('top -bn 1 | grep "Cpu(s)" | sed "s/.*, *\([0-9.]*\)%* id.*/\1/"');
    }

    return $cpuUsage;
}

// Fonction pour obtenir l'utilisation de la RAM (compatible avec Windows et Linux)
function getRAMUsage() {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        // Windows
        $ramUsage = shell_exec('systeminfo | find "Available Physical Memory"');
    } else {
        // Linux
        $ramUsage = shell_exec('free -m | awk \'/Mem:/ {print $3}\'');
    }

    return $ramUsage;
}

// Affichage des informations
echo "Utilisation du CPU : " . getCPUUsage();
echo "<br>Utilisation de la RAM : " . getRAMUsage();
?>
