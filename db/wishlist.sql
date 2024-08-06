-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 29, 2024 at 09:22 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wishlist`
--

-- --------------------------------------------------------

--
-- Table structure for table `Image`
--

CREATE TABLE `Image` (
    `image_id` int(11) NOT NULL,
    `file_name` varchar(255) NOT NULL,
    `file_size` int NOT NULL,
    `file_type` varchar(50) NOT NULL,
    `upload_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `Wishlist_Items`
--

CREATE TABLE `Wishlist_Items` (
  `itemid` int(11) NOT NULL,
  `rid` int(11) NOT NULL, -- role id
  `sid` int(11) NOT NULL, -- status id
  `image_id` int(11) NOT NULL, -- image id
  `item_name` varchar(100) NOT NULL,
  `description` TEXT,
  `category` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `uid` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `passwd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `Role`
--

CREATE TABLE `Role` (
  `rid` int(11) NOT NULL,
  `rname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Role`
--

INSERT INTO `Role` (`rid`, `rname`) VALUES
(1, 'admin'),
(2, 'non-admin');

--
-- Table structure for table `Status`
--

CREATE TABLE `Status` (
  `sid` int(11) NOT NULL,
  `sname` varchar(255) NOT NULL DEFAULT 'Not Urgent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Status`
--

INSERT INTO `Status` (`sid`, `sname`) VALUES
(1, 'Urgent'),
(2, 'Not Urgent'),
(3, 'Bought');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Wishlist_Items`
--
ALTER TABLE `Wishlist_Items`
  ADD PRIMARY KEY (`itemid`),
  ADD KEY `rid` (`rid`),
  ADD KEY `sid` (`sid`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `rid` (`rid`);

--
-- Indexes for table `Role`
--
ALTER TABLE `Role`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `Image`
--
ALTER TABLE `Image`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `Status`
--

ALTER TABLE `Status`
  ADD PRIMARY KEY (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Image`
--
ALTER TABLE `Image`
	MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT;


--
-- AUTO_INCREMENT for table `Wishlist_Items`
--
ALTER TABLE `Wishlist_Items`
  MODIFY `itemid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Role`
--
ALTER TABLE `Role`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Status`
--

ALTER TABLE `Status`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Wishlist_Items`
--

ALTER TABLE `Wishlist_Items`
  ADD CONSTRAINT `found_items_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `Role` (`rid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `found_items_ibfk_2` FOREIGN KEY (`sid`) REFERENCES `Status` (`sid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `found_items_ibfk_3` FOREIGN KEY (`image_id`) REFERENCES `Image` (`image_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `Role` (`rid`) ON DELETE CASCADE ON UPDATE CASCADE;

INSERT INTO `User` (`rid`, `fname`, `lname`, `gender`, `tel`, `email`, `passwd`) VALUES (1, 'Nyameye', 'Akumia', 'Other', '0556036295', 'kiki.etc@icloud.com', '$2y$10$DTkowH8nMqwBuC3n.EhmROENY2KB.lNPsFYfxZU15h/uF8rDJLtu6');


COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;