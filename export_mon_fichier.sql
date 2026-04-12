-- MariaDB dump 10.19-11.8.3-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: kapitalstark
-- ------------------------------------------------------
-- Server version	11.8.3-MariaDB-1+b1 from Debian

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `admin_template_documents`
--

DROP TABLE IF EXISTS `admin_template_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_template_documents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'Général',
  `description` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `mime` varchar(100) NOT NULL,
  `size_bytes` bigint(20) unsigned NOT NULL DEFAULT 0,
  `uploaded_by` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_template_documents_uploaded_by_foreign` (`uploaded_by`),
  CONSTRAINT `admin_template_documents_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_template_documents`
--

LOCK TABLES `admin_template_documents` WRITE;
/*!40000 ALTER TABLE `admin_template_documents` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `admin_template_documents` VALUES
(1,'bb','Général','fghjnfjh','admin-templates/rAKjouAioTr0NgT9xMsYyb4si8Nchv4n16DZX6wJ.pdf','recu-20260404-5 (1).pdf','application/pdf',34016,2,'2026-04-07 17:51:11','2026-04-07 17:51:11');
/*!40000 ALTER TABLE `admin_template_documents` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `appointment_requests`
--

DROP TABLE IF EXISTS `appointment_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `appointment_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `email` varchar(150) NOT NULL,
  `project_type` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(10) NOT NULL,
  `notes` text DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `handled` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointment_requests`
--

LOCK TABLES `appointment_requests` WRITE;
/*!40000 ALTER TABLE `appointment_requests` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `appointment_requests` VALUES
(1,'zert','jhon','+20909090909090','az@gmail.com','automobile','2026-04-16','16:00','cdsjncds jdscdsndsn sjdncdsnjd','127.0.0.1',1,'2026-04-07 12:09:45','2026-04-07 12:12:24'),
(2,'zert','jhon','1111111111111','az@gmail.com','rachat','2026-04-23','16:30','Déposer un dossier\ncc\n\n15:27\nVotre message a bien été reçu. Un conseiller KapitalStark va vous répondre dans les plus brefs délais.\n\n15:27\ncc\n\n15:27\nbonjour\n\n15:27\nBonjour ! Je suis le conseiller virtuel KapitalStark. Comment puis-je vous aider aujourd\'hui ? (prêt, simulation, rendez-vous…)\n\n15:27\nBonjour ! Je suis le conseiller virtuel KapitalStark. Comment puis-je vous aider aujourd\'hui ? (prêt, simulation, rendez-vous…)\n\n15:27\nc\'est comment\n\n15:27\nBonne question ! Consultez notre FAQ pour trouver des réponses aux questions fréquentes, ou posez-moi votre question directement. Voir la FAQ →\n\n15:27\nBonne question ! Consultez notre FAQ pour trouver des réponses aux questions fréquentes, ou posez-moi votre question directement.\n\n15:27','127.0.0.1',1,'2026-04-07 13:31:30','2026-04-07 13:31:47');
/*!40000 ALTER TABLE `appointment_requests` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `appointments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  `time` varchar(10) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `channel` varchar(30) NOT NULL DEFAULT 'phone',
  `advisor` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('upcoming','past','cancelled') NOT NULL DEFAULT 'upcoming',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `appointments_user_id_foreign` (`user_id`),
  CONSTRAINT `appointments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointments`
--

LOCK TABLES `appointments` WRITE;
/*!40000 ALTER TABLE `appointments` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `appointments` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `cache` VALUES
('kapitalstark-cache-08b4a7edd596cc821c68656e03d716fa','i:1;',1775572573),
('kapitalstark-cache-08b4a7edd596cc821c68656e03d716fa:timer','i:1775572573;',1775572573),
('kapitalstark-cache-5c785c036466adea360111aa28563bfd556b5fba','i:1;',1775569175),
('kapitalstark-cache-5c785c036466adea360111aa28563bfd556b5fba:timer','i:1775569175;',1775569175),
('kapitalstark-cache-e45444ecc678a271a6330f468a373360','i:1;',1775578586),
('kapitalstark-cache-e45444ecc678a271a6330f468a373360:timer','i:1775578586;',1775578586),
('kapitalstark-cache-f844378168053ff820b2e7bdba0583e0','i:1;',1775655090),
('kapitalstark-cache-f844378168053ff820b2e7bdba0583e0:timer','i:1775655090;',1775655090);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `chat_messages`
--

DROP TABLE IF EXISTS `chat_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` bigint(20) unsigned NOT NULL,
  `direction` enum('visitor','admin') NOT NULL,
  `body` text NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_messages_session_id_foreign` (`session_id`),
  CONSTRAINT `chat_messages_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `chat_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_messages`
--

LOCK TABLES `chat_messages` WRITE;
/*!40000 ALTER TABLE `chat_messages` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `chat_messages` VALUES
(1,1,'visitor','cc',1,'2026-04-07 13:19:53','2026-04-07 13:20:06'),
(2,1,'admin','cc',1,'2026-04-07 13:20:10','2026-04-07 13:20:14'),
(3,1,'visitor','c\'est bien ce produits ??',1,'2026-04-07 13:20:22','2026-04-07 13:20:27'),
(4,1,'visitor','vc',1,'2026-04-07 13:20:41','2026-04-07 13:23:52'),
(5,1,'visitor','cc',1,'2026-04-07 13:27:29','2026-04-07 13:31:56'),
(6,1,'visitor','bonjour',1,'2026-04-07 13:27:46','2026-04-07 13:31:56'),
(7,1,'admin','Bonjour ! Je suis le conseiller virtuel KapitalStark. Comment puis-je vous aider aujourd\'hui ? (prêt, simulation, rendez-vous…)',1,'2026-04-07 13:27:46','2026-04-07 13:27:49'),
(8,1,'visitor','c\'est comment',1,'2026-04-07 13:27:59','2026-04-07 13:31:56'),
(9,1,'admin','Bonne question ! Consultez notre FAQ pour trouver des réponses aux questions fréquentes, ou posez-moi votre question directement.',1,'2026-04-07 13:27:59','2026-04-07 13:27:59'),
(10,1,'admin','cc',1,'2026-04-07 13:32:08','2026-04-07 13:32:14'),
(11,1,'visitor','cc',1,'2026-04-07 13:32:33','2026-04-07 13:37:08'),
(12,1,'visitor','quand l\'admin reponds il faut le badg pour que l\'utilisateur sache',1,'2026-04-07 13:33:08','2026-04-07 13:37:08'),
(13,1,'admin','cc',1,'2026-04-07 13:37:08','2026-04-07 13:37:12'),
(14,1,'visitor','cc',1,'2026-04-07 13:37:27','2026-04-07 13:37:46'),
(15,1,'admin','ccvcv',1,'2026-04-07 13:38:17','2026-04-07 13:38:19'),
(16,1,'visitor','cccvbn',1,'2026-04-07 13:38:35','2026-04-07 14:00:53');
/*!40000 ALTER TABLE `chat_messages` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `chat_sessions`
--

DROP TABLE IF EXISTS `chat_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_sessions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(64) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `last_seen_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_sessions_token_unique` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_sessions`
--

LOCK TABLES `chat_sessions` WRITE;
/*!40000 ALTER TABLE `chat_sessions` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `chat_sessions` VALUES
(1,'045da94b76638c2c9032093522db80150f50bd4094f87d0afd358918ce0789c6','127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36','2026-04-07 13:38:35','2026-04-07 13:19:53','2026-04-07 13:38:35');
/*!40000 ALTER TABLE `chat_sessions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `contact_requests`
--

DROP TABLE IF EXISTS `contact_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `handled` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_requests`
--

LOCK TABLES `contact_requests` WRITE;
/*!40000 ALTER TABLE `contact_requests` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `contact_requests` VALUES
(1,'sasa toto','toto@gmail.com','simulation','cvv','127.0.0.1',1,'2026-04-07 12:06:16','2026-04-07 12:06:37'),
(2,'sasa toto','toto@gmail.com','dossier','capres l\'evois du premier message lapres l\'evois du premier message lapres l\'evois du premier message lapres l\'evois du premier message lapres l\'evois du premier message lapres l\'evois du premier message lapres l\'evois du premier message lapres l\'evois du premier message lapres l\'evois du premier message lapres l\'evois du premier message lapres l\'evois du premier message lapres l\'evois du premier message l','127.0.0.1',1,'2026-04-07 13:23:48','2026-04-07 13:24:00');
/*!40000 ALTER TABLE `contact_requests` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `documents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `loan_request_id` bigint(20) unsigned DEFAULT NULL,
  `original_name` varchar(255) NOT NULL,
  `stored_name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL DEFAULT 'Autre',
  `mime` varchar(100) NOT NULL,
  `size_bytes` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_user_id_foreign` (`user_id`),
  KEY `documents_loan_request_id_foreign` (`loan_request_id`),
  CONSTRAINT `documents_loan_request_id_foreign` FOREIGN KEY (`loan_request_id`) REFERENCES `loan_requests` (`id`) ON DELETE SET NULL,
  CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `documents` VALUES
(1,4,1,'recu-20260404-5 (1).pdf','documents/4/i5a2Qx0hS4ETyvGrtCWY3nRnMpXsVwTRQbakRECs.pdf','Pièce justificative','application/pdf',34016,'2026-04-07 14:01:58','2026-04-07 14:01:58'),
(2,4,NULL,'Accord de prêt — Automobile.pdf','documents/4/accord-pret-1-20260407.pdf','Approbation','application/pdf',80550,'2026-04-07 14:02:31','2026-04-07 14:02:31');
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `failed_jobs` VALUES
(1,'38a608f8-672d-4073-9341-11a792bc7a16','database','default','{\"uuid\":\"38a608f8-672d-4073-9341-11a792bc7a16\",\"displayName\":\"App\\\\Mail\\\\ContactConfirmation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:28:\\\"App\\\\Mail\\\\ContactConfirmation\\\":6:{s:10:\\\"senderName\\\";s:9:\\\"sasa toto\\\";s:11:\\\"senderEmail\\\";s:14:\\\"toto@gmail.com\\\";s:14:\\\"contactSubject\\\";s:10:\\\"simulation\\\";s:11:\\\"messageBody\\\";s:3:\\\"cvv\\\";s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:14:\\\"toto@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1775563576,\"delay\":null}','Symfony\\Component\\Mailer\\Exception\\TransportException: Connection could not be established with host \"ssl://smtp.hostinger.com:465\": stream_socket_client(): php_network_getaddresses: getaddrinfo for smtp.hostinger.com failed: Temporary failure in name resolution in /home/afterdays/Documents/kapitalstark/vendor/symfony/mailer/Transport/Smtp/Stream/SocketStream.php:154\nStack trace:\n#0 [internal function]: Symfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\SocketStream->{closure:Symfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\SocketStream::initialize():153}()\n#1 /home/afterdays/Documents/kapitalstark/vendor/symfony/mailer/Transport/Smtp/Stream/SocketStream.php(157): stream_socket_client()\n#2 /home/afterdays/Documents/kapitalstark/vendor/symfony/mailer/Transport/Smtp/SmtpTransport.php(268): Symfony\\Component\\Mailer\\Transport\\Smtp\\Stream\\SocketStream->initialize()\n#3 /home/afterdays/Documents/kapitalstark/vendor/symfony/mailer/Transport/Smtp/SmtpTransport.php(200): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->start()\n#4 /home/afterdays/Documents/kapitalstark/vendor/symfony/mailer/Transport/AbstractTransport.php(69): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doSend()\n#5 /home/afterdays/Documents/kapitalstark/vendor/symfony/mailer/Transport/Smtp/SmtpTransport.php(138): Symfony\\Component\\Mailer\\Transport\\AbstractTransport->send()\n#6 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Mail/Mailer.php(584): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->send()\n#7 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Mail/Mailer.php(331): Illuminate\\Mail\\Mailer->sendSymfonyMessage()\n#8 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Mail/Mailable.php(207): Illuminate\\Mail\\Mailer->send()\n#9 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Support/Traits/Localizable.php(19): Illuminate\\Mail\\Mailable->{closure:Illuminate\\Mail\\Mailable::send():200}()\n#10 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Mail/Mailable.php(200): Illuminate\\Mail\\Mailable->withLocale()\n#11 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Mail/SendQueuedMailable.php(89): Illuminate\\Mail\\Mailable->send()\n#12 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Mail\\SendQueuedMailable->handle()\n#13 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#14 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#15 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#16 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#17 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(135): Illuminate\\Container\\Container->call()\n#18 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\\Bus\\Dispatcher->{closure:Illuminate\\Bus\\Dispatcher::dispatchNow():132}()\n#19 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->{closure:Illuminate\\Pipeline\\Pipeline::prepareDestination():178}()\n#20 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(139): Illuminate\\Pipeline\\Pipeline->then()\n#21 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(134): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#22 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->{closure:Illuminate\\Queue\\CallQueuedHandler::dispatchThroughMiddleware():127}()\n#23 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->{closure:Illuminate\\Pipeline\\Pipeline::prepareDestination():178}()\n#24 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(127): Illuminate\\Pipeline\\Pipeline->then()\n#25 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#26 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#27 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(494): Illuminate\\Queue\\Jobs\\Job->fire()\n#28 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(442): Illuminate\\Queue\\Worker->process()\n#29 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(365): Illuminate\\Queue\\Worker->runJob()\n#30 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(148): Illuminate\\Queue\\Worker->runNextJob()\n#31 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#32 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#33 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#34 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#35 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#36 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#37 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Console/Command.php(280): Illuminate\\Container\\Container->call()\n#38 /home/afterdays/Documents/kapitalstark/vendor/symfony/console/Command/Command.php(291): Illuminate\\Console\\Command->execute()\n#39 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Console/Command.php(249): Symfony\\Component\\Console\\Command\\Command->run()\n#40 /home/afterdays/Documents/kapitalstark/vendor/symfony/console/Application.php(1107): Illuminate\\Console\\Command->run()\n#41 /home/afterdays/Documents/kapitalstark/vendor/symfony/console/Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand()\n#42 /home/afterdays/Documents/kapitalstark/vendor/symfony/console/Application.php(195): Symfony\\Component\\Console\\Application->doRun()\n#43 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(198): Symfony\\Component\\Console\\Application->run()\n#44 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Foundation/Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle()\n#45 /home/afterdays/Documents/kapitalstark/artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#46 {main}','2026-04-07 16:45:08'),
(2,'a5b1ce41-2539-4197-8c34-fc07b1b1e9df','database','transfers','{\"uuid\":\"a5b1ce41-2539-4197-8c34-fc07b1b1e9df\",\"displayName\":\"App\\\\Jobs\\\\ProcessTransfer\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":1,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":600,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessTransfer\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\ProcessTransfer\\\":2:{s:10:\\\"transferId\\\";i:1;s:5:\\\"queue\\\";s:9:\\\"transfers\\\";}\",\"batchId\":null},\"createdAt\":1775582142,\"delay\":null}','Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Transfer]. in /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php:785\nStack trace:\n#0 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(2004): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()\n#1 /home/afterdays/Documents/kapitalstark/app/Jobs/ProcessTransfer.php(102): Illuminate\\Database\\Eloquent\\Model->refresh()\n#2 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): App\\Jobs\\ProcessTransfer->handle()\n#3 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#4 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#5 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#6 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#7 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(135): Illuminate\\Container\\Container->call()\n#8 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\\Bus\\Dispatcher->{closure:Illuminate\\Bus\\Dispatcher::dispatchNow():132}()\n#9 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->{closure:Illuminate\\Pipeline\\Pipeline::prepareDestination():178}()\n#10 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(139): Illuminate\\Pipeline\\Pipeline->then()\n#11 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(134): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#12 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->{closure:Illuminate\\Queue\\CallQueuedHandler::dispatchThroughMiddleware():127}()\n#13 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->{closure:Illuminate\\Pipeline\\Pipeline::prepareDestination():178}()\n#14 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(127): Illuminate\\Pipeline\\Pipeline->then()\n#15 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#16 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#17 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(494): Illuminate\\Queue\\Jobs\\Job->fire()\n#18 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(442): Illuminate\\Queue\\Worker->process()\n#19 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(208): Illuminate\\Queue\\Worker->runJob()\n#20 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon()\n#21 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#22 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#23 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#24 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#25 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#26 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#27 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Console/Command.php(280): Illuminate\\Container\\Container->call()\n#28 /home/afterdays/Documents/kapitalstark/vendor/symfony/console/Command/Command.php(291): Illuminate\\Console\\Command->execute()\n#29 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Console/Command.php(249): Symfony\\Component\\Console\\Command\\Command->run()\n#30 /home/afterdays/Documents/kapitalstark/vendor/symfony/console/Application.php(1107): Illuminate\\Console\\Command->run()\n#31 /home/afterdays/Documents/kapitalstark/vendor/symfony/console/Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand()\n#32 /home/afterdays/Documents/kapitalstark/vendor/symfony/console/Application.php(195): Symfony\\Component\\Console\\Application->doRun()\n#33 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(198): Symfony\\Component\\Console\\Application->run()\n#34 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Foundation/Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle()\n#35 /home/afterdays/Documents/kapitalstark/artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#36 {main}','2026-04-07 17:18:36'),
(3,'4f238199-f130-4111-9923-13d0979c5dc9','database','transfers','{\"uuid\":\"4f238199-f130-4111-9923-13d0979c5dc9\",\"displayName\":\"App\\\\Jobs\\\\ProcessTransfer\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":1,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":600,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessTransfer\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\ProcessTransfer\\\":2:{s:10:\\\"transferId\\\";i:2;s:5:\\\"queue\\\";s:9:\\\"transfers\\\";}\",\"batchId\":null},\"createdAt\":1775582428,\"delay\":null}','Illuminate\\Queue\\TimeoutExceededException: App\\Jobs\\ProcessTransfer has timed out. in /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/TimeoutExceededException.php:15\nStack trace:\n#0 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(884): Illuminate\\Queue\\TimeoutExceededException::forJob()\n#1 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(249): Illuminate\\Queue\\Worker->timeoutExceededException()\n#2 [internal function]: Illuminate\\Queue\\Worker->{closure:Illuminate\\Queue\\Worker::registerTimeoutHandler():246}()\n#3 /home/afterdays/Documents/kapitalstark/app/Jobs/ProcessTransfer.php(133): sleep()\n#4 /home/afterdays/Documents/kapitalstark/app/Jobs/ProcessTransfer.php(88): App\\Jobs\\ProcessTransfer->waitForUnlock()\n#5 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): App\\Jobs\\ProcessTransfer->handle()\n#6 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#7 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#8 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#9 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#10 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(135): Illuminate\\Container\\Container->call()\n#11 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\\Bus\\Dispatcher->{closure:Illuminate\\Bus\\Dispatcher::dispatchNow():132}()\n#12 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->{closure:Illuminate\\Pipeline\\Pipeline::prepareDestination():178}()\n#13 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(139): Illuminate\\Pipeline\\Pipeline->then()\n#14 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(134): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#15 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->{closure:Illuminate\\Queue\\CallQueuedHandler::dispatchThroughMiddleware():127}()\n#16 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->{closure:Illuminate\\Pipeline\\Pipeline::prepareDestination():178}()\n#17 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(127): Illuminate\\Pipeline\\Pipeline->then()\n#18 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#19 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#20 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(494): Illuminate\\Queue\\Jobs\\Job->fire()\n#21 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(442): Illuminate\\Queue\\Worker->process()\n#22 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(208): Illuminate\\Queue\\Worker->runJob()\n#23 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon()\n#24 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#25 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#26 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#27 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#28 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#29 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#30 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Console/Command.php(280): Illuminate\\Container\\Container->call()\n#31 /home/afterdays/Documents/kapitalstark/vendor/symfony/console/Command/Command.php(291): Illuminate\\Console\\Command->execute()\n#32 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Console/Command.php(249): Symfony\\Component\\Console\\Command\\Command->run()\n#33 /home/afterdays/Documents/kapitalstark/vendor/symfony/console/Application.php(1107): Illuminate\\Console\\Command->run()\n#34 /home/afterdays/Documents/kapitalstark/vendor/symfony/console/Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand()\n#35 /home/afterdays/Documents/kapitalstark/vendor/symfony/console/Application.php(195): Symfony\\Component\\Console\\Application->doRun()\n#36 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(198): Symfony\\Component\\Console\\Application->run()\n#37 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Foundation/Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle()\n#38 /home/afterdays/Documents/kapitalstark/artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#39 {main}','2026-04-07 17:30:28'),
(4,'478d89e3-0715-45eb-a597-c5cdb06472a7','database','transfers','{\"uuid\":\"478d89e3-0715-45eb-a597-c5cdb06472a7\",\"displayName\":\"App\\\\Jobs\\\\ProcessTransfer\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":1,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":600,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessTransfer\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\ProcessTransfer\\\":2:{s:10:\\\"transferId\\\";i:2;s:5:\\\"queue\\\";s:9:\\\"transfers\\\";}\",\"batchId\":null},\"createdAt\":1775583259,\"delay\":null}','Illuminate\\Database\\Eloquent\\ModelNotFoundException: No query results for model [App\\Models\\Transfer]. in /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php:785\nStack trace:\n#0 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php(2004): Illuminate\\Database\\Eloquent\\Builder->firstOrFail()\n#1 /home/afterdays/Documents/kapitalstark/app/Jobs/ProcessTransfer.php(136): Illuminate\\Database\\Eloquent\\Model->refresh()\n#2 /home/afterdays/Documents/kapitalstark/app/Jobs/ProcessTransfer.php(88): App\\Jobs\\ProcessTransfer->waitForUnlock()\n#3 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): App\\Jobs\\ProcessTransfer->handle()\n#4 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#5 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#6 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#7 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#8 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(135): Illuminate\\Container\\Container->call()\n#9 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\\Bus\\Dispatcher->{closure:Illuminate\\Bus\\Dispatcher::dispatchNow():132}()\n#10 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->{closure:Illuminate\\Pipeline\\Pipeline::prepareDestination():178}()\n#11 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(139): Illuminate\\Pipeline\\Pipeline->then()\n#12 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(134): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#13 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->{closure:Illuminate\\Queue\\CallQueuedHandler::dispatchThroughMiddleware():127}()\n#14 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->{closure:Illuminate\\Pipeline\\Pipeline::prepareDestination():178}()\n#15 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(127): Illuminate\\Pipeline\\Pipeline->then()\n#16 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#17 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#18 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(494): Illuminate\\Queue\\Jobs\\Job->fire()\n#19 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(442): Illuminate\\Queue\\Worker->process()\n#20 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(208): Illuminate\\Queue\\Worker->runJob()\n#21 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon()\n#22 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#23 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#24 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#25 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#26 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#27 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#28 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Console/Command.php(280): Illuminate\\Container\\Container->call()\n#29 /home/afterdays/Documents/kapitalstark/vendor/symfony/console/Command/Command.php(291): Illuminate\\Console\\Command->execute()\n#30 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Console/Command.php(249): Symfony\\Component\\Console\\Command\\Command->run()\n#31 /home/afterdays/Documents/kapitalstark/vendor/symfony/console/Application.php(1107): Illuminate\\Console\\Command->run()\n#32 /home/afterdays/Documents/kapitalstark/vendor/symfony/console/Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand()\n#33 /home/afterdays/Documents/kapitalstark/vendor/symfony/console/Application.php(195): Symfony\\Component\\Console\\Application->doRun()\n#34 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(198): Symfony\\Component\\Console\\Application->run()\n#35 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Foundation/Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle()\n#36 /home/afterdays/Documents/kapitalstark/artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#37 {main}','2026-04-07 17:38:30'),
(5,'b52c4fd1-6550-419b-878d-76e8e47006cd','database','transfers','{\"uuid\":\"b52c4fd1-6550-419b-878d-76e8e47006cd\",\"displayName\":\"App\\\\Jobs\\\\ProcessTransfer\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":1,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":600,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessTransfer\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\ProcessTransfer\\\":2:{s:10:\\\"transferId\\\";i:3;s:5:\\\"queue\\\";s:9:\\\"transfers\\\";}\",\"batchId\":null},\"createdAt\":1775583644,\"delay\":null}','Illuminate\\Queue\\TimeoutExceededException: App\\Jobs\\ProcessTransfer has timed out. in /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/TimeoutExceededException.php:15\nStack trace:\n#0 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(884): Illuminate\\Queue\\TimeoutExceededException::forJob()\n#1 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(249): Illuminate\\Queue\\Worker->timeoutExceededException()\n#2 [internal function]: Illuminate\\Queue\\Worker->{closure:Illuminate\\Queue\\Worker::registerTimeoutHandler():246}()\n#3 /home/afterdays/Documents/kapitalstark/app/Jobs/ProcessTransfer.php(142): sleep()\n#4 /home/afterdays/Documents/kapitalstark/app/Jobs/ProcessTransfer.php(97): App\\Jobs\\ProcessTransfer->waitForUnlock()\n#5 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): App\\Jobs\\ProcessTransfer->handle()\n#6 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#7 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#8 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#9 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#10 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(135): Illuminate\\Container\\Container->call()\n#11 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\\Bus\\Dispatcher->{closure:Illuminate\\Bus\\Dispatcher::dispatchNow():132}()\n#12 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->{closure:Illuminate\\Pipeline\\Pipeline::prepareDestination():178}()\n#13 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(139): Illuminate\\Pipeline\\Pipeline->then()\n#14 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(134): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#15 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->{closure:Illuminate\\Queue\\CallQueuedHandler::dispatchThroughMiddleware():127}()\n#16 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->{closure:Illuminate\\Pipeline\\Pipeline::prepareDestination():178}()\n#17 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(127): Illuminate\\Pipeline\\Pipeline->then()\n#18 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#19 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#20 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(494): Illuminate\\Queue\\Jobs\\Job->fire()\n#21 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(442): Illuminate\\Queue\\Worker->process()\n#22 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(208): Illuminate\\Queue\\Worker->runJob()\n#23 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon()\n#24 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#25 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#26 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#27 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#28 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#29 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Container/Container.php(799): Illuminate\\Container\\BoundMethod::call()\n#30 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Console/Command.php(280): Illuminate\\Container\\Container->call()\n#31 /home/afterdays/Documents/kapitalstark/vendor/symfony/console/Command/Command.php(291): Illuminate\\Console\\Command->execute()\n#32 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Console/Command.php(249): Symfony\\Component\\Console\\Command\\Command->run()\n#33 /home/afterdays/Documents/kapitalstark/vendor/symfony/console/Application.php(1107): Illuminate\\Console\\Command->run()\n#34 /home/afterdays/Documents/kapitalstark/vendor/symfony/console/Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand()\n#35 /home/afterdays/Documents/kapitalstark/vendor/symfony/console/Application.php(195): Symfony\\Component\\Console\\Application->doRun()\n#36 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(198): Symfony\\Component\\Console\\Application->run()\n#37 /home/afterdays/Documents/kapitalstark/vendor/laravel/framework/src/Illuminate/Foundation/Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle()\n#38 /home/afterdays/Documents/kapitalstark/artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#39 {main}','2026-04-07 17:50:45');
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `jobs` VALUES
(3,'default','{\"uuid\":\"bde5a0c4-b472-404b-9bb6-874d5104ec18\",\"displayName\":\"App\\\\Mail\\\\WelcomeEmail\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:21:\\\"App\\\\Mail\\\\WelcomeEmail\\\":3:{s:4:\\\"user\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:4;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:14:\\\"fiif@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1775569683,\"delay\":null}',0,NULL,1775569683,1775569683),
(4,'default','{\"uuid\":\"c70f1918-d5b9-4da2-8c1a-89b6765dac69\",\"displayName\":\"App\\\\Mail\\\\LoanRequestReceived\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:28:\\\"App\\\\Mail\\\\LoanRequestReceived\\\":3:{s:11:\\\"loanRequest\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\LoanRequest\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:14:\\\"fiif@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1775570447,\"delay\":null}',0,NULL,1775570447,1775570447),
(5,'default','{\"uuid\":\"45ea0fea-6b1d-403f-b5f1-69742ccb3cb3\",\"displayName\":\"App\\\\Mail\\\\LoanRequestStatusChanged\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:33:\\\"App\\\\Mail\\\\LoanRequestStatusChanged\\\":3:{s:11:\\\"loanRequest\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\LoanRequest\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:14:\\\"fiif@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1775570485,\"delay\":null}',0,NULL,1775570485,1775570485),
(6,'default','{\"uuid\":\"3e4ea22d-211e-47d0-803e-2e8c5455a940\",\"displayName\":\"App\\\\Mail\\\\LoanRequestStatusChanged\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:33:\\\"App\\\\Mail\\\\LoanRequestStatusChanged\\\":3:{s:11:\\\"loanRequest\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\LoanRequest\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:14:\\\"fiif@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1775570535,\"delay\":null}',0,NULL,1775570535,1775570535),
(7,'default','{\"uuid\":\"1524dc32-fae7-4c29-8758-d1d4b2beccd9\",\"displayName\":\"App\\\\Mail\\\\LoanRequestStatusChanged\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:33:\\\"App\\\\Mail\\\\LoanRequestStatusChanged\\\":3:{s:11:\\\"loanRequest\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:22:\\\"App\\\\Models\\\\LoanRequest\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:14:\\\"fiif@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1775570551,\"delay\":null}',0,NULL,1775570551,1775570551),
(8,'default','{\"uuid\":\"5906207e-e9ac-43d9-b679-d74a18b800f1\",\"displayName\":\"App\\\\Jobs\\\\ProcessTransfer\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":1,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":600,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessTransfer\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\ProcessTransfer\\\":1:{s:10:\\\"transferId\\\";i:1;}\",\"batchId\":null},\"createdAt\":1775579342,\"delay\":null}',0,NULL,1775579342,1775579342),
(9,'default','{\"uuid\":\"9bf3f496-1df0-4e30-aec4-b7f141a12961\",\"displayName\":\"App\\\\Jobs\\\\ProcessTransfer\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":1,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":360,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ProcessTransfer\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\ProcessTransfer\\\":1:{s:10:\\\"transferId\\\";i:1;}\",\"batchId\":null},\"createdAt\":1775580292,\"delay\":null}',0,NULL,1775580292,1775580292),
(15,'default','{\"uuid\":\"0406afc9-53d5-45d5-8435-a043790baf20\",\"displayName\":\"App\\\\Mail\\\\AdvisorMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:23:\\\"App\\\\Mail\\\\AdvisorMessage\\\":3:{s:7:\\\"message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Message\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:14:\\\"fiif@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1775584489,\"delay\":null}',0,NULL,1775584489,1775584489),
(17,'default','{\"uuid\":\"573826dd-e093-40df-bc26-73ac129d313d\",\"displayName\":\"App\\\\Mail\\\\AdvisorMessage\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"deleteWhenMissingModels\":false,\"data\":{\"commandName\":\"Illuminate\\\\Mail\\\\SendQueuedMailable\",\"command\":\"O:34:\\\"Illuminate\\\\Mail\\\\SendQueuedMailable\\\":17:{s:8:\\\"mailable\\\";O:23:\\\"App\\\\Mail\\\\AdvisorMessage\\\":3:{s:7:\\\"message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Message\\\";s:2:\\\"id\\\";i:3;s:9:\\\"relations\\\";a:1:{i:0;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"to\\\";a:1:{i:0;a:2:{s:4:\\\"name\\\";N;s:7:\\\"address\\\";s:14:\\\"fiif@gmail.com\\\";}}s:6:\\\"mailer\\\";s:4:\\\"smtp\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:13:\\\"maxExceptions\\\";N;s:17:\\\"shouldBeEncrypted\\\";b:0;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\",\"batchId\":null},\"createdAt\":1775585248,\"delay\":null}',0,NULL,1775585248,1775585248);
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `loan_requests`
--

DROP TABLE IF EXISTS `loan_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `loan_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `loan_type` varchar(50) NOT NULL,
  `amount` bigint(20) unsigned NOT NULL,
  `duration_months` smallint(5) unsigned NOT NULL,
  `purpose` text NOT NULL,
  `income` int(10) unsigned NOT NULL,
  `charges` int(10) unsigned NOT NULL DEFAULT 0,
  `employment` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `contract_path` varchar(255) DEFAULT NULL,
  `signed_contract_path` varchar(255) DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `approved_amount` decimal(15,2) DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `loan_requests_user_id_foreign` (`user_id`),
  KEY `loan_requests_status_idx` (`status`),
  CONSTRAINT `loan_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loan_requests`
--

LOCK TABLES `loan_requests` WRITE;
/*!40000 ALTER TABLE `loan_requests` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `loan_requests` VALUES
(1,4,'automobile',50000,240,'http://127.0.0.1:8000/dashboard/ma-carte',222222,2233,'CDI','approved','2026-04-07 14:02:31','contracts/1/contrat-20260407-160125.pdf','contracts/1/contrat-signe-20260407-160158.pdf','cv',50000.00,'2026-04-07 14:02:31',NULL,'2026-04-07 14:00:47','2026-04-07 14:02:31');
/*!40000 ALTER TABLE `loan_requests` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `loans`
--

DROP TABLE IF EXISTS `loans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `loans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `type` varchar(50) NOT NULL,
  `amount` bigint(20) NOT NULL,
  `remaining` bigint(20) NOT NULL,
  `monthly` int(11) NOT NULL,
  `rate` decimal(5,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `progress` tinyint(4) NOT NULL DEFAULT 0,
  `status` enum('active','closed','late') NOT NULL DEFAULT 'active',
  `next_payment_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `loans_user_id_foreign` (`user_id`),
  CONSTRAINT `loans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loans`
--

LOCK TABLES `loans` WRITE;
/*!40000 ALTER TABLE `loans` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `loans` VALUES
(1,4,'automobile',50000,50000,219,3.50,'2026-04-07','2046-04-07',0,'active','2026-05-07','2026-04-07 14:02:31','2026-04-07 14:02:31');
/*!40000 ALTER TABLE `loans` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `direction` enum('inbound','outbound') NOT NULL,
  `body` text NOT NULL,
  `read` tinyint(1) NOT NULL DEFAULT 0,
  `subject` varchar(200) DEFAULT NULL,
  `attachment_path` varchar(255) DEFAULT NULL,
  `attachment_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_user_direction_idx` (`user_id`,`direction`),
  KEY `messages_user_direction_read_idx` (`user_id`,`direction`,`read`),
  CONSTRAINT `messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `messages` VALUES
(1,4,'outbound','Bonjour,\r\n\r\nVotre virement #3 nécessite un code de déblocage pour continuer.\r\n\r\nVotre code : YM4-2T4F\r\n\r\nRendez-vous sur votre espace client, page Virements, et entrez ce code dans le formulaire de déblocage.\r\n\r\nCordialement,\r\nL\'équipe KapitalStark',1,'Code de déblocage — Virement #00003','admin-templates/rAKjouAioTr0NgT9xMsYyb4si8Nchv4n16DZX6wJ.pdf','recu-20260404-5 (1).pdf','2026-04-07 17:54:49','2026-04-07 17:54:56'),
(2,4,'inbound','merci',1,NULL,NULL,NULL,'2026-04-07 17:55:16','2026-04-07 18:07:23'),
(3,4,'outbound','Bonjour,\r\n\r\nVotre virement #3 nécessite un code de déblocage pour continuer.\r\n\r\nVotre code : KEK-R2AS\r\n\r\nRendez-vous sur votre espace client, page Virements, et entrez ce code dans le formulaire de déblocage.\r\n\r\nCordialement,\r\nL\'équipe KapitalStark',1,'Code de déblocage — Virement #00003',NULL,NULL,'2026-04-07 18:07:28','2026-04-07 18:07:55');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_04_03_000000_create_newsletter_subscriptions_table',1),
(5,'2026_04_03_000001_create_loan_requests_table',1),
(6,'2026_04_03_000002_create_appointments_table',1),
(7,'2026_04_03_000003_create_messages_table',1),
(8,'2026_04_03_000004_create_contact_requests_table',1),
(9,'2026_04_03_000005_create_appointment_requests_table',1),
(10,'2026_04_03_000006_create_documents_table',1),
(11,'2026_04_03_000007_add_phone_is_admin_to_users_table',1),
(12,'2026_04_03_000008_create_loans_table',1),
(13,'2026_04_04_000001_create_transfers_table',1),
(14,'2026_04_05_000001_add_attachment_to_messages_table',2),
(15,'2026_04_05_000001_alter_loan_requests_workflow',3),
(16,'2026_04_05_000002_add_balance_to_users',3),
(17,'2026_04_05_000003_add_loan_request_id_to_documents',3),
(18,'2026_04_06_012435_create_push_subscriptions_table',4),
(19,'2026_04_06_012741_create_admin_template_documents_table',5),
(20,'2026_04_06_035704_add_indexes_for_performance',6),
(21,'2026_04_07_000001_create_chat_tables',7),
(22,'2026_04_07_183657_add_approved_status_to_transfers',8),
(23,'2026_04_07_185848_add_paused_status_to_transfers',9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `newsletter_subscriptions`
--

DROP TABLE IF EXISTS `newsletter_subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `newsletter_subscriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `source` varchar(50) NOT NULL DEFAULT 'home',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `newsletter_subscriptions_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletter_subscriptions`
--

LOCK TABLES `newsletter_subscriptions` WRITE;
/*!40000 ALTER TABLE `newsletter_subscriptions` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `newsletter_subscriptions` VALUES
(1,'fifi@gmail.com',1,'home','2026-04-07 13:36:13','2026-04-07 13:36:13');
/*!40000 ALTER TABLE `newsletter_subscriptions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `push_subscriptions`
--

DROP TABLE IF EXISTS `push_subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `push_subscriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `endpoint` text NOT NULL,
  `p256dh` varchar(255) NOT NULL,
  `auth` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `push_user_endpoint_unique` (`user_id`,`endpoint`) USING HASH,
  KEY `push_subscriptions_user_id_foreign` (`user_id`),
  CONSTRAINT `push_subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `push_subscriptions`
--

LOCK TABLES `push_subscriptions` WRITE;
/*!40000 ALTER TABLE `push_subscriptions` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `push_subscriptions` VALUES
(1,4,'https://fcm.googleapis.com/fcm/send/fLjSkTqgNjs:APA91bEzgqi7e_k5RgwlXYXzGxoDu7xZBsKa4Bmt_AGy38nYat6fwtHMN54rJwOCFe-hXuRabLCx7cV1Innk1BRXhlfZLjiJKflzrGzeJ4PVPHmDxI3qbFAiZMKiWOxCMw_6D4r-_2Ud','BMhrk9MxEremvdfKMjTu1Q9ZlvW2-VAMxNMDMJ2xkDvOyJJr0B09N-rFzqNDhBF11etQdDJAsJVJGocF-Rm9iSc','orvBo7psdjadVNGWNAdjYQ','2026-04-07 13:48:15','2026-04-07 13:48:15');
/*!40000 ALTER TABLE `push_subscriptions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `sessions` VALUES
('vJ2NXMLu8MYvYciQzACr1jBVfYTvZrrZ8DiUfTHM',2,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJTMnJEMTFUQkJWajgySllSYzZha3E3WW5NMlZnV1pwekpPWTMzV2ZaIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hZG1pblwvbWVzc2FnZXJpZT91c2VyX2lkPTQiLCJyb3V0ZSI6ImFkbWluLm1lc3NhZ2VzIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjJ9',1775586317),
('VlAGEJxo58SNRiNV6uiZVqMG8WvEEDOQnLyox26T',NULL,'127.0.0.1','curl/8.17.0','eyJfdG9rZW4iOiJMYm8ybjk5OUdMQm10b2dqSjhJdHNmbUgwRjVtRzJyUjlLRHZJeUFWIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hZG1pblwvdmlyZW1lbnRzXC8zIiwicm91dGUiOiJhZG1pbi50cmFuc2ZlcnMuc2hvdyJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1775584544),
('xIlRDREVRZ6Z0ik8eodHpzrRavhSQchZYpQaH87K',4,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36','eyJfdG9rZW4iOiIyTllUcXlFbE56TDhyVnZZQ2pQcUlya2UycDV3MHRjdnhIaEVpNFBPIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9kYXNoYm9hcmRcL3ZpcmVtZW50c1wvMyIsInJvdXRlIjoiZGFzaGJvYXJkLnRyYW5zZmVycy5zaG93In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9jYWxlIjoiZnIiLCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6NH0=',1775586334);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `transfers`
--

DROP TABLE IF EXISTS `transfers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `transfers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `recipient_iban` varchar(34) NOT NULL,
  `recipient_bic` varchar(11) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` enum('pending','approved','processing','paused','completed','rejected') NOT NULL DEFAULT 'pending',
  `progress` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `stop_levels` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`stop_levels`)),
  `completion_message` text DEFAULT NULL,
  `validated_by` bigint(20) unsigned DEFAULT NULL,
  `validated_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transfers_user_id_foreign` (`user_id`),
  KEY `transfers_validated_by_foreign` (`validated_by`),
  KEY `transfers_status_idx` (`status`),
  CONSTRAINT `transfers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transfers_validated_by_foreign` FOREIGN KEY (`validated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transfers`
--

LOCK TABLES `transfers` WRITE;
/*!40000 ALTER TABLE `transfers` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `transfers` VALUES
(3,4,20000.00,'dodo','FR3098309309930',NULL,'Website for comeup-sales.ct.ws','cc','completed',100,'[{\"percentage\":10,\"text\":\"ou ok\",\"reached_at\":\"2026-04-07T19:41:15+02:00\",\"unlock_code\":\"YM4-2T4F\",\"code_used_at\":\"2026-04-07T19:55:41+02:00\"},{\"percentage\":15,\"text\":\"oui 2\",\"reached_at\":\"2026-04-07T20:06:44+02:00\",\"unlock_code\":\"KEK-R2AS\",\"code_used_at\":\"2026-04-07T20:08:27+02:00\"}]','ok c\'est bon maintenant',2,'2026-04-07 17:40:32','2026-04-07 18:12:43','2026-04-07 17:39:39','2026-04-07 18:12:43');
/*!40000 ALTER TABLE `transfers` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `users` VALUES
(2,'Administrateur','admin@kapitalstark.fr',NULL,0.00,NULL,'$2y$12$8sjOtQsH1MnhA23nSQm5t.j6eplp1E8fHvjwbMzZxtU4nS3B45vl6',NULL,1,'2026-04-05 13:58:24','2026-04-07 11:48:05'),
(4,'fifi gogo','fiif@gmail.com',NULL,50000.00,NULL,'$2y$12$xorCMtHMQQ.LeCdQ6N9rAOWkSp1/sbt7i84v0HYEVabPTBlVKSBCq',NULL,0,'2026-04-07 13:48:03','2026-04-07 14:02:31');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping routines for database 'kapitalstark'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-04-07 20:25:35
