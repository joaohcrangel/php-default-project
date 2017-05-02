CREATE TABLE `tb_creditcards` (
  `idcard` int(11) NOT NULL AUTO_INCREMENT,
  `idperson` int(11) NOT NULL,
  `desname` varchar(64) NOT NULL,
  `dtvalidity` date NOT NULL,
  `nrcds` varchar(8) NOT NULL,
  `desnumber` char(16) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcard`),
  KEY `idperson` (`idperson`),
  CONSTRAINT `tb_creditcards_ibfk_1` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8