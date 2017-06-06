CREATE TABLE `tb_productsdata` (
  `idproduct` int(11) NOT NULL,
  `idproducttype` int(11) NOT NULL,
  `desproduct` varchar(64) NOT NULL,
  `vlprice` decimal(10,2) DEFAULT NULL,
  `desproducttype` varchar(64) NOT NULL,
  `dtstart` datetime DEFAULT NULL,
  `dtend` datetime DEFAULT NULL,
<<<<<<< HEAD
  `inremoved` bit(1) NOT NULL DEFAULT b'0',
  `idurl` INT DEFAULT NULL,
  `desurl` VARCHAR(128) DEFAULT NULL,
=======
  `inremoved` tinyint(1) NOT NULL DEFAULT 0,
>>>>>>> b50bb097b1c67643f67cbe83f6f931a3b898a1bf
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idproduct`),
  KEY `idproducttype` (`idproducttype`),
  CONSTRAINT `tb_productsdata_ibfk_1` FOREIGN KEY (`idproduct`) REFERENCES `tb_products` (`idproduct`),
  CONSTRAINT `tb_productsdata_ibfk_2` FOREIGN KEY (`idproducttype`) REFERENCES `tb_productstypes` (`idproducttype`),
  CONSTRAINT `tb_productsdata_ibfk_3` FOREIGN KEY (`idurl`) REFERENCES `tb_urls` (`idurl`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8