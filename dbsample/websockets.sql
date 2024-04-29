-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2024 at 03:45 AM
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
-- Database: `websockets`
--

-- --------------------------------------------------------

--
-- Table structure for table `w_chats`
--

CREATE TABLE `w_chats` (
  `chat_id` int(11) NOT NULL,
  `u_from` int(11) NOT NULL,
  `u_to` int(11) NOT NULL,
  `u_msg` varchar(250) NOT NULL,
  `u_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `u_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `u_isread` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `w_users`
--

CREATE TABLE `w_users` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `u_token` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `w_users`
--

INSERT INTO `w_users` (`id`, `fname`, `lname`, `u_token`) VALUES
(1, 'admin', 'Llauderes', 'cc04f6bffc811bba810519d08c5fe2453650c30c298cf0c2392213d19e6d8d061'),
(2, 'Pogi', 'Simon', '6cfe42f4d4bea4e6c75e81d0949ee45076f38f41d7c2b64f3387e9e8f10c0dc12'),
(3, 'Nino', 'John', '0103f5a7ffa30c4ab47763249b18c4a643b3c7212bf75f63c9ced081365cb7343');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `w_chats`
--
ALTER TABLE `w_chats`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `w_users`
--
ALTER TABLE `w_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `w_chats`
--
ALTER TABLE `w_chats`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `w_users`
--
ALTER TABLE `w_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
