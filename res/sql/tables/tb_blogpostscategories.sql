CREATE TABLE `tb_blogpostscategories` (
  `idpost` int(11) NOT NULL,
  `idcategory` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `idpost` (`idpost`),
  KEY `idcategory` (`idcategory`),
  CONSTRAINT `tb_blogpostscategories_ibfk_1` FOREIGN KEY (`idpost`) REFERENCES `tb_blogposts` (`idpost`),
  CONSTRAINT `tb_blogpostscategories_ibfk_2` FOREIGN KEY (`idcategory`) REFERENCES `tb_blogcategories` (`idcategory`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8