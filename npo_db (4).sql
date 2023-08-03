-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 03, 2023 at 02:49 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

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
  `image` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `cause` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`organization_id`, `number`, `address`, `state`, `city`, `organization_name`, `npoadmin_id`, `image`, `description`, `cause`) VALUES
(1, 949283092, '431 18th St NW', 'DC', 'Washington', 'American Red Cross', NULL, 'images/American_Red_Cross_Logo.png', 'The American Red Cross, also known as the American National Red Cross, is a nonprofit humanitarian organization that provides emergency assistance, disaster relief, and disaster preparedness education in the United States.', 'Disaster Relief'),
(3, 800771230, '161 N Clark St', 'IL', 'Chicago', 'Feeding America', NULL, 'images/Feeding_America_logo.svg.png', 'Feeding America is a United States–based nonprofit organization that is a nationwide network of more than 200 food banks that feed more than 46 million people through food pantries, soup kitchens, shelters, and other community-based agencies. Forbes ranks it as the largest U.S. charity by revenue.', 'Poverty'),
(4, 800999888, '777 Elm St', 'CA', 'San Diego', 'United Way', NULL, 'images/United_Way_logo.svg.png', 'United Way seeks to improve lives by mobilizing the caring power of communities around the world to advance the common good.  United Way brings people together to build strong, equitable communities where everyone can thrive. Through United Way, communities tackle tough challenges and work with private, public, and nonprofit partners to boost education, economic mobility, and health resources.', 'Poverty'),
(6, 800987654, '789 Oak Ave', 'TX', 'Dallas', 'Habitat for Humanity', NULL, 'images/Habitat-For-Humanity-Logo.jpg', 'Habitat for Humanity International, generally referred to as Habitat for Humanity or Habitat, is a US non-governmental, and nonprofit organization which was founded in 1976 by couple Millard and Linda Fuller. Habitat for Humanity is a Christian organization.', 'Housing'),
(7, 800111222, '321 Pine Rd', 'FL', 'Miami', 'Save the Children', NULL, 'images/Save-The-Children-logo.jpg', 'Save the Children is an international, non-government-operated organization. It was founded in the UK in 1919, with the goal of helping improve the lives of children worldwide.', 'Poverty'),
(8, 800444777, '555 Maple Ln', 'CA', 'San Francisco', 'Doctors Without Borders', NULL, 'images/Doctors-Without-Borders-logo.png', 'Doctors Without Borders is a charity that provides humanitarian medical care. It is a non-governmental organisation (NGO) of French origin known for its projects in conflict zones and in countries affected by endemic diseases.[1] The organisation provides care for diabetes, drug-resistant infections, HIV/AIDS, hepatitis C, tropical and neglected diseases, tuberculosis, vaccines and COVID-19. ', 'Health'),
(9, 800222333, '444 Cedar Ave', 'IL', 'Springfield', 'World Wildlife Fund', NULL, 'images/WWF_logo.svg.png', 'The World Wide Fund for Nature (WWF) is a Swiss-based international non-governmental organization founded in 1961 that works in the field of wilderness preservation and the reduction of human impact on the environment.[4] It was formerly named the World Wildlife Fund, which remains its official name in Canada and the United States.', 'Animal Conservation'),
(10, 800666999, '777 Birch St', 'TX', 'Houston', 'UNICEF', NULL, 'images/UNICEF_Logo.png', 'UNICEF, headquartered in Houston, TX, is a renowned non-profit organization that works in more than 190 countries to provide assistance to children in need. Their focus areas include education, healthcare, nutrition, and child protection. UNICEF is committed to safeguarding the rights of children and ensuring their well-being, particularly in emergencies and vulnerable situations.\r\n\r\n', 'Poverty'),
(11, 800888222, '888 Pine St', 'NY', 'Albany', 'Amnesty International', NULL, 'images/Amnesty_International_logo.svg.png', 'Amnesty International (also referred to as Amnesty or AI) is an international non-governmental organization focused on human rights, with its headquarters in the United Kingdom. The stated mission of the organization is to campaign for \"a world in which every person enjoys all of the human rights enshrined in the Universal Declaration of Human Rights and other international human rights instruments.\"', 'Human Rights'),
(12, 800999111, '999 Oak Ave', 'FL', 'Orlando', 'Oxfam', NULL, 'images/Oxfam-logo-RGB.png', 'Oxfam is a British-founded confederation of 21 independent charitable organizations focusing on the alleviation of global poverty, founded in 1942 and led by Oxfam International.', 'Poverty'),
(19, 1234567890, '375 Mackubin St', 'MN', 'Saint Paul', 'Greenpeace', NULL, 'images/pexels-photo-290275.jpeg', 'Located in San Diego, CA, United Way is a non-profit organization that mobilizes resources to address community needs and create positive social change. They collaborate with local agencies, businesses, and volunteers to support education, financial stability, and health initiatives, striving to improve lives and strengthen communities.\r\n\r\n', 'Greenery'),
(20, 1234567890, '375 Mackubin St', 'MN', 'Saint Paul', 'Test', NULL, 'images/pexels-photo-290275.jpeg', 'With its headquarters in San Francisco, CA, Doctors Without Borders (Médecins Sans Frontières) is an international medical humanitarian organization. They provide medical aid in regions affected by armed conflicts, natural disasters, and epidemics. By delivering impartial and independent medical care, they aim to save lives and alleviate suffering where it is most needed.\r\n\r\n', 'Greenery'),
(21, 1234567890, '123 Student St', 'MN', 'Saint Paul', 'Abdulkader', NULL, 'images/pexels-photo-290275.jpeg', 'asddacafcadasaasfa', 'Student'),
(23, 1234567890, '123 Street', 'MN', 'Saint Paul', 'AA', NULL, 'images/UNICEF_Logo.png', 'f3rf31', 'Student');

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
(1, 'Super Admin', 'superadmin', 'dad4df61ff3c19fe58412149ee1b230d2bdde3f4b6e71fa5d46e124167812ee6', 'superadmin', 3),
(2, 'Npo admin', 'npoadmin', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'npoadmin', 1),
(3, 'Jane Smith', 'janesmith', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'user', 3),
(4, 'Alice Johnson', 'alicejohnson', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'npoadmin', NULL),
(5, 'Bob Wilson', 'bobwilson', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'user', NULL),
(6, 'Sarah Thompson', 'sarahthompson', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'user', NULL),
(7, 'Michael Davis', 'michaeldavis', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'npoadmin', NULL),
(8, 'Emily Brown', 'emilybrown', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'user', NULL),
(9, 'David Lee', 'davidlee', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'user', NULL),
(10, 'Abdulkader Abdi', 'aa@gmail.com', '123456', 'user', 1);

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `organization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
