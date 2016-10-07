<?php

namespace App;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {

    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);

        echo "{$conn->resourceId} connected.\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
                , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
        $emojis = scandir("public/img/");
        foreach ($emojis as $emot) {
            
            if(strlen($emot)<3) continue;
            
            $name = explode('.', $emot);
            if (strpos($msg, $name[0]." ") !== false || strpos($msg, $name[0]) == strlen($msg)-  strlen($name[0])) {
                $msg = str_replace($name[0], "<img class=\"emoji\" src=\"public/img/{$emot}\">", $msg);
            }
        }

        foreach ($this->clients as $client) {
            // if ($from !== $client) {
            // The sender is not the receiver, send to each client connected

            $client->send($msg);
            //}
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

}
