-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2017 at 04:33 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gresik_live`
--

-- --------------------------------------------------------

--
-- Table structure for table `order_kongsi_memos`
--

CREATE TABLE `order_kongsi_memos` (
  `order_kongsi_memo_id` int(11) NOT NULL,
  `order_kongsi_id` int(11) NOT NULL,
  `memo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_kongsi_memos`
--

INSERT INTO `order_kongsi_memos` (`order_kongsi_memo_id`, `order_kongsi_id`, `memo_id`) VALUES
(10, 1, 6),
(11, 1, 9),
(13, 2, 7),
(14, 3, 8),
(15, 4, 10),
(16, 6, 4),
(17, 7, 4),
(18, 8, 4),
(19, 9, 4),
(20, 10, 4),
(21, 11, 4),
(22, 12, 4),
(23, 13, 4),
(24, 14, 4),
(25, 15, 4),
(26, 16, 4),
(27, 17, 4),
(28, 18, 4),
(35, 19, 1),
(39, 20, 11),
(40, 21, 12),
(41, 22, 13),
(42, 22, 14),
(43, 23, 13),
(44, 24, 13),
(45, 24, 14),
(46, 25, 13),
(47, 26, 13),
(48, 26, 14),
(49, 27, 13),
(50, 27, 14),
(51, 28, 13),
(52, 28, 14),
(53, 30, 13),
(54, 30, 14),
(55, 31, 14),
(56, 32, 13),
(57, 32, 14),
(58, 33, 13),
(59, 33, 14),
(60, 34, 13),
(61, 34, 14),
(62, 35, 13),
(63, 36, 13),
(64, 37, 13),
(65, 38, 13),
(66, 39, 13),
(67, 40, 13),
(68, 40, 14);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order_kongsi_memos`
--
ALTER TABLE `order_kongsi_memos`
  ADD PRIMARY KEY (`order_kongsi_memo_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order_kongsi_memos`
--
ALTER TABLE `order_kongsi_memos`
  MODIFY `order_kongsi_memo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
