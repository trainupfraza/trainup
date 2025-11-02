/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-12.0.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: train_up
-- ------------------------------------------------------
-- Server version	12.0.2-MariaDB

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

-- Create and use the database
DROP DATABASE IF EXISTS `train_up`;
CREATE DATABASE `train_up`;
USE `train_up`;

--
-- Table structure for table `cycling_activities`
--

DROP TABLE IF EXISTS `cycling_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cycling_activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `distance` double NOT NULL,
  `time_minutes` double NOT NULL,
  `weather` enum('SUNNY','CLOUDY','WINDY','RAINY','HOT','COLD') NOT NULL,
  `bike_type` enum('RoadBike','MountainBike','HybridBike','ElectricBike') NOT NULL,
  `speed` double NOT NULL,
  `calories` double NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_cycling_user` (`user_id`),
  CONSTRAINT `fk_cycling_user` FOREIGN KEY (`user_id`) REFERENCES `train_up_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cycling_activities`
--

LOCK TABLES `cycling_activities` WRITE;
/*!40000 ALTER TABLE `cycling_activities` DISABLE KEYS */;
INSERT INTO `cycling_activities` VALUES
(1,1,78,45,'WINDY','HybridBike',104,6.80625,'me is cool','2025-10-07 22:29:15'),
(2,1,45,3,'RAINY','ElectricBike',900,0.25875,'4','2025-10-09 09:21:07'),
(3,1,89,78,'SUNNY','RoadBike',68.46153846153845,9.75,'45','2025-10-10 16:19:27'),
(4,1,23,5,'SUNNY','RoadBike',276,0.625,'great','2025-10-12 07:05:25'),
(6,7,78,20,'WINDY','HybridBike',234,75.625,'vfas','2025-10-27 22:09:12'),
(7,7,4,45,'SUNNY','RoadBike',5.333333333333334,140.625,'1','2025-10-27 23:33:15');
/*!40000 ALTER TABLE `cycling_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goal_targets`
--

DROP TABLE IF EXISTS `goal_targets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `goal_targets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `goal_id` bigint(20) unsigned NOT NULL,
  `metric_key` varchar(100) NOT NULL,
  `value` double DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_goal_id` (`goal_id`),
  CONSTRAINT `fk_goaltargets_goal` FOREIGN KEY (`goal_id`) REFERENCES `goals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goal_targets`
--

LOCK TABLES `goal_targets` WRITE;
/*!40000 ALTER TABLE `goal_targets` DISABLE KEYS */;
INSERT INTO `goal_targets` VALUES
(2,2,'target_distance_km',90,'km','2025-10-10 16:23:08'),
(3,3,'target_time_minutes',50,'min','2025-10-10 19:50:31'),
(4,4,'target_weight_kg',45,'kg','2025-10-10 19:51:00'),
(5,5,'target_time_minutes',30,'min','2025-10-10 19:53:51'),
(7,7,'target_speed_mps',65,'m/s','2025-10-10 21:11:54'),
(8,8,'target_distance_km',5,'km','2025-10-10 22:30:51'),
(9,9,'target_time_minutes',78,'min','2025-10-10 23:56:49'),
(10,10,'target_distance_km',45,'km','2025-10-10 23:58:06'),
(11,11,'target_time_minutes',23,'min','2025-10-12 06:49:47'),
(12,12,'target_speed_kmh',45,'km','2025-10-12 06:50:10'),
(13,13,'target_distance_meters',34,'m','2025-10-12 06:50:25'),
(16,16,'target_time_minutes',23,'min','2025-10-12 06:50:43'),
(19,19,'target_distance_meters',89,'m','2025-10-27 17:21:34'),
(20,20,'target_sets',78,'sets','2025-10-27 17:22:58'),
(21,21,'target_distance_km',8,'km','2025-10-27 17:27:20'),
(22,21,'target_time_minutes',78,'min','2025-10-27 17:27:20'),
(23,21,'target_speed_kmh',45,'km','2025-10-27 17:27:20'),
(28,26,'target_speed_mps',45,'m/s','2025-10-27 22:13:19'),
(29,27,'target_speed_kmh',54,'km','2025-10-27 22:13:30'),
(30,28,'target_sets',4,'sets','2025-10-27 22:14:03'),
(31,29,'target_time_minutes',58,'min','2025-10-27 22:14:15'),
(32,30,'target_time_minutes',78,'min','2025-10-29 09:35:53');
/*!40000 ALTER TABLE `goal_targets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goals`
--

DROP TABLE IF EXISTS `goals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `goals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `activity_type` varchar(100) NOT NULL,
  `duration_option` varchar(100) DEFAULT NULL,
  `target_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('active','completed','cancelled') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  CONSTRAINT `fk_goals_user` FOREIGN KEY (`user_id`) REFERENCES `train_up_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goals`
--

LOCK TABLES `goals` WRITE;
/*!40000 ALTER TABLE `goals` DISABLE KEYS */;
INSERT INTO `goals` VALUES
(2,1,'Running','Today',NULL,'','active','2025-10-10 16:23:07'),
(3,1,'Running','In three months',NULL,'','active','2025-10-10 19:50:31'),
(4,1,'Weightlifting','Today',NULL,'','active','2025-10-10 19:51:00'),
(5,1,'Weightlifting','Today',NULL,'','active','2025-10-10 19:53:51'),
(7,1,'Swimming','In two weeks',NULL,'for  improved speed','active','2025-10-10 21:11:54'),
(8,1,'Running','Today',NULL,'po','active','2025-10-10 22:30:50'),
(9,1,'Yoga','In two weeks',NULL,'','active','2025-10-10 23:56:49'),
(10,1,'Cycling','In two weeks',NULL,'','active','2025-10-10 23:58:06'),
(11,1,'Yoga','Today',NULL,'','active','2025-10-12 06:49:47'),
(12,1,'Walking','Today',NULL,'','active','2025-10-12 06:50:10'),
(13,1,'Swimming','Today',NULL,'','active','2025-10-12 06:50:24'),
(16,1,'Running','Today',NULL,'','active','2025-10-12 06:50:42'),
(19,1,'Swimming','Today',NULL,'','active','2025-10-27 17:21:34'),
(20,1,'Weightlifting','Today',NULL,'','active','2025-10-27 17:22:58'),
(21,1,'Walking','Today',NULL,'yu','active','2025-10-27 17:27:20'),
(26,7,'Swimming','Today',NULL,'','active','2025-10-27 22:13:19'),
(27,7,'Running','Today',NULL,'','active','2025-10-27 22:13:29'),
(28,7,'Weightlifting','Today',NULL,'','active','2025-10-27 22:14:03'),
(29,7,'Yoga','In a month',NULL,'','active','2025-10-27 22:14:15'),
(30,7,'Yoga','Today',NULL,'98','active','2025-10-29 09:35:53');
/*!40000 ALTER TABLE `goals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `running_activities`
--

DROP TABLE IF EXISTS `running_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `running_activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `distance_km` double NOT NULL,
  `time_minutes` double NOT NULL,
  `weather` enum('SUNNY','CLOUDY','WINDY','RAINY','HOT','COLD') NOT NULL,
  `speed_kmh` double NOT NULL,
  `calories_burned` double NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_running_user` (`user_id`),
  CONSTRAINT `fk_running_user` FOREIGN KEY (`user_id`) REFERENCES `train_up_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `running_activities`
--

LOCK TABLES `running_activities` WRITE;
/*!40000 ALTER TABLE `running_activities` DISABLE KEYS */;
INSERT INTO `running_activities` VALUES
(2,1,8,67,'SUNNY',7.164179104477612,8.933333333333334,'what a journey','2025-10-07 20:09:21'),
(3,1,9,65,'SUNNY',8.307692307692308,8.666666666666666,'short note','2025-10-07 20:10:40'),
(4,1,56,21,'SUNNY',160,2.8,'huf','2025-10-07 20:21:57'),
(5,1,45,6,'RAINY',450,0.9199999999999999,'my note is grt','2025-10-07 22:26:43'),
(6,1,45,6,'RAINY',450,0.9199999999999999,'my note is grt','2025-10-07 22:26:44'),
(7,1,78,5,'HOT',936,0.7999999999999999,'rty','2025-10-07 22:28:01'),
(8,1,2,2,'RAINY',60,0.30666666666666664,'2','2025-10-09 09:19:51'),
(9,1,45,6,'SUNNY',450,0.8,'rere','2025-10-09 12:36:09'),
(10,1,7,8,'CLOUDY',52.5,1.12,'popo','2025-10-10 17:59:24'),
(11,1,78,2,'SUNNY',2340,0.26666666666666666,'yu','2025-10-10 22:19:37'),
(12,1,78,2,'SUNNY',2340,0.26666666666666666,'yu','2025-10-10 22:19:39'),
(13,1,23,45,'WINDY',30.666666666666664,6.6000000000000005,'wede','2025-10-11 00:02:43'),
(15,7,78,45,'HOT',104,180,'popo','2025-10-27 22:08:46'),
(16,7,89,45,'SUNNY',118.66666666666667,150,'20','2025-10-27 23:32:56'),
(17,7,45,24,'SUNNY',112.5,80,'12','2025-10-27 23:37:32');
/*!40000 ALTER TABLE `running_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `swimming_activities`
--

DROP TABLE IF EXISTS `swimming_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `swimming_activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `distance_meters` double NOT NULL,
  `time_minutes` double NOT NULL,
  `weather` varchar(20) NOT NULL,
  `stroke_type` enum('FREESTYLE','BREASTSTROKE','BACKSTROKE','BUTTERFLY') NOT NULL DEFAULT 'FREESTYLE',
  `speed_mps` double NOT NULL,
  `calories_burned` double NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_swimming_user` (`user_id`),
  CONSTRAINT `fk_swimming_user` FOREIGN KEY (`user_id`) REFERENCES `train_up_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `swimming_activities`
--

LOCK TABLES `swimming_activities` WRITE;
/*!40000 ALTER TABLE `swimming_activities` DISABLE KEYS */;
INSERT INTO `swimming_activities` VALUES
(1,1,45,60,'SUNNY','BUTTERFLY',0.0125,7.800000000000001,'','2025-10-09 09:16:32'),
(2,1,78,5,'SUNNY','FREESTYLE',0.26,0.5,'thj','2025-10-10 22:20:42'),
(3,1,9,5,'SUNNY','FREESTYLE',0.03,0.5,'','2025-10-12 16:30:53'),
(4,1,26,25,'SUNNY','FREESTYLE',0.017333333333333333,2.5,'','2025-10-12 16:34:34'),
(5,7,45,15,'HOT','BREASTSTROKE',0.05,53.99999999999999,'we','2025-10-27 22:10:06');
/*!40000 ALTER TABLE `swimming_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `train_up_users`
--

DROP TABLE IF EXISTS `train_up_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `train_up_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(200) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `weight` int(11) DEFAULT 45,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `train_up_users`
--

LOCK TABLES `train_up_users` WRITE;
/*!40000 ALTER TABLE `train_up_users` DISABLE KEYS */;
INSERT INTO `train_up_users` VALUES
(1,'francis zaunda','franciszaunda@gmail.com','Male','$2y$12$DS1Hz5I29p/bz6mf/piY4O0yt/E/9heUHJuehJIjjTZhwp/ThKXM6',45),
(2,'francis zaundaw','franciszaundaw@gmail.com','Male','$2y$12$tH7QR65.//oD/ey2Ufdas.NDcQ7DvXRAlXe3az22iUthVUOoE3Q1m',45),
(3,'james lon','wese@rete.com','Male','$2y$12$JGAR/3cMAfbC/ZR/mYDCA.sdE3lW4MAtUIlP8WzKvPi0TmyFaQ/XG',578),
(5,'popo','tyu@ju.mnb','Male','$2y$12$.gLNAVit0iWA.ag3YOS5luPUBIR7lmWb4BvAm3HtZ95.OvguOb1Cu',59),
(7,'wede rede','wede@mail.com','Male','$2y$12$E7difBtjiExm93omarWo2.Fe9sS2cc6RuddpPMEV7akBIFSI6CiY2',25);
/*!40000 ALTER TABLE `train_up_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `walking_activities`
--

DROP TABLE IF EXISTS `walking_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `walking_activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `distance_km` double NOT NULL,
  `time_minutes` double NOT NULL,
  `weather` varchar(20) NOT NULL,
  `speed_kmh` double NOT NULL,
  `calories_burned` double NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_walking_user` (`user_id`),
  CONSTRAINT `fk_walking_user` FOREIGN KEY (`user_id`) REFERENCES `train_up_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `walking_activities`
--

LOCK TABLES `walking_activities` WRITE;
/*!40000 ALTER TABLE `walking_activities` DISABLE KEYS */;
INSERT INTO `walking_activities` VALUES
(1,1,3,120,'CLOUDY',1.5,7.3500000000000005,'it was a nice walk','2025-10-09 09:14:49'),
(2,1,34,67,'SUNNY',30.44776119402985,3.908333333333333,'','2025-10-12 07:05:00'),
(3,7,2,50,'COLD',2.4,80.20833333333334,'slow','2025-10-27 22:10:24'),
(4,7,12,23,'SUNNY',31.304347826086957,33.54166666666667,'8','2025-10-27 23:37:13');
/*!40000 ALTER TABLE `walking_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `weightlifting_activities`
--

DROP TABLE IF EXISTS `weightlifting_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `weightlifting_activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `exercise_name` varchar(100) NOT NULL,
  `sets` int(11) NOT NULL,
  `reps` int(11) NOT NULL,
  `weight_kg` double NOT NULL,
  `time_minutes` double DEFAULT 0,
  `calories` double NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_weightlifting_user` (`user_id`),
  CONSTRAINT `fk_weightlifting_user` FOREIGN KEY (`user_id`) REFERENCES `train_up_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weightlifting_activities`
--

LOCK TABLES `weightlifting_activities` WRITE;
/*!40000 ALTER TABLE `weightlifting_activities` DISABLE KEYS */;
INSERT INTO `weightlifting_activities` VALUES
(1,1,'PULL_UP',3,2,45,40,5,'it was great','2025-10-09 09:19:03'),
(2,1,'OVERHEAD_PRESS',78,3,45,50,5.500000000000001,'lo2','2025-10-09 10:24:49'),
(3,1,'BENCH_PRESS',90,87,89,0,1.7999999999999998,'','2025-10-12 09:15:17'),
(4,7,'BENCH_PRESS',45,2,78,25,74.99999999999999,'dede','2025-10-27 22:09:35'),
(5,7,'SQUAT',2,1,78,21,51.1875,'12','2025-10-27 23:36:48');
/*!40000 ALTER TABLE `weightlifting_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yoga_activities`
--

DROP TABLE IF EXISTS `yoga_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `yoga_activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `session_type` varchar(100) NOT NULL,
  `duration_minutes` double NOT NULL,
  `intensity` enum('LOW','MEDIUM','HIGH') NOT NULL,
  `calories` double NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_yoga_user` (`user_id`),
  CONSTRAINT `fk_yoga_user` FOREIGN KEY (`user_id`) REFERENCES `train_up_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yoga_activities`
--

LOCK TABLES `yoga_activities` WRITE;
/*!40000 ALTER TABLE `yoga_activities` DISABLE KEYS */;
INSERT INTO `yoga_activities` VALUES
(1,1,'HATHA',78,'LOW',3.9000000000000004,'wede','2025-10-09 12:36:25'),
(2,1,'POWER',78,'MEDIUM',5.830500000000001,'yuhu','2025-10-09 13:11:43'),
(3,1,'POWER',50,'HIGH',4.6000000000000005,'good meditation','2025-10-10 22:17:59'),
(4,1,'HATHA',89,'LOW',4.45,'buiom','2025-10-10 23:52:53'),
(5,1,'HATHA',900,'LOW',45,'','2025-10-12 13:58:09'),
(8,7,'HATHA',78,'LOW',97.5,'hede','2025-10-27 22:05:36'),
(9,7,'HATHA',23,'LOW',28.750000000000004,'sed','2025-10-27 22:09:45'),
(10,7,'HATHA',65,'LOW',81.25,'','2025-10-29 09:38:03');
/*!40000 ALTER TABLE `yoga_activities` ENABLE KEYS */;
UNLOCK TABLES;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2025-11-01 22:39:52