CREATE TABLE `tb_transactionscategories` (
  `idcategory` int(11) NOT NULL AUTO_INCREMENT,
  `descategory` varchar(64) NOT NULL,
  `idcategoryfather` int(11) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcategory`),
  KEY `fk_transactionscategories_transactionscategories_idx` (`idcategoryfather`),
  CONSTRAINT `fk_transactionscategories_transactionscategories` FOREIGN KEY (`idcategoryfather`) REFERENCES `tb_transactionscategories` (`idcategory`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8