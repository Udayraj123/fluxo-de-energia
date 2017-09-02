-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: techno_online
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `commons`
--

DROP TABLE IF EXISTS `commons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` enum('god','investor','farmer') NOT NULL,
  `sysLE` int(11) NOT NULL,
  `upperTHR` int(11) NOT NULL,
  `lowerTHR` int(11) NOT NULL,
  `prev_time` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commons`
--

LOCK TABLES `commons` WRITE;
/*!40000 ALTER TABLE `commons` DISABLE KEYS */;
INSERT INTO `commons` VALUES (1,'god',12510000,1125900,62550,1504315347,'2016-10-11 03:15:05','2017-09-02 01:22:27'),(2,'investor',11625210,58126,5813,1504298823,'2016-10-11 03:15:05','2017-09-01 20:47:03'),(3,'farmer',11614281,5807,581,1504315332,'2016-10-11 03:15:05','2017-09-02 01:22:12');
/*!40000 ALTER TABLE `commons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `farmers`
--

DROP TABLE IF EXISTS `farmers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `farmers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `decay` float NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `farmers`
--

LOCK TABLES `farmers` WRITE;
/*!40000 ALTER TABLE `farmers` DISABLE KEYS */;
INSERT INTO `farmers` VALUES (1,32,'2017-09-02 01:22:12','2017-09-02 01:22:12',2),(2,33,'2017-09-02 01:22:13','2017-09-02 01:22:13',2),(3,34,'2017-09-02 01:22:13','2017-09-02 01:22:13',2),(4,35,'2017-09-02 01:22:13','2017-09-02 01:22:13',2),(5,36,'2017-09-02 01:22:14','2017-09-02 01:22:14',2),(6,37,'2017-09-02 01:22:14','2017-09-02 01:22:14',2),(7,38,'2017-09-02 01:22:14','2017-09-02 01:22:14',2),(8,39,'2017-09-02 01:22:14','2017-09-02 01:22:14',2),(9,40,'2017-09-02 01:22:15','2017-09-02 01:22:15',2),(10,41,'2017-09-02 01:22:15','2017-09-02 01:22:15',2),(11,42,'2017-09-02 01:22:15','2017-09-02 01:22:15',2),(12,43,'2017-09-02 01:22:15','2017-09-02 01:22:15',2),(13,44,'2017-09-02 01:22:16','2017-09-02 01:22:16',2),(14,45,'2017-09-02 01:22:16','2017-09-02 01:22:16',2),(15,46,'2017-09-02 01:22:16','2017-09-02 01:22:16',2),(16,47,'2017-09-02 01:22:16','2017-09-02 01:22:16',2),(17,48,'2017-09-02 01:22:17','2017-09-02 01:22:17',2),(18,49,'2017-09-02 01:22:17','2017-09-02 01:22:17',2),(19,50,'2017-09-02 01:22:17','2017-09-02 01:22:17',2),(20,51,'2017-09-02 01:22:17','2017-09-02 01:22:17',2),(21,52,'2017-09-02 01:22:18','2017-09-02 01:22:18',2),(22,53,'2017-09-02 01:22:18','2017-09-02 01:22:18',2),(23,54,'2017-09-02 01:22:18','2017-09-02 01:22:18',2),(24,55,'2017-09-02 01:22:18','2017-09-02 01:22:18',2),(25,56,'2017-09-02 01:22:18','2017-09-02 01:22:18',2),(26,57,'2017-09-02 01:22:19','2017-09-02 01:22:19',2),(27,58,'2017-09-02 01:22:19','2017-09-02 01:22:19',2),(28,59,'2017-09-02 01:22:19','2017-09-02 01:22:19',2),(29,60,'2017-09-02 01:22:19','2017-09-02 01:22:19',2),(30,61,'2017-09-02 01:22:20','2017-09-02 01:22:20',2),(31,62,'2017-09-02 01:22:20','2017-09-02 01:22:20',2),(32,63,'2017-09-02 01:22:20','2017-09-02 01:22:20',2),(33,64,'2017-09-02 01:22:20','2017-09-02 01:22:20',2),(34,65,'2017-09-02 01:22:21','2017-09-02 01:22:21',2),(35,66,'2017-09-02 01:22:21','2017-09-02 01:22:21',2);
/*!40000 ALTER TABLE `farmers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fertilizers`
--

DROP TABLE IF EXISTS `fertilizers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fertilizers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `quality_factor` float(3,3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fertilizers`
--

LOCK TABLES `fertilizers` WRITE;
/*!40000 ALTER TABLE `fertilizers` DISABLE KEYS */;
/*!40000 ALTER TABLE `fertilizers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fruitbills`
--

DROP TABLE IF EXISTS `fruitbills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fruitbills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fruit_id` int(11) DEFAULT NULL,
  `buy_price` int(11) NOT NULL,
  `num_units` int(11) NOT NULL,
  `avl_units` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `investor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fruitbills`
--

LOCK TABLES `fruitbills` WRITE;
/*!40000 ALTER TABLE `fruitbills` DISABLE KEYS */;
/*!40000 ALTER TABLE `fruitbills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fruits`
--

DROP TABLE IF EXISTS `fruits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fruits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `launched` tinyint(4) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `num_units` int(11) NOT NULL DEFAULT '0',
  `avl_units` int(11) NOT NULL,
  `unit_price` int(11) DEFAULT NULL,
  `seed_id` int(11) DEFAULT NULL,
  `storage_le` int(11) NOT NULL DEFAULT '100',
  `launched_at` int(11) DEFAULT NULL,
  `sell_price` varchar(45) DEFAULT NULL,
  `quality_factor` int(11) NOT NULL DEFAULT '37',
  `name` varchar(45) DEFAULT NULL,
  `farmer_id` int(11) NOT NULL DEFAULT '1',
  `ET` int(11) DEFAULT NULL,
  `description` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fruits`
--

LOCK TABLES `fruits` WRITE;
/*!40000 ALTER TABLE `fruits` DISABLE KEYS */;
/*!40000 ALTER TABLE `fruits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gods`
--

DROP TABLE IF EXISTS `gods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `decay` int(11) NOT NULL DEFAULT '166',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gods`
--

LOCK TABLES `gods` WRITE;
/*!40000 ALTER TABLE `gods` DISABLE KEYS */;
INSERT INTO `gods` VALUES (1,32,'2017-09-02 01:22:13','2017-09-02 01:22:13',166),(2,33,'2017-09-02 01:22:13','2017-09-02 01:22:13',166),(3,34,'2017-09-02 01:22:27','2017-09-02 01:22:27',2085),(4,35,'2017-09-02 01:22:13','2017-09-02 01:22:13',166),(5,36,'2017-09-02 01:22:14','2017-09-02 01:22:14',166),(6,37,'2017-09-02 01:22:14','2017-09-02 01:22:14',166),(7,38,'2017-09-02 01:22:14','2017-09-02 01:22:14',166),(8,39,'2017-09-02 01:22:14','2017-09-02 01:22:14',166),(9,40,'2017-09-02 01:22:15','2017-09-02 01:22:15',166),(10,41,'2017-09-02 01:22:15','2017-09-02 01:22:15',166),(11,42,'2017-09-02 01:22:15','2017-09-02 01:22:15',166),(12,43,'2017-09-02 01:22:15','2017-09-02 01:22:15',166),(13,44,'2017-09-02 01:22:16','2017-09-02 01:22:16',166),(14,45,'2017-09-02 01:22:16','2017-09-02 01:22:16',166),(15,46,'2017-09-02 01:22:16','2017-09-02 01:22:16',166),(16,47,'2017-09-02 01:22:16','2017-09-02 01:22:16',166),(17,48,'2017-09-02 01:22:17','2017-09-02 01:22:17',166),(18,49,'2017-09-02 01:22:17','2017-09-02 01:22:17',166),(19,50,'2017-09-02 01:22:17','2017-09-02 01:22:17',166),(20,51,'2017-09-02 01:22:17','2017-09-02 01:22:17',166),(21,52,'2017-09-02 01:22:18','2017-09-02 01:22:18',166),(22,53,'2017-09-02 01:22:18','2017-09-02 01:22:18',166),(23,54,'2017-09-02 01:22:18','2017-09-02 01:22:18',166),(24,55,'2017-09-02 01:22:18','2017-09-02 01:22:18',166),(25,56,'2017-09-02 01:22:19','2017-09-02 01:22:19',166),(26,57,'2017-09-02 01:22:19','2017-09-02 01:22:19',166),(27,58,'2017-09-02 01:22:19','2017-09-02 01:22:19',166),(28,59,'2017-09-02 01:22:19','2017-09-02 01:22:19',166),(29,60,'2017-09-02 01:22:19','2017-09-02 01:22:19',166),(30,61,'2017-09-02 01:22:20','2017-09-02 01:22:20',166),(31,62,'2017-09-02 01:22:20','2017-09-02 01:22:20',166),(32,63,'2017-09-02 01:22:20','2017-09-02 01:22:20',166),(33,64,'2017-09-02 01:22:20','2017-09-02 01:22:20',166),(34,65,'2017-09-02 01:22:21','2017-09-02 01:22:21',166),(35,66,'2017-09-02 01:22:21','2017-09-02 01:22:21',166);
/*!40000 ALTER TABLE `gods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `investments`
--

DROP TABLE IF EXISTS `investments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `investments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `investor_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `bid_price` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `num_shares` int(11) DEFAULT '10',
  `amt_ret` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `investments`
--

LOCK TABLES `investments` WRITE;
/*!40000 ALTER TABLE `investments` DISABLE KEYS */;
/*!40000 ALTER TABLE `investments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `investors`
--

DROP TABLE IF EXISTS `investors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `investors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `decay` float NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `investors`
--

LOCK TABLES `investors` WRITE;
/*!40000 ALTER TABLE `investors` DISABLE KEYS */;
INSERT INTO `investors` VALUES (1,32,'2017-09-02 01:22:13','2017-09-02 01:22:13',2),(2,33,'2017-09-02 01:22:13','2017-09-02 01:22:13',2),(3,34,'2017-09-02 01:22:13','2017-09-02 01:22:13',2),(4,35,'2017-09-02 01:22:14','2017-09-02 01:22:14',2),(5,36,'2017-09-02 01:22:14','2017-09-02 01:22:14',2),(6,37,'2017-09-02 01:22:14','2017-09-02 01:22:14',2),(7,38,'2017-09-02 01:22:14','2017-09-02 01:22:14',2),(8,39,'2017-09-02 01:22:15','2017-09-02 01:22:15',2),(9,40,'2017-09-02 01:22:15','2017-09-02 01:22:15',2),(10,41,'2017-09-02 01:22:15','2017-09-02 01:22:15',2),(11,42,'2017-09-02 01:22:15','2017-09-02 01:22:15',2),(12,43,'2017-09-02 01:22:15','2017-09-02 01:22:15',2),(13,44,'2017-09-02 01:22:16','2017-09-02 01:22:16',2),(14,45,'2017-09-02 01:22:16','2017-09-02 01:22:16',2),(15,46,'2017-09-02 01:22:16','2017-09-02 01:22:16',2),(16,47,'2017-09-02 01:22:16','2017-09-02 01:22:16',2),(17,48,'2017-09-02 01:22:17','2017-09-02 01:22:17',2),(18,49,'2017-09-02 01:22:17','2017-09-02 01:22:17',2),(19,50,'2017-09-02 01:22:17','2017-09-02 01:22:17',2),(20,51,'2017-09-02 01:22:18','2017-09-02 01:22:18',2),(21,52,'2017-09-02 01:22:18','2017-09-02 01:22:18',2),(22,53,'2017-09-02 01:22:18','2017-09-02 01:22:18',2),(23,54,'2017-09-02 01:22:18','2017-09-02 01:22:18',2),(24,55,'2017-09-02 01:22:18','2017-09-02 01:22:18',2),(25,56,'2017-09-02 01:22:19','2017-09-02 01:22:19',2),(26,57,'2017-09-02 01:22:19','2017-09-02 01:22:19',2),(27,58,'2017-09-02 01:22:19','2017-09-02 01:22:19',2),(28,59,'2017-09-02 01:22:19','2017-09-02 01:22:19',2),(29,60,'2017-09-02 01:22:19','2017-09-02 01:22:19',2),(30,61,'2017-09-02 01:22:20','2017-09-02 01:22:20',2),(31,62,'2017-09-02 01:22:20','2017-09-02 01:22:20',2),(32,63,'2017-09-02 01:22:20','2017-09-02 01:22:20',2),(33,64,'2017-09-02 01:22:20','2017-09-02 01:22:20',2),(34,65,'2017-09-02 01:22:21','2017-09-02 01:22:21',2),(35,66,'2017-09-02 01:22:21','2017-09-02 01:22:21',2);
/*!40000 ALTER TABLE `investors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lands`
--

DROP TABLE IF EXISTS `lands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) NOT NULL DEFAULT '4',
  `farmer_id` int(11) DEFAULT NULL,
  `seed_id` int(11) NOT NULL DEFAULT '-1',
  `fert_id` int(11) NOT NULL DEFAULT '-1',
  `GT` int(11) NOT NULL DEFAULT '5',
  `planted_at` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lands`
--

LOCK TABLES `lands` WRITE;
/*!40000 ALTER TABLE `lands` DISABLE KEYS */;
INSERT INTO `lands` VALUES (1,1,1,-1,-1,5,0,'2017-09-02 01:22:22','2017-09-02 01:22:22'),(2,2,2,-1,-1,5,0,'2017-09-02 01:22:22','2017-09-02 01:22:22'),(3,3,3,-1,-1,5,0,'2017-09-02 01:22:22','2017-09-02 01:22:22'),(4,4,4,-1,-1,5,0,'2017-09-02 01:22:22','2017-09-02 01:22:22'),(5,5,5,-1,-1,5,0,'2017-09-02 01:22:23','2017-09-02 01:22:23'),(6,6,6,-1,-1,5,0,'2017-09-02 01:22:23','2017-09-02 01:22:23'),(7,7,7,-1,-1,5,0,'2017-09-02 01:22:23','2017-09-02 01:22:23'),(8,8,8,-1,-1,5,0,'2017-09-02 01:22:23','2017-09-02 01:22:23'),(9,9,9,-1,-1,5,0,'2017-09-02 01:22:23','2017-09-02 01:22:23'),(10,10,10,-1,-1,5,0,'2017-09-02 01:22:23','2017-09-02 01:22:23'),(11,11,11,-1,-1,5,0,'2017-09-02 01:22:23','2017-09-02 01:22:23'),(12,12,12,-1,-1,5,0,'2017-09-02 01:22:23','2017-09-02 01:22:23'),(13,13,13,-1,-1,5,0,'2017-09-02 01:22:24','2017-09-02 01:22:24'),(14,14,14,-1,-1,5,0,'2017-09-02 01:22:24','2017-09-02 01:22:24'),(15,15,15,-1,-1,5,0,'2017-09-02 01:22:24','2017-09-02 01:22:24'),(16,16,16,-1,-1,5,0,'2017-09-02 01:22:24','2017-09-02 01:22:24'),(17,17,17,-1,-1,5,0,'2017-09-02 01:22:24','2017-09-02 01:22:24'),(18,18,18,-1,-1,5,0,'2017-09-02 01:22:24','2017-09-02 01:22:24'),(19,19,19,-1,-1,5,0,'2017-09-02 01:22:24','2017-09-02 01:22:24'),(20,20,20,-1,-1,5,0,'2017-09-02 01:22:24','2017-09-02 01:22:24'),(21,21,21,-1,-1,5,0,'2017-09-02 01:22:25','2017-09-02 01:22:25'),(22,22,22,-1,-1,5,0,'2017-09-02 01:22:25','2017-09-02 01:22:25'),(23,23,23,-1,-1,5,0,'2017-09-02 01:22:25','2017-09-02 01:22:25'),(24,24,24,-1,-1,5,0,'2017-09-02 01:22:25','2017-09-02 01:22:25'),(25,25,25,-1,-1,5,0,'2017-09-02 01:22:25','2017-09-02 01:22:25'),(26,26,26,-1,-1,5,0,'2017-09-02 01:22:25','2017-09-02 01:22:25'),(27,27,27,-1,-1,5,0,'2017-09-02 01:22:25','2017-09-02 01:22:25'),(28,28,28,-1,-1,5,0,'2017-09-02 01:22:26','2017-09-02 01:22:26'),(29,29,29,-1,-1,5,0,'2017-09-02 01:22:26','2017-09-02 01:22:26'),(30,30,30,-1,-1,5,0,'2017-09-02 01:22:26','2017-09-02 01:22:26'),(31,31,31,-1,-1,5,0,'2017-09-02 01:22:26','2017-09-02 01:22:26'),(32,32,32,-1,-1,5,0,'2017-09-02 01:22:26','2017-09-02 01:22:26'),(33,33,33,-1,-1,5,0,'2017-09-02 01:22:26','2017-09-02 01:22:26'),(34,34,34,-1,-1,5,0,'2017-09-02 01:22:26','2017-09-02 01:22:26'),(35,35,35,-1,-1,5,0,'2017-09-02 01:22:26','2017-09-02 01:22:26');
/*!40000 ALTER TABLE `lands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `god_id` int(11) NOT NULL,
  `category` enum('seed','fertilizer','land') NOT NULL,
  `being_funded` tinyint(4) NOT NULL DEFAULT '1',
  `ET` int(11) NOT NULL DEFAULT '0',
  `FT` int(11) NOT NULL DEFAULT '0',
  `quality` int(11) NOT NULL,
  `description` varchar(400) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `bid_price` float(11,4) DEFAULT NULL,
  `total_cost` float(11,4) DEFAULT NULL,
  `unit_price` float(11,4) NOT NULL,
  `avl_units` int(11) NOT NULL,
  `total_shares` int(11) DEFAULT NULL,
  `avl_shares` int(11) DEFAULT NULL,
  `launched_at` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,'land',-1,5,5,50,'moderated',NULL,NULL,700000.0000,7000.0000,100,50,0,1504315342,'2017-09-02 01:22:22','2017-09-02 01:22:22',NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `farmer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `num_units` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `buy_price` int(11) DEFAULT '1800',
  `avl_units` int(11) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchases`
--

LOCK TABLES `purchases` WRITE;
/*!40000 ALTER TABLE `purchases` DISABLE KEYS */;
INSERT INTO `purchases` VALUES (1,1,1,1,'2017-09-02 01:22:22','2017-09-02 01:22:22',0,1),(2,2,1,1,'2017-09-02 01:22:22','2017-09-02 01:22:22',0,1),(3,3,1,1,'2017-09-02 01:22:22','2017-09-02 01:22:22',0,1),(4,4,1,1,'2017-09-02 01:22:22','2017-09-02 01:22:22',0,1),(5,5,1,1,'2017-09-02 01:22:22','2017-09-02 01:22:22',0,1),(6,6,1,1,'2017-09-02 01:22:23','2017-09-02 01:22:23',0,1),(7,7,1,1,'2017-09-02 01:22:23','2017-09-02 01:22:23',0,1),(8,8,1,1,'2017-09-02 01:22:23','2017-09-02 01:22:23',0,1),(9,9,1,1,'2017-09-02 01:22:23','2017-09-02 01:22:23',0,1),(10,10,1,1,'2017-09-02 01:22:23','2017-09-02 01:22:23',0,1),(11,11,1,1,'2017-09-02 01:22:23','2017-09-02 01:22:23',0,1),(12,12,1,1,'2017-09-02 01:22:23','2017-09-02 01:22:23',0,1),(13,13,1,1,'2017-09-02 01:22:23','2017-09-02 01:22:23',0,1),(14,14,1,1,'2017-09-02 01:22:24','2017-09-02 01:22:24',0,1),(15,15,1,1,'2017-09-02 01:22:24','2017-09-02 01:22:24',0,1),(16,16,1,1,'2017-09-02 01:22:24','2017-09-02 01:22:24',0,1),(17,17,1,1,'2017-09-02 01:22:24','2017-09-02 01:22:24',0,1),(18,18,1,1,'2017-09-02 01:22:24','2017-09-02 01:22:24',0,1),(19,19,1,1,'2017-09-02 01:22:24','2017-09-02 01:22:24',0,1),(20,20,1,1,'2017-09-02 01:22:24','2017-09-02 01:22:24',0,1),(21,21,1,1,'2017-09-02 01:22:25','2017-09-02 01:22:25',0,1),(22,22,1,1,'2017-09-02 01:22:25','2017-09-02 01:22:25',0,1),(23,23,1,1,'2017-09-02 01:22:25','2017-09-02 01:22:25',0,1),(24,24,1,1,'2017-09-02 01:22:25','2017-09-02 01:22:25',0,1),(25,25,1,1,'2017-09-02 01:22:25','2017-09-02 01:22:25',0,1),(26,26,1,1,'2017-09-02 01:22:25','2017-09-02 01:22:25',0,1),(27,27,1,1,'2017-09-02 01:22:25','2017-09-02 01:22:25',0,1),(28,28,1,1,'2017-09-02 01:22:25','2017-09-02 01:22:25',0,1),(29,29,1,1,'2017-09-02 01:22:26','2017-09-02 01:22:26',0,1),(30,30,1,1,'2017-09-02 01:22:26','2017-09-02 01:22:26',0,1),(31,31,1,1,'2017-09-02 01:22:26','2017-09-02 01:22:26',0,1),(32,32,1,1,'2017-09-02 01:22:26','2017-09-02 01:22:26',0,1),(33,33,1,1,'2017-09-02 01:22:26','2017-09-02 01:22:26',0,1),(34,34,1,1,'2017-09-02 01:22:26','2017-09-02 01:22:26',0,1),(35,35,1,1,'2017-09-02 01:22:26','2017-09-02 01:22:26',0,1);
/*!40000 ALTER TABLE `purchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `category` enum('farmer','investor','god') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remember_token` varchar(100) DEFAULT NULL,
  `prev_time` int(11) DEFAULT NULL,
  `le` int(11) NOT NULL DEFAULT '500000',
  `stored_LE` int(11) DEFAULT NULL,
  `highest_LE` int(11) NOT NULL DEFAULT '500000',
  `is_moderator` int(4) DEFAULT '0',
  `prev_LE` int(11) NOT NULL DEFAULT '0',
  `prev_LE_time` int(11) DEFAULT NULL,
  `change_percent` int(11) DEFAULT '0',
  `logged_in` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (32,'user1','$2y$10$DP16.wLUocdLp7NafO9XiuGst3EnFGz4sdifp525Rgj0hMr.TckIm','god','2016-09-09 19:00:46','2017-09-02 01:22:22',NULL,1504315332,1000000,100000,1000000,1,1000000,1504315333,0,0),(33,'user2','$2y$10$kO5OkVRiryHj1CmOf0qyi.iWKDYMqsbPDW8uChE3Qranw0ii0C3h2','god','2016-09-09 19:00:46','2017-09-02 01:22:22',NULL,1504315332,1000000,100000,1000000,1,1000000,1504315333,0,0),(34,'user3','$2y$10$5rLTCcdwD578I8tuJHcqB.3qU3vjKdzfl7A8We8YSX7FV/JgFpmem','god','2016-09-09 19:00:46','2017-09-02 01:22:27','yfXCKblUYBH0cIo7EwKqVMzg3lId9buFDjEM4NPKLAYxKtOqCIfGdWsYmn9h',1504315346,970810,100000,1000000,0,1000000,1504315333,0,0),(35,'user4','$2y$10$Ov473Vdj3lWTtzrAlcKCOeyMxzIlIhJtPgxA.s.R2.J8qNCqoBCYu','god','2016-09-09 19:00:46','2017-09-02 01:22:14','Iwuhr4cC1qkHujZaEu0GJXEdYRuPbE8Vt3DXSFr40s1YXcTsDFH3F8wJCyUr',1504315332,1000000,100000,1000000,0,1000000,1504315334,0,0),(36,'user5','$2y$10$giJ6HSWeG8jYfCDBbxm3UOOzEdGhsOVE1.yBAUCFun6gQMgIxW94S','god','2016-09-09 19:00:46','2017-09-02 01:22:14',NULL,1504315332,1000000,100000,1000000,0,1000000,1504315334,0,0),(37,'user6','$2y$10$RTbpoyk5WwAc87ncKGC09e22dntkqHxEdESeRWaL.ZhmGgmgn.f2.','god','2016-09-09 19:00:46','2017-09-02 01:22:14','bVsLC11gqqTGn38WdMXp7300I39vtFqeawGc5ZnVpZT9rJsNbypagr9Z0eu4',1504315332,1000000,100000,1000000,0,1000000,1504315334,0,0),(38,'user7','$2y$10$2BTjwiHJF6b8GwTUnnwZi.sN3EGSWvk5LB1.XWUC.CoFPEqILo50K','investor','2016-09-09 19:00:46','2017-09-02 01:22:22',NULL,1504315332,500000,60000,500000,1,500000,1504315334,0,0),(39,'user8','$2y$10$HK0bMf.w7YFWAk22yQQNX.TByN1zyrDykcRLDTYAxEOFl28oCKOje','investor','2016-09-09 19:00:46','2017-09-02 01:22:22','aJy8yhX9cGJsbGJZIhqJCEwruuCzPQU7CHtmGv2TwhAw1ks4iAeMjYctiEC4',1504315332,500000,60000,500000,1,500000,1504315335,0,0),(40,'user9','$2y$10$XbRaUc6Uar9Ul3dXdRINH.Ip3pDB9vRXv7MhwcHOvyhK473M6.ccO','investor','2016-09-09 19:00:46','2017-09-02 01:22:15',NULL,1504315332,500000,60000,500000,0,500000,1504315335,0,0),(41,'user10','$2y$10$jRDbEAZeN6HcMITp9q5h5.vy8umZKy40ZkdbCW9F3ai6EHe6zpCvm','investor','2016-09-09 19:00:46','2017-09-02 01:22:15',NULL,1504315332,500000,60000,500000,0,500000,1504315335,0,0),(42,'user11','$2y$10$G1/Zny3tqY/ZaA0RzbsFteX1aw32oLJfl0OYUCuA1jnH7Iflj4vlq','investor','2016-09-09 19:02:24','2017-09-02 01:22:15','SJZbanVakW5ipQk7Rq4pZbL6IDSHyvfXmejsy9tkequlJekdllrh1Mz8SaP2',1504315332,500000,60000,500000,0,500000,1504315335,0,0),(43,'user12','$2y$10$Fjz6qNyJIGFXPKtyzjkv9.tz2ONtpy1HFGvQ8hkD7qzEtkcsa8qzm','investor','2016-09-09 19:00:46','2017-09-02 01:22:16',NULL,1504315332,500000,60000,500000,0,500000,1504315336,0,0),(44,'user13','$2y$10$aL6iDpSqjO4mCZqbSjBBQ.3GIf/zbNmzWB7RoH/FgpGLdcsnDS3DC','investor','2016-09-09 19:00:46','2017-09-02 01:22:16',NULL,1504315332,500000,60000,500000,0,500000,1504315336,0,0),(45,'user14','$2y$10$pnwvd5/XEN3Oj3rllsHqMetXmFmxks5sRZz8d4MAdLl1AsgmKoCGK','investor','2016-09-09 19:00:46','2017-09-02 01:22:16',NULL,1504315332,500000,60000,500000,0,500000,1504315336,0,0),(46,'user15','$2y$10$Y0Pcni4B6KWiHyKc/c7PhunQwENacmrAxsV2mBXYZ7FxE.AjIzTBq','investor','2016-09-09 19:00:46','2017-09-02 01:22:16',NULL,1504315332,500000,60000,500000,0,500000,1504315336,0,0),(47,'user16','$2y$10$98ygVupbLaSOOeRjV2js7uKQDMlXRGqsBVEqKUKTryLeuEtvbXxvW','investor','2016-09-09 19:00:47','2017-09-02 01:22:17',NULL,1504315332,500000,60000,500000,0,500000,1504315337,0,0),(48,'user17','$2y$10$CTP4R3O7mObwNgaJYTVJX.QJBoEJIVYAvenJ3IitfaLNij7tyMAp2','investor','2016-09-09 19:00:47','2017-09-02 01:22:17',NULL,1504315332,500000,60000,500000,0,500000,1504315337,0,0),(49,'user18','$2y$10$VmFgtLS/0pmxRG6/MEIMt.zDkHbJyOsznznBMJzmeNDH3mbWiODGa','investor','2016-09-09 19:00:47','2017-09-02 01:22:17',NULL,1504315332,500000,60000,500000,0,500000,1504315337,0,0),(50,'user19','$2y$10$XGoC6OvSQ0EEfayR5t9EM.uHJ4598pLOWj1GvSChVt4uG1lymev/W','farmer','2016-09-09 19:00:47','2017-09-02 01:22:22',NULL,1504315332,30000,10000,30000,1,30000,1504315337,0,0),(51,'user20','$2y$10$qiaMg2pL/IPkF..JwyNuhePp0CurWnJ8VDSByTAliry/3jOuAB9pS','farmer','2016-09-09 19:00:47','2017-09-02 01:22:22',NULL,1504315332,30000,10000,30000,1,30000,1504315338,0,0),(52,'user21','$2y$10$Y93QImuuRqKpZfpRmlq4UOEgk4axz5YDP6PPncHzOKBlPa5NzIPFe','farmer','2016-09-09 19:00:47','2017-09-02 01:22:18','g4GKZPw5dxrMNnFQiMHhNJgY8c2EjA8IenyRJ2VHUFhXDT1RX1XkYE2Hy2mp',1504315332,30000,10000,30000,0,30000,1504315338,0,0),(53,'user22','$2y$10$9vmhzoxP5e3xLyoAoQfpv./4T.pcpyl85iasZxb7XhllrrhN/8Kn2','farmer','2016-09-09 19:00:47','2017-09-02 01:22:18',NULL,1504315332,30000,10000,30000,0,30000,1504315338,0,0),(54,'user23','$2y$10$hk4UVZTldgN1B73or/ZGXOHR.RX30vk7pEFJrwwAj3LOCammVGZb.','farmer','2016-09-09 19:00:47','2017-09-02 01:22:18','2neNRaX7LiLHoOaFjFfEaWW6FO7FjF6JJDSuTibKBnjoPYqhhkSj2i2YTgyP',1504315332,30000,10000,30000,0,30000,1504315338,0,0),(55,'user24','$2y$10$cIVAebQbTZbmrJ9m9PpvF.lGs4ggsOSoxYhNWZKGUrGvaLsPsaaK2','farmer','2016-09-09 19:00:47','2017-09-02 01:22:18',NULL,1504315332,30000,10000,30000,0,30000,1504315338,0,0),(56,'user25','$2y$10$54ulL4/1KMEm1..0lGLKVe0X9oMrgIayDtwmBwqJY2OYfWwsAW.nq','farmer','2016-09-09 19:00:47','2017-09-02 01:22:19','ZxNB1uTDV0hMcOiQOdpZWXk8ydRwYCZM4NUBYzvFex3VyGdm5PhEQOIuhGW5',1504315332,30000,10000,30000,0,30000,1504315339,0,0),(57,'user26','$2y$10$T8t9HESEC2HRGAKIM3hgP.VbIv4LDmDa4E1zxrsJRB7v38020IqFi','farmer','2016-09-09 19:00:47','2017-09-02 01:22:19',NULL,1504315332,30000,10000,30000,0,30000,1504315339,0,0),(58,'user27','$2y$10$Mka3KLSOGAmDmIXArbMjqev.ybXqV6j42tCu6BsSeBdqR7/g52Jbm','farmer','2016-09-09 19:00:47','2017-09-02 01:22:19',NULL,1504315332,30000,10000,30000,0,30000,1504315339,0,0),(59,'user28','$2y$10$/YS4Gn1w16e.oc/TIhZIdeYq9l3ha.eVqDidWPMr9.1zC7Cx9f3q2','farmer','2016-09-09 19:00:47','2017-09-02 01:22:19',NULL,1504315332,30000,10000,30000,0,30000,1504315339,0,0),(60,'user29','$2y$10$7vBLBsWwOE784PbEZM8OFOdrrezrGAX8/38xKVXk2O81leNlb6jlK','farmer','2016-09-09 19:00:47','2017-09-02 01:22:19',NULL,1504315332,30000,10000,30000,0,30000,1504315339,0,0),(61,'user30','$2y$10$1S6YQnYiC8VZnXx4fRJoTu5ADCVlFvGXEjIkju3NXF6yObc1WCyxO','farmer','2016-09-09 19:00:47','2017-09-02 01:22:20','DTxmhFbhchOsnKJdOQ4pXUvjJr4yaXgRdNuLobr6ZWtRzuyAufFALLnzIy8R',1504315332,30000,10000,30000,0,30000,1504315340,0,0),(62,'user31','$2y$10$giJ6HSWeG8jYfCDBbxm3UOOzEdGhsOVE1.yBAUCFun6gQMgIxW94S','farmer','2016-09-09 19:00:46','2017-09-02 01:22:20',NULL,1504315332,30000,10000,30000,0,30000,1504315340,0,0),(63,'user32','$2y$10$giJ6HSWeG8jYfCDBbxm3UOOzEdGhsOVE1.yBAUCFun6gQMgIxW94S','farmer','2016-09-09 19:00:46','2017-09-02 01:22:20',NULL,1504315332,30000,10000,30000,0,30000,1504315340,0,0),(64,'user33','$2y$10$giJ6HSWeG8jYfCDBbxm3UOOzEdGhsOVE1.yBAUCFun6gQMgIxW94S','farmer','2016-09-09 19:00:46','2017-09-02 01:22:21',NULL,1504315332,30000,10000,30000,0,30000,1504315341,0,0),(65,'user34','$2y$10$giJ6HSWeG8jYfCDBbxm3UOOzEdGhsOVE1.yBAUCFun6gQMgIxW94S','farmer','2016-09-09 19:00:46','2017-09-02 01:22:21',NULL,1504315332,30000,10000,30000,0,30000,1504315341,0,0),(66,'user35','$2y$10$giJ6HSWeG8jYfCDBbxm3UOOzEdGhsOVE1.yBAUCFun6gQMgIxW94S','farmer','2016-09-09 19:00:46','2017-09-02 01:22:21',NULL,1504315332,30000,10000,30000,0,30000,1504315341,0,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-02  6:52:52
