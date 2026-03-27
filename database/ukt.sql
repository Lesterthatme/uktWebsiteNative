-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Mar 25, 2026 at 11:05 AM
-- Server version: 11.7.1-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ukt`
--

-- --------------------------------------------------------

--
-- Table structure for table `admission_requirement`
--

CREATE TABLE `admission_requirement` (
  `requirement_id` int(11) NOT NULL,
  `requirement_title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date_added` date DEFAULT curdate(),
  `status` enum('Active','Inactive') NOT NULL,
  `ap_id` int(11) DEFAULT NULL,
  `up_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admission_requirement`
--

INSERT INTO `admission_requirement` (`requirement_id`, `requirement_title`, `description`, `date_added`, `status`, `ap_id`, `up_id`) VALUES
(14, 'Completed Application Form ', '<p>Online or paper application as required by the college.</p>', '2025-03-13', 'Active', 1, 1),
(15, 'High School Diploma or Equivalent', 'Proof of graduation (e.g., GED for non-traditional students).', '2025-03-13', 'Active', 1, 1),
(17, 'Official Transcripts', '<ul><li>From high school and any previous colleges attended.</li></ul>', '2025-04-03', 'Active', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `announcement_id` int(11) NOT NULL,
  `announcement_title` text NOT NULL,
  `announcement_description` text NOT NULL,
  `announcement_date` date NOT NULL,
  `announcement_time` time NOT NULL,
  `announcement_image` varchar(250) DEFAULT NULL,
  `announcement_status` varchar(11) NOT NULL,
  `ap_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announcement_id`, `announcement_title`, `announcement_description`, `announcement_date`, `announcement_time`, `announcement_image`, `announcement_status`, `ap_id`) VALUES
(17, 'MoU with LGUs', '...', '2025-03-24', '05:07:31', '67ec883dcf3fb_IMG_20240627_001149_968.jpg', 'active', 1),
(18, 'Songkran New Year, Year of Chosak', 'The University of Kratie is preparing for the upcoming Songkran New Year, which marks the Year of Chosak BC. The celebration, scheduled for April 4-5, 2024, will be observed with great anticipation and enthusiasm.', '2025-03-24', '05:16:14', '67ec8864ef100_434182367_1022478502719239_2245871357186593994_n.jpg', 'active', 1),
(19, 'Computer Participation Center', 'Computer Programming for Language Comprehension: Congratulations to all those who graduated short courses on \"Business Mathematics\" and \"Computer Programming for Language Comprehension\" at Kratie University. ', '2025-03-24', '05:19:26', '6805a57ebfacb__com2.png', 'active', 1),
(20, 'Student Workshop', '\"Towards the creation of Asian communities: Youth Capacity Building for Sustainable Community Development\"', '2025-03-24', '05:20:24', '67ec89845cf86_workshop.jpg', 'active', 1),
(21, 'Agricultural Activities', 'Trichoderma production and increase activity, Liquid Fertilizer production from fruit peel, PDA food production for Fungi & NA cultivation for bacteria and natural toxin production, trained by Dr. Hendri Bustamam from Indonesia', '2025-03-24', '05:20:58', '67ec899bb8643_agri1.png', 'active', 1),
(22, 'UKT\'s Inauguration ', 'UKT\'s Inauguration ', '2025-03-24', '05:21:43', '67ec89b64649a_IMG_20240627_000400_659.jpg', 'active', 1),
(23, 'Awarding the Scholarship Grant from the Samdech Thipadei Hun Manet', '...', '2025-03-24', '05:22:13', '67ec89e6db0d0_Awarding the Scholarship Grant from the Samdech Thipadei Hun Manet.jpg', 'active', 1),
(24, 'College Workshop', 'Kratie University (SOC) organized a joint workshop with Kagawa University (Kagawa University) Japan for 2 days under the high supervision of H.E. Dr. Touch Visal Sok', '2025-03-24', '05:27:37', '67ec8a03295de_workshop2.png', 'active', 1),
(25, 'National-International Workshop', 'Kratie University organizes a workshop on self-development for the workshops that are students, students, teachers, and government officials at the relevant departments in Kratie province', '2025-03-24', '05:28:20', '67ec8a17e63b3_workshop1.png', 'active', 1),
(26, 'UKT and BASC Faculty and Student Exchange', 'UKT and BASC Faculty and Student Exchange', '2025-03-24', '05:30:11', 'DATA DOCUMENT ANALYST (1).png', 'active', 1),
(27, 'Research Activities', 'Sout East Asian Studies: Management Team attended the Inauguration Ceremony of the Center for Southeast Asian Studies, presided over by H.E. Minister of Education, Youth and Sport', '2025-03-24', '05:30:53', '67ec8c014aeb0_research.jpg', 'active', 1);

-- --------------------------------------------------------

--
-- Table structure for table `authorized_person`
--

CREATE TABLE `authorized_person` (
  `ap_id` int(11) NOT NULL,
  `ap_firstname` varchar(50) NOT NULL,
  `ap_mi` varchar(50) DEFAULT NULL,
  `ap_lastname` varchar(50) NOT NULL,
  `birthday` date NOT NULL,
  `age` int(11) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `full_address` text NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authorized_person`
--

INSERT INTO `authorized_person` (`ap_id`, `ap_firstname`, `ap_mi`, `ap_lastname`, `birthday`, `age`, `sex`, `full_address`, `contact_number`, `user_id`) VALUES
(1, 'admins', 'aa', 'nolastname', '2000-12-06', 30, 'Male', '', '', 1),
(24, 'Christian', 'S', 'Arenas', '2003-01-26', 22, 'Male', '1123 waweasd wa aw wa', '09701844582', 29),
(29, 'Emilyn', 'P.', 'Marinas', '2000-11-21', 0, 'Female', 'Cambodia', '85595868633', 34),
(35, 'Lester Arjay', 'Bernardo', 'Merino', '2003-07-21', 22, 'Male', 'Sampaguita St.', '09972744144', 41),
(37, 'Emmanuel', 'sad', 'Villalon', '2000-02-02', 26, 'Male', '', '', 43);

-- --------------------------------------------------------

--
-- Table structure for table `board_of_director`
--

