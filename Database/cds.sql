-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2025 at 10:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cds`

-- CREATE DATABASE IF NOT EXISTS cds CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE cds;

--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins`(
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin1', 'admin@example.com', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `car_images`
--

DROP TABLE IF EXISTS `car_images`;
CREATE TABLE IF NOT EXISTS `car_images`(
  `id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_cover` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `car_images`
--

INSERT INTO `car_images` (`id`, `unit_id`, `image_path`, `is_cover`, `sort_order`) VALUES
(6, 35, 'assets/img/1.jpg', 1, 1),
(7, 36, 'assets/img/2.jpg', 1, 1),
(8, 37, 'assets/img/3.jpg', 1, 1),
(9, 38, 'assets/img/4.jpg', 1, 1),
(10, 39, 'assets/img/5.jpg', 1, 1),
(11, 40, 'assets/img/6.jpg', 1, 1),
(12, 41, 'assets/img/7.jpg', 1, 1),
(13, 42, 'assets/img/8.jpg', 1, 1),
(14, 43, 'assets/img/9.jpg', 1, 1),
(15, 44, 'assets/img/10.jpg', 1, 1),
(16, 45, 'assets/img/11.jpg', 1, 1),
(17, 46, 'assets/img/12.jpg', 1, 1),
(18, 47, 'assets/img/13.jpg', 1, 1),
(19, 48, 'assets/img/14.jpg', 1, 1),
(20, 49, 'assets/img/15.jpg', 1, 1),
(21, 50, 'assets/img/16.jpg', 1, 1),
(22, 51, 'assets/img/17.jpg', 1, 1),
(23, 52, 'assets/img/18.jpg', 1, 1),
(24, 53, 'assets/img/19.jpg', 1, 1),
(25, 54, 'assets/img/20.jpg', 1, 1),
(26, 55, 'assets/img/21.jpg', 1, 1),
(27, 56, 'assets/img/22.jpg', 1, 1),
(28, 57, 'assets/img/23.jpg', 1, 1),
(29, 58, 'assets/img/24.jpg', 1, 1),
(30, 59, 'assets/img/25.jpg', 1, 1),
(31, 60, 'assets/img/26.jpg', 1, 1),
(32, 61, 'assets/img/27.jpg', 1, 1),
(33, 62, 'assets/img/28.jpg', 1, 1),
(34, 63, 'assets/img/29.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `car_units`
--

DROP TABLE IF EXISTS `car_units`;
CREATE TABLE IF NOT EXISTS `car_units`(
  `id` int(11) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `variant` varchar(50) DEFAULT NULL,
  `year` smallint(6) DEFAULT NULL,
  `color` varchar(30) DEFAULT NULL,
  `fuel_type` enum('Petrol','Diesel','Hybrid','Electric') NOT NULL,
  `transmission` enum('Manual','Automatic') NOT NULL,
  `engine_cc` int(11) DEFAULT NULL,
  `power_hp` smallint(6) DEFAULT NULL,
  `mileage_kmpl` decimal(5,2) DEFAULT NULL,
  `seats` tinyint(4) DEFAULT NULL,
  `airbags` tinyint(4) DEFAULT NULL,
  `vin` varchar(50) DEFAULT NULL,
  `status` enum('in_stock','reserved','sold') DEFAULT 'in_stock',
  `asking_price` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `car_units`
--

INSERT INTO `car_units` (`id`, `brand`, `model`, `variant`, `year`, `color`, `fuel_type`, `transmission`, `engine_cc`, `power_hp`, `mileage_kmpl`, `seats`, `airbags`, `vin`, `status`, `asking_price`) VALUES
(35, 'Toyota', 'Camry', 'SE', 2023, 'Silver', 'Petrol', 'Automatic', 2500, 203, 14.50, 5, 6, 'VIN-T-101', 'in_stock', 30000.00),
(36, 'Toyota', 'Premio', 'G Superior', 2021, 'Silver', 'Petrol', 'Automatic', 1800, 140, 15.80, 5, 6, 'VIN-T-102', 'in_stock', 24000.00),
(37, 'Toyota', 'Supra', 'GR', 2024, 'Silver', 'Petrol', 'Automatic', 3000, 382, 11.00, 2, 6, 'VIN-T-103', 'in_stock', 55000.00),
(38, 'Toyota', 'C-HR', 'S', 2022, 'Silver', 'Petrol', 'Automatic', 1800, 144, 15.50, 5, 6, 'VIN-T-104', 'in_stock', 28000.00),
(39, 'Toyota', 'Land Cruiser Prado', 'TX-L', 2023, 'Black', 'Diesel', 'Automatic', 3000, 201, 10.00, 7, 7, 'VIN-T-105', 'in_stock', 70000.00),
(40, 'Toyota', 'Mark II', 'Grande', 2001, 'White', 'Petrol', 'Automatic', 2000, 160, 11.50, 5, 4, 'VIN-T-106', 'in_stock', 12000.00),
(41, 'Toyota', 'RAV4', 'XLE', 2024, 'Blue', 'Petrol', 'Automatic', 2500, 203, 13.50, 5, 6, 'VIN-T-107', 'in_stock', 35000.00),
(42, 'Lexus', 'LFA', NULL, 2012, 'Yellow', 'Petrol', 'Automatic', 4800, 552, 7.00, 2, 6, 'VIN-L-108', 'in_stock', 350000.00),
(43, 'Toyota', 'Harrier', '2025 Edition', 2025, 'Red', 'Hybrid', 'Automatic', 2500, 218, 16.00, 5, 6, 'VIN-T-109', 'in_stock', 45000.00),
(44, 'Toyota', 'Tacoma', 'TRD Sport', 2023, 'Gray', 'Petrol', 'Manual', 3500, 278, 9.50, 5, 6, 'VIN-T-110', 'in_stock', 40000.00),
(45, 'Honda', 'Civic', 'Sport', 2024, 'Black', 'Petrol', 'Automatic', 2000, 158, 14.00, 5, 6, 'VIN-H-112', 'in_stock', 26000.00),
(46, 'Honda', 'Civic Type R', 'FL5', 2024, 'Red', 'Petrol', 'Manual', 2000, 315, 9.00, 4, 6, 'VIN-H-113', 'in_stock', 47000.00),
(47, 'Honda', 'Accord', 'EX', 2023, 'Silver', 'Hybrid', 'Automatic', 2000, 204, 17.00, 5, 6, 'VIN-H-114', 'in_stock', 35000.00),
(48, 'Honda', 'CR-V', 'Touring', 2023, 'Dark Gray', 'Petrol', 'Automatic', 1500, 190, 15.80, 5, 6, 'VIN-H-115', 'in_stock', 33000.00),
(49, 'Honda', 'Pilot', 'Elite', 2025, 'Black', 'Petrol', 'Automatic', 3500, 285, 10.50, 7, 8, 'VIN-H-116', 'in_stock', 52000.00),
(50, 'Honda', 'Odyssey', 'EX-L', 2025, 'Red', 'Petrol', 'Automatic', 3500, 280, 9.50, 8, 8, 'VIN-H-117', 'in_stock', 45000.00),
(51, 'Mitsubishi', 'Lancer Evolution IX', 'GSR', 2007, 'Red', 'Petrol', 'Manual', 2000, 280, 8.50, 5, 4, 'VIN-M-118', 'in_stock', 35000.00),
(52, 'Tesla', 'Model 3', 'Long Range', 2024, 'Red', 'Electric', 'Automatic', NULL, 283, NULL, 5, 6, 'VIN-TS-119', 'in_stock', 45000.00),
(53, 'Tesla', 'Model X', 'Plaid', 2024, 'Dark Blue', 'Electric', 'Automatic', NULL, 1020, NULL, 7, 8, 'VIN-TS-120', 'in_stock', 110000.00),
(54, 'BYD', 'Sealion 7', NULL, 2024, 'Blue', 'Electric', 'Automatic', NULL, 530, NULL, 5, 6, 'VIN-BYD-121', 'in_stock', 42000.00),
(55, 'Deepal', 'S07', NULL, 2024, 'Orange', 'Electric', 'Automatic', NULL, 320, NULL, 5, 6, 'VIN-DP-122', 'in_stock', 40000.00),
(56, 'Land Rover', 'Defender', '110 SE', 2025, 'Wine Red', 'Petrol', 'Automatic', 3000, 296, 8.50, 7, 6, 'VIN-LR-123', 'in_stock', 65000.00),
(57, 'Rolls-Royce', 'Spectre', NULL, 2025, 'Dark Emerald', 'Electric', 'Automatic', NULL, 577, NULL, 4, 8, 'VIN-RR-124', 'in_stock', 400000.00),
(58, 'McLaren', 'Artura', NULL, 2024, 'Orange', 'Petrol', 'Automatic', 3000, 671, 7.50, 2, 4, 'VIN-MC-125', 'in_stock', 240000.00),
(59, 'Mercedes-Benz', 'GLS 450', '4MATIC', 2024, 'Mystic Blue Metallic', 'Petrol', 'Automatic', 3000, 362, 8.50, 7, 9, 'VIN-MB-126', 'in_stock', 85000.00),
(60, 'Nissan', 'Patrol', 'LE Platinum', 2024, 'Black', 'Petrol', 'Automatic', 5600, 400, 6.90, 7, 6, 'VIN-NP-127', 'in_stock', 75000.00),
(61, 'Mazda', 'MX-5 Miata', 'RF', 2023, 'Red', 'Petrol', 'Manual', 2000, 181, 15.00, 2, 4, 'VIN-MZ-128', 'in_stock', 32000.00),
(62, 'Toyota', 'Corolla', 'X', 2022, 'Silver', 'Petrol', 'Automatic', 1800, 140, 16.50, 5, 6, 'VIN-T-001', 'in_stock', 22000.00),
(63, 'Toyota', 'Crown Signia', NULL, 2025, 'Blue', 'Hybrid', 'Automatic', 2400, 236, 15.00, 5, 6, 'VIN-T-111', 'in_stock', 48000.00);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers`(
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `password`) VALUES
(2, 'Alp===haw', 'nssai@gm.c', '0171522333', 'ss');

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

DROP TABLE IF EXISTS `quotations`;
CREATE TABLE IF NOT EXISTS `quotations`(
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sales_exec_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `quote_date` date DEFAULT curdate(),
  `status` enum('draft','sent','accepted','rejected','expired') DEFAULT 'draft',
  `unit_price` decimal(12,2) NOT NULL,
  `tax_rate` decimal(5,2) DEFAULT 0.00,
  `discount_amount` decimal(12,2) DEFAULT 0.00,
  `grand_total` decimal(12,2) NOT NULL,
  `notes` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations`(
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `sales_exec_id` int(11) DEFAULT NULL,
  `reservation_type` enum('purchase_hold','booking') NOT NULL,
  `booking_amount` decimal(12,2) DEFAULT 0.00,
  `hold_expires_at` datetime DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled','expired') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `customer_id`, `unit_id`, `sales_exec_id`, `reservation_type`, `booking_amount`, `hold_expires_at`, `status`, `created_at`) VALUES
(8, 2, 59, NULL, '', 12222.00, '2025-09-29 01:48:15', 'cancelled', '2025-09-26 19:48:15');

-- --------------------------------------------------------

--
-- Table structure for table `sales_executives`
--

DROP TABLE IF EXISTS `sales_executives`;
CREATE TABLE IF NOT EXISTS `sales_executives`(
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_executives`
--

INSERT INTO `sales_executives` (`id`, `name`, `email`, `phone`, `password`) VALUES
(1, 'John Doe', 'john@example.com', '01711111111', 'sales123');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

DROP TABLE IF EXISTS `system_settings`;
CREATE TABLE IF NOT EXISTS `system_settings`(
  `key` varchar(50) NOT NULL,
  `value` varchar(255) NOT NULL,
  `reservation_hold_hours` int(11) NOT NULL DEFAULT 48
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`key`, `value`, `reservation_hold_hours`) VALUES
('default_tax_rate', '15', 48),
('reservation_hold_hours', '48', 48),
('site_name', 'CarDealer', 48);

-- --------------------------------------------------------

--
-- Table structure for table `test_drives`
--

DROP TABLE IF EXISTS `test_drives`;
CREATE TABLE IF NOT EXISTS `test_drives`(
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `preferred_datetime` datetime NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `test_drives`
--

INSERT INTO `test_drives` (`id`, `customer_id`, `unit_id`, `preferred_datetime`, `status`, `notes`, `created_at`) VALUES
(11, 2, 59, '2025-09-30 05:47:00', 'approved', '', '2025-09-26 19:47:59'),
(12, 2, 63, '2025-09-28 10:28:00', 'cancelled', 'not available', '2025-09-27 04:28:10'),
(13, 2, 63, '2025-09-29 02:32:00', 'completed', 'dlam', '2025-09-27 04:32:56'),
(14, 2, 61, '1996-11-11 05:55:00', 'cancelled', NULL, '2025-09-27 05:27:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `car_images`
--
ALTER TABLE `car_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `car_units`
--
ALTER TABLE `car_units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vin` (`vin`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `sales_exec_id` (`sales_exec_id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `unit_id` (`unit_id`),
  ADD KEY `sales_exec_id` (`sales_exec_id`);

--
-- Indexes for table `sales_executives`
--
ALTER TABLE `sales_executives`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `test_drives`
--
ALTER TABLE `test_drives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `car_images`
--
ALTER TABLE `car_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `car_units`
--
ALTER TABLE `car_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sales_executives`
--
ALTER TABLE `sales_executives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `test_drives`
--
ALTER TABLE `test_drives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `car_images`
--
ALTER TABLE `car_images`
  ADD CONSTRAINT `car_images_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `car_units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quotations`
--
ALTER TABLE `quotations`
  ADD CONSTRAINT `quotations_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quotations_ibfk_2` FOREIGN KEY (`sales_exec_id`) REFERENCES `sales_executives` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quotations_ibfk_3` FOREIGN KEY (`unit_id`) REFERENCES `car_units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`unit_id`) REFERENCES `car_units` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`sales_exec_id`) REFERENCES `sales_executives` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `test_drives`
--
ALTER TABLE `test_drives`
  ADD CONSTRAINT `test_drives_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `test_drives_ibfk_2` FOREIGN KEY (`unit_id`) REFERENCES `car_units` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
