-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2025 at 08:39 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `career_suggestion_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetUserStats` (IN `userId` INT)   BEGIN
    SELECT 
        (SELECT COUNT(*) FROM user_answers WHERE user_id = userId) as answers_count,
        (SELECT COUNT(*) FROM user_career_matches WHERE user_id = userId) as careers_matched,
        (SELECT COUNT(*) FROM user_roadmap_progress WHERE user_id = userId AND completed = TRUE) as steps_completed,
        (SELECT last_login FROM users WHERE user_id = userId) as last_active;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `careers`
--

CREATE TABLE `careers` (
  `career_id` int(11) NOT NULL,
  `career_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `avg_salary` varchar(50) DEFAULT NULL,
  `job_growth` varchar(50) DEFAULT NULL,
  `required_education` varchar(100) DEFAULT NULL,
  `skills_required` text DEFAULT NULL,
  `work_environment` text DEFAULT NULL,
  `job_outlook` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `faq_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`faq_id`, `question`, `answer`, `category`, `display_order`, `is_active`, `created_at`) VALUES
(1, 'How does the career assessment work?', 'Our assessment uses a series of questions to evaluate your interests, skills, and personality traits. Based on your responses, we match you with careers that align with your profile.', 'Assessment', 1, 1, '2025-11-23 18:44:55'),
(2, 'How long does the assessment take?', 'The assessment typically takes 15-20 minutes to complete. You can save your progress and return later if needed.', 'Assessment', 2, 1, '2025-11-23 18:44:55'),
(3, 'Can I retake the assessment?', 'Yes! You can retake the assessment at any time to get updated career suggestions.', 'Assessment', 3, 1, '2025-11-23 18:44:55'),
(4, 'Are the career suggestions accurate?', 'Our suggestions are based on proven career assessment methodologies. However, they should be used as guidance alongside other career exploration activities.', 'General', 4, 1, '2025-11-23 18:44:55'),
(5, 'How do I update my profile?', 'Navigate to the Profile page from the navigation menu. There you can update your personal information and preferences.', 'Account', 5, 1, '2025-11-23 18:44:55');

-- --------------------------------------------------------

--
-- Table structure for table `learning_materials`
--

