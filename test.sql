-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 23, 2024 at 07:39 AM
-- Server version: 5.7.39
-- PHP Version: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movietest`
--

-- --------------------------------------------------------

--
-- Table structure for table `formats`
--

CREATE TABLE `formats` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `formats`
--

INSERT INTO `formats` (`id`, `name`) VALUES
(1, 'VHS'),
(2, 'DVD'),
(3, 'Blu-ray');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `format_id` int(11) NOT NULL,
  `release_year` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `format_id`, `release_year`) VALUES
(1, 'Harry Potter: and the chamber of secrets', 1, 2002);

-- --------------------------------------------------------

--
-- Table structure for table `movie_stars`
--

CREATE TABLE `movie_stars` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `star_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `movie_stars`
--

INSERT INTO `movie_stars` (`id`, `movie_id`, `star_id`) VALUES
(1, 1, 101),
(2, 1, 102);

-- --------------------------------------------------------

--
-- Table structure for table `stars`
--

CREATE TABLE `stars` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stars`
--

INSERT INTO `stars` (`id`, `name`) VALUES
(47, 'Adam Baldwin'),
(84, 'Alan Arkin'),
(46, 'Alan Tudyk'),
(42, 'Alec Guinness'),
(58, 'Ally Sheedy'),
(76, 'Anthony Edwards'),
(11, 'Audrey Hepburn'),
(25, 'Austin Pendleton'),
(55, 'Barbara Hershey'),
(61, 'Barry Corbin'),
(62, 'Bill Pullman'),
(85, 'Brian Keith'),
(82, 'Carl Reiner'),
(41, 'Carrie Fisher'),
(12, 'Cary Grant'),
(96, 'Charles Drake'),
(21, 'Charles Durning'),
(54, 'Chiwetel Ejiofor'),
(9, 'Claude Rains'),
(2, 'Clevon Little'),
(38, 'Connie Nielson'),
(59, 'Dabney Coleman'),
(101, 'Daniel Radcliffe'),
(27, 'Danny DeVito'),
(65, 'Daphne Zuniga'),
(24, 'Dave Geolz'),
(30, 'Dennis Farina'),
(56, 'Dennis Hopper'),
(78, 'Donald Sutherland'),
(92, 'Douglas Rain'),
(79, 'Elliot Gould'),
(102, 'Emma Watson'),
(83, 'Eva Marie Saint'),
(23, 'Frank Oz'),
(33, 'Fred Gwynne'),
(71, 'Gabe Jarret'),
(90, 'Gary Lockwood'),
(29, 'Gene Hackman'),
(4, 'Gene Wilder'),
(15, 'George Kennedy'),
(50, 'Gina Torres'),
(39, 'Harrison Ford'),
(3, 'Harvey Korman'),
(7, 'Humphrey Bogart'),
(8, 'Ingrid Bergman'),
(14, 'James Coburn'),
(43, 'James Earl Jones'),
(93, 'James Stewart'),
(49, 'Jewel Staite'),
(22, 'Jim Henson'),
(66, 'Joan Rivers'),
(37, 'Joaquin Phoenix'),
(31, 'Joe Pesci'),
(63, 'John Candy'),
(26, 'John Travolta'),
(60, 'John Wood'),
(94, 'Josephine Hull'),
(44, 'Karen Allen'),
(98, 'Katherine Heigl'),
(19, 'Katherine Ross'),
(89, 'Keir Dullea'),
(75, 'Kelly McGillis'),
(67, 'Kenneth Mars'),
(34, 'Lane Smith'),
(100, 'Leslie Mann'),
(88, 'Lorraine Gary '),
(6, 'Madeline Kahn'),
(40, 'Mark Hamill'),
(32, 'Marrisa Tomei'),
(57, 'Matthew Broderick'),
(1, 'Mel Brooks'),
(72, 'Michelle Meyrink'),
(51, 'Morena Baccarin'),
(45, 'Nathan Fillion'),
(16, 'Paul Newman'),
(99, 'Paul Rudd'),
(95, 'Peggy Dow'),
(69, 'Peter Boyle'),
(10, 'Peter Lorre'),
(35, 'Ralph Macchio'),
(28, 'Renne Russo'),
(87, 'Richard Dreyfuss'),
(64, 'Rick Moranis'),
(81, 'Robert Duvall'),
(18, 'Robert Redford'),
(20, 'Robert Shaw'),
(48, 'Ron Glass'),
(86, 'Roy Scheider'),
(36, 'Russell Crowe'),
(80, 'Sally Kellerman'),
(52, 'Sean Maher'),
(97, 'Seth Rogen'),
(5, 'Slim Pickens'),
(17, 'Strother Martin'),
(53, 'Summer Glau'),
(68, 'Terri Garr'),
(74, 'Tom Cruise'),
(77, 'Tom Skerritt'),
(70, 'Val Kilmer'),
(13, 'Walter Matthau'),
(73, 'William Atherton'),
(91, 'William Sylvester');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `email`, `password`) VALUES
(1, 'admin', 'admin@admin.com', '4cb13d67725ef9477a0e7088f4dba965');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `formats`
--
ALTER TABLE `formats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`),
  ADD KEY `format_id` (`format_id`);

--
-- Indexes for table `movie_stars`
--
ALTER TABLE `movie_stars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `star_id` (`star_id`);

--
-- Indexes for table `stars`
--
ALTER TABLE `stars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `formats`
--
ALTER TABLE `formats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `movie_stars`
--
ALTER TABLE `movie_stars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stars`
--
ALTER TABLE `stars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`format_id`) REFERENCES `formats` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `movie_stars`
--
ALTER TABLE `movie_stars`
  ADD CONSTRAINT `movie_stars_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movie_stars_ibfk_2` FOREIGN KEY (`star_id`) REFERENCES `stars` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
