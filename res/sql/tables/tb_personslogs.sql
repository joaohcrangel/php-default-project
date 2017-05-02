CREATE TABLE `tb_personslogs` (
  `idpersonlog` int(11) NOT NULL AUTO_INCREMENT,
  `idperson` int(11) NOT NULL,
  `idlogtype` int(11) NOT NULL,
  `deslog` varchar(512) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idpersonlog`),
  KEY `fk_personslogs_logstypes` (`idlogtype`),
  KEY `fk_personslogs_persons_idx` (`idperson`),
  CONSTRAINT `fk_personslogs_persons` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_personslogs_personslogstypes` FOREIGN KEY (`idlogtype`) REFERENCES `tb_personslogstypes` (`idlogtype`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8