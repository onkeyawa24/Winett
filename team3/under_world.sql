-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2019 at 04:39 PM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `under_world`
--

-- --------------------------------------------------------

--
-- Table structure for table `advices`
--

CREATE TABLE `advices` (
  `advice_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `advice` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `advices`
--

INSERT INTO `advices` (`advice_id`, `question_id`, `advice`) VALUES
(21, 32, 'Reusing passwords is a bad practice. If you reuse a password in a service under attackersâ€™ control, they\r\nmay be successful when attempting to log in as you in other services.'),
(22, 33, 'Emails can be easily forged to look legitimate. Forged emails often contain links to malicious sites or\r\nmalware. As a general rule, do not click embedded links received via email.'),
(23, 34, 'Do not accept any unsolicited software, especially if it comes from a web page. It is extremely unlikely\r\nthat a web page will have a legitimate software update for you. It is strongly recommended to close the\r\nbrowser and use the operating system tools to check for the updates.'),
(24, 35, 'Malicious web pages can be easily made to look like a bank or financial institution website. Before clicking\r\nthe links or providing any information, double-check the URL to make sure it is the correct web page.'),
(25, 36, 'When you allow a program to run on your computer, you give it a lot of power. Choose wisely before\r\nallowing a program to run. Research to make sure the company or individual behind the program is a\r\nserious and legitimate author. Also, only download the program from the official website of the company\r\nor individual.'),
(26, 37, 'USB drives and thumb drives include a tiny controller to allow computers to communicate with it. It is\r\npossible to infect that controller and instruct it to install malicious software on the host computer. Because\r\nthe malware is hosted in the USB controller itself and not in the data area, no amount of erasing or\r\nanti-virus scanning will detect the malware.'),
(27, 38, 'Attackers will often deploy fake Wi-Fi hotspots to lure users. Because the attacker has access to all the\r\ninformation exchanged via the compromised hotspot, users connected to that hotspot are at risk. Never\r\nuse unknown Wi-Fi hot spots without encrypting your traffic through a VPN. Never provide sensitive data\r\nsuch as credit card numbers while using an unknown network (wired or wireless).');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `commenter_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date_commented` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `commenter_id`, `comment`, `date_commented`) VALUES
(3, 5, 'Hi guys, this is the first comment. ', '2018-10-16 13:34:43'),
(9, 3, 'Hi guys, you can share advice on how to be safe when online.', '2018-10-16 19:12:52'),
(12, 6, '<i style=\"color: red;\">This post has been removed. <b style=\"blue\"></i>', '2018-10-17 00:03:03'),
(15, 5, 'The survey was very useful for me, now I see where I need to improve on my online behavior.', '2018-10-22 10:21:43');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `question` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question`) VALUES
(32, 'When you create a new account in an online service, you:'),
(33, 'When you receive an email with links to other sites:'),
(34, 'A pop-up window is displayed as you visit a website. It states your computer is at risk and you should\r\ndownload and install a diagnostics program to make it safe:'),
(35, 'When you need to log into your financial institutionâ€™s website to perform a task, you:'),
(36, 'You read about a program and decide to give it a try. You look around the Internet and find a trial version\r\non an unknown site, you:'),
(37, 'You find a USB drive while walking to work. you:'),
(38, 'You need to connect to the Internet and you find an open Wi-Fi hotspot. You:');

-- --------------------------------------------------------

--
-- Table structure for table `table_options`
--

CREATE TABLE `table_options` (
  `option_id` int(11) NOT NULL,
  `options` text NOT NULL,
  `question_id` int(11) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table_options`
--

INSERT INTO `table_options` (`option_id`, `options`, `question_id`, `score`) VALUES
(76, 'You click all links if the email came from a person you know.', 32, 2),
(77, 'You hover the mouse on links to verify the destination URL before clicking.', 32, 1),
(78, 'You do not click the link because you never follow links sent to you via email.', 33, 0),
(79, 'You click the links because the email server has already scanned the email.', 33, 3),
(80, 'You click all links if the email came from a person you know.', 33, 2),
(81, 'You hover the mouse on links to verify the destination URL before clicking.', 33, 1),
(82, 'You click, download, and install the program to keep your computer safe.', 34, 3),
(83, 'You inspect the pop-up windows and hover over the link to verify its validity.', 34, 3),
(84, 'Ignore the message, making sure you donâ€™t click it or download the program and close the website.', 34, 0),
(86, 'Enter your login information immediately.', 35, 3),
(87, 'You verify the URL to ensure it is the institution you were looking for before entering any information.', 35, 0),
(88, 'You donâ€™t use online banking or any online financial services.', 35, 0),
(90, 'Promptly download and install the program.', 36, 3),
(91, 'Search for more information about the program creator before downloading it.', 36, 1),
(92, 'Do not download or install the program.', 36, 0),
(94, 'Pick it up and plug it into your computer to look at its contents.', 37, 3),
(95, 'Pick it up and plug it into your computer to completely erase its contents before re-using it.', 37, 3),
(96, 'Pick it up and plug it into your computer to run an anti-virus scan before re-using it for your own files', 37, 3),
(97, 'Donâ€™t pick it up.', 37, 0),
(98, 'Connect to it and use the Internet.', 38, 3),
(99, 'Donâ€™t connect to it and wait until you have a trusted connection.', 38, 0),
(100, 'Connect to it and establishes a VPN to a trusted server before sending any information.', 38, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(55) NOT NULL,
  `display_name` varchar(15) NOT NULL,
  `gender` enum('m','f') NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `display_name`, `gender`, `date_created`, `date_modified`, `password`) VALUES
(3, 'admin@team3.com', 'Admin', 'm', '2018-10-16 11:23:31', '2018-10-16 11:23:31', '$2y$10$57wrMRpQuCf75vd1JO4UNuqretBp2qp21hIiUuB1laTeSoejgyU/G'),
(4, 'yawa@gmail.com', 'Onke Yawa', 'm', '2018-10-16 11:28:22', '2018-10-16 11:28:22', '$2y$10$WKwGEYQ6DIjhkwou0LrLaeBpU.hi0enbIKY3lrQB46Cglqn8gCkxO'),
(5, 'anoni@gmail.com', 'Anonymous', 'f', '2018-10-16 11:51:50', '2018-10-16 11:51:50', '$2y$10$8NLXdQvSXoZWSoSBfmg11.41MzR08Zw5dZugrzB5GwmpTaqMqnA0O'),
(6, 'play@gmail.com', 'Playboy25', 'm', '2018-10-17 00:02:30', '2018-10-17 00:02:30', '$2y$10$y.HD8Ah3eUM.iI7SSElC9egw0yyrFg58W7oI0QbsXsTJUxe8zdRym');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advices`
--
ALTER TABLE `advices`
  ADD PRIMARY KEY (`advice_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `commenter_id` (`commenter_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `table_options`
--
ALTER TABLE `table_options`
  ADD PRIMARY KEY (`option_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advices`
--
ALTER TABLE `advices`
  MODIFY `advice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `table_options`
--
ALTER TABLE `table_options`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `advices`
--
ALTER TABLE `advices`
  ADD CONSTRAINT `advices_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`commenter_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`commenter_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `table_options`
--
ALTER TABLE `table_options`
  ADD CONSTRAINT `table_options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
