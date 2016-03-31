-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2016 at 10:45 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gl_appraisal`
--

-- --------------------------------------------------------

--
-- Table structure for table `appraisal`
--

CREATE TABLE `appraisal` (
  `id` int(100) NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'appraisal type/label'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appraisal_rate`
--

CREATE TABLE `appraisal_rate` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'appraisal rate label',
  `val` int(1) NOT NULL COMMENT 'value of appraisal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_appraisal`
--

CREATE TABLE `employee_appraisal` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `eid` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT 'employee id',
  `process` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'process belongs to',
  `doj` date NOT NULL COMMENT 'date of joining',
  `period` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Appraisal for period (like 2014-15)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `major_resoponsbilties` text COLLATE utf8_unicode_ci NOT NULL,
  `extra_mile` text COLLATE utf8_unicode_ci NOT NULL,
  `manager_lead_comment` text COLLATE utf8_unicode_ci NOT NULL,
  `notable_accomplishments` text COLLATE utf8_unicode_ci NOT NULL,
  `overall_fb` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'overall feedback given by Manager'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hierarchy`
--

CREATE TABLE `hierarchy` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `mngr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pwd` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `aprsl_id` int(11) NOT NULL COMMENT 'appraisal id',
  `aprsl_val` int(11) NOT NULL COMMENT 'appraisal value',
  `comment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `self_manager` enum('S','M') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'S' COMMENT 'S - self, M - manager'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appraisal`
--
ALTER TABLE `appraisal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appraisal_rate`
--
ALTER TABLE `appraisal_rate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_appraisal`
--
ALTER TABLE `employee_appraisal`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`eid`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emp_id` (`emp_id`);

--
-- Indexes for table `hierarchy`
--
ALTER TABLE `hierarchy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appraisal`
--
ALTER TABLE `appraisal`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `appraisal_rate`
--
ALTER TABLE `appraisal_rate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee_appraisal`
--
ALTER TABLE `employee_appraisal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `hierarchy`
--
ALTER TABLE `hierarchy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `manager`
--
ALTER TABLE `manager`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
