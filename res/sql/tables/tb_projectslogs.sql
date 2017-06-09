CREATE TABLE `tb_projectslogs` (
  `idlog` int(11) NOT NULL AUTO_INCREMENT,
  `idproject` int(11) NOT NULL,
  `idstatus` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idlog`),
  KEY `fk_projectslogs_projects_idx` (`idproject`),
  KEY `fk_projectslogs_projectsstatus_idx` (`idstatus`),
  CONSTRAINT `fk_projectslogs_projects` FOREIGN KEY (`idproject`) REFERENCES `tb_projects` (`idproject`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_projectslogs_projectsstatus` FOREIGN KEY (`idstatus`) REFERENCES `tb_projectsstatus` (`idstatus`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1