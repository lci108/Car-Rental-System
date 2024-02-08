-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2023 at 09:24 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cars`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `car_name` varchar(255) NOT NULL,
  `car_type` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `hire_cost` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `Type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `car_name`, `car_type`, `image`, `hire_cost`, `capacity`, `Type`, `status`) VALUES
(1, 'Phantom (Blue)', 'Rolls Royce ', 'Rolls Royce Phantom.jpg', 9800, 4, 'Luxurious', 'Available'),
(2, 'Continental Flying Spur (White)', 'Bentley', 'Bentley Continental Flying Spur.jpg', 4800, 4, 'Luxurious', 'Available'),
(3, 'CLS 350 (Silver)', 'Mercedes-Benz', 'Mercedes-Benz CLS 350.JPG', 1350, 4, 'Luxurious', 'Available'),
(4, 'S Type (Champagne)', 'Jaguar', 'Jaguar S Type.jpg', 1350, 4, 'Luxurious', 'Available'),
(5, 'F430 Scuderia (Red)', 'Ferrari', 'Ferrari F430 Scuderia.jpg', 6000, 2, 'Sports', 'Available'),
(11, 'Murcielago LP640 (Matte Black)', 'Lamborghini', 'Lamborghini Murcielago LP640.jpg', 7000, 2, 'Sports', 'Available'),
(12, 'Boxster (White)', 'Porsche', 'Porsche Boxster (White).jpg', 2800, 2, 'Sports', 'Available'),
(13, 'SC430 (Black)', 'Lexus', 'Lexus SC430.JPG', 1600, 2, 'Sports', 'Available'),
(14, 'MK 2 (White)', 'Jaguar', 'Jaguar MK 2.JPG', 2200, 4, 'Classics', 'Available'),
(15, 'Silver Spirit Limousine (Georgian Silver)', 'Rolls Royce', 'Rolls Royce Silver Spirit Limousine.jpg', 3200, 8, 'Classics', 'Available'),
(16, 'TD (Red)', 'MG', 'MG TD.jpg', 2500, 2, 'Classics', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `client_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `customer_name` varchar(255) NOT NULL,
  `reservation_id` varchar(255) NOT NULL,
  `car_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `fees` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `fname` (`fname`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
