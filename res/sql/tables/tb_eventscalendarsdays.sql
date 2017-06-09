CREATE TABLE `tb_eventscalendarsdays` (
  `idday` int(11) NOT NULL AUTO_INCREMENT,
  `idcalendar` int(11) NOT NULL,
  `dtstart` datetime NOT NULL,
  `dtend` datetime NOT NULL,
  `inevent` bit(1) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idday`),
  KEY `fk_eventscalendarsdays_eventscalendars_idx` (`idcalendar`),
  CONSTRAINT `fk_eventscalendarsdays_eventscalendars` FOREIGN KEY (`idcalendar`) REFERENCES `tb_eventscalendars` (`idcalendar`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1