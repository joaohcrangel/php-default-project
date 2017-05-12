CREATE TABLE `tb_configurations` (
  `idconfiguration` int(11) NOT NULL AUTO_INCREMENT,
  `desconfiguration` varchar(64) NOT NULL,
  `desvalue` varchar(2048) NOT NULL,
  `desdescription` varchar(256) DEFAULT NULL,
  `idconfigurationtype` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idconfiguration`),
  KEY `FK_configurations_configurationstypes_idx` (`idconfigurationtype`),
  KEY `IX_desconfiguration` (`desconfiguration`),
  CONSTRAINT `FK_configurations_configurationstypes` FOREIGN KEY (`idconfigurationtype`) REFERENCES `tb_configurationstypes` (`idconfigurationtype`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8