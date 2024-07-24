<?php
require '../base/nexus_base.php';

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
