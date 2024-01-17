-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2022 at 06:24 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance_tbl`
--

CREATE TABLE `attendance_tbl` (
  `attendance_id` int(2) NOT NULL,
  `attendance_name` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance_tbl`
--

INSERT INTO `attendance_tbl` (`attendance_id`, `attendance_name`) VALUES
(0, 'No'),
(1, 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `category_tbl`
--

CREATE TABLE `category_tbl` (
  `category_id` bigint(10) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_description` varchar(150) NOT NULL,
  `category_image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category_tbl`
--

INSERT INTO `category_tbl` (`category_id`, `category_name`, `category_description`, `category_image`) VALUES
(1, 'Public Healthcare', 'Our Organization holds events for health check up, blood donation, etc. as well as seminars to bring health awareness', '02-1.jpg'),
(2, 'Education of underprivileged children', 'Our Organization gives financial support, educational seminars to create awareness and to give guidance; We also provide educational materials.', '01-1.jpeg'),
(3, 'Environment protection', 'Our organization holds events for plantation in different areas and also holds seminars to bring more awareness', '03-1.jpg'),
(4, 'Joy of giving', 'Our organization holds events for Donations in different areas.', '02.jpg'),
(5, 'Administrative', 'Holds event for Administrative purpose', 'admin.png');

-- --------------------------------------------------------

--
-- Stand-in structure for view `donation amount wise`
-- (See below for the actual view)
--
CREATE TABLE `donation amount wise` (
`donation_id` bigint(10)
,`donation_date` date
,`donation_time` time
,`donation_amount` bigint(20)
,`donation_method` varchar(10)
,`user_name` varchar(60)
,`user_gender` varchar(10)
,`user_mobile` bigint(11)
,`donation_status` varchar(10)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `donation date wise`
-- (See below for the actual view)
--
CREATE TABLE `donation date wise` (
`donation_id` bigint(10)
,`donation_date` date
,`donation_time` time
,`donation_amount` bigint(20)
,`donation_method` varchar(10)
,`user_name` varchar(60)
,`user_gender` varchar(10)
,`user_mobile` bigint(11)
,`donation_status` varchar(10)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `donation gender wise`
-- (See below for the actual view)
--
CREATE TABLE `donation gender wise` (
`donation_id` bigint(10)
,`donation_date` date
,`donation_time` time
,`donation_amount` bigint(20)
,`donation_method` varchar(10)
,`user_name` varchar(60)
,`user_gender` varchar(10)
,`user_mobile` bigint(11)
,`donation_status` varchar(10)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `donation method wise`
-- (See below for the actual view)
--
CREATE TABLE `donation method wise` (
`donation_id` bigint(10)
,`donation_date` date
,`donation_time` time
,`donation_amount` bigint(20)
,`donation_method` varchar(10)
,`user_name` varchar(60)
,`user_gender` varchar(10)
,`user_mobile` bigint(11)
,`donation_status` varchar(10)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `donation user wise`
-- (See below for the actual view)
--
CREATE TABLE `donation user wise` (
`donation_id` bigint(10)
,`donation_date` date
,`donation_time` time
,`donation_amount` bigint(20)
,`donation_method` varchar(10)
,`user_name` varchar(60)
,`user_gender` varchar(10)
,`user_mobile` bigint(11)
,`donation_status` varchar(10)
);

-- --------------------------------------------------------

--
-- Table structure for table `donation_tbl`
--

CREATE TABLE `donation_tbl` (
  `donation_id` bigint(10) NOT NULL,
  `donation_date` date NOT NULL,
  `donation_time` time NOT NULL,
  `donation_amount` bigint(20) NOT NULL,
  `donation_method` varchar(10) NOT NULL,
  `user_id` bigint(10) NOT NULL,
  `donation_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Stand-in structure for view `event category wise`
-- (See below for the actual view)
--
CREATE TABLE `event category wise` (
`event_activity_num` bigint(10)
,`category_name` varchar(100)
,`event_title` varchar(60)
,`event_details` varchar(150)
,`event_date` date
,`event_time` time
,`event_location` varchar(250)
,`event_status` varchar(20)
,`Last Updated By` varchar(60)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `event date wise`
-- (See below for the actual view)
--
CREATE TABLE `event date wise` (
`event_activity_num` bigint(10)
,`category_name` varchar(100)
,`event_title` varchar(60)
,`event_details` varchar(150)
,`event_date` date
,`event_time` time
,`event_location` varchar(250)
,`event_status` varchar(20)
,`user_name` varchar(60)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `event registration event wise`
-- (See below for the actual view)
--
CREATE TABLE `event registration event wise` (
`registration_id` bigint(10)
,`registration_date` timestamp
,`user_name` varchar(60)
,`event_title` varchar(60)
,`event_date` date
,`event_location` varchar(250)
,`attendance_name` varchar(5)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `event registration present wise`
-- (See below for the actual view)
--
CREATE TABLE `event registration present wise` (
`registration_id` bigint(10)
,`registration_date` timestamp
,`user_name` varchar(60)
,`event_title` varchar(60)
,`event_date` date
,`event_location` varchar(250)
,`attendance_name` varchar(5)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `event registration user wise`
-- (See below for the actual view)
--
CREATE TABLE `event registration user wise` (
`registration_id` bigint(10)
,`registration_date` timestamp
,`user_name` varchar(60)
,`event_title` varchar(60)
,`event_date` date
,`event_location` varchar(250)
,`attendance_name` varchar(5)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `event status wise`
-- (See below for the actual view)
--
CREATE TABLE `event status wise` (
`category_name` varchar(100)
,`event_activity_num` bigint(10)
,`event_title` varchar(60)
,`event_details` varchar(150)
,`event_date` date
,`event_time` time
,`event_location` varchar(250)
,`event_status` varchar(20)
,`Last Updated By` varchar(60)
);

-- --------------------------------------------------------

--
-- Table structure for table `event_image_tbl`
--

CREATE TABLE `event_image_tbl` (
  `event_image_id` int(10) NOT NULL,
  `event_id` int(10) NOT NULL,
  `image_path` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `event_registration_tbl`
--

CREATE TABLE `event_registration_tbl` (
  `registration_id` bigint(10) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `event_id` bigint(10) NOT NULL,
  `user_id` bigint(10) NOT NULL,
  `is_present` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `event_tbl`
--

CREATE TABLE `event_tbl` (
  `event_id` bigint(10) NOT NULL,
  `event_activity_num` bigint(10) NOT NULL,
  `category_id` bigint(10) NOT NULL,
  `event_title` varchar(60) NOT NULL,
  `event_details` varchar(150) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `event_location` varchar(250) NOT NULL,
  `event_status` varchar(20) NOT NULL,
  `image_path` varchar(100) NOT NULL,
  `event_coordinates` varchar(100) NOT NULL,
  `event_chat_group_link` varchar(150) NOT NULL,
  `event_last_updated_by` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `faq_tbl`
--

CREATE TABLE `faq_tbl` (
  `faq_id` bigint(10) NOT NULL,
  `faq_question` varchar(100) NOT NULL,
  `faq_answer` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faq_tbl`
--

INSERT INTO `faq_tbl` (`faq_id`, `faq_question`, `faq_answer`) VALUES
(1, 'Will I get tax benefit which I made?', 'Yes. If you are citizen of India, then for your all donation you can avail 50% tax benefit under section 80G of Indian Income Tax Act 1961. Income Tax registration number is number AAQTS2945A/885/16-17/T-1206/12AA. For further details visit incometaxindia.gov.in'),
(2, 'How can I donate money to the trust?', 'You can make donations either in Cash or through Cheque, Demand Draft or wired transfer by net banking. We encourage non-cash transaction for better transparency and accountability. We do not accept donation in foreign currency or as remittance, donation should be in Indian rupees from Indian origin'),
(4, 'How can I donate money to the trust?', 'You can make donations either in Cash or through Cheque, Demand Draft or wired transfer by net banking. We encourage non-cash transaction for better transparency and accountability. We do not accept donation in foreign currency or as remittance, donation should be in Indian rupees from Indian origin'),
(5, 'Will I get receipt of my donation?', 'Yes. We will arrange to send you soft copy/hard copy of receipt for your donation through email. If you donate even one rupee, we will generate receipt of it.'),
(6, 'How much amount can I donate?', 'You can donate any amount in Indian currency.');

-- --------------------------------------------------------

--
-- Stand-in structure for view `feedback date wise`
-- (See below for the actual view)
--
CREATE TABLE `feedback date wise` (
`feedback_id` bigint(10)
,`feedback_date` date
,`feedback_time` time
,`feedback_description` varchar(150)
,`event_title` varchar(60)
,`event_date` date
,`event_location` varchar(250)
,`user_name` varchar(60)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `feedback event wise`
-- (See below for the actual view)
--
CREATE TABLE `feedback event wise` (
`feedback_id` bigint(10)
,`feedback_date` date
,`feedback_time` time
,`feedback_description` varchar(150)
,`event_title` varchar(60)
,`event_date` date
,`event_location` varchar(250)
,`user_name` varchar(60)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `feedback user wise`
-- (See below for the actual view)
--
CREATE TABLE `feedback user wise` (
`feedback_id` bigint(10)
,`feedback_date` date
,`feedback_time` time
,`feedback_description` varchar(150)
,`event_title` varchar(60)
,`event_date` date
,`event_location` varchar(250)
,`user_name` varchar(60)
);

-- --------------------------------------------------------

--
-- Table structure for table `feedback_tbl`
--

CREATE TABLE `feedback_tbl` (
  `feedback_id` bigint(10) NOT NULL,
  `feedback_date` date NOT NULL,
  `feedback_time` time NOT NULL,
  `feedback_description` varchar(150) NOT NULL,
  `event_id` bigint(10) NOT NULL,
  `user_id` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `location_tbl`
--

CREATE TABLE `location_tbl` (
  `location_id` int(10) NOT NULL,
  `location_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ngo_info_tbl`
--

CREATE TABLE `ngo_info_tbl` (
  `ngo_id` int(11) NOT NULL,
  `ngo_description` varchar(300) NOT NULL,
  `ngo_address` varchar(200) NOT NULL,
  `ngo_email` varchar(30) NOT NULL,
  `ngo_mobile1` varchar(15) NOT NULL,
  `ngo_mobile2` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ngo_info_tbl`
--

INSERT INTO `ngo_info_tbl` (`ngo_id`, `ngo_description`, `ngo_address`, `ngo_email`, `ngo_mobile1`, `ngo_mobile2`) VALUES
(1, 'Suryabala Seva Sansthan sponsors education of underprivileged children from poor families, promoting blood donation and spreading awareness of eye donation, encouraging citizens to contribute in environment protection through creating a green belt within the cities.', 'Ashram Road, Ahmedabad', 'suryabala.seva@gmail.com', '+91 96011 81236', '+91 96011 81246');

-- --------------------------------------------------------

--
-- Stand-in structure for view `team member role wise`
-- (See below for the actual view)
--
CREATE TABLE `team member role wise` (
`member_id` bigint(10)
,`member_name` varchar(30)
,`member_role` varchar(20)
);

-- --------------------------------------------------------

--
-- Table structure for table `team_member_tbl`
--

CREATE TABLE `team_member_tbl` (
  `member_id` bigint(10) NOT NULL,
  `member_name` varchar(30) NOT NULL,
  `member_role` varchar(20) NOT NULL,
  `member_image` varchar(200) NOT NULL,
  `member_link` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team_member_tbl`
--

INSERT INTO `team_member_tbl` (`member_id`, `member_name`, `member_role`, `member_image`, `member_link`) VALUES
(1, 'Nirav Chokshi', 'Founder', '2.jpg', ''),
(2, 'Rupal Chokshi', 'Trustee', '1.png', ''),
(3, 'Vijay Satapara', 'Trustee', '09.jpg', ''),
(4, 'Shrenik Shah', 'Trustee', '1.png', '');

-- --------------------------------------------------------

--
-- Stand-in structure for view `user blood group wise`
-- (See below for the actual view)
--
CREATE TABLE `user blood group wise` (
`user_id` bigint(10)
,`type_name` varchar(15)
,`user_name` varchar(60)
,`user_gender` varchar(10)
,`user_dob` date
,`user_email` varchar(50)
,`user_mobile` bigint(11)
,`user_country_code` varchar(5)
,`user_blood_group` varchar(4)
,`user_health_issue` varchar(150)
,`user_location` varchar(200)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `user gender wise`
-- (See below for the actual view)
--
CREATE TABLE `user gender wise` (
`user_id` bigint(10)
,`type_name` varchar(15)
,`user_name` varchar(60)
,`user_gender` varchar(10)
,`user_dob` date
,`user_email` varchar(50)
,`user_mobile` bigint(11)
,`user_country_code` varchar(5)
,`user_blood_group` varchar(4)
,`user_health_issue` varchar(150)
,`user_location` varchar(200)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `user preferred category wise`
-- (See below for the actual view)
--
CREATE TABLE `user preferred category wise` (
`user_id` bigint(10)
,`type_name` varchar(15)
,`user_name` varchar(60)
,`user_gender` varchar(10)
,`user_dob` date
,`user_email` varchar(50)
,`user_mobile` bigint(11)
,`user_country_code` varchar(5)
,`user_blood_group` varchar(4)
,`user_health_issue` varchar(150)
,`user_location` varchar(200)
,`category_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `user type wise`
-- (See below for the actual view)
--
CREATE TABLE `user type wise` (
`user_id` bigint(10)
,`type_name` varchar(15)
,`user_image` varchar(300)
,`user_gender` varchar(10)
,`user_dob` date
,`user_email` varchar(50)
,`user_mobile` bigint(11)
,`user_country_code` varchar(5)
,`user_blood_group` varchar(4)
,`user_health_issue` varchar(150)
,`user_location` varchar(200)
);

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

CREATE TABLE `user_master` (
  `user_id` bigint(10) NOT NULL,
  `type_id` varchar(20) NOT NULL,
  `user_image` varchar(300) NOT NULL,
  `user_name` varchar(60) NOT NULL,
  `user_gender` varchar(10) NOT NULL,
  `user_dob` date NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(30) NOT NULL,
  `user_mobile` bigint(11) NOT NULL,
  `user_country_code` varchar(5) NOT NULL,
  `user_blood_group` varchar(4) NOT NULL,
  `user_health_issue` varchar(150) NOT NULL,
  `user_last_date_donation` date NOT NULL,
  `user_location` varchar(200) NOT NULL,
  `user_prefered_category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `type_id` bigint(10) NOT NULL,
  `type_name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`type_id`, `type_name`) VALUES
(1, 'Administrator'),
(2, 'Contributor');

-- --------------------------------------------------------

--
-- Stand-in structure for view `volunteer event wise`
-- (See below for the actual view)
--
CREATE TABLE `volunteer event wise` (
`volunteer_id` bigint(10)
,`user_name` varchar(60)
,`user_gender` varchar(10)
,`user_email` varchar(50)
,`user_mobile` bigint(11)
,`user_country_code` varchar(5)
,`user_blood_group` varchar(4)
,`event_activity_num` bigint(10)
,`event_title` varchar(60)
,`event_date` date
,`event_time` time
,`event_location` varchar(250)
,`category_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_tbl`
--

CREATE TABLE `volunteer_tbl` (
  `volunteer_id` bigint(10) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` bigint(10) NOT NULL,
  `event_id` bigint(10) NOT NULL,
  `is_present` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure for view `donation amount wise`
--
DROP TABLE IF EXISTS `donation amount wise`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `donation amount wise`  AS SELECT `donation_tbl`.`donation_id` AS `donation_id`, `donation_tbl`.`donation_date` AS `donation_date`, `donation_tbl`.`donation_time` AS `donation_time`, `donation_tbl`.`donation_amount` AS `donation_amount`, `donation_tbl`.`donation_method` AS `donation_method`, `user_master`.`user_name` AS `user_name`, `user_master`.`user_gender` AS `user_gender`, `user_master`.`user_mobile` AS `user_mobile`, `donation_tbl`.`donation_status` AS `donation_status` FROM (`donation_tbl` join `user_master` on(`donation_tbl`.`user_id` = `user_master`.`user_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `donation date wise`
--
DROP TABLE IF EXISTS `donation date wise`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `donation date wise`  AS SELECT `donation_tbl`.`donation_id` AS `donation_id`, `donation_tbl`.`donation_date` AS `donation_date`, `donation_tbl`.`donation_time` AS `donation_time`, `donation_tbl`.`donation_amount` AS `donation_amount`, `donation_tbl`.`donation_method` AS `donation_method`, `user_master`.`user_name` AS `user_name`, `user_master`.`user_gender` AS `user_gender`, `user_master`.`user_mobile` AS `user_mobile`, `donation_tbl`.`donation_status` AS `donation_status` FROM (`donation_tbl` join `user_master` on(`donation_tbl`.`user_id` = `user_master`.`user_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `donation gender wise`
--
DROP TABLE IF EXISTS `donation gender wise`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `donation gender wise`  AS SELECT `donation_tbl`.`donation_id` AS `donation_id`, `donation_tbl`.`donation_date` AS `donation_date`, `donation_tbl`.`donation_time` AS `donation_time`, `donation_tbl`.`donation_amount` AS `donation_amount`, `donation_tbl`.`donation_method` AS `donation_method`, `user_master`.`user_name` AS `user_name`, `user_master`.`user_gender` AS `user_gender`, `user_master`.`user_mobile` AS `user_mobile`, `donation_tbl`.`donation_status` AS `donation_status` FROM (`donation_tbl` join `user_master` on(`donation_tbl`.`user_id` = `user_master`.`user_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `donation method wise`
--
DROP TABLE IF EXISTS `donation method wise`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `donation method wise`  AS SELECT `donation_tbl`.`donation_id` AS `donation_id`, `donation_tbl`.`donation_date` AS `donation_date`, `donation_tbl`.`donation_time` AS `donation_time`, `donation_tbl`.`donation_amount` AS `donation_amount`, `donation_tbl`.`donation_method` AS `donation_method`, `user_master`.`user_name` AS `user_name`, `user_master`.`user_gender` AS `user_gender`, `user_master`.`user_mobile` AS `user_mobile`, `donation_tbl`.`donation_status` AS `donation_status` FROM (`donation_tbl` join `user_master` on(`donation_tbl`.`user_id` = `user_master`.`user_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `donation user wise`
--
DROP TABLE IF EXISTS `donation user wise`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `donation user wise`  AS SELECT `donation_tbl`.`donation_id` AS `donation_id`, `donation_tbl`.`donation_date` AS `donation_date`, `donation_tbl`.`donation_time` AS `donation_time`, `donation_tbl`.`donation_amount` AS `donation_amount`, `donation_tbl`.`donation_method` AS `donation_method`, `user_master`.`user_name` AS `user_name`, `user_master`.`user_gender` AS `user_gender`, `user_master`.`user_mobile` AS `user_mobile`, `donation_tbl`.`donation_status` AS `donation_status` FROM (`donation_tbl` join `user_master` on(`user_master`.`user_id` = `donation_tbl`.`user_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `event category wise`
--
DROP TABLE IF EXISTS `event category wise`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `event category wise`  AS SELECT `event_tbl`.`event_activity_num` AS `event_activity_num`, `category_tbl`.`category_name` AS `category_name`, `event_tbl`.`event_title` AS `event_title`, `event_tbl`.`event_details` AS `event_details`, `event_tbl`.`event_date` AS `event_date`, `event_tbl`.`event_time` AS `event_time`, `event_tbl`.`event_location` AS `event_location`, `event_tbl`.`event_status` AS `event_status`, `user_master`.`user_name` AS `Last Updated By` FROM ((`category_tbl` join `event_tbl` on(`category_tbl`.`category_id` = `event_tbl`.`category_id`)) join `user_master` on(`event_tbl`.`event_last_updated_by` = `user_master`.`user_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `event date wise`
--
DROP TABLE IF EXISTS `event date wise`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `event date wise`  AS SELECT `event_tbl`.`event_activity_num` AS `event_activity_num`, `category_tbl`.`category_name` AS `category_name`, `event_tbl`.`event_title` AS `event_title`, `event_tbl`.`event_details` AS `event_details`, `event_tbl`.`event_date` AS `event_date`, `event_tbl`.`event_time` AS `event_time`, `event_tbl`.`event_location` AS `event_location`, `event_tbl`.`event_status` AS `event_status`, `user_master`.`user_name` AS `user_name` FROM ((`event_tbl` join `category_tbl` on(`category_tbl`.`category_id` = `event_tbl`.`category_id`)) join `user_master` on(`event_tbl`.`event_last_updated_by` = `user_master`.`user_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `event registration event wise`
--
DROP TABLE IF EXISTS `event registration event wise`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `event registration event wise`  AS SELECT `event_registration_tbl`.`registration_id` AS `registration_id`, `event_registration_tbl`.`registration_date` AS `registration_date`, `user_master`.`user_name` AS `user_name`, `event_tbl`.`event_title` AS `event_title`, `event_tbl`.`event_date` AS `event_date`, `event_tbl`.`event_location` AS `event_location`, `attendance_tbl`.`attendance_name` AS `attendance_name` FROM (((`event_registration_tbl` join `event_tbl` on(`event_tbl`.`event_id` = `event_registration_tbl`.`event_id`)) join `user_master` on(`user_master`.`user_id` = `event_registration_tbl`.`user_id`)) join `attendance_tbl` on(`event_registration_tbl`.`is_present` = `attendance_tbl`.`attendance_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `event registration present wise`
--
DROP TABLE IF EXISTS `event registration present wise`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `event registration present wise`  AS SELECT `event_registration_tbl`.`registration_id` AS `registration_id`, `event_registration_tbl`.`registration_date` AS `registration_date`, `user_master`.`user_name` AS `user_name`, `event_tbl`.`event_title` AS `event_title`, `event_tbl`.`event_date` AS `event_date`, `event_tbl`.`event_location` AS `event_location`, `attendance_tbl`.`attendance_name` AS `attendance_name` FROM (((`event_registration_tbl` join `event_tbl` on(`event_tbl`.`event_id` = `event_registration_tbl`.`event_id`)) join `user_master` on(`user_master`.`user_id` = `event_registration_tbl`.`user_id`)) join `attendance_tbl` on(`event_registration_tbl`.`is_present` = `attendance_tbl`.`attendance_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `event registration user wise`
--
DROP TABLE IF EXISTS `event registration user wise`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `event registration user wise`  AS SELECT `event_registration_tbl`.`registration_id` AS `registration_id`, `event_registration_tbl`.`registration_date` AS `registration_date`, `user_master`.`user_name` AS `user_name`, `event_tbl`.`event_title` AS `event_title`, `event_tbl`.`event_date` AS `event_date`, `event_tbl`.`event_location` AS `event_location`, `attendance_tbl`.`attendance_name` AS `attendance_name` FROM (((`event_registration_tbl` join `event_tbl` on(`event_tbl`.`event_id` = `event_registration_tbl`.`event_id`)) join `user_master` on(`user_master`.`user_id` = `event_registration_tbl`.`user_id`)) join `attendance_tbl` on(`event_registration_tbl`.`is_present` = `attendance_tbl`.`attendance_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `event status wise`
--
DROP TABLE IF EXISTS `event status wise`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `event status wise`  AS SELECT `category_tbl`.`category_name` AS `category_name`, `event_tbl`.`event_activity_num` AS `event_activity_num`, `event_tbl`.`event_title` AS `event_title`, `event_tbl`.`event_details` AS `event_details`, `event_tbl`.`event_date` AS `event_date`, `event_tbl`.`event_time` AS `event_time`, `event_tbl`.`event_location` AS `event_location`, `event_tbl`.`event_status` AS `event_status`, `user_master`.`user_name` AS `Last Updated By` FROM ((`event_tbl` join `category_tbl` on(`category_tbl`.`category_id` = `event_tbl`.`category_id`)) join `user_master` on(`event_tbl`.`event_last_updated_by` = `user_master`.`user_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `feedback date wise`
--
DROP TABLE IF EXISTS `feedback date wise`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `feedback date wise`  AS SELECT `feedback_tbl`.`feedback_id` AS `feedback_id`, `feedback_tbl`.`feedback_date` AS `feedback_date`, `feedback_tbl`.`feedback_time` AS `feedback_time`, `feedback_tbl`.`feedback_description` AS `feedback_description`, `event_tbl`.`event_title` AS `event_title`, `event_tbl`.`event_date` AS `event_date`, `event_tbl`.`event_location` AS `event_location`, `user_master`.`user_name` AS `user_name` FROM ((`feedback_tbl` join `event_tbl` on(`feedback_tbl`.`event_id` = `event_tbl`.`event_id`)) join `user_master` on(`feedback_tbl`.`user_id` = `user_master`.`user_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `feedback event wise`
--
DROP TABLE IF EXISTS `feedback event wise`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `feedback event wise`  AS SELECT `feedback_tbl`.`feedback_id` AS `feedback_id`, `feedback_tbl`.`feedback_date` AS `feedback_date`, `feedback_tbl`.`feedback_time` AS `feedback_time`, `feedback_tbl`.`feedback_description` AS `feedback_description`, `event_tbl`.`event_title` AS `event_title`, `event_tbl`.`event_date` AS `event_date`, `event_tbl`.`event_location` AS `event_location`, `user_master`.`user_name` AS `user_name` FROM ((`event_tbl` join `feedback_tbl` on(`event_tbl`.`event_id` = `feedback_tbl`.`event_id`)) join `user_master` on(`user_master`.`user_id` = `feedback_tbl`.`user_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `feedback user wise`
--
DROP TABLE IF EXISTS `feedback user wise`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `feedback user wise`  AS SELECT `feedback_tbl`.`feedback_id` AS `feedback_id`, `feedback_tbl`.`feedback_date` AS `feedback_date`, `feedback_tbl`.`feedback_time` AS `feedback_time`, `feedback_tbl`.`feedback_description` AS `feedback_description`, `event_tbl`.`event_title` AS `event_title`, `event_tbl`.`event_date` AS `event_date`, `event_tbl`.`event_location` AS `event_location`, `user_master`.`user_name` AS `user_name` FROM ((`feedback_tbl` join `event_tbl` on(`feedback_tbl`.`event_id` = `event_tbl`.`event_id`)) join `user_master` on(`feedback_tbl`.`user_id` = `user_master`.`user_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `team member role wise`
--
DROP TABLE IF EXISTS `team member role wise`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `team member role wise`  AS SELECT `team_member_tbl`.`member_id` AS `member_id`, `team_member_tbl`.`member_name` AS `member_name`, `team_member_tbl`.`member_role` AS `member_role` FROM `team_member_tbl` ;

-- --------------------------------------------------------

--
-- Structure for view `user blood group wise`
--
DROP TABLE IF EXISTS `user blood group wise`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user blood group wise`  AS SELECT `user_master`.`user_id` AS `user_id`, `user_type`.`type_name` AS `type_name`, `user_master`.`user_name` AS `user_name`, `user_master`.`user_gender` AS `user_gender`, `user_master`.`user_dob` AS `user_dob`, `user_master`.`user_email` AS `user_email`, `user_master`.`user_mobile` AS `user_mobile`, `user_master`.`user_country_code` AS `user_country_code`, `user_master`.`user_blood_group` AS `user_blood_group`, `user_master`.`user_health_issue` AS `user_health_issue`, `user_master`.`user_location` AS `user_location` FROM (`user_master` join `user_type` on(`user_master`.`type_id` = `user_type`.`type_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `user gender wise`
--
DROP TABLE IF EXISTS `user gender wise`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user gender wise`  AS SELECT `user_master`.`user_id` AS `user_id`, `user_type`.`type_name` AS `type_name`, `user_master`.`user_name` AS `user_name`, `user_master`.`user_gender` AS `user_gender`, `user_master`.`user_dob` AS `user_dob`, `user_master`.`user_email` AS `user_email`, `user_master`.`user_mobile` AS `user_mobile`, `user_master`.`user_country_code` AS `user_country_code`, `user_master`.`user_blood_group` AS `user_blood_group`, `user_master`.`user_health_issue` AS `user_health_issue`, `user_master`.`user_location` AS `user_location` FROM (`user_master` join `user_type` on(`user_master`.`type_id` = `user_type`.`type_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `user preferred category wise`
--
DROP TABLE IF EXISTS `user preferred category wise`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user preferred category wise`  AS SELECT `user_master`.`user_id` AS `user_id`, `user_type`.`type_name` AS `type_name`, `user_master`.`user_name` AS `user_name`, `user_master`.`user_gender` AS `user_gender`, `user_master`.`user_dob` AS `user_dob`, `user_master`.`user_email` AS `user_email`, `user_master`.`user_mobile` AS `user_mobile`, `user_master`.`user_country_code` AS `user_country_code`, `user_master`.`user_blood_group` AS `user_blood_group`, `user_master`.`user_health_issue` AS `user_health_issue`, `user_master`.`user_location` AS `user_location`, `category_tbl`.`category_name` AS `category_name` FROM ((`user_master` join `user_type` on(`user_master`.`type_id` = `user_type`.`type_id`)) join `category_tbl` on(`user_master`.`user_prefered_category` = `category_tbl`.`category_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `user type wise`
--
DROP TABLE IF EXISTS `user type wise`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user type wise`  AS SELECT `user_master`.`user_id` AS `user_id`, `user_type`.`type_name` AS `type_name`, `user_master`.`user_image` AS `user_image`, `user_master`.`user_gender` AS `user_gender`, `user_master`.`user_dob` AS `user_dob`, `user_master`.`user_email` AS `user_email`, `user_master`.`user_mobile` AS `user_mobile`, `user_master`.`user_country_code` AS `user_country_code`, `user_master`.`user_blood_group` AS `user_blood_group`, `user_master`.`user_health_issue` AS `user_health_issue`, `user_master`.`user_location` AS `user_location` FROM (`user_master` join `user_type` on(`user_master`.`type_id` = `user_type`.`type_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `volunteer event wise`
--
DROP TABLE IF EXISTS `volunteer event wise`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `volunteer event wise`  AS SELECT `volunteer_tbl`.`volunteer_id` AS `volunteer_id`, `user_master`.`user_name` AS `user_name`, `user_master`.`user_gender` AS `user_gender`, `user_master`.`user_email` AS `user_email`, `user_master`.`user_mobile` AS `user_mobile`, `user_master`.`user_country_code` AS `user_country_code`, `user_master`.`user_blood_group` AS `user_blood_group`, `event_tbl`.`event_activity_num` AS `event_activity_num`, `event_tbl`.`event_title` AS `event_title`, `event_tbl`.`event_date` AS `event_date`, `event_tbl`.`event_time` AS `event_time`, `event_tbl`.`event_location` AS `event_location`, `category_tbl`.`category_name` AS `category_name` FROM (((`volunteer_tbl` join `user_master` on(`volunteer_tbl`.`user_id` = `user_master`.`user_id`)) join `event_tbl` on(`volunteer_tbl`.`event_id` = `event_tbl`.`event_id`)) join `category_tbl` on(`event_tbl`.`category_id` = `category_tbl`.`category_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance_tbl`
--
ALTER TABLE `attendance_tbl`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `category_tbl`
--
ALTER TABLE `category_tbl`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `donation_tbl`
--
ALTER TABLE `donation_tbl`
  ADD PRIMARY KEY (`donation_id`);

--
-- Indexes for table `event_image_tbl`
--
ALTER TABLE `event_image_tbl`
  ADD PRIMARY KEY (`event_image_id`);

--
-- Indexes for table `event_registration_tbl`
--
ALTER TABLE `event_registration_tbl`
  ADD PRIMARY KEY (`registration_id`);

--
-- Indexes for table `event_tbl`
--
ALTER TABLE `event_tbl`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `faq_tbl`
--
ALTER TABLE `faq_tbl`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `feedback_tbl`
--
ALTER TABLE `feedback_tbl`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `location_tbl`
--
ALTER TABLE `location_tbl`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `ngo_info_tbl`
--
ALTER TABLE `ngo_info_tbl`
  ADD PRIMARY KEY (`ngo_id`);

--
-- Indexes for table `team_member_tbl`
--
ALTER TABLE `team_member_tbl`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `user_master`
--
ALTER TABLE `user_master`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_mobile` (`user_mobile`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `volunteer_tbl`
--
ALTER TABLE `volunteer_tbl`
  ADD PRIMARY KEY (`volunteer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category_tbl`
--
ALTER TABLE `category_tbl`
  MODIFY `category_id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `donation_tbl`
--
ALTER TABLE `donation_tbl`
  MODIFY `donation_id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_image_tbl`
--
ALTER TABLE `event_image_tbl`
  MODIFY `event_image_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_registration_tbl`
--
ALTER TABLE `event_registration_tbl`
  MODIFY `registration_id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_tbl`
--
ALTER TABLE `event_tbl`
  MODIFY `event_id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq_tbl`
--
ALTER TABLE `faq_tbl`
  MODIFY `faq_id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `feedback_tbl`
--
ALTER TABLE `feedback_tbl`
  MODIFY `feedback_id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `location_tbl`
--
ALTER TABLE `location_tbl`
  MODIFY `location_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ngo_info_tbl`
--
ALTER TABLE `ngo_info_tbl`
  MODIFY `ngo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team_member_tbl`
--
ALTER TABLE `team_member_tbl`
  MODIFY `member_id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_master`
--
ALTER TABLE `user_master`
  MODIFY `user_id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `type_id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `volunteer_tbl`
--
ALTER TABLE `volunteer_tbl`
  MODIFY `volunteer_id` bigint(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
