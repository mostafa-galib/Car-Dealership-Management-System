<?php
class CarImage {
    private $conn;
    public function __construct($conn){ $this->conn = $conn; }

    public function allByUnit($unitId) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM car_images WHERE unit_id=? ORDER BY is_cover DESC, sort_order ASC, id ASC"
        );
        $stmt->bind_param('i',$unitId);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM car_images WHERE id=?");
        $stmt->bind_param('i',$id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($unitId, $path, $isCover, $sortOrder) {
        $stmt = $this->conn->prepare(
            "INSERT INTO car_images (unit_id, image_path, is_cover, sort_order) VALUES (?,?,?,?)"
        );
        $stmt->bind_param('isii', $unitId, $path, $isCover, $sortOrder);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM car_images WHERE id=?");
        $stmt->bind_param('i',$id);
        return $stmt->execute();
    }

    public function clearCovers($unitId) {
        $stmt = $this->conn->prepare("UPDATE car_images SET is_cover=0 WHERE unit_id=?");
        $stmt->bind_param('i',$unitId);
        return $stmt->execute();
    }

    public function setCover($imageId) {
        $img = $this->findById($imageId);
        if (!$img) return false;
        $unitId = (int)$img['unit_id'];
        $this->clearCovers($unitId);
        $stmt = $this->conn->prepare("UPDATE car_images SET is_cover=1 WHERE id=?");
        $stmt->bind_param('i',$imageId);
        return $stmt->execute();
    }

    public function updateSort($imageId, $sortOrder) {
        $stmt = $this->conn->prepare("UPDATE car_images SET sort_order=? WHERE id=?");
        $stmt->bind_param('ii',$sortOrder,$imageId);
        return $stmt->execute();
    }

    // For customer views
    public function cover($unitId) {
        $stmt = $this->conn->prepare(
            "SELECT image_path FROM car_images WHERE unit_id=? AND is_cover=1 LIMIT 1"
        );
        $stmt->bind_param('i',$unitId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row['image_path'] ?? 'assets/img/no-image.png';
    }
}
