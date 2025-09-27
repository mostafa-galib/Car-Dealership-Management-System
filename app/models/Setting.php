<?php
class Setting {
    private $conn;
    public function __construct($conn){ $this->conn = $conn; }

    public function getAll(){
        return $this->conn->query("SELECT `key`,`value`,`reservation_hold_hours` FROM system_settings ORDER BY `key`");
    }

    public function get($key){
        $stmt = $this->conn->prepare("SELECT `key`,`value`,`reservation_hold_hours` FROM system_settings WHERE `key`=? LIMIT 1");
        $stmt->bind_param("s",$key);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function set($key, $value){
        $stmt = $this->conn->prepare("INSERT INTO system_settings (`key`,`value`) VALUES (?,?) ON DUPLICATE KEY UPDATE `value`=VALUES(`value`)");
        $stmt->bind_param("ss",$key,$value);
        return $stmt->execute();
    }

    public function setHoldHours($hours){
        $exists = $this->get('reservation_hold_hours');
        if ($exists){
            $stmt = $this->conn->prepare("UPDATE system_settings SET reservation_hold_hours=? WHERE `key`='reservation_hold_hours' LIMIT 1");
            $stmt->bind_param("i",$hours);
            return $stmt->execute();
        } else {
            $stmt = $this->conn->prepare("INSERT INTO system_settings (`key`,`value`,`reservation_hold_hours`) VALUES ('reservation_hold_hours', '0', ?)");
            $stmt->bind_param("i",$hours);
            return $stmt->execute();
        }
    }
}
