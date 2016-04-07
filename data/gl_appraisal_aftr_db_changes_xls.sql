-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2016 at 05:15 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `appraisal`
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
  `process` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'process belongs to',
  `doj` date DEFAULT NULL COMMENT 'date of joining',
  `period` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Appraisal assessment period (like 2014-15)',
  `mgr1_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mgr1_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mgr2_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mgr2_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent` int(11) DEFAULT '0' COMMENT 'parent id of current record',
  `role` enum('0','1','2') COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '1-manager, 2-reporting manager',
  `complete` enum('1','0','2','3') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '1 - completed by mngr, 0 - not completed, 2 - completed by reporting mngr, 3-completed by self',
  `pswd` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `change_pswd` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT 'password changed on first time or not'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `employeeappraisal`
--

INSERT INTO `employeeappraisal` (`id`, `name`, `email`, `designation`, `eid`, `process`, `doj`, `period`, `mgr1_name`, `mgr1_email`, `mgr2_name`, `mgr2_email`, `parent`, `role`, `complete`, `pswd`, `change_pswd`) VALUES
(1, 'Ashok Babu Ravuri', 'ashok.babu@globallogic.com', 'Senior Analyst', '302570', 'Content Engg', '2011-09-26', '2015-16', 'Ravi Krishna K', 'ravikrishna.kothuri@globallogic.com', 'NA', 'NA', 12, '2', '3', 'e10adc3949ba59abbe56e057f20f883e', '1'),
(2, 'Hemalatha P', 'hemalatha.p@globallogic.com', 'Senior Analyst', '303735', 'Content Engg', '2012-10-01', NULL, 'Ravi Krishna K', 'ravikrishna.kothuri@globallogic.com', 'NA', 'NA', 12, '0', '0', 'e10adc3949ba59abbe56e057f20f883e', '0'),
(3, 'Veera Pratyush Kumar Dama', 'pratyush.dama@globallogic.com ', 'Analyst', '305115', 'Content Engg', '2013-07-29', NULL, 'Ashok Babu R', 'ashok.babu@globallogic.com', 'Ravi Krishna K', 'ravikrishna.kothuri@globallogic.com', 1, '0', '0', 'e10adc3949ba59abbe56e057f20f883e', '0'),
(4, 'Anil Kumar Davuluri', 'anil.davuluri@globallogic.com ', 'Senior Analyst', '305135', 'Content Engg', '2013-08-01', NULL, 'Ravi Krishna K', 'ravikrishna.kothuri@globallogic.com', 'NA', 'NA', 12, '2', '0', 'e10adc3949ba59abbe56e057f20f883e', '0'),
(5, 'Sandeep Kumar Banala', 'banala.kumar@globallogic.com ', 'Analyst', '305872', 'Content Engg', '2013-11-18', NULL, 'Ravi Krishna K', 'ravikrishna.kothuri@globallogic.com', 'NA', 'NA', 12, '0', '0', 'e10adc3949ba59abbe56e057f20f883e', '0'),
(6, 'Prasanna Kumar Palai', 'prasanna.palai@globallogic.com ', 'Analyst', '305877', 'Content Engg', '2013-11-18', '2015-16', 'Ashok Babu Ravuri', 'ashok.babu@globallogic.com', 'Ravi Krishna K', 'ravikrishna.kothuri@globallogic.com', 1, '0', '3', 'e10adc3949ba59abbe56e057f20f883e', '1'),
(7, 'Siva Kumar Bonu', 'siva.bonu@globallogic.com ', 'Analyst', '305878', 'Content Engg', '2013-11-18', NULL, 'Anil Kumar Davuluri', 'anil.davuluri@globallogic.com ', 'Ravi Krishna K', 'ravikrishna.kothuri@globallogic.com', 4, '0', '0', 'e10adc3949ba59abbe56e057f20f883e', '0'),
(8, 'Sandeep Nara', 'nara.naidu@globallogic.com ', 'Analyst', '305882', 'Content Engg', '2013-11-18', NULL, 'Bhuvana Mallika', 'bhuvanamallika.v@globallogic.com', 'Ravi Krishna K', 'ravikrishna.kothuri@globallogic.com', 13, '0', '0', 'e10adc3949ba59abbe56e057f20f883e', '0'),
(9, 'Sravanthi Burra', 'sravanthi.burra@globallogic.com ', 'Analyst', '305884', 'Content Engg', '2013-11-18', NULL, 'Anil Kumar Davuluri', 'anil.davuluri@globallogic.com ', 'Ravi Krishna K', 'ravikrishna.kothuri@globallogic.com', 4, '0', '0', 'e10adc3949ba59abbe56e057f20f883e', '0'),
(10, 'Kishore G', 'kishore.garlapati@globallogic.com ', 'Analyst', '308236', 'Content Engg', '2014-09-01', NULL, 'Ashok Babu Ravuri', 'ashok.babu@globallogic.com', 'Ravi Krishna K', 'ravikrishna.kothuri@globallogic.com', 1, '0', '0', 'e10adc3949ba59abbe56e057f20f883e', '0'),
(11, 'Siva Naga Prasad Jalla', 'siva.jalla@globallogic.com ', 'Analyst', '308240', 'Content Engg', '2014-09-01', NULL, 'Bhuvana Mallika', 'bhuvanamallika.v@globallogic.com', 'Ravi Krishna K', 'ravikrishna.kothuri@globallogic.com', 13, '0', '0', 'e10adc3949ba59abbe56e057f20f883e', '0'),
(12, 'Ravi Krishna K', 'ravikrishna.kothuri@globallogic.com', 'Manager', '12345', 'Content Engg', '2000-04-01', NULL, '', '', '', '', 0, '1', '0', 'e10adc3949ba59abbe56e057f20f883e', '0'),
(13, 'Bhuvana Mallika', 'bhuvanamallika.v@globallogic.com', 'na', '234233', 'Content Engg', '2000-04-01', NULL, '', '', '', '', 0, '2', '0', 'e10adc3949ba59abbe56e057f20f883e', '0');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `major_resoponsbilties` text COLLATE utf8_unicode_ci NOT NULL,
  `extra_mile` text COLLATE utf8_unicode_ci,
  `notable_accomplishments` text COLLATE utf8_unicode_ci,
  `e_manager_comment` text COLLATE utf8_unicode_ci,
  `n_manager_comment` text COLLATE utf8_unicode_ci,
  `overall_fb` text COLLATE utf8_unicode_ci COMMENT 'overall feedback given by Manager',
  `e_rpt_manager_comment` text COLLATE utf8_unicode_ci COMMENT 'reporting mngr''s comment for Extramile',
  `n_rpt_manager_comment` text COLLATE utf8_unicode_ci COMMENT 'reporting mngr''s comment for Nodal Achivement'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `emp_id`, `major_resoponsbilties`, `extra_mile`, `notable_accomplishments`, `e_manager_comment`, `n_manager_comment`, `overall_fb`, `e_rpt_manager_comment`, `n_rpt_manager_comment`) VALUES
