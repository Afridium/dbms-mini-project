-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2025 at 07:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `missing_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`username`, `password`) VALUES
('admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) DEFAULT NULL,
  `object_name` varchar(100) DEFAULT NULL,
  `lost_date` date DEFAULT NULL,
  `returned_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `student_id`, `object_name`, `lost_date`, `returned_date`) VALUES
(1, '23215845', 'Phone', '2025-07-23', '2025-07-23 12:14:58');

-- --------------------------------------------------------

--
-- Table structure for table `missing_objects`
--

CREATE TABLE `missing_objects` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `lost_date` date DEFAULT NULL,
  `last_seen` varchar(150) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `student_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `missing_objects`
--

INSERT INTO `missing_objects` (`id`, `name`, `description`, `lost_date`, `last_seen`, `phone_number`, `student_id`) VALUES
(3, 'Laptop', 'Asus TUF A15, RTX4050 6G, 16GB RAM, 512GB SSD', '2025-07-17', 'KT-305', '01737774444', '23215845'),
(4, 'phone', 'Nokia M15, Blue', '2025-07-11', 'KT-224', '01876371970', '23215761'),
(6, 'Notebook', 'Notebooks with Numerical Methods notes, Pink Cover, Sayla Akter written on the cover', '2025-08-05', 'KT-803', '01234567890', '23215598');

-- --------------------------------------------------------

--
-- Stand-in structure for view `pending_tickets`
-- (See below for the actual view)
--
CREATE TABLE `pending_tickets` (
`id` int(11)
,`name` varchar(100)
,`description` text
,`lost_date` date
,`last_seen` varchar(150)
,`student_id` varchar(20)
,`student_name` varchar(100)
,`phone_number` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ticket_entries`
-- (See below for the actual view)
--
CREATE TABLE `ticket_entries` (
`student_id` varchar(20)
,`student_name` varchar(100)
,`student_phone` varchar(20)
,`object_id` int(11)
,`object_name` varchar(100)
,`description` text
,`lost_date` date
,`last_seen` varchar(150)
);

-- --------------------------------------------------------

--
-- Table structure for table `website_users`
--

CREATE TABLE `website_users` (
  `student_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `website_users`
--

INSERT INTO `website_users` (`student_id`, `name`, `phone_number`, `password`) VALUES
('23215598', 'Sayla Akter', '01234567890', '$2y$10$LhUR9LOM4Ufx77bqxK4Go.nPne0dPQcGBuLQH9M9xTMRKa.lseVtm'),
('23215761', 'Tanbir Taj', '01876371970', '$2y$10$RMKkuafFBFJ8b8jEaG.6AuNuLYfy8TOaDLZ/kmFWEG5NoKLx5hgUe'),
('23215845', 'Afridi Hassan', '01737774444', '$2y$10$a7wUR3e1ZTfE9rMwF155LecyiIwt14qQ7v2MvktEVXiA5WgVtgVx6');

-- --------------------------------------------------------

--
-- Structure for view `pending_tickets`
--
DROP TABLE IF EXISTS `pending_tickets`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pending_tickets`  AS SELECT `o`.`id` AS `id`, `o`.`name` AS `name`, `o`.`description` AS `description`, `o`.`lost_date` AS `lost_date`, `o`.`last_seen` AS `last_seen`, `u`.`student_id` AS `student_id`, `u`.`name` AS `student_name`, `u`.`phone_number` AS `phone_number` FROM (`missing_objects` `o` join `website_users` `u` on(`o`.`student_id` = `u`.`student_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `ticket_entries`
--
DROP TABLE IF EXISTS `ticket_entries`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ticket_entries`  AS SELECT `u`.`student_id` AS `student_id`, `u`.`name` AS `student_name`, `u`.`phone_number` AS `student_phone`, `o`.`id` AS `object_id`, `o`.`name` AS `object_name`, `o`.`description` AS `description`, `o`.`lost_date` AS `lost_date`, `o`.`last_seen` AS `last_seen` FROM (`website_users` `u` join `missing_objects` `o` on(`u`.`student_id` = `o`.`student_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `missing_objects`
--
ALTER TABLE `missing_objects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `website_users`
--
ALTER TABLE `website_users`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `missing_objects`
--
ALTER TABLE `missing_objects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `missing_objects`
--
ALTER TABLE `missing_objects`
  ADD CONSTRAINT `missing_objects_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `website_users` (`student_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
