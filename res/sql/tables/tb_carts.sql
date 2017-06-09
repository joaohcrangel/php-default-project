CREATE TABLE `tb_carts` (
  `idcart` int(11) NOT NULL AUTO_INCREMENT,
  `idperson` int(11) NULL,
  `dessession` varchar(128) NOT NULL,
  `inclosed` bit(1) DEFAULT NULL,
  `nrproducts` int(11) DEFAULT NULL,
  `vltotal` decimal(10,2) DEFAULT NULL,
  `vltotalgross` decimal(10,2) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcart`),
  KEY `idperson` (`idperson`),
  CONSTRAINT `tb_carts_ibfk_1` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8