-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: wordpress
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.17.04.1

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
-- Table structure for table `wp_cb_newsreader`
--

DROP TABLE IF EXISTS `wp_cb_newsreader`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wp_cb_newsreader` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `feed_name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `feed_url` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `feed_qty` int(11) NOT NULL,
  `feed_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wp_cb_newsreader`
--

LOCK TABLES `wp_cb_newsreader` WRITE;
/*!40000 ALTER TABLE `wp_cb_newsreader` DISABLE KEYS */;
INSERT INTO `wp_cb_newsreader` VALUES (1,'France 24','http://www.france24.com/en/france/rss',12,1),(2,'Breitbart','http://feeds.feedburner.com/breitbart',12,7),(4,'The Spectator','https://www.spectator.co.uk/',12,9),(6,'Oxford Mail','http://www.oxfordmail.co.uk/news/',12,6),(8,'Google UK','https://news.google.com/news/rss/headlines/section/q/UK/UK?ned=us&hl=en',12,5),(9,'Google USA','https://news.google.com/news/rss/headlines/section/topic/NATION?ned=us&hl=en',12,12),(10,'Google World','https://news.google.com/news/rss/headlines/section/topic/WORLD?ned=us&hl=en',12,13),(11,'Google Business','https://news.google.com/news/rss/headlines/section/topic/BUSINESS?ned=us&hl=en',12,14),(12,'Google Technology','https://news.google.com/news/rss/headlines/section/topic/TECHNOLOGY?ned=us&hl=en',12,15),(13,'CNET','https://www.cnet.com/topics/tech-industry/',12,11),(15,'Google Science','https://news.google.com/news/rss/headlines/section/q/science/science?ned=us&hl=en',12,16),(16,'Google Health','https://news.google.com/news/rss/headlines/section/topic/HEALTH?ned=us&hl=en',12,17),(21,'SCMP - HK','http://www.scmp.com/rss/2/feed',12,3),(22,'SCMP - China','http://www.scmp.com/rss/4/feed',12,4),(29,'France - the Local','https://www.thelocal.fr/feeds/rss.php',12,2),(30,'Spiked online','http://www.spiked-online.com/newsite/rss/',12,8),(31,'Standpoint','http://feeds.feedburner.com/WelcomeToStandpoint',12,10);
/*!40000 ALTER TABLE `wp_cb_newsreader` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-24 18:13:13
