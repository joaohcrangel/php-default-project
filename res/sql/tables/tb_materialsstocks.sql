CREATE TABLE `tb_materialsstocks` (
  `idstock` int(11) NOT NULL AUTO_INCREMENT,
  `idmaterial` int(11) NOT NULL,
  `dteliminated` datetime DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idstock`),
  KEY `fk_materialsstocks_idx` (`idmaterial`),
  CONSTRAINT `fk_materialsstocks` FOREIGN KEY (`idmaterial`) REFERENCES `tb_materials` (`idmaterial`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1