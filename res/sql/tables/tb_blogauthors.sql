CREATE TABLE `tb_blogauthors` (
  `idauthor` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `desauthor` varchar(32) NOT NULL,
  `desresume` varchar(512) DEFAULT NULL,
  `idphoto` int(11) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idauthor`),
  KEY `iduser` (`iduser`),
  KEY `idphoto` (`idphoto`),
  CONSTRAINT `tb_blogauthors_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `tb_users` (`iduser`),
  CONSTRAINT `tb_blogauthors_ibfk_2` FOREIGN KEY (`idphoto`) REFERENCES `tb_files` (`idfile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8