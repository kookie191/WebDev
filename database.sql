-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2024 at 05:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blackboard3`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `AssignmentID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `AssignmentName` varchar(100) NOT NULL,
  `Weight` decimal(5,2) NOT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`AssignmentID`, `CourseID`, `AssignmentName`, `Weight`, `Description`) 
VALUES 
(4, 1, 'report 2', 20.00, 'make a detailed report about nothing tbh.'),
(5, 2, 'presentation', 15.00, 'Prepare a 10-minute presentation on the topic of renewable energy sources.'),
(6, 3, 'coding project', 25.00, 'Develop a web application using HTML, CSS, and JavaScript.'),
(7, 1, 'midterm exam', 30.00, 'A comprehensive exam covering all topics discussed in the first half of the course.'),
(8, 2, 'essay', 10.00, 'Write a 5-page essay discussing the impact of globalization on cultural identity.'),
(9, 3, 'quiz 1', 5.00, 'Short quiz covering basic concepts of object-oriented programming.'),
(10, 1, 'final project', 35.00, 'Design and implement a software solution for a real-world problem of your choice.');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `CourseID` int(11) NOT NULL,
  `CourseName` varchar(100) NOT NULL,
  `CourseCode` varchar(20) NOT NULL,
  `Tutor` varchar(100) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Term` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`CourseID`, `CourseName`, `CourseCode`, `Tutor`, `Description`, `Term`) VALUES
(1, 'Introduction to Computer Science', 'CS101', 'Dr Hend ElMohandes', 'This course provides an introductory overview of computer science, covering fundamental concepts such as algorithms, programming languages, data structures, and computer architecture. Students will learn the basics of problem-solving using computers and gain foundational knowledge necessary for further studies in computer science.', '1'),
(2, 'Data Structures and Algorithms', 'CS201', 'Dr Manar Alkhatib', 'Data structures and algorithms are fundamental components of computer science. This course explores various data structures (such as arrays, linked lists, trees, and graphs) and algorithms (such as sorting, searching, and graph traversal). Students will learn how to analyze the efficiency and performance of algorithms and how to choose the appropriate data structure for solving different computational problems.', '2'),
(3, 'Web Development', 'WEB101', 'Dr Manar Alkhatib', 'Web development focuses on designing and building interactive websites and web applications. This course covers front-end development (HTML, CSS, JavaScript) for creating user interfaces and back-end development (server-side scripting, databases) for handling data and business logic. Students will learn how to create responsive and dynamic web applications using modern web development frameworks and tools.', '2'),
(4, 'Mathematics', 'MATH101', 'Dr Manar Alkhatib', 'Mathematics encompasses the study of numbers, quantities, shapes, and patterns. This course delves into various branches of mathematics, including algebra, geometry, calculus, statistics, and discrete mathematics. Students will develop problem-solving skills, logical reasoning, and critical thinking abilities through the exploration of mathematical concepts and applications.', '3'),
(5, 'Introduction to Artificial Intelligence', 'AI101', 'Dr. Sarah Smith', 'Introduction to Artificial Intelligence (AI) covers the fundamental concepts and techniques used in AI systems, including problem-solving methods, knowledge representation, machine learning, and natural language processing. Students will gain an understanding of how AI technologies are applied in various domains and develop practical skills through programming assignments and projects.', '1'),
(6, 'Database Management Systems', 'DBMS201', 'Prof. John Davis', 'Database Management Systems (DBMS) focuses on the principles and practices of designing, implementing, and managing database systems. Topics include data modeling, relational database design, SQL programming, database security, and transaction management. Students will learn how to build and query databases to support information management and decision-making processes.', '2'),
(7, 'Software Engineering', 'SE301', 'Dr. Emily Johnson', 'Software Engineering is concerned with the systematic approach to developing high-quality software systems. This course covers software development methodologies, requirements engineering, software design, testing, and project management. Students will work on team-based projects to apply software engineering principles and practices in real-world scenarios.', '2'),
(8, 'Machine Learning', 'ML401', 'Prof. Michael Lee', 'Machine Learning explores algorithms and techniques that enable computers to learn from data and make predictions or decisions without being explicitly programmed. Topics include supervised learning, unsupervised learning, reinforcement learning, neural networks, and deep learning. Students will gain hands-on experience with machine learning algorithms through programming assignments and projects.', '3'),
(9, 'Cybersecurity Fundamentals', 'SEC101', 'Dr. Samantha Brown', 'Cybersecurity Fundamentals provides an introduction to the principles and practices of securing computer systems and networks against cyber threats. Topics include network security, cryptography, access control, security policies, and incident response. Students will learn how to identify vulnerabilities, assess risks, and implement security measures to protect information assets.', '3');
-- --------------------------------------------------------

--
-- Table structure for table `student_courses`
--

CREATE TABLE `student_courses` (
  `StudentID` varchar(50) NOT NULL,
  `CourseID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `student_courses`
