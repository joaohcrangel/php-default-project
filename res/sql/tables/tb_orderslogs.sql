CREATE TABLE `tb_orderslogs` (
  `idlog` int(11) NOT NULL AUTO_INCREMENT,
  `idorder` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `dtregister` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idlog`),
  KEY `idorder` (`idorder`),
  KEY `iduser` (`iduser`),
  CONSTRAINT `tb_orderslogs_ibfk_1` FOREIGN KEY (`idorder`) REFERENCES `tb_orders` (`idorder`),
  CONSTRAINT `tb_orderslogs_ibfk_2` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8