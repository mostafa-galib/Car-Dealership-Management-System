<?php
class CarUnit {
    private $conn;
    public function __construct($conn){ $this->conn = $conn; }

    // List with filters
    public function all($filters = []) {
        $sql = "SELECT * FROM car_units WHERE 1";
        $params = [];
        $types  = '';

        if (!empty($filters['brand'])) {
            $sql .= " AND (brand LIKE ? OR model LIKE ? OR variant LIKE ?)";
            $like = '%'.$filters['brand'].'%';
            $params[] = $like; $types .= 's';
            $params[] = $like; $types .= 's';
            $params[] = $like; $types .= 's';
        }
        if (!empty($filters['fuel'])) {
            $sql .= " AND fuel_type = ?";
            $params[] = $filters['fuel'];
            $types .= 's';
        }
        if (!empty($filters['trans'])) {
            $sql .= " AND transmission = ?";
            $params[] = $filters['trans'];
            $types .= 's';
        }
        if (isset($filters['pmin']) && $filters['pmin'] !== '' && $filters['pmin'] !== null) {
            $sql .= " AND asking_price >= ?";
            $params[] = (float)$filters['pmin'];
            $types .= 'd';
        }
        if (isset($filters['pmax']) && $filters['pmax'] !== '' && $filters['pmax'] !== null) {
            $sql .= " AND asking_price <= ?";
            $params[] = (float)$filters['pmax'];
            $types .= 'd';
        }

        $sql .= " ORDER BY id DESC";

        if ($params) {
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            return $stmt->get_result();
        } else {
            return $this->conn->query($sql);
        }
    }

    public function find($id) {
        $stmt = $this->conn->prepare("SELECT * FROM car_units WHERE id=?");
        $stmt->bind_param('i',$id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function findMany(array $ids) {
        if (!$ids) return [];
        $place = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        $stmt = $this->conn->prepare("SELECT * FROM car_units WHERE id IN ($place)");
        $stmt->bind_param($types, ...$ids);
        $stmt->execute();
        $res = $stmt->get_result();
        $byId = [];
        while ($r = $res->fetch_assoc()) $byId[$r['id']] = $r;
        $ordered = [];
        foreach ($ids as $i) if (isset($byId[$i])) $ordered[] = $byId[$i];
        return $ordered;
    }

    public function create($data) {
        $brand = trim($data['brand'] ?? '');
        $model = trim($data['model'] ?? '');
        $variant = trim($data['variant'] ?? '');
        $year = (int)($data['year'] ?? 0);
        $color = trim($data['color'] ?? '');
        $fuel_type = trim($data['fuel_type'] ?? '');
        $transmission = trim($data['transmission'] ?? '');
        $engine_cc = ($data['engine_cc'] === '' ? null : (int)$data['engine_cc']);
        $power_hp = ($data['power_hp'] === '' ? null : (int)$data['power_hp']);
        $mileage_kmpl = ($data['mileage_kmpl'] === '' ? null : (float)$data['mileage_kmpl']);
        $seats = ($data['seats'] === '' ? null : (int)$data['seats']);
        $airbags = ($data['airbags'] === '' ? null : (int)$data['airbags']);
        $vin = trim($data['vin'] ?? '');
        $status = trim($data['status'] ?? 'in_stock');
        $asking_price = (float)($data['asking_price'] ?? 0);

        $stmt = $this->conn->prepare(
          "INSERT INTO car_units
           (brand, model, variant, year, color, fuel_type, transmission, engine_cc, power_hp, mileage_kmpl, seats, airbags, vin, status, asking_price)
           VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"
        );
        $stmt->bind_param(
          'sssisssiiidiiss',
          $brand, $model, $variant, $year, $color, $fuel_type, $transmission,
          $engine_cc, $power_hp, $mileage_kmpl, $seats, $airbags, $vin, $status, $asking_price
        );
        return $stmt->execute();
    }

    public function update($id, $data) {
        $brand = trim($data['brand'] ?? '');
        $model = trim($data['model'] ?? '');
        $variant = trim($data['variant'] ?? '');
        $year = (int)($data['year'] ?? 0);
        $color = trim($data['color'] ?? '');
        $fuel_type = trim($data['fuel_type'] ?? '');
        $transmission = trim($data['transmission'] ?? '');
        $engine_cc = ($data['engine_cc'] === '' ? null : (int)$data['engine_cc']);
        $power_hp = ($data['power_hp'] === '' ? null : (int)$data['power_hp']);
        $mileage_kmpl = ($data['mileage_kmpl'] === '' ? null : (float)$data['mileage_kmpl']);
        $seats = ($data['seats'] === '' ? null : (int)$data['seats']);
        $airbags = ($data['airbags'] === '' ? null : (int)$data['airbags']);
        $vin = trim($data['vin'] ?? '');
        $status = trim($data['status'] ?? 'in_stock');
        $asking_price = (float)($data['asking_price'] ?? 0);

        $stmt = $this->conn->prepare(
          "UPDATE car_units
           SET brand=?, model=?, variant=?, year=?, color=?, fuel_type=?, transmission=?, engine_cc=?, power_hp=?, mileage_kmpl=?, seats=?, airbags=?, vin=?, status=?, asking_price=?
           WHERE id=?"
        );
        $stmt->bind_param(
          'sssisssiiidiissi',
          $brand, $model, $variant, $year, $color, $fuel_type, $transmission,
          $engine_cc, $power_hp, $mileage_kmpl, $seats, $airbags, $vin, $status, $asking_price, $id
        );
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM car_units WHERE id=?");
        $stmt->bind_param('i',$id);
        return $stmt->execute();
    }
}
