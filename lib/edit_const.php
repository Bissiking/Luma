<?php
function ConstEdit($NAME_CONST, $NEW_CONST)
{
    // Le nom du fichier à modifier
    $nomFichier = '../../base/config.php';
    // Lire le contenu du fichier
    $contenuFichier = file_get_contents($nomFichier);
    // Effectuer la modification souhaitée
    $contenuModifie = str_replace(
        "define('$NAME_CONST', '".constant($NAME_CONST)."');",
        "define('$NAME_CONST', '$NEW_CONST');",
        $contenuFichier
    );

    echo $NAME_CONST;
    echo $NEW_CONST;
    // Écrire le nouveau contenu dans le fichier
    file_put_contents($nomFichier, $contenuModifie);
}