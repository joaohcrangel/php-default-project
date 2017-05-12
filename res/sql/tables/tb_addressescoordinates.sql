CREATE TABLE `tb_addressescoordinates` (
  `idaddress` int(11) NOT NULL,
  `idcoordinate` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `idaddress` (`idaddress`),
  KEY `idcoordinate` (`idcoordinate`),
  CONSTRAINT `tb_addressescoordinates_ibfk_1` FOREIGN KEY (`idaddress`) REFERENCES `tb_addresses` (`idaddress`),
  CONSTRAINT `tb_addressescoordinates_ibfk_2` FOREIGN KEY (`idcoordinate`) REFERENCES `tb_coordinates` (`idcoordinate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8