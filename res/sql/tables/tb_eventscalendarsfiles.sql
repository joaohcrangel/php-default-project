CREATE TABLE `tb_eventscalendarsfiles` (
  `idcalendar` int(11) NOT NULL,
  `idfile` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcalendar`,`idfile`),
  CONSTRAINT `fk_eventscalendarsfiles_eventscalendars` FOREIGN KEY (`idcalendar`) REFERENCES `tb_eventscalendars` (`idcalendar`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1