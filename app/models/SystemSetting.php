<?php
class SystemSetting {
    private $conn;
    public function __construct($conn){ $this->conn = $conn; }

    public function all(){
        return $this->conn->query("SELECT `key`,`value`,`reservation_hold_hours` FROM system_settings ORDER BY `key` ASC");
    }

    public function get($key){
        $stmt = $this->conn->prepare("SELECT `value` FROM system_settings WHERE `key`=? LIMIT 1");
        $stmt->bind_param("s",$key);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row['value'] ?? null;
    }

    public function set($key,$value){
        $stmt = $this->conn->prepare(
            "INSERT INTO system_settings (`key`,`value`,reservation_hold_hours)
             VALUES (?,?,reservation_hold_hours)
             ON DUPLICATE KEY UPDATE `value`=VALUES(`value`)"
        );
        $stmt->bind_param("ss",$key,$value);
        return $stmt->execute();
    }

    public function reservationHoldHours(){
        $stmt = $this->conn->prepare("SELECT `value`,`reservation_hold_hours` FROM system_settings WHERE `key`='reservation_hold_hours' LIMIT 1");
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        if ($row){
            
            $v = (int)($row['value'] ?? 0);
            if ($v > 0) return $v;
            $c = (int)($row['reservation_hold_hours'] ?? 0);
            if ($c > 0) return $c;
        }
        $any = $this->conn->query("SELECT reservation_hold_hours FROM system_settings LIMIT 1")->fetch_assoc();
        $fallback = (int)($any['reservation_hold_hours'] ?? 48);
        return $fallback > 0 ? $fallback : 48;
    }

    public function defaultTaxRate(){
        return (float)($this->get('default_tax_rate') ?? 0.0);
    }

    public function siteName(){
        return (string)($this->get('site_name') ?? 'CarDealer');
    }


    public function setReservationHoldHours($hours){
        $hours = max(1, (int)$hours);
        $this->set('reservation_hold_hours', (string)$hours);
        $stmt = $this->conn->prepare("UPDATE system_settings SET reservation_hold_hours=?");
        $stmt->bind_param("i",$hours);
        $stmt->execute();
        return $hours;
    }
}
