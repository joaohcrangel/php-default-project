CREATE TABLE `tb_eventscalendars` (
  `idcalendar` int(11) NOT NULL AUTO_INCREMENT,
  `idevent` int(11) NOT NULL,
  `idplace` int(11) NOT NULL,
  `dtstart` datetime NOT NULL,
  `dtend` datetime NOT NULL,
  `desurl` varchar(128) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcalendar`),
  KEY `fk_eventsschedules_events_idx` (`idevent`),
  CONSTRAINT `fk_eventsschedules_events` FOREIGN KEY (`idevent`) REFERENCES `tb_events` (`idevent`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1