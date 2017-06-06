CREATE TABLE `tb_productsdata` (
  `idproduct` int(11) NOT NULL,
  `idproducttype` int(11) NOT NULL,
  `desproduct` varchar(64) NOT NULL,
  `vlprice` decimal(10,2) DEFAULT NULL,
  `desproducttype` varchar(64) NOT NULL,
  `dtstart` datetime DEFAULT NULL,
  `dtend` datetime DEFAULT NULL,
  `inremoved` tinyint(1) NOT NULL DEFAULT 0,
  `idurl` INT DEFAULT NULL,
  `desurl` VARCHAR(128) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idproduct`),
  KEY `idproducttype` (`idproducttype`),
  CONSTRAINT `FK_productsdata_products` FOREIGN KEY (`idproduct`) REFERENCES `tb_products` (`idproduct`),
  CONSTRAINT `FK_productsdata_productstypes` FOREIGN KEY (`idproducttype`) REFERENCES `tb_productstypes` (`idproducttype`),
  CONSTRAINT `FK_productsdata_urls` FOREIGN KEY (`idurl`) REFERENCES `tb_urls` (`idurl`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8