CREATE TABLE `tb_materialsproperties` (
  `idproperty` int(11) NOT NULL AUTO_INCREMENT,
  `desproperty` varchar(32) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idproperty`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1