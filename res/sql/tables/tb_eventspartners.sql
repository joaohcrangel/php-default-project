CREATE TABLE `tb_eventspartners` (
  `idcalendar` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idperson`,`idcalendar`),
  KEY `fk_eventspartners_eventscalendars_idx` (`idcalendar`),
  CONSTRAINT `fk_eventspartners_eventscalendars` FOREIGN KEY (`idcalendar`) REFERENCES `tb_eventscalendars` (`idcalendar`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1