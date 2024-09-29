-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2024 at 04:43 AM
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
-- Database: `v_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `item_sale`
--

CREATE TABLE `item_sale` (
  `id` int(11) NOT NULL,
  `item_code` varchar(6) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `quantity` decimal(10,0) NOT NULL,
  `expired_date` date NOT NULL,
  `note` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item_sale`
--

INSERT INTO `item_sale` (`id`, `item_code`, `item_name`, `quantity`, `expired_date`, `note`) VALUES
(1, 'A001', 'Apple', 100, '2024-12-31', 'Fresh apples'),
(2, 'B002', 'Banana', 200, '2024-11-15', 'Organic bananas'),
(3, 'C003', 'Carrot', 150, '2024-10-20', 'Farm fresh carrots');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item_sale`
--
ALTER TABLE `item_sale`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item_sale`
--
ALTER TABLE `item_sale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