--

INSERT INTO `student_courses` (`StudentID`, `CourseID`) 
VALUES 
('1000', 1),
('1000', 2),
('1000', 3),
('1000', 4),
('1000', 5),
('1000', 6),
('1122', 1),
('1122', 2),
('1122', 5),
('1122', 6),
('1122', 8),
('1122', 7),
('1155', 3),
('1155', 4),
('1155', 6),
('1155', 9),
('1155', 8),
('1155', 7),
('1188', 2),
('1188', 4),
('1188', 7),
('1188', 1),
('1188', 9),
('1188', 8);


-- --------------------------------------------------------

--
-- Table structure for table `student_marks`
--

CREATE TABLE `student_marks` (
  `StudentID` varchar(50) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `Grade` decimal(5,2) DEFAULT NULL,
  `AssignmentGrade` decimal(5,2) DEFAULT NULL,
  `QuizGrade` decimal(5,2) DEFAULT NULL,
  `FinalExamGrade` decimal(5,2) DEFAULT NULL,
  `AssignmentID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_marks`
--

INSERT INTO `student_marks` (`StudentID`, `CourseID`, `Grade`, `AssignmentGrade`, `QuizGrade`, `FinalExamGrade`, `AssignmentID`) 
VALUES 
('1000', 1, 82.67, 83.00, 75.00, 90.00, NULL),
('1000', 2, 93.00, 60.00, 70.00, 80.00, NULL),
('1000', 3, 90.00, 90.00, 90.00, 90.00, NULL),
('1122', 1, 78.00, 53.00, 83.00, 76.00, NULL),
('1222', 2, 88.50, NULL, NULL, NULL, NULL),
('1234', 1, 92.00, NULL, NULL, NULL, NULL),
('1234', 2, 85.00, NULL, NULL, NULL, NULL),
('13245', 3, 70.00, NULL, NULL, NULL, NULL),
('1000', 4, 85.00, 88.00, NULL, NULL, NULL),
('1122', 2, 75.00, 70.00, 80.00, 75.00, NULL),
('1222', 3, 95.00, 90.00, NULL, NULL, NULL),
('1234', 3, 88.00, 85.00, NULL, NULL, NULL);


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` varchar(50) NOT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Type` enum('admin','student') NOT NULL,
  `EmailId` varchar(50) DEFAULT NULL,
  `MobNo` bigint(11) DEFAULT NULL,
  `Password` varchar(50) DEFAULT NULL,
  `gender` enum('male','female') NOT NULL DEFAULT 'male',
  `educationLevel` varchar(100) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `mailingAddress` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `FirstName`, `LastName`, `Type`, `EmailId`, `MobNo`, `Password`, `gender`, `educationLevel`, `birthday`, `mailingAddress`) 
VALUES 
('1000', 'batool', 'masadehs', 'student', 'batool.masadeh@yahoo.com', 222, '123', 'female', '', '0000-00-00', ''),
('1122', 'Abbot', 'rabiot', 'student', 'abbot@gmail.com', 6352416352, '1234', 'male', NULL, NULL, NULL),
('1222', 'Alice', 'wunder', 'student', 'alice@hotmail.com', 4512451245, 'b160003ch', 'female', NULL, NULL, NULL),
('2331', 'bale', 'gareth', 'student', 'bale@gmail.com', 96685747485, 'b160005ce', 'male', NULL, NULL, NULL),
('ADMIN', 'admin', NULL, 'admin', 'admin@nitc.ac.in', 123456789, 'admin', 'female', NULL, NULL, NULL),
('3333', 'John', 'Doe', 'student', 'johndoe@example.com', 1234567890, 'password', 'male', NULL, NULL, NULL),
('4444', 'Jane', 'Smith', 'student', 'janesmith@example.com', 9876543210, 'password123', 'female', NULL, NULL, NULL),
('5555', 'Michael', 'Johnson', 'student', 'michaeljohnson@example.com', 9871234560, 'pass123', 'male', NULL, NULL, NULL);


--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`AssignmentID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`CourseID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- Indexes for table `student_courses`
--
ALTER TABLE `student_courses`
  ADD PRIMARY KEY (`StudentID`,`CourseID`),
  ADD KEY `fk_course_id` (`CourseID`);

--
-- Indexes for table `student_marks`
--
ALTER TABLE `student_marks`
  ADD PRIMARY KEY (`StudentID`,`CourseID`),
  ADD KEY `AssignmentID` (`AssignmentID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `EmailId` (`EmailId`),
  ADD KEY `UserID` (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `AssignmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `CourseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`);

--
-- Constraints for table `student_marks`
--
ALTER TABLE `student_marks`
  ADD CONSTRAINT `student_marks_ibfk_1` FOREIGN KEY (`AssignmentID`) REFERENCES `assignments` (`AssignmentID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
