-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2024 at 07:46 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `students_marksheet_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `behaviour`
--

CREATE TABLE `behaviour` (
  `id` int(11) NOT NULL,
  `absence` int(11) NOT NULL,
  `lateness` int(11) NOT NULL,
  `punishment` int(11) NOT NULL,
  `warning` int(11) NOT NULL,
  `temporary_exlusion` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `trim_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`) VALUES
(1, 'FIRST LEVEL'),
(2, 'SECOND LEVEL'),
(3, 'THIRD LEVEL CHINESE'),
(4, 'THIRD LEVEL ARABIC'),
(5, 'THIRD LEVEL GERMAN'),
(6, 'THIRD LEVEL SPANISH'),
(7, 'FOURTH LEVEL CHINESE'),
(8, 'FOURTH LEVEL ARABIC'),
(9, 'FOURTH LEVEL GERMAN'),
(10, 'FOURTH LEVEL SPANISH'),
(11, 'FIFTH LEVEL CHINESE'),
(12, 'FIFTH LEVEL ARABIC'),
(13, 'FIFTH LEVEL GERMAN'),
(14, 'FIFTH LEVEL SPANISH'),
(15, 'FIFTH LEVEL SCIENTIFIC'),
(16, 'SIXTH LEVEL CHINESE'),
(17, 'SIXTH LEVEL ARABIC'),
(18, 'SIXTH LEVEL GERMAN'),
(19, 'SIXTH LEVEL SPANISH'),
(20, 'SIXTH LEVEL BIOLOGY'),
(21, 'SIXTH LEVEL MATHEMATICS'),
(22, 'TERMINAL LEVEL CHINESE'),
(23, 'TERMINAL LEVEL ARABIC'),
(24, 'TERMINAL LEVEL GERMAN'),
(25, 'TERMINAL LEVEL SPANISH'),
(26, 'TERMINAL LEVEL BIOLOGY'),
(27, 'TERMINAL LEVEL MATHEMATICS');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `class_id` int(11) NOT NULL,
  `coefficient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `class_id`, `coefficient`) VALUES
