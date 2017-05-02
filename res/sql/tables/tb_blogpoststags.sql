CREATE TABLE `tb_blogpoststags` (
  `idpost` int(11) NOT NULL,
  `idtag` int(11) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `idpost` (`idpost`),
  KEY `idtag` (`idtag`),
  CONSTRAINT `tb_blogpoststags_ibfk_1` FOREIGN KEY (`idpost`) REFERENCES `tb_blogposts` (`idpost`),
  CONSTRAINT `tb_blogpoststags_ibfk_2` FOREIGN KEY (`idtag`) REFERENCES `tb_blogtags` (`idtag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8