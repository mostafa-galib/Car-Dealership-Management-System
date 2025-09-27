<?php
class TestDrive {
    private $conn;
    public function __construct($conn){ $this->conn = $conn; }

    // Create a new test drive - customer
    public function create($customerId, $unitId, $preferredDatetime, $notes = null){
        $stmt = $this->conn->prepare(
            "INSERT INTO test_drives (customer_id, unit_id, preferred_datetime, status, notes)
             VALUES (?,?,?,?,?)"
        );
        $status = 'pending';
        $stmt->bind_param("iisss", $customerId, $unitId, $preferredDatetime, $status, $notes);
        if (!$stmt->execute()) return false;
        return $this->conn->insert_id;
    }

    public function all($status=null){
        $sql = "SELECT td.*, c.name AS customer_name, u.brand, u.model, u.variant
                FROM test_drives td
                JOIN customers c ON td.customer_id=c.id
                JOIN car_units u ON td.unit_id=u.id";
        if ($status) {
            $sql .= " WHERE td.status=? ORDER BY td.created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s",$status);
            $stmt->execute();
            return $stmt->get_result();
        }
        return $this->conn->query($sql." ORDER BY td.created_at DESC");
    }

    // Customer's own list
    public function listByCustomer($customerId){
        $stmt = $this->conn->prepare(
            "SELECT td.*, u.brand, u.model, u.variant, u.color
             FROM test_drives td
             JOIN car_units u ON td.unit_id=u.id
             WHERE td.customer_id=?
             ORDER BY td.created_at DESC"
        );
        $stmt->bind_param("i",$customerId);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function find($id){
        $stmt = $this->conn->prepare("SELECT * FROM test_drives WHERE id=?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Sales updates status/notes
    public function updateStatus($id,$status,$notes=null){
        $stmt = $this->conn->prepare("UPDATE test_drives SET status=?, notes=? WHERE id=?");
        $stmt->bind_param("ssi",$status,$notes,$id);
        return $stmt->execute();
    }

    // Customer cancel (pending/approved/confirmed)
    public function cancelByCustomer($id, $customerId){
        $stmt = $this->conn->prepare(
            "UPDATE test_drives
             SET status='cancelled'
             WHERE id=? AND customer_id=? AND status IN ('pending','approved','confirmed')"
        );
        $stmt->bind_param("ii",$id,$customerId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
