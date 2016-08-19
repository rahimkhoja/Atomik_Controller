-- MySQL dump 10.15  Distrib 10.0.25-MariaDB, for debian-linux-gnueabihf (armv7l)
--
-- Host: localhost    Database: atomik_controller
-- ------------------------------------------------------
-- Server version	10.0.25-MariaDB-0+deb8u1

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
-- Table structure for table `atomik_commands_received`
--

DROP TABLE IF EXISTS `atomik_commands_received`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atomik_commands_received` (
  `command_received_id` int(6) NOT NULL AUTO_INCREMENT,
  `command_received_source_type` varchar(16) NOT NULL COMMENT 'cron, emulator, transciever, atomik api',
  `command_received_zone_id` int(6) DEFAULT NULL,
  `command_received_remote_id` int(6) DEFAULT NULL,
  `command_received_channel_id` int(6) DEFAULT NULL,
  `command_received_date` datetime(6) DEFAULT NULL,
  `command_received_data` varchar(32) NOT NULL,
  `command_received_status` varchar(16) DEFAULT NULL,
  `command_received_color_mode` int(1) DEFAULT NULL,
  `command_received_rgb256` int(3) DEFAULT NULL,
  `command_received_white_temprature` int(4) DEFAULT NULL,
  `command_received_brightness` int(3) DEFAULT NULL,
  `command_received_processed` int(1) NOT NULL,
  `command_received_MAC` varchar(32) DEFAULT NULL,
  `command_received_IP` varchar(32) DEFAULT NULL,
  `command_received_ADD1` varchar(2) DEFAULT NULL,
  `command_received_ADD2` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`command_received_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6650 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atomik_commands_received`
--

LOCK TABLES `atomik_commands_received` WRITE;
/*!40000 ALTER TABLE `atomik_commands_received` DISABLE KEYS */;
/*!40000 ALTER TABLE `atomik_commands_received` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atomik_device_types`
--

