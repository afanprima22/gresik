-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2017 at 04:34 PM
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
-- Table structure for table `set_branch_details`
--

CREATE TABLE `set_branch_details` (
  `set_branch_detail_id` int(11) NOT NULL,
  `set_branch_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `order_kongsi_id` int(11) NOT NULL,
  `set_branch_detail_qty` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_kongsi_detail_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `set_branch_details`
--

INSERT INTO `set_branch_details` (`set_branch_detail_id`, `set_branch_id`, `item_id`, `order_kongsi_id`, `set_branch_detail_qty`, `user_id`, `order_kongsi_detail_id`) VALUES
(35, 12, 6416, 42, 0, 11, 29),
(36, 12, 6416, 42, 0, 11, 30);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `set_branch_details`
--
ALTER TABLE `set_branch_details`
  ADD PRIMARY KEY (`set_branch_detail_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `set_branch_details`
--
ALTER TABLE `set_branch_details`
  MODIFY `set_branch_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
