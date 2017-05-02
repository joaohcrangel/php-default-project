CREATE TABLE `tb_formspayments` (
  `idformpayment` int(11) NOT NULL AUTO_INCREMENT,
  `idgateway` int(11) NOT NULL,
  `desformpayment` varchar(128) NOT NULL,
  `nrparcelsmax` int(11) NOT NULL,
  `instatus` bit(1) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idformpayment`),
  KEY `idgateway` (`idgateway`),
  CONSTRAINT `tb_formspayments_ibfk_1` FOREIGN KEY (`idgateway`) REFERENCES `tb_gateways` (`idgateway`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8