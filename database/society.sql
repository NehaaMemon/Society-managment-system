-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2024 at 07:50 PM
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
-- Database: `society`
--

-- --------------------------------------------------------

--
-- Table structure for table `blockexp`
--

CREATE TABLE `blockexp` (
  `id` int(11) NOT NULL,
  `lift_expense` bigint(20) NOT NULL,
  `security_expense` bigint(20) NOT NULL,
  `parking_expense` bigint(20) NOT NULL,
  `water_expense` bigint(20) NOT NULL,
  `clean_expense` bigint(20) NOT NULL,
  `bl_id` int(11) DEFAULT NULL,
  `total_amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blockexp`
--

INSERT INTO `blockexp` (`id`, `lift_expense`, `security_expense`, `parking_expense`, `water_expense`, `clean_expense`, `bl_id`, `total_amount`) VALUES
(13, 500, 500, 500, 500, 500, 1, NULL),
(14, 500, 400, 200, 100, 200, 2, NULL),
(15, 500, 1, 100, 100, 100, 1, 801);

-- --------------------------------------------------------

--
-- Table structure for table `blockexpense`
--

CREATE TABLE `blockexpense` (
  `bl_id` int(11) NOT NULL,
  `lift_expense` int(11) DEFAULT NULL,
  `security_expense` int(11) DEFAULT NULL,
  `parking_expense` int(11) DEFAULT NULL,
  `water_expense` int(11) DEFAULT NULL,
  `clean_expense` int(11) DEFAULT NULL,
  `block_electri_bill` int(11) DEFAULT NULL,
  `staff_expense` int(11) DEFAULT NULL,
  `total_amount` int(11) DEFAULT NULL,
  `block` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blockexpense`
--

INSERT INTO `blockexpense` (`bl_id`, `lift_expense`, `security_expense`, `parking_expense`, `water_expense`, `clean_expense`, `block_electri_bill`, `staff_expense`, `total_amount`, `block`) VALUES
(1, 1500, 4500, 3500, 4500, 8540, 4502, 7510, 34552, 'Block A'),
(2, 5992, 3145, 1540, 4570, 450, 15000, 7511, 38208, 'Block A'),
(3, 6365, 5354, 453, 1311, 4501, 155, 1144, 19283, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE `blocks` (
  `id` int(11) NOT NULL,
  `block_name` varchar(255) NOT NULL,
  `total_lift` int(11) NOT NULL,
  `total_house` int(11) NOT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blocks`
--

INSERT INTO `blocks` (`id`, `block_name`, `total_lift`, `total_house`, `status`) VALUES
(1, 'Block A', 2, 7, 'Active'),
(2, 'Block B', 2, 8, 'Active'),
(3, 'Block C', 2, 8, 'Active'),
(5, 'Block D', 2, 8, 'under construction'),
(14, 'Block E', 3, 10, 'under construction');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffId` int(11) NOT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `cnic` int(11) DEFAULT NULL,
  `contact` int(11) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `depart` varchar(100) DEFAULT NULL,
  `salary` int(11) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `HireDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffId`, `fname`, `gender`, `cnic`, `contact`, `address`, `depart`, `salary`, `position`, `HireDate`) VALUES
(1, 'Ali', 'male', 2147483647, 2147483647, 'Hyderabad', 'Cleaning', 25000, 'manager', '2023-03-07'),
(2, 'saad', 'male', 2147483647, 2147483647, 'Hyderabad', 'security', 25000, 'employee', '2023-11-16'),
(3, 'zara', 'female', 2147483647, 105820695, 'Lahore', 'Reception', 45000, 'Supervisor', '2023-07-03'),
(4, 'Ahmed', 'male', 2147483647, 230105460, 'karachi', 'Security', 32000, 'assistant manager', '2024-06-03'),
(5, 'kinza', 'female', 2147483647, 2147483647, 'karachi', 'Reception', 14500, 'Coordinator', '2024-08-20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blockexp`
--
ALTER TABLE `blockexp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bl_id` (`bl_id`);

--
-- Indexes for table `blockexpense`
--
ALTER TABLE `blockexpense`
  ADD PRIMARY KEY (`bl_id`);

--
-- Indexes for table `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blockexp`
--
ALTER TABLE `blockexp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `blockexpense`
--
ALTER TABLE `blockexpense`
  MODIFY `bl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staffId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blockexp`
--
ALTER TABLE `blockexp`
  ADD CONSTRAINT `blockexp_ibfk_1` FOREIGN KEY (`bl_id`) REFERENCES `blocks` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
