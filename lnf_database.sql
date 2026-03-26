-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2026 at 11:42 AM
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
-- Database: `lnf_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `lnf_admins`
--

CREATE TABLE `lnf_admins` (
  `id` int(11) NOT NULL,
  `admin_username` varchar(50) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lnf_admins`
--

INSERT INTO `lnf_admins` (`id`, `admin_username`, `admin_password`) VALUES
(1, 'admin', 'lnfadmin');

-- --------------------------------------------------------

--
-- Table structure for table `lnf_itemlist`
--

CREATE TABLE `lnf_itemlist` (
  `lnf_id` int(11) NOT NULL,
  `lnf_item` varchar(50) NOT NULL,
  `lnf_category` enum('Electronics','ID / Documents','Bags','Accessories','Others') NOT NULL DEFAULT 'Others',
  `lnf_location` varchar(50) NOT NULL,
  `lnf_description` text NOT NULL,
  `lnf_image` varchar(60) NOT NULL,
  `lnf_contact` varchar(50) NOT NULL,
  `lnf_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `lnf_approval` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `lnf_status` enum('lost','found','claimed') NOT NULL DEFAULT 'lost',
  `lnf_claimed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lnf_itemlist`
--

INSERT INTO `lnf_itemlist` (`lnf_id`, `lnf_item`, `lnf_category`, `lnf_location`, `lnf_description`, `lnf_image`, `lnf_contact`, `lnf_timestamp`, `lnf_approval`, `lnf_status`, `lnf_claimed_at`) VALUES
(1, 'Black Wallet', 'Accessories', 'Canteen', 'It is a black-colored wallet I lost near the food stall.', 'download.jpg', '09820028492', '2026-03-26 07:49:14', 'approved', 'claimed', '2026-03-26 15:53:18'),
(3, 'Brown Wallet', 'Bags', 'Library', 'Color Brown, Leather Texture', 'lostwallet.jpeg', 'mikotungol20@gmail.com', '2026-03-26 07:59:00', 'approved', 'found', NULL),
(4, 'Lost Keys', 'Others', 'Restroom', 'I lost my keys; last time I saw them when I was in a restroom', 'lostkeys.jpg', 'mikotungol20@gmail.com', '2026-03-26 08:54:51', 'approved', 'claimed', '2026-03-26 17:30:02'),
(6, 'Lost Cat', 'Others', 'SCHOOL', 'USELESS', 'cat-cute.gif', 'miko@gmail.com', '2026-03-26 09:37:48', 'approved', 'claimed', '2026-03-26 17:40:21'),
(7, 'Rolex', 'Accessories', 'No idea', 'I lost my rolex, i have no idea where i placed it.', 'images.jpg', 'mikotungol20@gmail.com', '2026-03-26 09:52:39', 'approved', 'claimed', '2026-03-26 18:19:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lnf_admins`
--
ALTER TABLE `lnf_admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lnf_itemlist`
--
ALTER TABLE `lnf_itemlist`
  ADD PRIMARY KEY (`lnf_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lnf_admins`
--
ALTER TABLE `lnf_admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lnf_itemlist`
--
ALTER TABLE `lnf_itemlist`
  MODIFY `lnf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
