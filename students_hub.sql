-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 16, 2022 at 11:30 AM
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
-- Database: `students hub`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `Comment_id` int(11) NOT NULL,
  `Post_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  `Comments` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`Comment_id`, `Post_id`, `User_id`, `Comments`) VALUES
(178, 99, 36, 'Nice bro!'),
(179, 99, 31, 'Thank you shubham 🤗'),
(180, 99, 42, 'Vera level💥💥'),
(182, 99, 31, '🙌💥'),
(185, 99, 31, 'dflk;f'),
(188, 99, 45, 'class topper nu nirubikkadha da🤣'),
(189, 104, 45, '💕💖💖💖memorable day '),
(191, 109, 31, '🤣🤣🤣🤣🤣'),
(193, 109, 45, '😉😉'),
(194, 104, 31, 'Yes😍✨'),
(195, 99, 31, '🤣🤣🤣'),
(196, 115, 31, 'And also with the edit and delete comment options'),
(197, 120, 42, '🤣🤣🤣🤣'),
(198, 115, 42, 'Bring it on soon'),
(199, 118, 42, 'Coimbatore theriyuma manda bathram 😂'),
(200, 122, 31, 'Epdi bro ungaluku mattum ivalo kaasu irruku'),
(201, 123, 31, '🛐😈💥');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `ID` int(11) NOT NULL,
  `Full_name` varchar(500) NOT NULL,
  `Email_id` varchar(500) NOT NULL,
  `Feedback` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `job_details`
--

CREATE TABLE `job_details` (
  `Job_id` int(11) NOT NULL,
  `Company_name` varchar(500) NOT NULL,
  `Role` varchar(1000) NOT NULL,
  `Work_location` varchar(100) DEFAULT NULL,
  `Salary` varchar(100) DEFAULT NULL,
  `Department` varchar(500) NOT NULL,
  `Bondage` varchar(50) DEFAULT NULL,
  `Backlogs` varchar(50) DEFAULT NULL,
  `His_of_backlog` varchar(50) DEFAULT NULL,
  `Percentage` varchar(50) DEFAULT NULL,
  `Last_date` varchar(100) DEFAULT NULL,
  `Apply_link` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job_details`
--

INSERT INTO `job_details` (`Job_id`, `Company_name`, `Role`, `Work_location`, `Salary`, `Department`, `Bondage`, `Backlogs`, `His_of_backlog`, `Percentage`, `Last_date`, `Apply_link`) VALUES
(1, 'Fanisko', 'Sports Graduate interns/Freshers', 'Chennai', '2.0', 'All UG', 'Yes', 'Yes', 'Yes', 'None', '2022-05-18', 'https://fanisko.com/'),
(3, 'Guide House', 'Associate AR Caller', 'Chennai', '2.9', 'All', 'No', 'Yes', 'Yes', 'None', '2022-05-15', 'https://www.guidehouse.com'),
(4, 'Zoho Corp', 'Software Developer', 'Chennai', '5-6', 'BCA,MCA', 'No', 'Yes', 'Yes', 'None', '2022-05-19', 'https://www.zoho.com'),
(5, 'Start Up', 'Software Developer-Intern', 'Chennai', '5-6', 'BCA', 'Yes', 'No', 'No', '80', '2022-05-17', 'https://www.startup.com'),
(6, 'Altruist Technologies Pvt Ltd', 'Business Associate', 'Chennai', '2.0-2.5', 'All', 'No', 'Yes', 'Yes', 'None', '2022-05-16', 'https://www.altruist.com'),
(7, 'Paperflite', 'Customer Success Role', 'Chennai', '3.0', 'All UG', 'No', 'Yes', 'Yes', 'None', '2022-05-16', 'https://www.paperflite.com'),
(8, 'Almoayyed International Group', 'Commercial Executive', 'Not mentioned', '4.5', 'All PG,B.com,BBA', 'No', 'Yes', 'Yes', '80', '2022-05-19', 'https://www.almoayyed.com'),
(9, 'Mys technologies', 'Web Developer', 'Chennai', '4.5', 'BCA,MCA', 'Yes', 'No', 'Yes', 'None', '2022-05-20', 'https://www.mystech.com'),
(10, 'Kaar Technologies', 'Associate Analyst', 'Chennai', '3.0', 'All UG', 'Yes', 'No', 'No', '80', '2022-05-17', 'https://www.kaar.com'),
(11, 'SureIT', 'Assciate-Intern', 'Chennai', '2.9', 'All', 'No', 'Yes', 'Yes', 'None', '2022-06-01', 'https://www.sureit.com'),
(13, 'Telusko', 'Web Developer', 'Chennai', '5-6', 'BCA,MCA', 'Yes', 'No', 'Yes', 'None', '2022-05-25', 'https://www.telusko.com'),
(16, 'Deloitte USI', 'Associate Analyst', 'Hyderabad,Bangalore', '3.82', 'BCA', 'No', 'No', 'Yes', '70', '2022-05-25', 'https://www.deloitte.com'),
(17, 'Google', 'SDE', 'Hyderabad,Bangalore', '15', 'BCA,MCA', 'No', 'No', 'No', '80', '2022-05-28', 'https://www.google.com'),
(18, 'Microsoft', 'Intern Web Developer having good knowledge in Asp.net framework', 'Bangalore', '7', 'BCA', 'No', 'No', 'Yes', '70', '2022-06-12', 'https://www.microsoftjobs.com'),
(19, 'Sain Gobain', 'Product manager', 'Chennai', '2.9', 'All UG', 'No', 'No', 'Yes', '60', '2022-06-07', 'https://www.saintgobain.com'),
(20, 'Amazon', 'SDE', 'Hyderabad', '12', 'BCA,MCA', 'No', 'No', 'Yes', '70', '2022-07-01', 'https://www.amazonjobs.com'),
(21, 'Google', 'Sde', 'Chennai', '50', 'BCA', 'No', 'No', 'No', '80', '2022-08-04', 'https://www.guidehouse.com');

