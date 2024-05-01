-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2024 at 01:32 PM
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
-- Database: `bloodhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `blood_bank`
--

CREATE TABLE `blood_bank` (
  `blood_bank_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_bank`
--

INSERT INTO `blood_bank` (`blood_bank_id`, `name`, `email`, `password`, `location`) VALUES
(1, 'blood0', 'admin@1.com', '$2y$10$Ztft5ASnkH9oHl.Bn.USpePDEiR8BdbAmw1Lv.QIiA.bCHFYcVtCe', 'pta'),
(2, 'blood1', 'blood1@1.com', '$2y$10$1DMrlhrxAT7E54FdhRo8SOXuWz7GpPzR2mqTNcmELzR.6y2zTZv0G', 'p1'),
(6, 'blood2', 'blood2@1.com', '$2y$10$FgsOodPEOoUSC5tJbXLV2e/aID3yVD5vm6LgjHzBv.74wu4LLCL8m', 'p2'),
(7, 'bloodbank3', 'blood3@1.com', '$2y$10$KcnaLCVicjLBNd9N9xWPW.xnKNrhTMJvH/DH5vvRHpND86/oss88m', 'p3'),
(8, 'bloodbank5', 'blood5@1.com', '$2y$10$xGDi40lMQX9A.0OliB8gbO5E9KyP5tfrWHPjaEhHD80kbySriVCKi', 'kollam'),
(9, 'ptabloodbank', 'ptabloodbank@123.com', '$2y$10$AKA9pR7y1voQ7.ihjtQkhOHejBKttpvFES2kphk.ol4YL0O0ERW72', 'pta'),
(10, 'microlab', 'microlab@gmail.com', '$2y$10$J4/lerhBjqPsYGwp1s2qDuf4UygTPQmKaKDNfD0XhVo2vBjsEQ6Wi', 'Pathanamthitta');

-- --------------------------------------------------------

--
-- Table structure for table `blood_banks`
--

CREATE TABLE `blood_banks` (
  `blood_bank_id` int(11) NOT NULL,
  `blood_bank_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blood_donations`
--

CREATE TABLE `blood_donations` (
  `donation_id` int(11) NOT NULL,
  `donor_id` int(11) DEFAULT NULL,
  `donation_date` date DEFAULT NULL,
  `blood_unit` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_donations`
--

INSERT INTO `blood_donations` (`donation_id`, `donor_id`, `donation_date`, `blood_unit`) VALUES
(14, 4, '2024-04-12', '3'),
(20, 2, '2024-04-11', '20'),
(21, 2, '2024-04-09', '30'),
(22, 2, '2024-04-09', '30'),
(23, 7, '2024-02-01', '10'),
(24, 7, '2023-11-08', '10'),
(25, 6, '2024-04-02', '30'),
(26, 7, '2024-04-02', '15'),
(27, 7, '2024-04-02', '15'),
(28, 5, '2024-04-09', '40'),
(29, 7, '2024-04-08', '4'),
(30, 7, '2024-04-02', '10'),
(31, 4, '2024-04-02', '20'),
(32, 9, '2024-04-12', '20'),
(33, 5, '2024-04-10', '10'),
(34, 5, '2024-04-10', '15'),
(35, 3, '2024-04-09', '22'),
(36, 5, '2024-04-01', '3'),
(37, 1, '2024-04-17', '2'),
(38, 5, '2024-04-01', '3'),
(39, 5, '2024-04-01', '3'),
(40, 7, '2024-04-03', '12'),
(41, 5, '2024-04-22', '5'),
(42, 5, '2024-04-22', '5'),
(43, 7, '2024-04-09', '3'),
(45, 2, '2024-04-01', '2'),
(46, 6, '2024-04-05', '100'),
(47, 10, '2023-10-03', '70'),
(48, 9, '2024-03-01', '80'),
(49, 8, '2024-04-05', '17'),
(50, 8, '2024-04-05', '17'),
(51, 13, '2024-04-25', '2'),
(52, 7, '2023-07-19', '2'),
(53, 8, '2024-04-02', '5'),
(54, 14, '2024-04-24', '10'),
(55, 14, '2024-04-24', '10'),
(56, 14, '2024-04-02', '5'),
(57, 13, '2024-04-07', '3'),
(58, 5, '2024-04-01', '6'),
(59, 6, '2024-04-26', '2'),
(60, 5, '2024-04-26', '2'),
(65, 4, '2024-04-23', '2'),
(66, 15, '2024-04-16', '3'),
(67, 15, '2024-04-09', '20'),
(68, 7, '2024-04-09', '10'),
(69, 5, '2024-04-03', '1'),
(70, 4, '2024-04-11', '1'),
(71, 7, '2024-04-17', '1'),
(72, 7, '2024-04-09', '1'),
(73, 6, '2024-04-03', '1'),
(74, 3, '2024-04-06', '1'),
(75, 9, '2024-04-01', '1'),
(76, 13, '2024-04-09', '1'),
(77, 19, '2024-04-16', '1'),
(78, 3, '2024-04-25', '1'),
(79, 1, '2024-04-01', '1'),
(80, 3, '2024-04-09', '1'),
(81, 3, '2024-04-17', '1'),
(82, 3, '2024-04-05', '1'),
(83, 3, '2024-04-02', '1'),
(85, 3, '2024-04-02', '1'),
(86, 3, '2024-03-07', '1'),
(87, 3, '2024-03-07', '1'),
(88, 3, '2024-02-16', '1'),
(89, 3, '2024-02-13', '1'),
(90, 3, '2024-02-13', '1'),
(91, 13, '2024-04-05', '1'),
(92, 3, '2024-04-11', '1'),
(93, 14, '2024-04-05', '1'),
(94, 20, '2024-04-29', '1');

