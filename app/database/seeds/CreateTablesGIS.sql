# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: us-cdbr-east-04.cleardb.com (MySQL 5.5.31-log)
# Database: heroku_ac91f93835b5206
# Generation Time: 2014-02-11 00:34:06 +0000
# ************************************************************



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table gis_counties
# ------------------------------------------------------------

DROP TABLE IF EXISTS `gis_counties`;

CREATE TABLE `gis_counties` (
  `OGR_FID` int(11) NOT NULL AUTO_INCREMENT,
  `SHAPE` geometry NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `state_name` varchar(25) DEFAULT NULL,
  `state_fips` varchar(2) DEFAULT NULL,
  `cnty_fips` varchar(3) DEFAULT NULL,
  `fips` varchar(5) DEFAULT NULL,
  UNIQUE KEY `OGR_FID` (`OGR_FID`),
  SPATIAL KEY `SHAPE` (`SHAPE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table gis_countries
# ------------------------------------------------------------

DROP TABLE IF EXISTS `gis_countries`;

CREATE TABLE `gis_countries` (
  `OGR_FID` int(11) NOT NULL AUTO_INCREMENT,
  `SHAPE` geometry NOT NULL,
  `fips` varchar(2) DEFAULT NULL,
  `iso2` varchar(2) DEFAULT NULL,
  `iso3` varchar(3) DEFAULT NULL,
  `un` decimal(3,0) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `area` decimal(7,0) DEFAULT NULL,
  `pop2005` decimal(10,0) DEFAULT NULL,
  `region` decimal(3,0) DEFAULT NULL,
  `subregion` decimal(3,0) DEFAULT NULL,
  `lon` double(8,3) DEFAULT NULL,
  `lat` double(7,3) DEFAULT NULL,
  UNIQUE KEY `OGR_FID` (`OGR_FID`),
  SPATIAL KEY `SHAPE` (`SHAPE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table gis_states
# ------------------------------------------------------------

DROP TABLE IF EXISTS `gis_states`;

CREATE TABLE `gis_states` (
  `OGR_FID` int(11) NOT NULL AUTO_INCREMENT,
  `SHAPE` geometry NOT NULL,
  `state_name` varchar(25) DEFAULT NULL,
  `drawseq` decimal(2,0) DEFAULT NULL,
  `state_fips` varchar(2) DEFAULT NULL,
  `sub_region` varchar(20) DEFAULT NULL,
  `state_abbr` varchar(2) DEFAULT NULL,
  UNIQUE KEY `OGR_FID` (`OGR_FID`),
  SPATIAL KEY `SHAPE` (`SHAPE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table gis_territories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `gis_territories`;

CREATE TABLE `gis_territories` (
  `areaid` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `uid` int(10) DEFAULT NULL,
  `geom` geometry DEFAULT NULL,
  `areatype` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`areaid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table gis_zipcodes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `gis_zipcodes`;

CREATE TABLE `gis_zipcodes` (
  `OGR_FID` int(11) NOT NULL AUTO_INCREMENT,
  `SHAPE` geometry NOT NULL,
  `zip` varchar(5) DEFAULT NULL,
  `po_name` varchar(28) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `sumblkpop` decimal(9,0) DEFAULT NULL,
  `pop2007` decimal(9,0) DEFAULT NULL,
  `pop07_sqmi` double(10,1) DEFAULT NULL,
  `sqmi` double(12,2) DEFAULT NULL,
  `oid` decimal(9,0) DEFAULT NULL,
  UNIQUE KEY `OGR_FID` (`OGR_FID`),
  SPATIAL KEY `SHAPE` (`SHAPE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
