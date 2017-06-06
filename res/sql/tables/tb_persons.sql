CREATE TABLE `tb_persons` (
  `idperson` int(11) NOT NULL AUTO_INCREMENT,
  `idpersontype` int(1) NOT NULL,
  `desperson` varchar(64) NOT NULL,
  `inremoved` tinyint(1) NOT NULL DEFAULT 0,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idperson`),
  KEY `FK_personstypes` (`idpersontype`),
  CONSTRAINT `FK_persons_personstypes` FOREIGN KEY (`idpersontype`) REFERENCES `tb_personstypes` (`idpersontype`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8