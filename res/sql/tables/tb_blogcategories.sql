CREATE TABLE `tb_blogcategories` (
  `idcategory` int(11) NOT NULL AUTO_INCREMENT,
  `descategory` varchar(64) NOT NULL,
  `idurl` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcategory`),
  KEY `idurl` (`idurl`),
  CONSTRAINT `tb_blogcategories_ibfk_1` FOREIGN KEY (`idurl`) REFERENCES `tb_urls` (`idurl`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8