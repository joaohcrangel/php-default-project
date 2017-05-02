CREATE TABLE `tb_documentstypes` (
  `iddocumenttype` int(11) NOT NULL AUTO_INCREMENT,
  `desdocumenttype` varchar(64) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`iddocumenttype`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8