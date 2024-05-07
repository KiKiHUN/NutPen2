-- MariaDB dump 10.19-11.5.0-MariaDB, for Win64 (AMD64)
--
-- Host: kgaming.ddns.net    Database: NutPen2
-- ------------------------------------------------------
-- Server version	10.3.39-MariaDB-0+deb10u2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `UserID` varchar(8) NOT NULL,
  `password` varchar(60) NOT NULL,
  `FName` varchar(50) NOT NULL,
  `LName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `SexTypeID` smallint(5) unsigned NOT NULL,
  `PostalCode` smallint(5) unsigned NOT NULL,
  `FullAddress` varchar(255) NOT NULL,
  `BDay` date NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `RoleTypeID` bigint(20) unsigned NOT NULL,
  `LastLogin` datetime NOT NULL,
  `AllowMessages` tinyint(1) NOT NULL DEFAULT 1,
  `BannedFromMessages` tinyint(1) NOT NULL DEFAULT 0,
  `Enabled` tinyint(1) NOT NULL DEFAULT 1,
  `DefaultPassword` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`UserID`),
  KEY `admins_roletypeid_foreign` (`RoleTypeID`),
  KEY `admins_sextypeid_foreign` (`SexTypeID`),
  CONSTRAINT `admins_roletypeid_foreign` FOREIGN KEY (`RoleTypeID`) REFERENCES `role_types` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `admins_sextypeid_foreign` FOREIGN KEY (`SexTypeID`) REFERENCES `sex_types` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES
('a00000','$2y$10$GodLuckCrackingThePW6uQqaUtlDBvsrAK8l/Bvp4doDoJR4ljyW','Krisztián','Rába','kikimano2001@gmail.com',1,9730,'a00000','2017-06-23','06304206110',1,'2024-04-28 20:18:36',1,0,1,0,'2024-03-09 13:14:55','2024-04-28 19:18:36'),
('a6q8j2y5','$2y$10$GodLuckCrackingThePW6uQqaUtlDBvsrAK8l/Bvp4doDoJR4ljyW','fefew','frew','kikimano2001@gmail.com',1,9730,'a00000','2017-06-01','06304206110',1,'2024-04-23 15:48:08',1,0,1,1,'2024-04-23 14:48:08','2024-04-23 14:48:08');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banned_i_p_s`
--

DROP TABLE IF EXISTS `banned_i_p_s`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banned_i_p_s` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `clientID` varchar(255) DEFAULT NULL,
  `UUIDBanned` tinyint(1) DEFAULT NULL,
  `clientIP` varchar(255) DEFAULT NULL,
  `IPBanned` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banned_i_p_s`
--

