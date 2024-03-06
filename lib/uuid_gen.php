<?php
function generateUUID() {
    // Générer 16 octets aléatoires
    $bytes = random_bytes(16);

    // Modifier les bits selon la spécification UUID v4
    $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40); // version 4
    $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80); // variant RFC 4122

    // Convertir les octets en format hexadécimal avec des tirets
    $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));

    return $uuid;
}
