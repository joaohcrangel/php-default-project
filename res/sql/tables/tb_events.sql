CREATE TABLE `tb_events` (
  `idevent` int(11) NOT NULL AUTO_INCREMENT,
  `desevent` varchar(64) NOT NULL,
  `idfrequency` int(11) NOT NULL,
  `nrfrequency` int(11) NOT NULL,
  `idorganizer` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idevent`),
  KEY `fk_events_eventsfrequencies_idx` (`idfrequency`),
  KEY `fk_events_eventsorganizers_idx` (`idorganizer`),
  CONSTRAINT `fk_events_eventsfrequencies` FOREIGN KEY (`idfrequency`) REFERENCES `tb_eventsfrequencies` (`idfrequency`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_events_eventsorganizers` FOREIGN KEY (`idorganizer`) REFERENCES `tb_eventsorganizers` (`idorganizer`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1