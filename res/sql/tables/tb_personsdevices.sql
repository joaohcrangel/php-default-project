CREATE TABLE `tb_personsdevices` (
  `iddevice` int(11) NOT NULL AUTO_INCREMENT,
  `idperson` int(11) NOT NULL,
  `desdevice` varchar(128) NOT NULL,
  `desid` varchar(512) NOT NULL,
  `dessystem` varchar(128) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iddevice`),
  KEY `FK_personsdevices_persons_idx` (`idperson`),
  CONSTRAINT `FK_personsdevices_persons` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8