CREATE TABLE `tb_placesfiles` (
  `idplace` int(11) NOT NULL,
  `idfile` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `idplace` (`idplace`),
  KEY `idfile` (`idfile`),
  CONSTRAINT `tb_placesfiles_ibfk_1` FOREIGN KEY (`idplace`) REFERENCES `tb_places` (`idplace`),
  CONSTRAINT `tb_placesfiles_ibfk_2` FOREIGN KEY (`idfile`) REFERENCES `tb_files` (`idfile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8