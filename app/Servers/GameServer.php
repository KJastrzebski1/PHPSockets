<?php
namespace App\Server;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Game;
$conf = include("conf.php");
$serverGame = IoServer::factory(new HttpServer(new WsServer(new Game())), $conf["port"]);

$serverGame->run();