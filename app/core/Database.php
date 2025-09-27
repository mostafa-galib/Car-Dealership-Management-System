<?php
class Database {
    private $conn;
    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "cds");
        $this->conn->set_charset("utf8mb4");
    }
    public function getConnection() {
        return $this->conn;
    }
}
