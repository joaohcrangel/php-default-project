CREATE TABLE `tb_productsfiles` (
  `idproduct` int(11) NOT NULL,
  `idfile` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idproduct`,`idfile`),
  KEY `FK_productsfiles_files_idx` (`idfile`),
  CONSTRAINT `FK_productsfiles_files` FOREIGN KEY (`idfile`) REFERENCES `tb_files` (`idfile`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_productsfiles_products` FOREIGN KEY (`idproduct`) REFERENCES `tb_products` (`idproduct`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8