<?php

require_once "./database.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json');

class Branch {
    public $branch_id;
    public $branch_name;
    public $branch_location;
}

$db = new Connection();

$stmt = $db->connection->prepare("SELECT * FROM branch");
$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_CLASS, "Branch");

 echo json_encode($data);