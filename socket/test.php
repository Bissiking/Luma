<?php
// Configuration
$host = '192.168.1.200'; // Adresse IP du serveur
$port = 12345; // Port du serveur

require '../base/nexus_base.php';

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

// Fonction pour vérifier le token dans la base de données
function verify_token($pdo, $token)
{
    try {
        $v = array('uuid_agent' => $token);
        $sql = "SELECT * FROM luma_agent WHERE uuid_agent = :uuid_agent";
        $req = $pdo->prepare($sql);
        $req->execute($v);
        return $req->rowCount() > 0;
    } catch (PDOException $e) {
        echo "Erreur lors de la vérification du token : " . $e->getMessage() . "\n";
        return false;
    }
}

// Fonction pour mettre à jour le statut de l'agent dans la base de données
function update_agent_agent_etat($pdo, $token, $agent_etat)
{
    try {
        $v = array('uuid_agent' => $token, 'agent_etat' => $agent_etat);
        $sql = "UPDATE luma_agent SET agent_etat = :agent_etat WHERE uuid_agent = :uuid_agent";
        $req = $pdo->prepare($sql);
        $req->execute($v);
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour du statut : " . $e->getMessage() . "\n";
    }
}

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
    foreach ($read_socks as $sock) {
        if ($sock === $sock) {
            // Nouvelle connexion entrante
            $new_client = socket_accept($sock);
            if ($new_client) {
                echo "Nouvelle connexion acceptée\n";
                $clients[] = $new_client;
            }
        } else {
            // Données reçues d'un client existant
            $input = socket_read($sock, 1024, PHP_NORMAL_READ);
            if ($input === false || $input === '') {
                // Le client s'est déconnecté
                $uuid_agent = $agents[(int)$sock];
                update_agent_agent_etat($pdo, $uuid_agent, 0); // Mise à jour à "disconnected" (0)
                echo "Client déconnecté. ID: $uuid_agent\n";
                unset($clients[array_search($sock, $clients)]);
                unset($agents[(int)$sock]);
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
    }
}

// Fermer le socket du serveur
socket_close($sock);
?>
