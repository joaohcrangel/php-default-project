CREATE TABLE `tb_ordersnegotiations` (
  `idnegotiation` int(11) NOT NULL,
  `idorder` int(11) NOT NULL,
  `dtstart` datetime NOT NULL,
  `dtend` datetime DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idnegotiation`,`idorder`),
  KEY `FK_ordersnegotiations_orders_idx` (`idorder`),
  CONSTRAINT `FK_ordersnegotiations_orders` FOREIGN KEY (`idorder`) REFERENCES `tb_orders` (`idorder`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_ordersnegotiations_ordersnegotiationstypes` FOREIGN KEY (`idorder`) REFERENCES `tb_ordersnegotiationstypes` (`idnegotiation`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8