CREATE TABLE `learning_materials` (
  `material_id` int(11) NOT NULL,
  `career_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `material_type` enum('video','article','course','book','podcast') NOT NULL,
  `url` text DEFAULT NULL,
  `difficulty_level` enum('beginner','intermediate','advanced') DEFAULT 'beginner',
  `duration` varchar(50) DEFAULT NULL,
  `is_free` tinyint(1) DEFAULT 1,
  `rating` decimal(3,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `category` varchar(50) NOT NULL,
  `question_type` enum('multiple_choice','scale','text') NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `options` text DEFAULT NULL,
  `question_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question_text`, `category`, `question_type`, `is_active`, `created_at`, `options`, `question_order`) VALUES
(1, 'What is your preferred work location?', 'Work Environment', 'multiple_choice', 1, '2025-11-23 19:32:13', '[\"Remote\", \"On-site\", \"Hybrid\", \"Flexible\"]', 1),
(2, 'What working style do you prefer?', 'Collaboration', 'multiple_choice', 1, '2025-11-23 19:32:13', '[\"Alone\", \"Partner\", \"Small Group\", \"Large Team\"]', 2),
(3, 'What work speed suits you best?', 'Work Pace', 'multiple_choice', 1, '2025-11-23 19:32:13', '[\"Fast-paced\", \"Moderate\", \"Slow and steady\", \"Varies\"]', 3),
(4, 'How do you handle problem-solving?', 'Problem Solving', 'multiple_choice', 1, '2025-11-23 19:32:13', '[\"Independent\", \"With guidance\", \"Team brainstorming\", \"Research first\"]', 4),
(5, 'What type of tasks do you enjoy?', 'Task Preference', 'multiple_choice', 1, '2025-11-23 19:32:13', '[\"Creative\", \"Logical\", \"Organizing\", \"Helping others\"]', 5),
(6, 'How do you prefer learning?', 'Learning Style', 'multiple_choice', 1, '2025-11-23 19:32:13', '[\"Videos\", \"Books\", \"Hands-on\", \"Mentorship\"]', 6),
(7, 'What motivates you?', 'Motivation', 'multiple_choice', 1, '2025-11-23 19:32:13', '[\"Money\", \"Growth\", \"Passion\", \"Stability\"]', 7),
(8, 'Where do you see yourself working?', 'Work Setting', 'multiple_choice', 1, '2025-11-23 19:32:13', '[\"Government\", \"Private company\", \"Startup\", \"Freelance\"]', 8),
(9, 'What is your preferred work environment?', 'Environment', 'multiple_choice', 1, '2025-11-23 19:32:13', '[\"Quiet\", \"Active\", \"Social\", \"Flexible\"]', 9),
(10, 'How do you manage deadlines?', 'Deadline Management', 'multiple_choice', 1, '2025-11-23 19:32:13', '[\"Strictly\", \"Adjustable\", \"Team-dependent\", \"Ahead of time\"]', 10),
(11, 'Do you like working with technology?', 'Technology Interest', 'multiple_choice', 1, '2025-11-23 19:32:13', '[\"Always\", \"Sometimes\", \"Rarely\", \"Only basics\"]', 11),
(12, 'How do you prefer to communicate?', 'Communication', 'multiple_choice', 1, '2025-11-23 19:32:13', '[\"Chat\", \"Email\", \"Calls\", \"In-person\"]', 12),
(13, 'Do you enjoy analyzing things?', 'Analytical Thinking', 'multiple_choice', 1, '2025-11-23 19:32:13', '[\"Yes\", \"Sometimes\", \"Not much\", \"No\"]', 13),
(14, 'How do you feel about coding?', 'Coding Interest', 'multiple_choice', 1, '2025-11-23 19:32:13', '[\"Love it\", \"Like it\", \"Neutral\", \"Don\'t like\"]', 14),
(15, 'Do you enjoy designing?', 'Design Interest', 'multiple_choice', 1, '2025-11-23 19:32:13', '[\"Yes\", \"Sometimes\", \"Rarely\", \"No\"]', 15),
(16, 'Do you like planning?', 'Planning', 'multiple_choice', 1, '2025-11-23 19:32:13', '[\"Yes\", \"Mostly\", \"A little\", \"No\"]', 16),
(17, 'How do you prefer handling tasks?', 'Task Management', 'multiple_choice', 1, '2025-11-23 19:32:13', '[\"One at a time\", \"Multitasking\", \"Depends\", \"Flexible\"]', 17),
(18, 'Do you enjoy helping users?', 'User Support', 'multiple_choice', 1, '2025-11-23 19:32:13', '[\"Yes\", \"Sometimes\", \"Rarely\", \"No\"]', 18),
(19, 'What type of workload do you prefer?', 'Workload', 'multiple_choice', 1, '2025-11-23 19:32:13', '[\"Light\", \"Medium\", \"Heavy\", \"Varied\"]', 19),
(20, 'Do you like managing others?', 'Management', 'multiple_choice', 1, '2025-11-23 19:32:13', '[\"Yes\", \"Maybe\", \"Not really\", \"No\"]', 20);

-- --------------------------------------------------------

--
-- Table structure for table `question_options`
--

CREATE TABLE `question_options` (
  `option_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_text` varchar(255) NOT NULL,
  `weight_science` int(11) DEFAULT 0,
  `weight_arts` int(11) DEFAULT 0,
  `weight_business` int(11) DEFAULT 0,
  `weight_technology` int(11) DEFAULT 0,
  `weight_healthcare` int(11) DEFAULT 0,
  `weight_engineering` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roadmap_steps`
--

CREATE TABLE `roadmap_steps` (
  `step_id` int(11) NOT NULL,
  `career_id` int(11) NOT NULL,
  `step_order` int(11) NOT NULL,
  `step_title` varchar(200) NOT NULL,
  `step_description` text DEFAULT NULL,
  `estimated_duration` varchar(50) DEFAULT NULL,
  `difficulty_level` enum('beginner','intermediate','advanced') DEFAULT 'beginner'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `session_logs`
--

CREATE TABLE `session_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `logout_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `session_logs`
--

INSERT INTO `session_logs` (`log_id`, `user_id`, `ip_address`, `user_agent`, `login_time`, `logout_time`) VALUES
(1, 3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-11-23 18:53:36', NULL),
(2, 3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-11-23 18:53:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `education_level` varchar(50) DEFAULT NULL,
  `interests` text DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT 'default-avatar.png',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL,
  `assessment_completed` tinyint(1) DEFAULT 0,
  `assessment_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `full_name`, `date_of_birth`, `phone`, `education_level`, `interests`, `profile_picture`, `is_active`, `created_at`, `last_login`, `assessment_completed`, `assessment_date`) VALUES
(1, 'testuser', 'test@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Test User', NULL, NULL, 'High School', NULL, 'default-avatar.png', 1, '2025-11-23 18:44:55', NULL, 0, NULL),
(2, 'johndoe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John Doe', NULL, NULL, 'Bachelor', NULL, 'default-avatar.png', 1, '2025-11-23 18:44:55', NULL, 0, NULL),
(3, 'aaaa', 'atest@example.com', '$2y$10$wQhT/hsdyvPiwhTc4oBDVOCsLjlBf5g5iWbFSSNUulN4Tk6NW3tvq', 'aaaa', NULL, NULL, NULL, NULL, 'default-avatar.png', 1, '2025-11-23 18:53:36', '2025-11-23 18:53:49', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_answers`
--

CREATE TABLE `user_answers` (
  `answer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_career_matches`
--

CREATE TABLE `user_career_matches` (
  `match_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `career_id` int(11) NOT NULL,
  `match_percentage` decimal(5,2) NOT NULL,
  `rank_position` int(11) DEFAULT NULL,
  `suggested_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_progress`
--

CREATE TABLE `user_progress` (
  `progress_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `current_question` int(11) DEFAULT 0,
  `answers` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_progress`
--

INSERT INTO `user_progress` (`progress_id`, `user_id`, `current_question`, `answers`, `updated_at`) VALUES
(1, 3, 19, '{\"1\":\"Flexible\",\"2\":\"Large Team\",\"3\":\"Slow and steady\",\"4\":\"Research first\",\"5\":\"Helping others\",\"6\":\"Videos\",\"7\":\"Stability\",\"8\":\"Freelance\",\"9\":\"Social\",\"10\":\"Team-dependent\",\"11\":\"Always\",\"12\":\"Calls\",\"13\":\"Yes\",\"14\":\"Neutral\",\"15\":\"Rarely\",\"16\":\"Yes\",\"17\":\"Multitasking\",\"18\":\"Sometimes\",\"19\":\"Medium\",\"20\":\"Maybe\"}', '2025-11-23 19:35:29');

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_progress_overview`
-- (See below for the actual view)
--
CREATE TABLE `user_progress_overview` (
`user_id` int(11)
,`full_name` varchar(100)
,`email` varchar(100)
,`questions_answered` bigint(21)
,`careers_suggested` bigint(21)
,`total_steps` bigint(21)
,`completed_steps` decimal(22,0)
);

-- --------------------------------------------------------

--
-- Table structure for table `user_roadmap_progress`
--

CREATE TABLE `user_roadmap_progress` (
  `progress_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `step_id` int(11) NOT NULL,
  `completed` tinyint(1) DEFAULT 0,
  `completed_at` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure for view `user_progress_overview`
--
DROP TABLE IF EXISTS `user_progress_overview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_progress_overview`  AS SELECT `u`.`user_id` AS `user_id`, `u`.`full_name` AS `full_name`, `u`.`email` AS `email`, count(distinct `ua`.`question_id`) AS `questions_answered`, count(distinct `ucm`.`career_id`) AS `careers_suggested`, count(distinct `urp`.`step_id`) AS `total_steps`, sum(case when `urp`.`completed` = 1 then 1 else 0 end) AS `completed_steps` FROM (((`users` `u` left join `user_answers` `ua` on(`u`.`user_id` = `ua`.`user_id`)) left join `user_career_matches` `ucm` on(`u`.`user_id` = `ucm`.`user_id`)) left join `user_roadmap_progress` `urp` on(`u`.`user_id` = `urp`.`user_id`)) GROUP BY `u`.`user_id`, `u`.`full_name`, `u`.`email` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `careers`
--
ALTER TABLE `careers`
  ADD PRIMARY KEY (`career_id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `learning_materials`
--
ALTER TABLE `learning_materials`
  ADD PRIMARY KEY (`material_id`),
  ADD KEY `career_id` (`career_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `question_options`
--
ALTER TABLE `question_options`
  ADD PRIMARY KEY (`option_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `roadmap_steps`
--
ALTER TABLE `roadmap_steps`
  ADD PRIMARY KEY (`step_id`),
  ADD KEY `career_id` (`career_id`);

--
-- Indexes for table `session_logs`
--
ALTER TABLE `session_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_username` (`username`);

--
-- Indexes for table `user_answers`
--
ALTER TABLE `user_answers`
  ADD PRIMARY KEY (`answer_id`),
  ADD UNIQUE KEY `unique_user_question` (`user_id`,`question_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `user_career_matches`
--
ALTER TABLE `user_career_matches`
  ADD PRIMARY KEY (`match_id`),
  ADD KEY `career_id` (`career_id`),
  ADD KEY `idx_user_match` (`user_id`,`match_percentage`);

--
-- Indexes for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD PRIMARY KEY (`progress_id`),
  ADD UNIQUE KEY `unique_user_progress` (`user_id`);

--
-- Indexes for table `user_roadmap_progress`
--
ALTER TABLE `user_roadmap_progress`
  ADD PRIMARY KEY (`progress_id`),
  ADD UNIQUE KEY `unique_user_step` (`user_id`,`step_id`),
  ADD KEY `step_id` (`step_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `careers`
--
ALTER TABLE `careers`
  MODIFY `career_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `learning_materials`
--
ALTER TABLE `learning_materials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `question_options`
--
ALTER TABLE `question_options`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roadmap_steps`
--
ALTER TABLE `roadmap_steps`
  MODIFY `step_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `session_logs`
--
ALTER TABLE `session_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_answers`
--
ALTER TABLE `user_answers`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_career_matches`
--
ALTER TABLE `user_career_matches`
  MODIFY `match_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_progress`
--
ALTER TABLE `user_progress`
  MODIFY `progress_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_roadmap_progress`
--
ALTER TABLE `user_roadmap_progress`
  MODIFY `progress_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `learning_materials`
--
ALTER TABLE `learning_materials`
  ADD CONSTRAINT `learning_materials_ibfk_1` FOREIGN KEY (`career_id`) REFERENCES `careers` (`career_id`) ON DELETE CASCADE;

--
-- Constraints for table `question_options`
--
ALTER TABLE `question_options`
  ADD CONSTRAINT `question_options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE;

--
-- Constraints for table `roadmap_steps`
--
ALTER TABLE `roadmap_steps`
  ADD CONSTRAINT `roadmap_steps_ibfk_1` FOREIGN KEY (`career_id`) REFERENCES `careers` (`career_id`) ON DELETE CASCADE;

--
-- Constraints for table `session_logs`
--
ALTER TABLE `session_logs`
  ADD CONSTRAINT `session_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_answers`
--
ALTER TABLE `user_answers`
  ADD CONSTRAINT `user_answers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_answers_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_career_matches`
--
ALTER TABLE `user_career_matches`
  ADD CONSTRAINT `user_career_matches_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_career_matches_ibfk_2` FOREIGN KEY (`career_id`) REFERENCES `careers` (`career_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD CONSTRAINT `user_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_roadmap_progress`
--
ALTER TABLE `user_roadmap_progress`
  ADD CONSTRAINT `user_roadmap_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_roadmap_progress_ibfk_2` FOREIGN KEY (`step_id`) REFERENCES `roadmap_steps` (`step_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
