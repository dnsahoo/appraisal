-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2016 at 12:03 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `gl_appraisal`
--

-- --------------------------------------------------------

--
-- Table structure for table `appraisal`
--

CREATE TABLE `appraisal` (
  `id` int(100) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'appraisal type/label'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `appraisal`
--

INSERT INTO `appraisal` (`id`, `type`) VALUES
(1, 'Taking Responsibility : (Completes assignments in a thorough, accurate, and timely manner that achieves expected outcomes.'),
(2, 'Problem Solving : (Identifies and analyzes problems; formulates alternative solutions; takes or recommends appropriate actions; follows up to ensure problems are resolved)'),
(3, 'Collaboration/Teamwork: (Maintain harmonious and effective work relationships with co-workers and team members)'),
(4, 'Produces functional deliverables within committed timelines'),
(5, 'Produces functional deliverables with respect to committed quality level'),
(6, 'Coverage planning with respect to business requirement (Only for those handling teams)'),
(7, 'Providing scope to Professional develepment of team members'),
(8, 'Client relationship management ( Escalation management, response to client,  sharing reports on timely basis, showcasing organisation commitment )'),
(9, 'Self Learning (Openness dfor learning new skills and capabilities, partcipation in skill development programs driven by Organisation, Apply learnings on the job )');

-- --------------------------------------------------------

--
-- Table structure for table `appraisalrate`
--

CREATE TABLE `appraisalrate` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'appraisal rate label',
  `val` int(1) NOT NULL COMMENT 'value of appraisal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `appraisalrate`
--

INSERT INTO `appraisalrate` (`id`, `name`, `val`) VALUES
(1, 'Not meets Expectations', 1),
(2, 'Partially Meets Expectations', 2),
(3, 'Meets Expectations', 3),
(4, 'Exceeding Expectations', 4),
(5, 'Outstanding', 5);

-- --------------------------------------------------------

--
-- Table structure for table `employeeappraisal`
--

CREATE TABLE `employeeappraisal` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `designation` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `eid` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT 'employee id',
  `process` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'process belongs to',
  `doj` date NOT NULL COMMENT 'date of joining',
  `period` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Appraisal assessment period (like 2014-15)',
  `complete` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '1 - completed, 0 - not completed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `employeeappraisal`
--

INSERT INTO `employeeappraisal` (`id`, `name`, `email`, `designation`, `eid`, `process`, `doj`, `period`, `complete`) VALUES
(1, 'Amar Kant', 'amar.kant@globallogic.com', '', '309212', 'Engineering', '2015-05-08', '2015-16', '0'),
(2, 'Ram Kumar', 'ram.kumar@globallogic.com', '', '112233', 'Content Engineering', '2014-09-15', '2015-16', '1'),
(3, 'Iek Lie', 'asdf@mgial.in', 'Seymke', '53535', 'engineer', '2016-04-04', '2015-16', '1'),
(4, 'Amar Anthoney', 'dnase@mgail.com', 'Seer Niem', '123424', 'YKJkiu', '2015-06-30', '2015-16', '0'),
(5, 'Iere Yourm', 'amar@gmail.com', 'sw engg', '309802', 'engineering', '2015-06-30', '2015-16', '0'),
(6, 'Kalam Kur', 'kalam@gmail.com', 'sfasdf sdf', '23424', 'asdfasdf', '2015-06-30', '2015-16', '0');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `major_resoponsbilties` text COLLATE utf8_unicode_ci NOT NULL,
  `extra_mile` text COLLATE utf8_unicode_ci,
  `e_manager_comment` text COLLATE utf8_unicode_ci,
  `notable_accomplishments` text COLLATE utf8_unicode_ci,
  `n_manager_comment` text COLLATE utf8_unicode_ci,
  `overall_fb` text COLLATE utf8_unicode_ci COMMENT 'overall feedback given by Manager'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `emp_id`, `major_resoponsbilties`, `extra_mile`, `e_manager_comment`, `notable_accomplishments`, `n_manager_comment`, `overall_fb`) VALUES
