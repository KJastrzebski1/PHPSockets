<?php
namespace App;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Chat;

$server = IoServer::factory(new HttpServer(new WsServer(new Chat())), 8080);

 // $server = IoServer::factory(new Chat(),80);
$server->run();

