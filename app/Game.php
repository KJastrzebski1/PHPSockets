<?php

namespace App;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Game implements MessageComponentInterface {

    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage();
        echo round(microtime(true) * 1000);
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        
        echo "G: {$conn->resourceId} connected.\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        $playerPos = json_decode($msg);

        @$playerPos->id = $from->resourceId; //Creating object from empty value
        @$playerPos->timestamp = round(microtime(true) * 1000);
        foreach ($this->clients as $client) {
            //if ($from !== $client) {
            // The sender is not the receiver, send to each client connected

            $client->send(json_encode($playerPos));
            //}
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);

        echo "G: Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "G: An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

}
