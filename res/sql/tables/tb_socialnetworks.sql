CREATE TABLE `tb_socialnetworks` (
  `idsocialnetwork` int(11) NOT NULL AUTO_INCREMENT,
  `dessocialnetwork` varchar(128) NOT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idsocialnetwork`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8