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
-- Table structure for table `tb_productsdata`
--

DROP TABLE IF EXISTS `tb_productsdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_productsdata` (
  `idproduct` int(11) NOT NULL,
  `idproducttype` int(11) NOT NULL,
  `desproduct` varchar(64) NOT NULL,
  `vlprice` decimal(10,2) DEFAULT NULL,
  `desproducttype` varchar(64) NOT NULL,
  `dtstart` datetime DEFAULT NULL,
  `dtend` datetime DEFAULT NULL,
  `inremoved` bit(1) NOT NULL DEFAULT b'0',
  `desurl` varchar(128) DEFAULT NULL,
  `idprice` int(11) DEFAULT NULL,
  `vlpriceold` decimal(10,2) DEFAULT NULL,
  `idpriceold` int(11) DEFAULT NULL,
  `idthumb` int(11) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idproduct`),
  KEY `idproducttype` (`idproducttype`),
  CONSTRAINT `tb_productsdata_ibfk_1` FOREIGN KEY (`idproduct`) REFERENCES `tb_products` (`idproduct`),
  CONSTRAINT `tb_productsdata_ibfk_2` FOREIGN KEY (`idproducttype`) REFERENCES `tb_productstypes` (`idproducttype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_productsdata`
--

LOCK TABLES `tb_productsdata` WRITE;
/*!40000 ALTER TABLE `tb_productsdata` DISABLE KEYS */;
INSERT INTO `tb_productsdata` VALUES (1,1,'PHP7',29.99,'Curso Udemy','2017-05-16 17:21:48',NULL,'\0',NULL,NULL,NULL,NULL,NULL,'2017-05-16 17:21:48'),(2,1,'PHP7',29.99,'Curso Udemy','2017-05-16 17:38:46',NULL,'\0',NULL,NULL,NULL,NULL,NULL,'2017-05-16 17:38:46'),(3,1,'PHP7',29.99,'Curso Udemy','2017-05-16 17:40:09',NULL,'\0',NULL,NULL,NULL,NULL,NULL,'2017-05-16 17:40:09'),(4,1,'PHP7',29.99,'Curso Udemy','2017-05-16 18:24:27',NULL,'\0',NULL,NULL,NULL,NULL,NULL,'2017-05-16 18:24:27'),(5,1,'PHP7',30.00,'Curso Udemy','2017-05-16 18:34:49',NULL,'\0',NULL,NULL,NULL,NULL,NULL,'2017-05-16 18:34:49'),(6,1,'PHP7',50.00,'Curso Udemy','2017-05-17 14:00:13',NULL,'\0',NULL,10,100.00,9,8,'2017-05-17 14:00:13'),(7,1,'Curso do Desenvolvedor Web',45.00,'Curso Udemy','2017-05-16 18:42:03',NULL,'\0',NULL,NULL,NULL,NULL,NULL,'2017-05-16 18:42:03'),(8,1,'Curso do Desenvolvedor Web',99.00,'Curso Udemy','2017-06-02 14:13:40',NULL,'\0',NULL,13,NULL,NULL,76,'2017-06-02 14:14:42'),(9,1,'MySQL',25.00,'Curso Udemy','2017-05-30 19:21:59',NULL,'\0',NULL,12,70.00,11,0,'2017-05-30 19:21:59');
/*!40000 ALTER TABLE `tb_productsdata` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-02 14:11:06
