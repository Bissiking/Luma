<?php

function genererMotDePasse($longueur = 12) {
    // Caractères possibles dans le mot de passe
    $caracteresPossibles = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+';

    // Mélanger les caractères
    $caracteresMelanges = str_shuffle($caracteresPossibles);

    // Extraire la partie du mot de passe avec la longueur spécifiée
    $motDePasse = substr($caracteresMelanges, 0, $longueur);

    return $motDePasse;
}