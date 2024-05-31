-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2024 at 10:12 AM
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
-- Database: `traffic_signal`
--

-- --------------------------------------------------------

--
-- Table structure for table `signal_records`
--

CREATE TABLE `signal_records` (
  `id` int(11) NOT NULL,
  `green_signal_interval` int(11) NOT NULL,
  `yellow_signal_interval` int(11) NOT NULL,
  `signal_a` int(11) NOT NULL,
  `signal_b` int(11) NOT NULL,
  `signal_c` int(11) NOT NULL,
  `signal_d` int(11) NOT NULL,
  `is_delete` enum('1','0') NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signal_records`
--

INSERT INTO `signal_records` (`id`, `green_signal_interval`, `yellow_signal_interval`, `signal_a`, `signal_b`, `signal_c`, `signal_d`, `is_delete`, `created_at`, `deleted_at`) VALUES
(1, 12, 4, 1, 2, 4, 3, '1', '2024-05-31 07:12:44', '2024-05-31 07:12:44'),
(2, 11, 4, 2, 3, 4, 1, '1', '2024-05-31 07:21:07', '2024-05-31 07:21:07'),
(3, 11, 4, 2, 3, 4, 1, '1', '2024-05-31 07:21:36', '2024-05-31 07:21:36'),
(4, 11, 3, 2, 3, 4, 1, '1', '2024-05-31 07:22:14', '2024-05-31 07:22:14'),
(5, 11, 3, 2, 3, 1, 4, '1', '2024-05-31 07:23:40', '2024-05-31 07:23:40'),
(6, 11, 3, 2, 3, 1, 4, '1', '2024-05-31 07:25:40', '2024-05-31 07:25:40'),
(7, 11, 4, 2, 3, 4, 1, '1', '2024-05-31 07:27:19', '2024-05-31 07:27:19'),
(8, 11, 4, 2, 3, 4, 1, '1', '2024-05-31 07:28:30', '2024-05-31 07:28:30'),
(9, 10, 3, 1, 2, 3, 4, '1', '2024-05-31 07:43:16', '2024-05-31 07:43:16'),
(10, 10, 3, 1, 2, 3, 4, '1', '2024-05-31 07:43:53', '2024-05-31 07:43:53'),
(11, 10, 3, 1, 2, 3, 4, '1', '2024-05-31 07:48:05', '2024-05-31 07:48:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `signal_records`
--
ALTER TABLE `signal_records`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `signal_records`
--
ALTER TABLE `signal_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
