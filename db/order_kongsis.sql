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
-- Table structure for table `order_kongsis`
--

CREATE TABLE `order_kongsis` (
  `order_kongsi_id` int(11) NOT NULL,
  `order_kongsi_code` varchar(100) NOT NULL,
  `kongsi_id` int(11) NOT NULL,
  `order_kongsi_date` date NOT NULL,
  `order_kongsi_status` int(11) NOT NULL,
  `order_kongsi_discount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_kongsis`
--

INSERT INTO `order_kongsis` (`order_kongsi_id`, `order_kongsi_code`, `kongsi_id`, `order_kongsi_date`, `order_kongsi_status`, `order_kongsi_discount`) VALUES
(42, 'NT2017100001', 20, '2017-10-17', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order_kongsis`
--
ALTER TABLE `order_kongsis`
  ADD PRIMARY KEY (`order_kongsi_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order_kongsis`
--
ALTER TABLE `order_kongsis`
  MODIFY `order_kongsi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
