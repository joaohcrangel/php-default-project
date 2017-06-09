CREATE TABLE `tb_materialspropertiesvalues` (
  `idmaterial` int(11) NOT NULL,
  `idproperty` int(11) NOT NULL,
  `desvalue` varchar(32) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idmaterial`,`idproperty`),
  KEY `fk_materialspropertiesvalues_materialsproperties_idx` (`idproperty`),
  CONSTRAINT `fk_materialspropertiesvalues_materials` FOREIGN KEY (`idmaterial`) REFERENCES `tb_materials` (`idmaterial`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_materialspropertiesvalues_materialsproperties` FOREIGN KEY (`idproperty`) REFERENCES `tb_materialsproperties` (`idproperty`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1