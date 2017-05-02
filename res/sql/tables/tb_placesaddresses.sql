CREATE TABLE `tb_placesaddresses` (
  `idplace` int(11) NOT NULL,
  `idaddress` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `idplace` (`idplace`),
  KEY `idaddress` (`idaddress`),
  CONSTRAINT `tb_placesaddresses_ibfk_1` FOREIGN KEY (`idplace`) REFERENCES `tb_places` (`idplace`),
  CONSTRAINT `tb_placesaddresses_ibfk_2` FOREIGN KEY (`idaddress`) REFERENCES `tb_addresses` (`idaddress`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8