<?php
class SalesExecutive {
    private $conn;
    public function __construct($conn){ $this->conn = $conn; }

    public function findByEmail($email) {
        $stmt = $this->conn->prepare("SELECT id, name, email, phone, password FROM sales_executives WHERE email=? LIMIT 1");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT id, name, email, phone, password FROM sales_executives WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
