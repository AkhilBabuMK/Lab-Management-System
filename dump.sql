-- MariaDB dump 10.19-11.1.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: labmanagement
-- ------------------------------------------------------
-- Server version	11.1.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ActivityLog`
--

DROP TABLE IF EXISTS `ActivityLog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ActivityLog` (
  `LogID` int(11) NOT NULL,
  `TimeStamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`LogID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ActivityLog`
--

LOCK TABLES `ActivityLog` WRITE;
/*!40000 ALTER TABLE `ActivityLog` DISABLE KEYS */;
/*!40000 ALTER TABLE `ActivityLog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Answer`
--

DROP TABLE IF EXISTS `Answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Answer` (
  `AnswerID` int(11) NOT NULL,
  `QuestionID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `AnswerText` text DEFAULT NULL,
  `submissionDate` date DEFAULT NULL,
  `FileUpload` varchar(255) DEFAULT NULL,
  `uploadDate` date DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL CHECK (`Status` in ('Pending','Reviewed','Rejected')),
  `Feedback` text DEFAULT NULL,
  PRIMARY KEY (`AnswerID`),
  KEY `Answer_ibfk_2` (`UserID`),
  KEY `fk_Answer_Question` (`QuestionID`),
  CONSTRAINT `fk_Answer_Question` FOREIGN KEY (`QuestionID`) REFERENCES `Question` (`QuestionID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Answer`
--

LOCK TABLES `Answer` WRITE;
/*!40000 ALTER TABLE `Answer` DISABLE KEYS */;
/*!40000 ALTER TABLE `Answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Lab`
--

DROP TABLE IF EXISTS `Lab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Lab` (
  `LabID` int(11) NOT NULL AUTO_INCREMENT,
  `LabName` varchar(50) DEFAULT NULL,
  `LabDescription` text DEFAULT NULL,
  `TeacherID` int(11) DEFAULT NULL,
  `RoomNumber` varchar(20) DEFAULT NULL,
  `CreationDate` date DEFAULT curdate(),
  PRIMARY KEY (`LabID`),
  KEY `useridconst` (`TeacherID`),
  CONSTRAINT `useridconst` FOREIGN KEY (`TeacherID`) REFERENCES `Users` (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Lab`
--

LOCK TABLES `Lab` WRITE;
/*!40000 ALTER TABLE `Lab` DISABLE KEYS */;
INSERT INTO `Lab` VALUES
(1,'Dbms','sfddsfsdd',1005,'4','2023-11-11'),
(4,'System Software and Microcontroller Lab','ss and mpmc lab',1007,'1','2023-11-12'),
(5,'Mpmc','microprocessor and microcontroller lab',1007,'8','2023-11-12');
/*!40000 ALTER TABLE `Lab` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Question`
--

DROP TABLE IF EXISTS `Question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Question` (
  `QuestionID` int(11) NOT NULL AUTO_INCREMENT,
  `LabID` int(11) DEFAULT NULL,
  `QuestionNumber` int(11) DEFAULT NULL,
  `QuestionText` text DEFAULT NULL,
  `QuestionUploadDate` date DEFAULT NULL,
  `DifficultyLevel` int(11) DEFAULT NULL,
  `submissiondate` date DEFAULT NULL,
  PRIMARY KEY (`QuestionID`),
  KEY `Question_ibfk_1` (`LabID`),
  CONSTRAINT `Question_ibfk_1` FOREIGN KEY (`LabID`) REFERENCES `Lab` (`LabID`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Question`
--

LOCK TABLES `Question` WRITE;
/*!40000 ALTER TABLE `Question` DISABLE KEYS */;
INSERT INTO `Question` VALUES
(2,1,NULL,'Employee salary Increment by 5 % ','2023-11-12',1,'2023-11-12'),
(7,4,NULL,'perform pass 1 algorithm ','2023-11-12',4,'2023-11-12'),
(9,4,NULL,'perfom round roubin','2023-11-12',5,'2023-11-12'),
(10,4,NULL,'perfrom fcfs algorithm ','2023-11-12',2,'2023-11-12'),
(12,1,NULL,'perfrom function in plsql','2023-11-12',2,'2023-11-12'),
(13,1,NULL,'perform Cursor ','2023-11-12',2,'2023-11-12'),
(14,4,NULL,'perfrom scan scheduling','2023-11-12',2,'2023-11-12'),
(15,4,NULL,'perfrom 8086 program','2023-11-12',3,'2023-11-12'),
(17,1,NULL,'perform trigger in plsql','2023-11-12',4,'2023-11-12'),
(19,4,NULL,'perfrom one pass assembler','2023-11-12',4,'2023-11-12'),
(23,1,NULL,'perfrom Bulk import','2023-11-12',2,'2023-11-12'),
(25,5,NULL,'perfrom 8056 addition of 16 bit numbers','2023-11-12',2,'2023-11-12'),
(26,4,NULL,'perfrom cscan algorithm','2023-11-12',1,'2023-11-12');
/*!40000 ALTER TABLE `Question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Session`
--

DROP TABLE IF EXISTS `Session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Session` (
  `SessionID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `LoginTime` timestamp NULL DEFAULT NULL,
  `LogoutTime` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`SessionID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Session`
--

LOCK TABLES `Session` WRITE;
/*!40000 ALTER TABLE `Session` DISABLE KEYS */;
/*!40000 ALTER TABLE `Session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `StudentLab`
--

DROP TABLE IF EXISTS `StudentLab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `StudentLab` (
  `StudentID` int(11) NOT NULL,
  `LabID` int(11) NOT NULL,
  PRIMARY KEY (`StudentID`,`LabID`),
  KEY `StudentLab_ibfk_2` (`LabID`),
  CONSTRAINT `StudentLab_ibfk_2` FOREIGN KEY (`LabID`) REFERENCES `Lab` (`LabID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `StudentLab`
--

LOCK TABLES `StudentLab` WRITE;
/*!40000 ALTER TABLE `StudentLab` DISABLE KEYS */;
/*!40000 ALTER TABLE `StudentLab` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Role` varchar(20) DEFAULT NULL CHECK (`Role` in ('Teacher','Student','Admin')),
  `Username` varchar(50) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `ContactNumber` varchar(20) DEFAULT NULL,
  `RegistrationDate` date DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL CHECK (`Status` in ('enabled','disabled')),
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `unique_username` (`Username`),
  UNIQUE KEY `unique_email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=1009 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES
(1001,'Student','Akhil','$2y$10$3kPyjOT6QeZZ0a3RCZPuAuczSYRCOd1Cn9BrrWfhlak7v9DMJAmc6','akhilbabu633@gmail.com','AkhilBabuMK','9747136608','2023-11-11','enabled'),
(1003,'Student','Timothi','$2y$10$stBNb3yenf2B27msfj6doutmRlhpJqebloq/Wc5/JPCpyHuCb8Ouy','timtho@gmail.com','Timothi m aby','9857465622','2023-11-11','enabled'),
(1004,'Admin','Admin','$2y$10$FiXFiVvjgFGat3SY03mtxuqohAC2DrfLoA6EIvGnVlxc7.4QT3mHW','admin@gamil.com','adminUser','9858457823','2023-11-11','enabled'),
(1005,'Teacher','DivyaJohn','$2y$10$Zn3gSNpuL6AmEnhPtF8ZLeycVMPvB2/YzI2RjR0p7Ihm5ilD3.5bG','divyajohn@gamil.com','DivyaJohnDJ','98574562221','2023-11-11','enabled'),
(1006,'Student','Amal','$2y$10$CceL5FQY55RUyv6xvTcblu4bmamLDNxgbXfKx5SxElvt/1sm5tUBe','amal@gmail.com','amalKrishna','7845962152','2023-11-11','enabled'),
(1007,'Teacher','Soumya','$2y$10$i3U6TU/7a5i5W/2pwH/iD.5DjPB/XzNwpzVlR7T1xr3nKYUBSh4Va','soumya@gmail.com','Soumya S Raj','8545256387','2023-11-12','enabled');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-12 22:56:54