(1, 6, 'Major ResponsibilitiesSSSSS', 'Extra-mile(optional):Accepted targeted result beyond common call of duty and acts toward achieving g', 'Notable Accomplishments', NULL, NULL, NULL, NULL, NULL),
(2, 1, 'ajor Responsibilities ajor Responsibilities ', 'Extra-mile(optional):Accepted targeted result beyond common call of duty and aExtra-mile(optional):Accepted targeted result beyond common call of duty and aExtra-mile(optional):Accepted targeted result beyond common call of duty and a', 'Notable Accomplishments\r\nNotable Accomplishments\r\n', NULL, NULL, NULL, NULL, NULL);

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
  `pwd` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` int(11) NOT NULL DEFAULT '1' COMMENT '1-manager, 2-reporting manager'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `key_pointers` text COLLATE utf8_unicode_ci COMMENT 'for self comment',
  `reporting_rating` int(11) DEFAULT NULL COMMENT 'reporting mngr''s rating',
  `reporting_comment` text COLLATE utf8_unicode_ci COMMENT 'reporting mngr''s comment'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `emp_id`, `aprsl_id`, `aprsl_rate_id`, `comment`, `manager_ratting`, `key_pointers`, `reporting_rating`, `reporting_comment`) VALUES
(1, 6, 1, 4, NULL, NULL, 'aking Responsibility', NULL, NULL),
(2, 6, 2, 4, NULL, NULL, 'Problem Solving : (Identifies and analyzes problems; formulates alternative solutions; takes or recommends appropriate actions; follows up to ensure problems are res', NULL, NULL),
(3, 6, 3, 2, NULL, NULL, 'Collaboration/Teamwork: (Maintain harmonious and ', NULL, NULL),
(4, 6, 4, 4, NULL, NULL, 'Produces functional deliverables wit', NULL, NULL),
(5, 6, 5, 4, NULL, NULL, 'Produces functional deliverables with respect to committ', NULL, NULL),
(6, 6, 6, 4, NULL, NULL, 'Coverage planning with respect to business require', NULL, NULL),
(7, 6, 7, 2, NULL, NULL, 'Providing scope to Professional develepment', NULL, NULL),
(8, 6, 8, 4, NULL, NULL, 'lient relationship management ( Escalation management, response to client, sharing reports on timely basis, showcasing organisati', NULL, NULL),
(9, 6, 9, 2, NULL, NULL, 'Self Learning (Openness dfor learning new skills and capabilities, partcipation in skill development programs driven by Organisation, Apply learni', NULL, NULL),
(10, 1, 1, 2, NULL, NULL, 'aking Responsibility : (Completes assignments in a thorough, accurate, and timely manner that achieves expected outcomes.aking Responsibility : (Completes assignments in a thorough, accurate, and timely manner that achieves expected outcomes.', NULL, NULL),
(11, 1, 2, 2, NULL, NULL, 'Problem Solving : (IdentifProblem Solving : (Identif', NULL, NULL),
(12, 1, 3, 2, NULL, NULL, 'Collaboration/TeamworCollaboration/Teamwor', NULL, NULL),
(13, 1, 4, 2, NULL, NULL, 'Produces functional deliverables Produces functional deliverables ', NULL, NULL),
(14, 1, 5, 2, NULL, NULL, 'Produces functional deliverables Produces functional deliverables ', NULL, NULL),
(15, 1, 6, 2, NULL, NULL, 'Coverage planning with respect to businCoverage planning with respect to busin', NULL, NULL),
(16, 1, 7, 2, NULL, NULL, 'Providing scope to Professional deProviding scope to Professional de', NULL, NULL),
(17, 1, 8, 2, NULL, NULL, 'Client relationship management Client relationship management ', NULL, NULL),
(18, 1, 9, 2, NULL, NULL, 'Self Learning (Openness dfSelf Learning (Openness df', NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;