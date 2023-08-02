-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 20, 2023 at 01:00 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `npo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `organization_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `address` varchar(30) NOT NULL,
  `state` varchar(2) NOT NULL,
  `city` varchar(30) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `organization_name` varchar(30) NOT NULL,
  `npoadmin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`organization_id`, `number`, `address`, `state`, `city`, `image`, `organization_name`, `npoadmin_id`) VALUES
(1, 949283092, '431 18th St NW', 'DC', 'Washington', 'https://images.pexels.com/photos/290275/pexels-photo-290275.jpeg', 'American Red Cross', NULL),
(2, 800123456, '123 Main St', 'NY', 'New York', 'https://images.pexels.com/photos/233698/pexels-photo-233698.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2', 'American Cancer Society', NULL),
(3, 800771230, '161 N Clark St', 'IL', 'Chicago', 'https://images.pexels.com/photos/269077/pexels-photo-269077.jpeg', 'Feeding America', NULL),
(4, 800999888, '777 Elm St', 'CA', 'San Diego', 'https://images.pexels.com/photos/188035/pexels-photo-188035.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2', 'United Way', NULL),
(6, 800987654, '789 Oak Ave', 'TX', 'Dallas', 'https://images.pexels.com/photos/273250/pexels-photo-273250.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2', 'Habitat for Humanity', NULL),
(7, 800111222, '321 Pine Rd', 'FL', 'Miami', 'https://images.pexels.com/photos/2078774/pexels-photo-2078774.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2', 'Save the Children', NULL),
(8, 800444777, '555 Maple Ln', 'CA', 'San Francisco', 'https://images.pexels.com/photos/273239/pexels-photo-273239.jpeg?auto=compress&cs=tinysrgb&w=800', 'Doctors Without Borders', NULL),
(9, 800222333, '444 Cedar Ave', 'IL', 'Springfield', 'https://images.pexels.com/photos/7078666/pexels-photo-7078666.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2', 'World Wildlife Fund', NULL),
(10, 800666999, '777 Birch St', 'TX', 'Houston', 'https://images.pexels.com/photos/443383/pexels-photo-443383.jpeg', 'UNICEF', NULL),
(11, 800888222, '888 Pine St', 'NY', 'Albany', 'https://images.pexels.com/photos/443383/pexels-photo-443383.jpeg', 'Amnesty International', NULL),
(12, 800999111, '999 Oak Ave', 'FL', 'Orlando', 'https://images.pexels.com/photos/443383/pexels-photo-443383.jpeg', 'Oxfam', NULL),
(13, 800777888, '222 Maple Ln', 'CA', 'Los Angeles', 'https://images.pexels.com/photos/443383/pexels-photo-443383.jpeg', 'Greenpeace', NULL),
(14, 800771230, '35 address St', 'MN', 'Saint Paul', 'https://images.pexels.com/photos/443383/pexels-photo-443383.jpeg', 'Greenpeace', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`organization_id`),
  ADD UNIQUE KEY `organization_id` (`organization_id`),
  ADD KEY `organization_name` (`organization_name`),
  ADD KEY `organization_name_2` (`organization_name`),
  ADD KEY `fk_organization_npoadmin` (`npoadmin_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `organization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