CREATE TABLE `board_of_director` (
  `director_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `date_appointed` date DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `ap_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `computer_laboratory`
--

CREATE TABLE `computer_laboratory` (
  `lab_id` int(11) NOT NULL,
  `comlab_description` text NOT NULL,
  `ap_id` int(11) NOT NULL,
  `up_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `computer_laboratory_image`
--

CREATE TABLE `computer_laboratory_image` (
  `image_id` int(11) NOT NULL,
  `comlab_image` varchar(255) NOT NULL,
  `lab_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(255) NOT NULL,
  `dm_name` text DEFAULT NULL,
  `dm_about` text DEFAULT NULL,
  `dm_image` varchar(255) DEFAULT NULL,
  `dm_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `dm_status` varchar(11) DEFAULT NULL,
  `up_id` int(11) DEFAULT NULL,
  `ap_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `dm_name`, `dm_about`, `dm_image`, `dm_created`, `dm_status`, `up_id`, `ap_id`) VALUES
(19, 'Technical Vocational Education', 'Provides practical and career-oriented programs, such as the Associate Degree in TESOL, to equip students with hands-on skills for immediate employment.', 'UKT Logo.png', '2026-02-18 06:16:30', 'Active', 1, 29),
(20, 'Institute of Foreign Languages & Information', 'Focuses on language proficiency and communication skills, offering programs like Bachelor’s in TESOL and Business Administration to prepare students for global opportunities.', 'UKT Logo.png', '2026-02-18 06:16:37', 'Active', 1, 29),
(21, 'Faculty of Agronomy', 'Dedicated to agricultural sciences, this faculty offers programs in crop science, crop protection, and breeding to develop experts in sustainable farming and plant production.', 'UKT Logo.png', '2026-02-18 06:16:44', 'Active', 1, 29),
(22, 'Faculty of Agro-Industry', 'Specializes in food production and processing, offering programs in Food Science & Nutrition and Food Engineering to train professionals for the agri-food sector.', 'UKT Logo.png', '2026-02-18 06:16:51', 'Active', 1, 29),
(23, 'Faculty of Rural Engineering', 'Prepares students for engineering challenges in civil, mechanical, and electrical fields, focusing on infrastructure development and industrial solutions for rural and urban communities.', 'UKT Logo.png', '2026-02-18 06:16:57', 'Active', 1, 29),
(24, 'Institute of Ichthyology', 'Concentrates on aquatic sciences, providing programs in Aquaculture and Feed to develop experts in fish farming and fisheries management.', 'UKT Logo.png', '2026-02-18 06:17:04', 'Active', 1, 29),
(25, 'Faculty of Animal Science', 'Focuses on the health, management, and production of animals, offering a Bachelor’s in Animal & Veterinary Science to prepare skilled professionals for veterinary and livestock industries.', 'UKT Logo.png', '2026-02-18 06:17:10', 'Active', 1, 29);

-- --------------------------------------------------------

--
-- Table structure for table `department_facilities`
--

CREATE TABLE `department_facilities` (
  `facility_id` int(11) NOT NULL,
  `facility_name` varchar(255) NOT NULL,
  `facility_description` text DEFAULT NULL,
  `facility_image` varchar(255) DEFAULT NULL,
  `image_type` enum('Main Building','Facility') DEFAULT NULL,
  `date_upload` date DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faculty_member`
--

CREATE TABLE `faculty_member` (
  `fm_id` int(255) NOT NULL,
  `fm_firstname` varchar(50) DEFAULT NULL,
  `fm_mname` varchar(50) DEFAULT NULL,
  `fm_lastname` varchar(50) DEFAULT NULL,
  `fm_position` varchar(50) DEFAULT NULL,
  `fm_email` varchar(50) DEFAULT NULL,
  `fm_number` varchar(20) DEFAULT NULL,
  `fm_image` varchar(250) DEFAULT NULL,
  `fm_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fm_status` varchar(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `faq_id` int(11) NOT NULL,
  `faq_question` longtext NOT NULL,
  `faq_answer` longtext NOT NULL,
  `faq_date` date NOT NULL,
  `faq_time` time NOT NULL,
  `faq_status` varchar(11) NOT NULL,
  `ap_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`faq_id`, `faq_question`, `faq_answer`, `faq_date`, `faq_time`, `faq_status`, `ap_id`) VALUES
(18, 'What are the available programs at UKT?', 'Visit the University Programs to see the available program', '2025-03-24', '04:45:47', 'Active', 1),
(19, 'Are you considering returning to education?', 'We welcome students from all ages and background and want to help you get into studying something you\'re passionate about. No matter where you are in your journey ,let us help guide you to reach the next stage in your life\'s goals.', '2025-03-24', '04:46:07', 'Active', 1),
(20, 'What scholarships or financial aid are available?', 'For the Academic year 2023-2024 the Kratie University offers 100% FREE SCHOLARSHIP! Visit the University to know more about the free scholarship.', '2025-03-24', '04:46:23', 'Active', 1),
(21, 'What is the mission and vision of UKT?', 'Mission and Vision of University of Kratie', '2025-03-24', '04:45:36', 'Active', 1),
(22, 'Who is the rector of university of kratie?', 'The current Rector of University of Kratie is HE Dr. Laymituna Ngy', '2025-03-24', '04:36:04', 'Active', 1);

-- --------------------------------------------------------

--
-- Table structure for table `highlight`
--

CREATE TABLE `highlight` (
  `h_id` int(11) NOT NULL,
  `h_icon` varchar(50) NOT NULL,
  `h_title` varchar(255) NOT NULL,
  `h_description` longtext NOT NULL,
  `h_date` date NOT NULL,
  `h_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `ap_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `highlight`
--

INSERT INTO `highlight` (`h_id`, `h_icon`, `h_title`, `h_description`, `h_date`, `h_time`, `ap_id`) VALUES
(91, 'ri-graduation-cap-fill', 'Highlights', 'Unlocking Dreams: Celebrating Recipients of 100% Free Scholarships at Kratie University for the Academic Year 2023-2024! Apply for Admission Now until December 23, 2026.', '2025-03-24', '2025-03-24 03:26:21', 1),
(92, 'ri-star-line', 'Management', 'Empowering Futures: Kratie University Hosts Self-Development Workshop for Students, Teachers, and Government Officials Across Departments in Kratie Province.', '2025-03-24', '2025-03-24 03:27:29', 1),
(124, 'ri-leaf-line', 'Faculty Agronomy ', 'February 8, 2023 Trichoderma production and increase activity, Liquid Fertilizer production from fruit peel, PDA food production for Fungi & NA cultivation for bacteria and natural toxin production, trained by Dr. Hendri Bustamam from Indonesia.', '2025-03-24', '2025-03-24 04:51:38', 1);

-- --------------------------------------------------------

--
-- Table structure for table `history_log`
--

CREATE TABLE `history_log` (
  `log_id` int(255) NOT NULL,
  `description` text NOT NULL,
  `log_date` date NOT NULL,
  `log_time` time NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_log`
--

INSERT INTO `history_log` (`log_id`, `description`, `log_date`, `log_time`, `user_id`) VALUES
(3749, 'Account Logged in', '2026-02-03', '08:56:58', 34),
(3750, 'Account Logged in', '2026-02-03', '09:26:27', 34),
(3751, 'Account Logged out', '2026-02-03', '09:26:31', 34),
(3752, 'Account Logged in', '2026-02-03', '09:26:51', 34),
(3753, 'Account Logged out', '2026-02-03', '09:28:18', 34),
(3754, 'Account Logged in', '2026-02-03', '09:28:21', 34),
(3755, 'Account Logged out', '2026-02-03', '09:28:25', 34),
(3756, 'Account Logged in', '2026-02-03', '09:28:28', 34),
(3757, 'Account Logged out', '2026-02-03', '09:28:31', 34),
(3758, 'Account Logged in', '2026-02-03', '10:33:16', 34),
(3759, 'Account Logged out', '2026-02-03', '10:34:29', 34),
(3760, 'Account Logged in', '2026-02-03', '10:40:02', 34),
(3761, 'Account Logged in', '2026-02-03', '10:53:58', 34),
(3762, 'Account Logged out', '2026-02-03', '10:54:35', 34),
(3763, 'Account Logged in', '2026-02-03', '10:58:45', 34),
(3764, 'Account Logged out', '2026-02-03', '14:46:04', 34),
(3765, 'Account Logged in', '2026-02-03', '14:52:40', 34),
(3766, 'Account Logged out', '2026-02-03', '14:52:56', 34),
(3767, 'Account Logged in', '2026-02-03', '15:39:07', 34),
(3768, 'You updated the highlight: Highlights', '2026-02-03', '15:39:39', 34),
(3769, 'Updated Department', '2026-02-03', '15:40:36', 34),
(3770, 'Added Content Manager erot', '2026-02-03', '15:44:07', 34),
(3771, 'Added a new University Founder: Lester Arjay Merino', '2026-02-03', '15:46:41', 34),
(3772, 'Deleted the university partnership: \'Confucius Institute at the Royal Academy of Cambodia\'', '2026-02-03', '15:48:05', 34),
(3773, 'Account Logged in', '2026-02-04', '08:52:46', 34),
(3774, 'Replied example@gmail.com concern', '2026-02-04', '08:55:00', 1),
(3775, 'Deleted Program: Bachelor of Geodetic Engineering', '2026-02-04', '08:56:10', 34),
(3776, 'Account Logged in', '2026-02-09', '07:26:55', 34),
(3777, 'Deleted event: \'Visaka Bochea Day\'', '2026-02-09', '07:28:55', 34),
(3778, 'Deleted event: \'National Independence Day\'', '2026-02-09', '07:28:57', 34),
(3779, 'Deleted event: \'Water Festival Ceremony\'', '2026-02-09', '07:29:00', 34),
(3780, 'Deleted Founder: \'Lester Arjay Bernardo Merino\'', '2026-02-09', '07:29:40', 34),
(3781, 'University Mission Updated.', '2026-02-09', '07:32:55', 34),
(3782, 'University Mission Updated.', '2026-02-09', '07:33:29', 34),
(3783, 'University Mission Updated.', '2026-02-09', '07:34:23', 34),
(3784, 'University Mission Updated.', '2026-02-09', '07:34:38', 34),
(3785, 'University Vision Updated.', '2026-02-09', '07:35:14', 34),
(3786, 'University Mission Updated.', '2026-02-09', '07:35:35', 34),
(3787, 'University Vision Updated.', '2026-02-09', '07:35:54', 34),
(3788, 'University Mission Updated.', '2026-02-09', '07:36:05', 34),
(3789, 'University Goal Updated.', '2026-02-09', '07:37:02', 34),
(3790, 'University Goal Updated.', '2026-02-09', '07:37:53', 34),
(3791, 'University Background Updated.', '2026-02-09', '07:40:39', 34),
(3792, 'University Background Updated.', '2026-02-09', '07:40:57', 34),
(3793, 'Added Department: try dep', '2026-02-09', '07:57:38', 34),
(3794, 'Deleted Faculty Member: Carl Angelo A Aquino', '2026-02-09', '08:01:37', 34),
(3795, 'Deleted Program: Technical Vocational Program', '2026-02-09', '08:02:02', 34),
(3796, 'Added Department: Technical Vocational Education', '2026-02-09', '08:03:30', 34),
(3797, 'Added a new program: Associate Degree in Teaching English to Speakers of Other Languages (TESOL)', '2026-02-09', '08:04:28', 34),
(3798, 'Added Department: Institute of Foreign Languages & Information', '2026-02-09', '08:06:14', 34),
(3799, 'Added Department: Faculty of Agronomy', '2026-02-09', '08:06:29', 34),
(3800, 'Added Department: Faculty of Agro-Industry', '2026-02-09', '08:06:53', 34),
(3801, 'Added Department: Faculty of Rural Engineering', '2026-02-09', '08:07:05', 34),
(3802, 'Added Department: Institute of Ichthyology', '2026-02-09', '08:07:18', 34),
(3803, 'Added Department: Faculty of Animal Science', '2026-02-09', '08:07:28', 34),
(3804, 'Added a new program: Bachelor’s Degree in Teaching English to Speakers of Other Languages (TESOL)', '2026-02-09', '08:08:02', 34),
(3805, 'Added a new program: Bachelor’s Degree in Business Administration', '2026-02-09', '08:08:11', 34),
(3806, 'Added a new program: Bachelor’s Degree in Soil & Crop Science', '2026-02-09', '08:08:32', 34),
(3807, 'Added a new program: Bachelor’s Degree in Crop Protection & Post-Harvesting Technology', '2026-02-09', '08:08:41', 34),
(3808, 'Added a new program: Bachelor’s Degree in Genetics in Breeding', '2026-02-09', '08:08:50', 34),
(3809, 'Added a new program: Bachelor’s Degree in Food Science & Nutrition', '2026-02-09', '08:14:22', 34),
(3810, 'Added a new program: Bachelor’s Degree in Food Engineering', '2026-02-09', '08:14:31', 34),
(3811, 'Added a new program: Bachelor’s Degree in Civil Engineering', '2026-02-09', '08:15:00', 34),
(3812, 'Added a new program: Bachelor’s Degree in Mechanical & Industrial Engineering', '2026-02-09', '08:15:21', 34),
(3813, 'Added a new program: Bachelor’s Degree in Electrical Engineering', '2026-02-09', '08:15:29', 34),
(3814, 'Added a new program: Bachelor’s Degree in Aquaculture', '2026-02-09', '08:15:45', 34),
(3815, 'Added a new program: Bachelor’s Degree in Feed', '2026-02-09', '08:16:01', 34),
(3816, 'Added a new program: Bachelor’s Degree in Animal & Veterinary Science', '2026-02-09', '08:16:23', 34),
(3817, 'Account Logged in', '2026-02-11', '08:26:38', 34),
(3818, 'University Mission Updated.', '2026-02-11', '09:13:01', 34),
(3819, 'University Mission Updated.', '2026-02-11', '09:14:05', 34),
(3820, 'University Mission Updated.', '2026-02-11', '09:15:12', 34),
(3821, 'University Mission Updated.', '2026-02-11', '09:15:24', 34),
(3822, 'University Mission Updated.', '2026-02-11', '09:16:19', 34),
(3823, 'University Mission Updated.', '2026-02-11', '09:16:29', 34),
(3824, 'University Mission Updated.', '2026-02-11', '09:16:54', 34),
(3825, 'University Mission Updated.', '2026-02-11', '09:17:28', 34),
(3826, 'University Mission Updated.', '2026-02-11', '09:17:40', 34),
(3827, 'Account Logged in', '2026-02-16', '08:54:33', 34),
(3847, 'Account Logged in', '2026-02-19', '13:08:42', 1),
(3848, 'Account Logged out', '2026-02-19', '13:15:44', 1),
(3849, 'Account Logged in', '2026-02-19', '13:15:53', 1),
(3850, 'Password Updated', '2026-02-19', '13:16:30', 1),
(3852, 'Password Updated', '2026-02-19', '15:07:50', 1),
(3853, 'Account Logged in', '2026-02-20', '07:16:59', 1),
(3854, 'Admin Profile Updated.', '2026-02-20', '07:19:02', 1),
(3855, 'Admin Profile Updated.', '2026-02-20', '07:19:11', 1),
(3856, 'Admin Profile Updated.', '2026-02-20', '07:22:10', 1),
(3858, 'Account Logged in', '2026-02-23', '12:42:30', 1),
(3860, 'Added Content Manager lester', '2026-02-23', '14:20:53', 1),
(3862, 'Approved lester as Content manager', '2026-02-23', '15:04:54', 1),
(3863, 'Added Content Manager erot', '2026-02-23', '15:07:27', 1),
(3865, 'Denied the registration of username erot.', '2026-02-23', '15:37:13', 1),
(3866, 'Account Logged in', '2026-02-24', '12:18:01', 1),
(3868, 'Account Logged out', '2026-02-24', '13:44:56', 1),
(3869, 'Account Logged in', '2026-02-24', '13:47:10', 1),
(3870, 'Added Content Manager lester', '2026-02-24', '13:47:41', 1),
(3871, 'Approved lester as Content manager', '2026-02-24', '13:47:45', 1),
(3872, 'Account Logged out', '2026-02-24', '13:49:09', 1),
(3873, 'Account Logged in', '2026-02-24', '13:49:25', 41),
(3874, 'Added new job vacancy: example', '2026-02-24', '14:00:56', 41),
(3875, 'Job Updated.', '2026-02-24', '14:08:51', 41),
(3876, 'Account Logged out', '2026-02-24', '14:09:06', 41),
(3877, 'Account Logged in', '2026-02-24', '14:43:11', 1),
(3878, 'Updated job vacancy: example', '2026-02-24', '14:54:36', 1),
(3879, 'Job Updated.', '2026-02-24', '14:59:14', 1),
(3880, 'Account Logged in', '2026-02-25', '09:08:02', 1),
(3881, 'Updated job vacancy: example', '2026-02-25', '09:20:41', 1),
(3882, 'Updated job vacancy: example', '2026-02-25', '09:21:58', 1),
(3883, 'Job Updated.', '2026-02-25', '09:22:37', 1),
(3884, 'Job Updated.', '2026-02-25', '10:08:32', 1),
(3885, 'Account Logged out', '2026-02-25', '12:40:50', 1),
(3886, 'Account Logged in', '2026-02-25', '12:42:23', 41),
(3887, 'Account Logged out', '2026-02-25', '12:43:20', 41),
(3888, 'Account Logged in', '2026-02-25', '12:43:30', 1),
(3889, 'Unblocked user Xtian.', '2026-02-25', '13:12:36', 1),
(3890, 'Blocked user admin.', '2026-02-25', '13:12:42', 1),
(3894, 'Account Logged out', '2026-02-26', '08:21:30', 41),
(3895, 'Account Logged in', '2026-02-27', '09:25:15', 1),
(3896, 'Denied the registration of username sad123.', '2026-02-27', '09:25:32', 1),
(3897, 'Account Logged in', '2026-03-02', '13:02:16', 41),
(3898, 'Account Logged out', '2026-03-02', '13:04:39', 41),
(3899, 'Account Logged in', '2026-03-02', '13:17:50', 41),
(3900, 'Account Logged out', '2026-03-19', '11:15:41', 41),
(3901, 'Account Logged in', '2026-03-19', '11:18:17', 1),
(3902, 'Added a new University Scholarship: thth', '2026-03-19', '11:26:09', 1),
(3903, 'Deleted Scholarship: Number of scholarships available for the academic year 2025-2026.', '2026-03-19', '16:26:05', 1),
(3904, 'Deleted Scholarship: Key Benefits Received by Scholarship Students', '2026-03-19', '16:26:12', 1),
(3905, 'Deleted Scholarship: thth', '2026-03-19', '16:26:16', 1),
(3906, 'Added a new University Scholarship: Kuya Win Scholarship', '2026-03-23', '09:54:30', 1),
(3907, 'Updated University Scholarship: Kuya Win Scholarship', '2026-03-23', '09:55:33', 1),
(3908, 'Updated University Scholarship: Kuya Win Scholarship', '2026-03-23', '10:04:26', 1),
(3909, 'Account Logged in', '2026-03-24', '09:43:08', 1),
(3910, 'Deleted Scholarship: Kuya Win Scholarship', '2026-03-24', '09:43:18', 1),
(3911, 'Added a new University Scholarship: Kuya Win Scholarship', '2026-03-24', '10:23:40', NULL),
(3912, 'Deleted Scholarship: Kuya Win Scholarship', '2026-03-24', '10:47:03', 1),
(3913, 'Added a new University Scholarship: Kuya Win Scholarship', '2026-03-24', '10:47:45', NULL),
(3914, 'Updated University Scholarship: Kuya Win Scholarship', '2026-03-24', '10:48:22', 1),
(3915, 'Updated University Scholarship: Kuya Win Scholarship', '2026-03-24', '10:48:52', 1),
(3916, 'Updated University Scholarship: Kuya Win Scholarship', '2026-03-24', '10:49:27', 1),
(3917, 'Updated University Scholarship: Kuya Win Scholarship', '2026-03-24', '10:54:50', 1),
(3918, 'Updated University Scholarship: Kuya Win Scholarship', '2026-03-24', '10:58:55', 1),
(3919, 'Updated University Scholarship: Kuya Win Scholarship', '2026-03-24', '10:59:29', 1),
(3920, 'Updated University Scholarship: Kuya Win Scholarship', '2026-03-24', '11:19:06', 1),
(3921, 'Updated University Scholarship: Kuya Win Scholarship', '2026-03-24', '12:36:59', 1),
(3922, 'Deleted Scholarship: Kuya Win Scholarship', '2026-03-24', '13:14:07', 1),
(3923, 'Added a new University Scholarship: Kuya Win Scholarship', '2026-03-24', '13:14:23', NULL),
(3924, 'Deleted Scholarship: Kuya Win Scholarship', '2026-03-24', '13:16:44', 1),
(3925, 'Added a new University Scholarship: Kuya Win Scholarship', '2026-03-24', '13:16:57', NULL),
(3926, 'Deleted Scholarship: Kuya Win Scholarship', '2026-03-24', '13:18:17', 1),
(3927, 'Added a new University Scholarship: Kuya Win Scholarship', '2026-03-24', '13:18:26', NULL),
(3928, 'Deleted Scholarship: Kuya Win Scholarship', '2026-03-24', '13:18:32', 1),
(3929, 'Added a new University Scholarship: Kuya Win Scholarship', '2026-03-24', '13:18:46', NULL),
(3930, 'Added a new University Scholarship: Kuya Win Scholarship', '2026-03-24', '13:19:35', NULL),
(3931, 'Deleted Scholarship: Kuya Win Scholarship', '2026-03-24', '13:19:58', 1),
(3932, 'Added a new University Scholarship: Kuya Win Scholarship', '2026-03-24', '13:20:07', NULL),
(3933, 'Added a new University Scholarship: asdasdasd', '2026-03-24', '13:20:49', NULL),
(3934, 'Deleted Scholarship: Kuya Win Scholarship', '2026-03-24', '13:24:49', 1),
(3935, 'Deleted Scholarship: asdasdasd', '2026-03-24', '13:24:53', 1),
(3936, 'Added a new University Scholarship: Kuya Win Scholarship', '2026-03-24', '13:25:07', NULL),
(3937, 'Updated University Scholarship: Kuya Win Scholarship', '2026-03-24', '13:25:16', NULL),
(3938, 'Updated University Scholarship: Kuya Win Scholarship', '2026-03-24', '13:26:33', NULL),
(3939, 'Updated University Scholarship: Kuya Win Scholarship', '2026-03-24', '13:27:34', NULL),
(3940, 'Updated University Scholarship: Kuya Win Scholarship', '2026-03-24', '13:29:52', NULL),
(3941, 'Deleted Scholarship: Kuya Win Scholarship', '2026-03-24', '14:01:17', 1),
(3942, 'Added a new University Scholarship: Kuya Win Scholarship', '2026-03-24', '14:02:23', NULL),
(3943, 'Deleted Scholarship: Kuya Win Scholarship', '2026-03-24', '14:02:28', 1),
(3944, 'Account Logged in', '2026-03-25', '09:11:58', 43),
(3945, 'Added a new University Scholarship: Kuya Win Scholarship', '2026-03-25', '09:27:50', NULL),
(3946, 'Added a new University Scholarship: WOWOwin', '2026-03-25', '09:41:39', NULL),
(3947, 'Updated University Scholarship: Kuya Win Scholarship', '2026-03-25', '09:48:38', NULL),
(3948, 'Updated University Scholarship: Kuya Win Scholarship', '2026-03-25', '09:49:42', NULL),
(3949, 'Updated University Scholarship: WOWOwin', '2026-03-25', '09:50:03', NULL),
(3950, 'Deleted Scholarship: WOWOwin', '2026-03-25', '09:59:17', 43),
(3951, 'Deleted Scholarship: Kuya Win Scholarship', '2026-03-25', '09:59:25', 43),
(3952, 'Added a new University Scholarship: Kuya Win Scholarship', '2026-03-25', '10:00:07', NULL),
(3953, 'Deleted Scholarship: Kuya Win Scholarship', '2026-03-25', '10:00:11', 43);

-- --------------------------------------------------------

--
-- Table structure for table `job_opportunities`
--

CREATE TABLE `job_opportunities` (
  `job_id` int(11) NOT NULL,
  `job_description` text NOT NULL,
  `posted_date` date DEFAULT curdate(),
  `application_deadline` date DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `up_id` int(11) DEFAULT NULL,
  `ap_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_opportunities`
--

INSERT INTO `job_opportunities` (`job_id`, `job_description`, `posted_date`, `application_deadline`, `contact_email`, `up_id`, `ap_id`) VALUES
(2, 'try', '2026-02-26', '2026-02-28', 'lester@gmail.com', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `job_vacancy`
--

CREATE TABLE `job_vacancy` (
  `vacancy_id` int(11) NOT NULL,
  `job_position` varchar(100) DEFAULT NULL,
  `manpower_need` int(11) NOT NULL,
  `date_posted` date DEFAULT NULL,
  `job_forms` varchar(100) DEFAULT NULL,
  `remarks` enum('Filled','Unfilled') DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `ap_id` int(11) DEFAULT NULL,
  `up_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_vacancy`
--

INSERT INTO `job_vacancy` (`vacancy_id`, `job_position`, `manpower_need`, `date_posted`, `job_forms`, `remarks`, `location`, `ap_id`, `up_id`) VALUES
(6, 'example', 2, '2026-02-24', '../assets/uploads/vacancy_form/1771986118_Calendar-of-Activities.docx', 'Filled', 'College of fisheries', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `library_album`
--

CREATE TABLE `library_album` (
  `libalbum_id` int(11) NOT NULL,
  `libalbum_name` varchar(100) NOT NULL,
  `libalbum_description` text NOT NULL,
  `date_created` date DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `ap_id` int(11) DEFAULT NULL,
  `library_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library_archive`
--

CREATE TABLE `library_archive` (
  `libraryarchive_id` int(11) NOT NULL,
  `original_table` varchar(50) DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `archive_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`archive_description`)),
  `archived_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `archived_by` int(11) DEFAULT NULL,
  `library_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library_image`
--

CREATE TABLE `library_image` (
  `libimage_id` int(11) NOT NULL,
  `libimage_name` varchar(255) NOT NULL,
  `upload_date` date DEFAULT NULL,
  `libalbum_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library_resources`
--

CREATE TABLE `library_resources` (
  `resource_id` int(11) NOT NULL,
  `resource_title` varchar(255) NOT NULL,
  `resource_ISBN` varchar(20) NOT NULL,
  `resource_author` varchar(255) DEFAULT NULL,
  `publication_year` int(4) DEFAULT NULL,
  `resource_type` enum('Book','Journal','Magazine','E-Books','Others') NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `resource_status` enum('Active','Inactive') NOT NULL,
  `library_id` int(11) DEFAULT NULL,
  `ap_id` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library_staff`
--

CREATE TABLE `library_staff` (
  `staff_id` int(11) NOT NULL,
  `staff_firstname` varchar(50) DEFAULT NULL,
  `staff_middlename` varchar(50) DEFAULT NULL,
  `staff_lastname` varchar(50) DEFAULT NULL,
  `staff_image` varchar(255) DEFAULT NULL,
  `staff_position` text DEFAULT NULL,
  `staff_email` varchar(50) DEFAULT NULL,
  `staff_contactnumber` varchar(20) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT NULL,
  `library_id` int(11) DEFAULT NULL,
  `ap_id` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library_university`
--

CREATE TABLE `library_university` (
  `library_id` int(11) NOT NULL,
  `library_name` varchar(255) NOT NULL,
  `library_logo` varchar(255) DEFAULT NULL,
  `library_location` text DEFAULT NULL,
  `library_contact` varchar(255) DEFAULT NULL,
  `library_email` varchar(255) DEFAULT NULL,
  `library_website` varchar(255) DEFAULT NULL,
  `library_history` text NOT NULL,
  `library_vision` text NOT NULL,
  `library_mission` text NOT NULL,
  `library_goal` text NOT NULL,
  `library_objectives` text NOT NULL,
  `up_id` int(11) DEFAULT NULL,
  `ap_id` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `library_updates`
--

CREATE TABLE `library_updates` (
  `update_id` int(11) NOT NULL,
  `update_image` varchar(255) NOT NULL,
  `update_category` enum('news','announcement') NOT NULL,
  `update_title` varchar(255) NOT NULL,
  `update_description` text NOT NULL,
  `posted_date` date NOT NULL DEFAULT current_timestamp(),
  `ap_id` int(255) DEFAULT NULL,
  `library_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_reply`
--

CREATE TABLE `message_reply` (
  `reply_id` int(11) NOT NULL,
  `reply_message` text NOT NULL,
  `reply_date` datetime DEFAULT current_timestamp(),
  `message_id` int(11) DEFAULT NULL,
  `ap_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message_reply`
--

INSERT INTO `message_reply` (`reply_id`, `reply_message`, `reply_date`, `message_id`, `ap_id`) VALUES
(5, 'otits par XD', '2025-03-28 06:24:54', 2, 1),
(8, 'this is a sample message from adminukt', '2025-03-30 12:22:15', 2, 1),
(11, 'example', '2025-06-19 02:29:31', 12, 1),
(12, 'try', '2026-02-04 08:55:00', 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `news_title` varchar(255) NOT NULL,
  `news_description` longtext NOT NULL,
  `news_date` date NOT NULL,
  `news_time` time NOT NULL,
  `news_image` varchar(255) DEFAULT NULL,
  `news_status` varchar(11) NOT NULL,
  `ap_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `news_title`, `news_description`, `news_date`, `news_time`, `news_image`, `news_status`, `ap_id`) VALUES
(7, 'Memorandum of Understanding between Romblon State University-RSU of the Republic of the Philippines with National University, Kratie University', '...', '2025-03-24', '05:53:32', 'news3.png', 'Active', 1),
(8, 'Opening ceremony of the training course on Processing local food product', '...', '2025-03-24', '05:54:25', '67ec8e1f1ed63_news1.png', 'Active', 1),
(9, 'Kratie University held a training course on \"Towards the creation of Asian Community ??? Building Youth Capacity for Sustainable Community Development\"', '...', '2025-03-24', '05:54:54', 'news2.png', 'Active', 1),
(10, 'Completion of the course of orientation for the basic academic year (Bridging Course)', 'Kratie University organized a ceremony for the completion of the course of orientation before entering the basic academic year (Bridging Course) to the 9th generation students, letter of gratitude and certificate of appreciation to the teachers and the winners of the research, Samdach Tejo Hun Sen Award 2023-2024, certificate of appreciation and certificate of graduation from the short course, computer and ESP English under high supervision, and His Excellency Dr. Lao Tivseh, Secretary of State, Ministry of Land, Department of Physical Education and Construction, His Excellency Dr. Ngee Laymuneh, University of Kratie University, and with the participation of guests, Mr. Mrs. Representative of Kratie Provincial School, Kratie City Hall, Mr. Orrusey commune, Mr. and Mrs. Representative of Education, Youth and Sport Department of Kratie Province, Parents and Student Guardians, Teachers, Educational Staff All students and students of Kratie University, about 200 in total.', '2025-03-24', '05:55:45', '67ec8e4d217ff_434089350_1024010999232656_3930974112031206842_n.jpg', 'Active', 1),
(14, 'The 6th mandate meeting of the Rector Council of Cambodia (RCC)', 'The management member of University of Kratie has attended the 6th mandate meeting of the Rector Council of Cambodia (RCC) for the first time in 2025 at the Institute of Technology of Cambodia, Phnom Penh. The meeting focused on: collaboration with the University Association in China and other countries, cooperation between RCC member and other related higher education institutions, to organize a higher education fair, and other issues.', '2025-02-01', '07:13:39', '6822f2e559099_Picture1.jpg', 'Active', 29),
(15, 'Policy framework and laws of land management in Cambodia', 'Kratie University in cooperation with the Ministry of Land Planning, Ministry of Land Planning and Construction held a lecture on Policy framework and laws of land management in Cambodia under the leadership of H.E. Dr. Teng Chansongwar, Secretary and Head of Legal Working Team of the Ministry of Land Management, Science and Construction, H.D. Ngee Laymythuna, Director of Land Planning, Science and Construction. Mr. Khan Bun Seng, Deputy Director of Kratie Province. There will be participation of guests Mr. and Mrs. President-Vice President of the Department of Around the Province, Mr. Mrs. Representative of Kratie City School, Mr. and Ms. Oussey District Council, Teachers and students of Kratie University, total of 280 people.', '2025-02-01', '07:15:24', '6822f2c889288_Picture2.jpg', 'Active', 29),
(16, 'Scholarship of King General Techo Hun Sen and King of Honorary Doctorate', 'Participate in the conversation with the students who won the scholarship of King General Techo Hun Sen and King of Honorary Doctorate (A. .. Continued) Provided by King Hun Manet and Her excellency Dr. Pich Chanmony, academic year 2024-2025.', '2025-05-13', '07:19:53', '6822f29950985_Picture3.jpg', 'Active', 29),
(17, 'Career Guide and Study Exhibition', 'The team of Kratie University participated in the exhibition of products in the ?Career Guide and Study Exhibition? organized by the Department of Vocational Orientation of the Ministry of Education, Youth and Sports and made a public presentation about the general information of the university to the students of grade 11 and grade 12 at the schools in Ratanakiri province', '2025-01-16', '07:23:20', '6822f3893bd62_Picture4.jpg', 'Active', 29),
(18, 'Development of Technical Education Curriculum', 'The Department of Vocational Orientation of the Ministry of Education, Youth and Sports has held a workshop on ?Development of Technical Education Curriculum that integrates Green and Digital Education (Green and Digital) on Computer, Electronics, Mechanical, Electricity and Food Processing Skills? under the supervision of H.E. Dr. Ngi Laymythuna, University of Science, Kratie University, Ms. Yem Chariya, Head of the Curriculum Development Office. Sa of the Department of Professional Orientation, and Mr. Ouk Samphes, Head of the Office of the Digital Revolution Department, with participation of about 80 participants from the academic institutions.', '2025-01-21', '07:24:44', '6822f3d517878_Picture5.jpg', 'Active', 29);

-- --------------------------------------------------------

--
-- Table structure for table `operating_hours`
--

CREATE TABLE `operating_hours` (
  `oh_id` int(11) NOT NULL,
  `day` varchar(20) NOT NULL,
  `is_open` tinyint(1) NOT NULL DEFAULT 0,
  `open_time` time DEFAULT NULL,
  `close_time` time DEFAULT NULL,
  `ap_id` int(11) NOT NULL,
  `library_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `page_poster`
--

CREATE TABLE `page_poster` (
  `poster_id` int(250) NOT NULL,
  `poster_image` varchar(255) NOT NULL,
  `poster_status` varchar(11) NOT NULL,
  `poster_date` date NOT NULL,
  `poster_time` time NOT NULL,
  `ap_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page_poster`
--

INSERT INTO `page_poster` (`poster_id`, `poster_image`, `poster_status`, `poster_date`, `poster_time`, `ap_id`) VALUES
(20, '4.png', 'Active', '2025-03-18', '07:46:40', 1),
(21, '5.png', 'Active', '2025-03-18', '07:47:38', 1),
(23, '67ee42559bf07_3.png', 'Active', '2025-04-03', '08:09:57', 1);

-- --------------------------------------------------------

--
-- Table structure for table `program_offering`
--

CREATE TABLE `program_offering` (
  `program_id` int(255) NOT NULL,
  `program_name` varchar(255) DEFAULT NULL,
  `course_code` varchar(20) DEFAULT NULL,
  `course_duration` varchar(20) NOT NULL,
  `program_description` text NOT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp(),
  `status` enum('Active','Inactive') NOT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_offering`
--

INSERT INTO `program_offering` (`program_id`, `program_name`, `course_code`, `course_duration`, `program_description`, `date_created`, `status`, `department_id`) VALUES
(43, 'Associate Degree in Teaching English to Speakers of Other Languages (TESOL)', '--', '2 Years', '--', '2026-02-09', 'Active', 19),
(44, 'Bachelor’s Degree in Teaching English to Speakers of Other Languages (TESOL)', '--', '4 Years', '<p>--</p>', '2026-02-09', 'Active', 20),
(45, 'Bachelor’s Degree in Business Administration', '--', '4 Years', '<p>--</p>', '2026-02-09', 'Active', 20),
(46, 'Bachelor’s Degree in Soil & Crop Science', '--', '4 Years', '<p>--</p>', '2026-02-09', 'Active', 21),
(47, 'Bachelor’s Degree in Crop Protection & Post-Harvesting Technology', '--', '4 Years', '<p>--</p>', '2026-02-09', 'Active', 21),
(48, 'Bachelor’s Degree in Genetics in Breeding', '--', '4 Years', '<p>--</p>', '2026-02-09', 'Active', 21),
(49, 'Bachelor’s Degree in Food Science & Nutrition', '--', '4 Years', '<p>--</p>', '2026-02-09', 'Active', 22),
(50, 'Bachelor’s Degree in Food Engineering', '--', '4 Years', '<p>--</p>', '2026-02-09', 'Active', 22),
(51, 'Bachelor’s Degree in Civil Engineering', '--', '4 Years', '<p>--</p>', '2026-02-09', 'Active', 23),
(52, 'Bachelor’s Degree in Mechanical & Industrial Engineering', '--', '4 Years', '<p>--</p>', '2026-02-09', 'Active', 23),
(53, 'Bachelor’s Degree in Electrical Engineering', '--', '4 Years', '<p>--</p>', '2026-02-09', 'Active', 23),
(54, 'Bachelor’s Degree in Aquaculture', '--', '4 Years', '<p>--</p>', '2026-02-09', 'Active', 24),
(55, 'Bachelor’s Degree in Feed', '--', '4 Years', '<p>--</p>', '2026-02-09', 'Active', 24),
(56, 'Bachelor’s Degree in Animal & Veterinary Science', '--', '4 Years', '<p>--</p>', '2026-02-09', 'Active', 25);

-- --------------------------------------------------------

--
-- Table structure for table `rector`
--

CREATE TABLE `rector` (
  `rector_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `date_appointed` date DEFAULT NULL,
  `rector_details` longtext NOT NULL,
  `status` varchar(11) DEFAULT NULL,
  `ap_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rector`
--

INSERT INTO `rector` (`rector_id`, `image`, `first_name`, `middle_name`, `last_name`, `date_appointed`, `rector_details`, `status`, `ap_id`) VALUES
(5, '6826db1d3849e_rector.png', 'Laymithuna', 'S.', 'Ngy', '2025-03-28', '<p style=\"text-align: justify;\">Currently serving as Rector of the University of Kratie and an Advisor to Cambodia\'s Ministry of Industry, Science, Technology & Innovation, Dr. Ngy plays a pivotal role in shaping the nation\'s industrial and technological advancement. His distinguished career bridges academia and policymaking, with leadership roles including membership in Cambodia\'s Rector Council since 2016 and previous governance positions at the Royal University of Agriculture. An internationally educated scholar (Nagasaki University, Japan), Dr. Laymithuna has directed cross-border development initiatives since 2008, driving socio-economic and environmental progress in Cambodia and neighboring ASEAN nations. His scholarly contributions span critical development sectors, with multiple publications in peer- reviewed international journals. The Royal Government of Cambodia has recognized his service with the Moha Sena Medal (2015) and Bronze Medal (2010), complementing earlier international recognition from Nagasaki. His work continues influencing Cambodia\'s transition toward a knowledge-based economy through science, technology and institutional leadership.</p>', 'Active', 24);

-- --------------------------------------------------------

--
-- Table structure for table `research_project`
--

CREATE TABLE `research_project` (
  `research_id` int(11) NOT NULL,
  `research_title` varchar(255) NOT NULL,
  `researcher_name` text NOT NULL,
  `research_adviser` text NOT NULL,
  `publication_year` year(4) NOT NULL,
  `research_type` enum('Capstone','Thesis') NOT NULL,
  `ap_id` int(255) DEFAULT NULL,
  `library_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `research_project`
--

INSERT INTO `research_project` (`research_id`, `research_title`, `researcher_name`, `research_adviser`, `publication_year`, `research_type`, `ap_id`, `library_id`) VALUES
(8, 'Sci-Gamesazzz', 'asdasd', 'DAve Macalinao', '2025', 'Capstone', NULL, NULL),
(9, 'Sci-Games', 'Ronaldo Payawal, Kimberly Sinaguinan, Carl Angelo Aquino, Christian Arenas, Francesca Piczon, Ivy Tianes', 'Gelo Inducil', '2028', 'Capstone', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `settings_id` int(11) NOT NULL,
  `fav_icon` varchar(255) DEFAULT NULL,
  `website_tagline` varchar(100) DEFAULT NULL,
  `websitetitle_admin` varchar(100) DEFAULT NULL,
  `websitetitle_cm` varchar(100) DEFAULT NULL,
  `website_background` varchar(255) DEFAULT NULL,
  `website_footerbg` varchar(255) DEFAULT NULL,
  `site_banner` varchar(255) NOT NULL,
  `homepage_bg` varchar(255) NOT NULL,
  `ap_id` int(11) DEFAULT NULL,
  `up_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`settings_id`, `fav_icon`, `website_tagline`, `websitetitle_admin`, `websitetitle_cm`, `website_background`, `website_footerbg`, `site_banner`, `homepage_bg`, `ap_id`, `up_id`) VALUES
(1, '1746757931_kratie logo.png', 'Knowledge for Development', 'UKT || Admin', 'UKT || Content Manager', '1745886293_univ.jpg', '1746593086_univ.jpg', '1746592431_aboutunivprofile.png', '1746677603_8.jfif', 29, 1);

-- --------------------------------------------------------

--
-- Table structure for table `universityprofile_image`
--

CREATE TABLE `universityprofile_image` (
  `upimage_id` int(11) NOT NULL,
  `up_image` varchar(100) DEFAULT NULL,
  `ap_id` int(11) DEFAULT NULL,
  `up_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `universityprofile_image`
--

INSERT INTO `universityprofile_image` (`upimage_id`, `up_image`, `ap_id`, `up_id`) VALUES
(1, '1.png', 1, 1),
(2, '2.png', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `university_album`
--

CREATE TABLE `university_album` (
  `album_id` int(11) NOT NULL,
  `album_name` varchar(255) NOT NULL,
  `album_description` text NOT NULL,
  `date_created` date DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `ap_id` int(11) DEFAULT NULL,
  `up_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `university_album`
--

INSERT INTO `university_album` (`album_id`, `album_name`, `album_description`, `date_created`, `status`, `ap_id`, `up_id`) VALUES
(8, 'Visiting exhibition in Songkran New Year ', 'Activity of visiting exhibition in Songkran New Year at Kratie University', '2025-03-04', 'Active', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `university_album_archive`
--

CREATE TABLE `university_album_archive` (
  `archive_album_id` int(11) NOT NULL,
  `album_id` int(11) DEFAULT NULL,
  `album_name` varchar(255) DEFAULT NULL,
  `album_description` text DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT NULL,
  `ap_id` int(11) DEFAULT NULL,
  `up_id` int(11) DEFAULT NULL,
  `date_archived` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `university_album_archive`
--

INSERT INTO `university_album_archive` (`archive_album_id`, `album_id`, `album_name`, `album_description`, `date_created`, `status`, `ap_id`, `up_id`, `date_archived`) VALUES
(3, 9, 'Faculty Day 1', 'For testing', '2025-05-15', 'Active', 24, 1, '2025-05-15'),
(4, 11, 'Sample', 'Sample', '2025-05-26', 'Active', 29, 1, '2025-05-26'),
(5, 3, 'Training on Food Processing Technique', 'Food Process ', '2025-03-19', 'Active', 24, 1, '2025-06-19'),
(6, 2, 'Joint Research Study with Nagasaki University on Puffer Fish', 'Joint Research Study with Nagasaki University on Puffer Fish', '2025-03-19', 'Active', 1, 1, '2025-06-19');

-- --------------------------------------------------------

--
-- Table structure for table `university_archive`
--

CREATE TABLE `university_archive` (
  `archive_id` int(11) NOT NULL,
  `original_table` varchar(50) DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `archive_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`archive_description`)),
  `archived_at` timestamp NULL DEFAULT NULL,
  `archived_by` int(11) DEFAULT NULL,
  `up_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `university_archive`
--

INSERT INTO `university_archive` (`archive_id`, `original_table`, `record_id`, `archive_description`, `archived_at`, `archived_by`, `up_id`) VALUES
(9, 'university_message', 5, '{\"message_id\":\"5\",\"message_subject\":\"elow\",\"message_body\":\"hahaha\",\"sender_email\":\"christianarenas.basc@gmail.com\",\"sender_fname\":\"Christian\",\"sender_mname\":\"Somalinog\",\"sender_lname\":\"Arenas\",\"date_sent\":\"2025-04-03 05:51:10\",\"status\":\"unread\",\"ap_id\":null,\"up_id\":\"1\"}', '2025-04-03 15:30:46', 24, 1),
(10, 'university_message', 6, '{\"message_id\":\"6\",\"message_subject\":\"elow\",\"message_body\":\"hahaha\",\"sender_email\":\"christianarenas.basc@gmail.com\",\"sender_fname\":\"Christian\",\"sender_mname\":\"Somalinog\",\"sender_lname\":\"Arenas\",\"date_sent\":\"2025-04-03 05:53:27\",\"status\":\"unread\",\"ap_id\":null,\"up_id\":\"1\"}', '2025-04-03 15:30:46', 24, 1),
(11, 'university_message', 7, '{\"message_id\":\"7\",\"message_subject\":\"haha\",\"message_body\":\"1\",\"sender_email\":\"ronaldopayawaljr.basc@gmail.com\",\"sender_fname\":\"Christian\",\"sender_mname\":\"Somalinog\",\"sender_lname\":\"Arenas\",\"date_sent\":\"2025-04-03 08:23:32\",\"status\":\"unread\",\"ap_id\":null,\"up_id\":\"1\"}', '2025-04-03 15:30:46', 24, 1),
(12, 'university_message', 8, '{\"message_id\":\"8\",\"message_subject\":\"haha\",\"message_body\":\"h555\",\"sender_email\":\"christianarenas.basc@gmail.com\",\"sender_fname\":\"Christian\",\"sender_mname\":\"Somalinog\",\"sender_lname\":\"Arenas\",\"date_sent\":\"2025-04-03 08:24:18\",\"status\":\"unread\",\"ap_id\":null,\"up_id\":\"1\"}', '2025-04-03 15:30:46', 24, 1),
(13, 'university_message', 9, '{\"message_id\":\"9\",\"message_subject\":\"haha\",\"message_body\":\"h555\",\"sender_email\":\"christianarenas.basc@gmail.com\",\"sender_fname\":\"Christian\",\"sender_mname\":\"Somalinog\",\"sender_lname\":\"Arenas\",\"date_sent\":\"2025-04-03 08:24:27\",\"status\":\"unread\",\"ap_id\":null,\"up_id\":\"1\"}', '2025-04-03 15:30:46', 24, 1),
(14, 'university_message', 10, '{\"message_id\":\"10\",\"message_subject\":\"haha\",\"message_body\":\"h555\",\"sender_email\":\"christianarenas.basc@gmail.com\",\"sender_fname\":\"Christian\",\"sender_mname\":\"Somalinog\",\"sender_lname\":\"Arenas\",\"date_sent\":\"2025-04-03 08:24:38\",\"status\":\"unread\",\"ap_id\":null,\"up_id\":\"1\"}', '2025-04-03 15:30:46', 24, 1),
(16, 'job_vacancy', 1, '{\"vacancy_id\":1,\"job_position\":\"Teacher\",\"date_posted\":\"2025-04-22\",\"job_forms\":null,\"remarks\":\"Unfilled\",\"location\":\"Educ Deartment\",\"ap_id\":1,\"up_id\":1}', '2025-04-22 09:26:43', 1, 1),
(18, 'job_vacancy', 2, '{\"vacancy_id\":2,\"job_position\":\"Information Technology Officer\",\"manpower_need\":1,\"date_posted\":\"2025-04-22\",\"job_forms\":\"..\\/assets\\/uploads\\/vacancy_form\\/1745289539_12. PayawalJr.RonaldoF_BSIT4A_EndorsementLetter.docx\",\"remarks\":\"Unfilled\",\"location\":\"MIS Departmentz\",\"ap_id\":1,\"up_id\":1}', '2025-04-22 12:14:21', 24, 1),
(19, 'university_calendar', 33, '{\"uc_title\":\"Coronation Day of His Majesty Preah Bat Samdech Preah Boromneath NORODOM SIHAMONI, King of Cambodia\",\"uc_month\":\"2024-10\",\"uc_day\":29,\"uc_description\":\"\",\"uc_dateposted\":\"2025-03-24\",\"uc_timeposted\":\"2025-03-24 04:20:34\",\"ap_id\":1}', '2025-04-24 03:33:45', 1, 1),
(21, 'admission_requirement', 19, '{\"requirement_id\":\"19\",\"requirement_title\":\"Sample Requirements\",\"description\":\"<p>sampel only<\\/p>\",\"date_added\":\"2025-04-24\",\"status\":\"Active\",\"ap_id\":\"1\",\"up_id\":\"1\"}', '2025-04-24 13:57:46', 1, 1),
(22, 'admission_requirement', 18, '{\"requirement_id\":\"18\",\"requirement_title\":\"Sample Requirments\",\"description\":\"<p>&gt;&gt; Admin &lt;&lt;<\\/p><p>Announcement - Remove status(Add)<\\/p><p>University Album - Remove status(Add)<\\/p><p>Message Inbox- Filter(Read, Unread)<\\/p><p>Message Sent Items - Sort By<\\/p><p>Scholarship - Remove status(Add)<\\/p><p>News - Remove status(Add)<\\/p><p>Program Offered &gt;&gt; Manage Department<\\/p><p>Admission Requirements - Remove status(Add)<\\/p><p>Rector - Remove status(Add)<\\/p><p>Scholarship - Remove status(Add)<\\/p><p>Board of Director - Remove status(Add)<\\/p><p>Dean - Remove status(Add)<\\/p><p><br><\\/p>\",\"date_added\":\"2025-04-22\",\"status\":\"Active\",\"ap_id\":\"26\",\"up_id\":\"1\"}', '2025-04-24 13:57:49', 1, 1),
(44, 'university_partnership', 30, '{\"up_name\":\"dasd\",\"up_image\":\"6811ab248251f.jfif\",\"up_date\":\"2025-04-30\",\"up_time\":\"2025-04-30 04:46:28\",\"up_status\":\"Active\",\"up_link\":\"www,gogog.com\",\"ap_id\":1}', '2025-04-30 04:46:43', 1, 1),
(45, 'news', 13, '{\"news_id\":13,\"news_title\":\"testing 3\",\"news_description\":\"ASXSD\",\"news_date\":\"2025-05-05\",\"news_time\":\"06:08:54\",\"news_image\":\"681855f62fd28_agri1.png\",\"news_status\":\"Active\",\"ap_id\":24}', '2025-05-05 06:11:04', 24, 1),
(46, 'news', 12, '{\"news_id\":12,\"news_title\":\"testing 2\",\"news_description\":\"SAAS\",\"news_date\":\"2025-05-05\",\"news_time\":\"06:08:27\",\"news_image\":\"681855dbc6eef_20250427_191228.jpg\",\"news_status\":\"Active\",\"ap_id\":24}', '2025-05-05 06:11:08', 24, 1),
(47, 'news', 11, '{\"news_id\":11,\"news_title\":\"testing\",\"news_description\":\"wdw\",\"news_date\":\"2025-05-05\",\"news_time\":\"06:07:44\",\"news_image\":\"681855b05834c_20250410_162030.jpg\",\"news_status\":\"Active\",\"ap_id\":24}', '2025-05-05 06:11:11', 24, 1),
(56, 'university_partnership', 31, '{\"up_name\":\"Bulacan Agricultural State College\",\"up_image\":\"68344cf9e1bfb.png\",\"up_date\":\"2025-05-26\",\"up_time\":\"2025-05-26 11:14:01\",\"up_status\":\"Active\",\"up_link\":\"http:\\/\\/www.eurasia.or.jp\\/en\\/\",\"ap_id\":29}', '2025-05-26 11:14:20', 29, 1),
(57, 'faq', 24, '{\"faq_question\":\"Sample\",\"faq_answer\":\"Sample\",\"faq_date\":\"2025-05-26\",\"faq_time\":\"11:16:56\",\"faq_status\":\"Active\",\"ap_id\":29}', '2025-05-26 11:17:07', 29, 1),
(58, 'announcement', 30, '{\"announcement_title\":\"sample\",\"announcement_description\":\"sample\",\"announcement_date\":\"2025-05-26\",\"announcement_time\":\"11:18:20\",\"announcement_status\":\"active\",\"announcement_image\":\"68344dfc0df0f_BSAU LOGO.jpg\",\"ap_id\":29}', '2025-05-26 11:18:34', 29, 1),
(59, 'university_message', 3, '{\"message_id\":\"3\",\"message_subject\":\"Hi\",\"message_body\":\"<3\",\"sender_email\":\"christianarenas.basc@gmail.com\",\"sender_fname\":\"Christian\",\"sender_mname\":\"S\",\"sender_lname\":\"Arenas\",\"date_sent\":\"2025-03-28 00:43:55\",\"status\":\"read\",\"ap_id\":\"28\",\"up_id\":\"1\"}', '2025-05-26 18:21:24', 29, 1),
(60, 'page_poster', 28, '{\"poster_id\":28,\"poster_image\":\"68344ef576748_BITS_LOGO-removebg-preview.png\",\"poster_status\":\"Active\",\"poster_date\":\"2025-05-26\",\"poster_time\":\"11:22:29\",\"ap_id\":29}', '2025-05-26 11:22:37', 29, 1),
(61, 'university_calendar', 44, '{\"uc_title\":\"jahdgw\",\"uc_month\":\"2025-05\",\"uc_day\":1,\"uc_description\":\"jbbsad\\r\\n\",\"uc_dateposted\":\"2025-05-26\",\"uc_timeposted\":\"2025-05-26 11:35:34\",\"ap_id\":29}', '2025-05-26 11:35:41', 29, 1),
(63, 'university_calendar', 42, '{\"uc_title\":\"Holiday\",\"uc_month\":\"2025-05\",\"uc_day\":1,\"uc_description\":\"Labor Day\",\"uc_dateposted\":\"2025-04-29\",\"uc_timeposted\":\"2025-04-29 05:05:55\",\"ap_id\":9}', '2025-06-19 02:34:59', 29, 1),
(64, 'university_partnership', 26, '{\"up_name\":\"Confucius Institute at the Royal Academy of Cambodia\",\"up_image\":\"royalacademy.png\",\"up_date\":\"2025-03-24\",\"up_time\":\"2025-03-24 11:11:31\",\"up_status\":\"Inactive\",\"up_link\":\"https:\\/\\/aeu.edu.kh\\/site\\/postdetail\\/113\",\"ap_id\":1}', '2026-02-03 08:48:05', 29, 1),
(65, 'university_calendar', 38, '{\"uc_title\":\"Visaka Bochea Day\",\"uc_month\":\"2024-05\",\"uc_day\":22,\"uc_description\":\"\",\"uc_dateposted\":\"2025-03-24\",\"uc_timeposted\":\"2025-03-24 11:14:05\",\"ap_id\":1}', '2026-02-09 00:28:55', 29, 1),
(66, 'university_calendar', 34, '{\"uc_title\":\"National Independence Day\",\"uc_month\":\"2024-11\",\"uc_day\":9,\"uc_description\":\"\",\"uc_dateposted\":\"2025-03-24\",\"uc_timeposted\":\"2025-03-24 11:22:18\",\"ap_id\":1}', '2026-02-09 00:28:57', 29, 1),
(67, 'university_calendar', 37, '{\"uc_title\":\"Water Festival Ceremony\",\"uc_month\":\"2024-11\",\"uc_day\":14,\"uc_description\":\"\",\"uc_dateposted\":\"2025-03-24\",\"uc_timeposted\":\"2025-03-24 11:23:14\",\"ap_id\":1}', '2026-02-09 00:29:00', 29, 1),
(70, 'university_scholarship', 1, '{\"scholarship_id\":\"1\",\"scholarship_title\":\"Number of scholarships available for the academic year 2025-2026.\",\"description\":\"<h5 class=\\\"wp-block-heading\\\" style=\\\"font-weight: 700; line-height: 1.5; color: rgb(52, 63, 82); font-size: 0.9rem; word-spacing: 0.1rem; letter-spacing: -0.01rem; font-family: Manrope, sans-serif;\\\"><span style=\\\"font-size: 18px;\\\"><br><\\/span><\\/h5><table class=\\\"table table-bordered\\\"><tbody><tr><td><b>DEPARTMENT<\\/b><\\/td><td><b>NO. OF SCHOLARSHIP<\\/b><\\/td><td><b>NARRATIVE ACCORDING TO THE SUBJECT<\\/b><\\/td><td><b>EXECUTIVE SUMMARY<\\/b><\\/td><td><b>CROSSING THROUGH THE EXAMINATION<\\/b><\\/td><\\/tr><tr><td>Soil Science and Crop<\\/td><td>25<\\/td><td>Biology Chemistry<\\/td><td>A -&gt; E<\\/td><td>-<\\/td><\\/tr><tr><td>Protection of Crops and Harvesting Technology<\\/td><td>25<\\/td><td>Biology Chemistry<\\/td><td>A -&gt; E<\\/td><td>-<\\/td><\\/tr><tr><td>Animal Science and Veterinary Medicine<\\/td><td>25<\\/td><td>Biology Chemistry<\\/td><td>A -&gt; E<\\/td><td>-<\\/td><\\/tr><tr><td>Food Science and Nutrition<\\/td><td>25<\\/td><td>Biology Chemistry<\\/td><td>A -&gt; E<\\/td><td>-<\\/td><\\/tr><tr><td>Cultural Heritage<\\/td><td>25<\\/td><td>Biology Chemistry<\\/td><td>A -&gt; E<\\/td><td>-<\\/td><\\/tr><tr><td>Genetics and Breeding<\\/td><td>25<\\/td><td>Biology Chemistry<\\/td><td>A -&gt; E<\\/td><td>-<\\/td><\\/tr><tr><td>Food Engineering<\\/td><td>25<\\/td><td>Biology Chemistry<\\/td><td>A -&gt; E<\\/td><td>-<\\/td><\\/tr><\\/tbody><\\/table><h5 class=\\\"wp-block-heading\\\" style=\\\"font-weight: 700; line-height: 1.5; color: rgb(52, 63, 82); font-size: 0.9rem; word-spacing: 0.1rem; letter-spacing: -0.01rem; font-family: Manrope, sans-serif;\\\"><br><\\/h5>\",\"status\":\"Active\",\"date_added\":\"2025-03-13\",\"ap_id\":\"1\",\"up_id\":\"1\"}', '2026-03-19 09:26:05', 1, 1),
(71, 'university_scholarship', 7, '{\"scholarship_id\":\"7\",\"scholarship_title\":\"Key Benefits Received by Scholarship Students\",\"description\":\"<p style=\\\"text-align: justify; \\\"><b>Graduation Rate&nbsp;<\\/b><br><\\/p><ul><li><div style=\\\"text-align: justify;\\\">The students have completed their studies, and there is an employment rate\\r\\n of 85.1%. Among them, 8.5% are engaged in self-employment.<\\/div><\\/li><li style=\\\"text-align: justify; \\\">Students who have served in government institutions account for 41%, in\\r\\n the private sector 28.2%, in national\\/international organizations 7.7%, and in\\r\\n other sectors 23.1%.<\\/li><\\/ul>\",\"status\":\"Active\",\"date_added\":\"2025-04-22\",\"ap_id\":\"24\",\"up_id\":\"1\"}', '2026-03-19 09:26:12', 1, 1),
(72, 'university_scholarship', 23, '{\"scholarship_id\":\"23\",\"scholarship_title\":\"thth\",\"description\":\"<p>gtgtgttgtgtgtt<\\/p>\",\"status\":\"Active\",\"date_added\":\"2026-03-19\",\"ap_id\":\"1\",\"up_id\":\"1\"}', '2026-03-19 09:26:16', 1, 1),
(73, 'university_scholarship', 24, '{\"scholarship_id\":\"24\",\"scholarship_title\":\"Kuya Win Scholarship\",\"description\":\"<p>This is the requirment for the scholarship!!!<br><br>1x1 Picture<\\/p><p><br><\\/p><p><u>https:\\/\\/www.youtube.com\\/@universityofkratie<\\/u><\\/p>\",\"image\":null,\"status\":\"Active\",\"date_added\":\"2026-03-23\",\"ap_id\":\"1\",\"up_id\":\"1\"}', '2026-03-24 02:43:18', 1, 1),
(74, 'university_scholarship', 26, '{\"scholarship_id\":\"26\",\"scholarship_title\":\"Kuya Win Scholarship\",\"description\":\"<div class=\\\"html-div xdj266r x14z9mp xat24cr x1lziwak xexx8yu xyri2b x18d9i69 x1c1uobl\\\" style=\\\"margin-inline: 0px; padding-inline: 0px; padding-bottom: 0px; margin-bottom: 0px; margin-top: 0px; padding-top: 0px; font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(28, 30, 33); font-size: 12px; background-color: rgb(37, 39, 40);\\\"><div dir=\\\"auto\\\" class=\\\"html-div xdj266r x14z9mp xat24cr x1lziwak xexx8yu xyri2b x18d9i69 x1c1uobl\\\" style=\\\"margin-inline: 0px; padding-inline: 0px; padding-bottom: 0px; margin-bottom: 0px; margin-top: 0px; padding-top: 0px; font-family: inherit;\\\"><div data-ad-rendering-role=\\\"story_message\\\" class=\\\"html-div xdj266r x14z9mp xat24cr x1lziwak xexx8yu xyri2b x18d9i69 x1c1uobl\\\" style=\\\"margin-inline: 0px; padding-inline: 0px; padding-bottom: 0px; margin-bottom: 0px; margin-top: 0px; padding-top: 0px; font-family: inherit;\\\"><div class=\\\"x1l90r2v x1iorvi4 x1g0dm76 xpdmqnj\\\" data-ad-comet-preview=\\\"message\\\" data-ad-preview=\\\"message\\\" style=\\\"padding-inline: 12px; padding-top: 4px; padding-bottom: 16px; font-family: inherit;\\\"><div class=\\\"x78zum5 xdt5ytf xz62fqu x16ldp7u\\\" style=\\\"display: flex; flex-direction: column; margin-top: -5px; margin-bottom: -5px; font-family: inherit;\\\"><div class=\\\"xu06os2 x1ok221b\\\" style=\\\"margin-top: 5px; margin-bottom: 5px; font-family: inherit;\\\"><span class=\\\"x193iq5w xeuugli x13faqbe x1vvkbs x1xmvt09 x1lliihq x1s928wv xhkezso x1gmr53x x1cpjm7i x1fgarty x1943h6x xudqn12 x3x7a5m x6prxxf xvq8zen xo1l8bm xzsf02u x1yc453h\\\" dir=\\\"auto\\\" style=\\\"word-break: break-word; display: block; overflow-wrap: break-word; font-family: inherit; font-size: 0.9375rem; line-height: 1.3333; color: rgb(226, 229, 233); max-width: 100%; min-width: 0px;\\\"><div class=\\\"html-div xdj266r x14z9mp xat24cr x1lziwak xexx8yu xyri2b x18d9i69 x1c1uobl\\\" style=\\\"margin-inline: 0px; padding-inline: 0px; padding-bottom: 0px; margin-bottom: 0px; margin-top: 0px; padding-top: 0px; font-family: inherit;\\\"><div class=\\\"x14z9mp xat24cr x1lziwak x1vvkbs xtlvy1s x126k92a\\\" style=\\\"white-space-collapse: preserve; margin-inline: 0px; overflow-wrap: break-word; margin-bottom: 0px; margin-top: 0.5em; font-family: inherit;\\\"><div dir=\\\"auto\\\" style=\\\"font-family: inherit;\\\">\\ud835\\udc12\\ud835\\udc04\\ud835\\udc0d. \\ud835\\udc16\\ud835\\udc08\\ud835\\udc0d \\ud835\\udc06\\ud835\\udc00\\ud835\\udc13\\ud835\\udc02\\ud835\\udc07\\ud835\\udc00\\ud835\\udc0b\\ud835\\udc08\\ud835\\udc00\\ud835\\udc0d \\ud835\\udc12\\ud835\\udc02\\ud835\\udc07\\ud835\\udc0e\\ud835\\udc0b\\ud835\\udc00\\ud835\\udc11\\ud835\\udc12\\ud835\\udc07\\ud835\\udc08\\ud835\\udc0f \\ud835\\udc06\\ud835\\udc11\\ud835\\udc00\\ud835\\udc0d\\ud835\\udc13\\ud835\\udc04\\ud835\\udc04\\ud835\\udc12 \\ud835\\udc06\\ud835\\udc04\\ud835\\udc0d\\ud835\\udc04\\ud835\\udc11\\ud835\\udc00\\ud835\\udc0b \\ud835\\udc00\\ud835\\udc12\\ud835\\udc12\\ud835\\udc04\\ud835\\udc0c\\ud835\\udc01\\ud835\\udc0b\\ud835\\udc18<\\/div><\\/div><div class=\\\"x14z9mp xat24cr x1lziwak x1vvkbs xtlvy1s x126k92a\\\" style=\\\"white-space-collapse: preserve; margin-inline: 0px; overflow-wrap: break-word; margin-bottom: 0px; margin-top: 0.5em; font-family: inherit;\\\"><div dir=\\\"auto\\\" style=\\\"font-family: inherit;\\\">\\ud835\\udc16\\ud835\\udc21\\ud835\\udc1e\\ud835\\udc27: March 28, 2026  I  1: 00 PM<\\/div><div dir=\\\"auto\\\" style=\\\"font-family: inherit;\\\">\\ud835\\udc16\\ud835\\udc21\\ud835\\udc1e\\ud835\\udc2b\\ud835\\udc1e: BASC Gymnasium<\\/div><div dir=\\\"auto\\\" style=\\\"font-family: inherit;\\\">\\ud835\\udc00\\ud835\\udc2d\\ud835\\udc2d\\ud835\\udc22\\ud835\\udc2b\\ud835\\udc1e: Red, White, or Blue Top and Maong Pants<\\/div><\\/div><div class=\\\"x14z9mp xat24cr x1lziwak x1vvkbs xtlvy1s x126k92a\\\" style=\\\"white-space-collapse: preserve; margin-inline: 0px; overflow-wrap: break-word; margin-bottom: 0px; margin-top: 0.5em; font-family: inherit;\\\"><div dir=\\\"auto\\\" style=\\\"font-family: inherit;\\\">\\ud835\\udc00\\ud835\\udc2d\\ud835\\udc2d\\ud835\\udc1e\\ud835\\udc27\\ud835\\udc1d\\ud835\\udc1a\\ud835\\udc27\\ud835\\udc1c\\ud835\\udc1e \\ud835\\udc22\\ud835\\udc2c \\ud835\\udc1a \\ud835\\udc0c\\ud835\\udc14\\ud835\\udc12\\ud835\\udc13.   \\ud835\\udc0d\\ud835\\udc28 \\ud835\\udc08\\ud835\\udc03 \\ud835\\udc1a\\ud835\\udc27\\ud835\\udc1d \\ud835\\udc29\\ud835\\udc1e\\ud835\\udc2b\\ud835\\udc26\\ud835\\udc22\\ud835\\udc2c\\ud835\\udc2c\\ud835\\udc22\\ud835\\udc28\\ud835\\udc27 \\ud835\\udc25\\ud835\\udc1e\\ud835\\udc2d\\ud835\\udc2d\\ud835\\udc1e\\ud835\\udc2b \\ud835\\udc27\\ud835\\udc28 \\ud835\\udc1e\\ud835\\udc27\\ud835\\udc2d\\ud835\\udc2b\\ud835\\udc32. <\\/div><\\/div><div class=\\\"x14z9mp xat24cr x1lziwak x1vvkbs xtlvy1s x126k92a\\\" style=\\\"white-space-collapse: preserve; margin-inline: 0px; overflow-wrap: break-word; margin-bottom: 0px; margin-top: 0.5em; font-family: inherit;\\\"><div dir=\\\"auto\\\" style=\\\"font-family: inherit;\\\">\\ud835\\udc0a\\ud835\\udc22\\ud835\\udc27\\ud835\\udc1d\\ud835\\udc25\\ud835\\udc32 \\ud835\\udc1b\\ud835\\udc2b\\ud835\\udc22\\ud835\\udc27\\ud835\\udc20 \\ud835\\udc2d\\ud835\\udc21\\ud835\\udc1e \\ud835\\udc1f\\ud835\\udc28\\ud835\\udc25\\ud835\\udc25\\ud835\\udc28\\ud835\\udc30\\ud835\\udc22\\ud835\\udc27\\ud835\\udc20:<\\/div><div dir=\\\"auto\\\" style=\\\"font-family: inherit;\\\">* Student ID<\\/div><div dir=\\\"auto\\\" style=\\\"font-family: inherit;\\\">* Permission Letter ( Download, print, and fill up )<\\/div><\\/div><div class=\\\"x14z9mp xat24cr x1lziwak x1vvkbs xtlvy1s x126k92a\\\" style=\\\"white-space-collapse: preserve; margin-inline: 0px; overflow-wrap: break-word; margin-bottom: 0px; margin-top: 0.5em; font-family: inherit;\\\"><div dir=\\\"auto\\\" style=\\\"font-family: inherit;\\\">\\ud835\\udc0f\\ud835\\udc25\\ud835\\udc1e\\ud835\\udc1a\\ud835\\udc2c\\ud835\\udc1e \\ud835\\udc1c\\ud835\\udc25\\ud835\\udc22\\ud835\\udc1c\\ud835\\udc24 \\ud835\\udc2d\\ud835\\udc21\\ud835\\udc1e \\ud835\\udc25\\ud835\\udc22\\ud835\\udc27\\ud835\\udc24 \\ud835\\udc1f\\ud835\\udc28\\ud835\\udc2b \\ud835\\udc2d\\ud835\\udc21\\ud835\\udc1e \\ud835\\udc0f\\ud835\\udc1e\\ud835\\udc2b\\ud835\\udc26\\ud835\\udc22\\ud835\\udc2c\\ud835\\udc2c\\ud835\\udc22\\ud835\\udc28\\ud835\\udc27 \\ud835\\udc0b\\ud835\\udc1e\\ud835\\udc2d\\ud835\\udc2d\\ud835\\udc1e\\ud835\\udc2b:<\\/div><\\/div><div class=\\\"x14z9mp xat24cr x1lziwak x1vvkbs xtlvy1s x126k92a\\\" style=\\\"white-space-collapse: preserve; margin-inline: 0px; overflow-wrap: break-word; margin-bottom: 0px; margin-top: 0.5em; font-family: inherit;\\\"><div dir=\\\"auto\\\" style=\\\"font-family: inherit;\\\"><span class=\\\"html-span xdj266r x14z9mp xat24cr x1lziwak xexx8yu xyri2b x18d9i69 x1c1uobl x1hl2dhg x16tdsg8 x1vvkbs\\\" style=\\\"margin-inline: 0px; text-align: inherit; padding-inline: 0px; overflow-wrap: break-word; padding-bottom: 0px; margin-bottom: 0px; margin-top: 0px; padding-top: 0px; font-family: inherit;\\\"><a attributionsrc=\\\"\\/privacy_sandbox\\/comet\\/register\\/source\\/?xt=AZZ30je08_qfp81XtAnrSXCB_5eUp04Pya0rJFpESMSULA0g29m0rg6PR0JqlgrP_yGANj0up4b6oOoPxedg5EET41TdtYJ8L_Q04FJTHlHyhOgTP9Y24i5cMWLA7bdYpi-fThwYd0qH4zAkGW23hl35Cr7yuKaS21d6XwSXPnt8dfQZPugn2vUYEMskxI1lj0Z9oGs-4jPgkq26dnyeM0lvhE1x0ffA8DSCiVWpKnoZg_1nyfsEDmMmlg7n42kudDm2tTiuv8Oo-PDJPM2AW8mmDZGm5SE9XkwR8v3bQ-dhenorV2ghIcxGN34Y26t3wpm1npUP8hh7vW2UKKN9eppqPxVdSyp6NhS5Yx0WrrhLwBFMfbojIUzeLzEHr2qMsXt2KpfVd-FRqkmRikguFKgJnKrBDTAiJjlW74_p-Gg5eeE-vZvvxpuXI13bes_l1jczyx9up5DA34xx0fD3n5HncB3QBegsbG33i5vh8UqMv-sA6Mm0pnHF-ck-bfJhjBx3QHm6ZZKWW57jlpFTLVT3pjl5mtKQCyzSJE4iR_yij_LSy07QYVSZtGz9DH7P09R_LgZQGn1vBCbUeJZPSd1D5eiiJ-IR0PkjFEgG7oxjdw4OAD1teVLGcczg53bwKoYfySdc6YUxQKRlMlu7_s6g6TPqPaVAd2wYr3uhEvmWUwMX4hJ_bXWPTByqFLzZ4fbgo_E7q3O-2XsIexmr13KTr_6DA3mQNxsQyA75u25nHmv01sM6yJJkFaEMAVQ9tBnbP4t5vOuv6ICCedENf3Fzo1iF6yWVDOPStDk2jSMmnqVRyVHaaXkdqt2xLmS-M-trwoKiWMcNuS6ClzzICpEQPkuxh2QR3e5_TpGbCJMtuJz0grrhB4jdlr-0jrdOw_11pOC-dcO63fENiAVDQb7rPUm3hOAl04LJA-9oICDQ3-USKqlX9SWaoX1o753MFWF3dvkWzXBgYT9tSuURMfc97y56x75bvNLre5IBLAicxMvSbJFoRmWycTcWwfkohpxRXEt8VK0h-x4uzWVgqjV4esgpOXMOG4qlO1Y3UnDOC1220JIaO9b3_LIKbXRSY_wlCR4tXwalQq3UBfelWw0TrFjrtWou_9WYuXURbIrn22xPQK6uhOdUGT4gPpA5BZUDf5g2ate0ajH4DAy3e3um6gv-MtH-9EGMMy_rZvVSdd91hvqWlBmzRyekiNbsryAQS7VrnP0kTPi9SzKTH85lS0MGjKwngEHJefzt8PDTaooW6dSFSdJsLlBc0LBOiI8MDEVyPANIKnuMKZbURXYD\\\" class=\\\"x1i10hfl xjbqb8w x1ejq31n x18oe1m7 x1sy0etr xstzfhl x972fbf x10w94by x1qhh985 x14e42zd x9f619 x1ypdohk xt0psk2 x3ct3a4 xdj266r x14z9mp xat24cr x1lziwak xexx8yu xyri2b x18d9i69 x1c1uobl x16tdsg8 x1hl2dhg xggy1nq x1a2a7pz xkrqix3 x1sur9pj x1fey0fg x1s688f\\\" href=\\\"https:\\/\\/drive.google.com\\/file\\/d\\/1MbN0XFANMaedGq7MQBLcaNOhhj4jBize\\/view?usp=sharing&amp;fbclid=IwZXh0bgNhZW0CMTAAYnJpZBExTld1bGxGTVBqYmtMSlRmVXNydGMGYXBwX2lkEDIyMjAzOTE3ODgyMDA4OTIAAR6ke18SpdTlxNQ75sexL7c8SVmHIJ2wFUwSitcE1Uj0Abys4O21Nc1uyH6KwA_aem_mRwfCixxHbWX22_MUGEBRA\\\" rel=\\\"nofollow noreferrer\\\" role=\\\"link\\\" tabindex=\\\"0\\\" target=\\\"_blank\\\" style=\\\"color: rgb(90, 167, 255); cursor: pointer; text-decoration: none; outline: none; border-inline-width: 0px; margin-inline: 0px; text-align: inherit; border-inline-style: none; padding-inline: 0px; -webkit-tap-highlight-color: transparent; font-weight: 600; list-style-type: none; touch-action: manipulation; display: inline; padding-bottom: 0px; border-top-style: none; border-bottom-width: 0px; border-bottom-style: none; border-top-width: 0px; margin-bottom: 0px; margin-top: 0px; padding-top: 0px;\\\">https:\\/\\/drive.google.com\\/file\\/d\\/1MbN0XFANMaedGq7MQBLcaNOhhj4jBize\\/view?fbclid=IwZXh0bgNhZW0CMTAAYnJpZBExTld1bGxGTVBqYmtMSlRmVXNydGMGYXBwX2lkEDIyMjAzOTE3ODgyMDA4OTIAAR6ke18SpdTlxNQ75sexL7c8SVmHIJ2wFUwSitcE1Uj0Abys4O21Nc1uyH6KwA_aem_mRwfCixxHbWX22_MUGEBRA<\\/a><\\/span><\\/div><\\/div><\\/div><\\/span><\\/div><\\/div><\\/div><\\/div><\\/div><div class=\\\"html-div xdj266r x14z9mp xat24cr x1lziwak xexx8yu xyri2b x18d9i69 x1c1uobl x1n2onr6\\\" style=\\\"margin-inline: 0px; padding-inline: 0px; position: relative; padding-bottom: 0px; margin-bottom: 0px; margin-top: 0px; padding-top: 0px; font-family: inherit;\\\"><div class=\\\"html-div xdj266r x14z9mp xat24cr x1lziwak xexx8yu xyri2b x18d9i69 x1c1uobl x1n2onr6\\\" style=\\\"margin-inline: 0px; padding-inline: 0px; position: relative; padding-bottom: 0px; margin-bottom: 0px; margin-top: 0px; padding-top: 0px; font-family: inherit;\\\"><div class=\\\"html-div xdj266r x14z9mp xat24cr x1lziwak xexx8yu xyri2b x18d9i69 x1c1uobl\\\" style=\\\"margin-inline: 0px; padding-inline: 0px; padding-bottom: 0px; margin-bottom: 0px; margin-top: 0px; padding-top: 0px; font-family: inherit;\\\"><div class=\\\"x1n2onr6\\\" style=\\\"position: relative; font-family: inherit;\\\"><div class=\\\"x1n2onr6\\\" style=\\\"position: relative; font-family: inherit; padding-top: 680px;\\\"><div class=\\\"x6ikm8r x10wlt62 x10l6tqk\\\" style=\\\"position: absolute; overflow: hidden; font-family: inherit; inset: calc(0% + 0px) calc(50% + 1.01px) calc(50% + 1.01px) calc(0% + 0px);\\\"><\\/div><div class=\\\"x6ikm8r x10wlt62 x10l6tqk\\\" style=\\\"position: absolute; overflow: hidden; font-family: inherit; inset: calc(50% + 1.01px) calc(50% + 1.01px) calc(0% + 0px) calc(0% + 0px);\\\"><\\/div><div class=\\\"x6ikm8r x10wlt62 x10l6tqk\\\" style=\\\"position: absolute; overflow: hidden; font-family: inherit; inset: calc(0% + 0px) calc(0% + 0px) calc(66.6667% + 1.01px) calc(50% + 1.01px);\\\"><\\/div><div class=\\\"x6ikm8r x10wlt62 x10l6tqk\\\" style=\\\"position: absolute; overflow: hidden; font-family: inherit; inset: calc(33.3333% + 1.01px) calc(0% + 0px) calc(33.3333% + 1.01px) calc(50% + 1.01px);\\\"><\\/div><div class=\\\"x6ikm8r x10wlt62 x10l6tqk\\\" style=\\\"position: absolute; overflow: hidden; font-family: inherit; inset: calc(66.6667% + 1.01px) calc(0% + 0px) calc(0% + 0px) calc(50% + 1.01px);\\\"><\\/div><\\/div><\\/div><\\/div><\\/div><div class=\\\"html-div xdj266r x14z9mp xat24cr x1lziwak xexx8yu xyri2b x18d9i69 x1c1uobl x6ikm8r x10wlt62\\\" style=\\\"margin-inline: 0px; padding-inline: 0px; overflow: hidden; padding-bottom: 0px; margin-bottom: 0px; margin-top: 0px; padding-top: 0px; font-family: inherit;\\\"><\\/div><\\/div><\\/div><div style=\\\"font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(28, 30, 33); font-size: 12px; background-color: rgb(37, 39, 40);\\\"><div class=\\\"xabvvm4 xeyy32k x1ia1hqs x1a2w583 x6ikm8r x10wlt62\\\" data-visualcompletion=\\\"ignore-dynamic\\\" style=\\\"overflow: hidden; border-radius: 0px 0px 8px 8px; font-family: inherit;\\\"><div style=\\\"font-family: inherit;\\\"><div style=\\\"font-family: inherit;\\\"><div style=\\\"font-family: inherit;\\\"><div class=\\\"x1n2onr6\\\" style=\\\"position: relative; font-family: inherit;\\\"><div class=\\\"x6s0dn4 xi81zsa x78zum5 x6prxxf x13a6bvl xvq8zen xdj266r xat24cr x1c1uobl xyri2b x1diwwjn xbmvrgn x1yrsyyn x18d9i69\\\" style=\\\"justify-content: flex-end; padding-inline: 0px; margin-inline: 12px; font-size: 0.9375rem; align-items: center; display: flex; color: rgb(176, 179, 184); line-height: 1.3333; padding-bottom: 0px; padding-top: 6px; margin-bottom: 0px; margin-top: 0px; font-family: inherit;\\\"><div class=\\\"x6s0dn4 x78zum5 x1iyjqo2 x6ikm8r x10wlt62\\\" style=\\\"flex-grow: 1; align-items: center; display: flex; overflow: hidden; font-family: inherit;\\\"><span aria-label=\\\"See who reacted to this\\\" class=\\\"x1ja2u2z\\\" role=\\\"toolbar\\\" style=\\\"z-index: 0; font-family: inherit;\\\"><span class=\\\"x6s0dn4 x78zum5 x135b78x\\\" style=\\\"padding-inline-start: 4px; align-items: center; display: flex; font-family: inherit;\\\"><span class=\\\"x6zyg47 x1lu4ftm xpn8fn3 x114g2xr xqbdsaf xpf24wh x14a4ghu x1a4jp9x x13fuv20 x18b5jzi x1q0q8m5 x1t7ytsu xamhcws x1alpsbp xlxy82 xyumdvf xmix8c7 x165d6jo x1n2onr6 x1xp8n7a xhtitgo\\\" style=\\\"border-inline: 2px solid rgb(37, 39, 40); border-end-end-radius: 11px; margin-inline-start: -4px; border-end-start-radius: 11px; position: relative; z-index: 2; border-start-end-radius: 11px; border-start-start-radius: 11px; border-top: 2px solid rgb(37, 39, 40); border-bottom: 2px solid rgb(37, 39, 40); width: 18px; height: 18px; font-family: inherit;\\\"><span class=\\\"x1fuqvrd xmvrd30 xt2fmn5 xkn4fgx x1rg5ohu xmix8c7 x1xp8n7a\\\" style=\\\"border-start-start-radius: 9px; display: inline-block; border-end-start-radius: 9px; border-start-end-radius: 9px; border-end-end-radius: 9px; width: 18px; height: 18px; font-family: inherit;\\\"><span class=\\\"html-span xdj266r x14z9mp xat24cr x1lziwak xexx8yu xyri2b x18d9i69 x1c1uobl x1hl2dhg x16tdsg8 x1vvkbs x4k7w5x x1h91t0o x1h9r5lt x1jfb8zj xv2umb2 x1beo9mf xaigb6o x12ejxvf x3igimt xarpa2k xedcshv x1lytzrv x1t2pt76 x7ja8zs x1qrby5j\\\" style=\\\"flex: inherit; margin-inline: 0px; text-align: inherit; flex-direction: inherit; padding-inline: 0px; align-items: inherit; align-self: inherit; display: inherit; overflow-wrap: break-word; place-content: inherit; padding-bottom: 0px; max-width: inherit; width: inherit; min-height: inherit; height: inherit; min-width: inherit; margin-bottom: 0px; margin-top: 0px; max-height: inherit; padding-top: 0px; font-family: inherit;\\\"><\\/span><\\/span><\\/span><span class=\\\"x6zyg47 x1lu4ftm xpn8fn3 x114g2xr xqbdsaf xpf24wh x14a4ghu x1a4jp9x x13fuv20 x18b5jzi x1q0q8m5 x1t7ytsu xamhcws x1alpsbp xlxy82 xyumdvf xmix8c7 x165d6jo x1n2onr6 x1xp8n7a x1vjfegm\\\" style=\\\"border-inline: 2px solid rgb(37, 39, 40); border-end-end-radius: 11px; margin-inline-start: -4px; border-end-start-radius: 11px; position: relative; z-index: 1; border-start-end-radius: 11px; border-start-start-radius: 11px; border-top: 2px solid rgb(37, 39, 40); border-bottom: 2px solid rgb(37, 39, 40); width: 18px; height: 18px; font-family: inherit;\\\"><span class=\\\"x1fuqvrd xmvrd30 xt2fmn5 xkn4fgx x1rg5ohu xmix8c7 x1xp8n7a\\\" style=\\\"border-start-start-radius: 9px; display: inline-block; border-end-start-radius: 9px; border-start-end-radius: 9px; border-end-end-radius: 9px; width: 18px; height: 18px; font-family: inherit;\\\"><span class=\\\"html-span xdj266r x14z9mp xat24cr x1lziwak xexx8yu xyri2b x18d9i69 x1c1uobl x1hl2dhg x16tdsg8 x1vvkbs x4k7w5x x1h91t0o x1h9r5lt x1jfb8zj xv2umb2 x1beo9mf xaigb6o x12ejxvf x3igimt xarpa2k xedcshv x1lytzrv x1t2pt76 x7ja8zs x1qrby5j\\\" style=\\\"flex: inherit; margin-inline: 0px; text-align: inherit; flex-direction: inherit; padding-inline: 0px; align-items: inherit; align-self: inherit; display: inherit; overflow-wrap: break-word; place-content: inherit; padding-bottom: 0px; max-width: inherit; width: inherit; min-height: inherit; height: inherit; min-width: inherit; margin-bottom: 0px; margin-top: 0px; max-height: inherit; padding-top: 0px; font-family: inherit;\\\"><\\/span><\\/span><\\/span><\\/span><\\/span><div style=\\\"font-family: inherit;\\\"><span class=\\\"html-span xdj266r x14z9mp xat24cr x1lziwak xexx8yu xyri2b x18d9i69 x1c1uobl x1hl2dhg x16tdsg8 x1vvkbs x4k7w5x x1h91t0o x1h9r5lt x1jfb8zj xv2umb2 x1beo9mf xaigb6o x12ejxvf x3igimt xarpa2k xedcshv x1lytzrv x1t2pt76 x7ja8zs x1qrby5j\\\" style=\\\"flex: inherit; margin-inline: 0px; text-align: inherit; flex-direction: inherit; padding-inline: 0px; align-items: inherit; align-self: inherit; display: inherit; overflow-wrap: break-word; place-content: inherit; padding-bottom: 0px; max-width: inherit; width: inherit; min-height: inherit; height: inherit; min-width: inherit; margin-bottom: 0px; margin-top: 0px; max-height: inherit; padding-top: 0px; font-family: inherit;\\\"><div class=\\\"x1i10hfl xjbqb8w x1ejq31n x18oe1m7 x1sy0etr xstzfhl x972fbf x10w94by x1qhh985 x14e42zd x9f619 x1ypdohk x3ct3a4 xdj266r x14z9mp xat24cr x1lziwak xexx8yu xyri2b x18d9i69 x1c1uobl x16tdsg8 x1hl2dhg xggy1nq x1fmog5m xu25z0z x140muxe xo1y3bh x1n2onr6 x87ps6o x1lku1pv x1a2a7pz x1heor9g xnl1qt8 x6ikm8r x10wlt62 x1vjfegm x1lliihq\\\" role=\\\"button\\\" tabindex=\\\"0\\\" style=\\\"outline: none; border-inline-width: 0px; border-end-end-radius: inherit; margin-inline: 0px; text-align: inherit; border-inline-style: none; padding-inline: 0px; border-start-start-radius: inherit; color: inherit; -webkit-tap-highlight-color: transparent; position: relative; z-index: 1; list-style-type: none; user-select: none; touch-action: manipulation; background-color: transparent; border-end-start-radius: inherit; border-start-end-radius: inherit; overflow: hidden; padding-bottom: 0px; border-top-style: none; border-bottom-width: 0px; border-bottom-style: none; border-top-width: 0px; margin-bottom: 0px; margin-top: 0px; padding-top: 0px; max-height: 1.3333em; font-family: inherit;\\\"><\\/div><\\/span><\\/div><\\/div><div class=\\\"x9f619 x1ja2u2z x78zum5 x2lah0s x1n2onr6 x1qughib x1qjc9v5 xozqiw3 x1q0g3np xyri2b x1c1uobl x1ws5yxj xw01apr x4cne27 xifccgj x123j3cw xs9asl8\\\" style=\\\"padding-inline: 0px; z-index: 0; position: relative; flex-flow: row; align-items: stretch; justify-content: space-between; margin-inline: -6px; flex-shrink: 0; display: flex; padding-top: 5px; margin-bottom: -6px; margin-top: -6px; padding-bottom: 5px; font-family: inherit;\\\"><\\/div><\\/div><\\/div><\\/div><\\/div><\\/div><\\/div><\\/div>\",\"image\":\"69c203bc6ef31_kuyaWIn.jpg\",\"status\":\"Active\",\"date_added\":\"2026-03-24\",\"ap_id\":null,\"up_id\":\"1\"}', '2026-03-24 03:47:03', 1, 1),
(75, 'university_scholarship', 27, '{\"scholarship_id\":\"27\",\"scholarship_title\":\"Kuya Win Scholarship\",\"description\":\"<p>THis is asdfsdafsadfdaf<\\/p>\",\"image\":\"69c20961a832e_kuyaWIn.jpg\",\"status\":\"Active\",\"date_added\":\"2026-03-24\",\"ap_id\":null,\"up_id\":\"1\"}', '2026-03-24 06:14:07', 1, 1),
(76, 'university_scholarship', 28, '{\"scholarship_id\":\"28\",\"scholarship_title\":\"Kuya Win Scholarship\",\"description\":\"<p>aasdasdasd<\\/p>\",\"image\":\"69c22bbfc06a3_kuyaWIn.jpg\",\"status\":\"Active\",\"date_added\":\"2026-03-24\",\"ap_id\":null,\"up_id\":\"1\"}', '2026-03-24 06:16:44', 1, 1),
(77, 'university_scholarship', 29, '{\"scholarship_id\":\"29\",\"scholarship_title\":\"Kuya Win Scholarship\",\"description\":\"<p>adsads<\\/p>\",\"image\":\"69c22c596753a_kuyaWIn.jpg\",\"status\":\"Active\",\"date_added\":\"2026-03-24\",\"ap_id\":null,\"up_id\":\"1\"}', '2026-03-24 06:18:17', 1, 1),
(78, 'university_scholarship', 30, '{\"scholarship_id\":\"30\",\"scholarship_title\":\"Kuya Win Scholarship\",\"description\":\"<p>asd<\\/p>\",\"image\":\"69c22cb276430_kuyaWIn.jpg\",\"status\":\"Active\",\"date_added\":\"2026-03-24\",\"ap_id\":null,\"up_id\":\"1\"}', '2026-03-24 06:18:32', 1, 1),
(79, 'university_scholarship', 32, '{\"scholarship_id\":\"32\",\"scholarship_title\":\"Kuya Win Scholarship\",\"description\":\"<p>sasdasd<\\/p>\",\"image\":\"69c22cf75978b_kuyaWIn.jpg\",\"status\":\"Active\",\"date_added\":\"2026-03-24\",\"ap_id\":null,\"up_id\":\"1\"}', '2026-03-24 06:19:58', 1, 1),
(80, 'university_scholarship', 33, '{\"scholarship_id\":\"33\",\"scholarship_title\":\"Kuya Win Scholarship\",\"description\":\"<p>asdasd<\\/p>\",\"image\":\"69c22d17499df_kuyaWIn.jpg\",\"status\":\"Active\",\"date_added\":\"2026-03-24\",\"ap_id\":null,\"up_id\":\"1\"}', '2026-03-24 06:24:49', 1, 1),
(81, 'university_scholarship', 34, '{\"scholarship_id\":\"34\",\"scholarship_title\":\"asdasdasd\",\"description\":\"<p>asdasd<\\/p>\",\"image\":\"69c22d41d9c7d_kuyaWIn.jpg\",\"status\":\"Active\",\"date_added\":\"2026-03-24\",\"ap_id\":null,\"up_id\":\"1\"}', '2026-03-24 06:24:53', 1, 1),
(82, 'university_scholarship', 35, '{\"scholarship_id\":\"35\",\"scholarship_title\":\"Kuya Win Scholarship\",\"description\":\"<p>asdasdasd<\\/p>\",\"image\":\"sch_69c22f60ada871.61661899.jpg\",\"status\":\"Active\",\"date_added\":\"2026-03-24\",\"ap_id\":null,\"up_id\":\"1\"}', '2026-03-24 07:01:17', 1, 1),
(83, 'university_scholarship', 36, '{\"scholarship_id\":\"36\",\"scholarship_title\":\"Kuya Win Scholarship\",\"description\":\"<p>asdasd<\\/p>\",\"image\":\"69c236ffd0aa4_kuyaWIn.jpg\",\"status\":\"Active\",\"date_added\":\"2026-03-24\",\"ap_id\":null,\"up_id\":\"1\"}', '2026-03-24 07:02:28', 1, 1),
(84, 'university_scholarship', 38, '{\"scholarship_id\":\"38\",\"scholarship_title\":\"WOWOwin\",\"description\":\"<p>Sarap Tames<\\/p>\",\"image\":\"69c34b6311927_images.jpg\",\"status\":\"Active\",\"date_added\":\"2026-03-25\",\"ap_id\":null,\"up_id\":\"1\"}', '2026-03-25 02:59:17', 37, 1),
(85, 'university_scholarship', 37, '{\"scholarship_id\":\"37\",\"scholarship_title\":\"Kuya Win Scholarship\",\"description\":\"<p><a href=\\\"http:\\/\\/youtube.com\\\" target=\\\"_blank\\\">hello<\\/a>&nbsp;kunitsiwaaa<\\/p><p>asdasd<\\/p>\",\"image\":\"69c34826368ca_kuyaWIn.jpg\",\"status\":\"Active\",\"date_added\":\"2026-03-25\",\"ap_id\":null,\"up_id\":\"1\"}', '2026-03-25 02:59:25', 37, 1),
(86, 'university_scholarship', 39, '{\"scholarship_id\":\"39\",\"scholarship_title\":\"Kuya Win Scholarship\",\"description\":\"<p>asdasd<\\/p>\",\"image\":\"69c34fb7e653d_kuyaWIn.jpg\",\"status\":\"Active\",\"date_added\":\"2026-03-25\",\"ap_id\":null,\"up_id\":\"1\"}', '2026-03-25 03:00:11', 37, 1);

-- --------------------------------------------------------

--
-- Table structure for table `university_calendar`
--

CREATE TABLE `university_calendar` (
  `uc_id` int(11) NOT NULL,
  `uc_title` text NOT NULL,
  `uc_month` varchar(20) NOT NULL,
  `uc_day` int(11) NOT NULL,
  `uc_description` text DEFAULT NULL,
  `uc_dateposted` date NOT NULL,
  `uc_timeposted` timestamp NOT NULL DEFAULT current_timestamp(),
  `ap_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `university_dean`
--

CREATE TABLE `university_dean` (
  `dean_id` int(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `date_appointed` date DEFAULT NULL,
  `status` varchar(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `ap_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `university_form`
--

CREATE TABLE `university_form` (
  `form_id` int(11) NOT NULL,
  `form_name` varchar(100) DEFAULT NULL,
  `form_description` text DEFAULT NULL,
  `form_path` varchar(255) NOT NULL,
  `date_uploaded` date DEFAULT NULL,
  `time_uploaded` time DEFAULT NULL,
  `ap_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `university_form`
--

INSERT INTO `university_form` (`form_id`, `form_name`, `form_description`, `form_path`, `date_uploaded`, `time_uploaded`, `ap_id`) VALUES
(19, 'Scholarship Application Form', 'students that needs financial aid.', '../assets/uploads/Downloadable_Forms/1747371942_4_Scholarship Application Form.pdf', '2025-05-16', '05:05:42', 1),
(20, '3_Personal Contract_Eng.docx', 'Personal Contract', '../assets/uploads/Downloadable_Forms/1747372912_3_Personal Contract_Eng.docx', '2025-05-16', '05:21:52', 1),
(21, '4_Application Receipt_Kh', 'Application Receipt', '../assets/uploads/Downloadable_Forms/1747372993_4_Application Receipt_Kh.docx', '2025-05-16', '05:23:13', 1),
(22, '5_Learning Discipline Agreement_Eng', 'Learning Discipline Agreement', '../assets/uploads/Downloadable_Forms/1747373079_5_Learning Discipline Agreement_Eng.docx', '2025-05-16', '05:24:39', 1),
(23, '6_Student ID Card Application', 'Student ID Card Application', '../assets/uploads/Downloadable_Forms/1747373123_6_ Student ID Card Application.docx', '2025-05-16', '05:25:23', 1),
(24, '7_Individual Memorandum Slip', 'Individual Memorandum Slip', '../assets/uploads/Downloadable_Forms/1747373160_7_Individual Memorandum Slip.docx', '2025-05-16', '05:26:00', 1),
(25, '8_Scholarship Receipt', 'Scholarship Receipt', '../assets/uploads/Downloadable_Forms/1747373209_8_Scholarship Receipt.docx', '2025-05-16', '05:26:49', 1),
(26, '1_Enrollment Form Foundation Year_Kh', 'Enrollment Form Foundation Year', '../assets/uploads/Downloadable_Forms/1747373253_1_Enrollment Form Foundation Year_Kh.pdf', '2025-05-16', '05:27:33', 1),
(27, '2_Student Personal Information', 'Student Personal Information', '../assets/uploads/Downloadable_Forms/1747373336_2_Student Personal Information.pdf', '2025-05-16', '05:28:56', 1),
(28, '3_Personal Contract_Kh', 'Personal Contract', '../assets/uploads/Downloadable_Forms/1747373423_3_Personal Contract_Kh.pdf', '2025-05-16', '05:30:23', 1),
(29, '4_Application Receipt_Eng', 'Application Receipt_Eng', '../assets/uploads/Downloadable_Forms/1747373486_4_Application Receipt_Eng.docx', '2025-05-16', '05:31:26', 1),
(30, '4_Scholarship Application  Form', 'Scholarship Application  Form', '../assets/uploads/Downloadable_Forms/1747373550_4_Scholarship Application Form.pdf', '2025-05-16', '05:32:30', 1),
(31, '5_Personal Agreement - Section A and Payment', 'Personal Agreement - Section A and Payment', '../assets/uploads/Downloadable_Forms/1747373659_5_Personal Agreement  Section A & Payment.pdf', '2025-05-16', '05:34:19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `university_founder`
--

CREATE TABLE `university_founder` (
  `founder_id` int(11) NOT NULL,
  `founder_fname` varchar(50) NOT NULL,
  `founder_mname` varchar(50) DEFAULT NULL,
  `founder_lname` varchar(50) NOT NULL,
  `founder_description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_founded` date DEFAULT NULL,
  `ap_id` int(11) DEFAULT NULL,
  `up_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `university_hymn`
--

CREATE TABLE `university_hymn` (
  `hymn_id` int(11) NOT NULL,
  `hymn_author` varchar(50) NOT NULL,
  `hymn_title` varchar(255) NOT NULL,
  `hymn_lyrics` text NOT NULL,
  `created_date` date NOT NULL,
  `created_time` time NOT NULL,
  `ap_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `university_hymn`
--

INSERT INTO `university_hymn` (`hymn_id`, `hymn_author`, `hymn_title`, `hymn_lyrics`, `created_date`, `created_time`, `ap_id`) VALUES
(1, 'N/A', 'No content as of now.', '<p data-start=\"78\" data-end=\"200\"><br></p>', '2025-02-19', '03:10:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `university_image`
--

CREATE TABLE `university_image` (
  `image_id` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `upload_date` date DEFAULT NULL,
  `album_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `university_image`
--

INSERT INTO `university_image` (`image_id`, `image_name`, `upload_date`, `album_id`) VALUES
(40, 'img_68104665888b18.32050867.jpg', '2025-04-29', 8),
(41, 'img_6810466588d8a7.24423825.jpg', '2025-04-29', 8),
(42, 'img_6810466588fba6.17991350.jpg', '2025-04-29', 8),
(44, 'img_68104684963a16.65763021.jpg', '2025-04-29', 8);

-- --------------------------------------------------------

--
-- Table structure for table `university_image_archive`
--

CREATE TABLE `university_image_archive` (
  `archive_image_id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `upload_date` date DEFAULT NULL,
  `album_id` int(11) DEFAULT NULL,
  `date_archived` timestamp NULL DEFAULT NULL,
  `ap_id` int(11) DEFAULT NULL,
  `up_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `university_image_archive`
--

INSERT INTO `university_image_archive` (`archive_image_id`, `image_id`, `image_name`, `upload_date`, `album_id`, `date_archived`, `ap_id`, `up_id`) VALUES
(15, 16, '4.png', '2025-03-19', 3, '2025-04-14 14:01:49', 1, 1),
(16, 14, '2.png', '2025-03-19', 3, '2025-04-21 04:44:20', 1, 1),
(23, 45, '20250502_130738.jpg', '2025-05-15', 9, '2025-05-15 00:00:00', 24, 1),
(32, 56, 'BITS_LOGO-removebg-preview.png', '2025-05-26', 11, '2025-05-26 00:00:00', 29, 1),
(33, 51, 'img_6826ccb1f1ddd0.25309422.png', '2025-05-16', 3, '2025-06-19 00:00:00', 24, 1),
(34, 52, 'img_6826ccb1f20c42.36660851.png', '2025-05-16', 3, '2025-06-19 00:00:00', 24, 1),
(35, 53, 'img_6826ccb1f240c4.06388778.png', '2025-05-16', 3, '2025-06-19 00:00:00', 24, 1),
(36, 46, 'img_6826cc5c0697f2.69101841.png', '2025-05-16', 2, '2025-06-19 00:00:00', 1, 1),
(37, 47, 'img_6826cc5c06d767.81789294.png', '2025-05-16', 2, '2025-06-19 00:00:00', 1, 1),
(38, 48, 'img_6826cc5c06faa5.83589776.png', '2025-05-16', 2, '2025-06-19 00:00:00', 1, 1),
(39, 49, 'img_6826cc5c071b03.36853140.png', '2025-05-16', 2, '2025-06-19 00:00:00', 1, 1),
(40, 50, 'img_6826cc5c073e22.71176889.png', '2025-05-16', 2, '2025-06-19 00:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `university_message`
--

CREATE TABLE `university_message` (
  `message_id` int(11) NOT NULL,
  `message_subject` varchar(255) NOT NULL,
  `message_body` longtext NOT NULL,
  `sender_email` varchar(100) NOT NULL,
  `sender_fname` varchar(100) NOT NULL,
  `sender_mname` varchar(100) DEFAULT NULL,
  `sender_lname` varchar(100) NOT NULL,
  `date_sent` datetime DEFAULT current_timestamp(),
  `status` enum('unread','read','deleted') DEFAULT 'unread',
  `ap_id` int(11) DEFAULT NULL,
  `up_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `university_message`
--

INSERT INTO `university_message` (`message_id`, `message_subject`, `message_body`, `sender_email`, `sender_fname`, `sender_mname`, `sender_lname`, `date_sent`, `status`, `ap_id`, `up_id`) VALUES
(2, 'Sample message 2', 'this message is sample only', 'ronaldferrerpayawal26@gmail.com', 'Ronald', 'Ferrer', 'Payawal', '2025-03-24 13:31:00', 'read', 1, 1),
(12, '123', '123', 'example@gmail.com', 'example', 'example', 'example', '2025-06-19 09:27:16', 'read', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `university_partnership`
--

CREATE TABLE `university_partnership` (
  `up_id` int(11) NOT NULL,
  `up_name` text NOT NULL,
  `up_image` varchar(255) DEFAULT NULL,
  `up_date` date NOT NULL,
  `up_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `up_status` varchar(11) NOT NULL,
  `up_link` text DEFAULT NULL,
  `ap_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `university_partnership`
--

INSERT INTO `university_partnership` (`up_id`, `up_name`, `up_image`, `up_date`, `up_time`, `up_status`, `up_link`, `ap_id`) VALUES
(18, 'Eurasia Foundation from Asia', 'Eurasia_from Asia.png', '2025-03-24', '2025-03-24 04:06:06', 'Active', 'http://www.eurasia.or.jp/en/', 1),
(19, 'University Malaysia Sarawak Unimas', 'University Malaysia Sarawa_UNIMAS.png', '2025-03-24', '2025-03-24 04:07:49', 'Active', 'https://www.unimas.my/', 1),
(20, 'Romblon State University', 'Romblon_State_University_Seal.png', '2025-03-24', '2025-03-24 04:08:29', 'Active', 'https://rsu.edu.ph/', 1),
(21, 'University of the EAST', 'University of the East_UE.png', '2025-03-24', '2025-03-24 04:08:52', 'Active', 'https://www.ue.edu.ph/', 1),
(22, 'Nagasaki University', 'Nagasaki University_ NU.jpg', '2025-03-24', '2025-03-24 04:09:19', 'Active', 'https://www.nagasaki-u.ac.jp/en/', 1),
(23, 'Guangxi University', 'Guangxi_University_GU.png', '2025-03-24', '2025-03-24 04:09:41', 'Active', 'https://english.gxu.edu.cn/', 1),
(24, 'Bulacan State Agricultural University', 'basc.png', '2025-03-24', '2025-03-24 04:10:07', 'Active', 'https://basc.edu.ph/', 1),
(25, 'Fao Fiat Panis', 'FAO_Cambodia.jpg', '2025-03-24', '2025-03-24 04:10:50', 'Active', 'https://www.facebook.com/faophilippines/?brand_redir=46370758585', 1),
(29, 'Giz Cambodia', 'GIZ_Cambodia.png', '2025-03-24', '2025-03-24 04:11:53', 'Active', 'https://www.giz.de/en/html/index.html', 1);

-- --------------------------------------------------------

--
-- Table structure for table `university_profile`
--

CREATE TABLE `university_profile` (
  `up_id` int(11) NOT NULL,
  `university_name` varchar(50) DEFAULT NULL,
  `university_logo` varchar(100) DEFAULT NULL,
  `university_street` varchar(100) DEFAULT NULL,
  `city_municipality` varchar(50) DEFAULT NULL,
  `university_country` varchar(50) DEFAULT NULL,
  `university_province` varchar(50) DEFAULT NULL,
  `university_postalcode` varchar(50) DEFAULT NULL,
  `university_contactnumber` varchar(50) DEFAULT NULL,
  `university_website` varchar(50) DEFAULT NULL,
  `fb_link` varchar(255) NOT NULL,
  `youtube_link` varchar(255) NOT NULL,
  `university_emailaddress` varchar(50) DEFAULT NULL,
  `university_yearestablished` varchar(10) DEFAULT NULL,
  `university_president` varchar(100) DEFAULT NULL,
  `university_background` longtext NOT NULL,
  `ap_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `university_profile`
--

INSERT INTO `university_profile` (`up_id`, `university_name`, `university_logo`, `university_street`, `city_municipality`, `university_country`, `university_province`, `university_postalcode`, `university_contactnumber`, `university_website`, `fb_link`, `youtube_link`, `university_emailaddress`, `university_yearestablished`, `university_president`, `university_background`, `ap_id`) VALUES
(1, 'University of Kratie', '1745814342_kratie logo.png', 'National Road 7', ' Sre Sdov Village, Sangkat Oru', 'Cambodia', ' Krong Kracheh, Kratie Province', 'F3V5+W4W', '+855-86-627-069\n+855-12-281-853\n+855-71-328-551', 'http://www.ukc.edu.kh/', 'https://www.facebook.com/ukt.edu.kh', 'https://www.youtube.com/@universityofkratie', 'information@ukt.edu.kh', '2002', 'Dr. Laymithuna Ngy', '<p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:8.0pt;\r\nmargin-left:.35pt;text-align:justify\"><span lang=\"EN-US\" style=\"font-size:12.0pt;\r\nline-height:107%;font-family:\" times=\"\" new=\"\" roman\",serif\"=\"\"><span style=\"font-size: 14pt;\">As a nation situated in\r\nSoutheast Asia, which has endured decades of foreign intervention and social\r\nunrest, the Kingdom of Cambodia has been acknowledged for experiencing numerous\r\npositive transformations over time. These advancements are not limited to\r\npolitical and security domains but extend to economic, commercial, and social\r\nsectors. These changes were a result of the Win-Win Policy executed by Prime\r\nMinister Samdech Akka Moha Sena Padei Techo HUN SEN, following the significant\r\nachievement of complete peace, national unity, social order, political\r\nstability, macroeconomic and financial stability, democracy, and human rights\r\nby the end of 1998. </span><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:8.0pt;\r\nmargin-left:.35pt;text-align:justify\"><span lang=\"EN-US\" style=\"font-size: 14pt; line-height: 107%;\" times=\"\" new=\"\" roman\",serif\"=\"\">&nbsp;</span></p><p class=\"MsoListParagraphCxSpFirst\" style=\"text-align: justify; \"><span style=\"font-size: 14pt;\">\r\n\r\n\r\n\r\n</span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:8.0pt;\r\nmargin-left:.35pt;text-align:justify\"><span lang=\"EN-US\" style=\"font-size:12.0pt;\r\nline-height:107%;font-family:\" times=\"\" new=\"\" roman\",serif\"=\"\"><span style=\"font-size: 14pt;\">Nevertheless, Cambodia\r\nstill requires additional resources and means to bolster and expand its growth\r\nfoundation, particularly to ensure sustainable development. Therefore, the\r\nRoyal Government of Cambodia (RGC) has consistently focused on multifaceted development\r\nas outlined in the Rectangular Strategy, which emphasizes four key areas:\r\nenhancing the agricultural sector, further rehabilitating and constructing\r\nphysical infrastructure, developing the private sector, generating employment,\r\nand especially, building capacity and developing human resources. In line with\r\nthis direction, the Prime Minister highlighted and supported the establishment\r\nand expansion of higher educational institutions in provinces under the slogan\r\n\"One Province, One Public University.\"</span><br><br></span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:8.0pt;\r\nmargin-left:.35pt;text-align:justify\"><span lang=\"EN-US\" style=\"font-size:12.0pt;\r\nline-height:107%;font-family:\" times=\"\" new=\"\" roman\",serif\"=\"\"><span style=\"font-size: 14pt;\">In line with these\r\nobjectives, and to strengthen and develop human resources in parallel with the\r\nRGC\'s strategic plan, with generous financial contributions from the Prime\r\nMinister to the Khmer Fund for Higher Education Opportunities (KFHEO), the\r\nmanagement team, led by H.E. Dr. KEAT CHHON as President, Akka Pundit\r\nSapheacha, Deputy Minister AUN PORNMONIROTH as Vice President, and H.E. Dr. NGY\r\nTAYI as Executive Director, has actively coordinated and collected\r\ncontributions for the construction of the university in Kratie province. </span><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:8.0pt;\r\nmargin-left:.35pt;text-align:justify\"><span lang=\"EN-US\" style=\"font-size: 14pt; line-height: 107%;\" times=\"\" new=\"\" roman\",serif\"=\"\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:8.0pt;\r\nmargin-left:.35pt;text-align:justify\"><span lang=\"EN-US\" style=\"font-size:12.0pt;\r\nline-height:107%;font-family:\" times=\"\" new=\"\" roman\",serif\"=\"\"><span style=\"font-size: 14pt;\">With Grant-Aid support\r\nfrom the People\'s Republic of China (PRC) through an agreement between Samdech\r\nPrime Minister and H.E. XI JINGPING, President of the PRC, the construction of\r\nUKT (Phase 1) was smoothly initiated following approval by Samdech. The “University\r\nof Kratie (UKT)” was officially established by Sub-Decree No. 8 ANKK dated </span><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:8.0pt;\r\nmargin-left:.35pt;text-align:justify\"><span lang=\"EN-US\" style=\"font-size:12.0pt;\r\nline-height:107%;font-family:\" times=\"\" new=\"\" roman\",serif\"=\"\"><span style=\"font-size: 14pt;\">February 6, 2015, in\r\nKratie Province, encompassing a total area of 99.01 hectares (SubDecree No. 143\r\ndated September 11, 2012). This was made possible by the continuous support and\r\ncoordination of KFHEO, the Ministry of Economy and Finance (MEF), and the\r\nMinistry of Education, Youth and Sports (MEYS). </span><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:8.0pt;\r\nmargin-left:.35pt;text-align:justify\"><span lang=\"EN-US\" style=\"font-size: 14pt; line-height: 107%;\" times=\"\" new=\"\" roman\",serif\"=\"\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:8.0pt;\r\nmargin-left:.35pt;text-align:justify\"><span lang=\"EN-US\" style=\"font-size:12.0pt;\r\nline-height:107%;font-family:\" times=\"\" new=\"\" roman\",serif\"=\"\"><span style=\"font-size: 14pt;\">The UKT was established\r\nunder the regulation of MEYS and is set to evolve into a \"University\r\nCity\" in the northeastern part of Cambodia. It aims to provide educational\r\ntraining, know-how, and practical skills instilled with nationalism. The acquired\r\nknowledge will be applied in the university farm to ensure practical skills and\r\nprofessionalism before entering the workforce, contributing to national\r\ndevelopment. </span><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:8.0pt;\r\nmargin-left:.35pt;text-align:justify\"><span lang=\"EN-US\" style=\"font-size: 14pt; line-height: 107%;\" times=\"\" new=\"\" roman\",serif\"=\"\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:8.0pt;\r\nmargin-left:.35pt;text-align:justify\"><span lang=\"EN-US\" style=\"font-size:12.0pt;\r\nline-height:107%;font-family:\" times=\"\" new=\"\" roman\",serif\"=\"\"><span style=\"font-size: 14pt;\">Initially, UKT will focus\r\non training in agricultural science (agronomy and ichthyology), agroindustry,\r\nrural engineering, business management, foreign languages, and information. The\r\nuniversity\'s reputation is founded on the high-quality training that will\r\ncommence from the academic year 2018-2019 onward. </span><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:8.0pt;\r\nmargin-left:.35pt;text-align:justify\"><span lang=\"EN-US\" style=\"font-size: 14pt; line-height: 107%;\" times=\"\" new=\"\" roman\",serif\"=\"\">&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:8.0pt;\r\nmargin-left:.35pt;text-align:justify\"><span lang=\"EN-US\" style=\"font-size:12.0pt;\r\nline-height:107%;font-family:\" times=\"\" new=\"\" roman\",serif\"=\"\"><span style=\"font-size: 14pt;\">As a member of ASEAN,\r\nCambodia must develop its professional skills and workforce to meet the demands\r\nof the highly competitive regional and global markets. It is crucial to ensure\r\nthat graduates are highly qualified according to labor market demands, aligning\r\nwith the status of regional countries and the context of climate change. </span><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:.6pt;text-align:justify\"><span lang=\"EN-US\" style=\"font-size:12.0pt;line-height:107%;font-family:\" times=\"\" new=\"\" roman\",serif\"=\"\"><span style=\"font-size: 14pt;\">&nbsp;</span><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:8.0pt;\r\nmargin-left:.35pt;text-align:justify\"><span lang=\"EN-US\" style=\"font-size:12.0pt;\r\nline-height:107%;font-family:\" times=\"\" new=\"\" roman\",serif\"=\"\"><span style=\"font-size: 14pt;\">Aligned\r\nwith this vision, UKT is dedicated to preparing itself to meet national and\r\nglobal training standards, striving for \"Academic Excellence\" to\r\nboost the development of Cambodian society and economic growth while equipping\r\nitself for integration into regional economic competition.</span><span style=\"font-size: 14pt;\">&nbsp;</span><o:p></o:p></span></p>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `university_scholarship`
--

CREATE TABLE `university_scholarship` (
  `scholarship_id` int(11) NOT NULL,
  `scholarship_title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `date_added` date NOT NULL DEFAULT current_timestamp(),
  `ap_id` int(11) DEFAULT NULL,
  `up_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `university_video`
--

CREATE TABLE `university_video` (
  `video_id` int(11) NOT NULL,
  `video_link` text NOT NULL,
  `upload_date` date NOT NULL,
  `album_id` int(11) NOT NULL,
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `university_video`
--

INSERT INTO `university_video` (`video_id`, `video_link`, `upload_date`, `album_id`, `is_pinned`) VALUES
(1, 'https://www.youtube.com/watch?v=RZ-qRDEQD-0&t=6s', '2026-03-25', 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `university_vmgo`
--

CREATE TABLE `university_vmgo` (
  `vmgo_id` int(11) NOT NULL,
  `university_mission` text NOT NULL,
  `university_vision` text NOT NULL,
  `university_goal` text NOT NULL,
  `university_core` text NOT NULL,
  `ap_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `university_vmgo`
--

INSERT INTO `university_vmgo` (`vmgo_id`, `university_mission`, `university_vision`, `university_goal`, `university_core`, `ap_id`) VALUES
(1, '<p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:8.0pt;\r\nmargin-left:17.0pt;text-align:justify\"><span style=\"font-family: Verdana; font-size: 18px;\">﻿</span><span style=\"font-family: Verdana; font-size: 18px;\">﻿</span><span style=\"font-family: Verdana; font-size: 18px;\">﻿</span><span style=\"font-family: Verdana; font-size: 18px;\">﻿</span><span lang=\"EN-US\" style=\"font-size:12.0pt;\r\nline-height:107%;font-family:\" times=\"\" new=\"\" roman\",serif\"=\"\"><span style=\"font-family: Verdana; font-size: 18px;\" times=\"\" new=\"\" roman\";\"=\"\">UKT is dedicated to\r\nproviding high-quality, accessible education in agriculture, fisheries,\r\neducation, rural development, and business entrepreneurship. Through academic\r\nachievement, research, and community engagement, we aim to empower individuals,\r\nsupport regional grow</span></span><span style=\"font-family: Verdana; font-size: 18px;\">﻿</span><span lang=\"EN-US\" style=\"font-size:12.0pt;\r\nline-height:107%;font-family:\" times=\"\" new=\"\" roman\",serif\"=\"\"><span style=\"font-family: Verdana; font-size: 18px;\" times=\"\" new=\"\" roman\";\"=\"\">th, and advance Cambodia\'s socioeconomic progress.&nbsp;</span><o:p></o:p></span></p><p><br></p>', '<p><span lang=\"EN-US\" style=\"font-size: 14pt; line-height: 107%; font-family: Verdana;\">To be Cambodia\'s leading higher education\r\ninstitution, empowering northeastern provinces via innovative learning,\r\nsustainable development, and transformative leadership while linking urban and\r\nrural possibilities.&nbsp;</span><span style=\"font-family: Verdana; font-size: 14pt;\">﻿</span></p>', '<p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:.25pt;\r\nmargin-left:26.0pt;text-align:justify;text-indent:-9.0pt;line-height:103%;\r\nmso-list:l0 level1 lfo1;tab-stops:26.0pt\"><span style=\"font-family: Verdana;\">﻿</span><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-family: Arial, sans-serif;\"><span style=\"font-family: Verdana;\">•</span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: Verdana;\">&nbsp;&nbsp;\r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:12.0pt;\r\nline-height:103%;font-family:\" times=\"\" new=\"\" roman\",serif\"=\"\"><span style=\"font-family: Verdana;\">To develop the university\r\ninfrastructure to become a fully operational facility, an institution for\r\nresearch, and involve both learners and instructors. </span><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:.25pt;\r\nmargin-left:26.0pt;text-align:justify;text-indent:-9.0pt;line-height:103%;\r\nmso-list:l0 level1 lfo1;tab-stops:26.0pt\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-family: Arial, sans-serif;\"><span style=\"font-family: Verdana;\">•</span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: Verdana;\">&nbsp;&nbsp;\r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size: 12pt; line-height: 103%; font-family: Verdana;\">To encourage teaching\r\nstaff and mid-level administrative staff to obtain at least a master\'s degree\r\nand become proficient in English and IT.</span><span lang=\"EN-US\" style=\"text-indent: -9pt; font-family: Arial, sans-serif;\"><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: \" times=\"\" new=\"\" roman\";\"=\"\"><br></span></span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:.25pt;\r\nmargin-left:26.0pt;text-align:justify;text-indent:-9.0pt;line-height:103%;\r\nmso-list:l0 level1 lfo1;tab-stops:26.0pt\"><span style=\"caret-color: rgba(0, 0, 0, 0); font-family: Verdana;\">•</span><span style=\"caret-color: rgba(0, 0, 0, 0); font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: Verdana;\">&nbsp; &nbsp;</span><span style=\"font-family: Verdana; font-size: 12pt; text-indent: -9pt;\">To motivate all staff and\r\nlecturers of the University to work responsibly, honestly, professionally, and\r\nto live with dignity.&nbsp;<br></span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:.25pt;\r\nmargin-left:26.0pt;text-align:justify;text-indent:-9.0pt;line-height:103%;\r\nmso-list:l0 level1 lfo1;tab-stops:26.0pt\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-family: Arial, sans-serif;\"><span style=\"font-family: Verdana;\">•</span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: Verdana;\">&nbsp;&nbsp;\r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:12.0pt;\r\nline-height:103%;font-family:&quot;Times New Roman&quot;,serif\"><span style=\"font-family: Verdana;\">To promote the exchange\r\nof lecturers and students with local university, ASEAN member universities, and\r\nalso offers various services to development partners and private enterprises. </span><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:.25pt;\r\nmargin-left:26.0pt;text-align:justify;text-indent:-9.0pt;line-height:103%;\r\nmso-list:l0 level1 lfo1;tab-stops:26.0pt\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-family: Arial, sans-serif;\"><span style=\"font-family: Verdana;\">•</span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: Verdana;\">&nbsp;&nbsp;\r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:12.0pt;\r\nline-height:103%;font-family:&quot;Times New Roman&quot;,serif\"><span style=\"font-family: Verdana;\">To provide basic IT\r\nservices such as: free using of E-mail and Internet for staff, lecturers, and\r\nstudents. </span><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:.25pt;\r\nmargin-left:26.0pt;text-align:justify;text-indent:-9.0pt;line-height:103%;\r\nmso-list:l0 level1 lfo1;tab-stops:26.0pt\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-family: Arial, sans-serif;\"><span style=\"font-family: Verdana;\">•</span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: Verdana;\">&nbsp;&nbsp;\r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:12.0pt;\r\nline-height:103%;font-family:&quot;Times New Roman&quot;,serif\"><span style=\"font-family: Verdana;\">To be the focal of\r\nelectronic resource and printing materials that is up-to-date for education and\r\nresearch serving the communities. </span><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:.25pt;\r\nmargin-left:26.0pt;text-align:justify;text-indent:-9.0pt;line-height:103%;\r\nmso-list:l0 level1 lfo1;tab-stops:26.0pt\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-family: Arial, sans-serif;\"><span style=\"font-family: Verdana;\">•</span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: Verdana;\">&nbsp;&nbsp;\r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:12.0pt;\r\nline-height:103%;font-family:&quot;Times New Roman&quot;,serif\"><span style=\"font-family: Verdana;\">To ensure safety and\r\ncomfort for teaching and learning environment. </span><o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:.25pt;\r\nmargin-left:26.0pt;text-align:justify;text-indent:-9.0pt;line-height:103%;\r\nmso-list:l0 level1 lfo1;tab-stops:26.0pt\"><span style=\"font-family: Verdana;\">\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n</span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:.25pt;\r\nmargin-left:26.0pt;text-align:justify;text-indent:-9.0pt;line-height:103%;\r\nmso-list:l0 level1 lfo1;tab-stops:26.0pt\"><!--[if !supportLists]--><span lang=\"EN-US\" style=\"font-family: Arial, sans-serif;\"><span style=\"font-family: Verdana;\">•</span><span style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: Verdana;\">&nbsp;&nbsp;\r\n</span></span><!--[endif]--><span lang=\"EN-US\" style=\"font-size:12.0pt;\r\nline-height:103%;font-family:&quot;Times New Roman&quot;,serif\"><span style=\"font-family: Verdana;\">To become a leading\r\ncenter in the field of research, science, publications and community service\r\naimed at contributing to social and economic development of the country.&nbsp;</span><o:p></o:p></span></p>', '<p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:.25pt;\r\nmargin-left:26.0pt;text-align:justify;text-indent:-9.0pt;line-height:103%;\r\nmso-list:l0 level1 lfo1;tab-stops:26.0pt\"><span style=\"caret-color: rgba(0, 0, 0, 0); font-family: Verdana;\">•</span><span times=\"\" new=\"\" roman\";\"=\"\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: Arial, sans-serif;\"><span style=\"font-family: Verdana;\">&nbsp;&nbsp;</span><span style=\"font-family: Verdana;\">&nbsp;</span></span><span style=\"font-family: Verdana; font-size: 12pt; text-indent: -9pt;\">Honesty. Prioritize transparency in work ethics, professionalism, study, and research.</span></p><p class=\"MsoNormal\" style=\"box-sizing: border-box; margin: 0cm 1.8pt 0.25pt 26pt; caret-color: rgba(0, 0, 0, 0); color: rgb(0, 0, 0); font-family: sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: normal; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; text-align: justify; text-indent: -9pt; line-height: 16.48px;\"><span lang=\"EN-US\" style=\"box-sizing: border-box; caret-color: transparent !important; font-family: Arial, sans-serif;\"><span style=\"font-family: Verdana;\">•</span><span times=\"\" new=\"\" roman\";\"=\"\" style=\"box-sizing: border-box; caret-color: transparent !important; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal;\"><span style=\"font-family: Verdana;\">&nbsp;&nbsp;</span><span style=\"font-family: Verdana;\">&nbsp;</span></span></span><span lang=\"EN-US\" times=\"\" new=\"\" roman\",serif\"=\"\" style=\"box-sizing: border-box; caret-color: transparent !important; font-size: 12pt; line-height: 16.48px;\"><span style=\"font-family: Verdana;\">Teamwork. Provide the value of unity and solidarity in performance;</span><o:p style=\"box-sizing: border-box; caret-color: transparent !important;\"></o:p></span></p><p class=\"MsoNormal\" style=\"box-sizing: border-box; margin: 0cm 1.8pt 0.25pt 26pt; caret-color: rgba(0, 0, 0, 0); color: rgb(0, 0, 0); font-family: sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: normal; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; text-align: justify; text-indent: -9pt; line-height: 16.48px;\"><span lang=\"EN-US\" style=\"box-sizing: border-box; caret-color: transparent !important; font-family: Arial, sans-serif;\"><span style=\"font-family: Verdana;\">•</span><span times=\"\" new=\"\" roman\";\"=\"\" style=\"box-sizing: border-box; caret-color: transparent !important; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal;\"><span style=\"font-family: Verdana;\">&nbsp;&nbsp;</span><span style=\"font-family: Verdana;\">&nbsp;</span></span></span><span lang=\"EN-US\" times=\"\" new=\"\" roman\",serif\"=\"\" style=\"box-sizing: border-box; caret-color: transparent !important; font-size: 12pt; line-height: 16.48px;\"><span style=\"font-family: Verdana;\">Good Service. Provides excellent services such as a learning environment harmonious environment for educational work, and training.</span><o:p style=\"box-sizing: border-box; caret-color: transparent !important;\"></o:p></span></p><p class=\"MsoNormal\" style=\"box-sizing: border-box; margin: 0cm 1.8pt 0.25pt 26pt; caret-color: rgba(0, 0, 0, 0); color: rgb(0, 0, 0); font-family: sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: normal; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; text-align: justify; text-indent: -9pt; line-height: 16.48px;\"><span lang=\"EN-US\" style=\"box-sizing: border-box; caret-color: transparent !important; font-family: Arial, sans-serif;\"><span style=\"font-family: Verdana;\">•</span><span times=\"\" new=\"\" roman\";\"=\"\" style=\"box-sizing: border-box; caret-color: transparent !important; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal;\"><span style=\"font-family: Verdana;\">&nbsp;&nbsp;</span><span style=\"font-family: Verdana;\">&nbsp;</span></span></span><span lang=\"EN-US\" times=\"\" new=\"\" roman\",serif\"=\"\" style=\"box-sizing: border-box; font-size: 12pt; line-height: 16.48px; font-family: Verdana; caret-color: transparent !important;\">Creative and Innovative.</span><b style=\"box-sizing: border-box; font-weight: bolder; caret-color: transparent !important;\"><span lang=\"EN-US\" times=\"\" new=\"\" roman\",serif;mso-fareast-font-family:=\"\" arial\"=\"\" style=\"box-sizing: border-box; caret-color: transparent !important; font-size: 12pt; line-height: 16.48px;\"><span style=\"font-family: Verdana;\">&nbsp;</span></span></b><span lang=\"EN-US\" times=\"\" new=\"\" roman\",serif\"=\"\" style=\"box-sizing: border-box; font-size: 12pt; line-height: 16.48px; font-family: Verdana; caret-color: transparent !important;\">Create first-hand initiatives and new funding mechanisms;</span><span lang=\"EN-US\" style=\"text-indent: -9pt; font-family: Arial, sans-serif;\"><span times=\"\" new=\"\" roman\";\"=\"\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal;\"><br></span></span></p><p class=\"MsoNormal\" style=\"box-sizing: border-box; margin: 0cm 1.8pt 0.25pt 26pt; caret-color: rgba(0, 0, 0, 0); color: rgb(0, 0, 0); font-family: sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-transform: none; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; white-space: normal; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial; text-align: justify; text-indent: -9pt; line-height: 16.48px;\"><span style=\"caret-color: rgba(0, 0, 0, 0); font-family: Verdana;\">•</span><span times=\"\" new=\"\" roman\";\"=\"\" style=\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-language-override: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: Verdana;\">&nbsp; &nbsp;</span><span style=\"font-size: 12pt; text-indent: -9pt; font-family: Verdana;\">Inspire for the Future. Provide a vision and an opportunity for all to achieve their future potential.&nbsp;</span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:.25pt;\r\nmargin-left:26.0pt;text-align:justify;text-indent:-9.0pt;line-height:103%;\r\nmso-list:l0 level1 lfo1;tab-stops:26.0pt\"><span lang=\"EN-US\" style=\"font-family: Arial, sans-serif;\"></span></p><p class=\"MsoNormal\" style=\"margin-top:0cm;margin-right:1.8pt;margin-bottom:.25pt;\r\nmargin-left:26.0pt;text-align:justify;text-indent:-9.0pt;line-height:103%;\r\nmso-list:l0 level1 lfo1;tab-stops:26.0pt\"><span lang=\"EN-US\" style=\"font-size:12.0pt;\r\nline-height:103%;font-family:\" times=\"\" new=\"\" roman\",serif\"=\"\"><o:p></o:p></span></p>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `user_type` varchar(20) NOT NULL,
  `account_status` enum('pending','approved','denied','blocked') NOT NULL,
  `forgot_password_code` varchar(50) DEFAULT NULL,
  `password_last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `session_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`user_id`, `username`, `email`, `password`, `image`, `user_type`, `account_status`, `forgot_password_code`, `password_last_updated`, `session_token`) VALUES
(1, 'admin', 'admin@gmail.com', 'L@ester5423', '1771546751_UKT Logo.png', 'Administrator', 'blocked', '1QD4LNOF2I', '2026-03-24 02:43:08', 'um64ckp9j6429m63v9jtk2iedq'),
(29, 'Xtian', 'deleted1@gmail.com', 'cute', '', 'Content manager', 'approved', 'JYEI8F27BT', '2026-02-25 06:12:36', '1ph6k8spt346j7afvp1u8atjp8'),
(34, 'Ma\'am Emilyn', 'deleted@gmail.com', '12345', 'profile (1).png', 'Administrator', 'blocked', '71KELMWHVG', '2026-02-19 08:20:18', '2ppsq1v8h50pubm8haa92hote3'),
(41, 'lester', 'lesterarjaymerino.basc@gmail.com', 'L@ester5423', 'profile (1).png', 'Content manager', 'approved', 'KHLI5GO0FX', '2026-03-19 04:17:30', NULL),
(43, 'sad123', 'sadking347@gmail.com', 'asd123', 'default-profile.jpeg', 'Content manager', 'denied', NULL, '2026-03-25 02:11:58', '634s1lak5nru8d9dnkfjbju80c');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admission_requirement`
--
ALTER TABLE `admission_requirement`
  ADD PRIMARY KEY (`requirement_id`),
  ADD KEY `ap_id` (`ap_id`),
  ADD KEY `up_id` (`up_id`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`announcement_id`),
  ADD KEY `ap_id` (`ap_id`);

--
-- Indexes for table `authorized_person`
--
ALTER TABLE `authorized_person`
  ADD PRIMARY KEY (`ap_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `board_of_director`
--
ALTER TABLE `board_of_director`
  ADD PRIMARY KEY (`director_id`),
  ADD KEY `ap_id` (`ap_id`);

--
-- Indexes for table `computer_laboratory`
--
ALTER TABLE `computer_laboratory`
  ADD PRIMARY KEY (`lab_id`),
  ADD KEY `ap_id` (`ap_id`),
  ADD KEY `up_id` (`up_id`);

--
-- Indexes for table `computer_laboratory_image`
--
ALTER TABLE `computer_laboratory_image`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `lab_id` (`lab_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`),
  ADD KEY `ap_id` (`ap_id`),
  ADD KEY `up_id` (`up_id`);

--
-- Indexes for table `department_facilities`
--
ALTER TABLE `department_facilities`
  ADD PRIMARY KEY (`facility_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `faculty_member`
--
ALTER TABLE `faculty_member`
  ADD PRIMARY KEY (`fm_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`faq_id`),
  ADD KEY `ap_id` (`ap_id`);

--
-- Indexes for table `highlight`
--
ALTER TABLE `highlight`
  ADD PRIMARY KEY (`h_id`),
  ADD KEY `ap_id` (`ap_id`);

--
-- Indexes for table `history_log`
--
ALTER TABLE `history_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `job_opportunities`
--
ALTER TABLE `job_opportunities`
  ADD PRIMARY KEY (`job_id`),
  ADD KEY `up_id` (`up_id`),
  ADD KEY `ap_id` (`ap_id`);

--
-- Indexes for table `job_vacancy`
--
ALTER TABLE `job_vacancy`
  ADD PRIMARY KEY (`vacancy_id`),
  ADD KEY `ap_id` (`ap_id`),
  ADD KEY `up_id` (`up_id`);

--
-- Indexes for table `library_album`
--
ALTER TABLE `library_album`
  ADD PRIMARY KEY (`libalbum_id`),
  ADD KEY `ap_id` (`ap_id`),
  ADD KEY `library_id` (`library_id`);

--
-- Indexes for table `library_archive`
--
ALTER TABLE `library_archive`
  ADD PRIMARY KEY (`libraryarchive_id`),
  ADD KEY `archived_by` (`archived_by`),
  ADD KEY `library_id` (`library_id`);

--
-- Indexes for table `library_image`
--
ALTER TABLE `library_image`
  ADD PRIMARY KEY (`libimage_id`),
  ADD KEY `libalbum_id` (`libalbum_id`);

--
-- Indexes for table `library_resources`
--
ALTER TABLE `library_resources`
  ADD PRIMARY KEY (`resource_id`),
  ADD KEY `ap_id` (`ap_id`),
  ADD KEY `library_id` (`library_id`);

--
-- Indexes for table `library_staff`
--
ALTER TABLE `library_staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `library_id` (`library_id`),
  ADD KEY `ap_id` (`ap_id`);

--
-- Indexes for table `library_university`
--
ALTER TABLE `library_university`
  ADD PRIMARY KEY (`library_id`),
  ADD KEY `ap_id` (`ap_id`),
  ADD KEY `up_id` (`up_id`);

--
-- Indexes for table `library_updates`
--
ALTER TABLE `library_updates`
  ADD PRIMARY KEY (`update_id`),
  ADD KEY `ap_id` (`ap_id`),
  ADD KEY `library_id` (`library_id`);

--
-- Indexes for table `message_reply`
--
ALTER TABLE `message_reply`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `message_id` (`message_id`),
  ADD KEY `ap_id` (`ap_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`),
  ADD KEY `ap_id` (`ap_id`);

--
-- Indexes for table `operating_hours`
--
ALTER TABLE `operating_hours`
  ADD PRIMARY KEY (`oh_id`),
  ADD UNIQUE KEY `day` (`day`,`library_id`),
  ADD KEY `ap_id` (`ap_id`),
  ADD KEY `library_id` (`library_id`);

--
-- Indexes for table `page_poster`
--
ALTER TABLE `page_poster`
  ADD PRIMARY KEY (`poster_id`),
  ADD KEY `ap_id` (`ap_id`);

--
-- Indexes for table `program_offering`
--
ALTER TABLE `program_offering`
  ADD PRIMARY KEY (`program_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `rector`
--
ALTER TABLE `rector`
  ADD PRIMARY KEY (`rector_id`),
  ADD KEY `ap_id` (`ap_id`);

--
-- Indexes for table `research_project`
--
ALTER TABLE `research_project`
  ADD PRIMARY KEY (`research_id`),
  ADD KEY `ap_id` (`ap_id`),
  ADD KEY `library_id` (`library_id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`settings_id`),
  ADD KEY `ap_id` (`ap_id`),
  ADD KEY `up_id` (`up_id`);

--
-- Indexes for table `universityprofile_image`
--
ALTER TABLE `universityprofile_image`
  ADD PRIMARY KEY (`upimage_id`),
  ADD KEY `ap_id` (`ap_id`),
  ADD KEY `up_id` (`up_id`);

--
-- Indexes for table `university_album`
--
ALTER TABLE `university_album`
  ADD PRIMARY KEY (`album_id`),
  ADD KEY `ap_id` (`ap_id`),
  ADD KEY `up_id` (`up_id`);

--
-- Indexes for table `university_album_archive`
--
ALTER TABLE `university_album_archive`
  ADD PRIMARY KEY (`archive_album_id`),
  ADD KEY `ap_id` (`ap_id`),
  ADD KEY `up_id` (`up_id`);

--
-- Indexes for table `university_archive`
--
ALTER TABLE `university_archive`
  ADD PRIMARY KEY (`archive_id`),
  ADD KEY `archived_by` (`archived_by`),
  ADD KEY `up_id` (`up_id`);

--
-- Indexes for table `university_calendar`
--
ALTER TABLE `university_calendar`
  ADD PRIMARY KEY (`uc_id`),
  ADD KEY `fk_authorized_person` (`ap_id`);

--
-- Indexes for table `university_dean`
--
ALTER TABLE `university_dean`
  ADD PRIMARY KEY (`dean_id`),
  ADD KEY `ap_id` (`ap_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `university_form`
--
ALTER TABLE `university_form`
  ADD PRIMARY KEY (`form_id`),
  ADD KEY `ap_id` (`ap_id`);

--
-- Indexes for table `university_founder`
--
ALTER TABLE `university_founder`
  ADD PRIMARY KEY (`founder_id`),
  ADD KEY `ap_id` (`ap_id`),
  ADD KEY `up_id` (`up_id`);

--
-- Indexes for table `university_hymn`
--
ALTER TABLE `university_hymn`
  ADD PRIMARY KEY (`hymn_id`),
  ADD KEY `ap_id` (`ap_id`);

--
-- Indexes for table `university_image`
--
ALTER TABLE `university_image`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `album_id` (`album_id`);

--
-- Indexes for table `university_image_archive`
--
ALTER TABLE `university_image_archive`
  ADD PRIMARY KEY (`archive_image_id`),
  ADD KEY `ap_id` (`ap_id`),
  ADD KEY `up_id` (`up_id`);

--
-- Indexes for table `university_message`
--
ALTER TABLE `university_message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `ap_id` (`ap_id`),
  ADD KEY `up_id` (`up_id`);

--
-- Indexes for table `university_partnership`
--
ALTER TABLE `university_partnership`
  ADD PRIMARY KEY (`up_id`),
  ADD KEY `ap_id` (`ap_id`);

--
-- Indexes for table `university_profile`
--
ALTER TABLE `university_profile`
  ADD PRIMARY KEY (`up_id`),
  ADD KEY `ap_id` (`ap_id`);

--
-- Indexes for table `university_scholarship`
--
ALTER TABLE `university_scholarship`
  ADD PRIMARY KEY (`scholarship_id`),
  ADD KEY `ap_id` (`ap_id`),
  ADD KEY `up_id` (`up_id`);

--
-- Indexes for table `university_video`
--
ALTER TABLE `university_video`
  ADD PRIMARY KEY (`video_id`),
  ADD KEY `university_video_ibfk_1` (`album_id`);

--
-- Indexes for table `university_vmgo`
--
ALTER TABLE `university_vmgo`
  ADD PRIMARY KEY (`vmgo_id`),
  ADD KEY `ap_id` (`ap_id`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admission_requirement`
--
ALTER TABLE `admission_requirement`
  MODIFY `requirement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `authorized_person`
--
ALTER TABLE `authorized_person`
  MODIFY `ap_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `board_of_director`
--
ALTER TABLE `board_of_director`
  MODIFY `director_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `computer_laboratory`
--
ALTER TABLE `computer_laboratory`
  MODIFY `lab_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `computer_laboratory_image`
--
ALTER TABLE `computer_laboratory_image`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `department_facilities`
--
ALTER TABLE `department_facilities`
  MODIFY `facility_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `faculty_member`
--
ALTER TABLE `faculty_member`
  MODIFY `fm_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `highlight`
--
ALTER TABLE `highlight`
  MODIFY `h_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `history_log`
--
ALTER TABLE `history_log`
  MODIFY `log_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3954;

--
-- AUTO_INCREMENT for table `job_opportunities`
--
ALTER TABLE `job_opportunities`
  MODIFY `job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_vacancy`
--
ALTER TABLE `job_vacancy`
  MODIFY `vacancy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `library_album`
--
ALTER TABLE `library_album`
  MODIFY `libalbum_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `library_archive`
--
ALTER TABLE `library_archive`
  MODIFY `libraryarchive_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `library_image`
--
ALTER TABLE `library_image`
  MODIFY `libimage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `library_resources`
--
ALTER TABLE `library_resources`
  MODIFY `resource_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `library_staff`
--
ALTER TABLE `library_staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `library_university`
--
ALTER TABLE `library_university`
  MODIFY `library_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `library_updates`
--
ALTER TABLE `library_updates`
  MODIFY `update_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `message_reply`
--
ALTER TABLE `message_reply`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `operating_hours`
--
ALTER TABLE `operating_hours`
  MODIFY `oh_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1142;

--
-- AUTO_INCREMENT for table `page_poster`
--
ALTER TABLE `page_poster`
  MODIFY `poster_id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `program_offering`
--
ALTER TABLE `program_offering`
  MODIFY `program_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `rector`
--
ALTER TABLE `rector`
  MODIFY `rector_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `research_project`
--
ALTER TABLE `research_project`
  MODIFY `research_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `settings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `universityprofile_image`
--
ALTER TABLE `universityprofile_image`
  MODIFY `upimage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `university_album`
--
ALTER TABLE `university_album`
  MODIFY `album_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `university_album_archive`
--
ALTER TABLE `university_album_archive`
  MODIFY `archive_album_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `university_archive`
--
ALTER TABLE `university_archive`
  MODIFY `archive_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `university_calendar`
--
ALTER TABLE `university_calendar`
  MODIFY `uc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `university_dean`
--
ALTER TABLE `university_dean`
  MODIFY `dean_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `university_form`
--
ALTER TABLE `university_form`
  MODIFY `form_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `university_founder`
--
ALTER TABLE `university_founder`
  MODIFY `founder_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `university_hymn`
--
ALTER TABLE `university_hymn`
  MODIFY `hymn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `university_image`
--
ALTER TABLE `university_image`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `university_image_archive`
--
ALTER TABLE `university_image_archive`
  MODIFY `archive_image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `university_message`
--
ALTER TABLE `university_message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `university_partnership`
--
ALTER TABLE `university_partnership`
  MODIFY `up_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `university_profile`
--
ALTER TABLE `university_profile`
  MODIFY `up_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `university_scholarship`
--
ALTER TABLE `university_scholarship`
  MODIFY `scholarship_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `university_video`
--
ALTER TABLE `university_video`
  MODIFY `video_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `university_vmgo`
--
ALTER TABLE `university_vmgo`
  MODIFY `vmgo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admission_requirement`
--
ALTER TABLE `admission_requirement`
  ADD CONSTRAINT `admission_requirement_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`),
  ADD CONSTRAINT `admission_requirement_ibfk_2` FOREIGN KEY (`up_id`) REFERENCES `university_profile` (`up_id`);

--
-- Constraints for table `announcement`
--
ALTER TABLE `announcement`
  ADD CONSTRAINT `announcement_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE;

--
-- Constraints for table `authorized_person`
--
ALTER TABLE `authorized_person`
  ADD CONSTRAINT `authorized_person_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `board_of_director`
--
ALTER TABLE `board_of_director`
  ADD CONSTRAINT `board_of_director_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE;

--
-- Constraints for table `computer_laboratory`
--
ALTER TABLE `computer_laboratory`
  ADD CONSTRAINT `computer_laboratory_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `computer_laboratory_ibfk_2` FOREIGN KEY (`up_id`) REFERENCES `university_profile` (`up_id`) ON DELETE CASCADE;

--
-- Constraints for table `computer_laboratory_image`
--
ALTER TABLE `computer_laboratory_image`
  ADD CONSTRAINT `computer_laboratory_image_ibfk_1` FOREIGN KEY (`lab_id`) REFERENCES `computer_laboratory` (`lab_id`) ON DELETE CASCADE;

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `department_ibfk_2` FOREIGN KEY (`up_id`) REFERENCES `university_profile` (`up_id`) ON DELETE CASCADE;

--
-- Constraints for table `department_facilities`
--
ALTER TABLE `department_facilities`
  ADD CONSTRAINT `department_facilities_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`) ON DELETE CASCADE;

--
-- Constraints for table `faculty_member`
--
ALTER TABLE `faculty_member`
  ADD CONSTRAINT `faculty_member_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);

--
-- Constraints for table `faq`
--
ALTER TABLE `faq`
  ADD CONSTRAINT `faq_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE;

--
-- Constraints for table `highlight`
--
ALTER TABLE `highlight`
  ADD CONSTRAINT `highlight_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE;

--
-- Constraints for table `history_log`
--
ALTER TABLE `history_log`
  ADD CONSTRAINT `history_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_account` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `job_opportunities`
--
ALTER TABLE `job_opportunities`
  ADD CONSTRAINT `job_opportunities_ibfk_1` FOREIGN KEY (`up_id`) REFERENCES `university_profile` (`up_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_opportunities_ibfk_2` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE;

--
-- Constraints for table `job_vacancy`
--
ALTER TABLE `job_vacancy`
  ADD CONSTRAINT `job_vacancy_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_vacancy_ibfk_2` FOREIGN KEY (`up_id`) REFERENCES `university_profile` (`up_id`) ON DELETE CASCADE;

--
-- Constraints for table `library_album`
--
ALTER TABLE `library_album`
  ADD CONSTRAINT `library_album_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `library_album_ibfk_2` FOREIGN KEY (`library_id`) REFERENCES `library_university` (`library_id`) ON DELETE CASCADE;

--
-- Constraints for table `library_archive`
--
ALTER TABLE `library_archive`
  ADD CONSTRAINT `library_archive_ibfk_1` FOREIGN KEY (`archived_by`) REFERENCES `authorized_person` (`ap_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `library_archive_ibfk_2` FOREIGN KEY (`library_id`) REFERENCES `library_university` (`library_id`) ON DELETE CASCADE;

--
-- Constraints for table `library_image`
--
ALTER TABLE `library_image`
  ADD CONSTRAINT `library_image_ibfk_1` FOREIGN KEY (`libalbum_id`) REFERENCES `library_album` (`libalbum_id`) ON DELETE CASCADE;

--
-- Constraints for table `library_resources`
--
ALTER TABLE `library_resources`
  ADD CONSTRAINT `library_resources_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `library_resources_ibfk_2` FOREIGN KEY (`library_id`) REFERENCES `library_university` (`library_id`) ON DELETE CASCADE;

--
-- Constraints for table `library_staff`
--
ALTER TABLE `library_staff`
  ADD CONSTRAINT `library_staff_ibfk_1` FOREIGN KEY (`library_id`) REFERENCES `library_university` (`library_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `library_staff_ibfk_2` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE;

--
-- Constraints for table `library_university`
--
ALTER TABLE `library_university`
  ADD CONSTRAINT `library_university_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `library_university_ibfk_2` FOREIGN KEY (`up_id`) REFERENCES `university_profile` (`up_id`) ON DELETE CASCADE;

--
-- Constraints for table `library_updates`
--
ALTER TABLE `library_updates`
  ADD CONSTRAINT `library_updates_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `library_updates_ibfk_2` FOREIGN KEY (`library_id`) REFERENCES `library_university` (`library_id`) ON DELETE CASCADE;

--
-- Constraints for table `message_reply`
--
ALTER TABLE `message_reply`
  ADD CONSTRAINT `message_reply_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `university_message` (`message_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `message_reply_ibfk_2` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE;

--
-- Constraints for table `operating_hours`
--
ALTER TABLE `operating_hours`
  ADD CONSTRAINT `operating_hours_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `operating_hours_ibfk_2` FOREIGN KEY (`library_id`) REFERENCES `library_university` (`library_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `page_poster`
--
ALTER TABLE `page_poster`
  ADD CONSTRAINT `page_poster_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE;

--
-- Constraints for table `program_offering`
--
ALTER TABLE `program_offering`
  ADD CONSTRAINT `program_offering_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);

--
-- Constraints for table `rector`
--
ALTER TABLE `rector`
  ADD CONSTRAINT `rector_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`);

--
-- Constraints for table `research_project`
--
ALTER TABLE `research_project`
  ADD CONSTRAINT `research_project_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `research_project_ibfk_2` FOREIGN KEY (`library_id`) REFERENCES `library_university` (`library_id`) ON DELETE CASCADE;

--
-- Constraints for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD CONSTRAINT `site_settings_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `site_settings_ibfk_2` FOREIGN KEY (`up_id`) REFERENCES `university_profile` (`up_id`) ON DELETE CASCADE;

--
-- Constraints for table `universityprofile_image`
--
ALTER TABLE `universityprofile_image`
  ADD CONSTRAINT `universityprofile_image_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `universityprofile_image_ibfk_2` FOREIGN KEY (`up_id`) REFERENCES `university_profile` (`up_id`) ON DELETE CASCADE;

--
-- Constraints for table `university_album`
--
ALTER TABLE `university_album`
  ADD CONSTRAINT `university_album_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `university_album_ibfk_2` FOREIGN KEY (`up_id`) REFERENCES `university_profile` (`up_id`) ON DELETE CASCADE;

--
-- Constraints for table `university_album_archive`
--
ALTER TABLE `university_album_archive`
  ADD CONSTRAINT `university_album_archive_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `university_album_archive_ibfk_2` FOREIGN KEY (`up_id`) REFERENCES `university_profile` (`up_id`) ON DELETE CASCADE;

--
-- Constraints for table `university_archive`
--
ALTER TABLE `university_archive`
  ADD CONSTRAINT `university_archive_ibfk_1` FOREIGN KEY (`archived_by`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `university_archive_ibfk_2` FOREIGN KEY (`up_id`) REFERENCES `university_profile` (`up_id`) ON DELETE CASCADE;

--
-- Constraints for table `university_calendar`
--
ALTER TABLE `university_calendar`
  ADD CONSTRAINT `fk_authorized_person` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `university_dean`
--
ALTER TABLE `university_dean`
  ADD CONSTRAINT `university_dean_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `university_dean_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`) ON DELETE CASCADE;

--
-- Constraints for table `university_form`
--
ALTER TABLE `university_form`
  ADD CONSTRAINT `university_form_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE;

--
-- Constraints for table `university_founder`
--
ALTER TABLE `university_founder`
  ADD CONSTRAINT `university_founder_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `university_founder_ibfk_2` FOREIGN KEY (`up_id`) REFERENCES `university_profile` (`up_id`) ON DELETE CASCADE;

--
-- Constraints for table `university_hymn`
--
ALTER TABLE `university_hymn`
  ADD CONSTRAINT `university_hymn_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE;

--
-- Constraints for table `university_image`
--
ALTER TABLE `university_image`
  ADD CONSTRAINT `university_image_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `university_album` (`album_id`) ON DELETE CASCADE;

--
-- Constraints for table `university_image_archive`
--
ALTER TABLE `university_image_archive`
  ADD CONSTRAINT `university_image_archive_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `university_image_archive_ibfk_2` FOREIGN KEY (`up_id`) REFERENCES `university_profile` (`up_id`) ON DELETE CASCADE;

--
-- Constraints for table `university_message`
--
ALTER TABLE `university_message`
  ADD CONSTRAINT `university_message_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `university_message_ibfk_2` FOREIGN KEY (`up_id`) REFERENCES `university_profile` (`up_id`) ON DELETE CASCADE;

--
-- Constraints for table `university_partnership`
--
ALTER TABLE `university_partnership`
  ADD CONSTRAINT `university_partnership_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE;

--
-- Constraints for table `university_profile`
--
ALTER TABLE `university_profile`
  ADD CONSTRAINT `university_profile_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE;

--
-- Constraints for table `university_scholarship`
--
ALTER TABLE `university_scholarship`
  ADD CONSTRAINT `university_scholarship_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `university_scholarship_ibfk_2` FOREIGN KEY (`up_id`) REFERENCES `university_profile` (`ap_id`) ON DELETE CASCADE;

--
-- Constraints for table `university_video`
--
ALTER TABLE `university_video`
  ADD CONSTRAINT `university_video_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `university_album` (`album_id`) ON DELETE CASCADE;

--
-- Constraints for table `university_vmgo`
--
ALTER TABLE `university_vmgo`
  ADD CONSTRAINT `university_vmgo_ibfk_1` FOREIGN KEY (`ap_id`) REFERENCES `authorized_person` (`ap_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
