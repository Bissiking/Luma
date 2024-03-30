<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    extract($_REQUEST);
    if (empty($_REQUEST)) {
        echo 'EMPTY';
        exit;
    }

    require './lib/mysql_table_update.php';
    $tableName = 'luma_users';

    // Utilisation de la fonction pour mettre à jour les données
    $condition = 'id = '.$_SESSION['authentification']['user']['id'];
    $PDOResult = updateDataPDO($tableName, $_REQUEST, $pdo, $condition);


    $v = array('id' => $_SESSION['authentification']['user']['id']);
        $sql = 'SELECT * FROM luma_users WHERE id = :id';
        $req = $pdo->prepare($sql);
        $req->execute($v);
        $result = $req->rowCount();
    if ($result == 1) {
        foreach($req as $user){}
        $_SESSION['authentification']['user'] = $user;
        echo $PDOResult;
    }else{
        echo 'ERROR UPDATE SESSION';
    }

    
}