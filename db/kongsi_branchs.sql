-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2017 at 04:30 PM
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
-- Table structure for table `kongsi_branchs`
--

CREATE TABLE `kongsi_branchs` (
  `kongsi_branch_id` int(11) NOT NULL,
  `kongsi_id` int(11) NOT NULL,
  `kongsi_branch_name` varchar(50) NOT NULL,
  `kongsi_branch_address` text NOT NULL,
  `spg_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kongsi_branchs`
--

INSERT INTO `kongsi_branchs` (`kongsi_branch_id`, `kongsi_id`, `kongsi_branch_name`, `kongsi_branch_address`, `spg_id`, `user_id`) VALUES
(8, 20, 'cabang purnama', 'mojokerto', 1, 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kongsi_branchs`
--
ALTER TABLE `kongsi_branchs`
  ADD PRIMARY KEY (`kongsi_branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kongsi_branchs`
--
ALTER TABLE `kongsi_branchs`
  MODIFY `kongsi_branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
