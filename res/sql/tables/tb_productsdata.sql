CREATE TABLE `tb_productsdata` (
  `idproduct` int(11) NOT NULL,
  `idproducttype` int(11) NOT NULL,
  `desproduct` varchar(64) NOT NULL,
  `vlprice` decimal(10,2) DEFAULT NULL,
  `desproducttype` varchar(64) NOT NULL,
  `dtstart` datetime DEFAULT NULL,
  `dtend` datetime DEFAULT NULL,
  `inremoved` tinyint(1) NOT NULL DEFAULT 0,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idproduct`),
  KEY `idproducttype` (`idproducttype`),
  CONSTRAINT `tb_productsdata_ibfk_1` FOREIGN KEY (`idproduct`) REFERENCES `tb_products` (`idproduct`),
  CONSTRAINT `tb_productsdata_ibfk_2` FOREIGN KEY (`idproducttype`) REFERENCES `tb_productstypes` (`idproducttype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8