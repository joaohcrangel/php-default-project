CREATE TABLE `tb_products` (
  `idproduct` int(11) NOT NULL AUTO_INCREMENT,
  `idproducttype` int(11) NOT NULL,
  `desproduct` varchar(64) NOT NULL,
  `inremoved` tinyint(1) NOT NULL DEFAULT '0',
  `idthumb` int(11) DEFAULT NULL,
  `descode` varchar(64) DEFAULT NULL,
  `desbarcode` char(13) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idproduct`),
  KEY `idproducttype` (`idproducttype`),
  KEY `FK_products_files` (`idthumb`),
  CONSTRAINT `FK_products_files` FOREIGN KEY (`idthumb`) REFERENCES `tb_files` (`idfile`),
  CONSTRAINT `FK_products_productstypes` FOREIGN KEY (`idproducttype`) REFERENCES `tb_productstypes` (`idproducttype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8