CREATE TABLE `tb_eventsschedulesvalues` (
  `idcalendar` int(11) NOT NULL,
  `idproperty` int(11) NOT NULL,
  `desvalue` varchar(32) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcalendar`,`idproperty`),
  KEY `fk_eventsschedulesvalues_eventsproperties_idx` (`idproperty`),
  CONSTRAINT `fk_eventsschedulesvalues_eventsproperties` FOREIGN KEY (`idproperty`) REFERENCES `tb_eventsproperties` (`idproperty`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_eventsschedulesvalues_eventsschedules` FOREIGN KEY (`idcalendar`) REFERENCES `tb_eventscalendars` (`idcalendar`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1