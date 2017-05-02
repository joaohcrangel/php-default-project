CREATE TABLE `tb_productsprices` (
  `idprice` int(11) NOT NULL AUTO_INCREMENT,
  `idproduct` int(11) NOT NULL,
  `dtstart` datetime NOT NULL,
  `dtend` datetime DEFAULT NULL,
  `vlprice` decimal(10,2) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idprice`),
  KEY `idproduct` (`idproduct`),
  CONSTRAINT `tb_productsprices_ibfk_1` FOREIGN KEY (`idproduct`) REFERENCES `tb_products` (`idproduct`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8