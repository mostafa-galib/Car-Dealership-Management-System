CREATE DATABASE IF NOT EXISTS cds CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cds;

-- 1. Admins
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL
);

-- 2. Customers
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    password_hash VARCHAR(255) NOT NULL
);

-- 3. Sales Executives
CREATE TABLE sales_executives (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    password_hash VARCHAR(255) NOT NULL
);

-- 4. Car Units
CREATE TABLE car_units (
    id INT AUTO_INCREMENT PRIMARY KEY,
    brand VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    variant VARCHAR(50),
    year SMALLINT,
    color VARCHAR(30),
    fuel_type ENUM('Petrol','Diesel','Hybrid','Electric') NOT NULL,
    transmission ENUM('Manual','Automatic') NOT NULL,
    engine_cc INT,
    power_hp SMALLINT,
    mileage_kmpl DECIMAL(5,2),
    seats TINYINT,
    airbags TINYINT,
    vin VARCHAR(50) UNIQUE,
    status ENUM('in_stock','reserved','sold') DEFAULT 'in_stock',
    asking_price DECIMAL(12,2) NOT NULL
);

-- 5. Car Images
CREATE TABLE car_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    unit_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_cover TINYINT(1) DEFAULT 0,
    sort_order INT DEFAULT 0,
    FOREIGN KEY (unit_id) REFERENCES car_units(id) ON DELETE CASCADE
);

-- 6. Test Drives
CREATE TABLE test_drives (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    unit_id INT NOT NULL,
    preferred_datetime DATETIME NOT NULL,
    status ENUM('requested','approved','completed','cancelled') DEFAULT 'requested',
    notes VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (unit_id) REFERENCES car_units(id) ON DELETE CASCADE
);

-- 7. Reservations
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    unit_id INT NOT NULL,
    sales_exec_id INT,
    reservation_type ENUM('purchase_hold','booking') NOT NULL,
    booking_amount DECIMAL(12,2) DEFAULT 0.00,
    hold_expires_at DATETIME,
    status ENUM('pending','confirmed','cancelled','expired') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (unit_id) REFERENCES car_units(id) ON DELETE CASCADE,
    FOREIGN KEY (sales_exec_id) REFERENCES sales_executives(id) ON DELETE SET NULL
);

-- 8. Quotations
CREATE TABLE quotations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    sales_exec_id INT NOT NULL,
    unit_id INT NOT NULL,
    quote_date DATE DEFAULT (CURRENT_DATE),
    status ENUM('draft','sent','accepted','rejected','expired') DEFAULT 'draft',
    unit_price DECIMAL(12,2) NOT NULL,
    tax_rate DECIMAL(5,2) DEFAULT 0.00,
    discount_amount DECIMAL(12,2) DEFAULT 0.00,
    grand_total DECIMAL(12,2) NOT NULL,
    notes VARCHAR(255),
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (sales_exec_id) REFERENCES sales_executives(id) ON DELETE CASCADE,
    FOREIGN KEY (unit_id) REFERENCES car_units(id) ON DELETE CASCADE
);

-- 9. System Settings
CREATE TABLE system_settings (
    `key` VARCHAR(50) PRIMARY KEY,
    `value` VARCHAR(255) NOT NULL
);

-- Insert default system settings
INSERT INTO system_settings (`key`, `value`) VALUES
('reservation_hold_hours', '48'),
('default_tax_rate', '7.50');
