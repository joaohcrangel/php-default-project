CREATE TABLE `tb_addresses` (
  `idaddress` int(11) NOT NULL AUTO_INCREMENT,
  `idaddresstype` int(11) NOT NULL,
  `desaddress` varchar(64) NOT NULL,
  `desnumber` varchar(16) NOT NULL,
  `desdistrict` varchar(64) NOT NULL,
  `descity` varchar(64) NOT NULL,
  `desstate` varchar(32) NOT NULL,
  `descountry` varchar(32) NOT NULL,
  `descep` char(8) NOT NULL,
  `descomplement` varchar(32) DEFAULT NULL,
  `inmain` tinyint(1) NOT NULL DEFAULT 0,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idaddress`),
  KEY `FK_addressestypes` (`idaddresstype`),
  CONSTRAINT `FK_addressestypes` FOREIGN KEY (`idaddresstype`) REFERENCES `tb_addressestypes` (`idaddresstype`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8