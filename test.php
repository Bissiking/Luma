<?php

require __DIR__ . '/vendor/autoload.php';

use Discord\Discord;

// Créer une instance de Discord
$discord = new Discord([
    'token' => 'YOUR_DISCORD_BOT_TOKEN',
]);

// Événement 'ready' : le bot est prêt
$discord->on('ready', function ($discord) {
    echo "Bot is ready!", PHP_EOL;

    // Récupérer le canal où envoyer le message
    $channelId = 'YOUR_CHANNEL_ID';
    $channel = $discord->getChannel($channelId);

    // Envoyer le message dans le canal
    $channel->sendMessage('Hello, world!');
});

// Démarrer le bot
$discord->run();
