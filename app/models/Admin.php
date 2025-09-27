<?php
class Admin {
    private $conn;
    public function __construct($conn){ $this->conn = $conn; }

    public function findByIdentity($identity) {
        $sql = "SELECT id, username, email, password FROM admins WHERE email=? OR username=? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ss', $identity, $identity);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT id, username, email, password FROM admins WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
