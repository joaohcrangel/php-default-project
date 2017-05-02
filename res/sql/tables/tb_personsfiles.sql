CREATE TABLE `tb_personsfiles` (
  `idperson` int(11) NOT NULL,
  `idfile` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idperson`,`idfile`),
  KEY `FK_personsfiles_files_idx` (`idfile`),
  CONSTRAINT `FK_personsfiles_files` FOREIGN KEY (`idfile`) REFERENCES `tb_files` (`idfile`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_personsfiles_persons` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8