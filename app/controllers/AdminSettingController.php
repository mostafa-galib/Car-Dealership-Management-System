<?php
require_once __DIR__ . "/../models/Setting.php";

class AdminSettingController {
    private $model;
    public function __construct($conn){ $this->model = new Setting($conn); }

    public function index(){
        Auth::requireLogin('admin');
        $rows = $this->model->getAll();
        include __DIR__ . "/../views/admin/settings/index.php";
    }

    public function save(){
        Auth::requireLogin('admin');
        if (!csrf_verify($_POST['_csrf'] ?? '')) { die("CSRF failed"); }

        // expected inputs
        $tax   = trim($_POST['default_tax_rate'] ?? '');
        $hours = (int)($_POST['reservation_hold_hours'] ?? 0);

        if ($tax !== '') {
            $this->model->set('default_tax_rate', $tax);
        }
        if ($hours > 0){
            $this->model->setHoldHours($hours);
        }

        header("Location: index.php?route=admin/settings");
        exit;
    }
}
