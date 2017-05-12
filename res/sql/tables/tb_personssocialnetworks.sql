CREATE TABLE `tb_personssocialnetworks` (
  `idperson` int(11) NOT NULL,
  `idsocialnetwork` int(11) NOT NULL,
  `desvalue` varchar(128) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `idperson` (`idperson`),
  KEY `idsocialnetwork` (`idsocialnetwork`),
  CONSTRAINT `tb_personssocialnetworks_ibfk_1` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`),
  CONSTRAINT `tb_personssocialnetworks_ibfk_2` FOREIGN KEY (`idsocialnetwork`) REFERENCES `tb_socialnetworks` (`idsocialnetwork`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8