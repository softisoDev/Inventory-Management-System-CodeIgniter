-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 08, 2019 at 06:26 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `billTypes`
--

CREATE TABLE `billTypes` (
  `ID` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('purchase','sale') COLLATE utf8mb4_unicode_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `billTypes`
--

INSERT INTO `billTypes` (`ID`, `name`, `type`, `isActive`) VALUES
(1, 'ÇIXIŞ', 'sale', 1),
(2, 'MASRAF', 'sale', 1),
(3, 'MÜŞTERİ', 'purchase', 1),
(4, 'DENGELEME', 'purchase', 1);

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `ID` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`ID`, `name`, `description`, `address`, `city`, `email`, `telephone`, `createdAt`, `updatedAt`, `isActive`) VALUES
(1, 'Naxçıvan Filialı', '', 'Heydər Əliyev prospekti', 'Naxçıvan', 'info@sample.com', '', '2019-03-02 00:00:00', '2019-07-28 09:43:48', 1),
(4, 'İstanbul filialı', '', 'Laleli, türkceli caddesi', 'İstanbul', 'info@sample.com', '', '2019-07-28 10:12:14', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`ID`, `name`, `description`, `createdAt`, `updatedAt`, `isActive`) VALUES
(1, 'CAT', NULL, '2019-02-24 00:00:00', NULL, 1),
(2, 'Mascotte', 'Tütün markası', '2019-06-30 07:14:13', NULL, 1),
(3, 'Greengo', 'Tütün markası', '2019-06-19 04:16:18', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `parentID` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `parentID`, `name`, `isActive`) VALUES
(1, 0, 'Yedek Parça', 1),
(2, 0, 'Tütün', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cigarette_types`
--

CREATE TABLE `cigarette_types` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `expTobac` double(15,2) NOT NULL,
  `unitID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cigarette_types`
--

INSERT INTO `cigarette_types` (`ID`, `name`, `expTobac`, `unitID`) VALUES
(2, 'Nano Size', 320.00, 5),
(4, 'King Size', 650.00, 5);

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `ID` int(11) NOT NULL,
  `name` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`ID`, `name`, `symbol`) VALUES
(1, 'AZN', '₼'),
(2, 'USD', '$'),
(3, 'EURO', '€');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `ID` int(11) NOT NULL,
  `branchID` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`ID`, `branchID`, `name`, `description`, `email`, `telephone`, `createdAt`, `updatedAt`, `isActive`) VALUES
(1, 1, 'Naxçıvan', NULL, NULL, NULL, '2019-03-02 00:00:00', NULL, 1),
(3, 1, 'Tobacco', '', 'info@sample.com', '', '2019-07-28 10:42:58', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `item_handlings`
--

CREATE TABLE `item_handlings` (
  `ID` int(11) NOT NULL,
  `slipID` int(11) NOT NULL,
  `slipType` enum('sale','purchase') COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouseFrom` int(11) DEFAULT NULL,
  `warehouseTo` int(11) DEFAULT NULL,
  `productID` int(11) NOT NULL,
  `productCode` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productTitle` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productUnit` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` double(15,6) NOT NULL,
  `price` double(15,2) NOT NULL,
  `discountValue` double(15,2) NOT NULL,
  `discount` double(15,2) NOT NULL,
  `VATValue` double(15,2) DEFAULT NULL,
  `VAT` double(15,2) DEFAULT NULL,
  `grassTotal` double(15,2) NOT NULL,
  `currency` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_handlings`
--

INSERT INTO `item_handlings` (`ID`, `slipID`, `slipType`, `warehouseFrom`, `warehouseTo`, `productID`, `productCode`, `productTitle`, `productUnit`, `quantity`, `price`, `discountValue`, `discount`, `VATValue`, `VAT`, `grassTotal`, `currency`, `icon`) VALUES
(15, 4, 'purchase', NULL, 1, 17, 'XAM-TTN-NS-006', 'VN-1 GRADE', 'KİLOGRAM', 45000.000000, 5.00, 0.00, 0.00, NULL, NULL, 225000.00, '₼', 'fa fa-plus'),
(16, 4, 'purchase', NULL, 1, 18, 'XAM-TTN-010', 'STAB-TK', 'KİLOGRAM', 45000.000000, 6.00, 0.00, 0.00, NULL, NULL, 270000.00, '₼', 'fa fa-plus'),
(17, 4, 'purchase', NULL, 1, 19, 'XAM-TTN-024', 'T2-M', 'KİLOGRAM', 45000.000000, 4.00, 0.00, 0.00, NULL, NULL, 180000.00, '₼', 'fa fa-plus'),
(18, 4, 'purchase', NULL, 1, 20, 'XAM-TTN-009', 'WANT S-B T2', 'KİLOGRAM', 45000.000000, 3.50, 0.00, 0.00, NULL, NULL, 157500.00, '₼', 'fa fa-plus'),
(19, 4, 'purchase', NULL, 1, 21, 'XAM-TTN-026', 'İZMİR ORİENTAL', 'KİLOGRAM', 45000.000000, 7.90, 0.00, 0.00, NULL, NULL, 355500.00, '₼', 'fa fa-plus'),
(20, 5, 'purchase', NULL, 1, 13, '43OP-HV5I-MKA0-Z39R', 'Muffler', 'ƏDƏD', 25.000000, 12.00, 0.00, 0.00, NULL, NULL, 300.00, '$', 'fa fa-plus'),
(21, 5, 'purchase', NULL, 1, 3, 'J4J7-WNKX-3CF5-W3Q6', 'Axle', 'ƏDƏD', 30.000000, 15.00, 0.00, 0.00, NULL, NULL, 450.00, '$', 'fa fa-plus'),
(22, 6, 'sale', 1, NULL, 13, '43OP-HV5I-MKA0-Z39R', 'Muffler', 'ƏDƏD', 12.000000, 45.00, 0.00, 0.00, NULL, NULL, 540.00, '$', 'fa fa-minus'),
(23, 6, 'sale', 1, NULL, 3, 'J4J7-WNKX-3CF5-W3Q6', 'Axle', 'ƏDƏD', 10.000000, 60.00, 0.00, 0.00, NULL, NULL, 600.00, '$', 'fa fa-minus'),
(24, 7, 'purchase', NULL, 1, 21, 'XAM-TTN-026', 'İZMİR ORİENTAL', 'KİLOGRAM', 20000.000000, 25.00, 0.00, 0.00, NULL, NULL, 500000.00, '₼', 'fa fa-plus'),
(25, 7, 'purchase', NULL, 1, 20, 'XAM-TTN-009', 'WANT S-B T2', 'KİLOGRAM', 15000.000000, 35.00, 0.00, 0.00, NULL, NULL, 525000.00, '₼', 'fa fa-plus');

-- --------------------------------------------------------

--
-- Table structure for table `item_slips`
--

CREATE TABLE `item_slips` (
  `ID` int(11) NOT NULL,
  `autoCode` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slipType` enum('sale','purchase','transfer') COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouseFrom` int(11) DEFAULT NULL,
  `warehouseTo` int(11) DEFAULT NULL,
  `billerID` int(11) DEFAULT NULL,
  `personID` int(11) DEFAULT NULL,
  `billType` int(11) DEFAULT NULL,
  `generalDiscountValue` double(15,2) DEFAULT NULL,
  `generalDiscount` double(15,2) DEFAULT NULL,
  `totalProductDiscount` double(15,2) DEFAULT NULL,
  `TotalDiscount` double(15,2) DEFAULT NULL,
  `VATvalue` double(15,2) DEFAULT NULL,
  `totalVAT` double(15,2) DEFAULT NULL,
  `grandTotal` double(15,2) NOT NULL,
  `total` double(15,2) NOT NULL,
  `currency` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `paymentTypeID` int(11) DEFAULT NULL,
  `paymentStatus` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waybill` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receivedBy` varchar(65) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requisitionID` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_slips`
--

INSERT INTO `item_slips` (`ID`, `autoCode`, `code`, `slipType`, `warehouseFrom`, `warehouseTo`, `billerID`, `personID`, `billType`, `generalDiscountValue`, `generalDiscount`, `totalProductDiscount`, `TotalDiscount`, `VATvalue`, `totalVAT`, `grandTotal`, `total`, `currency`, `paymentTypeID`, `paymentStatus`, `waybill`, `receivedBy`, `requisitionID`, `date`, `note`, `special1`, `special2`, `icon`, `updatedAt`, `updatedBy`, `userID`) VALUES
(4, 'IPS-000001', 'IPS-000001', 'purchase', NULL, 1, NULL, 1, 3, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1188000.00, 1188000.00, '₼', NULL, NULL, NULL, NULL, 0, '2019-07-24 13:38:05', '', '', '', 'fa fa-plus', NULL, NULL, 1),
(5, 'IPS-000002', 'IPS-000002', 'purchase', NULL, 1, NULL, 1, 3, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 750.00, 750.00, '$', NULL, NULL, NULL, NULL, 0, '2019-07-31 17:47:33', '', '', '', 'fa fa-plus', NULL, NULL, 1),
(6, 'ISS-000001', 'ISS-000001', 'sale', 1, NULL, 9, 4, 1, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 1140.00, 1140.00, '$', 1, 'paid', '', '', 0, '2019-07-31 18:07:31', '', '', '', 'fa fa-minus', NULL, NULL, 1),
(7, 'IPS-000003', 'IPS-000003', 'purchase', NULL, 1, NULL, 1, 3, 0.00, 0.00, 0.00, 0.00, NULL, NULL, 1025000.00, 1025000.00, '₼', NULL, NULL, NULL, NULL, 0, '2019-08-03 17:37:45', '', '', '', 'fa fa-plus', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `machines`
--

CREATE TABLE `machines` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `avgMC` int(11) NOT NULL,
  `cigTypeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `machines`
--

INSERT INTO `machines` (`ID`, `name`, `avgMC`, `cigTypeID`) VALUES
(1, 'Makina-1', 630, 2),
(2, 'Makina 2', 590, 4),
(3, 'LINE-1', 230, 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `ID` int(11) NOT NULL,
  `title` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `level` enum('low','medium','high') COLLATE utf8_unicode_ci NOT NULL,
  `createdAt` datetime NOT NULL,
  `readBy` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`ID`, `title`, `content`, `level`, `createdAt`, `readBy`) VALUES
(70, 'Stokta azalma', '<strong>Məhsul kodu: </strong> 43OP-HV5I-MKA0-Z39R<br/><strong>Məhsulun adı: </strong>: Muffler<br/><strong>Anbar: </strong>: Mərkəz<br/><strong>Qalan miqdar: </strong>: 13.00000<br/>', 'medium', '2019-07-31 18:07:32', '');

-- --------------------------------------------------------

--
-- Table structure for table `notification_types`
--

CREATE TABLE `notification_types` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notification_types`
--

INSERT INTO `notification_types` (`ID`, `name`) VALUES
(1, 'Stokta azalma');

-- --------------------------------------------------------

--
-- Table structure for table `paymentTypes`
--

CREATE TABLE `paymentTypes` (
  `ID` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isDefault` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paymentTypes`
--

INSERT INTO `paymentTypes` (`ID`, `name`, `isDefault`) VALUES
(1, 'Nəğd', 1),
(2, 'Bank', 0);

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE `persons` (
  `ID` int(11) NOT NULL,
  `personType` enum('supplier','customer','employee','biller') COLLATE utf8mb4_unicode_ci NOT NULL,
  `autoCode` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullName` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `companyName` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipCode` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special1` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` date DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `persons`
--

INSERT INTO `persons` (`ID`, `personType`, `autoCode`, `code`, `fullName`, `companyName`, `address`, `email`, `telephone`, `city`, `country`, `zipCode`, `special1`, `special2`, `createdAt`, `updatedAt`, `isActive`) VALUES
(1, 'supplier', 'SP-000001', 'FRM-000001', 'BORUSAN MAKİNA', 'BORUSAN MAKİNA', 'Nizami street', 'ismail.kali.2018@gmail.com', 'telephone', 'Baku', 'Azərbaycan', 'AZ1005', 'special-13', 'special-2', '2019-03-02 20:20:57', '0000-00-00', 1),
(2, 'supplier', 'SP-000002', 'AFRM-000002', 'HİTACHİ', 'HİTACHİ', '', 'noahlandtravel@gmail.com', 'telephone', '', 'Azərbaycan', '', '', '', '2019-03-02 20:22:10', '0000-00-00', 1),
(3, 'customer', 'CS-000001', 'FİRMA-000001', 'AVTOMEXANİKA', 'AVTOMEXANİKA', 'Nizami street', 'avtomekanika@gmail.com', '994557737979', 'Nakhchivan', 'Azərbaycan', 'AZ7005', '', '', '2019-03-03 11:35:19', NULL, 1),
(4, 'customer', 'CS-000002', 'CS-000002', 'Ləzzət MMC', 'Ləzzət MMC', '', '', '', '', '', '', '', '', '2019-06-30 12:23:45', NULL, 1),
(5, 'customer', 'CS-000003', 'CS-000003', 'Gəmiqaya Holdinq', 'Gəmiqaya Holdinq', '', '', '', '', '', '', '', '', '2019-06-30 12:23:45', NULL, 1),
(8, 'biller', 'BL-000001', 'BL-000001', 'John Doe', 'John Doe', 'Nizami street', '', '', 'Nakhchivan', 'Azərbaycan', 'AZ7002', '', '', '2019-03-03 11:35:19', NULL, 1),
(9, 'biller', 'BL-000002', 'BL-000002', 'Adrian Mutu', 'Adrian Mutu', 'Nizami street', '', '', 'Nakhchivan', 'Azərbaycan', 'AZ7006', '', '', '2019-03-03 11:35:19', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `premixes`
--

CREATE TABLE `premixes` (
  `ID` int(11) NOT NULL,
  `autoCode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `netAmount` double(15,6) NOT NULL,
  `initialAmount` double(15,6) NOT NULL,
  `unitID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `premixes`
--

INSERT INTO `premixes` (`ID`, `autoCode`, `code`, `name`, `netAmount`, `initialAmount`, `unitID`) VALUES
(2, 'PMX-000001', 'PMX-000001', 'Premix-1', 25928.400000, 31000.000000, 4),
(3, 'PMX-000002', 'PMX-000002', 'KENO-1', 930.000000, 930.000000, 4),
(4, 'PMX-000003', 'PMX-000003', 'KENO-2', 21829.500000, 22000.000000, 4);

-- --------------------------------------------------------

--
-- Table structure for table `premixes_items`
--

CREATE TABLE `premixes_items` (
  `ID` int(11) NOT NULL,
  `premixID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `warehouseID` int(11) NOT NULL,
  `ratio` int(11) DEFAULT NULL,
  `amount` double(15,6) NOT NULL,
  `unitID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `premixes_items`
--

INSERT INTO `premixes_items` (`ID`, `premixID`, `productID`, `warehouseID`, `ratio`, `amount`, `unitID`) VALUES
(5, 2, 20, 1, 4, 24800.000000, 4),
(6, 2, 21, 1, 1, 6200.000000, 4),
(7, 3, 19, 1, 1, 310.000000, 4),
(8, 3, 17, 1, 2, 620.000000, 4),
(9, 4, 21, 1, 5, 10000.000000, 4),
(10, 4, 20, 1, 6, 12000.000000, 4);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ID` int(11) NOT NULL,
  `autoCode` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `changableCode` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoryID` int(11) NOT NULL,
  `brandID` int(11) NOT NULL,
  `unitID` int(11) NOT NULL,
  `cost` double(15,2) DEFAULT NULL,
  `price` double(15,2) DEFAULT NULL,
  `price2` double(15,2) DEFAULT NULL,
  `VAT` double(8,2) DEFAULT NULL,
  `barcode` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode2` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stockAmount` double(15,2) NOT NULL,
  `criticStockAmount` double(15,2) NOT NULL,
  `shelfNo` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `createdBy` int(11) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ID`, `autoCode`, `code`, `changableCode`, `title`, `description`, `categoryID`, `brandID`, `unitID`, `cost`, `price`, `price2`, `VAT`, `barcode`, `barcode2`, `stockAmount`, `criticStockAmount`, `shelfNo`, `special1`, `special2`, `createdAt`, `updatedAt`, `createdBy`, `isActive`) VALUES
(1, 'PR-000001', 'YL9H-G85I-PUGP-IQ3J', 'AK-215', 'Breaks', 'this is desc', 1, 1, 2, 15.00, 18.00, NULL, 18.00, '2643580236117', NULL, 0.00, 5.00, 'A-80', NULL, NULL, '2019-02-23 00:00:00', NULL, 1, 1),
(2, 'PR-000002', 'O2Y6-D40D-14KV-GUNL', NULL, 'Battery', 'this is desc-2', 1, 1, 2, 20.00, 25.00, NULL, 18.00, '0670452657334', NULL, 0.00, 10.00, 'A-80', NULL, NULL, '2019-02-23 00:00:00', NULL, 1, 1),
(3, 'PR-000003', 'J4J7-WNKX-3CF5-W3Q6', NULL, 'Axle', 'this is desc-3', 1, 1, 2, 5.00, 8.00, NULL, 18.00, '1185445958891\r\n', NULL, 0.00, 15.00, 'A-80', NULL, NULL, '2019-02-23 00:00:00', NULL, 1, 1),
(4, 'PR-000004', 'CI0Y-JQTE-Y9XM-B17H', NULL, 'Fuel Injector', 'this is desc-4', 1, 1, 2, 20.00, 25.00, NULL, 18.00, '0679152657334', NULL, 0.00, 3.00, 'A-80', NULL, NULL, '2019-02-23 00:00:00', NULL, 1, 1),
(5, 'PR-000005', '0MDC-YP9B-N3A4-2GHI', '', 'Engine Fan', 'this is desc-5', 1, 1, 2, 5.00, 8.00, 0.00, 18.00, '6905716712282', '', 0.00, 20.00, 'A-80', '', '', '2019-02-23 00:00:00', '2019-06-07 10:05:42', 1, 1),
(6, 'PR-000006', '1EWQ-3K43-FIC9-L944', '', 'Piston', '', 1, 1, 2, 50.00, 180.00, 5.00, 0.00, '1812866707059', '', 0.00, 5.00, '12', '', '', '2019-02-28 16:28:12', NULL, 1, 1),
(7, 'PR-000007', '8FHC-30BT-TCXS-ACDG', '', 'A/C Compressor', '', 1, 1, 2, 0.00, 0.00, 0.00, 0.00, '8514681171680', '', 0.00, 2.00, '', '', '', '2019-02-28 16:31:26', NULL, 1, 1),
(8, 'PR-000008', '231M-XFM6-LEYU-IQV5', '', 'Car Jack', '', 1, 1, 2, 0.00, 0.00, 0.00, 0.00, '7340408225005', '', 0.00, 8.00, '252', '', '', '2019-03-05 13:10:41', NULL, 1, 1),
(9, 'PR-000009', 'WIET-II7Q-D9NA-S8IM', '', 'Spare Tire', '', 1, 1, 2, 0.00, 0.00, 0.00, 0.00, '2695499506744', '', 0.00, 0.00, '', '', '', '2019-03-05 13:10:52', NULL, 1, 1),
(10, 'PR-000010', 'UUCK-3PPD-TOVR-P39M', '', 'Transmission', '', 1, 1, 2, 0.00, 0.00, 0.00, 0.00, '0641357082693', '', 0.00, 0.00, '', '', '', '2019-03-05 13:11:07', NULL, 1, 1),
(11, 'PR-000011', 'TNZE-10NB-3X0P-0J8K', '', 'Spark Plug', '', 1, 1, 2, 0.00, 0.00, 0.00, 0.00, '9117883860230', '', 0.00, 0.00, '', '', '', '2019-03-05 13:11:18', NULL, 1, 1),
(12, 'PR-000012', '914I-WQ82-CT8X-6KKQ', '', 'Catalytic Converter', '', 1, 1, 2, 12.00, 15.00, 18.00, 0.00, '2148318543449', '', 0.00, 10.00, '', '', '', '2019-03-17 07:34:07', NULL, 1, 1),
(13, 'PR-000013', '43OP-HV5I-MKA0-Z39R', '', 'Muffler', '', 1, 1, 2, 60.00, 12.00, 20.00, 0.00, '9652958833615', '', 0.00, 15.00, '', '', '', '2019-03-17 07:35:07', NULL, 1, 1),
(14, 'PR-000014', '68KU-PYF9-EHBC-SIY8', '', 'Pressure Gauge', '', 1, 1, 2, 0.00, 0.00, 0.00, 0.00, '1606991975304', '', 0.00, 5.00, 'A-0001', '', '', '2019-06-04 14:24:46', NULL, 1, 1),
(15, 'PR-000015', 'XAM-TTN-019', '', 'ABL-2P', '', 2, 2, 4, 0.00, 0.00, 0.00, 0.00, '', '', 0.00, 10.00, 'A-0096', '', '', '2019-06-30 11:00:06', NULL, 1, 1),
(16, 'PR-000016', 'XAM-TTN-016', '', 'ABL-2V', '', 2, 3, 4, 0.00, 0.00, 0.00, 0.00, '', '', 0.00, 15.00, 'A-006', '', '', '2019-06-30 11:00:49', NULL, 1, 1),
(17, 'PR-000017', 'XAM-TTN-NS-006', '', 'VN-1 GRADE', '', 2, 2, 4, 0.00, 0.00, 0.00, 0.00, '', '', 38793.80, 2000.00, 'A-005', '', '', '2019-07-24 13:32:06', NULL, 1, 1),
(18, 'PR-000018', 'XAM-TTN-010', '', 'STAB-TK', '', 2, 3, 4, 0.00, 0.00, 0.00, 0.00, '', '', 39413.80, 300.00, 'A-0096', '', '', '2019-07-24 13:32:49', NULL, 1, 1),
(19, 'PR-000019', 'XAM-TTN-024', '', 'T2-M', '', 2, 2, 4, 0.00, 0.00, 0.00, 0.00, '', '', 39103.80, 3000.00, 'A-006', '', '', '2019-07-24 13:33:25', NULL, 1, 1),
(20, 'PR-000020', 'XAM-TTN-009', '', 'WANT S-B T2', '', 2, 2, 4, 0.00, 0.00, 0.00, 0.00, '', '', 20.00, 5000.00, 'A-006', '', '', '2019-07-24 13:34:06', NULL, 1, 1),
(21, 'PR-000021', 'XAM-TTN-026', '', 'İZMİR ORİENTAL', '', 2, 2, 4, 0.00, 0.00, 0.00, 0.00, '', '', 38800.00, 3500.00, 'A-008', '', '', '2019-07-24 13:34:38', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `ID` int(11) NOT NULL,
  `autoCode` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`ID`, `autoCode`, `code`, `title`, `createdAt`) VALUES
(4, 'RCP-000001', 'RCP-000001', 'KS KENO BLACK VE KENO RED (AZ)', '2019-07-24 11:43:38'),
(5, 'RCP-000002', 'RCP-000002', 'KARL RED DIAMOND', '2019-07-29 10:41:43'),
(6, 'RCP-000003', 'RCP-000003', 'KS FINE', '2019-08-03 15:52:11');

-- --------------------------------------------------------

--
-- Table structure for table `recipes_items`
--

CREATE TABLE `recipes_items` (
  `ID` int(11) NOT NULL,
  `recipeID` int(11) NOT NULL,
  `productID` int(11) DEFAULT NULL,
  `premixID` int(11) DEFAULT NULL,
  `warehouseID` int(11) DEFAULT NULL,
  `amount` double(15,5) NOT NULL,
  `unitID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `recipes_items`
--

INSERT INTO `recipes_items` (`ID`, `recipeID`, `productID`, `premixID`, `warehouseID`, `amount`, `unitID`) VALUES
(14, 4, 17, NULL, 1, 3.10000, 4),
(15, 4, 18, NULL, 1, 3.10000, 4),
(16, 4, 19, NULL, 1, 3.10000, 4),
(17, 4, NULL, 2, NULL, 3.10000, 4),
(18, 5, 17, NULL, 1, 3.10000, 4),
(19, 5, NULL, 3, NULL, 3.10000, 4),
(20, 6, 20, NULL, 1, 3.10000, 4),
(21, 6, 18, NULL, 1, 3.10000, 4),
(22, 6, NULL, 4, NULL, 3.10000, 4);

--
-- Triggers `recipes_items`
--
DELIMITER $$
CREATE TRIGGER `Set_NULL_lEmpty_FK_Fields` BEFORE INSERT ON `recipes_items` FOR EACH ROW BEGIN
/*
	IF new.productID = '' THEN
    	SET new.productID = NULL;
    END IF;
    IF new.warehouseID = '' THEN
    	SET new.warehouseID = NULL;
    END IF;
    IF new.premixID = '' THEN
    	SET new.premixID = NULL;
    END IF;
*/
SET NEW.productID=NULLIF(NEW.productID,0);
SET NEW.productID=NULLIF(NEW.productID,"");
SET NEW.warehouseID=NULLIF(NEW.warehouseID,0);
SET NEW.warehouseID=NULLIF(NEW.warehouseID,"");
SET NEW.premixID=NULLIF(NEW.premixID,0);
SET NEW.premixID=NULLIF(NEW.premixID,"");
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `requisitions`
--

CREATE TABLE `requisitions` (
  `ID` int(11) NOT NULL,
  `autoCode` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approvedBy` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receivedBy` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `requisitions`
--

INSERT INTO `requisitions` (`ID`, `autoCode`, `code`, `approvedBy`, `receivedBy`, `date`, `note`, `special1`, `special2`, `icon`, `updatedAt`, `updatedBy`, `userID`) VALUES
(1, 'AVTO-0000001', 'RQ-00000001', 'Ismayil Aliyev', 'Filankes', '2019-03-08 06:00:00', NULL, NULL, NULL, 'fa fa-', NULL, NULL, 1),
(2, 'AVTO-0000002', 'RQ-00000002', 'Ismayil Aliyev', 'Filankes', '2019-03-08 06:00:00', NULL, NULL, NULL, 'fa fa-', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `requisition_items`
--

CREATE TABLE `requisition_items` (
  `ID` int(11) NOT NULL,
  `requisitionID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `productCode` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productTitle` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productUnit` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` double(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `ID` int(11) NOT NULL,
  `autoCode` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `recipeID` int(11) NOT NULL,
  `machineID` int(11) NOT NULL,
  `ctID` int(11) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `isDone` tinyint(1) NOT NULL DEFAULT '0',
  `isActive` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`ID`, `autoCode`, `name`, `description`, `recipeID`, `machineID`, `ctID`, `startDate`, `endDate`, `isDone`, `isActive`) VALUES
(1, 'TSK-000001', 'Task-1', '', 4, 1, 2, '2019-07-25', '2019-08-30', 0, 1),
(2, 'TSK-000002', 'avqust', '', 5, 1, 2, '2019-07-29', '2019-07-31', 0, 1),
(3, 'TSK-000003', 'Agustos', '', 6, 3, 2, '2019-08-03', '2019-08-31', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `task_logs`
--

CREATE TABLE `task_logs` (
  `ID` int(11) NOT NULL,
  `taskID` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `prepMC` double(15,2) NOT NULL,
  `logDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `task_logs`
--

INSERT INTO `task_logs` (`ID`, `taskID`, `content`, `prepMC`, `logDate`) VALUES
(4, 1, NULL, 650.00, '2019-07-27'),
(5, 1, NULL, 500.00, '2019-07-28'),
(6, 1, NULL, 640.00, '2019-07-29'),
(7, 1, NULL, 380.00, '2019-07-30'),
(8, 1, NULL, 250.00, '2019-08-02'),
(9, 1, NULL, 2000.00, '2019-08-03'),
(10, 3, NULL, 110.00, '2019-08-03');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `ID` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shortName` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1',
  `isDeletable` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`ID`, `name`, `shortName`, `isActive`, `isDeletable`) VALUES
(1, 'KİLOMETR', 'KM', 1, 0),
(2, 'ƏDƏD', 'ƏDƏD', 1, 0),
(3, 'BOBİN', 'BOBİN', 1, 1),
(4, 'KİLOGRAM', 'KG', 1, 0),
(5, 'MİLLİGRAM', 'MG', 1, 0),
(6, 'METR', 'M', 1, 0),
(7, 'GRAM', 'GR', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `uname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` text COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(65) COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default.png',
  `isActive` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `uname`, `password`, `name`, `surname`, `email`, `img`, `isActive`) VALUES
(1, 'yalcin', 'abfaca55b8d0ca4ea5ae5f3aa54c682fff13c729', 'Yalçın', 'Çolak', 'ismayil.developer@gmail.com', 'default.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE `warehouse` (
  `ID` int(11) NOT NULL,
  `branchID` int(11) NOT NULL,
  `departmentID` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `personInCharge` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`ID`, `branchID`, `departmentID`, `name`, `description`, `personInCharge`, `createdAt`, `updatedAt`, `isActive`) VALUES
(1, 1, 1, 'Mərkəz', '', 'John Doe', '2019-03-02 04:12:15', '2019-07-28 22:27:26', 1),
(2, 1, 1, 'Alt Depo', NULL, 'Filankəsov Filankəs', '2019-03-02 04:12:15', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_products`
--

CREATE TABLE `warehouse_products` (
  `ID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `warehouseID` int(11) NOT NULL,
  `productIn` double(15,6) NOT NULL,
  `productOut` double(15,6) NOT NULL,
  `netQuantity` double(15,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warehouse_products`
--

INSERT INTO `warehouse_products` (`ID`, `productID`, `warehouseID`, `productIn`, `productOut`, `netQuantity`) VALUES
(34, 17, 1, 45000.000000, 6206.200000, 38793.800000),
(35, 18, 1, 45000.000000, 5756.700000, 39243.300000),
(36, 19, 1, 45000.000000, 5896.200000, 39103.800000),
(37, 20, 1, 60000.000000, 36970.500000, 23029.500000),
(38, 21, 1, 65000.000000, 16200.000000, 48800.000000),
(39, 13, 1, 25.000000, 12.000000, 13.000000),
(40, 3, 1, 30.000000, 10.000000, 20.000000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billTypes`
--
ALTER TABLE `billTypes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `cigarette_types`
--
ALTER TABLE `cigarette_types`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `unitID` (`unitID`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `branchID` (`branchID`);

--
-- Indexes for table `item_handlings`
--
ALTER TABLE `item_handlings`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `item_slips`
--
ALTER TABLE `item_slips`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `autoCode` (`autoCode`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `machines`
--
ALTER TABLE `machines`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `cigTypeID` (`cigTypeID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `notification_types`
--
ALTER TABLE `notification_types`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `paymentTypes`
--
ALTER TABLE `paymentTypes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `persons`
--
ALTER TABLE `persons`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `premixes`
--
ALTER TABLE `premixes`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `autoCode` (`autoCode`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `premixes_items`
--
ALTER TABLE `premixes_items`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `premixID` (`premixID`),
  ADD KEY `productID` (`productID`),
  ADD KEY `warehouseID` (`warehouseID`),
  ADD KEY `unitID` (`unitID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `autoCode` (`autoCode`),
  ADD KEY `brandID` (`brandID`),
  ADD KEY `categoryID` (`categoryID`),
  ADD KEY `unitID` (`unitID`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `title` (`title`),
  ADD UNIQUE KEY `autoCode` (`autoCode`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `recipes_items`
--
ALTER TABLE `recipes_items`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `recipeID` (`recipeID`),
  ADD KEY `productID` (`productID`),
  ADD KEY `warehouseID` (`warehouseID`),
  ADD KEY `premixID` (`premixID`);

--
-- Indexes for table `requisitions`
--
ALTER TABLE `requisitions`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `autoCode` (`autoCode`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `requisition_items`
--
ALTER TABLE `requisition_items`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `task_logs`
--
ALTER TABLE `task_logs`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `taskID` (`taskID`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `shortName` (`shortName`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `branchID` (`branchID`),
  ADD KEY `departmentID` (`departmentID`);

--
-- Indexes for table `warehouse_products`
--
ALTER TABLE `warehouse_products`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `productID` (`productID`),
  ADD KEY `warehouseID` (`warehouseID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billTypes`
--
ALTER TABLE `billTypes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cigarette_types`
--
ALTER TABLE `cigarette_types`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `item_handlings`
--
ALTER TABLE `item_handlings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `item_slips`
--
ALTER TABLE `item_slips`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `machines`
--
ALTER TABLE `machines`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `notification_types`
--
ALTER TABLE `notification_types`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `paymentTypes`
--
ALTER TABLE `paymentTypes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `persons`
--
ALTER TABLE `persons`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `premixes`
--
ALTER TABLE `premixes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `premixes_items`
--
ALTER TABLE `premixes_items`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `recipes_items`
--
ALTER TABLE `recipes_items`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `requisitions`
--
ALTER TABLE `requisitions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `requisition_items`
--
ALTER TABLE `requisition_items`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `task_logs`
--
ALTER TABLE `task_logs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `warehouse`
--
ALTER TABLE `warehouse`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `warehouse_products`
--
ALTER TABLE `warehouse_products`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cigarette_types`
--
ALTER TABLE `cigarette_types`
  ADD CONSTRAINT `cigarette_types_ibfk_1` FOREIGN KEY (`unitID`) REFERENCES `units` (`ID`);

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_ibfk_1` FOREIGN KEY (`branchID`) REFERENCES `branch` (`ID`);

--
-- Constraints for table `machines`
--
ALTER TABLE `machines`
  ADD CONSTRAINT `machines_ibfk_1` FOREIGN KEY (`cigTypeID`) REFERENCES `cigarette_types` (`ID`);

--
-- Constraints for table `premixes_items`
--
ALTER TABLE `premixes_items`
  ADD CONSTRAINT `premixes_items_ibfk_1` FOREIGN KEY (`premixID`) REFERENCES `premixes` (`ID`),
  ADD CONSTRAINT `premixes_items_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`ID`),
  ADD CONSTRAINT `premixes_items_ibfk_3` FOREIGN KEY (`warehouseID`) REFERENCES `warehouse` (`ID`),
  ADD CONSTRAINT `premixes_items_ibfk_4` FOREIGN KEY (`unitID`) REFERENCES `units` (`ID`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`brandID`) REFERENCES `brands` (`ID`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`categoryID`) REFERENCES `categories` (`ID`),
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`unitID`) REFERENCES `units` (`ID`);

--
-- Constraints for table `recipes_items`
--
ALTER TABLE `recipes_items`
  ADD CONSTRAINT `recipes_items_ibfk_1` FOREIGN KEY (`recipeID`) REFERENCES `recipes` (`ID`),
  ADD CONSTRAINT `recipes_items_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`ID`),
  ADD CONSTRAINT `recipes_items_ibfk_3` FOREIGN KEY (`warehouseID`) REFERENCES `warehouse` (`ID`),
  ADD CONSTRAINT `recipes_items_ibfk_4` FOREIGN KEY (`premixID`) REFERENCES `premixes` (`ID`);

--
-- Constraints for table `task_logs`
--
ALTER TABLE `task_logs`
  ADD CONSTRAINT `task_logs_ibfk_1` FOREIGN KEY (`taskID`) REFERENCES `tasks` (`ID`);

--
-- Constraints for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD CONSTRAINT `warehouse_ibfk_1` FOREIGN KEY (`branchID`) REFERENCES `branch` (`ID`),
  ADD CONSTRAINT `warehouse_ibfk_2` FOREIGN KEY (`departmentID`) REFERENCES `departments` (`ID`);

--
-- Constraints for table `warehouse_products`
--
ALTER TABLE `warehouse_products`
  ADD CONSTRAINT `warehouse_products_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `products` (`ID`),
  ADD CONSTRAINT `warehouse_products_ibfk_2` FOREIGN KEY (`warehouseID`) REFERENCES `warehouse` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