DROP TABLE IF EXISTS `atomik_device_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atomik_device_types` (
  `device_type_id` int(3) NOT NULL AUTO_INCREMENT,
  `device_type_name` varchar(32) NOT NULL,
  `device_type_rgb256` int(1) NOT NULL,
  `device_type_warm_white` int(1) NOT NULL,
  `device_type_cold_white` int(1) NOT NULL,
  `device_type_brightness` int(1) NOT NULL,
  PRIMARY KEY (`device_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atomik_device_types`
--

LOCK TABLES `atomik_device_types` WRITE;
/*!40000 ALTER TABLE `atomik_device_types` DISABLE KEYS */;
INSERT INTO `atomik_device_types` VALUES (1,'MiLight RGB Warm White',1,1,0,1),(2,'MiLight RGB Cold White',1,0,1,1),(5,'MiLight Dual White',0,1,1,1);
/*!40000 ALTER TABLE `atomik_device_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atomik_devices`
--

DROP TABLE IF EXISTS `atomik_devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atomik_devices` (
  `device_id` int(6) NOT NULL AUTO_INCREMENT,
  `device_name` varchar(32) NOT NULL,
  `device_description` text NOT NULL,
  `device_type` int(2) NOT NULL,
  `device_status` int(2) NOT NULL,
  `device_colormode` int(1) NOT NULL,
  `device_brightness` int(3) NOT NULL,
  `device_rgb256` int(3) NOT NULL,
  `device_white_temprature` int(4) NOT NULL,
  `device_address1` int(3) DEFAULT NULL,
  `device_address2` int(3) DEFAULT NULL,
  `device_transmission` int(3) DEFAULT NULL,
  PRIMARY KEY (`device_id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atomik_devices`
--

LOCK TABLES `atomik_devices` WRITE;
/*!40000 ALTER TABLE `atomik_devices` DISABLE KEYS */;
INSERT INTO `atomik_devices` VALUES (34,'Test Bulb 1','',1,1,1,100,109,2700,171,122,187),(37,'Test Bulb 2','',1,1,1,100,109,2700,21,40,125),(38,'Test Bulb 1 White','',5,1,1,100,0,2700,16,148,175),(39,'Kids Room Bulbs','2 9w Mi-Light RGBWW',1,1,1,100,0,2700,149,96,0),(40,'Hallway Lights','2 - Dual White Bulbs',5,0,1,9,0,2700,225,14,203),(42,'Kids Bedroom - Nightlight','',2,0,0,73,223,2700,206,151,158);
/*!40000 ALTER TABLE `atomik_devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atomik_remote_channels`
--

DROP TABLE IF EXISTS `atomik_remote_channels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atomik_remote_channels` (
  `remote_channel_id` int(6) NOT NULL AUTO_INCREMENT,
  `remote_channel_remote_id` int(6) NOT NULL,
  `remote_channel_number` int(3) NOT NULL,
  `remote_channel_zone_id` int(6) NOT NULL,
  `remote_channel_name` varchar(64) NOT NULL,
  PRIMARY KEY (`remote_channel_id`)
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atomik_remote_channels`
--

LOCK TABLES `atomik_remote_channels` WRITE;
/*!40000 ALTER TABLE `atomik_remote_channels` DISABLE KEYS */;
INSERT INTO `atomik_remote_channels` VALUES (91,20,0,22,'Master Channel'),(92,20,1,23,'Channel 1'),(93,20,2,24,'Channel 2'),(94,20,3,25,'Channel 3'),(95,20,4,0,'Channel 4'),(101,22,0,22,'Master Channel'),(102,22,1,23,'Channel 1'),(103,22,2,24,'Channel 2'),(104,22,3,0,'Channel 3'),(105,22,4,0,'Channel 4'),(106,19,0,23,'Atomik Remote Channel 1'),(107,19,1,22,'Atomik Remote Channel 2'),(108,19,2,25,'Atomik Remote Channel 3'),(109,23,0,22,'Master Channel'),(110,23,1,26,'Channel 1'),(111,23,2,0,'Channel 2'),(112,23,3,0,'Channel 3'),(113,23,4,0,'Channel 4'),(114,19,3,26,'Atomik Remote Channel 4'),(115,24,0,22,'Master Channel'),(116,24,1,0,'Channel 1'),(117,24,2,0,'Channel 2'),(118,24,3,0,'Channel 3'),(119,24,4,0,'Channel 4');
/*!40000 ALTER TABLE `atomik_remote_channels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atomik_remote_types`
--

DROP TABLE IF EXISTS `atomik_remote_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atomik_remote_types` (
  `remote_type_id` int(6) NOT NULL AUTO_INCREMENT,
  `remote_type_name` varchar(32) NOT NULL,
  `remote_type_atomik` int(1) NOT NULL,
  `remote_type_milight_smartphone` int(1) NOT NULL,
  `remote_type_milight_radio` int(1) NOT NULL,
  `remote_type_channels` int(3) NOT NULL,
  PRIMARY KEY (`remote_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atomik_remote_types`
--

LOCK TABLES `atomik_remote_types` WRITE;
/*!40000 ALTER TABLE `atomik_remote_types` DISABLE KEYS */;
INSERT INTO `atomik_remote_types` VALUES (1,'Mi-Light Smartphone Remote',0,1,0,5),(2,'Mi-Light Color RF Remote',0,0,1,5),(3,'Atomik API Remote',1,0,0,0);
/*!40000 ALTER TABLE `atomik_remote_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atomik_remotes`
--

DROP TABLE IF EXISTS `atomik_remotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atomik_remotes` (
  `remote_id` int(6) NOT NULL AUTO_INCREMENT,
  `remote_name` varchar(32) NOT NULL,
  `remote_description` text NOT NULL,
  `remote_type` int(11) NOT NULL,
  `remote_user` varchar(32) NOT NULL,
  `remote_password` varchar(16) NOT NULL,
  `remote_address1` int(3) NOT NULL,
  `remote_address2` int(3) NOT NULL,
  `remote_mac` varchar(20) NOT NULL,
  `remote_current_channel` int(11) DEFAULT NULL,
  PRIMARY KEY (`remote_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atomik_remotes`
--

LOCK TABLES `atomik_remotes` WRITE;
/*!40000 ALTER TABLE `atomik_remotes` DISABLE KEYS */;
INSERT INTO `atomik_remotes` VALUES (19,'Atomik Remote 1','',3,'rahimk','password',0,0,'',NULL),(20,'Mi-Light RF Remote 1','',2,'','',129,29,'',3),(22,'Mi-Light Smartphone Remote','',1,'','',0,0,'90:FD:61:BE:A3:E9',4),(23,'Second Remote','',2,'','',165,175,'',1),(24,'Android','',1,'','',0,0,'40:0E:85:2C:7C:42',NULL);
/*!40000 ALTER TABLE `atomik_remotes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atomik_settings`
--

DROP TABLE IF EXISTS `atomik_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atomik_settings` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `hostname` varchar(32) NOT NULL,
  `atomik_api` int(1) NOT NULL,
  `atomik_transceiver` int(1) NOT NULL,
  `atomik_emulator` int(1) NOT NULL,
  `password` varchar(40) NOT NULL,
  `timezone` varchar(64) NOT NULL,
  `daylight_savings` int(1) NOT NULL,
  `ntp_server_1` varchar(16) NOT NULL,
  `ntp_server_2` varchar(16) NOT NULL,
  `ntp_server_3` varchar(16) NOT NULL,
  `eth0_status` int(1) NOT NULL,
  `eth0_type` int(1) NOT NULL,
  `eth0_ip` varchar(16) NOT NULL,
  `eth0_mask` varchar(16) NOT NULL,
  `eth0_gateway` varchar(16) NOT NULL,
  `eth0_dns` varchar(32) NOT NULL,
  `wlan0_status` int(1) NOT NULL,
  `wlan0_ssid` varchar(32) NOT NULL,
  `wlan0_method` int(1) NOT NULL,
  `wlan0_algorithm` int(1) NOT NULL,
  `wlan0_password` varchar(32) NOT NULL,
  `wlan0_type` int(1) NOT NULL,
  `wlan0_ip` varchar(16) NOT NULL,
  `wlan0_mask` varchar(16) NOT NULL,
  `wlan0_gateway` varchar(16) NOT NULL,
  `wlan0_dns` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atomik_settings`
--

LOCK TABLES `atomik_settings` WRITE;
/*!40000 ALTER TABLE `atomik_settings` DISABLE KEYS */;
INSERT INTO `atomik_settings` VALUES (1,'atomik-control',1,1,1,'d033e22ae348aeb5660fc2140aec35850c4da997','America/Vancouver',0,'129.6.15.28','129.6.15.29','129.6.15.30',1,1,'172.16.254.99','255.255.0.0','172.16.254.1','8.8.8.8',1,'KhojaCorp',4,3,'St@rt3ck',0,'172.16.254.123','255.255.0.0','172.16.254.1','8.8.8.8');
/*!40000 ALTER TABLE `atomik_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atomik_tasks`
--

DROP TABLE IF EXISTS `atomik_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atomik_tasks` (
  `task_id` int(6) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(32) NOT NULL,
  `task_description` text NOT NULL,
  `task_zone_id` int(6) NOT NULL,
  `task_status` int(3) NOT NULL,
  `task_color_mode` int(3) NOT NULL,
  `task_brightness` int(3) NOT NULL,
  `task_rgb256` int(3) NOT NULL,
  `task_white_temprature` int(4) NOT NULL,
  `task_cron_minute` varchar(256) NOT NULL,
  `task_cron_hour` varchar(256) NOT NULL,
  `task_cron_day` varchar(256) NOT NULL,
  `task_cron_month` varchar(256) NOT NULL,
  `task_cron_weekday` varchar(256) NOT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atomik_tasks`
--

LOCK TABLES `atomik_tasks` WRITE;
/*!40000 ALTER TABLE `atomik_tasks` DISABLE KEYS */;
INSERT INTO `atomik_tasks` VALUES (15,'Hallway Lights Off','Turn Hallways Lights Off at Night',25,0,1,0,0,2700,'a:1:{i:0;s:2:\"30\";}','a:1:{i:0;s:2:\"23\";}','a:1:{i:0;s:1:\"*\";}','a:1:{i:0;s:1:\"*\";}','a:0:{}'),(14,'Childrens Bedtime Lights','',24,0,1,100,0,2700,'a:1:{i:0;s:1:\"0\";}','a:1:{i:0;s:2:\"22\";}','a:0:{}','a:1:{i:0;s:1:\"*\";}','a:5:{i:0;s:1:\"0\";i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:4;s:1:\"4\";}'),(16,'Childrens Morning Lights','Turn kids Lights on at 8 in the morning',24,1,1,100,0,2700,'a:1:{i:0;s:1:\"0\";}','a:1:{i:0;s:2:\"10\";}','a:1:{i:0;s:1:\"*\";}','a:1:{i:0;s:1:\"*\";}','a:0:{}'),(18,'Turn On Living Room Lights','',22,1,1,100,0,2700,'a:1:{i:0;s:2:\"30\";}','a:1:{i:0;s:2:\"21\";}','a:1:{i:0;s:1:\"*\";}','a:1:{i:0;s:1:\"*\";}','a:0:{}');
/*!40000 ALTER TABLE `atomik_tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atomik_zone_devices`
--

DROP TABLE IF EXISTS `atomik_zone_devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atomik_zone_devices` (
  `zone_device_id` int(6) NOT NULL AUTO_INCREMENT,
  `zone_device_zone_id` int(6) NOT NULL,
  `zone_device_device_id` int(6) NOT NULL,
  `zone_device_last_update` datetime(6) NOT NULL,
  PRIMARY KEY (`zone_device_id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atomik_zone_devices`
--

LOCK TABLES `atomik_zone_devices` WRITE;
/*!40000 ALTER TABLE `atomik_zone_devices` DISABLE KEYS */;
INSERT INTO `atomik_zone_devices` VALUES (62,22,38,'2016-08-19 04:30:02.292945'),(67,23,34,'2016-08-19 05:03:37.805344'),(70,23,37,'2016-08-19 05:03:37.805344'),(71,24,39,'2016-08-19 17:00:04.245251'),(72,25,40,'2016-08-19 06:30:02.695535'),(73,26,42,'2016-08-16 21:45:39.164094');
/*!40000 ALTER TABLE `atomik_zone_devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atomik_zone_remotes`
--

DROP TABLE IF EXISTS `atomik_zone_remotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atomik_zone_remotes` (
  `zone_remote_id` int(6) NOT NULL AUTO_INCREMENT,
  `zone_remote_zone_id` int(6) NOT NULL,
  `zone_remote_remote_id` int(6) NOT NULL,
  `zone_remote_channel_number` int(3) NOT NULL,
  `zone_remote_last_update` varchar(64) NOT NULL,
  PRIMARY KEY (`zone_remote_id`)
) ENGINE=MyISAM AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atomik_zone_remotes`
--

LOCK TABLES `atomik_zone_remotes` WRITE;
/*!40000 ALTER TABLE `atomik_zone_remotes` DISABLE KEYS */;
INSERT INTO `atomik_zone_remotes` VALUES (82,22,20,0,'2016-06-27 17:45:58'),(83,22,22,0,'2016-07-01 18:04:11'),(84,23,20,1,'2016-07-04 05:43:47'),(85,23,22,1,'2016-07-05 00:01:07'),(86,24,20,2,'2016-07-06 03:20:09'),(87,24,22,2,'2016-07-06 03:20:21'),(88,23,19,0,'2016-07-08 22:23:12'),(89,22,19,1,'2016-07-10 16:24:05'),(90,25,19,2,'2016-07-10 18:20:54'),(91,25,20,3,'2016-07-11 23:46:09'),(92,22,23,0,'2016-08-02 20:01:58'),(93,26,19,3,'2016-08-06 03:47:52'),(94,26,23,1,'2016-08-06 03:47:59'),(95,22,24,0,'2016-08-10 22:35:16');
/*!40000 ALTER TABLE `atomik_zone_remotes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atomik_zones`
--

DROP TABLE IF EXISTS `atomik_zones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atomik_zones` (
  `zone_id` int(6) NOT NULL AUTO_INCREMENT,
  `zone_name` varchar(32) NOT NULL,
  `zone_description` text NOT NULL,
  `zone_status` int(3) NOT NULL,
  `zone_colormode` int(3) NOT NULL,
  `zone_brightness` int(3) NOT NULL,
  `zone_rgb256` int(3) NOT NULL,
  `zone_white_temprature` int(4) NOT NULL,
  `zone_last_update` varchar(64) NOT NULL,
  PRIMARY KEY (`zone_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atomik_zones`
--

LOCK TABLES `atomik_zones` WRITE;
/*!40000 ALTER TABLE `atomik_zones` DISABLE KEYS */;
INSERT INTO `atomik_zones` VALUES (22,'Living Room','Single White Bulb',1,1,100,0,2700,'2016-08-19 04:30:02.289418'),(23,'Color Bulbs Different Addresses','',1,1,100,109,2700,'2016-08-19 05:03:37.796765'),(24,'Kids Room','2 - Bulbs',1,1,100,0,2700,'2016-08-19 17:00:04.234095'),(25,'Hallway','',0,1,9,0,2700,'2016-08-19 06:30:02.681637'),(26,'Kids NightLight','',0,0,73,223,2700,'2016-08-16 21:45:39.152223');
/*!40000 ALTER TABLE `atomik_zones` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-08-19 14:18:54
