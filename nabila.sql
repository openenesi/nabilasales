-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2018 at 07:48 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nabila`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `cid` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'C00000',
  `fname` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `oname` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` date NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_name` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `cid`, `fname`, `lname`, `oname`, `date_created`, `email`, `mobile_no`, `address`, `business_name`, `title`, `status`) VALUES
(1, '1', 'Rahama', 'Umar', NULL, '2018-10-22', 'rahama@rocketmail.com', '02033445332', 'Samaru Zaria', NULL, 'Mrs.', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `inv_ref` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `invoice_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `date_cancelled` datetime DEFAULT NULL,
  `cancellation_remark` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_rejected` datetime DEFAULT NULL,
  `rejection_remark` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_approved` datetime DEFAULT NULL,
  `approval_remark` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelled_by` int(11) DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loading`
--

CREATE TABLE `loading` (
  `loading_id` int(11) NOT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `received_by` int(11) DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `loading_date` datetime NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `quantity_received` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `purchase_rate` decimal(15,2) UNSIGNED NOT NULL,
  `truck_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_mobile_no` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `destination` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meter_ticket` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lh` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lh_received` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oh` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `oh_received` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ullage` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ullage_received` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_received` datetime DEFAULT NULL,
  `loading_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on-transit'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loading`
--

INSERT INTO `loading` (`loading_id`, `depot_id`, `product_id`, `created_by`, `received_by`, `date_created`, `loading_date`, `quantity`, `quantity_received`, `purchase_rate`, `truck_number`, `driver_name`, `driver_mobile_no`, `destination`, `meter_ticket`, `lh`, `lh_received`, `oh`, `oh_received`, `ullage`, `ullage_received`, `date_received`, `loading_status`) VALUES
(1, 2, 1, 1, NULL, '2018-10-15 13:37:43', '2018-10-10 13:34:27', 40000, 0, '138.00', 'XA419KD', 'Umar Ibrahim', '08054195327', 'Hotoro, Kano', '345321', '7676', NULL, '0909', NULL, '6767', NULL, NULL, 'on-transit'),
(2, 1, 1, 1, NULL, '2018-10-15 13:44:54', '2018-10-14 13:43:40', 40000, 0, '138.00', 'ABJ987KW', 'Umar Enesi', '08054195327', 'Zaria, Kaduna', '283682', '789', NULL, '456', NULL, '123', NULL, NULL, 'on-transit'),
(3, 1, 1, 1, NULL, '2018-10-15 13:47:07', '2018-10-14 13:43:40', 40000, 0, '138.00', 'ABJ987KW', 'Umar Enesi', '08054195327', 'Zaria, Kaduna', '283682', '789', NULL, '456', NULL, '123', NULL, NULL, 'on-transit'),
(4, 2, 1, 1, NULL, '2018-10-15 13:49:20', '2018-10-12 13:47:07', 40000, 0, '138.00', 'XA419KD', 'Umar Ibrahim', '08054195327', 'Hotoro, Kano', '09876', '443', NULL, '124', NULL, '920', NULL, NULL, 'on-transit'),
(5, 2, 1, 1, NULL, '2018-10-15 13:51:13', '2018-10-12 13:47:07', 40000, 0, '138.00', 'XA419KD', 'Umar Ibrahim', '08054195327', 'Hotoro, Kano', '09876', '443', NULL, '124', NULL, '920', NULL, NULL, 'on-transit'),
(6, 2, 1, 1, NULL, '2018-10-15 13:52:50', '2018-10-12 13:47:07', 40000, 0, '138.00', 'XA419KD', 'Umar Ibrahim', '08054195327', 'Hotoro, Kano', '09876', '443', NULL, '124', NULL, '920', NULL, NULL, 'on-transit'),
(7, 2, 1, 1, NULL, '2018-10-15 13:53:25', '2018-10-12 13:47:07', 40000, 0, '138.00', 'XA419KD', 'Umar Ibrahim', '08054195327', 'Hotoro, Kano', '09876', '443', NULL, '124', NULL, '920', NULL, NULL, 'on-transit'),
(8, 1, 2, 1, NULL, '2018-10-15 13:56:08', '2018-10-15 13:54:31', 30000, 0, '150.00', 'eiduhhgt', 'Kamal', '08054195999', 'Lagos', '97623', '213', NULL, '234', NULL, '132', NULL, NULL, 'on-transit');

-- --------------------------------------------------------

--
-- Table structure for table `loading_depot`
--

CREATE TABLE `loading_depot` (
  `depot_id` int(11) NOT NULL,
  `depot_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loading_depot`
--

INSERT INTO `loading_depot` (`depot_id`, `depot_name`) VALUES
(2, 'Oando'),
(1, 'Total');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `order_item_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `delivery_entered_by` int(11) DEFAULT NULL,
  `cancelled_by_id` int(11) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `unit_price` decimal(15,2) UNSIGNED NOT NULL,
  `quantity_ordered` int(10) UNSIGNED NOT NULL,
  `quantity_delivered` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `date_delivered` datetime DEFAULT NULL,
  `delivery_address` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_remark` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_cancelled` datetime DEFAULT NULL,
  `cancellation_remark` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancellation_initiated_by` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_item_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `org`
--

CREATE TABLE `org` (
  `org_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobileno` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `transaction_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `received_by` int(11) NOT NULL,
  `cancelled_by` int(11) DEFAULT NULL,
  `refunded_by` int(11) DEFAULT NULL,
  `diverted_by` int(11) DEFAULT NULL,
  `diverted_to` int(11) DEFAULT NULL,
  `t_ref` int(10) UNSIGNED NOT NULL,
  `trans_date` datetime NOT NULL,
  `date_created` datetime NOT NULL,
  `amount_paid` decimal(15,2) NOT NULL,
  `payment_method` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'accepted',
  `date_cancelled` datetime DEFAULT NULL,
  `cancellation_remark` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_refunded` datetime DEFAULT NULL,
  `refund_remark` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_diverted` datetime DEFAULT NULL,
  `diversion_remark` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_price` decimal(15,2) UNSIGNED NOT NULL,
  `product_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `unit_price`, `product_code`) VALUES
(1, 'Petrol', '138.00', 'PMS'),
(2, 'Diesel', '150.00', 'AGO');

-- --------------------------------------------------------

--
-- Table structure for table `productorder`
--

CREATE TABLE `productorder` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_placed_by` int(11) DEFAULT NULL,
  `cancelled_by_id` int(11) DEFAULT NULL,
  `o_ref` int(10) UNSIGNED NOT NULL,
  `order_date` datetime NOT NULL,
  `date_created` datetime NOT NULL,
  `initiated_by` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `date_cancelled` datetime DEFAULT NULL,
  `cancellation_remark` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancellation_initiated_by` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `truck`
--

CREATE TABLE `truck` (
  `truck_id` int(11) NOT NULL,
  `truck_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_mobile_no` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `truck_status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `truck`
--

INSERT INTO `truck` (`truck_id`, `truck_number`, `driver_name`, `driver_mobile_no`, `truck_status`) VALUES
(1, 'XA419KD', 'Umar Ibrahim', '08054195327', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `truck_expense`
--

CREATE TABLE `truck_expense` (
  `id` int(11) NOT NULL,
  `truck_id` int(11) NOT NULL,
  `entered_by` int(11) NOT NULL,
  `date_of_expense` datetime NOT NULL,
  `date_created` datetime NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pwd` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fname` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `oname` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profilepix` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'users/default.jpg',
  `status` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'enabled',
  `date_created` date NOT NULL,
  `last_login` datetime NOT NULL,
  `roles` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `pwd`, `fname`, `lname`, `oname`, `title`, `profilepix`, `status`, `date_created`, `last_login`, `roles`) VALUES
(1, 'ieumar', '$2y$12$Zkcqol2t7JrzBJEeW1p.2eGojxirzDYi7QzrIn5AWBgYXzy9Skwd6', 'Ibrahim', 'Umar', 'Enesi', 'Mal.', 'users/default.jpg', 'enabled', '2018-10-13', '2018-10-13 00:00:00', 'ROLE_MANAGER_SALES');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `UNIQ_81398E094B30D9C4` (`cid`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`),
  ADD UNIQUE KEY `UNIQ_90651744BF6E5548` (`inv_ref`),
  ADD KEY `IDX_906517448D9F6D38` (`order_id`),
  ADD KEY `IDX_9065174448CCCEFB` (`cancelled_by`),
  ADD KEY `IDX_906517447DC818F9` (`rejected_by`),
  ADD KEY `IDX_906517444EA3CB3D` (`approved_by`);

--
-- Indexes for table `loading`
--
ALTER TABLE `loading`
  ADD PRIMARY KEY (`loading_id`),
  ADD KEY `IDX_576038B48510D4DE` (`depot_id`),
  ADD KEY `IDX_576038B44584665A` (`product_id`),
  ADD KEY `IDX_576038B4DE12AB56` (`created_by`),
  ADD KEY `IDX_576038B438D350E7` (`received_by`);

--
-- Indexes for table `loading_depot`
--
ALTER TABLE `loading_depot`
  ADD PRIMARY KEY (`depot_id`),
  ADD UNIQUE KEY `UNIQ_8F730A32A94B13DC` (`depot_name`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `IDX_52EA1F094584665A` (`product_id`),
  ADD KEY `IDX_52EA1F0915BA0BEB` (`delivery_entered_by`),
  ADD KEY `IDX_52EA1F09187B2D12` (`cancelled_by_id`),
  ADD KEY `IDX_52EA1F098D9F6D38` (`order_id`);

--
-- Indexes for table `org`
--
ALTER TABLE `org`
  ADD PRIMARY KEY (`org_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`transaction_id`),
  ADD UNIQUE KEY `UNIQ_6D28840DB2304957` (`t_ref`),
  ADD KEY `IDX_6D28840D2989F1FD` (`invoice_id`),
  ADD KEY `IDX_6D28840D38D350E7` (`received_by`),
  ADD KEY `IDX_6D28840D48CCCEFB` (`cancelled_by`),
  ADD KEY `IDX_6D28840D8546B99D` (`refunded_by`),
  ADD KEY `IDX_6D28840DAAEAD0E0` (`diverted_by`),
  ADD KEY `IDX_6D28840D42A6D066` (`diverted_to`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `UNIQ_D34A04ADD3CB5CA7` (`product_name`);

--
-- Indexes for table `productorder`
--
ALTER TABLE `productorder`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `UNIQ_25E4C122A500EFC4` (`o_ref`),
  ADD KEY `IDX_25E4C1229395C3F3` (`customer_id`),
  ADD KEY `IDX_25E4C12272AC128B` (`order_placed_by`),
  ADD KEY `IDX_25E4C122187B2D12` (`cancelled_by_id`);

--
-- Indexes for table `truck`
--
ALTER TABLE `truck`
  ADD PRIMARY KEY (`truck_id`),
  ADD UNIQUE KEY `UNIQ_CDCCF30AF017FF2F` (`truck_number`);

--
-- Indexes for table `truck_expense`
--
ALTER TABLE `truck_expense`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_EA8BA2F2C6957CCE` (`truck_id`),
  ADD KEY `IDX_EA8BA2F2BFF9CCF` (`entered_by`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loading`
--
ALTER TABLE `loading`
  MODIFY `loading_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `loading_depot`
--
ALTER TABLE `loading_depot`
  MODIFY `depot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `org`
--
ALTER TABLE `org`
  MODIFY `org_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `productorder`
--
ALTER TABLE `productorder`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `truck`
--
ALTER TABLE `truck`
  MODIFY `truck_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `truck_expense`
--
ALTER TABLE `truck_expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `FK_9065174448CCCEFB` FOREIGN KEY (`cancelled_by`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `FK_906517444EA3CB3D` FOREIGN KEY (`approved_by`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `FK_906517447DC818F9` FOREIGN KEY (`rejected_by`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `FK_906517448D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `productorder` (`order_id`);

--
-- Constraints for table `loading`
--
ALTER TABLE `loading`
  ADD CONSTRAINT `FK_576038B438D350E7` FOREIGN KEY (`received_by`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `FK_576038B44584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `FK_576038B48510D4DE` FOREIGN KEY (`depot_id`) REFERENCES `loading_depot` (`depot_id`),
  ADD CONSTRAINT `FK_576038B4DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `FK_52EA1F0915BA0BEB` FOREIGN KEY (`delivery_entered_by`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `FK_52EA1F09187B2D12` FOREIGN KEY (`cancelled_by_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `FK_52EA1F094584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `FK_52EA1F098D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `productorder` (`order_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `FK_6D28840D2989F1FD` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`invoice_id`),
  ADD CONSTRAINT `FK_6D28840D38D350E7` FOREIGN KEY (`received_by`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `FK_6D28840D42A6D066` FOREIGN KEY (`diverted_to`) REFERENCES `invoice` (`invoice_id`),
  ADD CONSTRAINT `FK_6D28840D48CCCEFB` FOREIGN KEY (`cancelled_by`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `FK_6D28840D8546B99D` FOREIGN KEY (`refunded_by`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `FK_6D28840DAAEAD0E0` FOREIGN KEY (`diverted_by`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `productorder`
--
ALTER TABLE `productorder`
  ADD CONSTRAINT `FK_25E4C122187B2D12` FOREIGN KEY (`cancelled_by_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `FK_25E4C12272AC128B` FOREIGN KEY (`order_placed_by`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `FK_25E4C1229395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);

--
-- Constraints for table `truck_expense`
--
ALTER TABLE `truck_expense`
  ADD CONSTRAINT `FK_EA8BA2F2BFF9CCF` FOREIGN KEY (`entered_by`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `FK_EA8BA2F2C6957CCE` FOREIGN KEY (`truck_id`) REFERENCES `truck` (`truck_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
