-- MySQL dump 10.15  Distrib 10.0.38-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: pokraska
-- ------------------------------------------------------
-- Server version	10.0.38-MariaDB-0ubuntu0.16.04.1

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
-- Table structure for table `cars`
--

DROP TABLE IF EXISTS `cars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dtcreate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `model` varchar(100) COLLATE utf8_bin NOT NULL,
  `number` varchar(100) COLLATE utf8_bin NOT NULL,
  `fio` varchar(200) COLLATE utf8_bin NOT NULL,
  `mobile` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cars`
--

LOCK TABLES `cars` WRITE;
/*!40000 ALTER TABLE `cars` DISABLE KEYS */;
INSERT INTO `cars` VALUES (2,'2019-10-10 15:31:29','ВАЗ 2105','А354ХА','Пупкин Фёдор','8726873'),(3,'2019-10-10 19:34:00','ТАЗ 2019','Х357ЕН','Забегайло Валентин','297462780482'),(4,'2019-10-14 14:34:32','4','r234','43r34','rw4rw3'),(5,'2019-10-20 18:20:28','киа ','105','кантик','02'),(6,'2019-10-20 18:22:27','хендай','107','Женя','01'),(7,'2019-10-20 18:25:04','мазда','850','мазда','009'),(8,'2019-10-20 18:27:07','мицубиши','001','ййй','999'),(9,'2019-10-20 18:31:08','нисан','445','лоарпд','01'),(10,'2019-10-20 18:31:47','ниссан','445','вырлпа','02');
/*!40000 ALTER TABLE `cars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL COMMENT '1 - точки, 2 - заказы',
  `order_id` int(11) NOT NULL COMMENT 'id точек или заказов',
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (2,2,1,'22127054.jpg'),(3,2,1,'17543247.png'),(4,2,1,'87205461.png'),(5,2,1,'51468080.png'),(6,2,2,'50880182.png'),(7,2,2,'80766607.jpg'),(8,2,2,'52747740.jpg');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id` int(11) NOT NULL,
  `painter_id` int(11) NOT NULL,
  `dtcreate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dtclose` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0 - новый 1 - в работе 2- законечен не оплачен 3 - закрыт',
  `comments` text COLLATE utf8_bin NOT NULL,
  `pay20` tinyint(1) NOT NULL DEFAULT '0',
  `pay30` tinyint(1) NOT NULL DEFAULT '0',
  `archive` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 - активный, 1 - в архиве',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,3,4,'2019-10-01 17:02:19','2019-10-01 17:02:19',3,'1231',1,1,0),(2,2,3,'2019-10-10 17:02:27',NULL,2,'',0,0,0),(3,-1,-1,'2019-10-10 19:55:29',NULL,0,'',0,0,1),(4,-1,-1,'2019-10-10 20:52:17',NULL,0,'',0,0,1),(5,-1,-1,'2019-10-13 18:49:01',NULL,0,'',0,0,1),(6,-1,1,'2019-10-20 18:14:58','2019-10-20 18:19:07',3,'',0,0,0),(7,5,1,'2019-10-20 18:19:31','2019-10-20 18:21:43',3,'',0,0,0),(8,6,1,'2019-10-20 18:21:49','2019-10-20 18:24:12',3,'',1,1,0),(9,-1,-1,'2019-10-20 18:24:28',NULL,0,'',0,0,1),(10,7,1,'2019-10-20 18:24:33','2019-10-22 13:43:40',3,'',1,0,0),(11,8,1,'2019-10-20 18:26:41','2019-10-23 15:30:06',3,'',0,0,0),(12,10,-1,'2019-10-20 18:31:27',NULL,0,'',0,0,0),(13,-1,-1,'2019-10-20 18:36:51',NULL,0,'',0,0,1),(14,-1,-1,'2019-10-20 18:40:00',NULL,0,'',0,0,1);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `painters`
--

DROP TABLE IF EXISTS `painters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `painters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dtcreate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fio` varchar(200) COLLATE utf8_bin NOT NULL,
  `mobile` varchar(100) COLLATE utf8_bin NOT NULL,
  `image` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `painters`
--

LOCK TABLES `painters` WRITE;
/*!40000 ALTER TABLE `painters` DISABLE KEYS */;
INSERT INTO `painters` VALUES (1,'2019-10-10 11:15:07','Пупкин Василий','+79212347594',''),(3,'2019-10-10 12:03:10','Дубровина Анастасия','6868',''),(4,'2019-10-10 19:32:38','Сидоров ТИмофей','9434883743','');
/*!40000 ALTER TABLE `painters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '2 - материалы 3 - запчасти',
  `amount` float NOT NULL,
  `comment` text COLLATE utf8_bin NOT NULL,
  `code` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,1,1.3,'www',''),(2,1,1,100,'test',''),(4,1,2,2000,'полуось',''),(5,1,3,400,'Краска',''),(6,1,3,250,'Пыво и сухарики',''),(7,1,2,1,'2',''),(8,1,2,1,'2','3'),(9,1,2,111,'222','333'),(11,6,3,1050,'краска',''),(13,10,3,1610,'краска',''),(14,11,3,2970,'краска','');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `points`
--

DROP TABLE IF EXISTS `points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `coors` varchar(255) COLLATE utf8_bin NOT NULL,
  `amount` float NOT NULL DEFAULT '0',
  `comment` text COLLATE utf8_bin NOT NULL,
  `photo` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `code` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `points`
--

LOCK TABLES `points` WRITE;
/*!40000 ALTER TABLE `points` DISABLE KEYS */;
INSERT INTO `points` VALUES (2,1,'[\"223\",\"51\"]',0,'','50800686.jpg',''),(3,1,'[\"352\",\"87\"]',0,'',NULL,''),(4,1,'[\"122\",\"65\"]',222,'1221','67352576.jpg',''),(5,1,'[\"195\",\"81\"]',0,'1111111111',NULL,''),(6,1,'[\"288\",\"182\"]',0,'',NULL,''),(7,1,'[\"406\",\"191\"]',0,'',NULL,''),(8,1,'[\"131\",\"183\"]',500,'',NULL,''),(10,1,'[\"361\",\"312\"]',0,'',NULL,''),(11,1,'[\"366\",\"176\"]',0,'',NULL,''),(12,1,'[\"263\",\"171\"]',0,'',NULL,''),(13,2,'[\"259\",\"173\"]',0,'',NULL,''),(17,1,'[\"420\",\"299\"]',700,'12wde  w',NULL,''),(18,2,'[\"420\",\"302\"]',0,'',NULL,''),(20,2,'[\"129\",\"303\"]',22,'222',NULL,''),(21,6,'[\"-1\",\"-1\"]',5000,'окрас двери ',NULL,NULL),(22,6,'[\"-1\",\"-1\"]',5000,'локальный окрас крыла пп',NULL,NULL),(23,7,'[\"-1\",\"-1\"]',4000,'крыло зп',NULL,NULL),(24,7,'[\"-1\",\"-1\"]',4000,'бампер зп',NULL,NULL),(25,8,'[\"-1\",\"-1\"]',2500,'ремонт замка багажника',NULL,NULL),(26,10,'[\"-1\",\"-1\"]',8000,'окрас двери пп',NULL,NULL),(27,11,'[\"-1\",\"-1\"]',29000,'покрас бампера пер зад два крыла',NULL,NULL),(28,12,'[\"-1\",\"-1\"]',5000,'ремонт бампера ',NULL,NULL),(29,10,'[\"-1\",\"-1\"]',10,'оо',NULL,NULL);
/*!40000 ALTER TABLE `points` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-10-23 15:33:50
