-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2023 at 09:58 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hehegroceries`
--

-- --------------------------------------------------------

--
-- Table structure for table `mscategory`
--

CREATE TABLE `mscategory` (
  `CategoryID` char(5) NOT NULL CHECK (`CategoryID` regexp '^CT[0-9][0-9][0-9]$'),
  `CategoryName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mscategory`
--

INSERT INTO `mscategory` (`CategoryID`, `CategoryName`) VALUES
('CT001', 'Dairy'),
('CT002', 'Vegetable'),
('CT003', 'Fruit'),
('CT004', 'Meat'),
('CT005', 'Condiment');

-- --------------------------------------------------------

--
-- Table structure for table `mscustomer`
--

CREATE TABLE `mscustomer` (
  `CustomerID` char(5) NOT NULL CHECK (`CustomerID` regexp '^CU[0-9][0-9][0-9]$'),
  `CustomerName` varchar(50) NOT NULL,
  `CustomerGender` varchar(10) NOT NULL,
  `CustomerAddress` varchar(50) NOT NULL,
  `CustomerEmail` varchar(50) NOT NULL,
  `CustomerDOB` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mscustomer`
--

INSERT INTO `mscustomer` (`CustomerID`, `CustomerName`, `CustomerGender`, `CustomerAddress`, `CustomerEmail`, `CustomerDOB`) VALUES
('CU001', 'Dirk Titterell', 'Male', '74 Melvin Point', 'dtitterell0@yellowpages.com', '2003-10-29'),
('CU002', 'Dukey Diano', 'Male', '92 Sugar Alley', 'ddiano1@state.com', '2003-09-27'),
('CU003', 'Alex Meekins', 'Male', '577 Dovetail Park', 'ameekins2@blogs.com', '1996-11-06'),
('CU004', 'Cherice Jermey', 'Female', '811 Debs Street', 'cjermey3@guardian.com', '2000-05-18'),
('CU005', 'Ingamar Carlin', 'Male', '389 Surrey Pass', 'icarlin4@shareasale.com', '2003-08-08'),
('CU006', 'Pooh McCutcheon', 'Male', '7 Melby Trail', 'pmccutcheon5@salon.com', '2001-08-03'),
('CU007', 'Silvain Jozsa', 'Female', '19269 Maryland Hill', 'sjozsa6@omniture.com', '2003-12-30'),
('CU008', 'Javier Drewson', 'Female', '8 Moulton Point', 'jdrewson7@home.com', '1996-08-20'),
('CU009', 'Wilbur Francino', 'Female', '21840 Golden Leaf Avenue', 'wfrancino8@wunderground.com', '2003-10-06'),
('CU010', 'Sadie Snow', 'Female', '70 Eagle Crest Hill', 'ssnow9@github.com', '2004-04-25'),
('CU011', 'Sofie Carmen', 'Female', '20196 Springview Plaza', 'scarmena@gov.com', '2000-11-20'),
('CU012', 'Amy Grenkov', 'Male', '2263 Weeping Birch Center', 'agrenkovb@aol.com', '2003-06-06'),
('CU013', 'Gabriela Scarf', 'Female', '920 Bobwhite Trail', 'gscarfc@skype.com', '2004-03-12'),
('CU014', 'Westley Boram', 'Female', '47 Darwin Terrace', 'wboramd@sun.com', '2003-09-03'),
('CU015', 'Hadleigh Playfoot', 'Female', '49 6th Junction', 'hplayfoote@msu.com', '2004-04-14');

-- --------------------------------------------------------

--
-- Table structure for table `msemployee`
--

