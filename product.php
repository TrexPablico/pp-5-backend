<?php

require_once "./database.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json');

class Product {
    public $product_id;
    public $product_name;

    public static function getAll() {
        $db = new Connection();
        $stmt = $db->connection->prepare("SELECT * FROM product");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, "Product");
    }
}

$products = Product::getAll();

echo json_encode($products);