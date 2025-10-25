-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 25, 2025 at 04:30 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `threebrotherlaw`
--

-- --------------------------------------------------------

--
-- Table structure for table `consultation_schedule`
--

CREATE TABLE `consultation_schedule` (
  `id` int NOT NULL,
  `lawyer_id` int DEFAULT NULL,
  `customer_id` int DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `profession` varchar(100) NOT NULL,
  `lawyer_name` varchar(100) NOT NULL,
  `consultation_date` date NOT NULL,
  `day` varchar(20) NOT NULL,
  `time` varchar(20) NOT NULL,
  `status` enum('Pending','Accepted','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `consultation_schedule`
--

INSERT INTO `consultation_schedule` (`id`, `lawyer_id`, `customer_id`, `customer_name`, `profession`, `lawyer_name`, `consultation_date`, `day`, `time`, `status`, `created_at`) VALUES
(1, 10, 7, 'customer1', 'Koorporasi', 'lawyersatu', '2025-10-16', 'Senin', '08.00 - 10.00', 'Accepted', '2025-10-16 11:42:55'),
(2, 11, 7, 'customer1', 'Advokat', 'lawyerdua', '2025-10-16', 'Selasa', '08.00 - 15.00', 'Pending', '2025-10-16 11:48:16'),
(3, 10, 7, 'customer1', 'Koorporasi', 'lawyersatu', '2025-10-18', 'Senin', '08.00 - 10.00', 'Pending', '2025-10-18 07:39:52'),
(4, 11, 7, 'customer1', 'Advokat', 'lawyerdua', '2025-10-18', 'Selasa', '08.00 - 15.00', 'Pending', '2025-10-18 07:41:56');

-- --------------------------------------------------------

--
-- Table structure for table `lawyers`
--

CREATE TABLE `lawyers` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `birth_place` varchar(100) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `profession` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lawyers`
--

INSERT INTO `lawyers` (`id`, `user_id`, `full_name`, `email`, `address`, `birth_place`, `birth_date`, `profession`, `phone`, `created_at`, `updated_at`) VALUES
(10, 24, 'lawyersatu', 'lawyersatu@gmail.com', 'jalan ku aman', 'Sidoarjo', '2025-10-01', 'Koorporasi', '08891231231', '2025-10-16 09:16:27', '2025-10-16 12:50:04'),
(11, 28, 'lawyerdua', 'lawyerdua@gmail.com', 'jalan nya', 'Sidoarjo', '2023-05-08', 'Advokat', '08891231231', '2025-10-16 09:35:44', '2025-10-16 09:35:44');

-- --------------------------------------------------------

--
-- Table structure for table `lawyer_schedule`
--

CREATE TABLE `lawyer_schedule` (
  `id` int NOT NULL,
  `lawyer_id` int DEFAULT NULL,
  `lawyer_username` varchar(100) DEFAULT NULL,
  `day` enum('Senin','Selasa','Rabu','Kamis','Jumat') DEFAULT NULL,
  `start_time` enum('08.00','10.00','13.00','15.00') DEFAULT NULL,
  `end_time` enum('10.00','12.00','15.00','17.00') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lawyer_schedule`
--

INSERT INTO `lawyer_schedule` (`id`, `lawyer_id`, `lawyer_username`, `day`, `start_time`, `end_time`, `created_at`) VALUES
(2, 10, 'lawyersatu', 'Senin', '08.00', '10.00', '2025-10-16 09:19:34'),
(3, 11, 'lawyerdua', 'Selasa', '08.00', '15.00', '2025-10-16 09:36:14'),
(4, 11, 'lawyerdua', 'Rabu', '13.00', '15.00', '2025-10-16 09:36:26'),
(5, NULL, 'lawyersatu', 'Senin', '08.00', '10.00', '2025-10-19 10:49:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `role` enum('Customer','Lawyer','Administrator') DEFAULT 'Customer',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `profile_picture`, `role`, `created_at`, `updated_at`) VALUES
(4, 'andicus', 'andi@gmail.com', '$2y$10$lTGZyaWv0il4ZOzE44dk8u6Ur9z5y42Huy7dbcF6D9wntqorhiYrG', NULL, 'Customer', '2025-10-02 13:37:12', '2025-10-02 13:37:12'),
(5, 'test1', 'test@gmail.com', '$2y$10$aEiiIYjR/DRl.H3WojORhuo8Fh426LvyMgmcOHAHZkwtlxAWCmdwy', NULL, 'Customer', '2025-10-02 13:39:19', '2025-10-02 13:39:19'),
(6, 'test2', 'test2@gmail.com', '$2y$10$66rTv3sdA35iOyNHuh9jOe.NqR2.8dExdj1cRCPMlRlnhkv7eCPye', NULL, 'Customer', '2025-10-04 07:56:48', '2025-10-04 07:56:48'),
(7, 'customer1', 'customer1@gmail.com', '$2y$10$3dMMlYfd2jV1n8xic.vbAux8ohK20bkBUmsdDkQohrFUO6rWLcery', NULL, 'Customer', '2025-10-12 18:04:53', '2025-10-12 18:04:53'),
(8, 'lawyer1', 'lawyer1@gmail.com', '$2y$10$w56xhjNjgOQYPJWswoS4SOXh2ZSxfpDhY03GSdpSPUJaV1mjpHf8G', NULL, 'Customer', '2025-10-12 19:40:17', '2025-10-12 19:40:17'),
(24, 'lawyersatu', 'lawyersatu@gmail.com', '46d5f4cae495902d83337bab4b0cd988a0fdb2a319bacbcc7cf1e2c6802cdc4e', 'assets/uploads/profiles/1761365677_pp amba 1.jpeg', 'Lawyer', '2025-10-16 09:16:27', '2025-10-25 04:14:37'),
(27, 'adminsatu', 'adminsatu@gmail.com', '9998da720208ae7867889484c5a201a2011715277d50e6a5483e216f1c1bb25f', NULL, 'Administrator', '2025-10-16 09:24:20', '2025-10-16 09:24:20'),
(28, 'lawyerdua', 'lawyerdua@gmail.com', '24e6cbd0241ac425fee9e67ff9e43bdb95b292f4e684d1e3cee3f898e174d1b3', NULL, 'Lawyer', '2025-10-16 09:35:44', '2025-10-16 09:35:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consultation_schedule`
--
ALTER TABLE `consultation_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_consultation_lawyer` (`lawyer_id`),
  ADD KEY `fk_consultation_customer` (`customer_id`);

--
-- Indexes for table `lawyers`
--
ALTER TABLE `lawyers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `lawyer_schedule`
--
ALTER TABLE `lawyer_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_schedule_lawyer` (`lawyer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consultation_schedule`
--
ALTER TABLE `consultation_schedule`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lawyers`
--
ALTER TABLE `lawyers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `lawyer_schedule`
--
ALTER TABLE `lawyer_schedule`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consultation_schedule`
--
ALTER TABLE `consultation_schedule`
  ADD CONSTRAINT `fk_consultation_customer` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_consultation_lawyer` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lawyers`
--
ALTER TABLE `lawyers`
  ADD CONSTRAINT `lawyers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lawyer_schedule`
--
ALTER TABLE `lawyer_schedule`
  ADD CONSTRAINT `fk_schedule_lawyer` FOREIGN KEY (`lawyer_id`) REFERENCES `lawyers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
