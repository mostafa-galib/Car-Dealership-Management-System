<?php

class AdminDashboardController {
    private $conn;
    public function __construct($conn){ $this->conn = $conn; }

    public function index(){
        $db = $this->conn;

        // Cars
        $cars_total     = (int)$db->query("SELECT COUNT(*) c FROM car_units")->fetch_assoc()['c'];
        $cars_in_stock  = (int)$db->query("SELECT COUNT(*) c FROM car_units WHERE status='in_stock'")->fetch_assoc()['c'];
        $cars_reserved  = (int)$db->query("SELECT COUNT(*) c FROM car_units WHERE status='reserved'")->fetch_assoc()['c'];
        $cars_sold      = (int)$db->query("SELECT COUNT(*) c FROM car_units WHERE status='sold'")->fetch_assoc()['c'];

        // Reservations
        $res_pending    = (int)$db->query("SELECT COUNT(*) c FROM reservations WHERE status='pending'")->fetch_assoc()['c'];
        $res_confirmed  = (int)$db->query("SELECT COUNT(*) c FROM reservations WHERE status='confirmed'")->fetch_assoc()['c'];
        $res_cancelled  = (int)$db->query("SELECT COUNT(*) c FROM reservations WHERE status='cancelled'")->fetch_assoc()['c'];
        $res_expired    = (int)$db->query("SELECT COUNT(*) c FROM reservations WHERE status='expired'")->fetch_assoc()['c'];

        // Test drives
        $td_pending     = (int)$db->query("SELECT COUNT(*) c FROM test_drives WHERE status='pending'")->fetch_assoc()['c'];
        $td_approved    = (int)$db->query("SELECT COUNT(*) c FROM test_drives WHERE status='approved'")->fetch_assoc()['c'];
        $td_completed   = (int)$db->query("SELECT COUNT(*) c FROM test_drives WHERE status='completed'")->fetch_assoc()['c'];
        $td_cancelled   = (int)$db->query("SELECT COUNT(*) c FROM test_drives WHERE status='cancelled'")->fetch_assoc()['c'];

        // Latest 6 reservations (any status)
        $latest_res = $db->query("
            SELECT r.*, c.name AS customer_name, u.brand, u.model
            FROM reservations r
            JOIN customers c ON r.customer_id=c.id
            JOIN car_units u ON r.unit_id=u.id
            ORDER BY r.created_at DESC
            LIMIT 6
        ");

        // Next 6 upcoming test drives
        $upcoming_td = $db->query("
            SELECT td.*, c.name AS customer_name, u.brand, u.model
            FROM test_drives td
            JOIN customers c ON td.customer_id=c.id
            JOIN car_units u ON td.unit_id=u.id
            WHERE td.preferred_datetime >= NOW() AND td.status IN ('pending','approved')
            ORDER BY td.preferred_datetime ASC
            LIMIT 6
        ");

        include __DIR__ . "/../views/admin/dashboard.php";
    }
}
