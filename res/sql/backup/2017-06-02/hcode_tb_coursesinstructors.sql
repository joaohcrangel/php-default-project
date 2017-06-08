CREATE DATABASE  IF NOT EXISTS `hcode` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `hcode`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 104.131.120.158    Database: hcode
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

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
-- Table structure for table `tb_coursesinstructors`
--

DROP TABLE IF EXISTS `tb_coursesinstructors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_coursesinstructors` (
  `idcourse` int(11) NOT NULL,
  `idinstructor` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `fk_coursesinstructors_courses` (`idcourse`),
  KEY `fk_coursesinstructors_instructors` (`idinstructor`),
  CONSTRAINT `fk_coursesinstructors_courses` FOREIGN KEY (`idcourse`) REFERENCES `tb_courses` (`idcourse`),
  CONSTRAINT `fk_coursesinstructors_instructors` FOREIGN KEY (`idinstructor`) REFERENCES `tb_instructors` (`idinstructor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_coursesinstructors`
--

LOCK TABLES `tb_coursesinstructors` WRITE;
/*!40000 ALTER TABLE `tb_coursesinstructors` DISABLE KEYS */;
INSERT INTO `tb_coursesinstructors` VALUES (3,2,'2017-05-23 13:09:51'),(2,2,'2017-05-30 14:39:45'),(4,2,'2017-05-30 16:48:05'),(4,4,'2017-05-30 19:19:47'),(4,5,'2017-05-30 19:19:49'),(3,4,'2017-05-30 20:07:55'),(3,5,'2017-05-30 20:07:57'),(2,4,'2017-05-30 20:09:32'),(2,5,'2017-05-30 20:09:35');
/*!40000 ALTER TABLE `tb_coursesinstructors` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-02 14:11:39
