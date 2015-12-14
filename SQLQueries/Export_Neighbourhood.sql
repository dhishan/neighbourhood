CREATE DATABASE  IF NOT EXISTS `nextdoordb` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `NextdoorDB`;
-- MySQL dump 10.13  Distrib 5.7.9, for osx10.9 (x86_64)
--
-- Host: localhost    Database: NextdoorDB
-- ------------------------------------------------------
-- Server version	5.5.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `blocks`
--

DROP TABLE IF EXISTS `blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blocks` (
  `bid` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `nid` int(6) NOT NULL,
  `ne_latitude` decimal(9,6) NOT NULL,
  `ne_longitude` decimal(9,6) NOT NULL,
  `nw_latitude` decimal(9,6) NOT NULL,
  `nw_longitude` decimal(9,6) NOT NULL,
  `sw_latitude` decimal(9,6) NOT NULL,
  `sw_longitude` decimal(9,6) NOT NULL,
  `se_latitude` decimal(9,6) NOT NULL,
  `se_longitude` decimal(9,6) NOT NULL,
  PRIMARY KEY (`bid`),
  KEY `nid` (`nid`),
  CONSTRAINT `blocks_ibfk_1` FOREIGN KEY (`nid`) REFERENCES `neighbourhood` (`nid`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blocks`
--

LOCK TABLES `blocks` WRITE;
/*!40000 ALTER TABLE `blocks` DISABLE KEYS */;
INSERT INTO `blocks` VALUES (1,'West-Columbus-C',100,40.773392,-73.994465,40.768192,-73.980560,40.763121,-73.985023,40.767932,-73.997040),(2,'East Art-Museum',100,40.764941,-73.973265,40.759090,-73.958244,40.754084,-73.962107,40.760131,-73.976526),(3,'South Central P',100,40.769102,-73.982534,40.764746,-73.971205,40.759286,-73.975239,40.763446,-73.986053),(4,'Hells Kitchen',100,40.768647,-73.996696,40.763641,-73.983736,40.759416,-73.986998,40.765396,-73.999958),(5,'North Times squ',100,40.764031,-73.985453,40.759936,-73.974552,40.755840,-73.977385,40.760716,-73.988800),(6,'Midtown East',100,40.760846,-73.975840,40.754409,-73.960047,40.749793,-73.963308,40.756360,-73.979959),(7,'West Times squa',100,40.765461,-73.999786,40.760716,-73.986225,40.755840,-73.989487,40.761626,-74.003820),(8,'Times square',100,40.760781,-73.988285,40.755905,-73.975496,40.750313,-73.979702,40.755580,-73.993263),(9,'North Tudor Cit',100,40.756815,-73.978758,40.751483,-73.964596,40.747192,-73.967943,40.752069,-73.982964),(10,'West Garmet Dis',100,40.762991,-74.002190,40.757400,-73.988714,40.751353,-73.993435,40.756035,-74.006996),(11,'Bryant Park',100,40.758050,-73.990602,40.753564,-73.979530,40.747582,-73.984337,40.751679,-73.995152),(12,'Tudor City',100,40.754409,-73.981075,40.747712,-73.964939,40.742640,-73.969402,40.747777,-73.986912),(13,'Penn Station',101,40.757920,-74.005022,40.751158,-73.988800,40.746867,-73.991976,40.753304,-74.009571),(14,'High line',101,40.753759,-74.008627,40.748037,-73.991117,40.743225,-73.994894,40.748753,-74.011030),(15,'South 23rd stre',101,40.751028,-74.010172,40.743550,-73.991117,40.739388,-73.994293,40.745176,-74.012489),(16,'14th street',101,40.746542,-74.011030,40.738803,-73.993950,40.735551,-73.996439,40.740429,-74.011545);
/*!40000 ALTER TABLE `blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `f_request`
--

DROP TABLE IF EXISTS `f_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `f_request` (
  `uid_requested_by` int(6) NOT NULL,
  `uid_requested_of` int(6) NOT NULL,
  `status` enum('waiting','accepted') NOT NULL DEFAULT 'waiting',
  PRIMARY KEY (`uid_requested_by`,`uid_requested_of`),
  KEY `uid_requested_of` (`uid_requested_of`),
  CONSTRAINT `f_request_ibfk_1` FOREIGN KEY (`uid_requested_by`) REFERENCES `user` (`uid`) ON DELETE CASCADE,
  CONSTRAINT `f_request_ibfk_2` FOREIGN KEY (`uid_requested_of`) REFERENCES `user` (`uid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `f_request`
--

LOCK TABLES `f_request` WRITE;
/*!40000 ALTER TABLE `f_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `f_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_history`
--

DROP TABLE IF EXISTS `m_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_history` (
  `uid` int(6) NOT NULL,
  `bid` int(6) NOT NULL,
  `since` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `till` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`uid`,`bid`,`till`),
  KEY `m_history_ibfk_2` (`bid`),
  CONSTRAINT `m_history_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE,
  CONSTRAINT `m_history_ibfk_2` FOREIGN KEY (`bid`) REFERENCES `blocks` (`bid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_history`
--

LOCK TABLES `m_history` WRITE;
/*!40000 ALTER TABLE `m_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_request`
--

DROP TABLE IF EXISTS `m_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_request` (
  `uid` int(6) NOT NULL,
  `bid` int(6) NOT NULL,
  `uid1` int(6) DEFAULT NULL,
  `uid2` int(6) DEFAULT NULL,
  `uid3` int(6) DEFAULT NULL,
  `acceptance_cnt` int(1) DEFAULT '3',
  `acceptedat` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`uid`,`bid`,`acceptedat`),
  KEY `uid1` (`uid1`),
  KEY `uid2` (`uid2`),
  KEY `uid3` (`uid3`),
  KEY `bid` (`bid`),
  CONSTRAINT `m_request_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE,
  CONSTRAINT `m_request_ibfk_2` FOREIGN KEY (`uid1`) REFERENCES `user` (`uid`) ON DELETE SET NULL,
  CONSTRAINT `m_request_ibfk_3` FOREIGN KEY (`uid2`) REFERENCES `user` (`uid`) ON DELETE SET NULL,
  CONSTRAINT `m_request_ibfk_4` FOREIGN KEY (`uid3`) REFERENCES `user` (`uid`) ON DELETE SET NULL,
  CONSTRAINT `m_request_ibfk_5` FOREIGN KEY (`bid`) REFERENCES `blocks` (`bid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_request`
--

LOCK TABLES `m_request` WRITE;
/*!40000 ALTER TABLE `m_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membership`
--

DROP TABLE IF EXISTS `membership`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `membership` (
  `uid` int(6) NOT NULL,
  `bid` int(6) NOT NULL,
  `since` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`,`bid`),
  KEY `membership_ibfk_2_idx` (`bid`),
  CONSTRAINT `membership_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `membership_ibfk_2` FOREIGN KEY (`bid`) REFERENCES `blocks` (`bid`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membership`
--

LOCK TABLES `membership` WRITE;
/*!40000 ALTER TABLE `membership` DISABLE KEYS */;
/*!40000 ALTER TABLE `membership` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `mid` bigint(20) NOT NULL,
  `author` int(6) NOT NULL,
  `m_body` text,
  `tid` bigint(20) NOT NULL,
  `postedat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image` blob,
  `latitude` decimal(9,6) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL,
  `ReadFlag` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`mid`),
  KEY `author` (`author`),
  KEY `tid` (`tid`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`author`) REFERENCES `user` (`uid`) ON DELETE NO ACTION,
  CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`tid`) REFERENCES `threads` (`tid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,1,'WElcome to neighbourhood.com',1,'2015-11-23 04:55:56','',0.000000,0.000000,0),(2,1,'This is the second message',1,'2015-11-23 05:09:24','',0.000000,0.000000,0);
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `neighbourhood`
--

DROP TABLE IF EXISTS `neighbourhood`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `neighbourhood` (
  `nid` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `nw_latitude` decimal(9,6) NOT NULL,
  `nw_longitude` decimal(9,6) NOT NULL,
  `ne_latitude` decimal(9,6) NOT NULL,
  `ne_longitude` decimal(9,6) NOT NULL,
  `se_latitude` decimal(9,6) NOT NULL,
  `se_longitude` decimal(9,6) NOT NULL,
  `sw_latitude` decimal(9,6) NOT NULL,
  `sw_longitude` decimal(9,6) NOT NULL,
  PRIMARY KEY (`nid`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `neighbourhood`
--

LOCK TABLES `neighbourhood` WRITE;
/*!40000 ALTER TABLE `neighbourhood` DISABLE KEYS */;
INSERT INTO `neighbourhood` VALUES (100,'Midtown',40.772612,-73.993263,40.759611,-73.957729,40.734641,-73.974037,40.749598,-74.010773),(101,'Chelsea',40.759286,-74.005022,40.751288,-73.985624,40.735616,-73.996868,40.742120,-74.012661),(102,'Flatiron District',40.751028,-73.988714,40.743746,-73.968287,40.725990,-73.969402,40.736462,-73.998671),(103,'Greenwich Village',40.744071,-74.010773,40.735616,-73.988113,40.721372,-73.991203,40.727942,-74.014635),(104,'East Village',40.736137,-73.991461,40.727226,-73.968201,40.717209,-73.972149,40.723584,-73.994980);
/*!40000 ALTER TABLE `neighbourhood` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `relationship`
--

DROP TABLE IF EXISTS `relationship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `relationship` (
  `uid1` int(6) NOT NULL DEFAULT '0',
  `uid2` int(6) NOT NULL DEFAULT '0',
  `type` enum('friend','neighbour') NOT NULL DEFAULT 'friend',
  `since` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid1`,`uid2`,`type`),
  KEY `relationship_ibfk_2` (`uid2`),
  CONSTRAINT `relationship_ibfk_1` FOREIGN KEY (`uid1`) REFERENCES `user` (`uid`) ON DELETE CASCADE,
  CONSTRAINT `relationship_ibfk_2` FOREIGN KEY (`uid2`) REFERENCES `user` (`uid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `relationship`
--

LOCK TABLES `relationship` WRITE;
/*!40000 ALTER TABLE `relationship` DISABLE KEYS */;
/*!40000 ALTER TABLE `relationship` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `threads`
--

DROP TABLE IF EXISTS `threads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `threads` (
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `subject` varchar(40) NOT NULL,
  `scope` enum('personnel','block','neighbourhood','friends','neighbours') NOT NULL DEFAULT 'block',
  `scope_id` int(6) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `threads`
--

LOCK TABLES `threads` WRITE;
/*!40000 ALTER TABLE `threads` DISABLE KEYS */;
INSERT INTO `threads` VALUES (1,'Test','personnel',2,'2015-11-23 04:43:52');
/*!40000 ALTER TABLE `threads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `uid` int(6) NOT NULL AUTO_INCREMENT,
  `email` varchar(80) NOT NULL,
  `fullname` varchar(20) NOT NULL,
  `streetadr1` varchar(40) NOT NULL,
  `streetadr2` varchar(40) DEFAULT NULL,
  `city` varchar(30) NOT NULL,
  `state` char(2) NOT NULL DEFAULT '',
  `zip` int(5) NOT NULL,
  `intro` text,
  `ppic` blob,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'dhishan@nyu.edu','Dhishan Amaranath','7920 3rd ave','Apt 2F','Brooklyn','Ne',0,NULL,NULL),(2,'','','',NULL,'','',0,NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_login`
--

DROP TABLE IF EXISTS `user_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_login` (
  `uid` int(6) NOT NULL,
  `uname` varchar(10) NOT NULL,
  `password` varchar(20) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uname` (`uname`),
  CONSTRAINT `user_login_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_login`
--

LOCK TABLES `user_login` WRITE;
/*!40000 ALTER TABLE `user_login` DISABLE KEYS */;
INSERT INTO `user_login` VALUES (1,'dhishan','123','2015-12-05 23:56:25');
/*!40000 ALTER TABLE `user_login` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-12-14 16:22:51