(1, 3, 'asdfasdf', 'fasdfasdf', 'Extra-mile(optional):11', 'asdfasdf', 'Notable Accomplishments11', 'Overall Manager''s Feedback with inline Self Ratings11x'),
(2, 4, 'asdfasdf', 'asdfasdf', NULL, 'asdfasdf', NULL, NULL),
(3, 5, 'asdfasdf', 'asdfasdf', NULL, 'asdfasdf', NULL, NULL),
(4, 6, 'asdfasdf', 'dfasdfasdf', '', NULL, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `hierarchy`
--

CREATE TABLE `hierarchy` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `mngr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `hierarchy`
--

INSERT INTO `hierarchy` (`id`, `emp_id`, `mngr_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 2),
(4, 4, 3),
(5, 5, 2),
(6, 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pwd` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` int(11) NOT NULL DEFAULT '1' COMMENT '1-manager, 2-admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`id`, `email`, `pwd`, `role`) VALUES
(1, 'dnsahoo', 'ff9d214cae9863f5b04e175a47f2c414', 1),
(2, 'ramesh@gmail.com', 'ff9d214cae9863f5b04e175a47f2c414', 1),
(3, 'ramesh1@gmail.com', 'ff9d214cae9863f5b04e175a47f2c414', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `aprsl_id` int(11) NOT NULL COMMENT 'appraisal id',
  `aprsl_rate_id` int(11) NOT NULL COMMENT 'appraisal rate id',
  `comment` text COLLATE utf8_unicode_ci COMMENT 'manager comment',
  `manager_ratting` int(11) DEFAULT NULL,
  `key_pointers` text COLLATE utf8_unicode_ci COMMENT 'for self comment'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `emp_id`, `aprsl_id`, `aprsl_rate_id`, `comment`, `manager_ratting`, `key_pointers`) VALUES
(1, 1, 1, 3, NULL, NULL, NULL),
(2, 1, 2, 4, NULL, NULL, NULL),
(3, 1, 3, 4, NULL, NULL, NULL),
(4, 1, 4, 4, NULL, NULL, NULL),
(5, 1, 5, 4, NULL, NULL, NULL),
(6, 1, 6, 4, NULL, NULL, NULL),
(7, 1, 7, 4, NULL, NULL, NULL),
(8, 1, 8, 4, NULL, NULL, NULL),
(9, 1, 9, 3, NULL, NULL, NULL),
(10, 2, 1, 3, NULL, NULL, NULL),
(11, 2, 2, 4, NULL, NULL, NULL),
(12, 2, 3, 3, NULL, NULL, NULL),
(13, 2, 4, 4, NULL, NULL, NULL),
(14, 2, 5, 4, NULL, NULL, NULL),
(15, 2, 6, 4, NULL, NULL, NULL),
(16, 2, 7, 4, NULL, NULL, NULL),
(17, 2, 8, 4, NULL, NULL, NULL),
(18, 2, 9, 3, NULL, NULL, NULL),
(19, 3, 1, 2, ' Taking Responsibility :        xx   11', 1, 'asdfasdf'),
(20, 3, 2, 4, ' Problem Solving :       xx   ', 2, 'asdfasdf'),
(21, 3, 3, 2, ' Collaboration/Teamwork:        xx   ', 4, 'asdfasdf'),
(22, 3, 4, 3, ' Produces functional d       xx   ', 2, 'asdfasd'),
(23, 3, 5, 3, ' Produces functional d       xx   ', 2, 'asdfasdf'),
(24, 3, 6, 5, ' Coverage planning with respect to       xx   ', 4, 'asdfasdf'),
(25, 3, 7, 2, ' Providing scope to Professional       xx   ', 2, 'asdfasdf'),
(26, 3, 8, 1, ' Client relationship management      xx    ', 1, 'asdfasdf'),
(27, 3, 9, 4, ' Self Learning         xx  ', 4, 'asdfasd'),
(28, 4, 1, 3, NULL, NULL, 'asdfasdf'),
(29, 4, 2, 3, NULL, NULL, 'asdfasdf'),
(30, 4, 3, 3, NULL, NULL, 'asdfasdf'),
(31, 4, 4, 3, NULL, NULL, 'asdfasdf'),
(32, 4, 5, 3, NULL, NULL, 'asdfasdf'),
(33, 4, 6, 3, NULL, NULL, 'asdfasdf'),
(34, 4, 7, 3, NULL, NULL, 'asdfasdf'),
(35, 4, 8, 3, NULL, NULL, 'asdfasdf'),
(36, 4, 9, 3, NULL, NULL, 'asdfasdfasdf'),
(37, 5, 1, 3, NULL, NULL, 'asdfasdf'),
(38, 5, 2, 3, NULL, NULL, 'asdfasdf'),
(39, 5, 3, 3, NULL, NULL, 'asdfas'),
(40, 5, 4, 3, NULL, NULL, 'dfasdf'),
(41, 5, 5, 3, NULL, NULL, 'asdfasdf'),
(42, 5, 6, 3, NULL, NULL, 'asdf'),
(43, 5, 7, 3, NULL, NULL, 'asdfasdf'),
(44, 5, 8, 3, NULL, NULL, 'asdfasdf'),
(45, 5, 9, 3, NULL, NULL, 'asdfasdf'),
(46, 6, 1, 2, ' test123', 3, 'asdfasdf'),
(47, 6, 2, 2, '    ', 3, 'asdfasdf'),
(48, 6, 3, 2, '    ', 3, 'asdfasfd'),
(49, 6, 4, 2, '    ', 3, 'asdfasd'),
(50, 6, 5, 2, '    ', 3, 'asdfasd'),
(51, 6, 6, 2, '    ', 3, 'asdf'),
(52, 6, 7, 2, '    ', 3, 'asdfasdf'),
(53, 6, 8, 2, '    ', 3, 'asdfasdf'),
(54, 6, 9, 3, '    ', 3, 'asdfas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appraisal`
--
ALTER TABLE `appraisal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appraisalrate`
--
ALTER TABLE `appraisalrate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employeeappraisal`
--
ALTER TABLE `employeeappraisal`
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
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `appraisalrate`
--
ALTER TABLE `appraisalrate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `employeeappraisal`
--
ALTER TABLE `employeeappraisal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `hierarchy`
--
ALTER TABLE `hierarchy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `manager`
--
ALTER TABLE `manager`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;