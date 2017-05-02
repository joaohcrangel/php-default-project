CREATE TABLE `tb_blogtags` (
  `idtag` int(11) NOT NULL AUTO_INCREMENT,
  `destag` varchar(32) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idtag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8