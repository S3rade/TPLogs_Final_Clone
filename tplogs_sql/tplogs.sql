-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2020 at 09:51 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tplogs`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ADMIN_ID` int(10) NOT NULL,
  `ROLES` varchar(10) NOT NULL,
  `A_USERNAME` varchar(20) NOT NULL,
  `A_NRIC` varchar(255) NOT NULL,
  `A_DOB` varchar(10) NOT NULL,
  `A_SALT` varchar(20) NOT NULL,
  `A_HASH` varchar(256) NOT NULL,
  `A_EMAIL` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ADMIN_ID`, `ROLES`, `A_USERNAME`, `A_NRIC`, `A_DOB`, `A_SALT`, `A_HASH`, `A_EMAIL`) VALUES
(21, 'Admin', 'Zac', 'UzEyMzQ1Njda', '03-11-2001', 'OElfls4AKR2Gz8Mn4G4I', 'MGRmNTcwZDMyY2M3YjFlZTY2NjQ1ZTZkMzE1YWQ4MjFjNjJiZTQyZjBhODdiYmFkNDU4ZWEwNWRjZGZkM2MyYzk3MDIxMDA5MTEyMzMwZTI3ZTdmMjhjZDlhNzYwMjQwZDMxNzYzNTc4Njk0ZWE2ZTZjNzQ5MGUyN2Y3ZjljNjU=', 'zachary.phoon@gmail.com'),
(22, 'Admin', 'Mik', 'UzEyMzQ1Njda', '03-11-2020', 'nnfGKe0vY5nD0j8xEhm6', 'M2NiNDcyYTJhOTJlODgyZjQ3ZjE5OWU3NWNmODRjNTM0NjUzMDYzNDY5MWJkOGFiOGViODcxZTkyMzgwYmFlMDk2YmRjMDU1NzFmMmNkMWIxMTM1NzhkYTIxOGFiYjc3NjFjNmUxYTVlNzlhYTkzMmE3MTVmNGMyMzgzYjdkOGQ=', 'mik@gmail.com'),
(23, 'Admin', 'Matin', 'UzEyMzQ1Njda', '15-12-2020', 'Rn2Qsg@vpWJ$7R*v5Bw1', 'ZTFlYmRjNjExZDE3OWU1NzJlZDU1YzNlMzM4NmNkNDg4ODdlNmY4M2E2YjNmYjMwM2Q1MjE2MzA4NzEwMTFlMWM3YjUyZmE4Nzg1NTI3YWMwMDRkY2M3MTAxMWYyMWQ0NTUxYjFlYjg2MTc0ODg3ZjAyMDViOTdiMzRhYTM5YTM=', 'Matin@gmail.com'),
(24, 'Admin', 'Aniq', 'VDEyMzQ1NjdB', '03-11-2020', 'GwPAJa@brYVkVQbWLF6n', 'ZmVkZDk4Mjc5MDQ3OWRkNmRmOTJhODZhMDZjN2RkMTMxYzQyYmUzODZhOWEyZDY1MGRkODRmMTU1YTdhMGQ3MjZhNzY1ZmQwOWI3ZmUwNGE2MTUzNmQ0Y2M4YWM0ZDU4ODNhMzQ2MjUwZjFjNTNiNDg4MjgwN2RmNzY1YmRmN2I=', 'aniq@gmail.com'),
(25, 'Admin', 'TingKai', 'RzEyMzQ1NjdB', '03-11-2001', 'Xz1*KF2@VeJ#z2e0UjYb', 'YjVlYTg3ZmZjYTZhMTUwZDA5NTk1MzNjNzY1NTU3YWI0ZTY2MjQ4Yjk1N2U4MjMwZDBlODc4YmYwODhkNTMyNTgxNTc5MjIzODdkNzQ5OWRjODE5ZmI4MDRlMGNmNjExNzViOGY2YWRmZjI5OGRjYmMwNThjZTc5MzcyNGY4Y2M=', 'tingkai@gmail.com'),
(26, 'Admin', 'ImportedStaff', 'RjEyMzQ1NjdC', '03-11-2001', 'KSmnPFMVufRlIRRyD@Tb', 'MGE1ZjJjZWQ5NWUwMzFjZTA4YjNlNzAzZGFlNTI1NTY0OTA2N2E4OTA4MjY2YzFlZjJjMWM2NGZmODk5MjMzNDA5NDE3NjEwNjdhOWZiODMxZDMzZGNmZGViMmI0MDdjZWRjMmRmN2YyNDQ0ZjY0YjI0NjdmM2M4ZmU4MDIxNjE=', 'Imported@gmail.com'),
(27, 'Staff', 'Staff', 'UzEyMzQ1NjdB', '03-11-2001', 'jxW4nkKq2GDd3ZIcftnh', 'MjA3ZDEyZTNiZGYyODFkOWMyY2U3ODUyOThkZTAwZjk4ZTkyOGU1YWRhOTc2NjkzZTMzYTJlNGNmNjRiYmU3Mzk1NzI5MTc3ODVkOWQ1MjkyMmQzZjQwYmVlNTJjYmI3N2EwNGFmZjRkNzE5YmFmZmMyOTg5NDlmM2U4Njc5ODc=', 'NANI@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `bankaccount`
--

CREATE TABLE `bankaccount` (
  `BA_ID` int(10) NOT NULL,
  `BA_USER` int(10) DEFAULT NULL,
  `BA_CARDNUM` varchar(255) NOT NULL,
  `BA_CVC` varchar(255) NOT NULL,
  `BA_EXP_DATE` varchar(5) NOT NULL,
  `BA_CARDNAME` varchar(26) NOT NULL,
  `BA_AMOUNT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bankaccount`
--

INSERT INTO `bankaccount` (`BA_ID`, `BA_USER`, `BA_CARDNUM`, `BA_CVC`, `BA_EXP_DATE`, `BA_CARDNAME`, `BA_AMOUNT`) VALUES
(2, 7, 'MTIzNC0xMjM0LTEyMzQtMTIzNA==', 'NzEz', '03/11', 'Serade', 0);

-- --------------------------------------------------------

--
-- Table structure for table `catalogs`
--

CREATE TABLE `catalogs` (
  `CAT_ID` int(10) NOT NULL,
  `C_LENDER` int(10) DEFAULT NULL,
  `C_OBJECTNAME` varchar(60) NOT NULL,
  `C_SHORTDESC` varchar(180) NOT NULL,
  `C_IMGLINK` varchar(60) NOT NULL,
  `C_COLLECTIONPOINT` varchar(300) NOT NULL,
  `C_CHARGEPERDAY` int(5) NOT NULL,
  `C_TIMESTAMP` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `catalogs`
--

INSERT INTO `catalogs` (`CAT_ID`, `C_LENDER`, `C_OBJECTNAME`, `C_SHORTDESC`, `C_IMGLINK`, `C_COLLECTIONPOINT`, `C_CHARGEPERDAY`, `C_TIMESTAMP`) VALUES
(11, 7, 'Hello', 'hihihihiihihihi', 'cam1.jpg', 'TP', 1000, '2020-12-15 15:34:51');

-- --------------------------------------------------------

--
-- Table structure for table `lenderoutstanding`
--

CREATE TABLE `lenderoutstanding` (
  `LO_ID` int(11) NOT NULL,
  `LO_LENDER` int(10) DEFAULT NULL,
  `LO_BORROWER` int(10) DEFAULT NULL,
  `LO_OBJECTNAME` varchar(60) NOT NULL,
  `LO_SHORTDESC` varchar(180) NOT NULL,
  `LO_IMGLINK` varchar(60) NOT NULL,
  `LO_CHARGEPERDAY` int(5) NOT NULL,
  `LO_COLLECTIONPOINT` varchar(300) NOT NULL,
  `LO_TIMESTAMP` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `USER_ID` int(10) NOT NULL,
  `ROLES` varchar(10) NOT NULL,
  `U_USERNAME` varchar(20) NOT NULL,
  `U_NRIC` varchar(255) NOT NULL,
  `U_DOB` varchar(10) NOT NULL,
  `U_SALT` varchar(20) NOT NULL,
  `U_HASH` varchar(256) NOT NULL,
  `U_EMAIL` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`USER_ID`, `ROLES`, `U_USERNAME`, `U_NRIC`, `U_DOB`, `U_SALT`, `U_HASH`, `U_EMAIL`) VALUES
(7, 'User', 'UserAniq', 'UzEyMzQ1NjdB', '03-11-2001', 'jxG8RxmUvncteTM9xh3Z', 'NDAxM2Y3OTQ2OWRiMTg3NWNhYzVjNGRiZTlkNWMxZjEzZDFjNmFjNDljNGMxZjJiNzRiNjQ0NjE5ZGU2MGIzNjJjMGNmMzI0YzE1NTQ2YzBlNDdlZDc5NzkwNmZkNTQ5OGM2YTliZWE0MWQ1ZDQ1YjViYTZkZTlmMjU1ODYzNDI=', 'aniq@gmail.com'),
(8, 'User', 'UserZac', 'UzEyMzQ1NjdB', '03-11-2001', 'A8fmUo9eEsclInI4aa6J', 'NWU4NGUxNTBkYTU0MTYyZGJiOTQ2ODFjM2UyN2QxZGY5MWZhNWU1NDQzMGFkNmIxNDUwYzZjZDFiNWUzODk3MzBmMWFlMGZkMDU0OTAzY2QxODQyM2QxMGRkNzg0ZDE1YzU3M2EyYWQwM2U4ODI3MjhmZjQwMWQ0NmI2NzlkNjk=', 'zachary.phoon@gmail.com'),
(9, 'User', 'UserMik', 'UzEyMzQ1NjdB', '03-11-2001', 'osqm1Pif7S9JESjLCe3G', 'ZDc0NWEzZWY3Y2FiNGZiNzllYjJiMGRiMDk5YjhjZTJhM2JhMzliZTNlN2VjNjhhODNlMGQyNjk0YWY4NDkwOTY2NjZiNmY3ODA4NDI3ODVjZDlhYzg1MjMxMDc5NDRjNTA5YzdhNDU0ZjJiOTZjNGRiNGQzMDBjOTAxM2ExNGI=', 'zachary.phoon@gmail.com'),
(10, 'User', 'UserMatin', 'UzEyMzQ1NjdB', '03-11-2001', 'hllG4aFifko6gkNyI0L4', 'MDZhMmI1NjRmYWI0ZTkxMjdiYjdhNTA3N2E0NWQ2NmNiYTJlMTkyNzJkZjg5OGQ4MGIyNDU0NTlmMzQ5YjI0NWYxNzljNjllY2ZkNDZjN2YzMmY1MWFkYWEyZWExYTkwZGU5Y2UwNDFjOGQxMDM3NDYyOGU4Y2U1MGU0MmVhZGE=', 'zachary.phoon@gmail.com'),
(11, 'User', 'UserTingKai', 'UzEyMzQ1NjdB', '03-11-2001', 'cJg3h9XOx138NPpSFawK', 'NjMzNDBkMWM4NGY0ZmNhODg5ZTA2MTYxZGUyN2M0ZDhiNThlNzU4ZTg2Nzg3MjU4ZmRjYmE5YzA2MGE3NzVlNWJiMGJjZDc0MjQwMGY3YzJlZTUxYjc0OTE4ZWI2NDEwN2FiMjZiOGM3NGRmYmFlYzg0ZWY2MGZiZGJkOTA0ZTE=', 'zachary.phoon@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `useroutstandings`
--

CREATE TABLE `useroutstandings` (
  `UO_ID` int(8) NOT NULL,
  `UO_LENDER` int(8) DEFAULT NULL,
  `UO_BORROWER` int(8) DEFAULT NULL,
  `UO_OBJECTNAME` varchar(60) NOT NULL,
  `UO_SHORTDESC` varchar(180) NOT NULL,
  `UO_IMGLINK` varchar(60) NOT NULL,
  `UO_CHARGEPERDAY` int(5) NOT NULL,
  `UO_COLLECTIONPOINT` varchar(300) NOT NULL,
  `UO_TIMESTAMP` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ADMIN_ID`),
  ADD UNIQUE KEY `A_USERNAME` (`A_USERNAME`,`A_NRIC`,`A_EMAIL`),
  ADD UNIQUE KEY `A_SALT` (`A_SALT`),
  ADD UNIQUE KEY `A_USERNAME_2` (`A_USERNAME`);

