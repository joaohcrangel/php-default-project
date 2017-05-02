CREATE TABLE `tb_coordinates` (
  `idcoordinate` int(11) NOT NULL AUTO_INCREMENT,
  `vllatitude` decimal(20,17) NOT NULL,
  `vllongitude` decimal(20,17) NOT NULL,
  `nrzoom` tinyint(4) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcoordinate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8