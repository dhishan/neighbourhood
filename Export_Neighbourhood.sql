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
  `bid` int(6) NOT NULL,
  `name` varchar(15) NOT NULL,
  `nid` int(6) NOT NULL,
  `ne_latitude` decimal(9,6) NOT NULL,
  `ne_longitude` decimal(9,6) NOT NULL,
  `sw_longitude` decimal(9,6) NOT NULL,
  `sw_latitude` decimal(9,6) NOT NULL,
  PRIMARY KEY (`bid`),
  KEY `nid` (`nid`),
  CONSTRAINT `blocks_ibfk_1` FOREIGN KEY (`nid`) REFERENCES `neighbourhood` (`nid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blocks`
--

LOCK TABLES `blocks` WRITE;
/*!40000 ALTER TABLE `blocks` DISABLE KEYS */;
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
  PRIMARY KEY (`uid`,`bid`)
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
  `mid` bigint(20) NOT NULL AUTO_INCREMENT,
  `author` int(6) NOT NULL,
  `m_body` text,
  `tid` bigint(20) NOT NULL,
  `postedat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image` blob,
  `latitude` decimal(9,6) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL,
  PRIMARY KEY (`mid`),
  KEY `author` (`author`),
  KEY `tid` (`tid`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`author`) REFERENCES `user` (`uid`) ON DELETE NO ACTION,
  CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`tid`) REFERENCES `threads` (`tid`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,1,'WElcome to neighbourhood.com',1,'2015-11-23 04:55:56','',0.000000,0.000000),(2,1,'This is the second message',1,'2015-11-23 05:09:24','',0.000000,0.000000);
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `neighbourhood`
--

DROP TABLE IF EXISTS `neighbourhood`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `neighbourhood` (
  `nid` int(6) NOT NULL,
  `name` varchar(15) NOT NULL,
  `ne_latitude` decimal(9,6) NOT NULL,
  `ne_longitude` decimal(9,6) NOT NULL,
  `sw_longitude` decimal(9,6) NOT NULL,
  `sw_latitude` decimal(9,6) NOT NULL,
  PRIMARY KEY (`nid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `neighbourhood`
--

LOCK TABLES `neighbourhood` WRITE;
/*!40000 ALTER TABLE `neighbourhood` DISABLE KEYS */;
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
  `scope_id` int(6) NOT NULL,
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
  `email` varchar(40) NOT NULL,
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
INSERT INTO `user` VALUES (1,'','','',NULL,'','',0,NULL,NULL),(2,'','','',NULL,'','',0,NULL,NULL);
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

-- Dump completed on 2015-11-23 14:19:53
