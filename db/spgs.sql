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
-- Table structure for table `spgs`
--

CREATE TABLE `spgs` (
  `spg_id` int(11) NOT NULL,
  `spg_name` varchar(50) NOT NULL,
  `spg_address` varchar(100) NOT NULL,
  `spg_birth` date NOT NULL,
  `spg_hp` varchar(20) NOT NULL,
  `spg_rek` varchar(20) NOT NULL,
  `spg_bank` varchar(20) NOT NULL,
  `spg_npwp` varchar(20) NOT NULL,
  `spg_name_npwp` varchar(20) NOT NULL,
  `spg_ktp` varchar(20) NOT NULL,
  `division_id` int(11) NOT NULL,
  `spg_status` varchar(15) NOT NULL,
  `spg_begin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `spgs`
--

INSERT INTO `spgs` (`spg_id`, `spg_name`, `spg_address`, `spg_birth`, `spg_hp`, `spg_rek`, `spg_bank`, `spg_npwp`, `spg_name_npwp`, `spg_ktp`, `division_id`, `spg_status`, `spg_begin`) VALUES
(1, 'Burhan Udin', 'Jombang', '2017-10-17', '1243541', '42524', 'BCA', '263533', 'SAMI', '1241341', 1, 'Aktif', '2017-10-23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `spgs`
--
ALTER TABLE `spgs`
  ADD PRIMARY KEY (`spg_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `spgs`
--
ALTER TABLE `spgs`
  MODIFY `spg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
