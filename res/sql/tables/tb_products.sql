CREATE TABLE `tb_products` (
  `idproduct` int(11) NOT NULL AUTO_INCREMENT,
  `idproducttype` int(11) NOT NULL,
  `desproduct` varchar(64) NOT NULL,
  `inremoved` tinyint(1) NOT NULL DEFAULT 0,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idproduct`),
  KEY `idproducttype` (`idproducttype`),
  CONSTRAINT `tb_products_ibfk_1` FOREIGN KEY (`idproducttype`) REFERENCES `tb_productstypes` (`idproducttype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8