CREATE TABLE `tb_personsaddresses` (
  `idperson` int(11) NOT NULL,
  `idaddress` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `idperson` (`idperson`),
  KEY `idaddress` (`idaddress`),
  CONSTRAINT `tb_personsaddresses_ibfk_1` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`),
  CONSTRAINT `tb_personsaddresses_ibfk_2` FOREIGN KEY (`idaddress`) REFERENCES `tb_addresses` (`idaddress`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8