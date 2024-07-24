<?php
require 'database.php';

function handle_client($sock, $pdo, &$clients, &$agents)
{
    $input = socket_read($sock, 1024, PHP_NORMAL_READ);
    if ($input === false) {
        // Le client s'est déconnecté
        $uuid_agent = isset($agents[(int)$sock]) ? $agents[(int)$sock] : 'Inconnu';
        if (isset($agents[(int)$sock])) {
            update_agent_agent_etat($pdo, $uuid_agent, 0); // Mise à jour à "disconnected" (0)
            unset($agents[(int)$sock]);
        }
        echo "Client déconnecté. ID: $uuid_agent\n";
        unset($clients[array_search($sock, $clients)]);
        socket_close($sock);
    } else {
        $input = trim($input);
        echo "Token reçu : $input\n";

        // Vérifier le token reçu
        if (!isset($agents[(int)$sock]) && verify_token($pdo, $input)) {
            $output = "Authentification réussie!";
            socket_write($sock, $output, strlen($output));

            // Stocker l'UUID de l'agent pour la mise à jour du statut
            $uuid_agent = $input;
            $agents[(int)$sock] = $uuid_agent;

            // Mettre à jour le statut à "connected" (1)
            update_agent_agent_etat($pdo, $uuid_agent, 1);
        } elseif (isset($agents[(int)$sock])) {
            // Traitez le message reçu du client
            echo "Message reçu : $input\n";
            $output = "Message reçu: $input";
            socket_write($sock, $output, strlen($output));
        } else {
            $output = "Échec de l'authentification!";
            socket_write($sock, $output, strlen($output));
            socket_close($sock);
            unset($clients[array_search($sock, $clients)]);
        }
    }
}
