-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2024 at 08:46 AM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `UserType` enum('admin','passenger') NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdminID`, `Username`, `Password`, `Name`, `Email`, `Phone`, `UserType`) VALUES
(2, 'admin', '$2y$10$jhoyoxuj6f/FcTebsEaacuaZVdWVn.ktVg9846OkVY3lMtGvjfSo6', 'admin', 'admin@gmail', '1234', 'admin'),
(3, 'admin2', '$2y$10$445AofyFmyJTPxCJqqOisuIYOT91nNffclIesqNqeBpUiU8dxMKBi', 'admin2', 'admin2@gmail.com', '8838383', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `BookingID` int(11) NOT NULL,
  `PassengerID` int(11) NOT NULL,
  `TripID` int(11) NOT NULL,
  `BookingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `NumSeatsBooked` int(11) NOT NULL,
  `TotalFare` decimal(10,2) NOT NULL,
  `PaymentMethod` varchar(50) NOT NULL,
  `DiscountID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`BookingID`, `PassengerID`, `TripID`, `BookingDate`, `NumSeatsBooked`, `TotalFare`, `PaymentMethod`, `DiscountID`) VALUES
(10, 1, 1, '2024-05-06 15:37:29', 3, '1350.00', '', NULL),
(13, 1, 2, '2024-05-06 16:02:04', 4, '2400.00', 'cash', NULL),
(20, 1, 1, '2024-05-06 18:30:47', 5, '2700.00', '', NULL),
(23, 1, 1, '2024-05-06 18:33:59', 1, '450.00', 'bank_transfer', NULL),
(24, 1, 5, '2024-05-07 17:01:49', 1, '2250.00', '', NULL),
(25, 1, 1, '2024-05-07 21:26:20', 2, '900.00', '', NULL),
(26, 1, 1, '2024-05-07 21:26:23', 2, '900.00', 'cash', NULL),
(27, 4, 5, '2024-05-07 21:32:40', 2, '4500.00', '', NULL),
(28, 4, 5, '2024-05-07 21:32:45', 2, '4500.00', 'cash', NULL),
(29, 4, 5, '2024-05-07 21:35:20', 2, '4500.00', 'mobile_money', NULL),
(30, 4, 5, '2024-05-07 21:35:32', 2, '4500.00', 'bank_transfer', NULL),
(31, 4, 5, '2024-05-07 21:35:51', 10, '7500.00', '', NULL),
(32, 4, 5, '2024-05-07 21:35:56', 10, '7500.00', 'bank_transfer', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `bushiring`
--

CREATE TABLE `bushiring` (
  `BusHiringID` int(11) NOT NULL,
  `PassengerID` int(11) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `TotalDistance` decimal(10,2) NOT NULL,
  `TotalCost` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bushiring`
--

INSERT INTO `bushiring` (`BusHiringID`, `PassengerID`, `StartDate`, `EndDate`, `TotalDistance`, `TotalCost`) VALUES
(17, 1, '2024-05-08', '2024-05-08', '10.00', '10000.00'),
(18, 1, '2024-05-02', '2024-05-08', '10.00', '110000.00');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `DiscountID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Amount` decimal(5,2) NOT NULL,
  `Eligibility` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`DiscountID`, `Name`, `Amount`, `Eligibility`) VALUES
(1, 'Children', '0.50', 'Children below the age of 16'),
(2, 'Elderly', '0.50', 'Any person over the age of 70'),
(3, 'Student', '0.25', 'Any person studying up to tertiary level'),
(4, 'Inter-Regional', '0.10', 'Any person travelling between 2 regions'),
(5, 'KabweRewards', '1.00', 'Any person travelling with the bus line for the 5th time in a month (After 5th trip, reset discount ');

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `DriverID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `LicenseNumber` varchar(50) NOT NULL,
  `Certification` varchar(100) DEFAULT NULL,
  `PerformanceRating` decimal(3,2) DEFAULT NULL,
  `Suspended` tinyint(1) DEFAULT 0,
  `SuspensionEndDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`DriverID`, `Username`, `Password`, `Name`, `LicenseNumber`, `Certification`, `PerformanceRating`, `Suspended`, `SuspensionEndDate`) VALUES
