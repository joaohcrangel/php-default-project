CREATE TABLE `tb_carousels` (
  `idcarousel` int(11) NOT NULL AUTO_INCREMENT,
  `descarousel` varchar(64) NOT NULL,
  `inloop` bit(1) NOT NULL DEFAULT b'0',
  `innav` bit(1) NOT NULL DEFAULT b'0',
  `incenter` bit(1) NOT NULL DEFAULT b'0',
  `inautowidth` bit(1) NOT NULL DEFAULT b'0',
  `invideo` bit(1) NOT NULL DEFAULT b'0',
  `inlazyload` bit(1) NOT NULL DEFAULT b'0',
  `indots` bit(1) NOT NULL DEFAULT b'1',
  `nritems` int(11) NOT NULL DEFAULT '3',
  `nrstagepadding` int(11) NOT NULL DEFAULT '0',
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcarousel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8