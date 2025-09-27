<?php
class SalesQuotationController {
    public function __construct($conn){ /* store $conn later for DB ops */ }
    public function index(){
        include __DIR__ . "/../views/sales/quotations/index.php";
    }
}