CREATE TABLE `msemployee` (
  `EmployeeID` char(5) NOT NULL CHECK (`EmployeeID` regexp '^EM[0-9][0-9][0-9]$'),
  `EmployeeName` varchar(50) NOT NULL,
  `EmployeeGender` varchar(10) NOT NULL,
  `EmployeeAddress` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `msemployee`
--

INSERT INTO `msemployee` (`EmployeeID`, `EmployeeName`, `EmployeeGender`, `EmployeeAddress`) VALUES
('EM001', 'Clem', 'Male', '0975 Forest Dale Trail'),
('EM002', 'Dene', 'Male', '2 Grayhawk Parkway'),
('EM003', 'Lethia', 'Female', '905 Goodland Lane'),
('EM004', 'Tyrone', 'Male', '51745 Bowman Hill'),
('EM005', 'Shanda', 'Male', '848 New Castle Center'),
('EM006', 'Nani', 'Male', '3455 Village Green Court'),
('EM007', 'Dorothea', 'Male', '772 Goodland Park'),
('EM008', 'Chet', 'Female', '1 Merchant Street'),
('EM009', 'Darsie', 'Female', '31718 Toban Point'),
('EM010', 'Don', 'Male', '936 Lyons Plaza'),
('EM011', 'Tabby', 'Male', '10787 School Drive'),
('EM012', 'Desmond', 'Male', '8 Lien Junction'),
('EM013', 'Robenia', 'Female', '4 Dapin Avenue'),
('EM014', 'Curr', 'Female', '2 Veith Terrace'),
('EM015', 'Rudd', 'Male', '2 Hermina Park');

-- --------------------------------------------------------

--
-- Table structure for table `msproduct`
--

CREATE TABLE `msproduct` (
  `ProductID` char(5) NOT NULL CHECK (`ProductID` regexp '^PR[0-9][0-9][0-9]$'),
  `CategoryID` char(5) NOT NULL,
  `ProductName` varchar(50) NOT NULL,
  `ProductPrice` float NOT NULL,
  `ProductStock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `msproduct`
--

INSERT INTO `msproduct` (`ProductID`, `CategoryID`, `ProductName`, `ProductPrice`, `ProductStock`) VALUES
('PR001', 'CT003', 'Honeycrisp Apples', 1.49, 300),
('PR002', 'CT002', 'Yellow Carrots', 1.49, 200),
('PR003', 'CT004', 'Sockeye Salmon', 9.99, 100),
('PR004', 'CT001', 'Mozarella Cheese', 5.99, 50),
('PR005', 'CT003', 'Seville Oranges', 0.99, 300),
('PR006', 'CT002', 'Purple Carrots', 1.49, 200),
('PR007', 'CT004', 'Free-Range Chicken Breast', 8.99, 150),
('PR008', 'CT002', 'Organic Spinach', 2.49, 150),
('PR009', 'CT001', 'Cheddar Cheese', 4.99, 50),
('PR010', 'CT002', 'Campari Tomatoes', 1.49, 200),
('PR011', 'CT004', 'Atlantic Salmon', 9.99, 100),
('PR012', 'CT001', 'Gouda Cheese', 5.99, 50),
('PR013', 'CT002', 'Wild Spinach', 2.49, 150),
('PR014', 'CT003', 'Golden Delicious Apples', 0.99, 300),
('PR015', 'CT001', 'Unsalted Butter', 3.49, 100),
('PR016', 'CT002', 'Baby Spinach', 2.49, 150),
('PR017', 'CT003', 'Valencia Oranges', 0.99, 300),
('PR018', 'CT004', 'Coho Salmon', 9.99, 100),
('PR019', 'CT002', 'Baby Carrots', 1.49, 200),
('PR020', 'CT001', 'Feta Cheese', 3.99, 50),
('PR021', 'CT003', 'Granny Smith Apples', 0.99, 300),
('PR022', 'CT004', 'Wild-Caught Salmon', 9.99, 100),
('PR023', 'CT002', 'Sweet Carrots', 1.49, 200),
('PR024', 'CT003', 'Moro Oranges', 0.99, 300),
('PR025', 'CT001', 'Whole Milk', 2.99, 100),
('PR026', 'CT003', 'Navel Oranges', 0.99, 300),
('PR027', 'CT002', 'Cherry Tomatoes', 1.49, 200),
('PR028', 'CT001', 'Salted Butter', 3.49, 100),
('PR029', 'CT003', 'Braeburn Apples', 1.49, 300),
('PR030', 'CT002', 'San Marzano Tomatoes', 1.49, 200),
('PR031', 'CT001', '2% Milk', 2.99, 100),
('PR032', 'CT002', 'Roma Tomatoes', 1.49, 200),
('PR033', 'CT004', 'Mature Spinach', 2.49, 150),
('PR034', 'CT001', 'Blue Cheese', 6.99, 50),
('PR035', 'CT003', 'Pink Lady Apples', 1.49, 300),
('PR036', 'CT002', 'Yellow Cherry Tomatoes', 1.49, 200),
('PR037', 'CT004', 'Wild-Caught Tuna', 12.99, 100),
('PR038', 'CT001', 'Goat Cheese', 5.99, 50),
('PR039', 'CT003', 'Red Delicious Apples', 0.99, 300),
('PR040', 'CT002', 'Heirloom Tomatoes', 2.49, 150),
('PR041', 'CT004', 'Wild-Caught Halibut', 14.99, 100),
('PR042', 'CT001', 'Swiss Cheese', 4.99, 50),
('PR043', 'CT002', 'Beefsteak Tomatoes', 1.49, 200),
('PR044', 'CT003', 'Bosc Pears', 1.49, 300),
('PR045', 'CT004', 'Wild-Caught Sole', 11.99, 100),
('PR046', 'CT001', 'Goat Milk', 3.99, 30);

-- --------------------------------------------------------

--
-- Table structure for table `transactiondetail`
--

CREATE TABLE `transactiondetail` (
  `TransactionID` char(5) NOT NULL,
  `ProductID` char(5) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactiondetail`
--

INSERT INTO `transactiondetail` (`TransactionID`, `ProductID`, `Quantity`) VALUES
('TR001', 'PR003', 5),
('TR001', 'PR008', 10),
('TR001', 'PR013', 20),
('TR001', 'PR038', 15),
('TR002', 'PR016', 20),
('TR002', 'PR022', 7),
('TR002', 'PR025', 3),
('TR002', 'PR042', 12),
('TR003', 'PR001', 2),
('TR003', 'PR006', 6),
('TR003', 'PR017', 9),
('TR003', 'PR020', 4),
('TR004', 'PR014', 11),
('TR004', 'PR028', 5),
('TR004', 'PR039', 17),
('TR004', 'PR040', 20),
('TR005', 'PR011', 7),
('TR005', 'PR030', 2),
('TR005', 'PR037', 15),
('TR005', 'PR041', 10),
('TR006', 'PR002', 20),
('TR006', 'PR008', 12),
('TR006', 'PR019', 5),
('TR006', 'PR036', 8),
('TR007', 'PR013', 11),
('TR007', 'PR021', 3),
('TR007', 'PR024', 15),
('TR007', 'PR042', 17),
('TR008', 'PR014', 3),
('TR008', 'PR028', 7),
('TR008', 'PR038', 12),
('TR008', 'PR039', 20),
('TR009', 'PR005', 17),
('TR009', 'PR011', 20),
('TR009', 'PR016', 3),
('TR009', 'PR022', 11),
('TR010', 'PR003', 12),
('TR010', 'PR007', 7),
('TR010', 'PR037', 3),
('TR010', 'PR039', 20),
('TR011', 'PR019', 7),
('TR011', 'PR022', 3),
('TR011', 'PR038', 12),
('TR011', 'PR040', 20),
('TR012', 'PR002', 3),
('TR012', 'PR008', 20),
('TR012', 'PR025', 12),
('TR012', 'PR037', 7),
('TR013', 'PR014', 7),
('TR013', 'PR028', 3),
('TR013', 'PR038', 20),
('TR013', 'PR039', 12),
('TR014', 'PR013', 12),
('TR014', 'PR021', 7),
('TR014', 'PR024', 3),
('TR014', 'PR042', 20),
('TR015', 'PR014', 20),
('TR015', 'PR028', 3),
('TR015', 'PR038', 7),
('TR015', 'PR039', 12),
('TR016', 'PR005', 7),
('TR016', 'PR011', 20),
('TR016', 'PR016', 3),
('TR016', 'PR022', 12),
('TR017', 'PR003', 12),
('TR017', 'PR007', 7),
('TR017', 'PR037', 3),
('TR017', 'PR039', 20),
('TR018', 'PR019', 7),
('TR018', 'PR022', 3),
('TR018', 'PR038', 12),
('TR018', 'PR040', 20),
('TR019', 'PR002', 3),
('TR019', 'PR008', 20),
('TR019', 'PR025', 12),
('TR019', 'PR037', 7),
('TR020', 'PR014', 7),
('TR020', 'PR028', 3),
('TR020', 'PR038', 20),
('TR020', 'PR039', 12),
('TR021', 'PR013', 12),
('TR021', 'PR021', 7),
('TR021', 'PR024', 3),
('TR021', 'PR042', 20),
('TR022', 'PR014', 20),
('TR022', 'PR028', 3),
('TR022', 'PR038', 7),
('TR022', 'PR039', 12),
('TR023', 'PR005', 7),
('TR023', 'PR011', 20),
('TR023', 'PR016', 3),
('TR023', 'PR022', 12),
('TR024', 'PR003', 12),
('TR024', 'PR007', 7),
('TR024', 'PR037', 3),
('TR024', 'PR039', 20),
('TR025', 'PR019', 7),
('TR025', 'PR022', 3),
('TR025', 'PR038', 12),
('TR025', 'PR040', 20),
('TR026', 'PR002', 3),
('TR026', 'PR008', 20),
('TR026', 'PR025', 12),
('TR026', 'PR037', 7),
('TR027', 'PR014', 7),
('TR027', 'PR028', 3),
('TR027', 'PR038', 20),
('TR027', 'PR039', 12),
('TR028', 'PR013', 12),
('TR028', 'PR021', 7),
('TR028', 'PR024', 3),
('TR028', 'PR042', 20),
('TR029', 'PR014', 20),
('TR029', 'PR028', 3),
('TR029', 'PR038', 7),
('TR029', 'PR039', 12),
('TR030', 'PR005', 7),
('TR030', 'PR011', 20),
('TR030', 'PR016', 3),
('TR030', 'PR022', 12),
('TR031', 'PR003', 12),
('TR031', 'PR007', 7),
('TR031', 'PR037', 3),
('TR031', 'PR039', 20),
('TR032', 'PR019', 7),
('TR032', 'PR022', 3),
('TR032', 'PR038', 12),
('TR032', 'PR040', 20),
('TR033', 'PR002', 3),
('TR033', 'PR008', 20),
('TR033', 'PR025', 12),
('TR033', 'PR037', 7),
('TR034', 'PR014', 7),
('TR034', 'PR028', 3),
('TR034', 'PR038', 20),
('TR034', 'PR039', 12),
('TR035', 'PR013', 12),
('TR035', 'PR021', 7),
('TR035', 'PR024', 3),
('TR035', 'PR042', 20),
('TR036', 'PR014', 20),
('TR036', 'PR028', 3),
('TR036', 'PR038', 7),
('TR036', 'PR039', 12),
('TR037', 'PR005', 7),
('TR037', 'PR011', 20),
('TR037', 'PR016', 3),
('TR037', 'PR022', 12),
('TR038', 'PR003', 12),
('TR038', 'PR007', 7),
('TR038', 'PR037', 3),
('TR038', 'PR039', 20),
('TR039', 'PR019', 7),
('TR039', 'PR022', 3),
('TR039', 'PR038', 12),
('TR039', 'PR040', 20),
('TR040', 'PR002', 3),
('TR040', 'PR008', 20),
('TR040', 'PR025', 12),
('TR040', 'PR037', 7),
('TR041', 'PR014', 7),
('TR041', 'PR028', 3),
('TR041', 'PR038', 20),
('TR041', 'PR039', 12),
('TR042', 'PR013', 12),
('TR042', 'PR021', 7),
('TR042', 'PR024', 3),
('TR042', 'PR042', 20),
('TR043', 'PR014', 20),
('TR043', 'PR028', 3),
('TR043', 'PR038', 7),
('TR043', 'PR039', 12),
('TR044', 'PR005', 7),
('TR044', 'PR011', 20),
('TR044', 'PR016', 3),
('TR044', 'PR022', 12),
('TR045', 'PR003', 12),
('TR045', 'PR007', 7),
('TR045', 'PR037', 3),
('TR045', 'PR039', 20),
('TR046', 'PR019', 7),
('TR046', 'PR022', 3),
('TR046', 'PR038', 12),
('TR046', 'PR040', 20),
('TR047', 'PR002', 3),
('TR047', 'PR008', 20),
('TR047', 'PR025', 12),
('TR047', 'PR037', 7),
('TR048', 'PR014', 7),
('TR048', 'PR028', 3),
('TR048', 'PR038', 20),
('TR048', 'PR039', 12),
('TR049', 'PR013', 12),
('TR049', 'PR021', 7),
('TR049', 'PR024', 3),
('TR049', 'PR042', 20),
('TR050', 'PR014', 20),
('TR050', 'PR028', 3),
('TR050', 'PR038', 7),
('TR050', 'PR039', 12),
('TR051', 'PR005', 7),
('TR051', 'PR011', 20),
('TR051', 'PR016', 3),
('TR051', 'PR022', 12),
('TR052', 'PR003', 12),
('TR052', 'PR007', 7),
('TR052', 'PR037', 3),
('TR052', 'PR039', 20),
('TR053', 'PR019', 7),
('TR053', 'PR022', 3),
('TR053', 'PR038', 12),
('TR053', 'PR040', 20),
('TR054', 'PR002', 3),
('TR054', 'PR008', 20),
('TR054', 'PR025', 12),
('TR054', 'PR037', 7),
('TR055', 'PR014', 7),
('TR055', 'PR028', 3),
('TR055', 'PR038', 20),
('TR055', 'PR039', 12),
('TR056', 'PR013', 12),
('TR056', 'PR021', 7),
('TR056', 'PR024', 3),
('TR056', 'PR042', 20),
('TR057', 'PR014', 20),
('TR057', 'PR028', 3),
('TR057', 'PR038', 7),
('TR057', 'PR039', 12),
('TR058', 'PR005', 7),
('TR058', 'PR011', 20),
('TR058', 'PR016', 3),
('TR058', 'PR022', 12),
('TR059', 'PR003', 12),
('TR059', 'PR007', 7),
('TR059', 'PR037', 3),
('TR059', 'PR039', 20),
('TR060', 'PR019', 7),
('TR060', 'PR022', 3),
('TR060', 'PR038', 12),
('TR060', 'PR040', 20),
('TR061', 'PR002', 3),
('TR061', 'PR008', 20),
('TR061', 'PR025', 12),
('TR061', 'PR037', 7),
('TR062', 'PR014', 7),
('TR062', 'PR028', 3),
('TR062', 'PR038', 20),
('TR062', 'PR039', 12),
('TR063', 'PR013', 12),
('TR063', 'PR021', 7),
('TR063', 'PR024', 3),
('TR063', 'PR042', 20),
('TR064', 'PR014', 20),
('TR064', 'PR028', 3),
('TR064', 'PR038', 7),
('TR064', 'PR039', 12),
('TR065', 'PR005', 7),
('TR065', 'PR011', 20),
('TR065', 'PR016', 3),
('TR065', 'PR022', 12),
('TR066', 'PR003', 12),
('TR066', 'PR007', 7),
('TR066', 'PR037', 3),
('TR066', 'PR039', 20),
('TR067', 'PR019', 7),
('TR067', 'PR022', 3),
('TR067', 'PR038', 12),
('TR067', 'PR040', 20),
('TR068', 'PR002', 3),
('TR068', 'PR008', 20),
('TR068', 'PR025', 12),
('TR068', 'PR037', 7),
('TR069', 'PR014', 7),
('TR069', 'PR028', 3),
('TR069', 'PR038', 20),
('TR069', 'PR039', 12);

-- --------------------------------------------------------

--
-- Table structure for table `transactionheader`
--

CREATE TABLE `transactionheader` (
  `TransactionID` char(5) NOT NULL CHECK (`TransactionID` regexp '^TR[0-9][0-9][0-9]$'),
  `EmployeeID` char(5) NOT NULL,
  `CustomerID` char(5) NOT NULL,
  `TransactionDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactionheader`
--

INSERT INTO `transactionheader` (`TransactionID`, `EmployeeID`, `CustomerID`, `TransactionDate`) VALUES
('TR001', 'EM006', 'CU002', '2022-05-01'),
('TR002', 'EM005', 'CU003', '2022-07-02'),
('TR003', 'EM011', 'CU001', '2022-02-14'),
('TR004', 'EM014', 'CU007', '2022-10-20'),
('TR005', 'EM005', 'CU008', '2022-12-25'),
('TR006', 'EM009', 'CU009', '2022-06-06'),
('TR007', 'EM011', 'CU015', '2022-01-01'),
('TR008', 'EM013', 'CU005', '2022-03-02'),
('TR009', 'EM014', 'CU013', '2022-08-09'),
('TR010', 'EM009', 'CU002', '2022-09-01'),
('TR011', 'EM013', 'CU008', '2022-07-12'),
('TR012', 'EM006', 'CU014', '2022-11-25'),
('TR013', 'EM005', 'CU001', '2022-10-31'),
('TR014', 'EM009', 'CU003', '2022-12-24'),
('TR015', 'EM005', 'CU010', '2022-04-12'),
('TR016', 'EM011', 'CU011', '2022-02-14'),
('TR017', 'EM006', 'CU013', '2022-05-17'),
('TR018', 'EM005', 'CU002', '2022-07-04'),
('TR019', 'EM009', 'CU005', '2022-01-18'),
('TR020', 'EM014', 'CU009', '2022-06-06'),
('TR021', 'EM009', 'CU014', '2022-03-17'),
('TR022', 'EM014', 'CU006', '2022-08-15'),
('TR023', 'EM005', 'CU007', '2022-12-25'),
('TR024', 'EM009', 'CU015', '2022-10-31'),
('TR025', 'EM006', 'CU010', '2022-11-01'),
('TR026', 'EM014', 'CU005', '2022-02-14'),
('TR027', 'EM009', 'CU008', '2022-04-12'),
('TR028', 'EM014', 'CU014', '2022-07-04'),
('TR029', 'EM005', 'CU009', '2022-08-09'),
('TR030', 'EM014', 'CU001', '2022-12-24'),
('TR031', 'EM005', 'CU006', '2022-05-17'),
('TR032', 'EM009', 'CU011', '2022-10-20'),
('TR033', 'EM014', 'CU002', '2022-11-25'),
('TR034', 'EM005', 'CU010', '2022-09-01'),
('TR035', 'EM014', 'CU003', '2022-06-06'),
('TR036', 'EM011', 'CU007', '2022-01-06'),
('TR037', 'EM009', 'CU013', '2022-03-02'),
('TR038', 'EM005', 'CU014', '2022-08-09'),
('TR039', 'EM014', 'CU005', '2022-09-01'),
('TR040', 'EM009', 'CU001', '2022-07-12'),
('TR041', 'EM013', 'CU009', '2022-11-25'),
('TR042', 'EM006', 'CU006', '2022-10-31'),
('TR043', 'EM009', 'CU008', '2022-12-24'),
('TR044', 'EM014', 'CU015', '2022-04-12'),
('TR045', 'EM005', 'CU011', '2022-02-14'),
('TR046', 'EM009', 'CU002', '2022-05-17'),
('TR047', 'EM006', 'CU003', '2022-07-04'),
('TR048', 'EM014', 'CU007', '2022-02-01'),
('TR049', 'EM009', 'CU014', '2022-06-06'),
('TR050', 'EM014', 'CU010', '2022-03-17'),
('TR051', 'EM005', 'CU005', '2022-08-15'),
('TR052', 'EM014', 'CU013', '2022-12-25'),
('TR053', 'EM005', 'CU009', '2022-10-31'),
('TR054', 'EM006', 'CU006', '2022-11-01'),
('TR055', 'EM009', 'CU008', '2022-02-14'),
('TR056', 'EM014', 'CU014', '2022-04-12'),
('TR057', 'EM005', 'CU009', '2022-07-04'),
('TR058', 'EM014', 'CU001', '2022-08-09'),
('TR059', 'EM005', 'CU006', '2022-12-24'),
('TR060', 'EM009', 'CU011', '2022-05-17'),
('TR061', 'EM014', 'CU002', '2022-10-20'),
('TR062', 'EM005', 'CU010', '2022-11-25'),
('TR063', 'EM014', 'CU003', '2022-09-01'),
('TR064', 'EM011', 'CU007', '2022-06-06'),
('TR065', 'EM009', 'CU013', '2022-03-02'),
('TR066', 'EM005', 'CU014', '2022-08-09'),
('TR067', 'EM014', 'CU005', '2022-09-01'),
('TR068', 'EM009', 'CU001', '2022-07-12'),
('TR069', 'EM013', 'CU009', '2022-11-25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mscategory`
--
ALTER TABLE `mscategory`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `mscustomer`
--
ALTER TABLE `mscustomer`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `msemployee`
--
ALTER TABLE `msemployee`
  ADD PRIMARY KEY (`EmployeeID`);

--
-- Indexes for table `msproduct`
--
ALTER TABLE `msproduct`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `CategoryID` (`CategoryID`);

--
-- Indexes for table `transactiondetail`
--
ALTER TABLE `transactiondetail`
  ADD UNIQUE KEY `idx_detailtransaction` (`TransactionID`,`ProductID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `transactionheader`
--
ALTER TABLE `transactionheader`
  ADD PRIMARY KEY (`TransactionID`),
  ADD KEY `EmployeeID` (`EmployeeID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `msproduct`
--
ALTER TABLE `msproduct`
  ADD CONSTRAINT `msproduct_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `mscategory` (`CategoryID`);

--
-- Constraints for table `transactiondetail`
--
ALTER TABLE `transactiondetail`
  ADD CONSTRAINT `transactiondetail_ibfk_1` FOREIGN KEY (`TransactionID`) REFERENCES `transactionheader` (`TransactionID`) ON DELETE CASCADE,
  ADD CONSTRAINT `transactiondetail_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `msproduct` (`ProductID`) ON DELETE CASCADE;

--
-- Constraints for table `transactionheader`
--
ALTER TABLE `transactionheader`
  ADD CONSTRAINT `transactionheader_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `msemployee` (`EmployeeID`),
  ADD CONSTRAINT `transactionheader_ibfk_2` FOREIGN KEY (`CustomerID`) REFERENCES `mscustomer` (`CustomerID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
