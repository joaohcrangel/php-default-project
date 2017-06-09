CREATE TABLE `tb_eventsorganizers` (
  `idorganizer` int(11) NOT NULL AUTO_INCREMENT,
  `desorganizer` varchar(64) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idorganizer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1