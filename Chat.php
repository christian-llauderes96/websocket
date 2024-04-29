<?php
// Chat.php

// namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $pdo;
    protected $userid;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        // Connect to the database
        $dsn = 'mysql:host=localhost;dbname=websockets;charset=utf8mb4';
        $username = 'root';
        $password = '';

        try {
            $this->pdo = new \PDO($dsn, $username, $password);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            die();
        }
    }

    public function onOpen(ConnectionInterface $conn) 
    {
        $queryParams = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryParams, $queryData);
        $token = $queryData['token']; // Assuming authentication token is passed as a query parameter
        $token = str_replace("?","",$token); //tanggalin ?
        // Validate authentication token (pseudo-code)
        $userId = $this->validateAuthToken($token); // This function should validate the token and return the user's ID
        // echo $token;
        // var_dump($userId);
        // exit($userId."id");
        if ($userId) {
            // Authentication successful, associate user ID with connection
            $conn->userId = $userId;
            $this->clients->attach($conn);
            echo "New connection! (User ID: $userId)\n";
        } else {
            // Authentication failed, close the connection
            echo "Authentication failed\n";
            $conn->close();
        }
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        try {
            // Decode the JSON data received from the client
            $data = json_decode($msg, true);
    
            // json data
            $message = $data['message'];
            $uid = $data['uid']; //pwede din to pero include mo sa request
            // $uid = $from->user_id; // instance ng original sender
            $uidto = $data['uidto'];
    
            // Save the message to the database
            $stmt = $this->pdo->prepare("INSERT INTO w_chats (`u_from`, `u_to`, `u_msg`) VALUES (?, ?, ?)");
            $stmt->execute([$uid, $uidto, $message]);
        } catch (PDOException $e) {
            // Handle database error
            error_log('Database error: ' . $e->getMessage());
            // Send an error response to the client
            $from->send('Database error: ' . $e->getMessage());
            return; // Exit the method to prevent further processing
        }
    
        // If the database operation was successful, send the message to all clients
        // foreach ($this->clients as $client) {
        //     if ($client !== $from) {
        //         $client->send($msg);
        //     }
        // }
        // Send the message only to the recipient client (identified by $uidto)
        foreach ($this->clients as $client) {
            // Check if the client's UID matches the recipient UID
            if ($client !== $from && $client->userId === $uidto) {
                $client->send($msg);
                break; // stop loop kung nasend na sa kausap
            }
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

    protected function validateAuthToken($token) {
        try {
            // Prepare and execute the query to check if the token exists
            $stmt = $this->pdo->prepare("SELECT `id` FROM w_users WHERE u_token = ?");
            $stmt->execute([$token]);
    
            // If a row is found, return the user ID associated with the token
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['id'];
            } else {
                // Token not found or expired
                return false;
            }
        } catch (PDOException $e) {
            // Handle database connection error
            error_log('Database connection failed: ' . $e->getMessage());
            return false;
        }
    }
}

