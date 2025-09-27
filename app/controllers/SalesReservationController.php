<?php
// app/controllers/SalesReservationController.php
require_once __DIR__ . '/../models/Reservation.php';

class SalesReservationController {
    private $model;

    public function __construct($conn){
        $this->model = new Reservation($conn);
    }

    // GET / sales/reservations
    public function index(){
        $rows = $this->model->all();  // uses stored hold_expires_at + auto-expire
        include __DIR__ . '/../views/sales/reservations/index.php';
    }

    // POST / sales/reservations/update
    public function update(){
        if (!csrf_verify($_POST['_csrf'] ?? '')) { die("CSRF failed"); }
        $id     = (int)($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? 'pending';
        if ($id <= 0) { http_response_code(400); echo "Missing id"; return; }

        $this->model->updateStatus($id, $status);
        header("Location: index.php?route=sales/reservations");
        exit;
    }
}
