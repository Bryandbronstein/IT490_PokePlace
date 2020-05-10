# IT490_PokePlace
Our final project for IT490 - Systems Integration class.  This project utilizes RabbitMQ, PHP, HTML, CSS, Javascript, MySQL and a Rest API for a pokemon database website

## Members
Andrew Amador: Backend/Database

Aadarsh Patel: DMZ

Bryan Bronstein: Frontend

Helder Quental: Backend/RabbitMQ


## Communication/Git Logs

Trello history: https://trello.com/b/w4ziB1tA.json

Discord server chat logs: https://drive.google.com/file/d/1BjX2nSHvnBOEhd6v24f6Exs9F7Y3yKSR/view?usp=sharing

Shared google doc (notes + some code): https://docs.google.com/document/d/1-1URF3sRuQ-7lTGquaQPDR8VAyUryE1X6jq5fa5rtKA/edit?usp=sharing

Github history: 


## Server Documentation
For all servers:

 - Create a folder within your home directory titled “git”
 - Clone the repository into this folder
 - Install php

### RabbitMQ Configuration
- Ensure git branch is changed to “RabbitMQ”
- Install rabbitmq with sudo apt-get install rabbitmq-server 
- Run sudo systemctl enable rabbitmq-server, then sudo systemctl start rabbitmq-server 
- Create admin user using sudo rabbitmqctl add_user admin password 
- and sudo rabbitmqctl set_user_tags admin administrator 
- set up rabbit management console using sudo rabbitmq-plugins enable rabbitmq_management 
- log into rabbitmq management with created user (using your ip and port 15672) 
- set up with proper exchanges and queues 
- DBExchange is central exchange 
- Then create two exchanges one named frontendExchange and one named dmzExchange and bind both to db exchange 
- Then create webtodbQueue and bind to frontendExchange and dmztodbQueue and bind to dmzExchange


### Frontend configuration
#### Configure custom domain
 - Ensure git branch is changed to “Frontend”
 - Install apache
 - Run sudo vim /etc/hosts and add “pokeplace.com” as an entry for 127.0.0.1
 - Run sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/pokeplace.conf
 - Run sudo vim /etc/apache2/sites-available/pokeplace.conf and edit the entry “DocumentRoot” from the path “/var/www/html” to the path “/home/ubuntu/git/IT490_PokePlace/Frontend”
 - Run the following: 
          sudo a2dissite 000-default.conf
          sudo a2ensite pokeplace.conf
          sudo systemctl reload apache2
 - Run sudo vim /etc/apache2/apache2.conf and add the following entry:
<Directory /home/ubuntu/git/IT490_PokePlace/Frontend>
        Options Indexes FollowSymLinks
        AllowOverride None
        Require all granted
</Directory>
    Then run sudo systemctl reload apache2

