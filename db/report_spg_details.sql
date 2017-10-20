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
-- Table structure for table `report_spg_details`
--

CREATE TABLE `report_spg_details` (
  `report_spg_detail_id` int(11) NOT NULL,
  `report_spg_id` int(11) NOT NULL,
  `report_spg_detail_date1` int(11) NOT NULL,
  `report_spg_detail_date2` int(11) NOT NULL,
  `report_spg_detail_date3` int(11) NOT NULL,
  `report_spg_detail_date4` int(11) NOT NULL,
  `report_spg_detail_date5` int(11) NOT NULL,
  `report_spg_detail_date6` int(11) NOT NULL,
  `report_spg_detail_date7` int(11) NOT NULL,
  `report_spg_detail_date8` int(11) NOT NULL,
  `report_spg_detail_date9` int(11) NOT NULL,
  `report_spg_detail_date10` int(11) NOT NULL,
  `report_spg_detail_date11` int(11) NOT NULL,
  `report_spg_detail_date12` int(11) NOT NULL,
  `report_spg_detail_date13` int(11) NOT NULL,
  `report_spg_detail_date14` int(11) NOT NULL,
  `report_spg_detail_date15` int(11) NOT NULL,
  `report_spg_detail_date16` int(11) NOT NULL,
  `report_spg_detail_date17` int(11) NOT NULL,
  `report_spg_detail_date18` int(11) NOT NULL,
  `report_spg_detail_date19` int(11) NOT NULL,
  `report_spg_detail_date20` int(11) NOT NULL,
  `report_spg_detail_date21` int(11) NOT NULL,
  `report_spg_detail_date22` int(11) NOT NULL,
  `report_spg_detail_date23` int(11) NOT NULL,
  `report_spg_detail_date24` int(11) NOT NULL,
  `report_spg_detail_date25` int(11) NOT NULL,
  `report_spg_detail_date26` int(11) NOT NULL,
  `report_spg_detail_date27` int(11) NOT NULL,
  `report_spg_detail_date28` int(11) NOT NULL,
  `report_spg_detail_date29` int(11) NOT NULL,
  `report_spg_detail_date30` int(11) NOT NULL,
  `report_spg_detail_date31` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `set_detail_branch_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `report_spg_details`
--

INSERT INTO `report_spg_details` (`report_spg_detail_id`, `report_spg_id`, `report_spg_detail_date1`, `report_spg_detail_date2`, `report_spg_detail_date3`, `report_spg_detail_date4`, `report_spg_detail_date5`, `report_spg_detail_date6`, `report_spg_detail_date7`, `report_spg_detail_date8`, `report_spg_detail_date9`, `report_spg_detail_date10`, `report_spg_detail_date11`, `report_spg_detail_date12`, `report_spg_detail_date13`, `report_spg_detail_date14`, `report_spg_detail_date15`, `report_spg_detail_date16`, `report_spg_detail_date17`, `report_spg_detail_date18`, `report_spg_detail_date19`, `report_spg_detail_date20`, `report_spg_detail_date21`, `report_spg_detail_date22`, `report_spg_detail_date23`, `report_spg_detail_date24`, `report_spg_detail_date25`, `report_spg_detail_date26`, `report_spg_detail_date27`, `report_spg_detail_date28`, `report_spg_detail_date29`, `report_spg_detail_date30`, `report_spg_detail_date31`, `user_id`, `set_detail_branch_id`, `item_id`) VALUES
(3, 6, 2, 2, 0, 3, 2, 2, 2, 3, 2, 2, 2, 2, 3, 3, 2, 2, 3, 3, 2, 3, 3, 2, 3, 2, 2, 2, 3, 2, 2, 2, 3, 11, 7, 6416);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `report_spg_details`
--
ALTER TABLE `report_spg_details`
  ADD PRIMARY KEY (`report_spg_detail_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `report_spg_details`
--
ALTER TABLE `report_spg_details`
  MODIFY `report_spg_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