--
-- Indexes for table `bankaccount`
--
ALTER TABLE `bankaccount`
  ADD PRIMARY KEY (`BA_ID`),
  ADD KEY `fk_to_user5` (`BA_USER`);

--
-- Indexes for table `catalogs`
--
ALTER TABLE `catalogs`
  ADD PRIMARY KEY (`CAT_ID`),
  ADD KEY `fk_to_user11` (`C_LENDER`);

--
-- Indexes for table `lenderoutstanding`
--
ALTER TABLE `lenderoutstanding`
  ADD PRIMARY KEY (`LO_ID`),
  ADD KEY `fk_to_user9` (`LO_LENDER`),
  ADD KEY `fk_to_user10` (`LO_BORROWER`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`USER_ID`),
  ADD UNIQUE KEY `U_USERNAME` (`U_USERNAME`,`U_NRIC`,`U_SALT`,`U_EMAIL`),
  ADD UNIQUE KEY `U_USERNAME_2` (`U_USERNAME`);

--
-- Indexes for table `useroutstandings`
--
ALTER TABLE `useroutstandings`
  ADD PRIMARY KEY (`UO_ID`),
  ADD KEY `fk_to_user6` (`UO_LENDER`),
  ADD KEY `fk_to_user7` (`UO_BORROWER`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ADMIN_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `bankaccount`
--
ALTER TABLE `bankaccount`
  MODIFY `BA_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `catalogs`
--
ALTER TABLE `catalogs`
  MODIFY `CAT_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `lenderoutstanding`
--
ALTER TABLE `lenderoutstanding`
  MODIFY `LO_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `USER_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `useroutstandings`
--
ALTER TABLE `useroutstandings`
  MODIFY `UO_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bankaccount`
--
ALTER TABLE `bankaccount`
  ADD CONSTRAINT `fk_to_user5` FOREIGN KEY (`BA_USER`) REFERENCES `user` (`USER_ID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `catalogs`
--
ALTER TABLE `catalogs`
  ADD CONSTRAINT `fk_to_user11` FOREIGN KEY (`C_LENDER`) REFERENCES `user` (`USER_ID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `lenderoutstanding`
--
ALTER TABLE `lenderoutstanding`
  ADD CONSTRAINT `fk_to_user10` FOREIGN KEY (`LO_BORROWER`) REFERENCES `user` (`USER_ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_to_user9` FOREIGN KEY (`LO_LENDER`) REFERENCES `user` (`USER_ID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `useroutstandings`
--
ALTER TABLE `useroutstandings`
  ADD CONSTRAINT `fk_to_user6` FOREIGN KEY (`UO_LENDER`) REFERENCES `user` (`USER_ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_to_user7` FOREIGN KEY (`UO_BORROWER`) REFERENCES `user` (`USER_ID`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
