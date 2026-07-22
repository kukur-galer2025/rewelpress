DROP DATABASE IF EXISTS press_unsoed_db; CREATE DATABASE press_unsoed_db; USE press_unsoed_db;  
-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: press_unsoed_db
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `authors`
--

DROP TABLE IF EXISTS `authors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `authors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `affiliation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `authors`
--

LOCK TABLES `authors` WRITE;
/*!40000 ALTER TABLE `authors` DISABLE KEYS */;
INSERT INTO `authors` VALUES (1,'Prof. Dr. Ir. Suwarto, M.S.','https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=400&h=400&q=80','Guru Besar Ilmu Pertanian Tropis UNSOED','Pakar pertanian tropis dan agroteknologi dengan fokus pada pengembangan varietas unggul tahan perubahan iklim.','2026-07-22 01:43:58'),(2,'Dr. Hibnu Nugroho, S.H., M.H.','https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&h=400&q=80','Pakar Hukum & Dosen Fakultas Hukum UNSOED','Pakar hukum pidana dan acara pidana Indonesia yang aktif menulis berbagai buku referensi hukum modern.','2026-07-22 01:43:58'),(3,'Dr. Agus Hery Susanto, M.S.','https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&h=400&q=80','Ahli Biologi & Bioteknologi UNSOED','Peneliti di bidang bioteknologi molekuler dan genetika tumbuhan pada Fakultas Biologi UNSOED.','2026-07-22 01:43:58'),(4,'Prof. Wiwiek Rabiatul Adawiyah','https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&h=400&q=80','Guru Besar Ekonomi & Bisnis UNSOED','Dekan FEB UNSOED yang konsen dalam bidang manajemen pemasaran, kewirausahaan, dan ekonomi pembangunan daerah.','2026-07-22 01:43:58'),(5,'Dr. Tyas Retno Wulan','https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=400&h=400&q=80','Sosiolog & Peneliti Masyarakat Desa UNSOED','Sosiolog FISIP UNSOED yang mengkaji pemberdayaan perempuan, sosiologi pedesaan, dan kajian gender.','2026-07-22 01:43:58'),(6,'Dr. dr. Eman Sutrisna, M.Kes.','https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=400&h=400&q=80','Dosen Kedokteran & Kesehatan Masyarakat UNSOED','Dosen Fakultas Kedokteran UNSOED dengan spesialisasi kedokteran umum dan farmakologi medis.','2026-07-22 01:43:58'),(7,'ya','http://localhost/rewelpress/public/assets/uploads/author_6a60257167966.jpg','ya','ya','2026-07-22 02:05:37'),(8,'yaa','https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=400&h=400&q=80','','','2026-07-22 07:14:26');
/*!40000 ALTER TABLE `authors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `books` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `synopsis` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `isbn` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edition` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dimensions` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Bahasa Indonesia',
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'published',
  `price` int NOT NULL,
  `old_price` int DEFAULT '0',
  `pages` int DEFAULT NULL,
  `weight` int DEFAULT NULL,
  `publication_year` int DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` int DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_flashsale` tinyint(1) DEFAULT '0',
  `stock` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `books_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (7,1,'Pengantar Ilmu Pertanian Tropis','pengantar-ilmu-pertanian-tropis','Dr. Agus Hery Susanto, M.S.; Dr. dr. Eman Sutrisna, M.Kes.; Dr. Hibnu Nugroho, S.H., M.H.','pppp','978-623-1234-56-7',NULL,NULL,NULL,'Bahasa Indonesia','published',85000,100000,250,400,2024,'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80&w=400',120,'2026-07-21 10:26:47',0,50),(8,2,'Metodologi Penelitian Hukum Modern','metodologi-penelitian-hukum-modern','Dr. Hibnu Nugroho, S.H., M.H.',NULL,'978-623-2233-44-1',NULL,NULL,NULL,'Bahasa Indonesia','published',95000,0,320,500,2023,'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?auto=format&fit=crop&q=80&w=400',450,'2026-07-21 10:26:47',0,35),(9,3,'Dasar-Dasar Bioteknologi','dasar-dasar-bioteknologi','Dr. Agus Hery Susanto, M.S.',NULL,'978-623-4567-89-0',NULL,NULL,NULL,'Bahasa Indonesia','published',110000,135000,180,300,2025,'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&q=80&w=400',300,'2026-07-21 10:26:47',0,120),(10,4,'Ekonomi Pembangunan Daerah','ekonomi-pembangunan-daerah','Prof. Wiwiek Rabiatul Adawiyah',NULL,'978-623-9988-77-6',NULL,NULL,NULL,'Bahasa Indonesia','published',75000,0,400,600,2022,'https://images.unsplash.com/photo-1611095966426-17b5f16805d7?auto=format&fit=crop&q=80&w=400',150,'2026-07-21 10:26:47',0,15),(11,5,'Sosiologi Masyarakat Desa','sosiologi-masyarakat-desa','Dr. Tyas Retno Wulan',NULL,'978-623-1122-33-4',NULL,NULL,NULL,'Bahasa Indonesia','published',65000,80000,210,350,2023,'https://images.unsplash.com/photo-1526958097901-5e6d742d3371?auto=format&fit=crop&q=80&w=400',200,'2026-07-21 10:26:47',0,80),(12,6,'Kesehatan Masyarakat Pedesaan','kesehatan-masyarakat-pedesaan','Dr. dr. Eman Sutrisna, M.Kes.',NULL,'978-623-5566-77-8',NULL,NULL,NULL,'Bahasa Indonesia','published',120000,150000,280,450,2024,'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&q=80&w=400',500,'2026-07-21 10:26:47',0,45),(13,5,'Ya','ya','ya','ya','ya',NULL,NULL,NULL,'Bahasa Indonesia','published',1000,1000,100,10,1000,'http://localhost/rewelpress/public/assets/uploads/6a5f4bacd8155.jpeg',0,'2026-07-21 10:31:47',1,0);
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Sains & Teknologi','sains-teknologi',NULL),(2,'Sosial & Humaniora','sosial-humaniora',NULL),(3,'Kesehatan & Kedokteran','kesehatan-kedokteran',NULL),(4,'Arsitektur','arsitektur',1),(5,'Biologi','biologi',1),(6,'Fisika','fisika',1),(7,'Teknik Kimia','teknik-kimia',1),(8,'Hukum','hukum',2),(9,'Ekonomi','ekonomi',2),(10,'Sosial','sosial',2),(11,'Kedokteran','kedokteran',3),(12,'Keperawatan','keperawatan',3),(13,'Pertanian','pertanian',1);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_messages`
--

