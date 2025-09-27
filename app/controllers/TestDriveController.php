<?php
// app/controllers/TestDriveController.php
require_once __DIR__ . "/../models/TestDrive.php";

class TestDriveController {
    private $model;
    private $conn;

    public function __construct($conn) {
        $this->conn  = $conn;
        $this->model = new TestDrive($conn);
    }

    // POST / testdrives/store
    public function store(){
        if (!csrf_verify($_POST['_csrf'] ?? '')) { die("CSRF failed"); }
        if (empty($_SESSION['customer_id'])) { http_response_code(401); echo "Login required"; return; }

        $customerId = (int)$_SESSION['customer_id'];
        $unitId     = (int)($_POST['unit_id'] ?? 0);
        $raw        = trim($_POST['preferred_datetime'] ?? ''); // e.g. "2025-09-26T14:30"
        $notes      = $_POST['notes'] ?? null;

        if (!$unitId || $raw === '') { http_response_code(400); echo "Missing data"; return; }

        // Normalize HTML5 datetime-local -> MySQL DATETIME
        $mysqlDT = null;

        // 1) Try "Y-m-d\TH:i" (no seconds)
        $dt = DateTime::createFromFormat('Y-m-d\TH:i', $raw);
        if ($dt instanceof DateTime) {
            $mysqlDT = $dt->format('Y-m-d H:i:s');
        } else {
            // 2) Try "Y-m-d H:i"
            $dt = DateTime::createFromFormat('Y-m-d H:i', $raw);
            if ($dt instanceof DateTime) {
                $mysqlDT = $dt->format('Y-m-d H:i:s');
            } else {
                // 3) Try with seconds ("Y-m-d\TH:i:s" or "Y-m-d H:i:s")
                $dt = DateTime::createFromFormat('Y-m-d\TH:i:s', $raw)
                   ?: DateTime::createFromFormat('Y-m-d H:i:s', $raw);
                if ($dt instanceof DateTime) {
                    $mysqlDT = $dt->format('Y-m-d H:i:s');
                }
            }
        }

        if (!$mysqlDT) {
            http_response_code(400);
            echo "Invalid datetime format";
            return;
        }

        // Save
        $newId = $this->model->create($customerId, $unitId, $mysqlDT, $notes);
        if ($newId === false) {
            http_response_code(500);
            echo "Failed to create test drive";
            return;
        }

        header("Location: index.php?route=testdrives/my");
        exit;
    }

    // GET / testdrives/my
    public function myList(){
        $customerId = (int)$_SESSION['customer_id'];
        $rows = $this->model->listByCustomer($customerId);
        include __DIR__ . "/../views/testdrives/my.php";
    }

    // POST / testdrives/cancel
    public function cancel(){
        if (!csrf_verify($_POST['_csrf'] ?? '')) { die("CSRF failed"); }
        if (empty($_SESSION['customer_id'])) { http_response_code(401); echo "Login required"; return; }

        $customerId = (int)$_SESSION['customer_id'];
        $id         = (int)($_POST['id'] ?? 0);
        if (!$id) { http_response_code(400); echo "Missing id"; return; }

        $ok = $this->model->cancelByCustomer($id, $customerId);
        header("Location: index.php?route=testdrives/my");
        exit;
    }
}
