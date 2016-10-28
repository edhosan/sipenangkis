-- MySQL dump 10.16  Distrib 10.1.9-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: sipenangkis
-- ------------------------------------------------------
-- Server version	10.1.9-MariaDB-log

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
-- Table structure for table `m_desa`
--

DROP TABLE IF EXISTS `m_desa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_desa` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `m_kecamatan_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `m_desa_name_unique` (`name`),
  KEY `m_desa_m_kecamatan_id_foreign` (`m_kecamatan_id`),
  CONSTRAINT `m_desa_m_kecamatan_id_foreign` FOREIGN KEY (`m_kecamatan_id`) REFERENCES `m_kecamatan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_desa`
--

LOCK TABLES `m_desa` WRITE;
/*!40000 ALTER TABLE `m_desa` DISABLE KEYS */;
INSERT INTO `m_desa` VALUES (16,19,'Sei. Bedungun',NULL,NULL),(17,19,'Tanjung Redeb',NULL,NULL),(18,19,'Bugis',NULL,NULL),(19,19,'Gunung Panjang',NULL,NULL),(20,19,'Karang Ambun',NULL,NULL),(21,19,'Gayam',NULL,NULL),(22,31,'Teluk Bayur',NULL,NULL),(23,31,'Rinding',NULL,NULL),(24,31,'Labanan Jaya',NULL,NULL),(25,31,'Labanan Makmur',NULL,NULL),(26,31,'Labanan Makarti',NULL,NULL),(27,31,'Tumbit Melayu',NULL,NULL),(39,27,'Tasuk',NULL,NULL),(40,27,'Birang',NULL,NULL),(41,27,'Gunung Tabur',NULL,NULL),(42,27,'Maluang',NULL,NULL),(43,27,'Samburakat',NULL,NULL),(44,27,'Sembakugan',NULL,NULL),(45,27,'Melati Jaya',NULL,NULL),(46,27,'Marancang Ulu',NULL,NULL),(47,27,'Pl. Besing',NULL,NULL),(48,27,'Marancang Ilir',NULL,NULL),(49,27,'Batu - Batu',NULL,NULL),(50,23,'Sambaliung',NULL,NULL),(51,23,'Tumbit Dayak',NULL,NULL),(52,23,'Inaran',NULL,NULL),(53,23,'Pegat Bukur',NULL,NULL),(54,23,'Rantau Panjang',NULL,NULL),(55,23,'Long Lanuk',NULL,NULL),(56,23,'Tg. Perangat',NULL,NULL),(57,23,'Sukan Tengah',NULL,NULL),(58,23,'Suaran',NULL,NULL),(59,23,'Pesayan',NULL,NULL),(60,23,'Pilanjau',NULL,NULL),(61,23,'Bena Baru',NULL,NULL),(62,23,'Gurimbang',NULL,NULL),(63,23,'Bebanir Bangun',NULL,NULL),(64,21,'Tabalar Muara',NULL,NULL),(65,21,'Harapan Maju',NULL,NULL),(66,21,'Tabalar Ulu',NULL,NULL),(67,21,'Tubaan',NULL,NULL),(68,21,'Semurut',NULL,NULL),(69,21,'Radak/Buyung-Buyung',NULL,NULL),(70,28,'Teluk Sumbang',NULL,NULL),(71,28,'Biduk-Biduk',NULL,NULL),(72,28,'Pantai Harapan',NULL,NULL),(73,28,'Tanjung Prepat',NULL,NULL),(74,28,'Giring-giring',NULL,NULL),(75,28,'Teluk Sulaiman',NULL,NULL),(76,29,'Biatan Bapinang',NULL,NULL),(77,29,'Biatan Baru',NULL,NULL),(78,29,'Bukit Makmur Jaya',NULL,NULL),(79,29,'Manunggal Jaya',NULL,NULL),(80,29,'Biatan Lempake',NULL,NULL),(81,29,'Biatan Ulu',NULL,NULL),(82,29,'Karangan',NULL,NULL),(83,29,'Biatan Ilir',NULL,NULL),(84,20,'Campur Sari',NULL,NULL),(85,20,'Bumi Jaya',NULL,NULL),(86,20,'Tunggal Bumi',NULL,NULL),(87,20,'Dumaring',NULL,NULL),(88,20,'Suka Murya',NULL,NULL),(89,20,'Purna Sari Jaya',NULL,NULL),(90,20,'Sumber Mulia',NULL,NULL),(91,20,'Eka Sapta Talisayan',NULL,NULL),(92,20,'Capuak',NULL,NULL),(93,20,'Talisayan',NULL,NULL),(96,30,'Kayu Indah',NULL,NULL),(97,30,'Sumber Agung',NULL,NULL),(98,30,'Tembudan',NULL,NULL),(99,30,'Batu Putih',NULL,NULL),(100,30,'Lobang Kelatak',NULL,NULL),(101,30,'Ampen Medang',NULL,NULL),(102,30,'Bali Kukup',NULL,NULL),(103,25,'Pegat Batumpuk',NULL,NULL),(104,25,'Teluk Sumanting',NULL,NULL),(105,25,'Tanjung Batu',NULL,NULL),(106,25,'Pl. Derawan',NULL,NULL),(107,25,'Kasai',NULL,NULL),(108,24,'Payung-Payung',NULL,NULL),(109,24,'Bohe Silian',NULL,NULL),(110,24,'Tl. Alulu',NULL,NULL),(111,24,'Tl. Harapan',NULL,NULL),(112,26,'Merapun',NULL,NULL),(113,26,'Merabu',NULL,NULL),(114,26,'Mapulu',NULL,NULL),(115,26,'Panaan',NULL,NULL),(116,26,'Merasa',NULL,NULL),(117,26,'Muara Lesan',NULL,NULL),(118,26,'Lesan Dayak',NULL,NULL),(119,26,'Sido Bangen',NULL,NULL),(120,26,'Long Beliu',NULL,NULL),(121,26,'Long Duhung',NULL,NULL),(122,26,'Long Keluh',NULL,NULL),(123,26,'Long Pelay',NULL,NULL),(124,26,'Long Lancim',NULL,NULL),(125,26,'Long Sului',NULL,NULL),(126,22,'Punan Mahkam',NULL,NULL),(127,22,'Long Laai',NULL,NULL),(128,22,'Punan Segah',NULL,NULL),(129,22,'Long Ayan',NULL,NULL),(130,22,'Punan Malinau',NULL,NULL),(131,22,'Gunung Sari',NULL,NULL),(132,22,'Harapan Jaya',NULL,NULL),(133,22,'Bukit Makmur',NULL,NULL),(134,22,'Pandan Sari',NULL,NULL),(135,22,'Batu Rajang',NULL,NULL),(136,22,'Siduung Indah',NULL,NULL),(137,22,'Tepian Buah',NULL,NULL),(138,22,'Long Ayap',NULL,NULL);
/*!40000 ALTER TABLE `m_desa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_indikator`
--

DROP TABLE IF EXISTS `m_indikator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_indikator` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `m_kategori_indikator_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `m_indikator_name_unique` (`name`),
  KEY `m_indikator_m_kategori_indikator_id_foreign` (`m_kategori_indikator_id`),
  CONSTRAINT `m_indikator_m_kategori_indikator_id_foreign` FOREIGN KEY (`m_kategori_indikator_id`) REFERENCES `m_kategori_indikator` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_indikator`
--

LOCK TABLES `m_indikator` WRITE;
/*!40000 ALTER TABLE `m_indikator` DISABLE KEYS */;
INSERT INTO `m_indikator` VALUES (5,5,'Jumlah Anggota Keluarga','2016-10-17 22:45:58','2016-10-18 05:15:11'),(7,6,'Status Kepemilikan','2016-10-17 22:49:03','2016-10-22 07:46:24'),(8,8,'Pendidikan KK','2016-10-17 22:51:48','2016-10-22 08:11:07'),(10,5,'Jumlah Anggota Keluarga Yang Masih Sekolah','2016-10-18 05:19:23','2016-10-18 05:19:23'),(11,5,'Jumlah Anggota Keluarga Bekerja (termasuk KK)','2016-10-22 07:26:07','2016-10-22 07:26:07'),(12,5,'Jumlah KK 1 (satu) Rumah Tangga','2016-10-22 07:44:42','2016-10-22 07:44:42'),(13,6,'Luas Bangunan','2016-10-22 07:56:47','2016-10-22 07:56:47'),(14,6,'Material Atap','2016-10-22 07:57:55','2016-10-22 07:57:55'),(15,6,'Material Lantai','2016-10-22 07:59:07','2016-10-22 07:59:07'),(16,6,'Material Dinding','2016-10-22 08:00:10','2016-10-22 08:00:10'),(17,6,'Sumber Air','2016-10-22 08:01:25','2016-10-22 08:01:25'),(18,6,'Toilet','2016-10-22 08:02:39','2016-10-22 08:02:39'),(19,6,'Penerangan Rumah','2016-10-22 08:04:18','2016-10-22 08:04:18'),(20,6,'Bahan Bakar Dapur yang sering digunakan','2016-10-22 08:05:33','2016-10-22 08:05:33'),(21,6,'Perabot Elektronik','2016-10-22 08:07:16','2016-10-22 08:07:16'),(22,6,'Alat Transportasi','2016-10-22 08:08:27','2016-10-22 08:08:27'),(23,8,'Pekerjaan KK','2016-10-22 08:12:25','2016-10-22 08:12:25'),(24,8,'Total Penghasilan Satu Keluarga per-Bulan','2016-10-22 08:13:37','2016-10-22 08:13:37'),(25,8,'Jumlah anggota Rumah Tangga yang sakit menahan atau cacat fisik','2016-10-22 08:14:56','2016-10-22 08:14:56'),(26,8,'Aset yang dimiliki bisa dijual','2016-10-22 08:16:06','2016-10-22 08:16:06');
/*!40000 ALTER TABLE `m_indikator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_intervensi`
--

DROP TABLE IF EXISTS `m_intervensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_intervensi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `m_program_id` int(10) unsigned NOT NULL,
  `m_sasaran_intervensi_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `m_intervensi_name_unique` (`name`),
  KEY `m_intervensi_m_program_id_foreign` (`m_program_id`),
  KEY `m_intervensi_m_sasaran_intervensi_id_foreign` (`m_sasaran_intervensi_id`),
  CONSTRAINT `m_intervensi_m_program_id_foreign` FOREIGN KEY (`m_program_id`) REFERENCES `m_program` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `m_intervensi_m_sasaran_intervensi_id_foreign` FOREIGN KEY (`m_sasaran_intervensi_id`) REFERENCES `m_sasaran_intervensi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_intervensi`
--

LOCK TABLES `m_intervensi` WRITE;
/*!40000 ALTER TABLE `m_intervensi` DISABLE KEYS */;
INSERT INTO `m_intervensi` VALUES (9,'Bantuan Alat Tangkap Nelayan','2016-10-16 07:24:33','2016-10-24 23:03:51',6,4),(10,'Pelatihan Menjahit dan Bantuan Mesin Jahit','2016-10-23 09:05:44','2016-10-23 09:05:44',7,5);
/*!40000 ALTER TABLE `m_intervensi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_jawaban`
--

DROP TABLE IF EXISTS `m_jawaban`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_jawaban` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `nilai` int(10) unsigned NOT NULL,
  `m_indikator_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `m_jawaban_m_indikator_id_foreign` (`m_indikator_id`),
  CONSTRAINT `m_jawaban_m_indikator_id_foreign` FOREIGN KEY (`m_indikator_id`) REFERENCES `m_indikator` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_jawaban`
