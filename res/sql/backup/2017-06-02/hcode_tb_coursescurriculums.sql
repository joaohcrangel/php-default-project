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
-- Table structure for table `tb_coursescurriculums`
--

DROP TABLE IF EXISTS `tb_coursescurriculums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_coursescurriculums` (
  `idcurriculum` int(11) NOT NULL AUTO_INCREMENT,
  `descurriculum` varchar(128) NOT NULL,
  `idsection` int(11) NOT NULL,
  `desdescription` varchar(2048) DEFAULT NULL,
  `nrorder` varchar(45) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcurriculum`),
  KEY `FK_coursescurriculums_coursessections_idx` (`idsection`),
  CONSTRAINT `FK_coursescurriculums_coursessections` FOREIGN KEY (`idsection`) REFERENCES `tb_coursessections` (`idsection`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_coursescurriculums`
--

LOCK TABLES `tb_coursescurriculums` WRITE;
/*!40000 ALTER TABLE `tb_coursescurriculums` DISABLE KEYS */;
INSERT INTO `tb_coursescurriculums` VALUES (1,'Introdução ao PHP',1,'testando','1','2017-05-16 19:27:00'),(2,'Começando',2,'nnnj','2','2017-05-16 19:39:08'),(3,'Continuando',1,'novamente','2','2017-05-19 17:00:01'),(4,'PHP novo',2,'<p>oi</p>','3','2017-05-19 17:20:52'),(6,'02 Banco de Dados vs. Base de Dados',4,'','2','2017-05-30 16:56:13'),(7,'03 Instalando o MySQL',4,'','3','2017-05-30 16:56:39'),(8,'04 História da Linguagem SQL',4,'','4','2017-05-30 16:57:07'),(16,'01 Boas Vindas',4,'<p><br></p>','1','2017-05-30 17:18:27'),(17,'05 MySQL Workbench e Create Database',5,'<p><br></p>','1','2017-05-30 17:34:50'),(18,' 06 Exercícios Criação de Banco de dados',5,'','2','2017-05-30 17:35:27'),(19,'07 Bancos, Tabelas, Linhas, Colunas e a Primeira Tabela',5,'','3','2017-05-30 17:35:57'),(20,'08 Exercícios de Fixação: Comandos básicos.',5,'','4','2017-05-30 17:36:26'),(23,'09 Entendendo os Tipos de Dados (Data Types)',6,'<p><br></p>','1','2017-05-30 17:40:33'),(25,'10 PDF Tipos de Dados no MySQL',6,'','2','2017-05-30 17:42:39'),(26,'11 DDL, DCL, DML, DTL, DQL',7,'<p><br></p>','1','2017-05-30 17:49:10'),(27,'12 Exercícios comandos DDL, DCL, DML, DTL, e DQL',7,'','2','2017-05-30 17:50:18'),(29,'13 - Alterando e excluindo dados',8,'<p><br></p>','1','2017-05-30 17:54:39'),(30,'14 - Dominando o comando Insert',8,'','2','2017-05-30 17:55:18'),(31,'15 - Dominando o comando Select',9,'','1','2017-05-30 17:56:15'),(32,'16 - Adicionando Filtros com Where',10,'','1','2017-05-30 17:57:19'),(33,'17 - Where Like, Between e Soundex',10,'','2','2017-05-30 17:57:43'),(34,'18 - Adicionando filtros com Datas',10,'<p><br></p>','3','2017-05-30 18:09:26'),(35,'19 - A Cláusula Order by e Limit',10,'','4','2017-05-30 18:10:11'),(36,'20 - Dominando o comando Update',11,'','1','2017-05-30 18:10:57'),(37,'21 - Dominando o comando Delete',11,'','2','2017-05-30 18:11:42'),(38,'24 - Criando e relacionando as tabelas',12,'','1','2017-05-30 18:12:16'),(39,'25 - Criando Consultas Avançadas com Joins',13,'','1','2017-05-30 18:12:59'),(40,'27 - Criando subconsultas com subquery',13,'','2','2017-05-30 18:13:43'),(41,'28 - A cláusula Group By',14,'','1','2017-05-30 18:14:29'),(42,'29 - Filtrando grupos com having',14,'','2','2017-05-30 18:14:55'),(43,'30 - Criando views',15,'','1','2017-05-30 18:15:18'),(44,'31 - Trabalhando com Stored Procedures',15,'','2','2017-05-30 18:15:39'),(45,'33 - Comandos avançados para Stored Procedures',15,'','3','2017-05-30 18:16:02'),(48,'35 - Criando Funções',15,'','4','2017-05-30 18:16:38'),(49,'36 - Encerramento',15,'','5','2017-05-30 18:17:30');
/*!40000 ALTER TABLE `tb_coursescurriculums` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-02 14:15:02
