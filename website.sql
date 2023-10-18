-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2023 at 08:35 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `website`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `activity_name` varchar(255) NOT NULL,
  `activity_date` date NOT NULL,
  `activity_time` time NOT NULL,
  `activity_location` varchar(255) NOT NULL,
  `activity_ootd` varchar(255) NOT NULL,
  `activity_status` varchar(20) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `activity_name`, `activity_date`, `activity_time`, `activity_location`, `activity_ootd`, `activity_status`) VALUES
(69, 'Take a bath', '2023-02-01', '18:48:00', 'New ERA', 'DIRTY WHITE', 'Cancelled'),
(70, 'MALIGO', '2023-03-01', '07:49:00', 'New ERA', 'DIRTY WHITE', 'Cancelled'),
(71, 'walk', '2023-04-27', '08:51:00', 'New ERA', 'DIRTY WHITE', 'Cancelled'),
(72, 'MALIGO', '2023-09-07', '18:59:00', 'New ERA', 'DIRTY WHITE', 'Pending'),
(73, 'MALIGO', '2023-09-07', '18:59:00', 'New ERA', 'DIRTY WHITE', 'Pending'),
(74, 'MALIGO', '2023-12-29', '07:01:00', 'New ERA', 'DIRTY WHITE', 'Pending'),
(75, 'Take a bath', '2023-11-23', '07:01:00', 'New ERA', 'sa', 'Pending'),
(76, 'Take a bath', '2023-12-22', '07:01:00', 'New ERA', 'DIRTY WHITE', 'Pending'),
(77, 'making project', '2023-10-12', '10:40:00', 'usc', 'white shirt and green pants', 'Pending'),
(78, 'webdev', '2023-10-13', '17:36:00', 'usc', 'school uniform', 'Pending'),
(79, 'java project', '2023-10-14', '11:57:00', 'usc', 'school uniform', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`) VALUES
(1, 'kabuang', 'hello bootan ko'),
(2, 'Update!!!', 'Hello new users, have a nice day ahead!');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `confirm_password` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `email`, `password`, `gender`, `confirm_password`, `status`) VALUES
(7, 'dine', 'dine', 'dine@gmail.com', '$2y$10$lCqFodszOQQ4cX6BE6ZszuUroQ/M1Pdkwc4zYMEdcD2SSAXfswKw.', 'Female', NULL, 1),
(8, 'loi', 'loi', 'loi@gmail.com', '$2y$10$Zsvnyp3kaGN9bbHscno95O301ZyPXmGcronv1GMNrJgTTTyTfoWDm', 'Male', '$2y$10$IcMz56S/v4/CXWQ8YuxUmOIJ/cMhd83VQ.vk0Hr5RZjRJws7YFRv6', 1),
(9, 'ge gedorio', 'ge20', 'ge@gmail.com', '$2y$10$LHajPgaKjgkofd3NByRkRuVYTUSUDdd.K2UGGlY3roGgK5rFbUGIe', 'Female', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