--

LOCK TABLES `m_jawaban` WRITE;
/*!40000 ALTER TABLE `m_jawaban` DISABLE KEYS */;
INSERT INTO `m_jawaban` VALUES (1,'Tidak Sekolah/Tidak tamat SD',1,8,'2016-10-17 23:01:03','2016-10-22 08:11:24'),(6,'> 6 (atau 1 orang lansia sebatang kara)',1,5,'2016-10-18 05:17:37','2016-10-22 07:36:46'),(7,'5 Orang',2,5,'2016-10-18 05:17:57','2016-10-22 07:37:03'),(8,'4 Orang',3,5,'2016-10-18 05:18:13','2016-10-22 07:37:14'),(9,'1 - 3 Orang',4,5,'2016-10-18 05:18:31','2016-10-22 07:37:25'),(10,'> 3 Orang',1,10,'2016-10-18 05:19:42','2016-10-22 07:38:04'),(11,'2 - 3 Orang',2,10,'2016-10-18 05:19:56','2016-10-22 07:38:14'),(12,'1 Orang',3,10,'2016-10-18 05:20:11','2016-10-22 07:38:23'),(13,'0 orang',4,10,'2016-10-18 05:20:26','2016-10-22 07:38:35'),(16,'0 Orang',1,11,'2016-10-22 07:40:33','2016-10-22 07:40:33'),(17,'1 Orang',2,11,'2016-10-22 07:40:54','2016-10-22 07:40:54'),(18,'2 - 3 Orang',3,11,'2016-10-22 07:41:04','2016-10-22 07:41:04'),(19,'> 3 Orang',4,11,'2016-10-22 07:41:16','2016-10-22 07:41:16'),(20,'> 3 KK',1,12,'2016-10-22 07:44:53','2016-10-22 07:44:53'),(21,'3 KK',2,12,'2016-10-22 07:45:07','2016-10-22 07:45:07'),(22,'2 KK',3,12,'2016-10-22 07:45:17','2016-10-22 07:45:17'),(23,'1 KK',4,12,'2016-10-22 07:45:32','2016-10-22 07:45:32'),(24,'Milik Orang Tua',1,7,'2016-10-22 07:53:33','2016-10-22 07:53:33'),(25,'Pinjam Gratis',2,7,'2016-10-22 07:53:50','2016-10-22 07:53:50'),(26,'Menyewa',3,7,'2016-10-22 07:54:05','2016-10-22 07:54:05'),(27,'Milik Sendiri',4,7,'2016-10-22 07:54:19','2016-10-22 07:54:19'),(28,'< 36 M2',1,13,'2016-10-22 07:57:01','2016-10-22 07:57:01'),(29,'36 - 50 M2',2,13,'2016-10-22 07:57:12','2016-10-22 07:57:12'),(30,'50 - 75 M2',3,13,'2016-10-22 07:57:24','2016-10-22 07:57:24'),(31,'> 75 M2',4,13,'2016-10-22 07:57:34','2016-10-22 07:57:34'),(32,'Daun',1,14,'2016-10-22 07:58:05','2016-10-22 07:58:05'),(33,'Seng Kondisi Rusak',2,14,'2016-10-22 07:58:19','2016-10-22 07:58:19'),(34,'Seng Kondisi Masih Bagus',3,14,'2016-10-22 07:58:30','2016-10-22 07:58:30'),(35,'Genting',4,14,'2016-10-22 07:58:39','2016-10-22 07:58:39'),(36,'Tanah/Kayu Kondisi Rusak',1,15,'2016-10-22 07:59:18','2016-10-22 07:59:18'),(37,'Kayu Kondisi Baik',2,15,'2016-10-22 07:59:28','2016-10-22 07:59:28'),(38,'Lantai Cor/Tegel/Kayu Ulin',3,15,'2016-10-22 07:59:39','2016-10-22 07:59:39'),(39,'Keramik',4,15,'2016-10-22 07:59:50','2016-10-22 07:59:50'),(40,'Kayu Kondisi Rusak',1,16,'2016-10-22 08:00:19','2016-10-22 08:00:19'),(41,'Kayu Kondisi Baik',2,16,'2016-10-22 08:00:29','2016-10-22 08:00:29'),(42,'Tembok/Beton Tanpa Cor',3,16,'2016-10-22 08:00:41','2016-10-22 08:00:41'),(43,'Tembok/Beton Kualitas Baik ',4,16,'2016-10-22 08:00:54','2016-10-22 08:00:54'),(44,'Sungai',1,17,'2016-10-22 08:01:36','2016-10-22 08:01:36'),(45,'Air Hujan/Sumur',2,17,'2016-10-22 08:01:48','2016-10-22 08:01:48'),(46,'Sumber Air Fasilitas Umum',3,17,'2016-10-22 08:01:58','2016-10-22 08:01:58'),(47,'PDAM/Mudah menjangkau fasilitas air bersih',4,17,'2016-10-22 08:02:14','2016-10-22 08:02:14'),(48,'Milik Fasilitas Umum',1,18,'2016-10-22 08:02:50','2016-10-22 08:02:50'),(49,'Milik Sendiri kondisi seadanya/jelek',2,18,'2016-10-22 08:03:04','2016-10-22 08:03:04'),(50,'Milik Sendiri kondisi Sedang',3,18,'2016-10-22 08:03:16','2016-10-22 08:03:16'),(51,'Milik Sendiri kondisi baik',4,18,'2016-10-22 08:03:31','2016-10-22 08:03:31'),(52,'Lampu Tempel',1,19,'2016-10-22 08:04:29','2016-10-22 08:04:29'),(53,'Listrik Numpang Tetangga/PLTS/PLTMH',2,19,'2016-10-22 08:04:45','2016-10-22 08:04:45'),(54,'PLN 450 Watt',3,19,'2016-10-22 08:04:58','2016-10-22 08:04:58'),(55,'PLN > 900 Watt',4,19,'2016-10-22 08:05:08','2016-10-22 08:05:08'),(56,'Kayu Bakar',1,20,'2016-10-22 08:05:43','2016-10-22 08:05:43'),(57,'Minyak Tanah',2,20,'2016-10-22 08:05:54','2016-10-22 08:05:54'),(58,'Gas 3 Kg',3,20,'2016-10-22 08:06:08','2016-10-22 08:06:08'),(59,'Gas 12 Kg',4,20,'2016-10-22 08:06:26','2016-10-22 08:06:26'),(60,'Tidak punya perabot elektronik',1,21,'2016-10-22 08:07:26','2016-10-22 08:07:26'),(61,'TV',2,21,'2016-10-22 08:07:37','2016-10-22 08:07:37'),(62,'Kulkas',3,21,'2016-10-22 08:07:46','2016-10-22 08:07:46'),(63,'Mesin Cuci',4,21,'2016-10-22 08:07:57','2016-10-22 08:07:57'),(64,'Jalan Kaki / Sepeda',1,22,'2016-10-22 08:08:44','2016-10-22 08:08:44'),(65,'Sepeda Motor/Ketinting tanpa mesin',2,22,'2016-10-22 08:09:04','2016-10-22 08:09:04'),(66,'Sepada Motor > 1 buah/Ketinting bermesin',3,22,'2016-10-22 08:09:20','2016-10-22 08:09:20'),(67,'Mobil/Speedboot bermesin',4,22,'2016-10-22 08:09:34','2016-10-22 08:09:34'),(68,'SD',2,8,'2016-10-22 08:11:34','2016-10-22 08:11:34'),(69,'SMP/Sederajat',3,8,'2016-10-22 08:11:49','2016-10-22 08:11:49'),(70,'SMA/SMK/PT',4,8,'2016-10-22 08:12:03','2016-10-22 08:12:03'),(71,'Buruh',1,23,'2016-10-22 08:12:37','2016-10-22 08:12:37'),(72,'Petani/Nelayan Kecil',2,23,'2016-10-22 08:12:48','2016-10-22 08:12:48'),(73,'Pedagang Kecil',3,23,'2016-10-22 08:13:01','2016-10-22 08:13:01'),(74,'Wirausaha / Pedagang Sedang',4,23,'2016-10-22 08:13:13','2016-10-22 08:13:13'),(75,'< Rp. 1,25 jt',1,24,'2016-10-22 08:13:46','2016-10-22 08:13:46'),(76,'Rp. 1,25 jt s/d Rp. 1,5',2,24,'2016-10-22 08:14:01','2016-10-22 08:14:01'),(77,'Rp. 1,5 jt s/d Rp. 1,750 jt',3,24,'2016-10-22 08:14:13','2016-10-22 08:14:13'),(78,'> Rp. 1.750.250,-',4,24,'2016-10-22 08:14:25','2016-10-22 08:14:25'),(79,'> 3 orang atau 1 (KK)',1,25,'2016-10-22 08:15:15','2016-10-22 08:15:15'),(80,'2 Orang',2,25,'2016-10-22 08:15:27','2016-10-22 08:15:27'),(81,'1 Orang',3,25,'2016-10-22 08:15:37','2016-10-22 08:15:37'),(82,'Tidak Ada',4,25,'2016-10-22 08:15:46','2016-10-22 08:15:46'),(83,'Tidak Punya',1,26,'2016-10-22 08:16:16','2016-10-22 08:16:16'),(84,'< Rp. 1 jt',2,26,'2016-10-22 08:16:27','2016-10-22 08:16:27'),(85,'Rp. 1 s/d 5 jt',3,26,'2016-10-22 08:16:41','2016-10-22 08:16:41'),(86,'> Rp. 5 jt',4,26,'2016-10-22 08:16:59','2016-10-22 08:16:59');
/*!40000 ALTER TABLE `m_jawaban` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_kategori_indikator`
--

DROP TABLE IF EXISTS `m_kategori_indikator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_kategori_indikator` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `m_kategori_indikator_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_kategori_indikator`
--

LOCK TABLES `m_kategori_indikator` WRITE;
/*!40000 ALTER TABLE `m_kategori_indikator` DISABLE KEYS */;
INSERT INTO `m_kategori_indikator` VALUES (5,'Informasi Keluarga','2016-10-17 22:43:44','2016-10-18 05:05:43'),(6,'Kondisi Rumah','2016-10-17 22:48:26','2016-10-18 05:06:05'),(8,'Kondisi Sosial Ekonomi','2016-10-17 22:51:33','2016-10-18 05:06:28');
/*!40000 ALTER TABLE `m_kategori_indikator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_kecamatan`
--

DROP TABLE IF EXISTS `m_kecamatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_kecamatan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `m_kecamatan_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_kecamatan`
--

LOCK TABLES `m_kecamatan` WRITE;
/*!40000 ALTER TABLE `m_kecamatan` DISABLE KEYS */;
INSERT INTO `m_kecamatan` VALUES (19,'Tanjung Redeb',NULL,NULL),(20,'Talisayan',NULL,NULL),(21,'Tabalar',NULL,NULL),(22,'Segah',NULL,NULL),(23,'Sambaliung',NULL,NULL),(24,'Pulau Maratua',NULL,NULL),(25,'Pulau Derawan',NULL,NULL),(26,'Kelay',NULL,NULL),(27,'Gunung Tabur',NULL,NULL),(28,'Biduk-Biduk',NULL,NULL),(29,'Biatan Lempake',NULL,NULL),(30,'Batu Putih',NULL,NULL),(31,'Teluk Bayur','2016-10-26 07:33:54','2016-10-26 07:33:54');
/*!40000 ALTER TABLE `m_kecamatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_kluster`
--

DROP TABLE IF EXISTS `m_kluster`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_kluster` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `min` int(10) unsigned NOT NULL,
  `max` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `m_kluster_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_kluster`
--

LOCK TABLES `m_kluster` WRITE;
/*!40000 ALTER TABLE `m_kluster` DISABLE KEYS */;
INSERT INTO `m_kluster` VALUES (1,'Sangat Miskin',20,30,'2016-10-17 20:53:14','2016-10-22 08:26:26'),(4,'Miskin',31,40,'2016-10-17 21:03:12','2016-10-22 08:27:20'),(5,'Hampir Miskin',41,50,'2016-10-22 08:27:55','2016-10-22 08:27:55'),(6,'Rentan Miskin',51,60,'2016-10-22 08:33:24','2016-10-22 08:33:24');
/*!40000 ALTER TABLE `m_kluster` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_kluster_m_kategori`
--

DROP TABLE IF EXISTS `m_kluster_m_kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_kluster_m_kategori` (
  `m_kluster_id` int(10) unsigned NOT NULL,
  `m_kategori_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`m_kluster_id`,`m_kategori_id`),
  KEY `m_kluster_m_kategori_m_kategori_id_foreign` (`m_kategori_id`),
  CONSTRAINT `m_kluster_m_kategori_m_kategori_id_foreign` FOREIGN KEY (`m_kategori_id`) REFERENCES `m_kategori_indikator` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `m_kluster_m_kategori_m_kluster_id_foreign` FOREIGN KEY (`m_kluster_id`) REFERENCES `m_kluster` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_kluster_m_kategori`
--

LOCK TABLES `m_kluster_m_kategori` WRITE;
/*!40000 ALTER TABLE `m_kluster_m_kategori` DISABLE KEYS */;
INSERT INTO `m_kluster_m_kategori` VALUES (1,5),(1,6),(1,8),(4,5),(4,6),(4,8),(5,5),(5,6),(5,8),(6,5),(6,6),(6,8);
/*!40000 ALTER TABLE `m_kluster_m_kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_pekerjaan`
--

DROP TABLE IF EXISTS `m_pekerjaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_pekerjaan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pekerjaan` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `m_pekerjaan_pekerjaan_unique` (`pekerjaan`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_pekerjaan`
--

LOCK TABLES `m_pekerjaan` WRITE;
/*!40000 ALTER TABLE `m_pekerjaan` DISABLE KEYS */;
INSERT INTO `m_pekerjaan` VALUES (2,'Belum / Tidak Bekerja','2016-10-16 08:06:37','2016-10-16 08:06:37'),(3,'Mengurus Rumah Tangga','2016-10-16 08:06:59','2016-10-16 08:06:59'),(4,'Pelajar / Mahasiswa','2016-10-16 08:07:30','2016-10-16 08:07:30');
/*!40000 ALTER TABLE `m_pekerjaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_pendidikan`
--

DROP TABLE IF EXISTS `m_pendidikan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_pendidikan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `m_pendidikan_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_pendidikan`
--

LOCK TABLES `m_pendidikan` WRITE;
/*!40000 ALTER TABLE `m_pendidikan` DISABLE KEYS */;
INSERT INTO `m_pendidikan` VALUES (2,'Tidak / Belum Sekolah ','2016-10-16 09:30:44','2016-10-16 09:30:44'),(3,'Belum Tamat SD / Sederajat','2016-10-16 09:31:34','2016-10-16 09:31:34'),(4,'Tamat SD / Sederajat','2016-10-16 09:33:55','2016-10-16 09:33:55');
/*!40000 ALTER TABLE `m_pendidikan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_penerima_manfaat`
--

DROP TABLE IF EXISTS `m_penerima_manfaat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_penerima_manfaat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `m_desa_id` int(10) unsigned NOT NULL,
  `rt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `no_rumah` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domisili` int(10) unsigned NOT NULL,
  `nkk` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `userid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rw` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `refid` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nkk` (`nkk`),
  KEY `m_penerima_manfaat_m_desa_id_foreign` (`m_desa_id`),
  CONSTRAINT `m_penerima_manfaat_m_desa_id_foreign` FOREIGN KEY (`m_desa_id`) REFERENCES `m_desa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=452 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_penerima_manfaat`
--

LOCK TABLES `m_penerima_manfaat` WRITE;
/*!40000 ALTER TABLE `m_penerima_manfaat` DISABLE KEYS */;
INSERT INTO `m_penerima_manfaat` VALUES (451,17,'','Jln. Pemuda Gg. Karya Bakti','',30,'6403051508080104','2016-10-26 13:18:47','2016-10-26 13:18:47','edosan','',NULL);
/*!40000 ALTER TABLE `m_penerima_manfaat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_penerima_manfaat_keluarga`
--

DROP TABLE IF EXISTS `m_penerima_manfaat_keluarga`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_penerima_manfaat_keluarga` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `m_penerima_manfaat_id` int(10) unsigned NOT NULL,
  `nik` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sex` enum('L','P') COLLATE utf8_unicode_ci NOT NULL,
  `tgl_lhr` date DEFAULT NULL,
  `tempat_lhr` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `agama` enum('1','2','3','4','5','6') COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('1','2','3','4','5') COLLATE utf8_unicode_ci NOT NULL,
  `hubungan` enum('01','02','03','04','05','06','07','08','09','10','11') COLLATE utf8_unicode_ci NOT NULL,
  `hubungan_ket` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `akta_nikah` enum('1','2') COLLATE utf8_unicode_ci NOT NULL,
  `kartu_identitas` enum('0','1','2','3','4') COLLATE utf8_unicode_ci NOT NULL,
  `disabilitas_jenis` enum('00','01','02','03','04','05') COLLATE utf8_unicode_ci NOT NULL,
  `disabilitas_kategori` enum('1','2','3') COLLATE utf8_unicode_ci NOT NULL,
  `penyakit_kronis` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nama_sekolah` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `m_pekerjaan_id` int(11) unsigned NOT NULL,
  `m_pendidikan_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `m_penerima_manfaat_keluarga_m_penerima_manfaat_id_foreign` (`m_penerima_manfaat_id`),
  KEY `m_pekerjaan_id` (`m_pekerjaan_id`),
  KEY `m_penerima_manfaat_keluarga_m_pendidikan_id_foreign` (`m_pendidikan_id`),
  CONSTRAINT `m_penerima_manfaat_keluarga_m_pendidikan_id_foreign` FOREIGN KEY (`m_pendidikan_id`) REFERENCES `m_pendidikan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `m_penerima_manfaat_keluarga_m_penerima_manfaat_id_foreign` FOREIGN KEY (`m_penerima_manfaat_id`) REFERENCES `m_penerima_manfaat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_penerima_manfaat_keluarga`
--

LOCK TABLES `m_penerima_manfaat_keluarga` WRITE;
/*!40000 ALTER TABLE `m_penerima_manfaat_keluarga` DISABLE KEYS */;
INSERT INTO `m_penerima_manfaat_keluarga` VALUES (1,451,'6403050107720022','Amir','L','2016-10-27','a','1','4','01','','1','1','00','1','','','2016-10-26 13:22:06','2016-10-26 13:22:06',2,4);
/*!40000 ALTER TABLE `m_penerima_manfaat_keluarga` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_program`
--

DROP TABLE IF EXISTS `m_program`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_program` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `m_program_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_program`
--

LOCK TABLES `m_program` WRITE;
/*!40000 ALTER TABLE `m_program` DISABLE KEYS */;
INSERT INTO `m_program` VALUES (6,'KUBE','2016-10-11 01:29:28','2016-10-23 09:00:59'),(7,'Pelatihan Menjahit','2016-10-11 07:20:08','2016-10-23 09:04:55');
/*!40000 ALTER TABLE `m_program` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_program_stakeholder`
--

DROP TABLE IF EXISTS `m_program_stakeholder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_program_stakeholder` (
  `m_stakeholders_id` int(10) unsigned NOT NULL,
  `m_program_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`m_stakeholders_id`,`m_program_id`),
  KEY `m_program_stakeholder_m_program_id_foreign` (`m_program_id`),
  CONSTRAINT `m_program_stakeholder_m_program_id_foreign` FOREIGN KEY (`m_program_id`) REFERENCES `m_program` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `m_program_stakeholder_m_stakeholders_id_foreign` FOREIGN KEY (`m_stakeholders_id`) REFERENCES `m_stakeholders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_program_stakeholder`
--

LOCK TABLES `m_program_stakeholder` WRITE;
/*!40000 ALTER TABLE `m_program_stakeholder` DISABLE KEYS */;
INSERT INTO `m_program_stakeholder` VALUES (2,6),(2,7);
/*!40000 ALTER TABLE `m_program_stakeholder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_sasaran_intervensi`
--

DROP TABLE IF EXISTS `m_sasaran_intervensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_sasaran_intervensi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `m_sasaran_intervensi_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_sasaran_intervensi`
--

LOCK TABLES `m_sasaran_intervensi` WRITE;
/*!40000 ALTER TABLE `m_sasaran_intervensi` DISABLE KEYS */;
INSERT INTO `m_sasaran_intervensi` VALUES (2,'Kawasan','2016-10-16 07:14:48','2016-10-16 07:14:48'),(3,'Kelompok','2016-10-16 07:15:04','2016-10-16 07:15:04'),(4,'Keluarga','2016-10-16 07:15:14','2016-10-16 07:15:14'),(5,'Individu','2016-10-16 07:15:22','2016-10-16 07:15:22');
/*!40000 ALTER TABLE `m_sasaran_intervensi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_stakeholders`
--

DROP TABLE IF EXISTS `m_stakeholders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_stakeholders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `m_stakeholders_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_stakeholders`
--

LOCK TABLES `m_stakeholders` WRITE;
/*!40000 ALTER TABLE `m_stakeholders` DISABLE KEYS */;
INSERT INTO `m_stakeholders` VALUES (2,'Dinas Sosial','2016-10-10 00:36:55','2016-10-23 09:00:04');
/*!40000 ALTER TABLE `m_stakeholders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_sumber_dana`
--

DROP TABLE IF EXISTS `m_sumber_dana`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_sumber_dana` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `m_sumber_dana_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_sumber_dana`
--

LOCK TABLES `m_sumber_dana` WRITE;
/*!40000 ALTER TABLE `m_sumber_dana` DISABLE KEYS */;
INSERT INTO `m_sumber_dana` VALUES (2,'APBD Kabupaten','2016-10-10 19:30:18','2016-10-10 19:30:18'),(3,'APBN','2016-10-11 01:00:50','2016-10-11 01:00:50');
/*!40000 ALTER TABLE `m_sumber_dana` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_sumber_dana_program`
--

DROP TABLE IF EXISTS `m_sumber_dana_program`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_sumber_dana_program` (
  `m_sumber_dana_id` int(10) unsigned NOT NULL,
  `m_program_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`m_sumber_dana_id`,`m_program_id`),
  KEY `m_sumber_dana_program_m_program_id_foreign` (`m_program_id`),
  CONSTRAINT `m_sumber_dana_program_m_program_id_foreign` FOREIGN KEY (`m_program_id`) REFERENCES `m_program` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `m_sumber_dana_program_m_sumber_dana_id_foreign` FOREIGN KEY (`m_sumber_dana_id`) REFERENCES `m_sumber_dana` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_sumber_dana_program`
--

LOCK TABLES `m_sumber_dana_program` WRITE;
/*!40000 ALTER TABLE `m_sumber_dana_program` DISABLE KEYS */;
INSERT INTO `m_sumber_dana_program` VALUES (2,6),(2,7),(3,6),(3,7);
/*!40000 ALTER TABLE `m_sumber_dana_program` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_tujuan_intervensi`
--

DROP TABLE IF EXISTS `m_tujuan_intervensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_tujuan_intervensi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `m_intervensi_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `m_tujuan_intervensi_name_unique` (`name`),
  KEY `m_tujuan_intervensi_m_intervensi_id_foreign` (`m_intervensi_id`),
  CONSTRAINT `m_tujuan_intervensi_m_intervensi_id_foreign` FOREIGN KEY (`m_intervensi_id`) REFERENCES `m_intervensi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_tujuan_intervensi`
--

LOCK TABLES `m_tujuan_intervensi` WRITE;
/*!40000 ALTER TABLE `m_tujuan_intervensi` DISABLE KEYS */;
INSERT INTO `m_tujuan_intervensi` VALUES (1,9,'Peningkatan Ekonomi Masyarakat Miskin','2016-10-23 09:02:17','2016-10-23 09:02:17'),(2,10,'Peningkatan Keterampilan dan Kemampuan Berusaha Warga Miskin','2016-10-23 09:06:19','2016-10-23 09:06:19');
/*!40000 ALTER TABLE `m_tujuan_intervensi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2016_09_28_040022_entrust_setup_tables',1),('2016_10_06_110246_data_master',2),('2016_10_06_153934_data_master_change_sumber_dana',3),('2016_10_10_032625_m_program_update_foreign_kecamatan',4),('2016_10_11_015451_change_m_program',5),('2016_10_11_103147_add_foreign_program',6),('2016_10_11_162154_create_table_penerima_manfaat',7),('2016_10_12_024205_create_table_penerima_manfaat_2',8),('2016_10_12_144521_change_penerima_manfaat_alamat',9),('2016_10_16_141901_create_m_sasaran_intervensi',10),('2016_10_16_163225_create_table_master_pendidikan',11),('2016_10_18_011640_create_table_cluster',12),('2016_10_18_070010_add_timestamps',13),('2016_10_18_145302_change_table_tindikator',14),('2016_10_22_152946_change_table_m_jawaban',15),('2016_10_22_153310_change_table_m_jawaban_name',16),('2016_10_22_163628_change_table_t_pm_penilaian',17),('2016_10_23_165450_t_intervensi',18),('2016_10_24_003736_change_table_user',19),('2016_10_28_082309_create_m_desa_table',0),('2016_10_28_082309_create_m_indikator_table',0),('2016_10_28_082309_create_m_intervensi_table',0),('2016_10_28_082309_create_m_jawaban_table',0),('2016_10_28_082309_create_m_kategori_indikator_table',0),('2016_10_28_082309_create_m_kecamatan_table',0),('2016_10_28_082309_create_m_kluster_table',0),('2016_10_28_082309_create_m_kluster_m_kategori_table',0),('2016_10_28_082309_create_m_pekerjaan_table',0),('2016_10_28_082309_create_m_pendidikan_table',0),('2016_10_28_082309_create_m_penerima_manfaat_table',0),('2016_10_28_082309_create_m_penerima_manfaat_keluarga_table',0),('2016_10_28_082309_create_m_program_table',0),('2016_10_28_082309_create_m_program_stakeholder_table',0),('2016_10_28_082309_create_m_sasaran_intervensi_table',0),('2016_10_28_082309_create_m_stakeholders_table',0),('2016_10_28_082309_create_m_sumber_dana_table',0),('2016_10_28_082309_create_m_sumber_dana_program_table',0),('2016_10_28_082309_create_m_tujuan_intervensi_table',0),('2016_10_28_082309_create_password_resets_table',0),('2016_10_28_082309_create_permissions_table',0),('2016_10_28_082309_create_permissions_role_table',0),('2016_10_28_082309_create_role_user_table',0),('2016_10_28_082309_create_roles_table',0),('2016_10_28_082309_create_t_intervensi_table',0),('2016_10_28_082309_create_t_pm_indikator_table',0),('2016_10_28_082309_create_t_pm_penilaian_table',0),('2016_10_28_082309_create_t_rincian_intervensi_table',0),('2016_10_28_082309_create_users_table',0),('2016_10_28_082312_add_foreign_keys_to_m_desa_table',0),('2016_10_28_082312_add_foreign_keys_to_m_indikator_table',0),('2016_10_28_082312_add_foreign_keys_to_m_intervensi_table',0),('2016_10_28_082312_add_foreign_keys_to_m_jawaban_table',0),('2016_10_28_082312_add_foreign_keys_to_m_kluster_m_kategori_table',0),('2016_10_28_082312_add_foreign_keys_to_m_penerima_manfaat_table',0),('2016_10_28_082312_add_foreign_keys_to_m_penerima_manfaat_keluarga_table',0),('2016_10_28_082312_add_foreign_keys_to_m_program_stakeholder_table',0),('2016_10_28_082312_add_foreign_keys_to_m_sumber_dana_program_table',0),('2016_10_28_082312_add_foreign_keys_to_m_tujuan_intervensi_table',0),('2016_10_28_082312_add_foreign_keys_to_permissions_role_table',0),('2016_10_28_082312_add_foreign_keys_to_role_user_table',0),('2016_10_28_082312_add_foreign_keys_to_t_intervensi_table',0),('2016_10_28_082312_add_foreign_keys_to_t_pm_indikator_table',0),('2016_10_28_082312_add_foreign_keys_to_t_pm_penilaian_table',0),('2016_10_28_082312_add_foreign_keys_to_t_rincian_intervensi_table',0);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (25,'dashboard','Dashboard','User can view dashboard','2016-10-03 22:37:40','2016-10-03 22:37:40'),(26,'hak akses','Hak Akses','user can view, create, delete, & update hak akses','2016-10-03 22:39:33','2016-10-03 22:39:33'),(27,'role','Tipe Pengguna','User can create, view, delete & update tipe pengguna','2016-10-03 22:40:56','2016-10-03 22:40:56'),(28,'User','Pengguna','Create, view, update & delete user ','2016-10-04 06:06:16','2016-10-04 23:40:48');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions_role`
--

DROP TABLE IF EXISTS `permissions_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permissions_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permissions_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permissions_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions_role`
--

LOCK TABLES `permissions_role` WRITE;
/*!40000 ALTER TABLE `permissions_role` DISABLE KEYS */;
INSERT INTO `permissions_role` VALUES (25,28),(25,29),(26,28),(26,29),(27,28),(27,29),(28,28),(28,29);
/*!40000 ALTER TABLE `permissions_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (5,28),(5,29);
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (28,'admin','Admin','','2016-10-04 19:10:55','2016-10-04 23:41:15'),(29,'user','Manajemen User','','2016-10-04 19:45:45','2016-10-04 23:42:30');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_intervensi`
--

DROP TABLE IF EXISTS `t_intervensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_intervensi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `m_intervensi_id` int(10) unsigned NOT NULL,
  `tahun` int(10) unsigned NOT NULL,
  `penerima_id` int(10) unsigned NOT NULL,
  `penerima_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rujukan` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `t_intervensi_m_intervensi_id_foreign` (`m_intervensi_id`),
  CONSTRAINT `t_intervensi_m_intervensi_id_foreign` FOREIGN KEY (`m_intervensi_id`) REFERENCES `m_intervensi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_intervensi`
--

LOCK TABLES `t_intervensi` WRITE;
/*!40000 ALTER TABLE `t_intervensi` DISABLE KEYS */;
INSERT INTO `t_intervensi` VALUES (1,9,2014,99,'App\\Models\\PenerimaManfaat','Balalalal','edosan','2016-10-25 05:25:05','2016-10-25 05:25:05'),(2,9,2015,99,'App\\Models\\PenerimaManfaat','asdasd','edosan','2016-10-25 07:13:23','2016-10-25 07:13:23'),(3,9,2016,102,'App\\Models\\PenerimaManfaat','asdasd','edosan','2016-10-25 07:37:48','2016-10-25 07:37:48'),(4,9,2014,102,'App\\Models\\PenerimaManfaat','dasdasd','edosan','2016-10-25 07:39:10','2016-10-25 07:39:10'),(5,9,2014,102,'App\\Models\\PenerimaManfaat','adasd','edosan','2016-10-25 07:42:19','2016-10-25 07:42:19'),(6,9,2013,102,'App\\Models\\PenerimaManfaat','asd','edosan','2016-10-25 07:43:41','2016-10-25 07:43:41'),(7,9,2012,102,'App\\Models\\PenerimaManfaat','asdad','edosan','2016-10-25 07:45:15','2016-10-25 07:45:15'),(8,9,1020,102,'App\\Models\\PenerimaManfaat','asdad','edosan','2016-10-25 07:51:16','2016-10-25 07:51:16'),(9,9,658,102,'App\\Models\\PenerimaManfaat','jfgjh','edosan','2016-10-25 07:56:00','2016-10-25 07:56:00'),(10,9,2016,102,'App\\Models\\PenerimaManfaat','asdasd','edosan','2016-10-25 08:01:46','2016-10-25 08:01:46'),(11,9,2016,102,'App\\Models\\PenerimaManfaat','asdsad','edosan','2016-10-25 08:20:06','2016-10-25 08:20:06'),(12,9,10,102,'App\\Models\\PenerimaManfaat','asdd','edosan','2016-10-25 08:27:18','2016-10-25 08:27:18'),(13,9,100,102,'App\\Models\\PenerimaManfaat','asasd','edosan','2016-10-25 08:30:57','2016-10-25 08:30:57'),(14,9,1213,102,'App\\Models\\PenerimaManfaat','asd','edosan','2016-10-25 08:34:11','2016-10-25 08:34:11'),(15,9,2015,99,'App\\Models\\PenerimaManfaat','dasd','edosan','2016-10-25 08:54:23','2016-10-25 08:54:23'),(16,9,2015,99,'App\\Models\\PenerimaManfaat','dasd','edosan','2016-10-25 08:56:09','2016-10-25 08:56:09'),(17,9,2015,99,'App\\Models\\PenerimaManfaat','dasd','edosan','2016-10-25 08:58:13','2016-10-25 08:58:13'),(18,9,2015,99,'App\\Models\\PenerimaManfaat','dasd','edosan','2016-10-25 09:00:50','2016-10-25 09:00:50'),(19,9,2015,99,'App\\Models\\PenerimaManfaat','dasd','edosan','2016-10-25 09:02:59','2016-10-25 09:02:59'),(20,9,2015,99,'App\\Models\\PenerimaManfaat','asd','edosan','2016-10-25 09:04:50','2016-10-25 09:04:50'),(21,9,2016,99,'App\\Models\\PenerimaManfaat','sdfad','edosan','2016-10-25 09:06:51','2016-10-25 09:06:51'),(22,9,2016,451,'App\\Models\\PenerimaManfaat','Ketua RT','edosan','2016-10-26 13:35:33','2016-10-26 13:35:33');
/*!40000 ALTER TABLE `t_intervensi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_pm_indikator`
--

DROP TABLE IF EXISTS `t_pm_indikator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_pm_indikator` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `t_pmp_id` int(10) unsigned NOT NULL,
  `value` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `m_indikator_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `t_pm_indikator_t_pmp_id_foreign` (`t_pmp_id`),
  KEY `t_pm_indikator_m_indikator_id_foreign` (`m_indikator_id`),
  CONSTRAINT `t_pm_indikator_m_indikator_id_foreign` FOREIGN KEY (`m_indikator_id`) REFERENCES `m_indikator` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_pm_indikator_t_pmp_id_foreign` FOREIGN KEY (`t_pmp_id`) REFERENCES `t_pm_penilaian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_pm_indikator`
--

LOCK TABLES `t_pm_indikator` WRITE;
/*!40000 ALTER TABLE `t_pm_indikator` DISABLE KEYS */;
INSERT INTO `t_pm_indikator` VALUES (1,1,4,'2016-10-26 13:26:04','2016-10-26 13:26:04',5),(2,1,1,'2016-10-26 13:26:04','2016-10-26 13:26:04',7),(3,1,2,'2016-10-26 13:26:04','2016-10-26 13:26:04',8),(4,1,4,'2016-10-26 13:26:04','2016-10-26 13:26:04',10),(5,1,1,'2016-10-26 13:26:04','2016-10-26 13:26:04',11),(6,1,4,'2016-10-26 13:26:04','2016-10-26 13:26:04',12),(7,1,1,'2016-10-26 13:26:04','2016-10-26 13:26:04',13),(8,1,2,'2016-10-26 13:26:04','2016-10-26 13:26:04',14),(9,1,3,'2016-10-26 13:26:04','2016-10-26 13:26:04',15),(10,1,4,'2016-10-26 13:26:04','2016-10-26 13:26:04',16),(11,1,1,'2016-10-26 13:26:04','2016-10-26 13:26:04',17),(12,1,2,'2016-10-26 13:26:04','2016-10-26 13:26:04',18),(13,1,2,'2016-10-26 13:26:04','2016-10-26 13:26:04',19),(14,1,2,'2016-10-26 13:26:04','2016-10-26 13:26:04',20),(15,1,4,'2016-10-26 13:26:04','2016-10-26 13:26:04',21),(16,1,1,'2016-10-26 13:26:04','2016-10-26 13:26:04',22),(17,1,2,'2016-10-26 13:26:04','2016-10-26 13:26:04',23),(18,1,1,'2016-10-26 13:26:04','2016-10-26 13:26:04',24),(19,1,1,'2016-10-26 13:26:04','2016-10-26 13:26:04',25),(20,1,3,'2016-10-26 13:26:04','2016-10-26 13:26:04',26);
/*!40000 ALTER TABLE `t_pm_indikator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_pm_penilaian`
--

DROP TABLE IF EXISTS `t_pm_penilaian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_pm_penilaian` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `m_pm_id` int(10) unsigned NOT NULL,
  `nilai` int(11) DEFAULT NULL,
  `kriteria` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `m_kluster_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `t_pm_penilaian_m_pm_id_foreign` (`m_pm_id`),
  KEY `t_pm_penilaian_m_kluster_id_foreign` (`m_kluster_id`),
  CONSTRAINT `t_pm_penilaian_m_kluster_id_foreign` FOREIGN KEY (`m_kluster_id`) REFERENCES `m_kluster` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `t_pm_penilaian_m_pm_id_foreign` FOREIGN KEY (`m_pm_id`) REFERENCES `m_penerima_manfaat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_pm_penilaian`
--

LOCK TABLES `t_pm_penilaian` WRITE;
/*!40000 ALTER TABLE `t_pm_penilaian` DISABLE KEYS */;
INSERT INTO `t_pm_penilaian` VALUES (1,451,45,'Hampir Miskin','2016-10-26 13:18:47','2016-10-26 13:26:04',5);
/*!40000 ALTER TABLE `t_pm_penilaian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_rincian_intervensi`
--

DROP TABLE IF EXISTS `t_rincian_intervensi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_rincian_intervensi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `t_intervensi_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `volume` int(11) NOT NULL,
  `satuan` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nilai` int(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `t_rincian_intervensi_t_intervensi_id_foreign` (`t_intervensi_id`),
  CONSTRAINT `t_rincian_intervensi_t_intervensi_id_foreign` FOREIGN KEY (`t_intervensi_id`) REFERENCES `t_intervensi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_rincian_intervensi`
--

LOCK TABLES `t_rincian_intervensi` WRITE;
/*!40000 ALTER TABLE `t_rincian_intervensi` DISABLE KEYS */;
INSERT INTO `t_rincian_intervensi` VALUES (1,9,'h',4,'gfhj',5,0,'2016-10-25 07:57:14','2016-10-25 07:57:14'),(2,10,'asd',2,'as',2,0,'2016-10-25 08:01:57','2016-10-25 08:01:57'),(3,11,'asd',2,'asd',10,0,'2016-10-25 08:20:45','2016-10-25 08:20:45'),(4,12,'asd edit',10,'10',20,200,'2016-10-25 08:27:30','2016-10-25 08:27:48'),(5,22,'Alat Jaring',1,'jaring',200000,200000,'2016-10-26 13:38:13','2016-10-26 13:38:13');
/*!40000 ALTER TABLE `t_rincian_intervensi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `m_stakeholder_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Ryan Chenkie','ryanchenkie@gmail.com','$2y$10$voYy4/vnhQq8g0iY.O/Jh.A.DMBP/ynRGLhRPynBavhTTFk.QJOa2',NULL,'2016-10-01 00:30:07','2016-10-01 00:30:07',0),(3,'Holly Lloyd','holly@scotch.io','$2y$10$7m42UCdt2RU/vxf711oHF.yudw3s4Gr2KYTDKJrP7hDdomM2W8ePy',NULL,'2016-10-01 00:30:07','2016-10-01 00:30:07',0),(5,'Edo','edosan','$2y$10$bwN.mlsa9n2zDDtjYhDgfu2bC0AH//n/cgojWQxT3/YcCLnVGB/sW',NULL,'2016-10-05 08:09:53','2016-10-24 01:19:41',2);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-28 16:39:07