LOCK TABLES `banned_i_p_s` WRITE;
/*!40000 ALTER TABLE `banned_i_p_s` DISABLE KEYS */;
INSERT INTO `banned_i_p_s` VALUES
(1,'706bba53-02ed-47ec-8bcd-026347b66c1c',0,'127.0.0.1',0,'2024-03-09 13:40:56','2024-04-02 20:05:46'),
(3,'',0,'192.168.1.8',1,'2024-04-23 16:07:18','2024-04-23 16:08:52');
/*!40000 ALTER TABLE `banned_i_p_s` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banner_msgs`
--

DROP TABLE IF EXISTS `banner_msgs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banner_msgs` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `messageTypeID` bigint(20) unsigned NOT NULL,
  `Header` varchar(255) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `ImagePath` varchar(255) DEFAULT NULL,
  `Enabled` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `banner_msgs_messagetypeid_foreign` (`messageTypeID`),
  CONSTRAINT `banner_msgs_messagetypeid_foreign` FOREIGN KEY (`messageTypeID`) REFERENCES `bannertypes` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banner_msgs`
--

LOCK TABLES `banner_msgs` WRITE;
/*!40000 ALTER TABLE `banner_msgs` DISABLE KEYS */;
/*!40000 ALTER TABLE `banner_msgs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bannertypes`
--

DROP TABLE IF EXISTS `bannertypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bannertypes` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `typename` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bannertypes`
--

LOCK TABLES `bannertypes` WRITE;
/*!40000 ALTER TABLE `bannertypes` DISABLE KEYS */;
/*!40000 ALTER TABLE `bannertypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendar_events`
--

DROP TABLE IF EXISTS `calendar_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar_events` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `CreatedByID` varchar(6) NOT NULL,
  `StartDateTime` datetime NOT NULL,
  `EndDateTime` datetime NOT NULL,
  `Enabled` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar_events`
--

LOCK TABLES `calendar_events` WRITE;
/*!40000 ALTER TABLE `calendar_events` DISABLE KEYS */;
/*!40000 ALTER TABLE `calendar_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classes_lessons`
--

DROP TABLE IF EXISTS `classes_lessons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classes_lessons` (
  `ClassID` bigint(20) unsigned NOT NULL,
  `LessonID` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `classes_lessons_classid_lessonid_unique` (`ClassID`,`LessonID`),
  KEY `classes_lessons_lessonid_foreign` (`LessonID`),
  CONSTRAINT `classes_lessons_classid_foreign` FOREIGN KEY (`ClassID`) REFERENCES `school_classes` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `classes_lessons_lessonid_foreign` FOREIGN KEY (`LessonID`) REFERENCES `lessons` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes_lessons`
--

LOCK TABLES `classes_lessons` WRITE;
/*!40000 ALTER TABLE `classes_lessons` DISABLE KEYS */;
INSERT INTO `classes_lessons` VALUES
(1,1,'2024-03-18 21:06:22','2024-03-18 21:06:22'),
(1,3,'2024-03-18 21:04:34','2024-03-18 21:04:34');
/*!40000 ALTER TABLE `classes_lessons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grade_types`
--

DROP TABLE IF EXISTS `grade_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grade_types` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) NOT NULL,
  `Value` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grade_types`
--

LOCK TABLES `grade_types` WRITE;
/*!40000 ALTER TABLE `grade_types` DISABLE KEYS */;
INSERT INTO `grade_types` VALUES
(2,'Jeles','5',NULL,NULL),
(3,'Jó','4',NULL,NULL),
(4,'Közepes','3','2024-03-27 20:28:06','2024-03-27 20:28:06');
/*!40000 ALTER TABLE `grade_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grades`
--

DROP TABLE IF EXISTS `grades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grades` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `DateTime` datetime NOT NULL,
  `LessonID` bigint(20) unsigned NOT NULL,
  `StudentID` varchar(8) NOT NULL,
  `GradeTypeID` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `grades_studentid_foreign` (`StudentID`),
  KEY `grades_lessonid_foreign` (`LessonID`),
  KEY `grades_gradetypeid_foreign` (`GradeTypeID`),
  CONSTRAINT `grades_gradetypeid_foreign` FOREIGN KEY (`GradeTypeID`) REFERENCES `grade_types` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `grades_lessonid_foreign` FOREIGN KEY (`LessonID`) REFERENCES `lessons` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `grades_studentid_foreign` FOREIGN KEY (`StudentID`) REFERENCES `students` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grades`
--

LOCK TABLES `grades` WRITE;
/*!40000 ALTER TABLE `grades` DISABLE KEYS */;
INSERT INTO `grades` VALUES
(2,'2024-04-10 19:38:32',4,'s7y2u4e3',2,NULL,NULL),
(3,'2024-03-27 19:38:32',4,'s7y2u4e3',2,NULL,NULL),
(10,'2024-03-27 21:37:36',3,'s7y2u4e3',3,'2024-03-27 21:37:36','2024-03-27 21:37:36'),
(11,'2024-03-27 21:40:38',4,'s9g5a1s4',4,'2024-03-27 21:40:38','2024-03-27 21:40:38'),
(12,'2024-03-27 21:40:45',4,'s9g5a1s4',4,'2024-03-27 21:40:45','2024-03-27 22:34:59');
/*!40000 ALTER TABLE `grades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `head_users`
--

DROP TABLE IF EXISTS `head_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `head_users` (
  `UserID` varchar(8) NOT NULL,
  `password` varchar(60) NOT NULL,
  `FName` varchar(50) NOT NULL,
  `LName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `SexTypeID` smallint(5) unsigned NOT NULL,
  `PostalCode` smallint(5) unsigned NOT NULL,
  `FullAddress` varchar(255) NOT NULL,
  `BDay` date NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `RoleTypeID` bigint(20) unsigned NOT NULL,
  `LastLogin` datetime NOT NULL,
  `AllowMessages` tinyint(1) NOT NULL DEFAULT 1,
  `BannedFromMessages` tinyint(1) NOT NULL DEFAULT 0,
  `Enabled` tinyint(1) NOT NULL DEFAULT 1,
  `DefaultPassword` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`UserID`),
  KEY `head_users_roletypeid_foreign` (`RoleTypeID`),
  KEY `head_users_sextypeid_foreign` (`SexTypeID`),
  CONSTRAINT `head_users_roletypeid_foreign` FOREIGN KEY (`RoleTypeID`) REFERENCES `role_types` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `head_users_sextypeid_foreign` FOREIGN KEY (`SexTypeID`) REFERENCES `sex_types` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `head_users`
--

LOCK TABLES `head_users` WRITE;
/*!40000 ALTER TABLE `head_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `head_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `home_work_students`
--

DROP TABLE IF EXISTS `home_work_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `home_work_students` (
  `StudentID` varchar(8) NOT NULL,
  `HomeWorkID` bigint(20) unsigned NOT NULL,
  `Done` tinyint(1) NOT NULL DEFAULT 0,
  `SubmitDateTime` datetime NOT NULL,
  `FileName` varchar(255) DEFAULT NULL,
  `Answer` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `home_work_students_studentid_homeworkid_unique` (`StudentID`,`HomeWorkID`),
  KEY `home_work_students_homeworkid_foreign` (`HomeWorkID`),
  CONSTRAINT `home_work_students_homeworkid_foreign` FOREIGN KEY (`HomeWorkID`) REFERENCES `home_works` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `home_work_students_studentid_foreign` FOREIGN KEY (`StudentID`) REFERENCES `students` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_work_students`
--

LOCK TABLES `home_work_students` WRITE;
/*!40000 ALTER TABLE `home_work_students` DISABLE KEYS */;
INSERT INTO `home_work_students` VALUES
('s7y2u4e3',1,1,'2024-04-18 21:16:56','s7y2u4e3_MicroSD_Case.bin',NULL,'2024-04-18 20:16:56','2024-04-18 20:16:56'),
('s7y2u4e3',2,1,'2024-04-18 21:16:11','s7y2u4e3_rufus.txt',NULL,'2024-04-18 20:16:11','2024-04-18 20:16:11'),
('s7y2u4e3',3,1,'2024-04-18 21:30:13',NULL,'Fasza','2024-04-18 20:30:13','2024-04-18 20:30:13');
/*!40000 ALTER TABLE `home_work_students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `home_works`
--

DROP TABLE IF EXISTS `home_works`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `home_works` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `LessonID` bigint(20) unsigned NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `StartDateTime` datetime NOT NULL,
  `EndDateTime` datetime NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `home_works_lessonid_foreign` (`LessonID`),
  CONSTRAINT `home_works_lessonid_foreign` FOREIGN KEY (`LessonID`) REFERENCES `lessons` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_works`
--

LOCK TABLES `home_works` WRITE;
/*!40000 ALTER TABLE `home_works` DISABLE KEYS */;
INSERT INTO `home_works` VALUES
(1,3,'Pizzázás','nyami','2024-03-11 18:48:44','2024-04-20 19:48:44',1,NULL,NULL),
(2,1,'Sörözés','gludóval','2024-03-12 11:40:00','2024-03-31 20:45:00',1,'2024-03-29 20:40:20','2024-03-29 20:51:50'),
(3,1,'jeje','gfd','2024-04-24 21:05:00','2024-05-04 21:05:00',1,'2024-04-17 20:05:29','2024-04-17 20:05:29'),
(4,3,'fd','gfd','2024-04-23 19:48:00','2024-05-05 19:48:00',1,'2024-04-18 18:49:03','2024-04-18 18:49:03'),
(5,3,'fd','gfd','2024-04-23 19:48:00','2024-05-05 19:48:00',1,'2024-04-18 18:49:26','2024-04-18 18:49:26');
/*!40000 ALTER TABLE `home_works` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lates_missings`
--

DROP TABLE IF EXISTS `lates_missings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lates_missings` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `LessonID` bigint(20) unsigned NOT NULL,
  `StudentID` varchar(8) NOT NULL,
  `MissedMinute` smallint(5) unsigned NOT NULL,
  `DateTime` datetime NOT NULL,
  `Verified` tinyint(1) NOT NULL DEFAULT 0,
  `VerifiedByID` varchar(8) DEFAULT NULL,
  `VerificationTypeID` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `lates_missings_studentid_foreign` (`StudentID`),
  KEY `lates_missings_lessonid_foreign` (`LessonID`),
  KEY `lates_missings_verificationtypeid_foreign` (`VerificationTypeID`),
  CONSTRAINT `lates_missings_lessonid_foreign` FOREIGN KEY (`LessonID`) REFERENCES `lessons` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lates_missings_studentid_foreign` FOREIGN KEY (`StudentID`) REFERENCES `students` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lates_missings_verificationtypeid_foreign` FOREIGN KEY (`VerificationTypeID`) REFERENCES `verification_types` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lates_missings`
--

LOCK TABLES `lates_missings` WRITE;
/*!40000 ALTER TABLE `lates_missings` DISABLE KEYS */;
INSERT INTO `lates_missings` VALUES
(2,1,'s9g5a1s4',10,'2024-04-25 21:41:16',1,'a00000',1,'2024-04-25 20:41:16','2024-04-25 20:41:16'),
(3,1,'s7y2u4e3',5,'2024-04-25 21:44:10',0,NULL,NULL,'2024-04-25 20:44:10','2024-04-25 20:44:10'),
(4,1,'s9g5a1s4',20,'2024-04-25 21:45:38',1,'a00000',1,'2024-04-25 20:45:38','2024-04-25 20:45:38'),
(5,1,'s7y2u4e3',30,'2024-04-25 21:45:38',1,'p0q4a7k0',4,'2024-04-25 20:45:38','2024-04-27 20:31:12'),
(6,1,'s9g5a1s4',2,'2024-04-25 21:45:49',1,'a00000',1,'2024-04-25 20:45:49','2024-04-25 20:46:20');
/*!40000 ALTER TABLE `lates_missings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lessons`
--

DROP TABLE IF EXISTS `lessons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lessons` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `SubjectID` bigint(20) unsigned NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `Minutes` int(11) NOT NULL,
  `WeeklyTimes` text NOT NULL,
  `TeacherID` varchar(8) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `lessons_teacherid_foreign` (`TeacherID`),
  KEY `lessons_subjectid_foreign` (`SubjectID`),
  CONSTRAINT `lessons_subjectid_foreign` FOREIGN KEY (`SubjectID`) REFERENCES `subjects` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lessons_teacherid_foreign` FOREIGN KEY (`TeacherID`) REFERENCES `teachers` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lessons`
--

LOCK TABLES `lessons` WRITE;
/*!40000 ALTER TABLE `lessons` DISABLE KEYS */;
INSERT INTO `lessons` VALUES
(1,2,'2024-03-11','2024-03-23',65,'a:7:{s:6:\"Monday\";s:5:\"00:10\";s:7:\"Tuesday\";N;s:9:\"Wednesday\";N;s:8:\"Thursday\";N;s:6:\"Friday\";N;s:8:\"Saturday\";N;s:6:\"Sunday\";N;}','t9p6c2r2',0,'2024-03-13 20:10:15','2024-03-13 21:46:08'),
(3,1,'2024-03-06','2024-04-06',43,'a:7:{s:6:\"Monday\";s:5:\"01:25\";s:7:\"Tuesday\";s:5:\"21:33\";s:9:\"Wednesday\";N;s:8:\"Thursday\";N;s:6:\"Friday\";N;s:8:\"Saturday\";N;s:6:\"Sunday\";N;}','t2e2m8g2',1,'2024-03-13 21:27:41','2024-03-13 21:46:15'),
(4,2,'2024-03-05','2024-04-02',95,'a:7:{s:6:\"Monday\";s:5:\"06:46\";s:7:\"Tuesday\";s:5:\"08:46\";s:9:\"Wednesday\";s:5:\"13:50\";s:8:\"Thursday\";N;s:6:\"Friday\";N;s:8:\"Saturday\";N;s:6:\"Sunday\";N;}','t5i0i5g3',1,'2024-03-13 21:46:53','2024-03-13 21:46:57');
/*!40000 ALTER TABLE `lessons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `SenderID` varchar(8) NOT NULL,
  `TargetID` varchar(8) NOT NULL,
  `Message` varchar(255) NOT NULL,
  `SentDateTime` datetime NOT NULL,
  `Flagged` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES
(4,'a00000','t5i0i5g3','Halika','2024-03-29 21:18:56',0,'2024-03-29 21:18:56','2024-03-29 21:18:56');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'2019_08_19_000000_create_failed_jobs_table',1),
(2,'2019_12_14_000001_create_personal_access_tokens_table',1),
(3,'2023_07_17_193232_create_role_types_table',1),
(4,'2023_07_17_193232_create_sex_types_table',1),
(5,'2023_07_17_193233_create_admins_table',1),
(6,'2023_07_17_193234_create_stud_parents_table',1),
(7,'2023_07_17_193251_create_students_table',1),
(8,'2023_07_17_193303_create_teachers_table',1),
(9,'2023_07_17_193511_create_student_parents_table',1),
(10,'2023_07_17_193614_create_school_classes_table',1),
(11,'2023_07_17_193639_create_students_classes_table',1),
(12,'2023_07_17_193700_create_subjects_table',1),
(13,'2023_07_17_193710_create_lessons_table',1),
(14,'2023_07_17_193740_create_verification_types_table',1),
(16,'2023_07_17_193805_create_grade_types_table',1),
(17,'2023_07_17_193809_create_grades_table',1),
(19,'2023_07_17_193839_create_home_works_table',1),
(21,'2023_07_17_193918_create_school_infos_table',1),
(22,'2023_07_17_193930_create_bannertypes_table',1),
(23,'2023_07_17_193931_create_banner_msgs_table',1),
(24,'2023_07_17_193956_create_messages_table',1),
(25,'2023_07_17_194110_create_calendar_events_table',1),
(26,'2023_07_17_194129_create_push_subs_table',1),
(27,'2023_07_17_200232_create_head_users_table',1),
(28,'2023_07_18_194406_create_who_can_see_events_table',1),
(29,'2023_07_21_190608_create_classes_lessons_table',1),
(30,'2023_07_25_024249_create_banned_i_p_s_table',1),
(31,'2023_08_31_212737_create_public_permissions_types_table',1),
(32,'2023_08_31_212743_create_public_permissions_table',1),
(33,'2023_12_18_202450_2023_07_17_193233_create_admins_table',1),
(34,'2023_12_18_202704_2023_07_17_193233_create_admins_table',1),
(35,'2023_07_17_193825_create_warnings_table',2),
(36,'2023_07_17_193856_create_home_work_students_table',3),
(37,'2023_07_17_193756_create_lates_missings_table',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `public_permissions`
--

DROP TABLE IF EXISTS `public_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `public_permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(3) unsigned NOT NULL,
  `PermissionType` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `public_permissions_permissiontype_foreign` (`PermissionType`),
  CONSTRAINT `public_permissions_permissiontype_foreign` FOREIGN KEY (`PermissionType`) REFERENCES `public_permissions_types` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `public_permissions`
--

LOCK TABLES `public_permissions` WRITE;
/*!40000 ALTER TABLE `public_permissions` DISABLE KEYS */;
INSERT INTO `public_permissions` VALUES
(1,0,1,'2024-03-09 13:14:07','2024-03-09 13:14:07');
/*!40000 ALTER TABLE `public_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `public_permissions_types`
--

DROP TABLE IF EXISTS `public_permissions_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `public_permissions_types` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `RoleName` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `public_permissions_types`
--

LOCK TABLES `public_permissions_types` WRITE;
/*!40000 ALTER TABLE `public_permissions_types` DISABLE KEYS */;
INSERT INTO `public_permissions_types` VALUES
(1,'EnableOverallLogin','2024-03-09 13:14:07','2024-03-09 13:14:07');
/*!40000 ALTER TABLE `public_permissions_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `push_subs`
--

DROP TABLE IF EXISTS `push_subs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `push_subs` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ClientID` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `push_subs`
--

LOCK TABLES `push_subs` WRITE;
/*!40000 ALTER TABLE `push_subs` DISABLE KEYS */;
/*!40000 ALTER TABLE `push_subs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_types`
--

DROP TABLE IF EXISTS `role_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_types` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) NOT NULL,
  `Description` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_types`
--

LOCK TABLES `role_types` WRITE;
/*!40000 ALTER TABLE `role_types` DISABLE KEYS */;
INSERT INTO `role_types` VALUES
(1,'Admin','Minden kezelő','2024-03-09 13:14:07','2024-03-29 20:58:01'),
(2,'Tanár',NULL,'2024-03-09 13:15:43','2024-03-09 13:15:43'),
(3,'Diák',NULL,'2024-03-09 13:22:43','2024-03-09 13:22:43'),
(4,'Közepes',NULL,'2024-03-27 20:26:21','2024-03-27 20:26:21'),
(5,'hrt',NULL,'2024-03-28 19:55:16','2024-03-28 19:55:16'),
(6,'Szülő',NULL,'2024-04-26 19:03:05','2024-04-26 19:03:05'),
(7,'',NULL,'2024-04-26 19:20:54','2024-04-26 19:20:54'),
(8,'',NULL,'2024-04-26 19:22:11','2024-04-26 19:22:11'),
(9,'',NULL,'2024-04-26 19:23:00','2024-04-26 19:23:00');
/*!40000 ALTER TABLE `role_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school_classes`
--

DROP TABLE IF EXISTS `school_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school_classes` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) NOT NULL,
  `ClassMasterID` varchar(8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `school_classes_classmasterid_foreign` (`ClassMasterID`),
  CONSTRAINT `school_classes_classmasterid_foreign` FOREIGN KEY (`ClassMasterID`) REFERENCES `teachers` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school_classes`
--

LOCK TABLES `school_classes` WRITE;
/*!40000 ALTER TABLE `school_classes` DISABLE KEYS */;
INSERT INTO `school_classes` VALUES
(1,'IncidenVégzősök','t2e2m8g2','2024-03-09 13:22:31','2024-03-29 20:12:05'),
(2,'nagyok','t9p6c2r2','2024-04-09 19:40:41','2024-04-28 15:02:12'),
(3,'dimat osztály','t2e2m8g2','2024-04-28 15:18:57','2024-04-28 15:18:57');
/*!40000 ALTER TABLE `school_classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school_infos`
--

DROP TABLE IF EXISTS `school_infos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school_infos` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `SchoolNumber` int(11) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PostalCode` smallint(5) unsigned NOT NULL,
  `FullAddress` varchar(255) NOT NULL,
  `Text1` varchar(255) NOT NULL,
  `Text2` varchar(255) NOT NULL,
  `Number1` int(11) NOT NULL,
  `Number2` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school_infos`
--

LOCK TABLES `school_infos` WRITE;
/*!40000 ALTER TABLE `school_infos` DISABLE KEYS */;
/*!40000 ALTER TABLE `school_infos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sex_types`
--

DROP TABLE IF EXISTS `sex_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sex_types` (
  `ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) NOT NULL,
  `Description` varchar(200) DEFAULT NULL,
  `Title` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sex_types`
--

LOCK TABLES `sex_types` WRITE;
/*!40000 ALTER TABLE `sex_types` DISABLE KEYS */;
INSERT INTO `sex_types` VALUES
(1,'Férfi','Férfinak születtet, férfinak nevezi magát','Mr.','2024-03-09 13:14:07','2024-03-09 13:14:07'),
(2,'Nő','Nőnek született nőnek nevezi magát','Mrs.','2024-03-09 13:14:07','2024-03-09 13:14:07');
/*!40000 ALTER TABLE `sex_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stud_parents`
--

DROP TABLE IF EXISTS `stud_parents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stud_parents` (
  `UserID` varchar(8) NOT NULL,
  `password` varchar(60) NOT NULL,
  `FName` varchar(50) NOT NULL,
  `LName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `SexTypeID` smallint(5) unsigned NOT NULL,
  `PostalCode` smallint(5) unsigned NOT NULL,
  `FullAddress` varchar(255) NOT NULL,
  `BDay` date NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `RoleTypeID` bigint(20) unsigned NOT NULL,
  `LastLogin` datetime NOT NULL,
  `AllowMessages` tinyint(1) NOT NULL DEFAULT 1,
  `BannedFromMessages` tinyint(1) NOT NULL DEFAULT 0,
  `Enabled` tinyint(1) NOT NULL DEFAULT 1,
  `DefaultPassword` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`UserID`),
  KEY `stud_parents_roletypeid_foreign` (`RoleTypeID`),
  KEY `stud_parents_sextypeid_foreign` (`SexTypeID`),
  CONSTRAINT `stud_parents_roletypeid_foreign` FOREIGN KEY (`RoleTypeID`) REFERENCES `role_types` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `stud_parents_sextypeid_foreign` FOREIGN KEY (`SexTypeID`) REFERENCES `sex_types` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stud_parents`
--

LOCK TABLES `stud_parents` WRITE;
/*!40000 ALTER TABLE `stud_parents` DISABLE KEYS */;
INSERT INTO `stud_parents` VALUES
('p0q4a7k0','$2y$10$GodLuckCrackingThePW6uQqaUtlDBvsrAK8l/Bvp4doDoJR4ljyW','kis','jani','gfdgdfbg@gmail.com',1,9730,'a00000','2017-01-04','06304206110',6,'2024-04-27 19:21:35',1,0,1,0,'2024-04-26 19:05:33','2024-04-27 18:21:35');
/*!40000 ALTER TABLE `stud_parents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_parents`
--

DROP TABLE IF EXISTS `student_parents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_parents` (
  `StudentID` varchar(8) NOT NULL,
  `ParentID` varchar(8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `student_parents_studentid_parentid_unique` (`StudentID`,`ParentID`),
  KEY `student_parents_parentid_foreign` (`ParentID`),
  CONSTRAINT `student_parents_parentid_foreign` FOREIGN KEY (`ParentID`) REFERENCES `stud_parents` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `student_parents_studentid_foreign` FOREIGN KEY (`StudentID`) REFERENCES `students` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_parents`
--

LOCK TABLES `student_parents` WRITE;
/*!40000 ALTER TABLE `student_parents` DISABLE KEYS */;
INSERT INTO `student_parents` VALUES
('s7y2u4e3','p0q4a7k0','2024-04-26 19:25:43','2024-04-26 19:25:43'),
('s9g5a1s4','p0q4a7k0','2024-04-26 19:25:36','2024-04-26 19:25:36');
/*!40000 ALTER TABLE `student_parents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `UserID` varchar(8) NOT NULL,
  `password` varchar(60) NOT NULL,
  `FName` varchar(50) NOT NULL,
  `LName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `SexTypeID` smallint(5) unsigned NOT NULL,
  `PostalCode` smallint(5) unsigned NOT NULL,
  `FullAddress` varchar(255) NOT NULL,
  `BDay` date NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `RoleTypeID` bigint(20) unsigned NOT NULL,
  `LastLogin` datetime NOT NULL,
  `AllowMessages` tinyint(1) NOT NULL DEFAULT 1,
  `BannedFromMessages` tinyint(1) NOT NULL DEFAULT 0,
  `Enabled` tinyint(1) NOT NULL DEFAULT 1,
  `DefaultPassword` tinyint(1) NOT NULL DEFAULT 1,
  `BPlace` varchar(255) NOT NULL,
  `StudentCardNum` int(11) NOT NULL,
  `StudentTeachID` int(11) NOT NULL,
  `RemainedParentVerification` smallint(5) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `students_studentcardnum_unique` (`StudentCardNum`),
  UNIQUE KEY `students_studentteachid_unique` (`StudentTeachID`),
  KEY `students_roletypeid_foreign` (`RoleTypeID`),
  KEY `students_sextypeid_foreign` (`SexTypeID`),
  CONSTRAINT `students_roletypeid_foreign` FOREIGN KEY (`RoleTypeID`) REFERENCES `role_types` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `students_sextypeid_foreign` FOREIGN KEY (`SexTypeID`) REFERENCES `sex_types` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES
('s7y2u4e3','$2y$10$GodLuckCrackingThePW6ukvxZRprIoKIGB9fUK.yT1mUdXMszBua','Krisztián','Rába','kikimano2001@gmail.com',1,9730,'a00000','2017-06-01','06304206110',3,'2024-04-28 19:42:32',1,0,1,0,'ztr',546,645,2,'2024-03-09 13:22:52','2024-04-28 18:42:32'),
('s9g5a1s4','$2y$10$GodLuckCrackingThePW6uQqaUtlDBvsrAK8l/Bvp4doDoJR4ljyW','ht','zhrt','trzhr@gmail.com',2,6577,'zhdrftg','2017-06-01','65',3,'2024-03-18 19:24:13',1,0,1,1,'54hrftg',645,6435,3,'2024-03-18 19:24:13','2024-03-18 19:24:13');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students_classes`
--

DROP TABLE IF EXISTS `students_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students_classes` (
  `ClassID` bigint(20) unsigned NOT NULL,
  `StudentID` varchar(8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `students_classes_studentid_classid_unique` (`StudentID`,`ClassID`),
  KEY `students_classes_classid_foreign` (`ClassID`),
  CONSTRAINT `students_classes_classid_foreign` FOREIGN KEY (`ClassID`) REFERENCES `school_classes` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `students_classes_studentid_foreign` FOREIGN KEY (`StudentID`) REFERENCES `students` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students_classes`
--

LOCK TABLES `students_classes` WRITE;
/*!40000 ALTER TABLE `students_classes` DISABLE KEYS */;
INSERT INTO `students_classes` VALUES
(1,'s7y2u4e3',NULL,NULL);
/*!40000 ALTER TABLE `students_classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subjects` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES
(1,'Dimat','unalmas','2024-03-11 18:53:35','2024-03-29 20:12:41'),
(2,'ókori izék','régiségek','2024-03-11 18:56:20','2024-03-11 18:56:20');
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teachers` (
  `UserID` varchar(8) NOT NULL,
  `password` varchar(60) NOT NULL,
  `FName` varchar(50) NOT NULL,
  `LName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `SexTypeID` smallint(5) unsigned NOT NULL,
  `PostalCode` smallint(5) unsigned NOT NULL,
  `FullAddress` varchar(255) NOT NULL,
  `BDay` date NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `RoleTypeID` bigint(20) unsigned NOT NULL,
  `LastLogin` datetime NOT NULL,
  `AllowMessages` tinyint(1) NOT NULL DEFAULT 1,
  `BannedFromMessages` tinyint(1) NOT NULL DEFAULT 0,
  `Enabled` tinyint(1) NOT NULL DEFAULT 1,
  `DefaultPassword` tinyint(1) NOT NULL DEFAULT 1,
  `TeachID` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `teachers_teachid_unique` (`TeachID`),
  KEY `teachers_roletypeid_foreign` (`RoleTypeID`),
  KEY `teachers_sextypeid_foreign` (`SexTypeID`),
  CONSTRAINT `teachers_roletypeid_foreign` FOREIGN KEY (`RoleTypeID`) REFERENCES `role_types` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `teachers_sextypeid_foreign` FOREIGN KEY (`SexTypeID`) REFERENCES `sex_types` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachers`
--

LOCK TABLES `teachers` WRITE;
/*!40000 ALTER TABLE `teachers` DISABLE KEYS */;
INSERT INTO `teachers` VALUES
('t2e2m8g2','$2y$10$GodLuckCrackingThePW6uQqaUtlDBvsrAK8l/Bvp4doDoJR4ljyW','Farkas','Gábor','kikimano2001@gmail.com',1,9730,'tzgjhugrf','2017-06-01','06304206110',2,'2024-03-09 13:50:22',1,0,1,1,7456,'2024-03-09 13:50:22','2024-03-29 20:12:24'),
('t5i0i5g3','$2y$10$GodLuckCrackingThePW6uPTidoHCaZEEmfgIiA1zztYMpAWkr.Vq','soos','sanyi','tzhrez@gmail.com',1,5466,'hgrtfzg45','2017-06-21','6546',2,'2024-03-09 13:16:31',1,0,1,1,4325324,'2024-03-09 13:16:31','2024-03-18 21:06:01'),
('t9p6c2r2','$2y$10$GodLuckCrackingThePW6uQqaUtlDBvsrAK8l/Bvp4doDoJR4ljyW','Rába','Krisztián','rabakiki2001@gmail.com',1,9730,'a00000','2017-06-01','06304206110',2,'2024-04-26 19:31:54',1,0,1,0,45,'2024-03-09 13:50:03','2024-04-26 18:32:04');
/*!40000 ALTER TABLE `teachers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `verification_types`
--

DROP TABLE IF EXISTS `verification_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `verification_types` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) NOT NULL,
  `Description` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verification_types`
--

LOCK TABLES `verification_types` WRITE;
/*!40000 ALTER TABLE `verification_types` DISABLE KEYS */;
INSERT INTO `verification_types` VALUES
(1,'Orvosi igazolás','Doktor által igazolt hiányzás','2024-04-25 18:47:43','2024-04-25 18:58:44'),
(4,'Szülői igazolás','Szülő által igazolt hiányzás',NULL,NULL);
/*!40000 ALTER TABLE `verification_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `warnings`
--

DROP TABLE IF EXISTS `warnings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `warnings` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `DateTime` datetime NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `WhoGaveID` varchar(8) NOT NULL,
  `StudentID` varchar(8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `warnings_studentid_foreign` (`StudentID`),
  CONSTRAINT `warnings_studentid_foreign` FOREIGN KEY (`StudentID`) REFERENCES `students` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warnings`
--

LOCK TABLES `warnings` WRITE;
/*!40000 ALTER TABLE `warnings` DISABLE KEYS */;
INSERT INTO `warnings` VALUES
(4,'2024-04-16 20:16:26','Futás','retg','a00000','s7y2u4e3','2024-04-16 18:23:49','2024-04-16 19:16:26');
/*!40000 ALTER TABLE `warnings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `who_can_see_events`
--

DROP TABLE IF EXISTS `who_can_see_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `who_can_see_events` (
  `RoleTypeID` bigint(20) unsigned NOT NULL,
  `CalendaerEventID` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `who_can_see_events_roletypeid_calendaereventid_unique` (`RoleTypeID`,`CalendaerEventID`),
  KEY `who_can_see_events_calendaereventid_foreign` (`CalendaerEventID`),
  CONSTRAINT `who_can_see_events_calendaereventid_foreign` FOREIGN KEY (`CalendaerEventID`) REFERENCES `calendar_events` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `who_can_see_events_roletypeid_foreign` FOREIGN KEY (`RoleTypeID`) REFERENCES `role_types` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `who_can_see_events`
--

LOCK TABLES `who_can_see_events` WRITE;
/*!40000 ALTER TABLE `who_can_see_events` DISABLE KEYS */;
/*!40000 ALTER TABLE `who_can_see_events` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2024-04-28 20:49:28
