<?php

require __DIR__ . "/../vendor/autoload.php";

use MyWebSocketsApp\MySocketsData;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$server = IoServer::factory(new HttpServer(new WsServer(new MySocketsData)), 8080);

$server->run();

?>
