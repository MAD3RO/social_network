-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2017 at 06:54 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social_network`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_author_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `user_id`, `comment`, `comment_author_id`, `date`) VALUES
(111, 132, 1, 'Just handle the form submission on the submit event, and return false:\r\n$(#contactForm).submit(function () {\r\n sendContactForm();\r\n return false;\r\n});', 2, '2017-09-07 19:09:17'),
(112, 132, 1, 'Instead of using the onClick event, you will use bind an click event handler using jQuery to the submit button (or whatever button), which will take submitClick as a callback. We pass the event to the callback to call preventDefault, which is what will prevent the click from submitting the form.', 3, '2017-09-07 19:11:52'),
(113, 132, 1, 'An alternative solution would be to not use form tag and handle click event on submit button through jquery. This way there wont be any page refresh but at the same time there is a downside that \"enter\" button for submission wont work and also on mobiles you wont get a go button( a style in some mobiles). So stick to use of form tag and use the accepted answer.', 4, '2017-09-07 19:13:08'),
(114, 133, 4, 'unset($foo[0]); // remove item at index 0\r\n$foo2 = array_values($foo); // reindex array', 3, '2017-09-07 19:20:30'),
(115, 133, 4, 'It works!!!! Thank you very much!!', 4, '2017-09-07 19:21:47');

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int(11) NOT NULL,
  `user_id_from` int(10) NOT NULL,
  `user_id_to` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `msg_sub` text NOT NULL,
  `msg_topic` text NOT NULL,
  `reply` text NOT NULL,
  `status` text NOT NULL,
  `msg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `post_title` text NOT NULL,
  `post_content` text NOT NULL,
  `image` text NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_public` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `topic_id`, `post_title`, `post_content`, `image`, `post_date`, `is_public`) VALUES
(132, 1, 3, 'Stop form refreshing page on submit', 'I\'ve searched through a bunch of pages, but can\'t find my problem, so I had to make a post.\r\n\r\nI have a form that has a submit button, and when submitted I want it to NOT refresh OR redirect. I just want jQuery to perform a function.\r\n\r\nHere\'s the form:', 'js.JPG', '2017-09-07 18:23:41', 1),
(133, 4, 2, 'How to Remove Array Element and Then Re-Index Array?', 'I have some troubles with an array. I have one array that I want to modify like below. I want to remove element (elements) of it by index and then re-index array. Is it possible?', 'php.JPG', '2017-09-07 19:15:28', 0);

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `topic_id` int(11) NOT NULL,
  `topic_title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `topic_title`) VALUES
(1, 'HTML & CSS'),
(2, 'PHP & MYSQL'),
(3, 'Javascript'),
(4, 'Ajax');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_pass` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_country` varchar(100) NOT NULL,
  `user_gender` varchar(100) NOT NULL,
  `user_b_day` date NOT NULL,
  `user_image` text NOT NULL,
  `register_date` date NOT NULL,
  `status` text NOT NULL,
  `posts` text NOT NULL,
  `friend_array` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_pass`, `user_email`, `user_country`, `user_gender`, `user_b_day`, `user_image`, `register_date`, `status`, `posts`, `friend_array`) VALUES
(1, 'Pero Peric', 'passwordd', 'pero@gmail.com', 'Afganistan', 'Male', '1995-06-14', 'fight_club.jpg', '2017-06-17', 'unverified', 'yes', '2,4'),
(2, 'Ivan Ivic', 'password', 'ivan@gmail.com', 'Croatia', 'Male', '1996-06-22', 'nature.jpg', '2017-06-17', 'unverified', 'No', '1'),
(3, 'Ana Anic', 'password', 'ana@gmail.com', 'Denmark', 'Female', '1994-06-20', 'default.jpg', '2017-06-06', 'unverified', 'No', '4'),
(4, 'Petra Petric', 'password', 'petra@gmail.com', 'Belgia', 'Female', '1993-06-07', 'razer.jpg', '2017-06-06', 'unverified', 'yes', '1,3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;
--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;
--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
