CREATE TABLE `tb_placesschedules` (
  `idschedule` int(11) NOT NULL AUTO_INCREMENT,
  `idplace` int(11) NOT NULL,
  `nrday` tinyint(4) NOT NULL,
  `hropen` time DEFAULT NULL,
  `hrclose` time DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idschedule`),
  KEY `idplace` (`idplace`),
  CONSTRAINT `tb_placesschedules_ibfk_1` FOREIGN KEY (`idplace`) REFERENCES `tb_places` (`idplace`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8