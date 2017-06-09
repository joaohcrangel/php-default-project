CREATE TABLE `tb_projectsitemsrelations` (
  `idproject` int(11) NOT NULL,
  `iditem` int(11) NOT NULL,
  `vlqtd` int(11) NOT NULL,
  `desobs` varchar(512) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idproject`),
  KEY `fk_projectsitemsrelations_projectsitems_idx` (`iditem`),
  CONSTRAINT `fk_projectsitemsrelations_projects` FOREIGN KEY (`idproject`) REFERENCES `tb_projects` (`idproject`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_projectsitemsrelations_projectsitems` FOREIGN KEY (`iditem`) REFERENCES `tb_projectsitems` (`iditem`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1