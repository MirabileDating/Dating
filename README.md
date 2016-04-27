# PHP Dating script - release 10 may 2016.
Online php dating script based on MariaDB/Mysql, PHP, Blitz template engine and geoip


Feel free to join development

Requirements

Applications:
*PHP > 5.4
*Mysql/MariaDB
*Nginx/Apache

mods:
*Blitz
*Geoip


SQL:
CREATE DATABASE IF NOT EXISTS `dating` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `dating`;
CREATE TABLE IF NOT EXISTS `onlineusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_ip` varchar(15) DEFAULT NULL,
  `session_id` varchar(64) DEFAULT NULL,
  `last_active` datetime DEFAULT NULL,
  `user_id` varchar(32) DEFAULT NULL,
  `user_agent` varchar(250) DEFAULT NULL,
  `user_country` varchar(75) DEFAULT NULL,
  `user_state` varchar(75) DEFAULT NULL,
  `user_city` varchar(75) DEFAULT NULL,
  `user_referer` varchar(255) DEFAULT NULL,
  `note` varchar(100) DEFAULT NULL,
  `update_counter` int(11) DEFAULT '0',
  KEY `Indeksi 1` (`id`)
) ENGINE=TokuDB DEFAULT CHARSET=utf8 `compression`='tokudb_zlib';

DELIMITER //
CREATE TRIGGER `onlineusers_after_update` BEFORE UPDATE ON `onlineusers` FOR EACH ROW BEGIN
	SET New.update_counter = OLD.update_counter + 1;
END//
DELIMITER ;

