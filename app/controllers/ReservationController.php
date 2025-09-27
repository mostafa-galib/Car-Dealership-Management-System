<?php
require_once __DIR__ . "/../models/Reservation.php";

class ReservationController {
    private $model;
    public function __construct($conn){ $this->model=new Reservation($conn); }

    public function store(){
        if (!csrf_verify($_POST['_csrf'] ?? '')) die("CSRF failed");
        $customerId = (int)$_SESSION['customer_id'];
        $unitId = (int)$_POST['unit_id'];
        $type   = $_POST['reservation_type'] ?? 'purchase_hold';
        $amt    = isset($_POST['booking_amount']) ? (float)$_POST['booking_amount'] : 0.0;

        if ($unitId <= 0) { http_response_code(400); echo "Missing unit"; return; }
        if ($amt < 0)     { http_response_code(400); echo "Invalid amount"; return; }

        $this->model->create($customerId,$unitId,$type,$amt);
        header("Location: index.php?route=reservations/my"); exit;
    }
   
    public function myList(){
        $rows = $this->model->listByCustomer((int)$_SESSION['customer_id']);
        include __DIR__."/../views/reservations/my.php";
    }

    public function cancel(){
        if (!csrf_verify($_POST['_csrf'] ?? '')) die("CSRF failed");
        $this->model->cancelByCustomer((int)$_POST['id'],(int)$_SESSION['customer_id']);
        header("Location: index.php?route=reservations/my"); exit;
    }
}