-- --------------------------------------------------------

--
-- Table structure for table `placement_details`
--

CREATE TABLE `placement_details` (
  `ID` int(11) NOT NULL,
  `Full_name` varchar(500) NOT NULL,
  `Email_id` varchar(500) NOT NULL,
  `Year` varchar(500) NOT NULL,
  `Department` varchar(500) NOT NULL,
  `Class` varchar(500) NOT NULL,
  `Bio` varchar(500) NOT NULL,
  `10th_percentage` varchar(10) NOT NULL,
  `12th_percentage` varchar(10) NOT NULL,
  `Sem_percentage` varchar(10) NOT NULL,
  `Sem_CGPA` varchar(10) NOT NULL,
  `Backlogs` varchar(10) NOT NULL,
  `No_of_backlogs` varchar(10) NOT NULL,
  `History_of_backlogs` varchar(10) NOT NULL,
  `Skills` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `placement_details`
--

INSERT INTO `placement_details` (`ID`, `Full_name`, `Email_id`, `Year`, `Department`, `Class`, `Bio`, `10th_percentage`, `12th_percentage`, `Sem_percentage`, `Sem_CGPA`, `Backlogs`, `No_of_backlogs`, `History_of_backlogs`, `Skills`) VALUES
(31, 'SharathM', '1901721033044@mcc.edu.in', 'III', 'BCA', 'A', 'Life has per thoughts💪🏻', '95', '90.25', '85', '8.5', 'No', 'None', 'No', 'Full Stack Web Developer\r\nInterested in web technologies'),
(36, 'Shubham Mishra', '1901721033045@mcc.edu.in', 'III', 'BCA', 'A', 'No one is perfect😎', '98', '95', '90', '9.0', 'No', '1', 'Yes', 'Python Developer'),
(39, 'DivyaB', 'divya@mcc.edu.in', 'III', 'B.Sc Mathemetics', 'A', 'Don\'t live for others❤', '95', '90', '90', '9.0', 'No', 'None', 'No', 'Love to do algebra sums'),
(42, 'ImronKhan', 'imron@mcc.edu.in', 'II', 'MCA', 'A', 'Only god can judge me!🤫', '90', '95', '90', '9.0', 'No', 'None', 'No', 'SAP developer\r\nInterseted in Web Technologies'),
(45, 'VeroJeni', '1901721033004@mcc.edu.in', 'III', 'BCA', 'A', '💚😇live love mcc😇💚', '98', '80', '98', '9.8', 'No', 'none', 'No', 'Art and crafts');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `Post_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  `Post_file` varchar(100) DEFAULT NULL,
  `Caption` mediumtext DEFAULT NULL,
  `Post_access` varchar(100) NOT NULL,
  `Datetime` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`Post_id`, `User_id`, `Post_file`, `Caption`, `Post_access`, `Datetime`) VALUES
(99, 31, '3136919504.jpg', 'Hello everyone. I am Sharath, creator of Students Hub.\r\nI am gladly invite you all to enjoy and use our platform and make our platform sucess.\r\nThank you all!😄', 'Public', 'May 18,2022, 11:35 pm'),
(104, 31, '28731270.jpg', 'Sometimes all about is to put a smile on your face!😃\r\n#candid', 'Class', 'May 22,2022, 11:19 pm'),
(109, 45, NULL, 'ipdi oru dept la padika ....rommba perumaiya iruku😌 ', 'Department', 'May 26,2022, 03:10 pm'),
(115, 31, NULL, 'Working on a update of Students Hub with like and react systems on post and also with save post so that users can view their most liked posts.\r\nComing soon...😄', 'Public', 'May 30,2022, 11:08 pm'),
(118, 31, '15192370.jpg', 'MCC💚', 'Public', 'May 31,2022, 09:56 pm'),
(120, 31, '30571449.jpg', 'Sun kissed😝', 'Public', 'May 31,2022, 09:58 pm'),
(121, 31, '28486107.jpg', NULL, 'Public', 'May 31,2022, 09:59 pm'),
(122, 42, '39566299.jpg', 'Himachal Diaries 🤞❄', 'Public', 'May 31,2022, 11:52 pm'),
(123, 42, '21574407.jpg', 'Rolex😤👿🔥', 'Public', 'June 5,2022, 10:09 pm'),
(124, 42, NULL, 'hello', 'department', 'June 5,2022, 10:18 pm'),
(125, 31, '67800458.jpg', 'Solitude is bless✨❤', 'Public', 'June 7,2022, 08:46 pm'),
(127, 31, '3183084991.jpg', '', 'Public', 'June 12,2022, 10:54 am'),
(129, 31, '97914955.jpg', 'My desktop wallpaper😇', 'Public', 'June 12,2022, 10:56 am'),
(130, 31, NULL, 'Okay, Its time for end semester examination, i am literally thrilled on how i could tackle those four examinations.\r\nAfter that i will be free to conquer my steps for my dreams.\r\nTill,then...Meet u soon...👋', 'Public', 'June 12,2022, 11:00 am'),
(131, 31, NULL, 'A last day in MCC\r\n\r\n', 'Public', 'June 19,2022, 03:16 pm'),
(132, 31, NULL, 'Hi everyone after a long gap..✌', 'Public', 'July 17,2022, 02:13 pm');

-- --------------------------------------------------------

--
-- Table structure for table `students_register`
--

CREATE TABLE `students_register` (
  `ID` int(11) NOT NULL,
  `First_name` varchar(500) NOT NULL,
  `Last_name` varchar(500) NOT NULL,
  `Profile_pic` varchar(1000) NOT NULL,
  `Email_id` varchar(500) NOT NULL,
  `Password` varchar(1000) NOT NULL,
  `Security_question` varchar(500) NOT NULL,
  `Answer` varchar(500) NOT NULL,
  `Year` varchar(500) NOT NULL,
  `Department` varchar(1000) NOT NULL,
  `Class` varchar(500) NOT NULL,
  `Gender` varchar(50) NOT NULL,
  `Age` int(11) NOT NULL,
  `From_address` varchar(100) NOT NULL,
  `Lives_in` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students_register`
--

INSERT INTO `students_register` (`ID`, `First_name`, `Last_name`, `Profile_pic`, `Email_id`, `Password`, `Security_question`, `Answer`, `Year`, `Department`, `Class`, `Gender`, `Age`, `From_address`, `Lives_in`) VALUES
(31, 'Sharath', 'M', '3169524397.jpg', '1901721033044@mcc.edu.in', '$2y$10$jBnUjs./v2IImKtCh6KVG.iFRHosxWJbenAc8osKnztXT9Ala7QbO', 'First School', 'Velammal', 'III', 'BCA', 'A', 'Male', 21, 'Chennai', 'Chennai'),
(36, 'Shubham', 'Mishra', '92649840.jpg', '1901721033045@mcc.edu.in', '$2y$10$FMAbBQsmURFAVj.WbXcLF.o1jHh2qcuv6S7uy6g97YHCn4xT0aOC6', 'City', 'Lucknow', 'III', 'BCA', 'A', 'Male', 21, 'Lucknow', 'Chennai'),
(39, 'Divya', 'B', '94078451.jpg', 'divya@mcc.edu.in', '$2y$10$cZ5wJXg4RVtTNQv695CypeFp4kBO9KGfVv7QGlf4jW7SUhbem7HmG', 'School', 'MDK', 'III', 'B.Sc Mathemetics', 'A', 'Female', 20, 'Chennai', 'Chennai'),
(42, 'Imron', 'Khan', '4212411625.jpg', 'imron@mcc.edu.in', '$2y$10$wleR6bD0JxmMKNfv1IQbweGXUwE/gsbzKhodaQakZr8E5CujYU0AS', 'Imron', 'imron', 'II', 'MCA', 'A', 'Male', 21, 'Coimbatore', 'Chennai'),
(45, 'Vero', 'Jeni', '4580737350.jpg', '1901721033004@mcc.edu.in', '$2y$10$1BeoBPSk1jfpIb5bTMA9tu7SOXIHkr6XxJSEHWFtJhUQBJH6Hs8tG', 'natural numbers', '12345678', 'III', 'BCA', 'A', 'Female', 20, 'CHENNAI', 'CHENNAI');

-- --------------------------------------------------------

--
-- Table structure for table `student_details`
--

CREATE TABLE `student_details` (
  `ID` int(11) NOT NULL,
  `Job_id` int(11) NOT NULL,
  `Company_name` varchar(500) NOT NULL,
  `Role` varchar(500) NOT NULL,
  `Full_name` varchar(100) NOT NULL,
  `Email_id` varchar(100) NOT NULL,
  `Year` varchar(10) NOT NULL,
  `Department` varchar(25) NOT NULL,
  `Class` varchar(10) NOT NULL,
  `Tenth_percentage` varchar(10) NOT NULL,
  `Twelve_percentage` varchar(10) NOT NULL,
  `Sem_percentage` varchar(10) NOT NULL,
  `Cgpa` varchar(10) NOT NULL,
  `Backlogs` varchar(10) NOT NULL,
  `History_of_backlogs` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_details`
--

INSERT INTO `student_details` (`ID`, `Job_id`, `Company_name`, `Role`, `Full_name`, `Email_id`, `Year`, `Department`, `Class`, `Tenth_percentage`, `Twelve_percentage`, `Sem_percentage`, `Cgpa`, `Backlogs`, `History_of_backlogs`) VALUES
(1, 4, 'Zoho Corp', 'Software Developer', 'Sharath M', '1901721033044@mcc.edu.in', 'III', 'BCA', 'A', '95', '90.25', '85', '8.5', 'No', 'No'),
(2, 5, 'Start Up', 'Software Developer-Intern', 'Sharath M', '1901721033044@mcc.edu.in', 'III', 'BCA', 'A', '95', '90.25', '85', '8.5', 'No', 'No'),
(3, 1, 'Fanisko', 'Sports Graduate interns/Freshers', 'Sharath M', '1901721033044@mcc.edu.in', 'III', 'BCA', 'A', '95', '90.25', '85', '8.5', 'No', 'No'),
(4, 1, 'Fanisko', 'Sports Graduate interns/Freshers', 'Divya B', 'divya@mcc.edu.in', 'III', 'B.Sc Mathemetics', 'A', '95', '90', '90', '9.0', 'No', 'No'),
(5, 9, 'Mys technologies', 'Web Developer', 'Shubham Mishra', '1901721033045@mcc.edu.in', 'III', 'BCA', 'A', '98', '95', '90', '9.0', 'No', 'Yes'),
(6, 9, 'Mys technologies', 'Web Developer', 'Sharath M', '1901721033044@mcc.edu.in', 'III', 'BCA', 'A', '95', '90.25', '85', '8.5', 'No', 'No'),
(7, 12, 'Infosys', 'Operations Executive', 'Sharath M', '1901721033044@mcc.edu.in', 'III', 'BCA', 'A', '95', '90.25', '85', '8.5', 'No', 'No'),
(8, 12, 'Infosys', 'Operations Executive', 'Shubham Mishra', '1901721033045@mcc.edu.in', 'III', 'BCA', 'A', '98', '95', '90', '9.0', 'No', 'Yes'),
(9, 4, 'Zoho Corp', 'Software Developer', 'Shubham Mishra', '1901721033045@mcc.edu.in', 'III', 'BCA', 'A', '98', '95', '90', '9.0', 'No', 'Yes'),
(10, 1, 'Fanisko', 'Sports Graduate interns/Freshers', 'Shubham Mishra', '1901721033045@mcc.edu.in', 'III', 'BCA', 'A', '98', '95', '90', '9.0', 'No', 'Yes'),
(11, 4, 'Zoho Corp', 'Software Developer', 'Imron Khan', 'imron@mcc.edu.in', 'II', 'MCA', 'A', '98', '95', '90', '9.0', 'No', 'No'),
(12, 11, 'SureIT', 'Assciate-Intern', 'Hari B', 'hari@mcc.in', 'II', 'MCA', 'A', '90', '90', '87', '8.7', 'No', 'No'),
(13, 4, 'Zoho Corp', 'Software Developer', 'Hari B', 'hari@mcc.in', 'II', 'MCA', 'A', '90', '90', '87', '8.7', 'No', 'No'),
(14, 9, 'Mys technologies', 'Web Developer', 'Hari B', 'hari@mcc.in', 'II', 'MCA', 'A', '90', '90', '87', '8.7', 'No', 'No'),
(15, 9, 'Mys technologies', 'Web Developer', 'Imron Khan', 'imron@mcc.edu.in', 'II', 'MCA', 'A', '98', '90', '90', '9.0', 'No', 'No'),
(16, 13, 'Telusko', 'Web Developer', 'Sharath M', '1901721033044@mcc.edu.in', 'III', 'BCA', 'A', '95', '90.25', '85', '8.5', 'No', 'No'),
(17, 13, 'Telusko', 'Web Developer', 'Raghaven Gubare', '1901721033039@mcc.edu.in', 'III', 'BCA', 'A', '98', '90', '75', '7.5', 'No', 'No'),
(18, 11, 'SureIT', 'Assciate-Intern', 'Raghaven Gubare', '1901721033039@mcc.edu.in', 'III', 'BCA', 'A', '98', '90', '75', '7.5', 'No', 'No'),
(19, 16, 'Deloitte USI', 'Associate Analyst', 'Sharath M', '1901721033044@mcc.edu.in', 'III', 'BCA', 'A', '95', '90.25', '85', '8.5', 'No', 'No'),
(20, 17, 'Google', 'SDE', 'vero jeni', '1901721033004@mcc.edu.in', 'III', 'BCA', 'A', '98', '80', '98', '9.8', 'No', 'No'),
(21, 17, 'Google', 'SDE', 'Sharath M', '1901721033044@mcc.edu.in', 'III', 'BCA', 'A', '95', '90.25', '85', '8.5', 'No', 'No'),
(22, 18, 'Microsoft', 'Intern Web Developer having good knowledge in Asp.net framework', 'Sharath M', '1901721033044@mcc.edu.in', 'III', 'BCA', 'A', '95', '90.25', '85', '8.5', 'No', 'No'),
(23, 21, 'Google', 'Sde', 'Sharath M', '1901721033044@mcc.edu.in', 'III', 'BCA', 'A', '95', '90.25', '85', '8.5', 'No', 'No');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`Comment_id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `job_details`
--
ALTER TABLE `job_details`
  ADD PRIMARY KEY (`Job_id`);

--
-- Indexes for table `placement_details`
--
ALTER TABLE `placement_details`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`Post_id`);

--
-- Indexes for table `students_register`
--
ALTER TABLE `students_register`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email_Id` (`Email_id`);

--
-- Indexes for table `student_details`
--
ALTER TABLE `student_details`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `Comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `job_details`
--
ALTER TABLE `job_details`
  MODIFY `Job_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `Post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `students_register`
--
ALTER TABLE `students_register`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `student_details`
--
ALTER TABLE `student_details`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
