CREATE TABLE `tb_urls` (
  `idurl` int(11) NOT NULL AUTO_INCREMENT,
  `desurl` varchar(128) NOT NULL,
  `destitle` varchar(64) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idurl`),
  UNIQUE KEY `desurl_UNIQUE` (`desurl`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8