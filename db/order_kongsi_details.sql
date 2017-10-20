-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2017 at 04:32 PM
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
-- Table structure for table `order_kongsi_details`
--

CREATE TABLE `order_kongsi_details` (
  `order_kongsi_detail_id` int(11) NOT NULL,
  `order_kongsi_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_detail_id` int(11) NOT NULL,
  `order_kongsi_detail_qty` int(11) NOT NULL,
  `order_kongsi_detail_price` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_kongsi_detail_discount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_kongsi_details`
--

INSERT INTO `order_kongsi_details` (`order_kongsi_detail_id`, `order_kongsi_id`, `item_id`, `item_detail_id`, `order_kongsi_detail_qty`, `order_kongsi_detail_price`, `user_id`, `order_kongsi_detail_discount`) VALUES
(29, 42, 6416, 1, 3, 10000, 11, 10),
(30, 42, 6416, 1, 4, 10000, 11, 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order_kongsi_details`
--
ALTER TABLE `order_kongsi_details`
  ADD PRIMARY KEY (`order_kongsi_detail_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order_kongsi_details`
--
ALTER TABLE `order_kongsi_details`
  MODIFY `order_kongsi_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
