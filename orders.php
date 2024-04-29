<?php

require_once "./database.php";

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

class Orders {
    public $order_id;
    public $quantity_to_deliver;
    public $product_name;
    public $branch_id;
    public $supplier_id;

    public static function getOrders() {
        $db = new Connection();
        $stmt = $db->connection->prepare("SELECT * FROM orders");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, "Orders");
    }


    // pag add ng order
    public static function addOrder($quantity_to_deliver, $product_name, $branch_id, $supplier_id) {
        $db = new Connection();
    
        // Add order sa the orders table
        $order_stmt = $db->connection->prepare("INSERT INTO orders (quantity_to_deliver, product_name, branch_id, supplier_id) VALUES (?, ?, ?, ?)");
        $order_stmt->execute([$quantity_to_deliver, $product_name, $branch_id, $supplier_id]);
        $order_id = $db->connection->lastInsertId(); 
    
        // update inventory
        $update_stmt = $db->connection->prepare("UPDATE inventory SET quantity_in_stock = quantity_in_stock + ? WHERE product_name = ? AND branch_id = ?");
        $update_stmt->execute([$quantity_to_deliver, $product_name, $branch_id]);
    
        return $order_id; 
    }

    //pag delete ng order
    public static function deleteOrder($order_id) {
        $db = new Connection();
        $stmt = $db->connection->prepare("DELETE FROM orders WHERE order_id = ?");
        $stmt->execute([$order_id]);

        return $stmt->rowCount();
    }

    
}


$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
    $orders = Orders::getOrders();
    echo json_encode($orders);
} else if ($method === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $order_id = Orders::addOrder($data['quantity_to_deliver'], $data['product_name'], $data['branch_id'], $data['supplier_id']);
    echo json_encode(array("order_id" => $order_id));
} else if ($method === "DELETE") {
    $data = json_decode(file_get_contents("php://input"), true);
    $deletedRows = Orders::deleteOrder($data['order_id']);
    echo json_encode(array("deleted_rows" => $deletedRows));
}