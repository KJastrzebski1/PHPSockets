<?php
namespace App\Server;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Game;

$serverGame = IoServer::factory(new HttpServer(new WsServer(new Game())), 8080);

$serverGame->run();