-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql203.infinityfree.com
-- Generation Time: Jan 18, 2024 at 01:56 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_35516756_Page`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminId` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `productId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedbackId` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `feedbackDescription` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `likeId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `productId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `messageId` int(11) NOT NULL,
  `userId1` int(11) DEFAULT NULL,
  `userId2` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `likes` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productId`, `name`, `description`, `price`, `image`, `likes`) VALUES
(1, 'Product 1', 'Description for Product 1', '19.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 1),
(2, 'Product 2', 'Description for Product 2', '29.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(3, 'Product 3', 'Description for Product 3', '39.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(4, 'Product 4', 'Description for Product 4', '49.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(5, 'Product 5', 'Description for Product 5', '59.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(6, 'Product 6', 'Description for Product 6', '69.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(7, 'Product 7', 'Description for Product 7', '79.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 2),
(8, 'Product 8', 'Description for Product 8', '89.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(9, 'Product 9', 'Description for Product 9', '99.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(10, 'Product 10', 'Description for Product 10', '109.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(11, 'Product 11', 'Description for Product 11', '119.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(12, 'Product 12', 'Description for Product 12', '129.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(13, 'Product 13', 'Description for Product 13', '139.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(14, 'Product 14', 'Description for Product 14', '149.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(15, 'Product 15', 'Description for Product 15', '159.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(16, 'Product 16', 'Description for Product 16', '169.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 1),
(17, 'Product 17', 'Description for Product 17', '179.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(18, 'Product 18', 'Description for Product 18', '189.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 1),
(19, 'Product 19', 'Description for Product 19', '199.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(20, 'Product 20', 'Description for Product 20', '209.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(21, 'Product 21', 'Description for Product 21', '219.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 1),
(22, 'Product 22', 'Description for Product 22', '229.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 1),
(23, 'Product 23', 'Description for Product 23', '239.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(24, 'Product 24', 'Description for Product 24', '249.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(25, 'Product 25', 'Description for Product 25', '259.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(26, 'Product 26', 'Description for Product 26', '269.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(27, 'Product 27', 'Description for Product 27', '279.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(28, 'Product 28', 'Description for Product 28', '289.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(29, 'Product 29', 'Description for Product 29', '299.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(30, 'Product 30', 'Description for Product 30', '309.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(31, 'Product 31', 'Description for Product 31', '319.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(32, 'Product 32', 'Description for Product 32', '329.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(33, 'Product 33', 'Description for Product 33', '339.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(34, 'Product 34', 'Description for Product 34', '349.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 1),
(35, 'Product 35', 'Description for Product 35', '359.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(36, 'Product 36', 'Description for Product 36', '369.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(37, 'Product 37', 'Description for Product 37', '379.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(38, 'Product 38', 'Description for Product 38', '389.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(39, 'Product 39', 'Description for Product 39', '399.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0),
(40, 'Product 40', 'Description for Product 40', '409.99', 'uploads/dom-CxjtV9qip6M-unsplash.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(25) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminId`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartId`),
  ADD KEY `fk_user` (`userId`),
  ADD KEY `fk_product` (`productId`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `productId` (`productId`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedbackId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`likeId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `productId` (`productId`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageId`),
  ADD KEY `userId1` (`userId1`),
  ADD KEY `userId2` (`userId2`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedbackId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `likeId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `messageId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`userId1`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`userId2`) REFERENCES `users` (`userId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
