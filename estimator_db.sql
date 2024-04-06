-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2019 at 12:02 AM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `estimator`
--

-- --------------------------------------------------------

--
-- Table structure for table `base_type`
--

CREATE TABLE `base_type` (
  `base_id` int(10) NOT NULL,
  `base_type` varchar(30) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(5) NOT NULL,
  `brand_name` varchar(30) NOT NULL,
  `base_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(10) NOT NULL,
  `cat_name` varchar(50) NOT NULL,
  `type_id` int(5) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `costumers_db`
--

CREATE TABLE `costumers_db` (
  `costumer_id` int(4) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `phone` int(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `number` int(4) NOT NULL,
  `street` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `county` varchar(30) NOT NULL,
  `user_id` int(10) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `estimates`
--

CREATE TABLE `estimates` (
  `est_item_id` int(10) NOT NULL,
  `estimate_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `item_name` varchar(30) NOT NULL,
  `total_area` double NOT NULL,
  `no_coats` int(5) NOT NULL,
  `painting_price` double NOT NULL,
  `painting_time` double NOT NULL,
  `include_paint` varchar(5) NOT NULL,
  `paint_brand` varchar(30) NOT NULL,
  `finish_type` varchar(25) NOT NULL,
  `paint_base` varchar(30) NOT NULL,
  `paint_amount` double NOT NULL,
  `paint_price` double NOT NULL,
  `include_primer` varchar(5) NOT NULL,
  `primer_name` varchar(50) NOT NULL,
  `primer_brand` varchar(30) NOT NULL,
  `primer_base` varchar(30) NOT NULL,
  `primer_amount` double NOT NULL,
  `primer_price` double NOT NULL,
  `primer_time` double NOT NULL,
  `include_materials` varchar(5) NOT NULL,
  `materials` varchar(100) NOT NULL,
  `materials_price` double NOT NULL,
  `include_prep` varchar(5) NOT NULL,
  `prep` varchar(100) NOT NULL,
  `prep_time` double NOT NULL,
  `prep_price` double NOT NULL,
  `total_time` double NOT NULL,
  `total_price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `finish_type`
--

CREATE TABLE `finish_type` (
  `finish_id` int(10) NOT NULL,
  `finish_type` varchar(30) NOT NULL,
  `brand_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(10) NOT NULL,
  `item_name` varchar(40) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `labour_price`
--

CREATE TABLE `labour_price` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `prep_price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `material_id` int(5) NOT NULL,
  `type` varchar(50) NOT NULL,
  `price` double NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `measure_price`
--

CREATE TABLE `measure_price` (
  `measure_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `measure_type` varchar(10) NOT NULL,
  `area_m2` double NOT NULL,
  `measure_price` double NOT NULL,
  `time_minutes` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `paint_info`
--

CREATE TABLE `paint_info` (
  `paint_id` int(5) NOT NULL,
  `base_id` int(10) NOT NULL,
  `brand_id` int(10) NOT NULL,
  `coverage_m2` int(10) NOT NULL,
  `price` double NOT NULL,
  `finish_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `preparation_works`
--

CREATE TABLE `preparation_works` (
  `prep_id` int(5) NOT NULL,
  `prep_name` varchar(100) NOT NULL,
  `prep_description` varchar(150) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `primers_undercoats`
--

CREATE TABLE `primers_undercoats` (
  `primer_id` int(5) NOT NULL,
  `primer_name` varchar(30) NOT NULL,
  `primer_brand` varchar(30) NOT NULL,
  `primer_base` varchar(30) NOT NULL,
  `primer_coverage` double NOT NULL,
  `primer_price` double NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(4) NOT NULL,
  `user_id` int(10) NOT NULL,
  `project_name` varchar(50) NOT NULL,
  `number` int(5) NOT NULL,
  `street` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `county` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `registered_users`
--

CREATE TABLE `registered_users` (
  `id_num` int(4) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `phone_number` int(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `user_addr` varchar(100) NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `work_type`
--

CREATE TABLE `work_type` (
  `type_id` int(5) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `work_type`
--

INSERT INTO `work_type` (`type_id`, `type`) VALUES
(1, 'Interior'),
(2, 'exterior');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `base_type`
--
ALTER TABLE `base_type`
  ADD PRIMARY KEY (`base_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `costumers_db`
--
ALTER TABLE `costumers_db`
  ADD PRIMARY KEY (`costumer_id`);

--
-- Indexes for table `estimates`
--
ALTER TABLE `estimates`
  ADD PRIMARY KEY (`est_item_id`);

--
-- Indexes for table `finish_type`
--
ALTER TABLE `finish_type`
  ADD PRIMARY KEY (`finish_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `labour_price`
--
ALTER TABLE `labour_price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`material_id`);

--
-- Indexes for table `measure_price`
--
ALTER TABLE `measure_price`
  ADD PRIMARY KEY (`measure_id`);

--
-- Indexes for table `paint_info`
--
ALTER TABLE `paint_info`
  ADD PRIMARY KEY (`paint_id`);

--
-- Indexes for table `preparation_works`
--
ALTER TABLE `preparation_works`
  ADD PRIMARY KEY (`prep_id`);

--
-- Indexes for table `primers_undercoats`
--
ALTER TABLE `primers_undercoats`
  ADD PRIMARY KEY (`primer_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `registered_users`
--
ALTER TABLE `registered_users`
  ADD PRIMARY KEY (`id_num`);

--
-- Indexes for table `work_type`
--
ALTER TABLE `work_type`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `base_type`
--
ALTER TABLE `base_type`
  MODIFY `base_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `costumers_db`
--
ALTER TABLE `costumers_db`
  MODIFY `costumer_id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimates`
--
ALTER TABLE `estimates`
  MODIFY `est_item_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `finish_type`
--
ALTER TABLE `finish_type`
  MODIFY `finish_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `labour_price`
--
ALTER TABLE `labour_price`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `material_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `measure_price`
--
ALTER TABLE `measure_price`
  MODIFY `measure_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paint_info`
--
ALTER TABLE `paint_info`
  MODIFY `paint_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `preparation_works`
--
ALTER TABLE `preparation_works`
  MODIFY `prep_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `primers_undercoats`
--
ALTER TABLE `primers_undercoats`
  MODIFY `primer_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registered_users`
--
ALTER TABLE `registered_users`
  MODIFY `id_num` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `work_type`
--
ALTER TABLE `work_type`
  MODIFY `type_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
