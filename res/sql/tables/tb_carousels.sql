CREATE TABLE `tb_carousels` (
  `idcarousel` int(11) NOT NULL AUTO_INCREMENT,
  `descarousel` varchar(64) NOT NULL,
<<<<<<< HEAD
  `nrspeed` int(11) NOT NULL DEFAULT '300',
  `nrautoplay` int(11) NOT NULL DEFAULT '0',
  `desmode` enum('horizontal', 'vertical') NOT NULL DEFAULT 'horizontal',
  `inloop` tinyint(1) NOT NULL DEFAULT '0',
=======
  `inloop` tinyint(1) NOT NULL DEFAULT 0,
  `innav` tinyint(1) NOT NULL DEFAULT 0,
  `incenter` tinyint(1) NOT NULL DEFAULT 0,
  `inautowidth` tinyint(1) NOT NULL DEFAULT 0,
  `invideo` tinyint(1) NOT NULL DEFAULT 0,
  `inlazyload` tinyint(1) NOT NULL DEFAULT 0,
  `indots` bit(1) NOT NULL DEFAULT b'1',
>>>>>>> b50bb097b1c67643f67cbe83f6f931a3b898a1bf
  `nritems` int(11) NOT NULL DEFAULT '3',
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcarousel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8