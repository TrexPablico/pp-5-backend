<?php

require_once "./database.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

class Inventory {
    public $product_id;
    public $quantity_in_stock;
    public $product_name;
    public $branch_id;

    public static function getAll() {
        $db = new Connection();
        $stmt = $db->connection->prepare("SELECT * FROM inventory");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, "Inventory");
    }
}

$products = Inventory::getAll();

echo json_encode($products);