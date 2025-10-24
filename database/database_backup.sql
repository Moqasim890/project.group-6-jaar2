DROP DATABASE IF EXISTS laravel;
CREATE DATABASE  IF NOT EXISTS `laravel` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `laravel`;
-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: laravel
-- ------------------------------------------------------
-- Server version	9.0.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bezoekers`
--

DROP TABLE IF EXISTS `bezoekers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bezoekers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Naam` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EmailAdres` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IsActief` tinyint(1) NOT NULL DEFAULT '1',
  `Opmerking` text COLLATE utf8mb4_unicode_ci,
  `DatumAangemaakt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DatumGewijzigd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bezoekers_emailadres_unique` (`EmailAdres`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bezoekers`
--

LOCK TABLES `bezoekers` WRITE;
/*!40000 ALTER TABLE `bezoekers` DISABLE KEYS */;
INSERT INTO `bezoekers` VALUES (1,'Gast','noreply@system.local',1,NULL,'2025-09-24 08:13:03','2025-10-15 17:55:13'),(2,'Test User','test@example.com',1,NULL,'2025-10-15 17:43:44','2025-10-15 17:43:44');
/*!40000 ALTER TABLE `bezoekers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_per_verkoper`
--

DROP TABLE IF EXISTS `contact_per_verkoper`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_per_verkoper` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `VerkoperId` bigint unsigned NOT NULL,
  `ContactpersoonId` bigint unsigned NOT NULL,
  `IsActief` tinyint(1) NOT NULL DEFAULT '1',
  `Opmerking` text COLLATE utf8mb4_unicode_ci,
  `DatumAangemaakt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DatumGewijzigd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contact_per_verkoper_verkoperid_contactpersoonid_unique` (`VerkoperId`,`ContactpersoonId`),
  KEY `contact_per_verkoper_contactpersoonid_foreign` (`ContactpersoonId`),
  CONSTRAINT `contact_per_verkoper_contactpersoonid_foreign` FOREIGN KEY (`ContactpersoonId`) REFERENCES `contactpersonen` (`id`) ON DELETE CASCADE,
  CONSTRAINT `contact_per_verkoper_verkoperid_foreign` FOREIGN KEY (`VerkoperId`) REFERENCES `verkopers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_per_verkoper`
--

LOCK TABLES `contact_per_verkoper` WRITE;
/*!40000 ALTER TABLE `contact_per_verkoper` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_per_verkoper` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contactpersonen`
--

DROP TABLE IF EXISTS `contactpersonen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contactpersonen` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Naam` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Telefoonnummer` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EmailAdres` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IsActief` tinyint(1) NOT NULL DEFAULT '1',
  `Opmerking` text COLLATE utf8mb4_unicode_ci,
  `DatumAangemaakt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DatumGewijzigd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contactpersonen_emailadres_unique` (`EmailAdres`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactpersonen`
--

LOCK TABLES `contactpersonen` WRITE;
/*!40000 ALTER TABLE `contactpersonen` DISABLE KEYS */;
/*!40000 ALTER TABLE `contactpersonen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evenements`
--

DROP TABLE IF EXISTS `evenements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evenements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Naam` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Datum` date NOT NULL,
  `Locatie` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `AantalTicketsPerTijdslot` int unsigned NOT NULL,
  `BeschikbareStands` int unsigned NOT NULL,
  `IsActief` tinyint(1) NOT NULL DEFAULT '1',
  `Opmerking` text COLLATE utf8mb4_unicode_ci,
  `DatumAangemaakt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DatumGewijzigd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `evenements_datum_index` (`Datum`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evenements`
--

LOCK TABLES `evenements` WRITE;
/*!40000 ALTER TABLE `evenements` DISABLE KEYS */;
INSERT INTO `evenements` VALUES (1,'Test Evenement 1','2025-10-24','Utrecht',100,20,1,NULL,'2025-09-24 08:13:03','2025-09-24 08:13:03'),(2,'Test Evenement 2','2025-11-24','Amsterdam',150,25,1,NULL,'2025-09-24 08:13:03','2025-09-24 08:13:03'),(3,'Test Evenement 3','2025-12-24','Rotterdam',120,15,1,NULL,'2025-09-24 08:13:03','2025-09-24 08:13:03'),(5,'djd;vd','2025-10-30','rrodfof',4,5,1,'xdfcvbn','2025-10-16 05:47:43','2025-10-16 05:47:43'),(6,'-1','2025-11-01','jhfjfj',1,1,1,'tydtgf','2025-10-16 06:18:12','2025-10-16 06:18:12'),(7,'ddfff','2025-10-21','utrecht',10000,10000,1,'jhfvj,v,','2025-10-16 06:19:32','2025-10-16 06:19:32'),(8,'fnaeFJKAEFN','2025-10-16','utrecht',500000,50000,1,';jkfaenjk;fef','2025-10-16 06:20:08','2025-10-16 06:20:08');
/*!40000 ALTER TABLE `evenements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_09_10_094246_create_organisators_table',1),(5,'2025_09_10_094350_create_bezoekers_table',1),(6,'2025_09_10_094446_create_evenements_table',1),(7,'2025_09_10_094519_create_prijzen_table',1),(8,'2025_09_10_094605_create_tickets_table',1),(9,'2025_09_10_094713_create_verkopers_table',1),(10,'2025_09_10_094803_create_stands_table',1),(11,'2025_09_10_095001_create_contactpersonen_table',1),(12,'2025_09_10_095213_create_contact_per_verkoper_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organisators`
--

DROP TABLE IF EXISTS `organisators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `organisators` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Naam` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Gebruikersnaam` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Wachtwoord` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IsActief` tinyint(1) NOT NULL DEFAULT '1',
  `Opmerking` text COLLATE utf8mb4_unicode_ci,
  `DatumAangemaakt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DatumGewijzigd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `organisators_gebruikersnaam_unique` (`Gebruikersnaam`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organisators`
--

LOCK TABLES `organisators` WRITE;
/*!40000 ALTER TABLE `organisators` DISABLE KEYS */;
INSERT INTO `organisators` VALUES (1,'Admin','admin','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',1,NULL,'2025-09-24 08:13:03','2025-09-24 08:13:03');
/*!40000 ALTER TABLE `organisators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prijzen`
--

DROP TABLE IF EXISTS `prijzen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prijzen` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `EvenementId` bigint unsigned NOT NULL,
  `Datum` date NOT NULL,
  `Tijdslot` time NOT NULL,
  `Tarief` decimal(8,2) NOT NULL,
  `IsActief` tinyint(1) NOT NULL DEFAULT '1',
  `Opmerking` text COLLATE utf8mb4_unicode_ci,
  `DatumAangemaakt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DatumGewijzigd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `prijzen_evenementid_datum_tijdslot_unique` (`EvenementId`,`Datum`,`Tijdslot`),
  UNIQUE KEY `idx_unique_prijs` (`EvenementId`,`Datum`,`Tijdslot`),
  CONSTRAINT `prijzen_evenementid_foreign` FOREIGN KEY (`EvenementId`) REFERENCES `evenements` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prijzen`
--

LOCK TABLES `prijzen` WRITE;
/*!40000 ALTER TABLE `prijzen` DISABLE KEYS */;
INSERT INTO `prijzen` VALUES (1,1,'2023-10-01','10:00:00',15.00,1,'Vroege vogel korting','2025-09-24 08:13:03','2025-09-24 08:13:03'),(2,1,'2023-10-01','14:00:00',20.00,0,NULL,'2025-09-24 08:13:03','2025-10-15 20:16:21'),(6,1,'2025-10-15','08:00:00',22.00,1,NULL,'2025-10-15 19:11:25','2025-10-15 19:19:03'),(7,1,'2025-10-15','11:00:00',80.00,1,NULL,'2025-10-15 19:25:49','2025-10-15 19:25:49'),(8,1,'2025-10-15','14:00:00',8.00,1,NULL,'2025-10-15 19:26:33','2025-10-15 19:26:33'),(10,1,'2025-10-17','08:00:00',24.00,1,NULL,'2025-10-16 07:51:07','2025-10-16 07:51:07'),(11,1,'2025-10-17','14:00:00',3.00,1,NULL,'2025-10-16 07:51:48','2025-10-16 07:51:48'),(12,2,'2025-10-17','08:00:00',10.00,1,NULL,'2025-10-16 08:25:16','2025-10-16 08:25:16');
/*!40000 ALTER TABLE `prijzen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('1GPWxZ0qwThAZV5NmKFnHoBPM1CdnelMWQc2nAUU',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTGFHMk1ZMFF1QVlMcnplMkFiUUx6VFk0clNGa1BQTVlzU0c0c1VZWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9wcmlqemVuL2NyZWF0ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1760603160);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stands`
--

DROP TABLE IF EXISTS `stands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stands` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `EvenementId` bigint unsigned NOT NULL,
  `VerkoperId` bigint unsigned NOT NULL,
  `StandType` enum('A','AA','AAplus') COLLATE utf8mb4_unicode_ci NOT NULL,
  `Prijs` decimal(10,2) NOT NULL,
  `VerhuurdStatus` tinyint(1) NOT NULL DEFAULT '1',
  `IsActief` tinyint(1) NOT NULL DEFAULT '1',
  `Opmerking` text COLLATE utf8mb4_unicode_ci,
  `DatumAangemaakt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DatumGewijzigd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `stands_verkoperid_foreign` (`VerkoperId`),
  KEY `stands_evenementid_verkoperid_index` (`EvenementId`,`VerkoperId`),
  CONSTRAINT `stands_evenementid_foreign` FOREIGN KEY (`EvenementId`) REFERENCES `evenements` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stands_verkoperid_foreign` FOREIGN KEY (`VerkoperId`) REFERENCES `verkopers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stands`
--

LOCK TABLES `stands` WRITE;
/*!40000 ALTER TABLE `stands` DISABLE KEYS */;
INSERT INTO `stands` VALUES (1,1,1,'A',100.00,1,1,NULL,'2025-09-24 08:13:04','2025-09-24 08:13:04'),(2,1,2,'AA',150.00,0,1,NULL,'2025-09-24 08:13:04','2025-09-24 08:13:04'),(3,2,3,'AAplus',200.00,1,1,NULL,'2025-09-24 08:13:04','2025-09-24 08:13:04'),(4,2,1,'A',120.00,1,1,NULL,'2025-09-24 08:13:04','2025-09-24 08:13:04'),(5,3,2,'AA',180.00,0,1,NULL,'2025-09-24 08:13:04','2025-09-24 08:13:04');
/*!40000 ALTER TABLE `stands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `BezoekerId` bigint unsigned NOT NULL,
  `EvenementId` bigint unsigned NOT NULL,
  `PrijsId` bigint unsigned NOT NULL,
  `AantalTickets` int unsigned NOT NULL,
  `Datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `IsActief` tinyint(1) NOT NULL DEFAULT '1',
  `Opmerking` text COLLATE utf8mb4_unicode_ci,
  `DatumAangemaakt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DatumGewijzigd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `tickets_bezoekerid_foreign` (`BezoekerId`),
  KEY `tickets_prijsid_index` (`PrijsId`),
  KEY `tickets_evenementid_index` (`EvenementId`),
  CONSTRAINT `tickets_bezoekerid_foreign` FOREIGN KEY (`BezoekerId`) REFERENCES `bezoekers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tickets_evenementid_foreign` FOREIGN KEY (`EvenementId`) REFERENCES `evenements` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tickets_prijsid_foreign` FOREIGN KEY (`PrijsId`) REFERENCES `prijzen` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (1,1,1,1,1,'2023-09-30 22:00:00',1,NULL,'2025-10-15 18:08:41','2025-10-15 18:08:41'),(2,1,1,1,10,'2023-09-30 22:00:00',1,NULL,'2025-10-15 18:19:41','2025-10-15 18:19:41'),(3,1,1,2,50,'2023-09-30 22:00:00',1,NULL,'2025-10-15 18:30:29','2025-10-15 18:30:29'),(4,1,1,1,10,'2023-09-30 22:00:00',1,NULL,'2025-10-15 18:35:40','2025-10-15 18:35:40'),(5,1,1,1,10,'2023-09-30 22:00:00',1,NULL,'2025-10-15 18:39:50','2025-10-15 18:39:50');
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `verkopers`
--

DROP TABLE IF EXISTS `verkopers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `verkopers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Naam` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SpecialeStatus` enum('GEEN','PARTNER') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'GEEN',
  `VerkooptSoort` enum('SNEAKERS','ETEN_DRINKEN','KIDS_CORNER','CUSTOMIZERS','TATTOO','BARBERSHOP','DJ_SET','OVERIG') COLLATE utf8mb4_unicode_ci NOT NULL,
  `StandType` enum('A','AA','AAplus') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Dagen` enum('EEN','TWEE') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `LogoUrl` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IsActief` tinyint(1) NOT NULL DEFAULT '1',
  `Opmerking` text COLLATE utf8mb4_unicode_ci,
  `DatumAangemaakt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DatumGewijzigd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `verkopers_specialestatus_index` (`SpecialeStatus`),
  KEY `verkopers_verkooptsoort_index` (`VerkooptSoort`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verkopers`
--

LOCK TABLES `verkopers` WRITE;
/*!40000 ALTER TABLE `verkopers` DISABLE KEYS */;
INSERT INTO `verkopers` VALUES (1,'Verkoper 1','GEEN','SNEAKERS','A','EEN',NULL,1,NULL,'2025-09-24 08:13:04','2025-09-24 08:13:04'),(2,'Verkoper 2','PARTNER','ETEN_DRINKEN','AA','TWEE',NULL,1,NULL,'2025-09-24 08:13:04','2025-09-24 08:13:04'),(3,'Verkoper 3','GEEN','KIDS_CORNER','AAplus','EEN',NULL,1,NULL,'2025-09-24 08:13:04','2025-09-24 08:13:04'),(4,'Verkoper 4','GEEN','CUSTOMIZERS',NULL,'TWEE',NULL,1,NULL,'2025-09-24 08:13:04','2025-09-24 08:13:04'),(5,'Verkoper 5','PARTNER','TATTOO','A','EEN',NULL,1,NULL,'2025-09-24 08:13:04','2025-09-24 08:13:04'),(6,'Verkoper 6','GEEN','BARBERSHOP','AA','TWEE',NULL,1,NULL,'2025-09-24 08:13:04','2025-09-24 08:13:04'),(7,'Verkoper 7','GEEN','DJ_SET','AAplus','EEN',NULL,1,NULL,'2025-09-24 08:13:04','2025-09-24 08:13:04'),(8,'Verkoper 8','GEEN','OVERIG',NULL,'TWEE',NULL,1,NULL,'2025-09-24 08:13:04','2025-09-24 08:13:04'),(9,'ewefasd','PARTNER','SNEAKERS','A','EEN',NULL,1,'','2025-10-16 07:08:22','2025-10-16 07:08:22'),(10,'-1','PARTNER','CUSTOMIZERS','AAplus','TWEE',NULL,1,'','2025-10-16 08:07:33','2025-10-16 08:07:33'),(11,'kaaskoppen','GEEN','KIDS_CORNER','AA','TWEE',NULL,1,'','2025-10-16 08:08:28','2025-10-16 08:08:28');
/*!40000 ALTER TABLE `verkopers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'laravel'
--

--
-- Dumping routines for database 'laravel'
--
/*!50003 DROP PROCEDURE IF EXISTS `SP_CreateOrGetBezoeker` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CreateOrGetBezoeker`(
    IN p_email VARCHAR(255),
    IN p_naam VARCHAR(255)
)
BEGIN
    DECLARE v_bezoeker_id INT;

    -- Check if bezoeker exists (using COLLATE to fix collation mismatch)
    SELECT id INTO v_bezoeker_id
    FROM bezoekers
    WHERE EmailAdres COLLATE utf8mb4_unicode_ci = p_email COLLATE utf8mb4_unicode_ci
    LIMIT 1;

    -- If not exists, create new bezoeker
    IF v_bezoeker_id IS NULL THEN
        INSERT INTO bezoekers (Naam, EmailAdres, IsActief)
        VALUES (p_naam, p_email, 1);

        SET v_bezoeker_id = LAST_INSERT_ID();
    END IF;

    SELECT v_bezoeker_id AS id, p_email AS EmailAdres;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_CreatePrijs` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CreatePrijs`(
    IN p_evenementId INT,
    IN p_datum DATE,
    IN p_tijdslot TIME,
    IN p_tarief DECIMAL(10,2),
    IN p_opmerking TEXT
)
BEGIN
    DECLARE v_duplicate_count INT;

    -- Check if duplicate exists (same event, date, and timeslot)
    SELECT COUNT(*) INTO v_duplicate_count
    FROM prijzen
    WHERE EvenementId = p_evenementId
      AND Datum = p_datum
      AND Tijdslot = p_tijdslot
      AND IsActief = 1;

    -- If duplicate exists, signal error
    IF v_duplicate_count > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Er bestaat al een prijs voor dit evenement op deze datum en dit tijdslot.';
    END IF;

    -- Insert new prijs
    INSERT INTO prijzen (EvenementId, Datum, Tijdslot, Tarief, IsActief, Opmerking)
    VALUES (p_evenementId, p_datum, p_tijdslot, p_tarief, 1, p_opmerking);

    SELECT LAST_INSERT_ID() AS id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_CreateTicket` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CreateTicket`(
    IN eventId INT,
    IN prijs DECIMAL(10,2),
    IN tijdslot TIME,
    IN datum DATE
)
BEGIN
    INSERT INTO prijzen (EvenementId, Tarief, Tijdslot, Datum)
    VALUES (eventId, prijs, tijdslot, datum);

    SELECT ROW_COUNT() AS Affected;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_CreateVerkoper` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_CreateVerkoper`(
    -- input parameters
    IN v_name VARCHAR(200),
    IN v_speciale_status VARCHAR(10),
    IN v_verkoopt_soort VARCHAR(20),
    IN v_stand_type VARCHAR(10),
    IN v_dagen VARCHAR(10),
    IN v_logo_url VARCHAR(500),
    IN v_is_actief BIT,
    IN v_opmerking TEXT
)
BEGIN
    -- insert in verkopers
    INSERT INTO verkopers (
        Naam,
        SpecialeStatus,
        VerkooptSoort,
        StandType,
        Dagen,
        LogoUrl,
        IsActief,
        Opmerking
    )
    -- met waarden van input parameters
    VALUES (
        v_name,
        v_speciale_status,
        v_verkoopt_soort,
        v_stand_type,
        v_dagen,
        v_logo_url,
        v_is_actief,
        v_opmerking
    );
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_DeletePrijs` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_DeletePrijs`(IN p_id INT)
BEGIN
    -- Soft delete: set IsActief to 0 instead of hard delete
    -- This prevents foreign key constraint errors when tickets reference this prijs
    UPDATE prijzen
    SET IsActief = 0,
        DatumGewijzigd = NOW()
    WHERE id = p_id;

    SELECT ROW_COUNT() AS Affected;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_DeleteTicket` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_DeleteTicket`(IN id INT)
BEGIN
    DELETE FROM prijzen WHERE id = id;
    SELECT ROW_COUNT() AS Affected;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_GetAllEvents` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_GetAllEvents`()
BEGIN
    SELECT
        id,
        Naam,
        Locatie,
        Datum
    FROM
        evenements;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_GetAllPrijzen` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_GetAllPrijzen`()
BEGIN
    SELECT
        p.id,
        p.EvenementId,
        e.Naam AS EventNaam,
        p.Datum,
        p.Tijdslot,
        p.Tarief,
        p.IsActief,
        p.Opmerking,
        p.DatumAangemaakt,
        p.DatumGewijzigd
    FROM prijzen AS p
    LEFT JOIN evenements AS e ON p.EvenementId = e.id
    WHERE p.IsActief = 1
    ORDER BY p.Datum DESC, p.Tijdslot;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_GetAllTickets` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_GetAllTickets`(IN eventId INT)
BEGIN
    -- Return price/time slots (prijzen) for a given event
    SELECT
        p.id AS PrijsID,
        e.Naam AS EventNaam,
        p.Tarief AS TicketPrijs,
        p.Tijdslot AS TicketTijdslot,
        p.Datum AS TicketDatum,
        e.Locatie AS EventLocatie
    FROM
        prijzen AS p
    LEFT JOIN
        evenements AS e ON p.EvenementId = e.id
    WHERE
        e.id = eventId
        AND p.IsActief = 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_GetAllTickets_NoParam` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_GetAllTickets_NoParam`()
BEGIN
    SELECT
        p.id AS PrijsID,
        e.Naam AS EventNaam,
        p.Tarief AS TicketPrijs,
        p.Tijdslot AS TicketTijdslot,
        p.Datum AS TicketDatum,
        e.Locatie AS EventLocatie
    FROM
        prijzen AS p
    LEFT JOIN
        evenements AS e ON p.EvenementId = e.id
    WHERE
        p.IsActief = 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetAllVerkopers` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetAllVerkopers`()
BEGIN
    SELECT
        v.id,
        v.Naam,
        v.SpecialeStatus,
        v.VerkooptSoort,
        v.StandType,
        v.Dagen,
        v.LogoUrl
    FROM verkopers AS v;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_GetEventByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_GetEventByID`(IN eventId INT)
BEGIN
    SELECT
        id,
        Naam,
        Locatie,
        Datum
    FROM
        evenements
    WHERE
        id = eventId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_GetPrijsByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_GetPrijsByID`(IN p_id INT)
BEGIN
    SELECT
        p.id,
        p.EvenementId,
        e.Naam AS EventNaam,
        p.Datum,
        p.Tijdslot,
        p.Tarief,
        p.IsActief,
        p.Opmerking,
        p.DatumAangemaakt,
        p.DatumGewijzigd
    FROM prijzen AS p
    LEFT JOIN evenements AS e ON p.EvenementId = e.id
    WHERE p.id = p_id;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_GetTicketByID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_GetTicketByID`(IN ticketId INT)
BEGIN
    -- Return a single prijs (ticket) record by its id
    SELECT
        p.id AS PrijsID,
        e.Naam AS EventNaam,
        p.Tarief AS TicketPrijs,
        p.Tijdslot AS TicketTijdslot,
        p.Datum AS TicketDatum,
        e.Locatie AS EventLocatie
    FROM
        prijzen AS p
    LEFT JOIN
        evenements AS e ON p.EvenementId = e.id
    WHERE
        p.id = ticketId
        AND p.IsActief = 1;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_GetTicketsByEventID` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_GetTicketsByEventID`(IN eventId INT)
BEGIN
    -- Alias of SP_GetAllTickets for compatibility
    SELECT
        p.id,
        p.Tarief,
        p.Tijdslot,
        p.Datum
    FROM
        prijzen AS p
    WHERE
        p.EvenementId = eventId &&
        p.IsActief = 1
    ORDER BY
        p.Datum, p.Tijdslot;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_GetVerkoperByNaam` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetVerkoperByNaam`(
    -- input parameter
    IN v_naam VARCHAR(200)
)
BEGIN
    -- select
    SELECT 
        -- kolom "Naam"
        VKPR.Naam
    -- van verkopers afgekort naar VKPR
    FROM verkopers AS VKPR
    -- waar kolom "Naam" Gelijk is aan input naam
    -- utf8mb4_unicode_ci zorgt ervoor dat het niet uitmaakt of het hoofdletters of kleine leters zijn
    -- dus "TEST" = "test" is TRUE
    WHERE VKPR.Naam COLLATE utf8mb4_unicode_ci = v_naam COLLATE utf8mb4_unicode_ci;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_KopenTicket` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_KopenTicket`(IN bezoekerid INT, IN evenementid INT, IN prijsid INT, IN aantalTickets INT, IN datum date)
BEGIN
    INSERT INTO tickets(BezoekerId, EvenementId, PrijsId, AantalTickets, Datum)
    VALUES(bezoekerid, evenementid, prijsid, aantalTickets, datum);
    SELECT ROW_COUNT() AS Affected;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_STORETICKET` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_STORETICKET`(
    IN param1 INT,
    IN param2 DECIMAL(10,2),
    IN param3 DATETIME,
    IN param4 VARCHAR(255)
)
BEGIN
    INSERT INTO Prijs (EvenementID, Tarief, Tijdslot, Datum)
    VALUES (param1, param2, param3, param4);

    SELECT ROW_COUNT() AS Affected;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_Ticketophalen` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_Ticketophalen`(IN bezoekerid INT, IN datum date)
BEGIN
    SELECT
        BezoekerId,
        EvenementId,
        PrijsId,
        AantalTickets,
        Datum
    FROM tickets
    WHERE
        Datum = datum &&
        Bezoekerid = bezoekerid;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_UpdatePrijs` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_UpdatePrijs`(
    IN p_id INT,
    IN p_evenementId INT,
    IN p_datum DATE,
    IN p_tijdslot TIME,
    IN p_tarief DECIMAL(10,2),
    IN p_isActief TINYINT,
    IN p_opmerking TEXT
)
BEGIN
    DECLARE v_duplicate_count INT;

    -- Check if duplicate exists (excluding current record)
    SELECT COUNT(*) INTO v_duplicate_count
    FROM prijzen
    WHERE EvenementId = p_evenementId
      AND Datum = p_datum
      AND Tijdslot = p_tijdslot
      AND IsActief = 1
      AND id != p_id;

    -- If duplicate exists, signal error
    IF v_duplicate_count > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Er bestaat al een prijs voor dit evenement op deze datum en dit tijdslot.';
    END IF;

    -- Update prijs
    UPDATE prijzen
    SET
        EvenementId = p_evenementId,
        Datum = p_datum,
        Tijdslot = p_tijdslot,
        Tarief = p_tarief,
        IsActief = p_isActief,
        Opmerking = p_opmerking,
        DatumGewijzigd = NOW()
    WHERE id = p_id;

    SELECT ROW_COUNT() AS Affected;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `SP_UpdateTicket` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_UpdateTicket`(
    IN id INT,
    IN prijs DECIMAL(10,2),
    IN tijdslot TIME,
    IN datum DATE,
    IN eventId INT
)
BEGIN
    UPDATE prijzen
    SET Tarief = prijs,
        Tijdslot = tijdslot,
        Datum = datum,
        EvenementId = eventId
    WHERE id = id;

    SELECT ROW_COUNT() AS Affected;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-24 15:38:58
