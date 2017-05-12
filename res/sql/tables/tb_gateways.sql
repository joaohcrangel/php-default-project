CREATE TABLE `tb_gateways` (
  `idgateway` int(11) NOT NULL AUTO_INCREMENT,
  `desgateway` varchar(128) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idgateway`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8