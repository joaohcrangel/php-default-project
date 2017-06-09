CREATE TABLE `tb_eventsfrequencies` (
  `idfrequency` int(11) NOT NULL AUTO_INCREMENT,
  `desfrequency` varchar(32) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idfrequency`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1