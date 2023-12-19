<?php

if ($_SERVER['HTTP_HOST'] === 'mhemery.fr') {
    $serveur = '185.13.37.244';
    $user = "nina";
    $bdd = "nina";
    $pass = 'bF*#J&tR!77fZ*fCcURZxxJ$&gz3Bk5P$2VrVU';
    $port = 5005;
}else{
    $serveur = '185.13.37.244';
    $user = "ninadev";
    $bdd = "ninadev";
    $pass = '#@g9AC5gqA!8LLxB';
    $port = 5006;
}


try {
    $ERROR = 0;
    $pdo = new PDO ('mysql:host=' . $serveur.':'.$port.';dbname=' . $bdd . ';charset=utf8', $user, $pass);
}
catch(PDOException $e)
{
    $ERROR = 1;
    $_SESSION['error']['bdd'] = $e->getMessage();
}