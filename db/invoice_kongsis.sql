-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2017 at 04:28 PM
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
-- Table structure for table `invoice_kongsis`
--

CREATE TABLE `invoice_kongsis` (
  `invoice_kongsi_id` int(11) NOT NULL,
  `invoice_kongsi_discount` int(11) NOT NULL,
  `invoice_kongsi_date` date NOT NULL,
  `invoice_kongsi_code` varchar(50) NOT NULL,
  `kongsi_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_kongsis`
--

INSERT INTO `invoice_kongsis` (`invoice_kongsi_id`, `invoice_kongsi_discount`, `invoice_kongsi_date`, `invoice_kongsi_code`, `kongsi_id`) VALUES
(4, 0, '2017-10-20', 'NT2017100001', 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoice_kongsis`
--
ALTER TABLE `invoice_kongsis`
  ADD PRIMARY KEY (`invoice_kongsi_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoice_kongsis`
--
ALTER TABLE `invoice_kongsis`
  MODIFY `invoice_kongsi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
