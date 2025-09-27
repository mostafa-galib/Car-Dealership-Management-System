<?php

class SalesDashboardController {
    private $conn;
    public function __construct($conn){ $this->conn = $conn; }

    public function index(){
        $db = $this->conn;

        $pending_reservations = (int)$db->query("SELECT COUNT(*) c FROM reservations WHERE status='pending'")->fetch_assoc()['c'];
        $today_testdrives     = (int)$db->query("
            SELECT COUNT(*) c FROM test_drives
            WHERE DATE(preferred_datetime) = CURDATE()
        ")->fetch_assoc()['c'];
        $upcoming_7_td        = (int)$db->query("
            SELECT COUNT(*) c FROM test_drives
            WHERE preferred_datetime > NOW()
              AND preferred_datetime <= DATE_ADD(NOW(), INTERVAL 7 DAY)
              AND status IN ('pending','approved')
        ")->fetch_assoc()['c'];

        // Upcoming list (next 7 days)
        $upcoming = $db->query("
            SELECT td.*, c.name AS customer_name, u.brand, u.model
            FROM test_drives td
            JOIN customers c ON td.customer_id=c.id
            JOIN car_units u ON td.unit_id=u.id
            WHERE td.preferred_datetime > NOW()
              AND td.preferred_datetime <= DATE_ADD(NOW(), INTERVAL 7 DAY)
              AND td.status IN ('pending','approved')
            ORDER BY td.preferred_datetime ASC
            LIMIT 10
        ");

        // Pending reservations list (latest 10)
        $pending_res_list = $db->query("
            SELECT r.*, c.name AS customer_name, u.brand, u.model
            FROM reservations r
            JOIN customers c ON r.customer_id=c.id
            JOIN car_units u ON r.unit_id=u.id
            WHERE r.status='pending'
            ORDER BY r.created_at DESC
            LIMIT 10
        ");

        include __DIR__ . "/../views/sales/dashboard.php";
    }
}
