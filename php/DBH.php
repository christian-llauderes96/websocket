<?php
date_default_timezone_set("Asia/Manila");

class DBH
{
    private $username = null;
    private $password = null;
    private $dbname = null;
    private $dbhost = null;
    private $con = null; // Store the PDO connection

    function __construct()
    {
        $this->username = "root";
        $this->password = "";
        $this->dbname = "websockets";
        $this->dbhost = "localhost";

        // Create a PDO connection when the DBconnection class is instantiated
        // $this->con = $this->connect();
    }

    protected function connect()
    {
        $dsn = "mysql:host=".$this->dbhost.";dbname=".$this->dbname.";charset=utf8mb4";
        $options = [
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        return new PDO($dsn, $this->username, $this->password, $options);
    }

    public function apiConnect()
    {
        // return $this->con; // Return the existing PDO connection
        return $this->connect();
    }

}

// $cc = new DBH;

// print_r($cc->apiConnect());
// if(mysqli_connect("localhost","root","","websockets")){
// echo "aksdhnkajsd";
// }