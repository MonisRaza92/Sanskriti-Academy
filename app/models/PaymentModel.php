<?php
require_once __DIR__ . '/../../core/database.php';

class PaymentModel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function insertTransaction($orderId, $amount, $status)
    {
        $stmt = $this->conn->prepare("INSERT INTO payments (order_id, amount, status) VALUES (?, ?, ?)");
        return $stmt->execute([$orderId, $amount, $status]);
    }

    public function updateTransaction($orderId, $status)
    {
        $stmt = $this->conn->prepare("UPDATE payments SET status = ? WHERE order_id = ?");
        return $stmt->execute([$status, $orderId]);
    }

    public function getTransaction($orderId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM payments WHERE order_id = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
