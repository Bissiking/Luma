<?php
// require('./base/nexus_base.php');

function getUserIdentifiant() {
    if (isset($_SESSION['authentification']['user']['identifiant'])) {
        return $_SESSION['authentification']['user']['identifiant'];
    } else {
        return 'Non authentifié';
    }
}

function logMessage($pdo, $log_level, $log_message, $username = 'système') {
    $sql = "INSERT INTO luma_logs (log_level, log_message, username) VALUES (:log_level, :log_message, :username)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':log_level', $log_level);
    $stmt->bindParam(':log_message', $log_message);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
}

// // Example usage:
// logMessage($pdo, 'INFO', 'This is an informational message.', 'JohnDoe');
// logMessage($pdo, 'ERROR', 'This is an error message.'); // Username will be 'système'
// logMessage($pdo, 'DEBUG', 'This is a debug message.', 'JaneDoe');
?>
