CREATE TABLE `tb_workersroles` (
  `idrole` int(11) NOT NULL AUTO_INCREMENT,
  `desrole` int(11) NOT NULL,
  `inadmin` bit(1) NOT NULL DEFAULT b'0',
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idrole`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1