<?php
require_once __DIR__."/../models/TestDrive.php";

class SalesTestDriveController {
    private $model;
    public function __construct($conn){ $this->model = new TestDrive($conn); }

    public function index(){
        $list = $this->model->all();
        include __DIR__."/../views/sales/testdrives/index.php";
    }

    public function updateStatus(){
        if ($_SERVER['REQUEST_METHOD']==='POST'){
            $id = (int)$_POST['id'];
            $status = $_POST['status'];
            $notes = $_POST['notes'] ?? null;
            $this->model->updateStatus($id,$status,$notes);
            header("Location: index.php?route=sales/testdrives");
        }
    }
}
