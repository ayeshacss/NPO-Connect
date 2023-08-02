-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 03, 2023 at 12:40 AM
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
  `organization_name` varchar(30) NOT NULL,
  `npoadmin_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `description` varchar(500) NOT NULL,
  `cause` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`organization_id`, `number`, `address`, `state`, `city`, `organization_name`, `npoadmin_id`, `image_url`, `description`, `cause`) VALUES
(1, 949283092, '431 18th St NW', 'DC', 'Washington', 'American Red Cross', NULL, 'images/1/American_Red_Cross_Logo.jpeg', 'The American Red Cross, also known as the American National Red Cross, is a nonprofit humanitarian organization that provides emergency assistance, disaster relief, and disaster preparedness education in the United States.', 'Disaster Relief'),
(3, 800771230, '161 N Clark St', 'IL', 'Chicago', 'Feeding America', NULL, 'images/3/Feeding_America_Logo.png', 'Feeding America is a United States–based nonprofit organization that is a nationwide network of more than 200 food banks that feed more than 46 million people through food pantries, soup kitchens, shelters, and other community-based agencies. Forbes ranks it as the largest U.S. charity by revenue.', 'Hunger'),
(7, 800111222, '321 Pine Rd', 'FL', 'Miami', 'Save the Children', NULL, 'images/7/Save_The_Children_Logo.jpg', 'Save the Children is an international, non-government operated organization. It was founded in the UK in 1919, with the goal of helping improve the lives of children worldwide.  The organization helps to raise money to improve children\'s lives by creating better educational opportunities, better health care, and improved economic opportunities.', 'Poverty'),
(8, 800444777, '555 Maple Ln', 'CA', 'San Francisco', 'Doctors Without Borders', NULL, 'images/8/Doctors_Without_Borders_Logo.png', 'Doctors Without Borders is a charity that provides humanitarian medical care. It is a non-governmental organisation (NGO) of French origin known for its projects in conflict zones and in countries affected by endemic diseases.[1] The organisation provides care for diabetes, drug-resistant infections, HIV/AIDS, hepatitis C, tropical and neglected diseases, tuberculosis, vaccines and COVID-19. ', 'Health'),
(9, 800222333, '444 Cedar Ave', 'IL', 'Springfield', 'World Wildlife Fund', NULL, 'images/9/WWF_Logo.png', 'The World Wide Fund for Nature (WWF) is a Swiss-based international non-governmental organization founded in 1961 that works in the field of wilderness preservation and the reduction of human impact on the environment.[4] It was formerly named the World Wildlife Fund, which remains its official name in Canada and the United States.', 'Animal Conservation'),
(10, 800666999, '777 Birch St', 'TX', 'Houston', 'UNICEF', NULL, 'images/10/unicef_logo.png', 'UNICEF originally called the United Nations International Children\'s Emergency Fund in full, now officially United Nations Children\'s Fund, is an agency of the United Nations responsible for providing humanitarian and developmental aid to children worldwide. The agency is among the most widespread and recognizable social welfare organizations in the world, with a presence in 192 countries and territories.', 'Poverty'),
(11, 800888222, '888 Pine St', 'NY', 'Albany', 'Amnesty International', NULL, 'images/11/Amnesty_International_Logo.svg', 'Amnesty International (also referred to as Amnesty or AI) is an international non-governmental organization focused on human rights, with its headquarters in the United Kingdom. The stated mission of the organization is to campaign for \"a world in which every person enjoys all of the human rights enshrined in the Universal Declaration of Human Rights and other international human rights instruments.\"', 'Human Rights'),
(12, 800999111, '999 Oak Ave', 'FL', 'Orlando', 'Oxfam', NULL, 'images/12/Oxfam_Logo.png', 'Oxfam is a British-founded confederation of 21 independent charitable organizations focusing on the alleviation of global poverty, founded in 1942 and led by Oxfam International.', 'Poverty');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('superadmin','npoadmin','user') NOT NULL,
  `npo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `user_type`, `npo_id`) VALUES
(1, 'Super Admin', 'superadmin', 'dad4df61ff3c19fe58412149ee1b230d2bdde3f4b6e71fa5d46e124167812ee6', 'superadmin', NULL),
(2, 'Npo admin', 'npoadmin', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'npoadmin', NULL),
(3, 'Jane Smith', 'janesmith', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'user', NULL),
(4, 'Alice Johnson', 'alicejohnson', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'npoadmin', 1),
(5, 'Bob Wilson', 'bobwilson', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'user', NULL),
(6, 'Sarah Thompson', 'sarahthompson', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'user', NULL),
(7, 'Michael Davis', 'michaeldavis', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'npoadmin', NULL),
(8, 'Emily Brown', 'emilybrown', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'user', NULL),
(9, 'David Lee', 'davidlee', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'user', NULL);

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_npo` (`npo_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `organization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_npo` FOREIGN KEY (`npo_id`) REFERENCES `organization` (`organization_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
