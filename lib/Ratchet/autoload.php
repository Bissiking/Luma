<?php
// Inclure les fichiers de Ratchet
require './lib/Psr/Log/LoggerInterface.php';
require './lib/Psr/Log/NullLogger.php';
require './lib/Psr/Log/AbstractLogger.php';
require './lib/Ratchet/MessageComponentInterface.php';
require './lib/Ratchet/ConnectionInterface.php';
require './lib/Ratchet/ComponentInterface.php';
require './lib/Ratchet/Server/ComponentInterface.php';
require './lib/Ratchet/Server/FlashPolicy.php';
require './lib/Ratchet/Server/IpBlackList.php';
require './lib/Ratchet/Server/IpWhitelist.php';
require './lib/Ratchet/Server/OriginCheck.php';
require './lib/Ratchet/Server/IoServer.php';
require './lib/Ratchet/Server/IoServerInterface.php';
require './lib/Ratchet/Server/IoServerComponentInterface.php';
require './lib/Ratchet/Server/SocketIoServer.php';
require './lib/Ratchet/Server/SocketIoServerInterface.php';
require './lib/Ratchet/Server/SocketIoServerComponentInterface.php';
require './lib/Ratchet/Server/GtkServer.php';
require './lib/Ratchet/Server/GtkServerInterface.php';
require './lib/Ratchet/Server/GtkServerComponentInterface.php';
require './lib/Ratchet/Server/ServerInterface.php';
require './lib/Ratchet/Server/Websocket.php';
require './lib/Ratchet/Server/WebsocketInterface.php';
require './lib/Ratchet/Server/WebsocketComponentInterface.php';
require './lib/Ratchet/Server/WebsocketServer.php';
require './lib/Ratchet/Server/WebsocketServerInterface.php';
require './lib/Ratchet/Wamp/WampServerInterface.php';
require './lib/Ratchet/Wamp/WampServer.php';
require './lib/Ratchet/Wamp/WampConnection.php';
require './lib/Ratchet/Wamp/WampServerComponentInterface.php';
require './lib/Ratchet/Wamp/WampServerProtocol.php';
require './lib/Ratchet/Wamp/WampServerRpcInterface.php';
require './lib/Ratchet/Wamp/Topic.php';
require './lib/Ratchet/Wamp/TopicInterface.php';
require './lib/Ratchet/Wamp/TopicManager.php';
require './lib/Ratchet/Session/SessionProviderInterface.php';
require './lib/Ratchet/Session/SessionInterface.php';
require './lib/Ratchet/Session/Session.php';
require './lib/Ratchet/Session/Serialize/SerializerInterface.php';
require './lib/Ratchet/Session/Serialize/Serialize.php';
require './lib/Ratchet/Session/Serialize/JsonSerializer.php';
require './lib/Ratchet/Session/Serialize/PhpSerializer.php';