#### Configure site to run using HTTPS using self-signed cert
 - Run mkdir certificates, cd certificates
 - Run openssl req -x509 -newkey rsa:4096 -keyout apache.key -out apache.crt -days 365 -nodes
 - You will then be prompted for some info for the certificate request.  The most important of these is “Common name”, which will be the server’s IP address
 - Run mkdir /etc/apache2/ssl, mv ~/certificates/* /etc/apache2/ssl/
 - Run sudo ufw enable
 - Run sudo ufw allow 'Apache Full'
 - Run sudo ufw allow 'OpenSSH'
 - Run sudo vim /etc/apache2/sites-available/default-ssl.conf and add the following configurations:
 - add this right under ServerAdmin:
ServerName YOUR_SERVER’S_IP_ADDRESS (add this right under ServerAdmin)
Add these entries under SSLEngine on:
SSLCertificateFile /etc/apache2/ssl/apache.crt
SSLCertificateKeyFile /etc/apache2/ssl/apache.key
 - Run sudo a2enmod ssl
 - Run sudo a2ensite default-ssl.conf
 - Run sudo service apache2 restart


### Backend/database configuration
Ensure git branch is changed to “Database”
Install Mysql 
Here is a dump of the database schema:

-- MySQL dump 10.13  Distrib 5.7.29, for Linux (x86_64)
--
-- Host: localhost    Database: registration
-- ------------------------------------------------------
-- Server version               5.7.29-0ubuntu0.18.04.1
 
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
-- Table structure for table `categories`
--
 
DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `cat_id` int(8) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  `cat_description` varchar(255) NOT NULL,
  PRIMARY KEY (`cat_id`),
  UNIQUE KEY `cat_name_unique` (`cat_name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
 
--
-- Dumping data for table `categories`
--
 
LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'andrew','This is a test'),(2,'bob','test'),(5,'asdasd','qweqwe'),(6,'Test','New Category'),(7,'aldskmcsld','laksmdfsuhfuwehfiwuejfwe'),(8,'test name','test description'),(9,'slknmflkwajenflkwje','wekjnoiewufoiew');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;
 
--
-- Table structure for table `leaderboard`
--
 
DROP TABLE IF EXISTS `leaderboard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leaderboard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `wins` int(11) NOT NULL,
  `losses` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
 
--
-- Dumping data for table `leaderboard`
--
 
LOCK TABLES `leaderboard` WRITE;
/*!40000 ALTER TABLE `leaderboard` DISABLE KEYS */;
INSERT INTO `leaderboard` VALUES (1,'bob',39,12),(2,'jdoe95',0,15),(3,'hquental',0,1),(4,'kjnkjnkjnk',0,0),(5,'newtestusername',0,0),(6,'jnjnjn',0,0),(7,'qwqwqw',11,23);
/*!40000 ALTER TABLE `leaderboard` ENABLE KEYS */;
UNLOCK TABLES;
 
--
-- Table structure for table `posts`
--
 
DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `post_id` int(8) NOT NULL AUTO_INCREMENT,
  `post_content` text NOT NULL,
  `post_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `post_topic` int(8) NOT NULL,
  `post_by` int(8) NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `post_topic` (`post_topic`),
  KEY `post_by` (`post_by`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`post_topic`) REFERENCES `topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`post_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `posts_ibfk_3` FOREIGN KEY (`post_topic`) REFERENCES `topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `posts_ibfk_4` FOREIGN KEY (`post_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
 
--
-- Dumping data for table `posts`
--
 
LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'this is a test',NULL,1,1),(2,'lkedlwekjfwe',NULL,1,1),(3,'newtestewfjnwoef',NULL,1,1),(4,'Hey this is carzy huh???',NULL,1,1),(5,'Its a meeeee',NULL,1,22);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;
 
--
-- Table structure for table `topics`
--
 
DROP TABLE IF EXISTS `topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topics` (
  `topic_id` int(8) NOT NULL AUTO_INCREMENT,
  `topic_subject` varchar(255) NOT NULL,
  `topic_cat` int(8) NOT NULL,
  `topic_by` int(8) NOT NULL,
  `topic_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`topic_id`),
  KEY `topic_cat` (`topic_cat`),
  KEY `topic_by` (`topic_by`),
  CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`topic_cat`) REFERENCES `categories` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `topics_ibfk_2` FOREIGN KEY (`topic_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `topics_ibfk_3` FOREIGN KEY (`topic_cat`) REFERENCES `categories` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `topics_ibfk_4` FOREIGN KEY (`topic_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
 
--
-- Dumping data for table `topics`
--
 
LOCK TABLES `topics` WRITE;
/*!40000 ALTER TABLE `topics` DISABLE KEYS */;
INSERT INTO `topics` VALUES (1,'New test',1,1,'2020-03-05 10:03:07'),(2,'andrew',1,1,'2020-03-10 10:58:01'),(3,'zasdas',1,1,'2020-03-10 11:27:14');
/*!40000 ALTER TABLE `topics` ENABLE KEYS */;
UNLOCK TABLES;
 
--
-- Table structure for table `users`
--
 
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `firstname` varchar(15) DEFAULT NULL,
  `lastname` varchar(15) DEFAULT NULL,
  `pokemon_1` varchar(100) NOT NULL DEFAULT '',
  `pokemon_2` varchar(100) NOT NULL DEFAULT '',
  `pokemon_3` varchar(100) NOT NULL DEFAULT '',
  `pokemon_4` varchar(100) NOT NULL DEFAULT '',
  `pokemon_5` varchar(100) NOT NULL DEFAULT '',
  `pokemon_6` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


