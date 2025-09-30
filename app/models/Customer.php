<?php
class Customer {
    private $conn;
    public function __construct($conn){ $this->conn = $conn; }

    public function findByEmail($email) {
        $stmt = $this->conn->prepare("SELECT id, name, email, phone, password FROM customers WHERE email=? LIMIT 1");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT id, name, email, phone, password FROM customers WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($name, $email, $phone, $passwordPlain) {
        $stmt = $this->conn->prepare("INSERT INTO customers (name,email,phone,password) VALUES (?,?,?,?)");
        $stmt->bind_param('ssss', $name, $email, $phone, $passwordPlain);
        return $stmt->execute();
    }

    
}
