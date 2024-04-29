<?php

class Connection {
public $connection;
private $host = "localhost";
private $database = "supplies-db";
private $username = "root";
private $password = "";
private $charset = 'utf8mb4';
private $options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];


public function __construct() {
    $dsn = "mysql:host={$this->host};dbname={$this->database};charset={$this->charset}";
    
    $this->connection = new PDO($dsn, $this->username, $this->password, $this->options);

    }
}


