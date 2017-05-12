CREATE TABLE `tb_orders` (
  `idorder` int(11) NOT NULL AUTO_INCREMENT,
  `idperson` int(11) NOT NULL,
  `idformpayment` int(11) NOT NULL,
  `idstatus` int(11) NOT NULL,
  `dessession` varchar(128) NOT NULL,
  `vltotal` decimal(10,2) NOT NULL,
  `nrparcels` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idorder`),
  KEY `idperson` (`idperson`),
  KEY `idformpayment` (`idformpayment`),
  KEY `idstatus` (`idstatus`),
  CONSTRAINT `tb_orders_ibfk_1` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`),
  CONSTRAINT `tb_orders_ibfk_2` FOREIGN KEY (`idformpayment`) REFERENCES `tb_formspayments` (`idformpayment`),
  CONSTRAINT `tb_orders_ibfk_3` FOREIGN KEY (`idstatus`) REFERENCES `tb_ordersstatus` (`idstatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8