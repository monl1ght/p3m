-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: jurnalistik_polibang
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.27-MariaDB

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
-- Table structure for table `agenda_models`
--

DROP TABLE IF EXISTS `agenda_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `agenda_models` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `keterangan` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agenda_models`
--

LOCK TABLES `agenda_models` WRITE;
/*!40000 ALTER TABLE `agenda_models` DISABLE KEYS */;
INSERT INTO `agenda_models` VALUES (1,'Pengabdian di Desa Mayong Nalumsari','2024-11-21','13:30:00','Mayong, Jepara','<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><body><p>Menanam Pohon mangruf,&nbsp;</p><p>dibuka untuk umum dan mahasiswa wajib mengikuti. diwajibkan untuk semester 3</p><p><img src=\"/storage/photo-agenda/21-11-2024-08-26-18-673eeeaa62afd.jpeg\" style=\"width: 275px;\" data-filename=\"images.jpeg\"><br></p></body></html>\n','2024-11-20 23:33:28','2024-11-21 01:26:18');
/*!40000 ALTER TABLE `agenda_models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m__pengelolas`
--

DROP TABLE IF EXISTS `m__pengelolas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `m__pengelolas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `nama_pengelola` varchar(255) NOT NULL,
  `NIDN` varchar(255) NOT NULL,
  `jabatan_pengelola` varchar(255) NOT NULL,
  `email_pengelola` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `m__pengelolas_email_pengelola_unique` (`email_pengelola`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m__pengelolas`
--

LOCK TABLES `m__pengelolas` WRITE;
/*!40000 ALTER TABLE `m__pengelolas` DISABLE KEYS */;
INSERT INTO `m__pengelolas` VALUES (15,'29-10-2024Casual Girl 3D Character (HD).png','Sofia Ulfah M.Kom','20242910','Ketua Pusat Penelitian dan Pengabdian Masyarakat','sofiaulfah@gmail.com','2024-10-28 22:16:19','2024-10-28 22:34:34'),(21,'29-10-2024Casual Girl 3D Character (AI style).png','A. Faiq Abror, M.Pd','20242911','Sekretaris Pusat Penelitian dan Pengabdian Masyarakat','sofiaulfah12@gmail.com','2024-10-28 22:30:48','2024-10-28 22:30:48');
/*!40000 ALTER TABLE `m__pengelolas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_categories`
--

DROP TABLE IF EXISTS `m_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `m_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `m_categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_categories`
--

LOCK TABLES `m_categories` WRITE;
/*!40000 ALTER TABLE `m_categories` DISABLE KEYS */;
INSERT INTO `m_categories` VALUES (1,'Penelitian Internal','penelitian internal','2024-09-11 21:55:55','2024-10-06 22:59:54'),(2,'Penelitian Eksternal','penelitian eksternal','2024-09-12 00:55:19','2024-10-06 23:00:25');
/*!40000 ALTER TABLE `m_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_dashboards`
--

DROP TABLE IF EXISTS `m_dashboards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `m_dashboards` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `instansi` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_dashboards`
--

LOCK TABLES `m_dashboards` WRITE;
/*!40000 ALTER TABLE `m_dashboards` DISABLE KEYS */;
INSERT INTO `m_dashboards` VALUES (1,'2024-10-30Desain_tanpa_judul__5_-removebg-preview.png','Pusat Penelitian dan Pengabdian kepada masyarakat','Politeknik Balekambang Jepara','2024-10-14 20:29:18','2024-10-29 19:19:46');
/*!40000 ALTER TABLE `m_dashboards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_ktps`
--

DROP TABLE IF EXISTS `m_ktps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `m_ktps` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `nik` varchar(25) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `m_ktps_user_id_foreign` (`user_id`),
  CONSTRAINT `m_ktps_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_ktps`
--

LOCK TABLES `m_ktps` WRITE;
/*!40000 ALTER TABLE `m_ktps` DISABLE KEYS */;
INSERT INTO `m_ktps` VALUES (1,504,'3232323232323','2024-09-11 02:45:24','2024-09-11 02:45:29'),(2,505,'23232323232','2024-09-11 02:44:59','2024-09-11 02:45:17');
/*!40000 ALTER TABLE `m_ktps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_news`
--

DROP TABLE IF EXISTS `m_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `m_news` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `m_news_category_id_foreign` (`category_id`),
  KEY `m_news_user_id_foreign` (`user_id`),
  CONSTRAINT `m_news_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `m_categories` (`id`),
  CONSTRAINT `m_news_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_news`
--

LOCK TABLES `m_news` WRITE;
/*!40000 ALTER TABLE `m_news` DISABLE KEYS */;
INSERT INTO `m_news` VALUES (4,'2024-10-22','18-09-2024download (14).jpeg','moon','<p>moon 1</p>',2,'2024-09-17 20:11:58','2024-10-21 18:57:31',504),(5,'2024-10-22','18-09-2024download (15).jpeg','Alien','<p>Alien yang menyeramkan</p>',2,'2024-09-17 20:22:12','2024-10-21 18:58:05',504),(6,'2024-10-22','08-10-2024♡ ﹕jake.jpeg','pm','<p><strong>Attempt to read property \"id\" on null</strong></p>',1,'2024-10-07 19:48:50','2024-10-21 18:58:16',504),(7,'2024-10-08','08-10-2024download (2).jpeg','PM1','<p>Pengabdian masyarakat dapat dilakukan oleh individu, kelompok, atau lembaga. Beberapa bentuk pengabdian masyarakat, di antaranya: Program Kreativitas Mahasiswa bidang Pengabdian kepada Masyarakat (PKM-PM), Kuliah Kerja Nyata (KKN), Pengabdian kepada masyarakat oleh mahasiswa (PMM), Pengabdian mandiri.</p>',1,'2024-10-07 20:11:44','2024-10-07 20:11:44',504),(9,'2024-10-23','23-10-202420240327182318_IMG_8199.JPG','Buka Bersama','<p>Buka bersama merupakan <strong>waktu yang penuh dengan kehangatan dan kebersamaan</strong>. Melalui momen ini, orang-orang dapat saling berbagi cerita, tawa, dan doa. Ini bukan hanya tentang berbagi hidangan lezat, tetapi juga tentang berbagi kasih sayang dan perhatian.</p>',1,'2024-10-22 18:59:47','2024-10-22 18:59:47',504),(10,'2024-10-23','23-10-2024PELATIHAN OFFICE (1).jpeg','Office Boosts','<p><strong>Pelatihan</strong> dasar Microsoft <strong>Office Pelatihan</strong> dasar Microsoft <strong>Office</strong> merupakan <strong>pelatihan</strong> yang bertujuan untuk mengenalkan dan membekali peserta dengan pengetahuan dan keterampilan dasar dalam menggunakan aplikasi Microsoft <strong>Office</strong>, termasuk Word, Excel, PowerPoint, dan Outlook</p>',2,'2024-10-22 19:01:00','2024-10-22 19:01:00',504),(11,'2024-10-23','23-10-2024Cewe.jpg','Grafis','<p><strong>Pelatihan desain grafis</strong> ini akan membekali peserta dengan pengetahuan dan teknik yang dibutuhkan untuk mengaplikasikan prinsip dasar <strong>desain</strong>, menerapkan prinsip dasar komunikasi, merapikan <strong>desain</strong> brief, mengoperasikan perangkat lunak <strong>desain</strong>, dan mencipatakan karya <strong>desain</strong>.</p>',1,'2024-10-22 19:02:20','2024-10-22 19:02:20',504),(12,'2024-10-19','23-10-2024cowo.jpg','Backend','<p>backend adalah <strong>segala sesuatu yang membuat aplikasi Anda berfungsi</strong>. Anda dapat mengibaratkan frontend sebagai eksterior mobil dan backend sebagai semua mesin di dalamnya. Mobil yang dirancang apik hanya akan berjalan optimal jika mesin internal bekerja dengan baik.<br>&nbsp;</p>',2,'2024-10-22 19:03:15','2024-11-05 21:08:24',504),(13,'2024-10-23','23-10-2024Dokument-rakergab.jpeg','Kepenulisan','<p>“Pelatihan kepenulisan ini <strong>ditujukan sebagai sarana untuk mahasiswa dalam hal kepenulisan</strong>, diharapkan program kerja ini terdapat luaran-luaran khususnya bidang penulisan berupa artikel ilmiah, artikel, dan lainnya,” ucap Linda, Ketua HMP PAI.</p><ul><li>Percaya Diri. Bisa atau tidak bukan masalah. Nomor satunya percaya diri.</li><li>Postur dan Bahasa Tubuh. Postur tubuh seseorang memperkuat image-nya.</li><li>Kenali Audience. Sebelum mempresentasikan sesuatu, Anda harus mengenali terlebih dulu, siapa audience yang akan dihadapi.</li><li>Eye Contact.</li></ul>',2,'2024-10-22 19:04:46','2024-11-05 21:06:24',504),(14,'2024-10-23','23-10-2024Peserta Pelatihan.jpeg','Bagaimana dengan Public Speaking mu','<p>Kegiatan ini dilaksanakan dengan tujuan untuk meningkatkan pengetahuan dan wawasan tentang <strong>Public Speaking</strong> kepada mahasiswa dan masyarakat umum, melatih diri dalam mengungkapkan ide kepada khalayak umum, melatih diri dalam penyampaian presentasi dan berdiskusi, dan juga memfasilitasi mahasiswa dan masyarakat umum.</p><p>Sayangnya, menurut survei mengenai ketakutan terbesar manusia yang dilakukan oleh The People’s Almanac Book of List, 630 dari 3000 orang di Amerika, merasa public speaking adalah hal yang paling menakutkan, melebihi ketakutan terhadap kematian, ketinggian, bahkan kebangkrutan.&nbsp; Biasanya, ketakutan yang dirasakan adalah takut lupa, takut ditanya, bahkan takut dipermalukan. Padahal, dengan banyaknya aktivitas yang memerlukan kemampuan public speaking yang baik, maka rasa takut tersebut mau tidak mau harus bisa diatasi.</p>',1,'2024-10-22 19:05:49','2024-11-05 21:05:42',504),(19,'2024-11-07','07-11-2024-02-47-29-672c2a41e0d6c.jpeg','bagaimana dengan ini','<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><body><p>Pusat Penelitian dan Pengabdian Kepada Masyarakat Politeknik Negeri Sambas (P3M Poltesa)\r\nberfungsi sebagai pelopor dalam memfasilitasi dan memediasi dosen serta mahasiswa untuk\r\nberpartisipasi secara aktif dalam penelitian dan pengabdian yang sesuai dengan disiplin ilmu mereka,\r\ndemi kebaikan masyarakat dan negara. Ini merupakan bagian dari upaya Poltesa untuk menciptakan\r\natmosfir penelitian dan memberikan kesempatan kepada akademik dosen serta mahasiswa untuk\r\nberkontribusi kepada masyarakat dengan mengoptimalkan peluang yang ada. sejalan dengan visi dari\r\nPusat Penelitian dan Pengabdian Kepada Masyarakat Poltesa, yaitu \"Membuat P3M menjadi pusat\r\nkeunggulan bagi dosen dalam menghadapi tantangan masa depan, sehingga menjadi institusi\r\nPendidikan Tinggi Vokasi yang Unggul pada tahun 2034\", maka peningkatan layanan dalam\r\npengelolaan penelitian dan pengabdian masyarakat di lingkungan Poltesa menjadi suatu kewajiban.</p><p><img src=\"/storage/photo-news/07-11-2024-02-47-29-672c2a41e0d6c.jpeg\" data-filename=\"Being so serious when it comes to art, Dummy_.jpeg\" style=\"width: 50%;\">&nbsp;</p><p>Bukan kah itu lebih baik?</p></body></html>\n',1,'2024-11-06 19:47:29','2024-11-06 19:47:29',504),(21,'2024-11-12','12-11-2024_3.jpeg','coba 1','<p>P2M adalah upaya pemberantasan dan pencegahan penyakit menular dengan cara menghilangkan dan merubah cara pandang masyarakat mengenai penyakit menular dan penanganannya maupun melakukan upaya pemberantasan dan pennyakit menular baik secara langsung maupun tidak langsung.</p>',1,'2024-11-11 22:12:41','2024-11-11 22:13:02',504),(22,'2024-11-12','12-11-2024-05-17-56-6732e504c733a.jpeg','ahahahah','<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><body><p>P3M, atau <strong>Pusat Penelitian dan Pengabdian kepada Masyarakat</strong>, adalah lembaga atau unit yang biasanya ada di perguruan tinggi atau institusi pendidikan. Tugas utama P3M adalah mengoordinasikan dan mendorong kegiatan penelitian serta pengabdian kepada masyarakat oleh dosen dan mahasiswa.</p><p><img src=\"/storage/photo-news/12-11-2024-05-17-56-6732e504c733a.jpeg\" style=\"width: 25%;\" data-filename=\"_3.jpeg\">&nbsp;</p></body></html>\n',2,'2024-11-11 22:17:56','2024-11-11 22:17:56',504);
/*!40000 ALTER TABLE `m_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_panduans`
--

DROP TABLE IF EXISTS `m_panduans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `m_panduans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `original_name` varchar(255) NOT NULL,
  `generated_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_panduans`
--

LOCK TABLES `m_panduans` WRITE;
/*!40000 ALTER TABLE `m_panduans` DISABLE KEYS */;
INSERT INTO `m_panduans` VALUES (4,'20241022082032.pdf','20241022082032.pdf','2024-10-22 01:20:32','2024-10-22 01:20:32'),(5,'20241022082130.pdf','20241022082130.pdf','2024-10-22 01:21:30','2024-10-22 01:21:30'),(6,'20241031081635.pdf','20241031081635.pdf','2024-10-31 01:16:35','2024-10-31 01:16:35');
/*!40000 ALTER TABLE `m_panduans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_rumahs`
--

DROP TABLE IF EXISTS `m_rumahs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `m_rumahs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `type_rumah` varchar(25) DEFAULT NULL,
  `harga_rumah` double(8,2) DEFAULT NULL,
  `lokasi_rumah` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `m_rumahs_user_id_foreign` (`user_id`),
  CONSTRAINT `m_rumahs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_rumahs`
--

LOCK TABLES `m_rumahs` WRITE;
/*!40000 ALTER TABLE `m_rumahs` DISABLE KEYS */;
INSERT INTO `m_rumahs` VALUES (1,504,'panggung',100000.00,'mewah',NULL,NULL),(2,505,'candi',200000.00,'sasa',NULL,NULL);
/*!40000 ALTER TABLE `m_rumahs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_tentangs`
--

DROP TABLE IF EXISTS `m_tentangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `m_tentangs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `visi` longtext NOT NULL,
  `misi` longtext NOT NULL,
  `ourbout` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_tentangs`
--

LOCK TABLES `m_tentangs` WRITE;
/*!40000 ALTER TABLE `m_tentangs` DISABLE KEYS */;
INSERT INTO `m_tentangs` VALUES (1,'<p class=\"MsoNormal\" style=\"text-align: justify; margin-top: 0cm; margin-bottom: 0cm; margin-right: 0cm; line-height: normal;\">Menjadi pusat unggulan dalam penelitian, pengabdian kepada masyarakat, dan pengembangan yang berkontribusi signifikan terhadap peningkatan kualitas hidup masyarakat dan kemajuan ilmu pengetahuan.</p><p class=\"MsoNormal\" style=\"text-align: justify; margin-top: 0cm; margin-bottom: 0cm; margin-right: 0cm; line-height: normal;\">larirarira lariri darindurim</p>','<ul><li>mengembangkan penelitian yang inovatif dan berkualitas tinggi</li><li>menyelenggarakan pengabdian kepada masyarakat</li><li>membangun kolaborasi yang kuat&nbsp;</li><li>meningkatkan kapasitas dan kompetensi sumber daya manusia</li><li>mengimplementasi hasil penelititan dan pengembangan</li></ul>','<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><body><p class=\"MsoNormal\" style=\"text-align: justify; margin-top: 0cm; margin-bottom: 0cm; margin-right: 0cm; line-height: normal;\"><span style=\'font-size: 12pt; font-family: \"system-ui\";\'>Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) adalah lembaga di kampus yang berfokus pada pengembangan penelitian dan pelaksanaan kegiatan pengabdian kepada masyarakat sebagai bentuk nyata kontribusi kampus terhadap kemajuan ilmu pengetahuan, teknologi, dan kesejahteraan masyarakat. P3M bertujuan untuk menjadi jembatan antara dunia akademik dan kebutuhan masyarakat dengan mengaplikasikan hasil penelitian dalam bentuk program-program pemberdayaan yang relevan dan bermanfaat.</span></p><p></p><p></p><p></p><p class=\"MsoNormal\" style=\"text-align: justify; margin-top: 0cm; margin-bottom: 0cm; margin-right: 0cm; line-height: normal;\"><span style=\'font-size: 12pt; font-family: \"system-ui\";\'>Melalui kolaborasi dengan dosen, mahasiswa, dan mitra eksternal, P3M berupaya menciptakan inovasi-inovasi berkelanjutan yang mendukung pengembangan masyarakat di berbagai bidang, seperti pendidikan, kesehatan, lingkungan, teknologi, dan ekonomi. Dengan pendekatan yang inklusif dan partisipatif, P3M berkomitmen untuk menciptakan solusi yang berdampak nyata, relevan dengan kebutuhan lokal, serta mendukung pembangunan nasional.</span></p><p class=\"MsoNormal\" style=\"text-align: justify; margin-top: 0cm; margin-bottom: 0cm; margin-right: 0cm; line-height: normal;\"><img src=\"/storage/photo-tentang/21-11-2024-08-10-01-673eead9f0b9e.jpeg\" style=\"width: 736px;\" data-filename=\"MINGYU.jpeg\"><span style=\'font-size: 12pt; font-family: \"system-ui\";\'><br></span></p><p class=\"MsoNormal\" style=\"text-align: justify; margin-top: 0cm; margin-bottom: 0cm; margin-right: 0cm; line-height: normal;\"><br></p><p></p><p></p></body></html>\n','2024-11-12 19:29:15','2024-11-21 01:10:02');
/*!40000 ALTER TABLE `m_tentangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2024_08_27_005353_add_column_image_to_users_table',2),(6,'2024_09_10_010543_create_permission_tables',3),(7,'2024_09_11_023706_create_m_ktps_table',4),(8,'2024_09_11_034332_create_m_rumahs_table',5),(9,'2024_09_12_025922_create_m_categories_table',6),(10,'2024_09_12_025930_create_m_news_table',7),(11,'2024_09_12_031815_create_table_add_category_id_to_m_news',7),(12,'2024_09_17_081619_create_image_to_m_news_table',8),(13,'2024_10_07_061132_add_date_to_m_news_table',9),(14,'2024_10_08_020634_add_user_id_to_m_news_table',10),(15,'2024_10_14_035552_create_m_dashboards_table',11),(16,'2024_10_15_003443_add_image_to_m_dashboard_table',12),(17,'2024_10_18_030906_create_m_panduans_table',13),(18,'2024_10_28_005034_create_m__pengelolas_table',14),(19,'2024_10_28_023110_add_image_to_m__pengelolas_table',15),(20,'2024_11_07_020623_change_content_type_in_m_news_table',16),(21,'2024_11_12_041139_create_m_tentangs_table',17),(22,'2024_11_20_053359_create_agenda_models_table',18);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',504);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'view_dashboard','web','2024-09-09 18:39:21','2024-09-09 18:39:21'),(2,'view_on_dashboard','web','2024-09-09 18:48:59','2024-09-09 18:48:59');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(2,3);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','web','2024-09-09 18:21:12','2024-09-09 18:21:12'),(3,'write','web','2024-09-09 18:31:11','2024-09-09 18:31:11'),(4,'guest','web','2024-09-09 18:31:11','2024-09-09 18:31:11');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=506 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (504,'Pengelola P2M 1','test@gmail.com',NULL,'$2y$10$AxBCZR3cWQnc7aJJwHCmf.jlCa/k0Y.6UTsZLzNl.2WyeOyf.ReA.',NULL,'2024-10-18Logo_Politbang.png','2024-09-10 01:23:09','2024-10-17 17:29:10'),(505,'Pengelola P2M 2','sujiwotejo1@gmail.com',NULL,'$2y$10$ZGzCgMIlKCJHk2FEteA5FO7y/B7KPShq1Q.aJRypnvIKX9wNzfJxS',NULL,'2024-09-11SMK ROUDLOTUL MUBTADIIN.jpg','2024-09-10 01:27:10','2024-10-06 18:15:24');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'jurnalistik_polibang'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-29 10:59:57
