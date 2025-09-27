<?php
class Reservation {
    private $conn;
    public function __construct($conn){ $this->conn = $conn; }

    public function create($customerId, $unitId, $type, $bookingAmount){
        $hours = $this->getHoldHoursFromSystemSettings();
        $stmt = $this->conn->prepare(
            "INSERT INTO reservations
             (customer_id, unit_id, reservation_type, booking_amount, status, hold_expires_at)
             VALUES (?,?,?,?,?, DATE_ADD(NOW(), INTERVAL ? HOUR))"
        );
        $status = 'pending';
        $stmt->bind_param("iiidsi",
            $customerId, $unitId, $type, $bookingAmount, $status, $hours
        );
        if (!$stmt->execute()) return false;
        return $this->conn->insert_id;
    }

    public function listByCustomer($customerId){
        $this->expirePendingByStoredHold();
        $sql = "SELECT r.*,
                       u.brand, u.model, u.variant, u.color
                FROM reservations r
                JOIN car_units u ON r.unit_id=u.id
                WHERE r.customer_id=?
                ORDER BY r.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function all(){
        $this->expirePendingByStoredHold();
        $sql = "SELECT r.*,
                       c.name AS customer_name,
                       u.brand, u.model, u.variant
                FROM reservations r
                JOIN customers c ON r.customer_id=c.id
                JOIN car_units u ON r.unit_id=u.id
                ORDER BY r.created_at DESC";
        return $this->conn->query($sql);
    }

    public function updateStatus($id,$status){
        $stmt = $this->conn->prepare("UPDATE reservations SET status=? WHERE id=?");
        $stmt->bind_param("si",$status,$id);
        return $stmt->execute();
    }

    public function cancelByCustomer($id,$customerId){
        $stmt = $this->conn->prepare(
            "UPDATE reservations SET status='cancelled'
             WHERE id=? AND customer_id=? AND status='pending'"
        );
        $stmt->bind_param("ii",$id,$customerId);
        $stmt->execute();
        return $stmt->affected_rows>0;
    }


    private function getHoldHoursFromSystemSettings(){
        $res = $this->conn->query("SELECT `value`, `reservation_hold_hours` FROM system_settings WHERE `key`='reservation_hold_hours' LIMIT 1");
        if ($res && $res->num_rows){
            $row = $res->fetch_assoc();
            $v = (int)($row['value'] ?? 0);
            if ($v > 0) return $v;
            $c = (int)($row['reservation_hold_hours'] ?? 0);
            if ($c > 0) return $c;
        }
        $any = $this->conn->query("SELECT reservation_hold_hours FROM system_settings LIMIT 1")->fetch_assoc();
        $fallback = (int)($any['reservation_hold_hours'] ?? 48);
        return $fallback > 0 ? $fallback : 48;
    }

    private function expirePendingByStoredHold(){
        $this->conn->query(
            "UPDATE reservations
             SET status='expired'
             WHERE status='pending'
               AND hold_expires_at IS NOT NULL
               AND hold_expires_at < NOW()"
        );
    }
}
