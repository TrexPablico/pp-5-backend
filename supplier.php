<?php

require_once "./database.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json');

class Supplier {
    public $supplier_id;
    public $supplier_name;
    public $product_category;
    public $contact_info;
}

function getSupplier() {
    $db = new Connection();

    $stmt = $db->connection->prepare("SELECT * FROM supplier");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_CLASS, "Supplier");
}


$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
    $supplier = getSupplier();
    echo json_encode($supplier);
}