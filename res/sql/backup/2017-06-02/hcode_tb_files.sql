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
-- Table structure for table `tb_files`
--

DROP TABLE IF EXISTS `tb_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_files` (
  `idfile` int(11) NOT NULL AUTO_INCREMENT,
  `desdirectory` varchar(256) NOT NULL,
  `desfile` varchar(128) NOT NULL,
  `desextension` varchar(32) NOT NULL,
  `desalias` varchar(128) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idfile`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_files`
--

LOCK TABLES `tb_files` WRITE;
/*!40000 ALTER TABLE `tb_files` DISABLE KEYS */;
INSERT INTO `tb_files` VALUES (1,'/res/uploads/','591b7d393797e','png','1464404074_facebook.png','2017-05-16 22:29:16'),(2,'/res/uploads/','591b7e7a91d9d','png','1464404074_facebook.png','2017-05-16 22:34:37'),(3,'/res/uploads/','591b7ec4bb1c8','png','1464404074_facebook.png','2017-05-16 22:35:51'),(4,'/res/uploads/','591b7f17efe06','png','1464404114_SnapChat.png','2017-05-16 22:37:15'),(5,'/res/uploads/','591b7f6c31166','png','1464404091_twitter.png','2017-05-16 22:38:39'),(6,'/res/uploads/','591b7f999fca1','png','1464404114_SnapChat.png','2017-05-16 22:39:25'),(7,'/res/uploads/','591b81d02ccf0','png','1464404074_facebook.png','2017-05-16 22:48:51'),(8,'/res/uploads/','591b8317619c8','png','cartao-verso-segundo-modelo.fw.png','2017-05-16 22:54:19'),(9,'/res/uploads/','591f49a4bf28e','jpg','download.jpg','2017-05-19 19:38:13'),(10,'/res/uploads/','591f4a2ba8bb1','jpg','download.jpg','2017-05-19 19:40:28'),(11,'/res/uploads/','591f4a9652220','png','10350413_1673904579527791_1940536857814926202_n.png','2017-05-19 19:42:15'),(12,'/res/uploads/','591f5b56499e9','jpg','atividade paraiso.jpg','2017-05-19 20:53:43'),(13,'/res/uploads/','591f68415e395','jpg','831404_d4d8_2.jpg','2017-05-19 21:48:49'),(14,'/res/uploads/','591f686001a87','png','1464404091_twitter.png','2017-05-19 21:49:20'),(15,'/res/img/hd/','html5dev-fundo.bkp','jpg','alias','2017-05-29 16:16:09'),(16,'/res/img/hd/','html5dev-fundo-cursos','jpg','alias','2017-05-29 16:16:10'),(17,'/res/uploads/','592c51a536da6','png','10350413_1673904579527791_1940536857814926202_n.png','2017-05-29 16:51:50'),(18,'/res/uploads/','592c528c46dd6','png','10350413_1673904579527791_1940536857814926202_n.png','2017-05-29 16:55:41'),(19,'/res/uploads/','592c536154c6d','png','10350413_1673904579527791_1940536857814926202_n.png','2017-05-29 16:59:13'),(20,'/res/uploads/','592c53d563ec4','png','10350413_1673904579527791_1940536857814926202_n.png','2017-05-29 17:01:09'),(21,'/res/uploads/','592c540cef80b','png','10350413_1673904579527791_1940536857814926202_n.png','2017-05-29 17:02:05'),(22,'/res/uploads/','592c54eae7e08','png','10350413_1673904579527791_1940536857814926202_n.png','2017-05-29 17:05:47'),(23,'/res/uploads/','592c5523cdcbf','png','10350413_1673904579527791_1940536857814926202_n.png','2017-05-29 17:06:44'),(24,'/res/uploads/','592c5592d3a3b','png','10350413_1673904579527791_1940536857814926202_n.png','2017-05-29 17:08:35'),(25,'/res/uploads/','592c671442e4d','png','10350413_1673904579527791_1940536857814926202_n.png','2017-05-29 18:23:16'),(26,'/res/uploads/','592c68822ba63','jpg','atividade paraiso.jpg','2017-05-29 18:29:23'),(27,'/res/uploads/','592c69af41787','png','10350413_1673904579527791_1940536857814926202_n.png','2017-05-29 18:34:24'),(28,'/res/uploads/','592c6a8db40fa','jpg','download.jpg','2017-05-29 18:38:06'),(29,'/res/uploads/','592c6eb0d6688','jpg','831404_d4d8_2.jpg','2017-05-29 18:55:44'),(30,'/res/img/curso-php7/','banner','jpg',NULL,'2017-05-30 03:14:02'),(31,'/res/img/curso-php7/','brasao','png',NULL,'2017-05-30 03:14:02'),(32,'/res/img/curso-completo-html5-css3-javascript/','banner','jpg',NULL,'2017-05-30 03:14:03'),(33,'/res/img/curso-completo-html5-css3-javascript/','brasao','png',NULL,'2017-05-30 03:14:03'),(34,'/res/uploads/','592d5eb3095a1','png','10350413_1673904579527791_1940536857814926202_n.png','2017-05-30 11:59:47'),(35,'/res/uploads/','592d5f26b62a7','png','10350413_1673904579527791_1940536857814926202_n.png','2017-05-30 12:01:42'),(36,'/res/uploads/','592d5faa9e30e','png','10350413_1673904579527791_1940536857814926202_n.png','2017-05-30 12:03:54'),(37,'/res/uploads/','592d5fb543706','jpg','download.jpg','2017-05-30 12:04:05'),(38,'/res/uploads/','592d62d285d75','png','10350413_1673904579527791_1940536857814926202_n.png','2017-05-30 12:17:22'),(39,'/res/uploads/','592d62f074e80','jpg','download.jpg','2017-05-30 12:17:52'),(40,'/res/uploads/','592d63523d8f3','jpg','674764_f980_6.jpg','2017-05-30 12:19:30'),(41,'/res/uploads/','592d638ad10d5','png','10350413_1673904579527791_1940536857814926202_n.png','2017-05-30 12:20:26'),(42,'/res/uploads/','592d63b63985c','jpg','674764_f980_6.jpg','2017-05-30 12:21:10'),(43,'/res/uploads/','592d63c44ae0d','png','10350413_1673904579527791_1940536857814926202_n.png','2017-05-30 12:21:24'),(44,'/res/uploads/','592d771bec647','jpg','IMG-20160927-WA0004.jpg','2017-05-30 13:43:56'),(45,'/res/uploads/','592d7742b42ab','jpg','IMG-20160927-WA0006.jpg','2017-05-30 13:44:36'),(46,'/res/uploads/','592d8c949c042','jpg','banner.jpg','2017-05-30 15:15:33'),(47,'/res/uploads/','592d8c9c4ee68','png','brasao.png','2017-05-30 15:15:40'),(48,'/res/uploads/','592d8ce6c3f2d','jpg','banner.jpg','2017-05-30 15:16:55'),(49,'/res/uploads/','592d8ceeca9af','png','brasao.png','2017-05-30 15:17:03'),(50,'/res/uploads/','592dc02a65f2e','jpg','16820398_f119_3.jpg','2017-05-30 18:55:38'),(51,'/res/uploads/','592dc1ea11e88','jpg','19160076_3a68_3.jpg','2017-05-30 19:03:07'),(52,'/res/uploads/','592dc2f8a988c','jpg','17073306_d1d7_2.jpg','2017-05-30 19:07:38'),(53,'/res/uploads/','592dd11ab9893','jpg','402017246_univ_sqs_sm.jpg','2017-05-30 20:07:53'),(54,'/res/uploads/','592dd133355b2','jpg','402017282_univ_sqs_sm.jpg','2017-05-30 20:08:18'),(55,'/res/uploads/','592dd14e813c1','jpg','402017283_univ_sqs_sm.jpg','2017-05-30 20:08:45'),(56,'/res/uploads/','592dd18f5cbb7','jpg','IMG_20160207_153602050.jpg','2017-05-30 20:09:50'),(57,'/res/uploads/','592dd1c0b1e6c','jpg','IMG_20160409_113756608.jpg','2017-05-30 20:10:40'),(58,'/res/uploads/','592dd1e8b0e39','jpg','402017323_univ_sqs_sm.jpg','2017-05-30 20:11:19'),(59,'/res/uploads/','592dd3499a672','jpg','IMG_20160207_143452600.jpg','2017-05-30 20:17:12'),(60,'/res/uploads/','592dd5fd0b4cc','jpg','WIN_20160509_11_14_49_Pro.jpg','2017-05-30 20:28:43'),(61,'/res/uploads/','592dd96b7576d','jpg','WIN_20160509_11_14_49_Pro.jpg','2017-05-30 20:43:22'),(62,'/res/uploads/','592ddad7a27d1','jpg','WIN_20160509_11_14_49_Pro.jpg','2017-05-30 20:49:26'),(63,'/res/uploads/','592ddb58ad6c5','jpg','WIN_20160509_11_14_49_Pro.jpg','2017-05-30 20:51:35'),(64,'/res/uploads/','592ddc7c8d283','jpg','WIN_20160509_11_14_49_Pro.jpg','2017-05-30 20:56:27'),(65,'/res/uploads/','592ddc906b566','jpg','WIN_20160509_11_33_37_Pro.jpg','2017-05-30 20:56:47'),(66,'/res/uploads/','592ddcc719775','jpg','WIN_20160509_11_14_49_Pro.jpg','2017-05-30 20:57:42'),(67,'/res/uploads/','592de3a164c11','jpg','WIN_20160509_11_14_49_Pro.jpg','2017-05-30 21:26:56'),(68,'/res/uploads/','592e32f90f575','jpg','WIN_20160509_11_24_31_Pro.jpg','2017-05-31 03:05:27'),(69,'/res/uploads/','592e3cccf213b','jpg','WIN_20160509_11_24_31_Pro.jpg','2017-05-31 03:47:23'),(70,'/res/uploads/','592ee3f21cb5d','jpg','WIN_20160509_11_14_49_Pro.jpg','2017-05-31 15:40:31'),(71,'/res/uploads/','592efba3ca126','jpg','WIN_20160509_11_14_49_Pro.jpg','2017-05-31 17:21:41'),(72,'/res/uploads/','592efbf742d33','jpg','WIN_20160509_11_33_37_Pro.jpg','2017-05-31 17:23:04'),(73,'/res/uploads/','592f07bb22db4','jpg','WIN_20160509_11_14_49_Pro.jpg','2017-05-31 18:13:16'),(74,'/res/uploads/','592f6b565575a','jpg','WIN_20160509_11_14_49_Pro.jpg','2017-06-01 01:18:15'),(75,'/res/uploads/','592f7dfe80cd8','jpg','WIN_20160509_11_14_49_Pro.jpg','2017-06-01 02:37:50'),(76,'/res/uploads/','593172c914465','png','thumb.png','2017-06-02 14:14:34');
/*!40000 ALTER TABLE `tb_files` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-02 14:05:22