(1, 'emzo', '', 'new customer', 'jdjfj', 'nfnfn', '0.00', 0, NULL),
(2, 'emzowe', '', 'new customer', 'jdjfj', 'nfnfn', '0.00', 0, NULL),
(3, 'emzowww', '', 'new customerdd', 'jdjfjdd', 'nfnfn', '9.99', 0, NULL),
(5, 'emzowwwdd', '', 'new customerdd', 'jdjfjdd', 'nfnfndd', '9.99', 0, NULL),
(6, 'emzo22', '', 'new customer33', 'jdjfjd', 'nfnfnee', '9.99', 0, NULL),
(7, 'emzosss', '', 'new customerssssss', 'jdjfjdd', 'nfnfndd2', '9.99', 0, NULL),
(9, 'emzoie', '', 'new customer', 'jdjfjdd', 'nfnfn', '9.99', 0, '2024-06-03'),
(10, 'emzodd', '', 'daily products', 'jdjfjdd', 'yes', '9.99', 0, NULL),
(11, 'emzoD', '', 'new customer', 'jdjfj', 'nfnfn', '9.99', 0, '2024-06-04');

-- --------------------------------------------------------

--
-- Table structure for table `fuel_refills`
--

CREATE TABLE `fuel_refills` (
  `RefillID` int(11) NOT NULL,
  `VehicleID` int(11) DEFAULT NULL,
  `RefillDate` date DEFAULT NULL,
  `FuelQuantity` decimal(10,2) DEFAULT NULL,
  `Cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fuel_refills`
--

INSERT INTO `fuel_refills` (`RefillID`, `VehicleID`, `RefillDate`, `FuelQuantity`, `Cost`) VALUES
(1, 1, '2024-05-11', '10000.00', '3000.00'),
(2, 2, '2024-05-10', '10000.00', '3000.00'),
(3, 2, '2024-05-10', '1000044.00', '3000444.00');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_schedule`
--

CREATE TABLE `maintenance_schedule` (
  `MaintenanceID` int(11) NOT NULL,
  `VehicleID` int(11) NOT NULL,
  `MaintenanceType` varchar(50) NOT NULL,
  `DueDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `maintenance_schedule`
--

INSERT INTO `maintenance_schedule` (`MaintenanceID`, `VehicleID`, `MaintenanceType`, `DueDate`) VALUES
(1, 1, '23', '2024-05-10'),
(2, 1, '23', '2024-05-08'),
(3, 3, 'fg', '2024-05-10');

-- --------------------------------------------------------

--
-- Table structure for table `passenger`
--

CREATE TABLE `passenger` (
  `PassengerID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Age` int(11) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `UserType` enum('admin','passenger') NOT NULL DEFAULT 'passenger'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `passenger`
--

INSERT INTO `passenger` (`PassengerID`, `Username`, `Password`, `Name`, `Age`, `Email`, `Phone`, `UserType`) VALUES
(1, 'emzo', '$2y$10$udztxYWS319DKGOSA9n1LOjGtlF6FLGYRU1LN2k7qy16txE9Ft0KW', 'sampleuser', 78, 'sampleuser@gmail.com', '9899', 'passenger'),
(3, 'xmzo', '$2y$10$VcKthb83bo40J5OmcB6sve5.oeUaNWTKRss4FVz4ROI2Vt1PVnyW.', 'sampleuser', 78, 'sampleuser@gmail.com', '9899', 'passenger'),
(4, 'sampleuser', '$2y$10$EOcKFtWOOAteXYGlrT.x5OoijZe1xRTMffLG5kJ6F3PKgFwG919ea', 'sample', 21, 'sampleuser@gmail.com', '98999', 'passenger');

-- --------------------------------------------------------

--
-- Table structure for table `passenger_discounts`
--

CREATE TABLE `passenger_discounts` (
  `PassengerID` int(11) NOT NULL,
  `DiscountID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trips`
--

CREATE TABLE `trips` (
  `TripID` int(11) NOT NULL,
  `DepartureDate` date NOT NULL,
  `DepartureTime` time NOT NULL,
  `Destination` varchar(100) NOT NULL,
  `AvailableSeats` int(11) NOT NULL,
  `FarePerKm` decimal(10,2) NOT NULL,
  `VehicleID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trips`
--

INSERT INTO `trips` (`TripID`, `DepartureDate`, `DepartureTime`, `Destination`, `AvailableSeats`, `FarePerKm`, `VehicleID`) VALUES
(1, '2024-05-15', '08:00:00', 'Blantyre or whatever', 7, '600.00', 1),
(2, '2024-05-16', '09:00:00', 'Limbe', 10, '600.00', 2),
(3, '2024-05-17', '10:00:00', 'Ntechu', 5, '600.00', 1),
(4, '2024-05-16', '12:34:00', 'Limbe', 0, '1000.00', 1),
(5, '2024-05-24', '08:50:00', 'Blantyer', 7, '3000.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `VehicleID` int(11) NOT NULL,
  `VehicleNumber` varchar(20) NOT NULL,
  `Model` varchar(50) NOT NULL,
  `Year` int(11) NOT NULL,
  `Mileage` int(11) DEFAULT NULL,
  `LastServiceDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`VehicleID`, `VehicleNumber`, `Model`, `Year`, `Mileage`, `LastServiceDate`) VALUES
(1, '', 'sjd', 2000, 2000, NULL),
(2, '', 'sjd', 2000, 2000, NULL),
(3, '', 'sjd', 2000, 2000, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `PassengerID` (`PassengerID`),
  ADD KEY `TripID` (`TripID`),
  ADD KEY `DiscountID` (`DiscountID`);

--
-- Indexes for table `bushiring`
--
ALTER TABLE `bushiring`
  ADD PRIMARY KEY (`BusHiringID`),
  ADD KEY `bushiring_ibfk_1` (`PassengerID`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`DiscountID`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`DriverID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `fuel_refills`
--
ALTER TABLE `fuel_refills`
  ADD PRIMARY KEY (`RefillID`),
  ADD KEY `VehicleID` (`VehicleID`);

--
-- Indexes for table `maintenance_schedule`
--
ALTER TABLE `maintenance_schedule`
  ADD PRIMARY KEY (`MaintenanceID`),
  ADD KEY `VehicleID` (`VehicleID`);

--
-- Indexes for table `passenger`
--
ALTER TABLE `passenger`
  ADD PRIMARY KEY (`PassengerID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `passenger_discounts`
--
ALTER TABLE `passenger_discounts`
  ADD PRIMARY KEY (`PassengerID`,`DiscountID`),
  ADD KEY `DiscountID` (`DiscountID`);

--
-- Indexes for table `trips`
--
ALTER TABLE `trips`
  ADD PRIMARY KEY (`TripID`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`VehicleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `bushiring`
--
ALTER TABLE `bushiring`
  MODIFY `BusHiringID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `DiscountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `DriverID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `fuel_refills`
--
ALTER TABLE `fuel_refills`
  MODIFY `RefillID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `maintenance_schedule`
--
ALTER TABLE `maintenance_schedule`
  MODIFY `MaintenanceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `passenger`
--
ALTER TABLE `passenger`
  MODIFY `PassengerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `trips`
--
ALTER TABLE `trips`
  MODIFY `TripID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `VehicleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`PassengerID`) REFERENCES `passenger` (`PassengerID`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`TripID`) REFERENCES `trips` (`TripID`),
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`DiscountID`) REFERENCES `discounts` (`DiscountID`);

--
-- Constraints for table `bushiring`
--
ALTER TABLE `bushiring`
  ADD CONSTRAINT `bushiring_ibfk_1` FOREIGN KEY (`PassengerID`) REFERENCES `passenger` (`PassengerID`);

--
-- Constraints for table `fuel_refills`
--
ALTER TABLE `fuel_refills`
  ADD CONSTRAINT `fuel_refills_ibfk_1` FOREIGN KEY (`VehicleID`) REFERENCES `vehicle` (`VehicleID`);

--
-- Constraints for table `maintenance_schedule`
--
ALTER TABLE `maintenance_schedule`
  ADD CONSTRAINT `maintenance_schedule_ibfk_1` FOREIGN KEY (`VehicleID`) REFERENCES `vehicle` (`VehicleID`);

--
-- Constraints for table `passenger_discounts`
--
ALTER TABLE `passenger_discounts`
  ADD CONSTRAINT `passenger_discounts_ibfk_1` FOREIGN KEY (`PassengerID`) REFERENCES `passenger` (`PassengerID`),
  ADD CONSTRAINT `passenger_discounts_ibfk_2` FOREIGN KEY (`DiscountID`) REFERENCES `discounts` (`DiscountID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
