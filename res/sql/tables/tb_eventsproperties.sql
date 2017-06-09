CREATE TABLE `tb_eventsproperties` (
  `idproperty` int(11) NOT NULL AUTO_INCREMENT,
  `desproperty` varchar(45) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idproperty`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1