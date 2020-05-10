-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2020 at 01:00 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent` int(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `ordering` int(11) NOT NULL,
  `visibility` tinyint(4) NOT NULL DEFAULT 0,
  `allow_comment` tinyint(4) DEFAULT 0,
  `allow_ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent`, `description`, `ordering`, `visibility`, `allow_comment`, `allow_ads`) VALUES
(1, 'Electric', 0, 'This is For Electric Machine', 0, 0, 0, 0),
(2, 'Toyes', 0, 'This is Category For Kids', 4, 0, 0, 0),
(3, 'Private', 0, 'This Is For Private Category', 2, 0, 1, 1),
(5, 'Huwai Mobile', 1, 'Mobile Phone', 3, 0, 0, 0),
(6, 'Blocks', 2, 'Bolcks For Kids Play', 2, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` varchar(250) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `status`, `date`, `item_id`, `user_id`) VALUES
(1, 'Thanks 100 Million', 0, '0000-00-00', 4, 11),
(2, 'Good Item', 0, '0000-00-00', 3, 8),
(5, 'dgdgdg', 1, '2020-02-21', 4, 12),
(7, 'dd Your Commen', 0, '2020-03-07', 7, 13),
(8, 'dd Your Commen', 0, '2020-03-07', 7, 13),
(9, 'dd Your Commen', 0, '2020-03-07', 7, 13),
(10, 'dd Your Commen', 1, '2020-03-07', 7, 13),
(11, 'Good Mobile Phone', 0, '2020-03-07', 7, 13);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `price` varchar(250) NOT NULL,
  `date` date NOT NULL,
  `country_made` varchar(250) NOT NULL,
  `image` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL,
  `approve` tinyint(4) NOT NULL DEFAULT 0,
  `rating` smallint(6) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `description`, `price`, `date`, `country_made`, `image`, `status`, `approve`, `rating`, `cat_id`, `member_id`) VALUES
(3, 'PS-4', 'Play Games', '150', '2020-02-14', 'Eroup', '', '2', 1, 0, 2, 8),
(4, 'Huawei N90', 'Mobile Phone', '95', '2020-02-14', 'China', '', '2', 0, 0, 1, 11),
(6, 'PS-4', 'Play Games', '140', '2020-02-15', 'Eroup', '', '2', 0, 0, 2, 11),
(7, 'Mobile', 'Mobile Phone', '85', '2020-03-06', 'China', '', '2', 0, 0, 1, 13);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `fullname` varchar(250) NOT NULL,
  `groubid` int(11) NOT NULL DEFAULT 0,
  `truststatus` int(11) NOT NULL DEFAULT 0,
  `regstatus` int(11) NOT NULL DEFAULT 0,
  `date` date NOT NULL,
  `image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `fullname`, `groubid`, `truststatus`, `regstatus`, `date`, `image`) VALUES
(7, 'hamza', '9cdda67ded3f25811728276cefa76b80913b4c54', 'hamza@shops', 'hamza mohamed', 0, 0, 0, '2020-01-27', '7_IMG_20180708_100205.jpg'),
(8, 'mazen ', '66efd9eefecf45dd64eff8e5cb2d13e005041925', 'mazen@shop', 'mazen mohamed', 0, 0, 0, '2020-01-31', '487_IMG_20190630_230735.JPG'),
(10, 'mohamed', '1985', 'mohamed@shop', 'mohamed elnemr', 1, 0, 0, '2020-02-04', '0'),
(11, 'Hany', 'bc3fa85725faafb899d3cd087484ecd09d05d8ce', 'hany@gmail.com', 'hany ahmed', 0, 0, 0, '2020-02-03', '27_DSC00163.JPG'),
(12, 'Marwa', '3d7b4f23b8f853910e4c64f09cdf897a59db524a', 'marwa@gmail.com', 'Marwa Masoud', 0, 0, 1, '2020-02-07', '0'),
(13, 'wael', '97265864d4de7d166302649eb1f26d64d16c88d5', 'wael@shop.com', 'wael mohmaed', 0, 0, 0, '2020-03-02', '490_uuu.bmp'),
(14, 'dsdsdsd', '316c03c9f991368eb792f2be5407823ef2605646', 'dsdsds@adad', 'adadad', 0, 0, 1, '2020-03-12', '646_The Secret of the Star.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item` (`item_id`),
  ADD KEY `user` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