LOCK TABLES `contact_messages` WRITE;
/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ebook_orders`
--

DROP TABLE IF EXISTS `ebook_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ebook_orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `ebook_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `voucher_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_amount` decimal(12,2) DEFAULT '0.00',
  `status` enum('pending','paid','confirmed','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_receipt` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `ebook_id` (`ebook_id`),
  CONSTRAINT `fk_ebook_orders_ebook` FOREIGN KEY (`ebook_id`) REFERENCES `ebooks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_ebook_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ebook_orders`
--

LOCK TABLES `ebook_orders` WRITE;
/*!40000 ALTER TABLE `ebook_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `ebook_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ebooks`
--

DROP TABLE IF EXISTS `ebooks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ebooks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `book_id` int DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_pdf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview_pdf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '15 MB',
  `page_count` int DEFAULT '200',
  `ebook_price` decimal(12,2) DEFAULT '0.00',
  `is_free` tinyint(1) DEFAULT '0',
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `downloads_count` int DEFAULT '0',
  `views_count` int DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_flashsale` tinyint(1) DEFAULT '0',
  `category_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `book_id` (`book_id`),
  KEY `fk_ebook_category` (`category_id`),
  CONSTRAINT `fk_ebook_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_ebooks_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ebooks`
--

LOCK TABLES `ebooks` WRITE;
/*!40000 ALTER TABLE `ebooks` DISABLE KEYS */;
INSERT INTO `ebooks` VALUES (1,7,'Pengantar Ilmu Pertanian Tropis (Edisi Digital)','sample_ebook_1.pdf','preview_bab1_1.pdf','13.5 MB',190,59500.00,0,'active',17,0,'2026-07-22 01:43:58',0,NULL),(2,8,'Metodologi Penelitian Hukum Modern (Edisi Digital)','sample_ebook_2.pdf','preview_bab1_2.pdf','16.5 MB',230,66500.00,0,'active',29,1,'2026-07-22 01:43:58',0,NULL),(3,9,'Dasar-Dasar Bioteknologi (Edisi Digital)','sample_ebook_3.pdf','preview_bab1_3.pdf','19.5 MB',270,77000.00,0,'active',41,0,'2026-07-22 01:43:58',0,NULL),(4,10,'Ekonomi Pembangunan Daerah (Edisi Digital)','sample_ebook_4.pdf','preview_bab1_4.pdf','22.5 MB',310,0.00,1,'active',53,0,'2026-07-22 01:43:58',0,NULL);
/*!40000 ALTER TABLE `ebooks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_albums`
--

DROP TABLE IF EXISTS `gallery_albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gallery_albums` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_albums`
--

LOCK TABLES `gallery_albums` WRITE;
/*!40000 ALTER TABLE `gallery_albums` DISABLE KEYS */;
INSERT INTO `gallery_albums` VALUES (1,'Idul Fitri 1439 H','idul-fitri-1439-h','2026-07-22 08:43:59'),(2,'Bazar Buku Online 2018','bazar-buku-online-2018','2026-07-22 08:43:59'),(3,'Silaturahmi Manajer dan Koordinator ke Redaksi Tribun','silaturahmi-manajer-ke-redaksi-tribun','2026-07-22 08:43:59'),(4,'Di Balik Lensa Kata','di-balik-lensa-kata','2026-07-22 08:43:59'),(5,'Clearance Sale Pameran Buku','clearance-sale-pameran-buku','2026-07-22 08:43:59'),(6,'Bedah Buku Mengembangkan Profesi Analisis Kebijakan','bedah-buku-profesi-analisis-kebijakan','2026-07-22 08:43:59'),(7,'New Springer Nature co publishing agreements','springer-nature-co-publishing','2026-07-22 08:43:59');
/*!40000 ALTER TABLE `gallery_albums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_photos`
--

DROP TABLE IF EXISTS `gallery_photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gallery_photos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `album_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_url` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `album_id` (`album_id`),
  CONSTRAINT `gallery_photos_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `gallery_albums` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_photos`
--

LOCK TABLES `gallery_photos` WRITE;
/*!40000 ALTER TABLE `gallery_photos` DISABLE KEYS */;
INSERT INTO `gallery_photos` VALUES (1,1,'Selamat Idul Fitri 1439 H Banner 1','https://images.unsplash.com/photo-1564507592333-c60657eea523?auto=format&fit=crop&w=600&q=80','2026-07-22 08:43:59'),(2,1,'Selamat Idul Fitri 1439 H Banner 2','https://images.unsplash.com/photo-1542816417-0983c9c9ad53?auto=format&fit=crop&w=600&q=80','2026-07-22 08:43:59'),(3,2,'Bazar Buku Online Promo 70% Off','https://images.unsplash.com/photo-1507842229356-51c6150fe11c?auto=format&fit=crop&w=600&q=80','2026-07-22 08:43:59'),(4,2,'Vlog Competition Bazar Buku','https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=600&q=80','2026-07-22 08:43:59'),(5,2,'Bazar Buku Online April Promo','https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=600&q=80','2026-07-22 08:43:59'),(6,3,'Wawancara Eksklusif Liputan Buku','https://images.unsplash.com/photo-1557804506-669a67965ba0?auto=format&fit=crop&w=600&q=80','2026-07-22 08:43:59'),(7,3,'Diskusi Redaksi Media & Penerbitan','https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=600&q=80','2026-07-22 08:43:59'),(8,3,'Foto Bersama Tim Redaksi','https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=600&q=80','2026-07-22 08:43:59'),(9,3,'Penyerahan Buku Cinderamata','https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=600&q=80','2026-07-22 08:43:59'),(10,4,'Suasana Pameran & Bedah Buku','https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=600&q=80','2026-07-22 08:43:59'),(11,5,'Pengunjung Memilih Buku Clearance Sale 1','https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=600&q=80','2026-07-22 08:43:59'),(12,5,'Pengunjung Memilih Buku Clearance Sale 2','https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=600&q=80','2026-07-22 08:43:59'),(13,5,'Antusiasme Mahasiswa di Stand Buku 1','https://images.unsplash.com/photo-1568667256549-094345857637?auto=format&fit=crop&w=600&q=80','2026-07-22 08:43:59'),(14,5,'Antusiasme Mahasiswa di Stand Buku 2','https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80','2026-07-22 08:43:59');
/*!40000 ALTER TABLE `gallery_photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_videos`
--

DROP TABLE IF EXISTS `gallery_videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gallery_videos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `youtube_url` text NOT NULL,
  `thumbnail_url` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_videos`
--

LOCK TABLES `gallery_videos` WRITE;
/*!40000 ALTER TABLE `gallery_videos` DISABLE KEYS */;
INSERT INTO `gallery_videos` VALUES (1,'Cara Belanja Online di Unsoed Press','https://www.youtube.com/embed/dQw4w9WgXcQ','https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80','2026-07-22 08:43:59'),(2,'Get Your Book Easier - Video Teaser','https://www.youtube.com/embed/dQw4w9WgXcQ','https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=600&q=80','2026-07-22 08:43:59'),(3,'Ayo Beli Buku Asli - Kampanye Literasi','https://www.youtube.com/embed/dQw4w9WgXcQ','https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=600&q=80','2026-07-22 08:43:59'),(4,'Nantikan Cuci Gudang Buku Lewat Online 8-22 Desember','https://www.youtube.com/embed/dQw4w9WgXcQ','https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=600&q=80','2026-07-22 08:43:59'),(5,'Mau Tau Penerbitan Akademik? Simak Alurnya','https://www.youtube.com/embed/dQw4w9WgXcQ','https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&w=600&q=80','2026-07-22 08:43:59'),(6,'Liputan Khusus Pameran Buku Nasional','https://www.youtube.com/embed/dQw4w9WgXcQ','https://images.unsplash.com/photo-1507842229356-51c6150fe11c?auto=format&fit=crop&w=600&q=80','2026-07-22 08:43:59');
/*!40000 ALTER TABLE `gallery_videos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `news` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `views` int DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'ya','ya','<blockquote><strong><em>ya</em></strong></blockquote>','[\"http:\\/\\/localhost\\/press-unsoed\\/public\\/assets\\/uploads\\/news\\/news_6a5f5bfc6a246_0.jpeg\",\"http:\\/\\/localhost\\/press-unsoed\\/public\\/assets\\/uploads\\/news\\/news_6a5f5bfc6ac0d_1.jpeg\"]',0,'2026-07-21 11:35:20','2026-07-21 11:46:04'),(2,'DORONG MUTU PENDIDIKAN KEDOKTERAN, FK-KMK UGM KUPAS TUNTAS BUKU \"PROGRAMMATIC ASSESSMENT\" BERBASIS OBE','dorong-mutu-pendidikan-kedokteran-fk-kmk-ugm-kupas-tuntas-buku-programmatic-assessment','<p><strong>YOGYAKARTA</strong> — Dalam upaya merespons dinamika pendidikan tinggi saat ini, Fakultas Kedokteran, Kesehatan Masyarakat, dan Keperawatan (FK-KMK) Universitas Gadjah Mada (UGM) kembali menggelar diskusi akademik strategis. Bertempat di Auditorium Gedung Tahir Foundation pada Rabu (4/6/2026), FK-KMK UGM menyelenggarakan <em>talkshow</em> bedah buku yang menyoroti transformasi asesmen pendidikan kedokteran dalam kerangka <em>Outcome-Based Education</em> (OBE).</p>\r\n<p>Acara ini secara khusus membedah karya terbaru dari Prof. dr. Mora Claramita, MHPE., Ph.D., Sp.KKLP beserta tim penulis. Menariknya, buku berukuran standar 15.5 x 23 cm ini tidak sekadar memaparkan teori, melainkan dirancang secara spesifik sebagai panduan operasional bagi institusi pendidikan kesehatan.</p>\r\n<p>Untuk menggali isi buku secara mendalam, acara yang dipandu oleh dr. Rachmadya Nur Hidayah, M.Sc., Ph.D. ini menghadirkan dua pakar utama sebagai pembedah, yaitu:</p>\r\n<p><strong>Prof. dr. Rr. Titi Savitri Prihatiningsih, MA, M.Med.Ed., Ph.D.</strong> (Pakar Kurikulum)<br><strong>Prof. dr. Eggi Arguni, M.Sc., Ph.D., Sp.A(K).</strong> (Pakar Pembelajaran Klinis)</p>\r\n<h3 class=\"font-bold text-xl mt-6 mb-3\">Tantangan Kurikulum Dan Evaluasi Berkelanjutan</h3>\r\n<p>Wakil Dekan Bidang Akademik dan Kemahasiswaan FK-KMK UGM, dr. Ahmad Hamim Sadewa, Ph.D., menegaskan bahwa fakultasnya terus berkomitmen memelopori inovasi pendidikan. Ia menyoroti bahwa penerapan <em>Programmatic Assessment</em> pada kurikulum yang sudah mapan bukanlah proses yang instan.</p>\r\n<p>\"Membutuhkan pemahaman yang utuh terkait konsep, mekanisme, hingga tahap eksekusinya. Harapannya, inovasi asesmen ini dapat berdampak langsung pada peningkatan kualitas pendidikan kedokteran di Indonesia dari waktu ke waktu,\" jelas dr. Hamim.</p>\r\n<p>Dukungan serupa disampaikan oleh Dr. I Wayan Mustika, S.T., M.Eng., Manajer UGM Press selaku penerbit. Menurutnya, penerapan kurikulum berbasis OBE di Indonesia saat ini berisiko kehilangan potensinya jika tidak dibarengi dengan sistem evaluasi yang mumpuni. Ia menyebut buku ini sebagai solusi komprehensif bagi institusi untuk melakukan perbaikan kurikulum yang berkesinambungan.</p>\r\n<h3 class=\"font-bold text-xl mt-6 mb-3\">Implementasi Dari Ruang Kuliah Hingga Rumah Sakit</h3>\r\n<p>Dalam sesi pemaparan, Prof. Mora menguraikan lima elemen krusial dalam <em>Programmatic Assessment</em> yang menjadi tulang punggung bukunya. Diskusi kemudian diperkaya oleh tinjauan Prof. Titi yang membedah keunggulan sistem asesmen tersebut dari kacamata literatur pendidikan kedokteran dan integrasinya dengan OBE.</p>\r\n<p>Sebagai pamungkas, Prof. Eggi membawa diskusi ke ranah yang lebih praktis, yakni bagaimana sistem evaluasi ini diterapkan di lapangan, khususnya terkait tantangan nyata di rumah sakit pendidikan dan rotasi klinis mahasiswa.</p>\r\n<p>Kegiatan bedah buku ini bukan sekadar agenda rutin kampus, melainkan wujud kontribusi nyata FK-KMK UGM terhadap Tujuan Pembangunan Berkelanjutan (SDGs). Terutama pada pilar Pendidikan Berkualitas (SDG 4), Kehidupan Sehat dan Sejahtera (SDG 3) melalui proyeksi kualitas layanan kesehatan yang lebih baik, serta Kemitraan untuk Mencapai Tujuan (SDG 17) lewat kolaborasi apik antara akademisi, fakultas, dan penerbit.</p>','[\"https:\\/\\/images.unsplash.com\\/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1000&q=80\"]',0,'2026-06-04 03:00:00','2026-07-22 01:43:59'),(3,'FK-KMK UGM Menggelar Bedah Buku Prinsip-Prinsip Riset Implementasi Untuk Tekankan Komitmen Diseminasi','fk-kmk-ugm-menggelar-bedah-buku-prinsip-prinsip-riset-implementasi','<p>Fakultas Kedokteran, Kesehatan Masyarakat, dan Keperawatan UGM kembali menggelar forum akademik melalui kegiatan bedah buku bertajuk Prinsip-Prinsip Riset Implementasi pada Selasa (18/2). Agenda ini dilaksanakan secara bauran dengan partisipasi 76 peserta hadir langsung di Auditorium Lantai 1 Gedung Tahir Foundation FK-KMK UGM serta 69 peserta mengikuti secara daring melalui Zoom.</p><p>Riset implementasi memegang peranan sangat vital dalam menjembatani kesenjangan antara temuan ilmiah laboratorium dengan penerapan kebijakan kesehatan nyata di masyarakat.</p>','[\"https:\\/\\/images.unsplash.com\\/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1000&q=80\"]',0,'2026-02-18 02:30:00','2026-07-22 01:43:59'),(4,'Tutup 2025, Fikrul Hanif Sufyan Luncurkan Buku Fort De Kock Dan Depresi Ekonomi','tutup-2025-fikrul-hanif-sufyan-luncurkan-buku-fort-de-kock','<p>Padang — Menutup rangkaian kegiatan akhir tahun 2025, peneliti sekaligus dosen sejarah Fikrul Hanif Sufyan resmi meluncurkan buku terbarunya berjudul Fort de Kock dan Depresi Ekonomi pada Minggu malam (28/12/2025). Peluncuran buku ini digelar dalam Festival Akhir Tahun yang berlangsung di Toko Buku Steva, Padang, dan dirangkai dengan agenda bedah buku bersama para sejarawan nasional.</p>','[\"https:\\/\\/images.unsplash.com\\/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&w=1000&q=80\"]',0,'2025-12-28 12:00:00','2026-07-22 01:43:59'),(5,'GELARAN PESTA BUKU JOGJA 2025 BERLANGSUNG SANGAT MERIAH','gelaran-pesta-buku-jogja-2025-berlangsung-sangat-meriah','<p>UGM Press bekerja sama dengan IKAPI DIY dengan penuh semangat mengadakan event bazar buku supermeriah dan supermurah, yang bertempat di GIK UGM Zona D Art Gallery. Acara ini berlangsung pada 26 November hingga 09 Desember 2025, dan diikuti lebih dari 60 penerbit di Yogyakarta. Pesta Buku Jogja 2025 resmi dibuka dengan antusiasme tinggi dari ribuan pecinta literasi.</p>','[\"https:\\/\\/images.unsplash.com\\/photo-1507842229356-51c615040f6f?auto=format&fit=crop&w=1000&q=80\"]',0,'2025-12-05 07:00:00','2026-07-22 01:43:59'),(6,'MEP FEB UGM Luncurkan Buku Inovasi Berdampak Pada Pembangunan Ekonomi Berkelanjutan','mep-feb-ugm-luncurkan-buku-inovasi-berdampak-ekonomi','<p>Yogyakarta, 13 Juni 2025 — Program Studi Magister Ekonomika Pembangunan (MEP) FEB UGM sukses menyelenggarakan Seminar Nasional dalam rangka memperingati Dies Natalis ke-30, Jumat (13/6). Bertempat di kampus FEB UGM, seminar ini mengangkat tema \"Mewujudkan Inovasi Berdampak pada Pembangunan Ekonomi Berkelanjutan\" dan menjadi momen penting peluncuran buku terbaru karya dosen MEP.</p>','[\"https:\\/\\/images.unsplash.com\\/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1000&q=80\"]',0,'2025-06-13 04:00:00','2026-07-22 01:43:59');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT '0' COMMENT '0/NULL untuk admin, >0 untuk user',
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,0,'Pesanan Baru #INV-1001','Pesanan baru masuk dari pengguna seharga Rp 125.000 menunggu konfirmasi.','http://localhost/rewelpress/public/admin/orders',1,'2026-07-22 06:43:59'),(2,0,'Bukti Pembayaran Diunggah #INV-1001','Pelanggan telah mengunggah bukti transfer untuk pesanan #INV-1001.','http://localhost/rewelpress/public/admin/orders',1,'2026-07-22 07:43:59'),(3,1,'Selamat Datang di Unsoed Press','Akun Anda berhasil didaftarkan. Nikmati kemudahan berbelanja buku akademik & publikasi ilmiah.','http://localhost/rewelpress/public/profile',1,'2026-07-21 08:43:59'),(4,1,'Pembayaran Diverifikasi!','Pembayaran untuk pesanan #INV-1001 telah diverifikasi oleh Admin. Pesanan segera diproses.','http://localhost/rewelpress/public/book',0,'2026-07-22 08:13:59'),(5,0,'Pesanan Baru #INV-1','Pesanan baru seharga Rp 65.000 menunggu pembayaran.','http://localhost/rewelpress/public/admin/orders',1,'2026-07-22 09:35:52'),(6,0,'Bukti Pembayaran Diunggah #INV-1','Pelanggan telah mengunggah bukti transfer untuk pesanan #INV-1','http://localhost/rewelpress/public/admin/orders',1,'2026-07-22 09:38:54'),(7,3,'Pembayaran Diverifikasi!','Pembayaran untuk pesanan #INV-1 telah diverifikasi oleh Admin Unsoed Press. Buku segera disiapkan.','http://localhost/rewelpress/public/order',0,'2026-07-22 09:39:27'),(8,0,'Pesanan Baru #INV-2','Pesanan baru seharga Rp 65.000 menunggu pembayaran.','http://localhost/rewelpress/public/admin/orders',1,'2026-07-22 09:50:46'),(9,0,'Bukti Pembayaran Diunggah #INV-2','Pelanggan telah mengunggah bukti transfer untuk pesanan #INV-2','http://localhost/rewelpress/public/admin/orders',1,'2026-07-22 09:50:52'),(10,3,'Pembayaran Diverifikasi!','Pembayaran untuk pesanan #INV-2 telah diverifikasi oleh Admin Unsoed Press. Buku segera disiapkan.','http://localhost/rewelpress/public/order',0,'2026-07-22 09:52:04');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `book_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `book_id` (`book_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,7,1,85000.00),(2,2,7,1,85000.00);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `voucher_code` varchar(50) DEFAULT NULL,
  `discount_amount` decimal(12,2) DEFAULT '0.00',
  `status` enum('pending','paid','confirmed','rejected') NOT NULL DEFAULT 'pending',
  `delivery_method` enum('pickup','shipping') NOT NULL DEFAULT 'pickup',
  `shipping_address` text,
  `payment_receipt` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,3,65000.00,'BUKUCETAK',20000.00,'confirmed','pickup',NULL,'http://localhost/rewelpress/public/assets/uploads/receipt_1_6a602d3e76f8b.jpg','2026-07-22 02:35:52'),(2,3,65000.00,'BUKUCETAK',20000.00,'confirmed','pickup','A','http://localhost/rewelpress/public/assets/uploads/receipt_2_6a60300c6442d.jpg','2026-07-22 02:50:46');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `qris_image` varchar(255) DEFAULT NULL,
  `bank_accounts` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,NULL,'BCA 1234567890 a.n Unsoed Press');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','customer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','admin@unsoed.ac.id','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','admin',NULL,NULL,'2026-07-21 10:15:39'),(2,'Mahasiswa','mahasiswa@mhs.unsoed.ac.id','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','customer',NULL,NULL,'2026-07-21 10:15:39'),(3,'Radit Yusuf','kingraditya2005@gmail.com','$2y$10$qw4XpEOjHDygL1XFWrWvdOhi9F8txUO.6MscaBIX51Z/DJhuI/1XK','customer',NULL,NULL,'2026-07-22 02:18:29'),(4,'Taktik Ujian','taktikujian@gmail.com','$2y$10$CFKcBusYHBXZns.y8fo/de5jkyJpnYxB2/1cEpgIuBekL7uocQ.Z.','customer',NULL,NULL,'2026-07-22 05:11:42');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vouchers`
--

DROP TABLE IF EXISTS `vouchers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vouchers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text,
  `discount_type` enum('percent','nominal') NOT NULL DEFAULT 'nominal',
  `discount_value` decimal(12,2) NOT NULL,
  `min_purchase` decimal(12,2) DEFAULT '0.00',
  `max_discount` decimal(12,2) DEFAULT NULL,
  `applicable_to` enum('all','book','ebook') NOT NULL DEFAULT 'all',
  `quota` int DEFAULT '0',
  `used_count` int DEFAULT '0',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vouchers`
--

LOCK TABLES `vouchers` WRITE;
/*!40000 ALTER TABLE `vouchers` DISABLE KEYS */;
INSERT INTO `vouchers` VALUES (1,'UNSOED2026','Diskon Grand Launching Unsoed Press','Potongan Rp 15.000 untuk pembelian semua produk (buku fisik maupun e-book).','nominal',15000.00,20000.00,NULL,'all',100,0,'2026-01-01 00:00:00','2026-12-31 23:59:59',1,'2026-07-22 01:44:19'),(2,'EBOOKHEMAT','Diskon Spesial Publikasi Digital (E-Book)','Diskon 25% khusus untuk pembelian semua e-book digital tanpa minimum transaksi.','percent',25.00,0.00,50000.00,'ebook',200,0,'2026-01-01 00:00:00','2026-12-31 23:59:59',1,'2026-07-22 01:44:19'),(3,'BUKUCETAK','Potongan Pengiriman & Belanja Buku Fisik','Potongan Rp 20.000 untuk setiap pembelian buku fisik cetak dengan minimum transaksi Rp 75.000.','nominal',20000.00,75000.00,NULL,'book',50,2,'2026-01-01 00:00:00','2026-12-31 23:59:59',1,'2026-07-22 01:44:19');
/*!40000 ALTER TABLE `vouchers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `user_name` varchar(150) DEFAULT NULL,
  `item_type` enum('book','ebook') NOT NULL DEFAULT 'book',
  `item_id` int NOT NULL,
  `rating` int NOT NULL DEFAULT '5',
  `comment` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_item` (`item_type`,`item_id`),
  KEY `idx_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,NULL,'Dr. Hendra Saputra, M.P.','book',7,5,'Buku referensi pertanian tropis terbaik yang pernah saya baca. Sangat komprehensif untuk mahasiswa dan peneliti.','2026-07-22 10:20:00'),(2,NULL,'Siti Nurhaliza','book',7,5,'Bahasa mudah dipahami, kualitas cetakan sangat baik.','2026-07-22 10:20:00'),(3,NULL,'Ahmad Fauzi, S.H.','book',8,5,'Metodologinya dijelaskan sangat terstruktur dan aplikatif untuk tesis hukum modern.','2026-07-22 10:20:00'),(4,NULL,'Rina Wati','book',8,4,'Sangat membantu penelitian hukum saya. Terimakasih Unsoed Press!','2026-07-22 10:20:00'),(5,NULL,'Prof. Budi Santoso','book',9,5,'Bioteknologi dijelaskan dengan contoh nyata di Indonesia. Luar biasa.','2026-07-22 10:20:00'),(6,NULL,'Dani Kurniawan','book',9,5,'Buku wajib untuk mahasiswa biologi sains!','2026-07-22 10:20:00'),(7,NULL,'Farah Diba','book',10,5,'Analisis ekonomi daerahnya sangat mendalam dan kritis.','2026-07-22 10:20:00'),(8,NULL,'Gunawan Wibisono','book',11,5,'Sosiologi pedesaan dijelaskan secara akurat dengan data lapangan UGM & Unsoed.','2026-07-22 10:20:00'),(9,NULL,'dr. Anisa Rahma','book',12,5,'Sangat direkomendasikan untuk tenaga medis di wilayah pedesaan.','2026-07-22 10:20:00'),(10,NULL,'Mahasiswa Kedokteran','book',12,4,'Buku saku yang sangat informatif dan padat ilmunya.','2026-07-22 10:20:00'),(11,NULL,'Bambang Pamungkas','ebook',1,5,'E-Book sangat jernih, bisa dibaca lewat HP maupun laptop kapan saja!','2026-07-22 10:20:00'),(12,NULL,'Intan Permatasari','ebook',1,5,'Download cepat, materinya persis versi cetak. Praktis sekali!','2026-07-22 10:20:00'),(13,NULL,'Drs. Haryanto, M.H.','ebook',2,5,'Fitur ebook sangat membantu riset hukum saya saat di luar kota.','2026-07-22 10:20:00'),(14,NULL,'Maya Amelia','ebook',3,5,'PDF full color, diagram bioteknologinya jelas banget!','2026-07-22 10:20:00'),(15,NULL,'Rizky Pratama','ebook',4,5,'Harga e-book hemat dan berkualitas dari Unsoed Press.','2026-07-22 10:20:00');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-22 15:00:09
