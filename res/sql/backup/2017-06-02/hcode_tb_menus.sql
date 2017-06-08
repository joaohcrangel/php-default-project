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
-- Table structure for table `tb_menus`
--

DROP TABLE IF EXISTS `tb_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tb_menus` (
  `idmenu` int(11) NOT NULL AUTO_INCREMENT,
  `idmenufather` int(11) DEFAULT NULL,
  `desmenu` varchar(128) NOT NULL,
  `desicon` varchar(64) NOT NULL,
  `deshref` varchar(64) NOT NULL,
  `nrorder` int(11) NOT NULL,
  `nrsubmenus` int(11) DEFAULT '0',
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idmenu`),
  KEY `FK_menus_menus` (`idmenufather`),
  CONSTRAINT `FK_menus_menus` FOREIGN KEY (`idmenufather`) REFERENCES `tb_menus` (`idmenu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_menus`
--

LOCK TABLES `tb_menus` WRITE;
/*!40000 ALTER TABLE `tb_menus` DISABLE KEYS */;
INSERT INTO `tb_menus` VALUES (1,NULL,'Dashboard','md-view-dashboard','/',0,0,'2017-04-18 16:17:58'),(2,NULL,'Sistema','md-code-setting','#',1,3,'2017-04-18 16:17:58'),(3,NULL,'Administração','md-settings','#',2,9,'2017-04-18 16:17:59'),(4,NULL,'Pessoas','md-accounts','/persons',3,0,'2017-04-18 16:17:58'),(5,3,'Tipos','md-collection-item','#',0,19,'2017-04-18 16:17:59'),(6,3,'Menu','','/system/menu',1,0,'2017-04-18 16:17:58'),(7,3,'Usuários','','/system/users',2,0,'2017-04-18 16:17:58'),(8,3,'Configurações','','/system/configurations',3,0,'2017-04-18 16:17:58'),(9,2,'SQL to CLASS','','/system/sql-to-class',0,0,'2017-04-18 16:17:58'),(10,2,'Template','','/../res/theme/material/base/html/index.html',1,0,'2017-04-18 16:17:58'),(11,2,'Exemplos','','#',2,1,'2017-04-18 16:17:59'),(12,11,'Upload de Arquivos','','/exemplos/upload',0,0,'2017-04-18 16:17:59'),(13,3,'Permissões','','/permissions',3,0,'2017-04-18 16:17:59'),(14,NULL,'Produtos','md-devices','/products',4,0,'2017-04-18 16:17:59'),(15,5,'Endereços Tipos','','/addresses-types',0,0,'2017-04-18 16:17:59'),(16,5,'Usuário Tipos','','/users-types',1,0,'2017-04-18 16:17:59'),(17,5,'Documentos Tipos','','/documents-types',2,0,'2017-04-18 16:17:59'),(18,5,'Lugares Tipos','','/places-types',3,0,'2017-04-18 16:17:59'),(19,5,'Cupons Tipos','','/cupons-types',4,0,'2017-04-18 16:17:59'),(20,5,'Produtos Tipos','','/products-types',5,0,'2017-04-18 16:17:59'),(21,5,'Pedidos Status','','/orders-status',6,0,'2017-04-18 16:17:59'),(22,5,'Pessoas Tipos','','/persons-types',7,0,'2017-04-18 16:17:59'),(23,5,'Contatos Tipos','','/contacts-types',8,0,'2017-04-18 16:17:59'),(24,5,'Gateways','','/gateways',9,0,'2017-04-18 16:17:59'),(25,5,'Historicos Tipos','','/logs-types',10,0,'2017-04-18 16:17:59'),(26,5,'Formas de Pagamentos','','/formas-pagamentos',11,0,'2017-04-18 16:17:59'),(27,5,'Pessoas Valores Campos','','/persons-valuesfields',11,0,'2017-04-18 16:17:59'),(28,5,'Configurações Tipos','','/configurations-types',12,0,'2017-04-18 16:17:59'),(29,5,'Carousels Items Tipos','','/carousels-types',13,0,'2017-04-18 16:17:59'),(30,5,'Pedidos Negociações Tipos','','/ordersnegotiationstypes',13,0,'2017-04-18 16:17:59'),(31,NULL,'Pedidos','md-money-box','/orders',5,0,'2017-04-18 16:17:59'),(32,NULL,'Carrinhos','md-shopping-cart','/carts',6,0,'2017-04-18 16:17:59'),(33,NULL,'Lugares','md-city','/places',7,0,'2017-04-18 16:17:59'),(34,NULL,'Site','md-view-web','#',8,3,'2017-04-18 16:17:59'),(35,34,'Menu','','/site/menu',0,0,'2017-04-18 16:17:59'),(36,NULL,'Cursos','md-book','/courses',9,0,'2017-04-18 16:17:59'),(37,34,'Carousels','','/carousels',1,0,'2017-04-18 16:17:59'),(38,3,'Países','','/countries',5,0,'2017-04-18 16:17:59'),(39,3,'Estados','','/states',6,0,'2017-04-18 16:17:59'),(40,3,'Cidades','','/cities',7,0,'2017-04-18 16:17:59'),(41,3,'Arquivos','','/files',8,0,'2017-04-18 16:17:59'),(42,5,'Categorias de Pessoas','','/persons-categories-types',14,0,'2017-04-18 16:17:59'),(43,5,'Histórico de Usuário','','/userslogs-types',15,0,'2017-04-18 16:17:59'),(44,5,'Transações tipos','','/transactions-types',16,0,'2017-04-18 16:17:59'),(45,NULL,'URLs','md-link','/urls',10,0,'2017-04-18 16:17:59'),(46,34,'Blog','','#',2,5,'2017-04-18 16:17:59'),(47,46,'Principal','','/blog/posts',0,0,'2017-04-18 16:17:59'),(48,46,'Novo Post','','/blog/posts/new',1,0,'2017-04-18 16:17:59'),(49,46,'Categorias','','/blog/categories',2,0,'2017-04-18 16:17:59'),(50,46,'Tags','','/blog/tags',3,0,'2017-04-18 16:17:59'),(51,46,'Comentários','','/blog/comments',4,0,'2017-04-18 16:17:59'),(52,NULL,'Serviço de E-mails','md-email','/emails',11,0,'2017-04-18 16:17:59'),(53,NULL,'Fluxo de Caixa','md-money-box','/fluxo-de-caixa',11,0,'2017-04-18 16:17:59'),(54,NULL,'Instrutores','','/instructors',12,0,'2017-05-19 18:37:07');
/*!40000 ALTER TABLE `tb_menus` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-06-02 14:10:59
