-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2017 at 08:27 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vote`
--

-- --------------------------------------------------------

--
-- Table structure for table `public_office`
--

CREATE TABLE `public_office` (
  `pid` int(11) NOT NULL,
  `pub_name` varchar(225) NOT NULL,
  `pub_desc` text NOT NULL,
  `pub_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `public_office`
--

INSERT INTO `public_office` (`pid`, `pub_name`, `pub_desc`, `pub_date`) VALUES
(3, 'Public Relation Officer (PRO)', 'This is a gerneral pulic office open for that passes information to the public.', '17th, June 2017'),
(4, 'President', 'hello', 'Wed 19, Jul 2017'),
(5, 'Vice President (V.P)', 'Vice President (V.P) LASSU', 'Wed 19, Jul 2017');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `matno` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `user_level` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone_number` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `matno`, `username`, `user_level`, `email`, `password`, `phone_number`) VALUES
(1, 160591046, 'victor', 1, 'victor@gmail.com', '1234', 'default'),
(2, 140591061, 'timmy', 1, 'timmy@gmail.com', 'spoon', 'tim_pic.jpg'),
(3, 123456789, 'ahkohd', 0, 'ahkohd@gmail.com', '1234', 'default'),
(38, 160876904, 'tola', 0, 'tola@gamil.com', '', '8050216865'),
(39, 1224345, 'joy', 0, 'joy@gmail.com', '', '8075257103'),
(40, 1045224345, 'Bola', 0, 'joy@gmail.com', '', '8075257103'),
(41, 10224345, 'segun', 0, 'joy@gmail.com', '', '8075257103'),
(42, 1245224345, 'Tunde', 0, 'joy@gmail.com', '', '8075257103'),
(43, 140591055, 'bayo', 0, 'iloh@gmail.com', '', '8012345678'),
(44, 150591031, 'dare', 0, 'dare@gmail.com', '', '909234567'),
(45, 140591022, 'ope', 0, 'ope@gmail.com', '', '909887736');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `public_office`
--
ALTER TABLE `public_office`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `matno` (`matno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `public_office`
--
ALTER TABLE `public_office`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