-- --------------------------------------------------------

--
-- Table structure for table `blood_quantity`
--

CREATE TABLE `blood_quantity` (
  `id` int(11) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `blood_bank_name` varchar(255) DEFAULT NULL,
  `units_available` int(11) NOT NULL,
  `plasma` int(11) DEFAULT 0,
  `red_blood_cells` int(11) DEFAULT 0,
  `white_blood_cells` int(11) DEFAULT 0,
  `platelets` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_quantity`
--

INSERT INTO `blood_quantity` (`id`, `blood_group`, `blood_bank_name`, `units_available`, `plasma`, `red_blood_cells`, `white_blood_cells`, `platelets`) VALUES
(5, 'O-', 'blood1', 64, 20, 10, 15, 20),
(6, 'B+', 'blood1', 39, 40, 20, 30, 40),
(7, 'A+', 'blood2', 23, 20, 10, 15, 20),
(8, 'O+', 'blood2', 170, 40, 20, 30, 40),
(9, 'A-', 'blood1', 104, 40, 20, 30, 40),
(10, 'AB+', 'blood1', 68, 20, 10, 15, 20),
(11, 'AB-', 'blood1', 24, -3, -2, -45, -7),
(12, 'B-', 'blood2', 3, 256, 119, 193, 256),
(13, 'AB+', 'blood2', 1, 20, 10, 15, 20),
(14, 'AB-', 'ptabloodbank', 1, 20, 10, 15, 20),
(15, 'A+', 'microlab', 1, 20, 10, 15, 20);

-- --------------------------------------------------------

--
-- Table structure for table `blood_request`
--

CREATE TABLE `blood_request` (
  `request_id` int(11) NOT NULL,
  `blood_bank_name` varchar(255) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `blood_quantity` int(11) NOT NULL,
  `priority` enum('high','medium','low') NOT NULL,
  `remarks` text DEFAULT NULL,
  `requested_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Red_blood_cells` int(11) DEFAULT 0,
  `White_blood_cells` int(11) DEFAULT 0,
  `Platelets` int(11) DEFAULT 0,
  `Plasma` int(11) DEFAULT 0,
  `hospital_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_request`
--

INSERT INTO `blood_request` (`request_id`, `blood_bank_name`, `blood_group`, `blood_quantity`, `priority`, `remarks`, `requested_date`, `Red_blood_cells`, `White_blood_cells`, `Platelets`, `Plasma`, `hospital_name`) VALUES
(7, 'blood1', 'AB+', 3, 'medium', 'dfdfg', '2024-04-28 12:49:37', 2, 5, 0, 0, 'hosp1'),
(8, 'blood0', 'A+', 1, 'low', 'ddd', '2024-04-28 12:50:54', 1, 1, 1, 1, 'hosp1'),
(9, 'blood0', 'A+', 1, 'low', 'ddd', '2024-04-28 12:53:32', 1, 1, 1, 1, 'hosp1'),
(10, 'blood0', 'A+', 1, 'low', 'ddd', '2024-04-28 12:58:29', 1, 1, 1, 1, 'hosp1'),
(11, 'blood1', 'AB+', 3, 'medium', 'dfdfg', '2024-04-28 13:02:40', 2, 5, 0, 0, 'hosp1'),
(12, 'blood1', 'AB+', 2, 'high', 'please gie', '2024-04-28 14:37:34', 7, 5, 3, 0, 'hosp1'),
(13, 'blood1', 'O+', 10, 'high', 'ds', '2024-04-28 14:40:56', 5, 5, 6, 0, 'hosp1'),
(14, 'blood1', 'B+', 20, 'high', 'very urgent', '2024-04-29 05:05:32', 30, 30, 30, 30, 'hosp1'),
(15, 'blood1', 'AB+', 1, 'low', 'sdsds', '2024-04-29 05:25:36', 1, 1, 1, 1, 'hosp1'),
(16, 'blood1', 'B-', 10, 'high', 'adsd', '2024-04-29 07:52:08', 11, 2, 4, 4, 'hosp1'),
(17, 'blood1', 'O+', 10, 'high', 'helooo', '2024-04-29 08:05:30', 12, 12, 12, 12, 'hosp1'),
(18, 'blood1', 'A+', 10, 'medium', 'sww', '2024-04-29 09:04:51', 10, 10, 0, 0, 'hosp1'),
(19, 'ptabloodbank', 'A+', 10, 'high', 'dsas', '2024-04-29 09:27:13', 11, 12, 12, 0, 'hosp1'),
(20, 'ptabloodbank', 'AB+', 12, 'high', '', '2024-04-29 09:30:54', 3, 4, 7, 8, 'muthoot'),
(21, 'ptabloodbank', 'A+', 1, 'high', '', '2024-04-29 09:35:46', 2, 3, 5, 6, 'hosp1'),
(22, 'ptabloodbank', 'A+', 12, 'high', '', '2024-04-29 09:38:30', 14, 43, 2, 4, 'muthoot'),
(23, 'ptabloodbank', 'AB-', 1, 'high', '', '2024-04-29 09:45:36', 2, 45, 7, 3, 'hosp1'),
(24, 'ptabloodbank', 'O+', 2, 'high', '2', '2024-04-29 09:47:51', 2, 4, 2, 1, 'hosp1'),
(25, 'ptabloodbank', 'B+', 3, 'high', '', '2024-04-29 09:49:28', 4, 32, 22, 21, 'hosp1'),
(26, 'ptabloodbank', 'A+', 1, 'high', 'wew', '2024-04-29 10:19:56', 2, 4, 5, 6, 'hosp1'),
(27, 'ptabloodbank', 'A+', 2, 'high', '', '2024-04-29 10:21:50', 4, 5, 4, 3, 'hosp1'),
(28, 'microlab', 'A+', 1, 'medium', 'test', '2024-04-29 11:21:23', 10, 3, 0, 0, 'Hospital5'),
(29, 'microlab', 'B+', 12, 'high', '', '2024-04-29 11:23:16', 4, 6, 0, 3, 'Hospital5');

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

CREATE TABLE `donors` (
  `donor_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_donation_date` date DEFAULT NULL,
  `blood_group` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donors`
--

INSERT INTO `donors` (`donor_id`, `name`, `email`, `password`, `last_donation_date`, `blood_group`) VALUES
(1, 'jijo', 'jijo@1.com', '$2y$10$8ZMVodKznRVHvE8df2q2Y.dlRodDke2iEUa6DiBYw1zUYrbh3GqlS', NULL, 'A-'),
(2, 'donor2', 'donor2@1.com', '$2y$10$V.1z2WcgvVGQBRW7CJG.OebR8CYQvnw1CK2H0S81FpZHF4FYoTQli', NULL, 'O-'),
(3, 'd3', 'd3@1.com', '$2y$10$DrFgFO0c7EuPB.6RJzIt5ehoCNyXf4PCvdV.6T9J86/TaVJkwKov6', NULL, 'B-'),
(4, 'd4', 'd4@1.com', '$2y$10$2BNQu0FmENipoF4vX/g9ue/yN.8oIqNmhc/lAy4.dTFSE6IUiuJj2', NULL, 'A+'),
(5, 'd5', 'd5@1.com', '$2y$10$XVe.b/rb.Nos9WAvrOiUPOX.LqmHaeDmVmNIkQa9S9vB3Xh/zofUu', NULL, 'O-'),
(6, 'd6', 'd6@1.com', '$2y$10$1rX9y3RyP4cfvBJwaXPdgew.Oz6eCILreyydP646sQMJqgobtuqo2', NULL, 'A-'),
(7, 'd7', 'd7@1.com', '$2y$10$BpJ5sURkjaqaCthwl30cgexNbqH9ID3ka1m1EF7KLEwYlJs9aHhVe', NULL, 'B+'),
(8, 'nevin', 'n@1.com', '$2y$10$PtnGaXwbLuMLfBMwcYGntuYY9de2OdHzclxCHQbeeyMJjN9kNS1bG', NULL, 'AB+'),
(9, 'd8', 'd8@1.com', '$2y$10$lZZRrdY3zLzv50UGwYu9MuvDmcPKBACDNzwhJ39NhW2VtSlSncoqq', NULL, 'O+'),
(10, 'raison', 'ra@1.com', '$2y$10$B7wj0c2/HnSc9cWNnu/UjuhYMISSilXg/5es4pwV56iozyjAuXVZO', NULL, 'O+'),
(13, 'tom', 'tom@1.com', '$2y$10$wFUUWR6Zrct7/RrPLbO11.34GRV1RXwHKyBNb20uhVj9AIUcpMkn6', NULL, 'AB+'),
(14, 'd10', 'd10@1.com', '$2y$10$AXP1/IqCsxXp9YA9mwCSuu8igK0fRADuRLbolqBFPFKZ9d3dE4q7e', NULL, 'AB-'),
(15, 'suhail', 'suhail@123.com', '$2y$10$1YCfvwVi7I7QjoxhmN7ltuF5u.APF1ClPUUb1wfI0El4rjIAm9KUK', NULL, 'AB+'),
(16, 'nevin', 'nevin@123.com', '$2y$10$7d0ZHtf6YtDIYQGGnj52Luh29DScCUrK5UjL7/zoXkVDRqKguD7hO', NULL, 'A+'),
(17, 'meri', 'meri@123.com', '$2y$10$GMq80oW3Vl6CDrRRq/Wd5uC.OsraNp4QOxamv5DBL6WsXjMQOY2oy', NULL, 'O+'),
(18, 'meri', 'me@12.com', '$2y$10$8527ePWXo0Zc50Nt6.161OHdQp5sFIuPsk2vMN4hP/Mi6iyXMeCUy', NULL, 'O+'),
(19, 'mdsa', 'md@12.com', '$2y$10$9o4zWWUtE2z0Y6ZOFL/I5.0nApaWOiVJNUKJIXM.hcwGoMKf03zSi', NULL, 'O+'),
(20, 'mathew', 'mathew@gmail.com', '$2y$10$i2VQQBiOQhBkjh5/KoExKe4v0QpyqtK5ix1bn6BuzMa0i.B5lSG4.', NULL, 'A+');

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

CREATE TABLE `hospitals` (
  `hospital_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospitals`
--

INSERT INTO `hospitals` (`hospital_id`, `name`, `email`, `password`, `location`) VALUES
(1, 'hosp1', 'hosp1@1.com', '$2y$10$UmXa3Gjpq3RITNGhcHoMuOBBZ5PYU76Nk0dv.OJJuNseaZE8eitl.', 'p1'),
(2, 'muthoot', 'muthoot@12.com', '$2y$10$VgoVQbnOSaKfEuyhdDhAUeFDIMXUIHNMFFZNn.yF1pc7xf6M29vje', 'pta'),
(3, 'Hospital5', 'hosp5@gmail.com', '$2y$10$/5iqPqfPMUGcBbTruaYY/.Nu8/jYCHu5StmLNTIG8E5FRA06vBra2', 'kollam');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  `blood_bank_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `hospital_id`, `blood_bank_id`, `message`, `timestamp`) VALUES
(19, 1, 2, 'Heloo This is a test message ', '2024-04-25 08:46:45'),
(21, 1, 6, 'test 1 blood2', '2024-04-25 08:59:07'),
(22, 1, 2, 'heloo test3', '2024-04-25 11:48:02'),
(26, 1, 2, 'helo any blood', '2024-04-25 14:55:56'),
(29, 3, 10, 'very urgent ', '2024-04-29 11:20:42');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `reply_id` int(11) NOT NULL,
  `message_id` int(11) DEFAULT NULL,
  `reply_message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`reply_id`, `message_id`, `reply_message`) VALUES
(1, 19, 'Got it'),
(2, 19, 'Got it');

-- --------------------------------------------------------

--
-- Table structure for table `request_status`
--

CREATE TABLE `request_status` (
  `id` int(11) NOT NULL,
  `hospital_name` varchar(255) NOT NULL,
  `request_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `blood_bank_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_status`
--

INSERT INTO `request_status` (`id`, `hospital_name`, `request_id`, `status`, `created_at`, `blood_bank_name`) VALUES
(2, 'hosp1', 7, 'rejected', '2024-04-29 09:09:31', NULL),
(3, 'hosp1', 8, 'rejected', '2024-04-29 09:09:25', NULL),
(4, 'hosp1', 7, 'rejected', '2024-04-29 09:09:31', NULL),
(5, 'hosp1', 8, 'rejected', '2024-04-29 09:09:25', NULL),
(6, 'hosp1', 7, 'rejected', '2024-04-29 09:09:31', NULL),
(7, 'hosp1', 8, 'rejected', '2024-04-29 09:09:25', NULL),
(8, 'hosp1', 11, 'accepted', '2024-04-29 08:04:18', NULL),
(9, 'hosp1', 12, 'accepted', '2024-04-28 14:38:18', NULL),
(10, 'hosp1', 13, 'accepted', '2024-04-28 14:41:33', NULL),
(11, 'hosp1', 9, 'accepted', '2024-04-29 07:32:54', NULL),
(12, 'hosp1', 10, 'accepted', '2024-04-29 07:33:29', NULL),
(13, 'hosp1', 14, 'rejected', '2024-04-29 07:49:48', NULL),
(14, 'hosp1', 15, 'rejected', '2024-04-29 08:04:49', NULL),
(15, '', 16, 'rejected', '2024-04-29 08:04:30', NULL),
(16, '', 17, 'rejected', '2024-04-29 09:09:16', NULL),
(17, '', 18, 'rejected', '2024-04-29 09:09:15', NULL),
(18, '', 19, 'rejected', '2024-04-29 09:45:14', NULL),
(19, '', 20, 'accepted', '2024-04-29 09:31:14', NULL),
(20, '', 21, 'rejected', '2024-04-29 09:37:06', NULL),
(21, '', 22, 'rejected', '2024-04-29 09:39:12', NULL),
(22, '', 23, 'accepted', '2024-04-29 09:45:44', NULL),
(23, '', 24, 'accepted', '2024-04-29 09:48:38', NULL),
(24, '', 25, 'rejected', '2024-04-29 09:52:58', NULL),
(25, 'hosp1', 26, 'rejected', '2024-04-29 10:20:05', ''),
(26, 'hosp1', 27, 'rejected', '2024-04-29 10:26:57', ''),
(27, 'Hospital5', 28, 'accepted', '2024-04-29 11:22:16', ''),
(28, 'Hospital5', 29, 'rejected', '2024-04-29 11:23:41', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blood_bank`
--
ALTER TABLE `blood_bank`
  ADD PRIMARY KEY (`blood_bank_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `blood_banks`
--
ALTER TABLE `blood_banks`
  ADD PRIMARY KEY (`blood_bank_id`);

--
-- Indexes for table `blood_donations`
--
ALTER TABLE `blood_donations`
  ADD PRIMARY KEY (`donation_id`),
  ADD KEY `donor_id` (`donor_id`);

--
-- Indexes for table `blood_quantity`
--
ALTER TABLE `blood_quantity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blood_request`
--
ALTER TABLE `blood_request`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`donor_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD PRIMARY KEY (`hospital_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `blood_bank_id` (`blood_bank_id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `message_id` (`message_id`);

--
-- Indexes for table `request_status`
--
ALTER TABLE `request_status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blood_bank`
--
ALTER TABLE `blood_bank`
  MODIFY `blood_bank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `blood_banks`
--
ALTER TABLE `blood_banks`
  MODIFY `blood_bank_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blood_donations`
--
ALTER TABLE `blood_donations`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `blood_quantity`
--
ALTER TABLE `blood_quantity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `blood_request`
--
ALTER TABLE `blood_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `donor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `hospitals`
--
ALTER TABLE `hospitals`
  MODIFY `hospital_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `request_status`
--
ALTER TABLE `request_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blood_donations`
--
ALTER TABLE `blood_donations`
  ADD CONSTRAINT `blood_donations_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `donors` (`donor_id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`blood_bank_id`) REFERENCES `blood_bank` (`blood_bank_id`);

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`message_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
