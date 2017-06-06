CREATE TABLE `tb_blogcomments` (
  `idcomment` int(11) NOT NULL AUTO_INCREMENT,
  `idcommentfather` int(11) DEFAULT NULL,
  `idpost` int(11) NOT NULL,
  `idperson` int(11) NOT NULL,
  `descomment` text NOT NULL,
  `inapproved` tinyint(1) NOT NULL DEFAULT 0,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcomment`),
  KEY `idcommentfather` (`idcommentfather`),
  KEY `idpost` (`idpost`),
  KEY `idperson` (`idperson`),
  CONSTRAINT `tb_blogcomments_ibfk_1` FOREIGN KEY (`idcommentfather`) REFERENCES `tb_blogcomments` (`idcomment`),
  CONSTRAINT `tb_blogcomments_ibfk_2` FOREIGN KEY (`idpost`) REFERENCES `tb_blogposts` (`idpost`),
  CONSTRAINT `tb_blogcomments_ibfk_3` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8