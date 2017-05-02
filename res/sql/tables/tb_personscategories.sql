CREATE TABLE `tb_personscategories` (
  `idperson` int(11) NOT NULL,
  `idcategory` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idperson`,`idcategory`),
  KEY `FK_personscategories_personscategoriestypes_idx` (`idcategory`),
  CONSTRAINT `FK_personscategories_persons` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_personscategories_personscategoriestypes` FOREIGN KEY (`idcategory`) REFERENCES `tb_personscategoriestypes` (`idcategory`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8