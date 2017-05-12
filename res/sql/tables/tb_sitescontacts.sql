CREATE TABLE `tb_sitescontacts` (
  `idsitecontact` int(11) NOT NULL AUTO_INCREMENT,
  `idperson` int(11) NOT NULL,
  `idpersonanswer` int(11) DEFAULT NULL,
  `desmessage` varchar(2048) NOT NULL,
  `inread` bit(1) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idsitecontact`),
  KEY `idperson` (`idperson`),
  CONSTRAINT `tb_sitescontacts_ibfk_1` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8