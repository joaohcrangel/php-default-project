CREATE TABLE `tb_workersroleslogs` (
  `idhistory` int(11) NOT NULL AUTO_INCREMENT,
  `idworker` int(11) NOT NULL,
  `idrole` int(11) NOT NULL,
  `vlsalary` decimal(10,2) NOT NULL,
  `dtstart` date NOT NULL,
  `dtend` date DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idhistory`),
  KEY `fk_workersroleshistorical_workersroles_idx` (`idrole`),
  KEY `fk_workersroleshistorical_workers_idx` (`idworker`),
  CONSTRAINT `fk_workersroleshistorical_workers` FOREIGN KEY (`idworker`) REFERENCES `tb_workers` (`idworker`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_workersroleshistorical_workersroles` FOREIGN KEY (`idrole`) REFERENCES `tb_workersroles` (`idrole`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1