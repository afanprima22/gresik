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
-- Table structure for table `set_detail_branch`
--

CREATE TABLE `set_detail_branch` (
  `set_detail_branch_id` int(11) NOT NULL,
  `set_branch_detail_id` int(11) NOT NULL,
  `kongsi_branch_id` int(11) NOT NULL,
  `set_detail_branch_qty` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `set_detail_branch`
--

INSERT INTO `set_detail_branch` (`set_detail_branch_id`, `set_branch_detail_id`, `kongsi_branch_id`, `set_detail_branch_qty`, `item_id`, `user_id`) VALUES
(7, 35, 8, 2, 6416, 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `set_detail_branch`
--
ALTER TABLE `set_detail_branch`
  ADD PRIMARY KEY (`set_detail_branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `set_detail_branch`
--
ALTER TABLE `set_detail_branch`
  MODIFY `set_detail_branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
