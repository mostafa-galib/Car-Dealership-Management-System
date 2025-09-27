<?php
require_once __DIR__ . "/../models/CarUnit.php";
require_once __DIR__ . "/../models/CarImage.php";

class CarUnitController {
    private $car, $img, $conn;
    private $maxCompare = 3; 

    public function __construct($conn){
        $this->conn = $conn;
        $this->car  = new CarUnit($conn);
        $this->img  = new CarImage($conn);
        if (!isset($_SESSION['compare_ids'])) $_SESSION['compare_ids'] = [];
    }

    // Cars list + filters
    public function index() {
        $filters = [
            'brand' => $_GET['brand'] ?? null,
            'fuel'  => $_GET['fuel']  ?? null,
            'trans' => $_GET['trans'] ?? null,
            'pmin'  => (isset($_GET['pmin']) && $_GET['pmin']!=='') ? (float)$_GET['pmin'] : null,
            'pmax'  => (isset($_GET['pmax']) && $_GET['pmax']!=='') ? (float)$_GET['pmax'] : null,
        ];

        $cars = $this->car->all($filters);
        $imgModel = $this->img;
        include __DIR__ . "/../views/cars/list.php";
    }

    // Car details
    public function show($id) {
        $id = (int)$id;
        if (!$id) { http_response_code(400); echo "Missing id"; return; }
        $car = $this->car->find($id);
        if (!$car) { http_response_code(404); echo "Car not found"; return; }
        $cover   = $this->img->cover($id);
        $gallery = $this->img->allByUnit($id);
        include __DIR__ . "/../views/cars/details.php";
    }

    public function compareSelect($prefId = null) {
        if ($prefId) $this->addToCompare((int)$prefId); 

        $q = trim($_GET['q'] ?? '');
        $filters = [];
        if ($q !== '') $filters['brand'] = $q; 
        $carsList = $this->car->all($filters);

        $selectedIds = $_SESSION['compare_ids'];
        $selected = $this->car->findMany($selectedIds);
        $imgModel = $this->img;

        include __DIR__ . "/../views/cars/compare_select.php";
    }

    public function compareAdd() {
        if (!csrf_verify($_POST['_csrf'] ?? '')) { die("CSRF failed"); }
        $id = (int)($_POST['id'] ?? 0);
        $this->addToCompare($id);
        header("Location: index.php?route=cars/compare");
        exit;
    }

    public function compareRemove($id) {
        $id = (int)$id;
        $_SESSION['compare_ids'] = array_values(array_filter($_SESSION['compare_ids'], fn($x)=>$x!=$id));
        header("Location: index.php?route=cars/compare");
        exit;
    }

    public function compareClear() {
        $_SESSION['compare_ids'] = [];
        header("Location: index.php?route=cars/compare");
        exit;
    }

    public function compareShow() {
        $ids = $_SESSION['compare_ids'];
        $cars = $this->car->findMany($ids);
        $imgModel = $this->img;
        include __DIR__ . "/../views/cars/compare_show.php";
    }

    private function addToCompare($id) {
        if (!$id) return;
        if (!in_array($id, $_SESSION['compare_ids'], true)) {
            if (count($_SESSION['compare_ids']) >= $this->maxCompare) {
                array_shift($_SESSION['compare_ids']);
            }
            $_SESSION['compare_ids'][] = $id;
        }
    }
}
