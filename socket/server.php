<?php
require 'config_soc.php';
require 'client_handler.php';

// Créer un socket
$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if (!$sock) {
    die("Erreur : " . socket_strerror(socket_last_error()) . "\n");
}

// Lier le socket à l'adresse et au port
if (!socket_bind($sock, $host, $port)) {
    die("Erreur de liaison : " . socket_strerror(socket_last_error($sock)) . "\n");
}

// Mettre le socket en mode écoute
if (!socket_listen($sock, 5)) {
    die("Erreur d'écoute : " . socket_strerror(socket_last_error($sock)) . "\n");
}

echo "Serveur en écoute sur $host:$port\n";

// Initialiser la liste des sockets clients
$clients = [$sock];

// Table de correspondance entre sockets et UUID d'agents
$agents = [];

// Boucle principale pour accepter les connexions entrantes et gérer les clients
while (true) {
    // Préparer les tableaux de sockets pour socket_select
    $read_socks = $clients;
    $write_socks = null;
    $except_socks = null;

    // Attendre une activité sur l'un des sockets
    if (socket_select($read_socks, $write_socks, $except_socks, null) === false) {
        die("Erreur de socket_select : " . socket_strerror(socket_last_error()) . "\n");
    }

    // Parcourir les sockets ayant de l'activité
    foreach ($read_socks as $read_sock) {
        if ($read_sock === $sock) {
            // Nouvelle connexion entrante
            $new_client = socket_accept($sock);
            if ($new_client === false) {
                echo "Erreur lors de l'acceptation d'une nouvelle connexion : " . socket_strerror(socket_last_error($sock)) . "\n";
            } else {
                echo "Nouvelle connexion acceptée\n";
                $clients[] = $new_client;
            }
        } else {
            // Gérer le client existant
            handle_client($read_sock, $pdo, $clients, $agents);
        }
    }
}

// Fermer le socket du serveur
socket_close($sock);
