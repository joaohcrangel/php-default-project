CREATE TABLE `tb_carousels` (
  `idcarousel` int(11) NOT NULL AUTO_INCREMENT,
  `descarousel` varchar(64) NOT NULL,
  `inloop` tinyint(1) NOT NULL DEFAULT 0,
  `innav` tinyint(1) NOT NULL DEFAULT 0,
  `incenter` tinyint(1) NOT NULL DEFAULT 0,
  `inautowidth` tinyint(1) NOT NULL DEFAULT 0,
  `invideo` tinyint(1) NOT NULL DEFAULT 0,
  `inlazyload` tinyint(1) NOT NULL DEFAULT 0,
  `indots` bit(1) NOT NULL DEFAULT b'1',
  `nritems` int(11) NOT NULL DEFAULT '3',
  `nrstagepadding` int(11) NOT NULL DEFAULT '0',
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcarousel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8