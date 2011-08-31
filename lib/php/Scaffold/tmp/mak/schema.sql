CREATE TABLE IF NOT EXISTS `mak_kategoria` (
  `id` int(11) NOT NULL auto_increment,
  `kategoria_nev` varchar(255) collate utf8_hungarian_ci NOT NULL,
  `azonosito` varchar(255) collate utf8_hungarian_ci NOT NULL,
  `email` varchar(255) collate utf8_hungarian_ci NOT NULL,
  `telefon` varchar(255) collate utf8_hungarian_ci NOT NULL,
  `sorrend` int(2) NOT NULL,
  `modositas` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `kategoria_nev` (`kategoria_nev`),
  UNIQUE KEY `azonosito` (`azonosito`),
  UNIQUE KEY `sorrend` (`sorrend`)
)

REATE TABLE IF NOT EXISTS `mak_almenu` (
  `id` int(11) NOT NULL auto_increment,
  `url` varchar(255) collate utf8_hungarian_ci NOT NULL,
  `almenu` varchar(255) collate utf8_hungarian_ci NOT NULL,
  `kategoria_id` int(11) NOT NULL,
  `title` varchar(255) collate utf8_hungarian_ci NOT NULL,
  `keywords` varchar(255) collate utf8_hungarian_ci NOT NULL,
  `description` varchar(255) collate utf8_hungarian_ci NOT NULL,
  `sorrend` int(2) NOT NULL,
  `modositas` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `url` (`url`),
  UNIQUE KEY `sorrend` (`sorrend`)
)

REATE TABLE IF NOT EXISTS `mak_tartalom` (
  `id` int(11) NOT NULL auto_increment,
  `almenu_id` int(3) NOT NULL,
  `cim` varchar(255) collate utf8_hungarian_ci NOT NULL,
  `szoveg` text collate utf8_hungarian_ci NOT NULL,
  `kep` varchar(80) collate utf8_hungarian_ci NOT NULL,
  `alt` varchar(255) collate utf8_hungarian_ci NOT NULL,
  `sorrend` int(2) NOT NULL,
  `modositas` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
)

