<?php
require_once __DIR__ . "/../models/CarUnit.php";
require_once __DIR__ . "/../models/CarImage.php";

class AdminCarController {
    private $car, $img, $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->car  = new CarUnit($conn);
        $this->img  = new CarImage($conn);
    }

    // -------- Cars --------
    public function index() {
        $cars = $this->car->all();
        include __DIR__ . "/../views/admin/cars/index.php";
    }

    public function create() {
        include __DIR__ . "/../views/admin/cars/create.php";
    }

    public function store() {
        if (!csrf_verify($_POST['_csrf'] ?? '')) { die("CSRF failed"); }
        $this->car->create($_POST);
        header("Location: index.php?route=admin/cars"); exit;
    }

    public function edit($id) {
        $id = (int)$id;
        if (!$id) { http_response_code(400); echo "Missing id"; return; }
        $car = $this->car->find($id);
        if (!$car) { http_response_code(404); echo "Car not found"; return; }
        $images = $this->img->allByUnit($id);
        include __DIR__ . "/../views/admin/cars/edit.php";
    }

    public function update($id) {
        if (!csrf_verify($_POST['_csrf'] ?? '')) { die("CSRF failed"); }
        $id = (int)$id;
        if (!$id) { http_response_code(400); echo "Missing id"; return; }
        $this->car->update($id, $_POST);
        header("Location: index.php?route=admin/cars"); exit;
    }

    public function delete($id) {
        $id = (int)$id;
        if (!$id) { http_response_code(400); echo "Missing id"; return; }
        $this->car->delete($id);
        header("Location: index.php?route=admin/cars"); exit;
    }

    // -------- Images --------
    public function uploadImage() {
        if (!csrf_verify($_POST['_csrf'] ?? '')) { die("CSRF failed"); }
        $unitId = (int)($_POST['unit_id'] ?? 0);
        if (!$unitId) { http_response_code(400); echo "Missing unit id"; return; }
        if (empty($_FILES['image']['name'])) { http_response_code(400); echo "No file"; return; }

        $allowed = ['image/jpeg','image/png','image/webp','image/gif'];
        $f = $_FILES['image'];
        if ($f['error'] !== UPLOAD_ERR_OK) { http_response_code(400); echo "Upload error"; return; }

        $mime = mime_content_type($f['tmp_name']);
        if (!in_array($mime, $allowed, true)) { http_response_code(400); echo "Invalid file type"; return; }

        $destDir = realpath(__DIR__ . '/../../public') . '/uploads/cars';
        if (!is_dir($destDir)) { @mkdir($destDir, 0777, true); }

        $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
        $basename = 'car_' . $unitId . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        $destPath = $destDir . '/' . $basename;

        if (!move_uploaded_file($f['tmp_name'], $destPath)) {
            http_response_code(500); echo "Failed to move file"; return;
        }

        // next sort
        $stmt = $this->conn->prepare("SELECT COALESCE(MAX(sort_order),0)+1 AS next_sort FROM car_images WHERE unit_id=?");
        $stmt->bind_param('i',$unitId);
        $stmt->execute();
        $nextSort = (int)($stmt->get_result()->fetch_assoc()['next_sort'] ?? 1);

        // save relative path from public/
        $rel = 'uploads/cars/' . $basename;
        $this->img->create($unitId, $rel, 0, $nextSort);

        // ensure cover exists
        $covers = $this->conn->prepare("SELECT COUNT(*) c FROM car_images WHERE unit_id=? AND is_cover=1");
        $covers->bind_param('i',$unitId);
        $covers->execute();
        $hasCover = (int)$covers->get_result()->fetch_assoc()['c'];

        if ($hasCover === 0) {
            $this->img->clearCovers($unitId);
            $this->conn->query("UPDATE car_images SET is_cover=1 WHERE unit_id={$unitId} ORDER BY id DESC LIMIT 1");
        }

        header("Location: index.php?route=admin/cars/edit&id=".$unitId); exit;
    }

    public function deleteImage($imageId) {
        $imageId = (int)$imageId;
        if (!$imageId) { http_response_code(400); echo "Missing image id"; return; }
        $img = $this->img->findById($imageId);
        if (!$img) { http_response_code(404); echo "Image not found"; return; }

        $unitId = (int)$img['unit_id'];

        $abs = realpath(__DIR__ . '/../../public') . '/' . $img['image_path'];
        if (is_file($abs)) { @unlink($abs); }

        $this->img->delete($imageId);

        // keep a cover
        $covers = $this->conn->prepare("SELECT COUNT(*) c FROM car_images WHERE unit_id=? AND is_cover=1");
        $covers->bind_param('i',$unitId);
        $covers->execute();
        $hasCover = (int)$covers->get_result()->fetch_assoc()['c'];

        if ($hasCover === 0) {
            $res = $this->conn->prepare("SELECT id FROM car_images WHERE unit_id=? ORDER BY sort_order ASC, id ASC LIMIT 1");
            $res->bind_param('i',$unitId);
            $res->execute();
            $row = $res->get_result()->fetch_assoc();
            if ($row) {
                $this->img->clearCovers($unitId);
                $this->conn->query("UPDATE car_images SET is_cover=1 WHERE id=".(int)$row['id']);
            }
        }

        header("Location: index.php?route=admin/cars/edit&id=".$unitId); exit;
    }

    public function setCover($imageId) {
        $imageId = (int)$imageId;
        if (!$imageId) { http_response_code(400); echo "Missing image id"; return; }
        $img = $this->img->findById($imageId);
        if (!$img) { http_response_code(404); echo "Image not found"; return; }

        $this->img->setCover($imageId);
        header("Location: index.php?route=admin/cars/edit&id=".$img['unit_id']); exit;
    }

    public function updateSort() {
        if (!csrf_verify($_POST['_csrf'] ?? '')) { die("CSRF failed"); }
        $imageId = (int)($_POST['image_id'] ?? 0);
        $sort    = (int)($_POST['sort_order'] ?? 0);
        if (!$imageId) { http_response_code(400); echo "Missing image id"; return; }
        $img = $this->img->findById($imageId);
        if (!$img) { http_response_code(404); echo "Image not found"; return; }

        $this->img->updateSort($imageId, $sort);
        header("Location: index.php?route=admin/cars/edit&id=".$img['unit_id']); exit;
    }
}
