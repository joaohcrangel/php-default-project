CREATE TABLE `tb_products` (
  `idproduct` int(11) NOT NULL AUTO_INCREMENT,
  `idproducttype` int(11) NOT NULL,
  `desproduct` varchar(64) NOT NULL,
  `inremoved` tinyint(1) NOT NULL DEFAULT 0,
  `idthumb` int(11) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idproduct`),
  KEY `idproducttype` (`idproducttype`),
  CONSTRAINT `FK_products_productstypes` FOREIGN KEY (`idproducttype`) REFERENCES `tb_productstypes` (`idproducttype`),
  CONSTRAINT `FK_products_files` FOREIGN KEY(`idthumb`) REFERENCES `tb_files` (`idfile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8