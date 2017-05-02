CREATE TABLE `tb_emails` (
  `idemail` int(11) NOT NULL AUTO_INCREMENT,
  `desemail` varchar(256) NOT NULL,
  `dessubject` varchar(256) NOT NULL,
  `desbody` text NOT NULL,
  `desbcc` varchar(256) DEFAULT NULL,
  `descc` varchar(256) DEFAULT NULL,
  `desreplyto` varchar(256) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idemail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8