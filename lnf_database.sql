-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2026 at 04:10 AM
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
-- Table structure for table `lnf_itemlist`
--

CREATE TABLE `lnf_itemlist` (
  `lnf_id` int(11) NOT NULL,
  `lnf_item` varchar(50) NOT NULL,
  `lnf_category` varchar(50) NOT NULL,
  `lnf_location` varchar(50) NOT NULL,
  `lnf_description` text NOT NULL,
  `lnf_image` varchar(60) NOT NULL,
  `lnf_contact` varchar(50) NOT NULL,
  `lnf_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lnf_itemlist`
--

INSERT INTO `lnf_itemlist` (`lnf_id`, `lnf_item`, `lnf_category`, `lnf_location`, `lnf_description`, `lnf_image`, `lnf_contact`, `lnf_timestamp`) VALUES
(8, 'Grey Bag', 'Bags', 'Main Building', 'Found inside the hallways.', 'lostbag.jpg', '099999999', '2026-03-12 09:32:12'),
(9, 'House Keys', 'Others', 'Library', 'A key, if I remember.', 'lostkeys.jpg', '', '2026-03-12 10:12:55'),
(18, 'Lost Cat', 'Others', 'Canteen', 'A lost cat description', 'cat-cute.gif', '09999999999', '2026-03-12 12:55:27'),
(19, 'Duke Flores', 'Others', 'Lobby', 'Mapayat, kulot at naka salamin.', 'ddc67b999c1bb896f4435d6f3207ed49.jpg', '1912041204912', '2026-03-14 06:10:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lnf_itemlist`
--
ALTER TABLE `lnf_itemlist`
  ADD PRIMARY KEY (`lnf_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lnf_itemlist`
--
ALTER TABLE `lnf_itemlist`
  MODIFY `lnf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
