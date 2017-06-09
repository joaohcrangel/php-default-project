CREATE TABLE `tb_eventscalendarskvas` (
  `idcalendar` int(11) NOT NULL,
  `idmaterial` int(11) NOT NULL,
  `vlkva` decimal(10,2) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcalendar`,`idmaterial`),
  KEY `fk_eventskvas_materials_idx` (`idmaterial`),
  CONSTRAINT `fk_eventscalendars_eventscalendars` FOREIGN KEY (`idcalendar`) REFERENCES `tb_eventscalendars` (`idcalendar`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_eventscalendars_materials` FOREIGN KEY (`idmaterial`) REFERENCES `tb_materials` (`idmaterial`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1