(2, 'Entrepreneurship', 3, 3),
(3, 'English skills', 3, 2),
(4, 'Geography', 3, 2),
(5, 'English', 1, 2),
(6, 'Dictation', 1, 2),
(7, 'Mathematics', 1, 4),
(8, 'Biology', 1, 2),
(9, 'Civics Education', 1, 2),
(10, 'History', 1, 2),
(11, 'Geography', 1, 2),
(12, 'Physical and Sport Education', 1, 2),
(13, 'Computer Science', 1, 2),
(14, 'Religion', 1, 1),
(15, 'Manual Labour', 1, 1),
(16, 'Text Study', 1, 1),
(17, 'Writing', 1, 2),
(19, 'Mathematics', 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `form_tutors`
--

CREATE TABLE `form_tutors` (
  `tutor_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_photo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `class_id` int(11) NOT NULL,
  `reset_token_hash` varchar(255) NOT NULL,
  `reset_token_expires_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `form_tutors`
--

INSERT INTO `form_tutors` (`tutor_id`, `fname`, `lname`, `email`, `profile_photo`, `password`, `class_id`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(22, 'NDAYISABA', 'Gloire', 'ndayisabarenzaho@gmail.com', 'Gloire.png', '$2y$10$ckrojmUZOsEAphMnF5lAcefWVFHyyxkFb.A.DZs4CCRJ3C3Osb7R.', 3, '', ''),
(24, 'ROBIN', 'BUSINDE', 'robinbusinde@gmail.com', 'abed.jpg', '$2y$10$1Z.GZimxu8LTjsozZ.HiEuo7gmhU05ZbzDOLLBuzuFbUayBqaR0am', 2, '', ''),
(29, 'Marly', 'Mbiatat', 'mbiatatmarly@gmail.com', 'Screenshot 2024-04-14 213353.png', '$2y$10$J3BhmradoSS9YVRpNqoEMu0NFh6EOQ.nCl7YZECp6Rq9BlgXg2lPu', 1, '', ''),
(33, 'VIANI', 'Biatat', 'armel.tchoumdjin@gmail.com', 'viani1.jpg', '$2y$10$ErTlYRtcMtpKfgg.HjNb9.D3WKCCXd8.xqFF5yqDuHpk5H/PJTkd.', 16, '', ''),
(34, 'ANICET', 'CHIZA', 'chizaanicet@gmail.com', 'Screenshot 2024-02-16 211034.png', '$2y$10$Dq946784QqRBY7zs67p9c.GgNUgrVG2qDLjcQOQzVCPLIZd8F.usS', 6, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `marksheets`
--

CREATE TABLE `marksheets` (
  `marksheet_id` int(11) NOT NULL,
  `SQ` float NOT NULL,
  `comp` float NOT NULL,
  `total` float NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `trim_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `marksheets`
--

INSERT INTO `marksheets` (`marksheet_id`, `SQ`, `comp`, `total`, `student_id`, `course_id`, `trim_id`, `class_id`) VALUES
(11, 0.1, 18, 27.15, 5, 2, 1, 3),
(12, 16, 9, 37.5, 5, 2, 2, 3),
(14, 19.5, 15, 51.75, 5, 2, 3, 3),
(17, 17, 15, 32, 5, 4, 1, 3),
(21, 19.5, 3, 33.75, 11, 2, 1, 3),
(22, 19.5, 15, 51.75, 11, 2, 2, 3),
(23, 10, 10, 30, 11, 2, 3, 3),
(24, 17, 0, 17, 11, 3, 1, 3),
(25, 0, 20, 20, 11, 3, 2, 3),
(78, 19.5, 15.5, 35, 5, 4, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `principals`
--

CREATE TABLE `principals` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token_expires_at` varchar(255) NOT NULL,
  `reset_token_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `principals`
--

INSERT INTO `principals` (`id`, `name`, `mail`, `password`, `reset_token_expires_at`, `reset_token_hash`) VALUES
(1, 'ARMEL Mbiatat', 'armelmbiatat@gmail.com', '1234', '', ''),
(2, 'NDAYISABA Gloire', 'ndayisabarenzaho@gmail.com', '$2y$10$NdAg6JtX7Nm84Z7rXk.AsuU3O2O5BolIqzgXJlMIJPyaCGg3hzErG', '2024-05-26 19:26:59', 'd4893217bfa7a2c6c2042c743262f00328b20d636d923358bf1ab20ffab8c21d');

-- --------------------------------------------------------

--
-- Table structure for table `students_per_class`
--

CREATE TABLE `students_per_class` (
  `student_id` int(11) NOT NULL,
  `regnumber` varchar(10) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `parent_address` varchar(255) NOT NULL,
  `Dob` date NOT NULL,
  `Pob` varchar(255) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students_per_class`
--

INSERT INTO `students_per_class` (`student_id`, `regnumber`, `fname`, `lname`, `parent_address`, `Dob`, `Pob`, `class_id`) VALUES
(5, '20240307', 'MUSA ', 'NGORANYA', '0791460743', '2003-07-24', 'GOMA', 3),
(10, '2024001', 'DANY', 'Mbiatat', '695667296', '2012-11-12', 'Yaounde', 1),
(11, '20240312', 'MAHAMAD', 'OUMAROU', '674895880', '2023-03-09', 'DOUALA', 3),
(21, '111A', 'MAEL', 'MBIATAT YOHANN', '674895880', '2021-10-25', 'Yaounde', 4);

-- --------------------------------------------------------

--
-- Table structure for table `trimeters`
--

CREATE TABLE `trimeters` (
  `trim_id` int(11) NOT NULL,
  `trimester_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trimeters`
--

INSERT INTO `trimeters` (`trim_id`, `trimester_name`) VALUES
(1, 'First trimester'),
(2, 'Second trimester'),
(3, 'Third trimester');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(60) NOT NULL,
  `lname` varchar(60) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token_hash` varchar(255) NOT NULL,
  `reset_token_expires_at` varchar(255) NOT NULL,
  `created_at` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fname`, `lname`, `mail`, `password`, `reset_token_hash`, `reset_token_expires_at`, `created_at`) VALUES
(3, 'Merlveille', 'Mashagiro', 'ndayisabarenzaho@gmail.com', '$2y$10$pCy3J5AOy4s/kuNoIP1PMOJXkyzltxIMRq.NCveCK7cIDAaLY06XC', '', '', '2024-05-26 14:35:32'),
(4, 'Merlveille1', 'Mashagiro', 'ndayisabarenzaho@gmail.com', '$2y$10$no5fyoSmAyvvQKjGGOsYvu3LqLJKpMZW9VDngoLEH7Bzcl8lVYeNq', '5f25656a2e74a4726ec6e20e1e9e2a7f43ecf49d8638e4ce587d098743d695a9', '2024-05-26 15:33:49', '2024-05-26 14:57:22'),
(5, 'NDAYISABA', 'Gloire', 'ndayisabarenzaho@gmail.com', '$2y$10$sm7ucBLY.6.IxsY/GGnQDO9TBM5XJZQTZF8zLsO5OhydcMnJln/zq', '5f25656a2e74a4726ec6e20e1e9e2a7f43ecf49d8638e4ce587d098743d695a9', '2024-05-26 15:33:49', '2024-05-26 15:02:55'),
(6, 'YANNICK', 'MUTANGANAY Gym', 'mutanganayyannick1@gmail.com', '$2y$10$tFodWdd6eQVSglJ1DmyTYuAnVSDk6fbzxNVdfrTn/NVsczv/0QhN.', '', '', '2024-05-31 17:04:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `behaviour`
--
ALTER TABLE `behaviour`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `form_tutors`
--
ALTER TABLE `form_tutors`
  ADD PRIMARY KEY (`tutor_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `marksheets`
--
ALTER TABLE `marksheets`
  ADD PRIMARY KEY (`marksheet_id`),
  ADD KEY `trim_id` (`trim_id`),
  ADD KEY `fk_student_marksheet` (`student_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `principals`
--
ALTER TABLE `principals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students_per_class`
--
ALTER TABLE `students_per_class`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `trimeters`
--
ALTER TABLE `trimeters`
  ADD PRIMARY KEY (`trim_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `behaviour`
--
ALTER TABLE `behaviour`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `form_tutors`
--
ALTER TABLE `form_tutors`
  MODIFY `tutor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `marksheets`
--
ALTER TABLE `marksheets`
  MODIFY `marksheet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `principals`
--
ALTER TABLE `principals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students_per_class`
--
ALTER TABLE `students_per_class`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `trimeters`
--
ALTER TABLE `trimeters`
  MODIFY `trim_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`);

--
-- Constraints for table `form_tutors`
--
ALTER TABLE `form_tutors`
  ADD CONSTRAINT `form_tutors_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`);

--
-- Constraints for table `marksheets`
--
ALTER TABLE `marksheets`
  ADD CONSTRAINT `fk_student_marksheet` FOREIGN KEY (`student_id`) REFERENCES `students_per_class` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `marksheets_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students_per_class` (`student_id`),
  ADD CONSTRAINT `marksheets_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students_per_class` (`student_id`),
  ADD CONSTRAINT `marksheets_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `students_per_class` (`student_id`),
  ADD CONSTRAINT `marksheets_ibfk_4` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `marksheets_ibfk_5` FOREIGN KEY (`trim_id`) REFERENCES `trimeters` (`trim_id`),
  ADD CONSTRAINT `marksheets_ibfk_6` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `marksheets_ibfk_7` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `marksheets_ibfk_8` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`);

--
-- Constraints for table `students_per_class`
--
ALTER TABLE `students_per_class`
  ADD CONSTRAINT `students_per_class_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
