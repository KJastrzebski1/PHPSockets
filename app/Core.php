<?php
namespace App;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Chat;
$conf = include("conf.php");
$server = IoServer::factory(new HttpServer(new WsServer(new Chat())),$conf["port"]);

 // $server = IoServer::factory(new Chat(),80);
$server->run();

