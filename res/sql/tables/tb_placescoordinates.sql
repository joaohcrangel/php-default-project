CREATE TABLE `tb_placescoordinates` (
  `idplace` int(11) NOT NULL,
  `idcoordinate` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `idplace` (`idplace`),
  KEY `idcoordinate` (`idcoordinate`),
  CONSTRAINT `tb_placescoordinates_ibfk_1` FOREIGN KEY (`idplace`) REFERENCES `tb_places` (`idplace`),
  CONSTRAINT `tb_placescoordinates_ibfk_2` FOREIGN KEY (`idcoordinate`) REFERENCES `tb_coordinates` (`idcoordinate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8