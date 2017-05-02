CREATE TABLE `tb_documents` (
  `iddocument` int(11) NOT NULL AUTO_INCREMENT,
  `iddocumenttype` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `desdocument` varchar(64) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`iddocument`),
  KEY `FK_personsdocuments` (`idperson`),
  KEY `FK_documents` (`iddocumenttype`),
  CONSTRAINT `FK_documents` FOREIGN KEY (`iddocumenttype`) REFERENCES `tb_documentstypes` (`iddocumenttype`),
  CONSTRAINT `FK_personsdocuments` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8