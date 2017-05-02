CREATE TABLE `tb_ordersnegotiationstypes` (
  `idnegotiation` int(11) NOT NULL AUTO_INCREMENT,
  `desnegotiation` varchar(64) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idnegotiation`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8