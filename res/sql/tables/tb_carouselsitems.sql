CREATE TABLE `tb_carouselsitems` (
  `iditem` int(11) NOT NULL AUTO_INCREMENT,
  `desitem` varchar(45) NOT NULL,
  `descontent` text,
  `nrorder` varchar(45) NOT NULL DEFAULT '0',
  `idtype` int(11) NOT NULL,
  `idcover` int(11) NOT NULL,
  `idcarousel` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`iditem`),
  KEY `FK_carouselsitems_files_idx` (`idcover`),
  KEY `FK_carouselsitems_carousels_idx` (`idcarousel`),
  KEY `FK_carouselsitems_carouselsitemstypes_idx` (`idtype`),
  CONSTRAINT `FK_carouselsitems_carousels` FOREIGN KEY (`idcarousel`) REFERENCES `tb_carousels` (`idcarousel`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_carouselsitems_carouselsitemstypes` FOREIGN KEY (`idtype`) REFERENCES `tb_carouselsitemstypes` (`idtype`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_carouselsitems_files` FOREIGN KEY(`idcover`) REFERENCES `tb_files`(`idfile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8