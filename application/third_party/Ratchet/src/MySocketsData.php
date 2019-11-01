<?php

namespace MyWebSocketsApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class MySocketsData implements MessageComponentInterface {

    public $clients;
    private $subscriptions;
    private $users;
    private $uids;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->subscriptions = [];
        $this->users = [];
         $this->uids = [];
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        $this->users[$conn->resourceId] = $conn;
        echo 'User ' . $conn->resourceId . ' Connected ' . "\n";
    }

    public function onMessage(ConnectionInterface $conn, $msg) {
        $data = json_decode($msg);
        switch ($data->command) {
            case "subscribe":
                $this->subscriptions[$conn->resourceId] = $data->channel;
                $this->uids[$conn->resourceId] = $data->user;
                echo 'User ' . $conn->resourceId . ' subscribed to channel ' . $data->channel . "\n";
                break;
            case "message":
                if (isset($this->subscriptions[$conn->resourceId])) {
                    $target = $this->subscriptions[$conn->resourceId];
                    foreach ($this->subscriptions as $id => $channel) {
                        if ($channel == $target && $id != $conn->resourceId) {
                            $this->users[$id]->send($data->message);
                        }
                    }
                }
                break;
            case "ping":
                foreach ($this->subscriptions as $id => $channel) {
                    $url = 'http://localhost/exchange/api/fetchsymboldata/' . $channel . '/' . $this->uids[$id];
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $curl_scraped_page = curl_exec($ch);
                    curl_close($ch);
                    $response = json_decode($curl_scraped_page, true);
                    $this->users[$id]->send(json_encode($response));
                }
                break;
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        unset($this->users[$conn->resourceId]);
        unset($this->subscriptions[$conn->resourceId]);
        echo "Connection Closed by $conn->resourceId \n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

}
