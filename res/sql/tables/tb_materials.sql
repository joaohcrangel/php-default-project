CREATE TABLE `tb_materials` (
  `idmaterial` int(11) NOT NULL AUTO_INCREMENT,
  `idmaterialparent` int(11) DEFAULT NULL,
  `idmaterialtype` int(11) NOT NULL,
  `idunitytype` int(11) NOT NULL,
  `idphoto` int(11) NOT NULL,
  `desmaterial` varchar(64) NOT NULL,
  `descode` varchar(64) NOT NULL,
  `inreusable` bit(1) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idmaterial`),
  KEY `FK_materials_materials_idx` (`idmaterialparent`),
  KEY `fk_materials_materialstypes_idx` (`idmaterialtype`),
  CONSTRAINT `fk_materials_materials` FOREIGN KEY (`idmaterialparent`) REFERENCES `tb_materials` (`idmaterial`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_materials_materialstypes` FOREIGN KEY (`idmaterialtype`) REFERENCES `tb_materialstypes` (`idtype`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_materials_materialsunittypes` FOREIGN KEY (`idmaterialtype`) REFERENCES `tb_materialsunitstypes` (`idunitytype`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1