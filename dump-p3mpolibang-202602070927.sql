-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: p3mpolibang
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agenda_models`
--

LOCK TABLES `agenda_models` WRITE;
/*!40000 ALTER TABLE `agenda_models` DISABLE KEYS */;
INSERT INTO `agenda_models` VALUES (4,'Persiapan Menuju Dunia Kerja dan Pendidikan Tinggi  Melalui Pengembangan Keterampilan Office untuk  Siswa SMA Negeri 1 Nalumsari','2024-11-26','13:00:00','Laboratorium Komputer SMA Negeri 1 Nalumsari','<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><body><p>Detail Kegiatan sebagai berikut :</p><p>a.<span style=\"white-space:pre\">	</span>Pembukaan dan Materi Pengenalan Microsoft Word, Pengaturan Dasar</p><p>Tanggal<span style=\"white-space:pre\">	</span>:<span style=\"white-space:pre\">	</span>Selasa, 26 November 2024&nbsp;</p><p>Waktu<span style=\"white-space:pre\">	</span>:<span style=\"white-space:pre\">	</span>Pukul 13.00 -15.30 WIB&nbsp;</p><p>Tempat<span style=\"white-space:pre\">	</span>:<span style=\"white-space:pre\">	</span>Laboratorium Komputer SMA Negeri 1 Nalumsari</p><p>b.<span style=\"white-space:pre\">	</span>Materi Format Teks dan Paragraf untuk Karya Ilmiah</p><p>Tanggal<span style=\"white-space:pre\">	</span>:<span style=\"white-space:pre\">	</span>Kamis, 28 November 2024&nbsp;</p><p>Waktu<span style=\"white-space:pre\">	</span>:<span style=\"white-space:pre\">	</span>Pukul 13.00 - 15.30 WIB&nbsp;</p><p>Tempat<span style=\"white-space:pre\">	</span>:<span style=\"white-space:pre\">	</span>Laboratorium Komputer SMA Negeri 1 Nalumsari</p><p>c.<span style=\"white-space:pre\">	</span>Materi Format Teks dan Paragraf untuk Karya Ilmiah</p><p>Tanggal<span style=\"white-space:pre\">	</span>:<span style=\"white-space:pre\">	</span>Selasa, 3 Desember 2024&nbsp;</p><p>Waktu<span style=\"white-space:pre\">	</span>:<span style=\"white-space:pre\">	</span>Pukul 13.00 - 15.30 WIB&nbsp;</p><p>Tempat<span style=\"white-space:pre\">	</span>:<span style=\"white-space:pre\">	</span>Laboratorium Komputer SMA Negeri 1 Nalumsari</p><p>e.<span style=\"white-space:pre\">	</span>Materi Pengaturan Margin, Spasi, Heading dan Daftar Isi Otomatis</p><p>Tanggal<span style=\"white-space:pre\">	</span>:<span style=\"white-space:pre\">	</span>Rabu, 4 Desember 2024&nbsp;</p><p>Waktu<span style=\"white-space:pre\">	</span>:<span style=\"white-space:pre\">	</span>Pukul 13.00 - 15.30 WIB&nbsp;</p><p>Tempat<span style=\"white-space:pre\">	</span>:<span style=\"white-space:pre\">	</span>Laboratorium Komputer SMA Negeri 1 Nalumsari&nbsp;</p><p>d.<span style=\"white-space:pre\">	</span>Penutupan serta Penyelesaian dan Finalisasi Karya Ilmiah</p><p>Tanggal<span style=\"white-space:pre\">	</span>:<span style=\"white-space:pre\">	</span>Kamis, 5 Desember 2024&nbsp;</p><p>Waktu<span style=\"white-space:pre\">	</span>:<span style=\"white-space:pre\">	</span>Pukul 13.00 - 15.30 WIB&nbsp;</p><p>Tempat<span style=\"white-space:pre\">	</span>:<span style=\"white-space:pre\">	</span>Laboratorium Komputer SMA Negeri 1 Nalumsari&nbsp;</p><div><br></div></body></html>\n','2025-02-17 09:55:35','2025-02-17 10:05:10'),(5,'Pelatihan Content Creator batch 2  Fotografi dan Penulisan Berita sebagai Optimalisasi media  dakwah digital Dalam Meningkatkan  Kapasitas Kader PAC Fatayat NU Tahunan”','2024-11-29','08:00:00','PR Fatayat NU Mantingan 01 ( Gedung TPQ Madin Barokatul  Khoir ) Mantingan','<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><body><p style=\"text-align: justify; \">Peningkatan ketrampilan dalam membuat materi dan konten kegiatan \r\nuntuk branding di media sosial oleh PAC Fatayat NU Tahunan sehingga \r\ndiharapkan masyarakat lebih mengenal PAC Fatayat NU Tahunan beserta \r\nkegiatan-kegiatan positifnya, yang berimbas pada peningkatan jumlah anggota.&nbsp;</p></body></html>\n','2025-02-17 09:59:33','2025-02-17 09:59:33'),(6,'Pelatihan Accurate Online Untuk Meningkatkan Kemampuan Pengelolaan Keuangan Siswa Smk','2025-01-24','08:00:00','SMK Al Hikmah 2 Kecamatan Welahan Kabupaten Jepara','<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><body><p style=\"text-align: justify; \">Kegiatan pelatihan ditujukan kepada para siswa SMK khususnya \r\nakuntansi di SMK Al Hikmah 2 Welahan Kabupaten Jepara, sebanyak 27 \r\npeserta yang mengikuti kegiatan pelatihan yang diadakan.</p></body></html>\n','2025-02-17 10:02:08','2025-02-17 10:02:08');
/*!40000 ALTER TABLE `agenda_models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ajuan_penelitian_models`
--

DROP TABLE IF EXISTS `ajuan_penelitian_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ajuan_penelitian_models` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `bidang` varchar(255) NOT NULL,
  `jeniskategori` varchar(255) NOT NULL,
  `ketua` varchar(255) NOT NULL,
  `jeniskelamin` enum('L','P') NOT NULL,
  `nidn` varchar(255) DEFAULT NULL,
  `jabatan` enum('DR','LT','KP','DS') DEFAULT NULL,
  `prodi` enum('R','A','AK','AB','AP') DEFAULT NULL,
  `telp` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `lamapenelitian` varchar(255) DEFAULT NULL,
  `biaya` double(15,2) DEFAULT NULL,
  `uppdf` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'proses',
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ajuan_penelitian_models_user_id_foreign` (`user_id`),
  CONSTRAINT `ajuan_penelitian_models_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ajuan_penelitian_models`
--

LOCK TABLES `ajuan_penelitian_models` WRITE;
/*!40000 ALTER TABLE `ajuan_penelitian_models` DISABLE KEYS */;
INSERT INTO `ajuan_penelitian_models` VALUES (8,'Lambang Daerah','Digitalisasi','Proposal Penelitian','sofi','L','20210101010','KP','R','09875467864321','Kabupaten Semarang','Laboratorium Komputer SMA Negeri 1 Nalumsari',NULL,1500000.00,'24-01-2026examplepdf.pdf',520,'2026-01-24 00:55:02','2026-01-24 01:56:09','proses','2026-01-24','2026-01-24','2026-01-26 17:48:13'),(9,'Tentang Kudus','Bisnis UKM','Surat Pengajuan Penelitian','Nur Hikmah','P','909009090','DR','A','085727772079','semarang','Kampus Politeknik Balekambang Jepara',NULL,1290000.00,'24-01-2026STPeng.pdf',520,'2026-01-24 02:45:14','2026-01-24 02:45:14','proses','2026-01-24','2026-01-24','2026-01-26 17:48:13'),(10,'Sejarah Kudus','Bisnis UKM','Surat Pengajuan Penelitian','Agusinanda','P','909009090','LT','AB','09875467864321','kudus','Kampus Politeknik Balekambang Jepara',NULL,1500000.00,'24-01-2026STPG1.pdf',520,'2026-01-24 02:50:12','2026-01-24 02:50:12','proses','2026-01-24','2026-01-24','2026-01-26 17:48:13'),(11,'asdasdsadsads','esdsaddasd','Surat Pengajuan Penelitian','adsadsa','P','12312132132','DR','AK','12121321321','sadsadsads','Kampus Politeknik Balekambang Jepara',NULL,12323313.00,'24-01-2026STPN1.pdf',520,'2026-01-24 02:55:03','2026-01-24 02:55:03','proses','2026-01-24','2026-01-24','2026-01-26 17:48:13'),(12,'Perekonomian Indonesia yang dikorupsi','Finansial','Surat Pengajuan Penelitian','Prabowo','L','123456789','DR','A','01290095601','Jakarta Pusat','Jakarta Timur',NULL,20000000.00,'27-01-2026lecture note_2-3.pdf',520,'2026-01-26 20:01:18','2026-01-26 20:01:18','proses','2026-01-29','2026-01-31','2026-01-26 20:56:53');
/*!40000 ALTER TABLE `ajuan_penelitian_models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ajupengabdian`
--

DROP TABLE IF EXISTS `ajupengabdian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ajupengabdian` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `bidang` varchar(255) NOT NULL,
  `jeniskategori` varchar(255) NOT NULL,
  `ketua` varchar(255) NOT NULL,
  `jeniskelamin` enum('L','P') NOT NULL,
  `nidn` varchar(255) DEFAULT NULL,
  `jabatan` enum('DR','LT','KP','DS') DEFAULT NULL,
  `prodi` enum('R','A','AK','AB','AP') DEFAULT NULL,
  `telp` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `lamapenelitian` varchar(255) DEFAULT NULL,
  `biaya` double(15,2) DEFAULT NULL,
  `uppdf` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'proses',
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ajupengabdian_user_id_foreign` (`user_id`),
  CONSTRAINT `ajupengabdian_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ajupengabdian`
--

LOCK TABLES `ajupengabdian` WRITE;
/*!40000 ALTER TABLE `ajupengabdian` DISABLE KEYS */;
INSERT INTO `ajupengabdian` VALUES (20,'Sejarah Kudus','Bisnis UKM','Proposal Pengabdian Masyarakat','sofi','L','909009090','DR','AP','085727772079','Mayong - Jepara','PR Fatayat NU Mantingan 01 ( Gedung TPQ Madin Barokatul  Khoir ) Mantingan',NULL,1290000.00,'24-01-2026Lap PKM konten kreator 2.pdf',520,'2026-01-24 00:22:10','2026-01-24 00:57:54','proses','2026-01-24','2026-02-03','2026-01-26 17:48:13'),(21,'Pengumpulan Data Pendidikan','Bisnis UKM','Pengajuan Pengabdian Masyarakat','Maulidia Agustina','P','909009090','DS','AK','085727772079','Jl.Paulidia manggarai','Jepara',NULL,1290000.00,'24-01-2026LAPORAN PKM ACCURATE ONLINE .pdf',520,'2026-01-24 02:17:52','2026-01-24 02:17:52','proses','2026-01-24','2026-01-24','2026-01-26 17:48:13'),(22,'Pemahaman dasar cyber','teknologi','Pengajuan Pengabdian Masyarakat','Jauharul','L','099879022','KP','AK','085727772079','Jepara','Semarang, kabupaten',NULL,15000000.00,'27-01-2026examplepdf.pdf',520,'2026-01-26 19:59:06','2026-01-26 19:59:06','proses','2026-01-29','2026-02-05','2026-01-26 20:58:49'),(23,'Mafia Indonesia Ditangkap','politik','Pengajuan Pengabdian Masyarakat','gibran','P','0986876333','LT','AK','082364759726','dimanasaja','Jepara, Mayong',NULL,20000000.00,'27-01-2026lecture note_2-3.pdf',520,'2026-01-26 20:38:00','2026-01-26 20:38:00','proses','2026-01-27','2026-01-27','2026-01-26 20:58:49');
/*!40000 ALTER TABLE `ajupengabdian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `anggotap3m_models`
--

DROP TABLE IF EXISTS `anggotap3m_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `anggotap3m_models` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `nim` varchar(255) DEFAULT NULL,
  `prodi` enum('R','A','AK','AB','AP') DEFAULT NULL,
  `jabatan` enum('DR','LT','KP','DS','MHS') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ajupengab_model_id` bigint(20) unsigned DEFAULT NULL,
  `ajupenel_model_id` bigint(20) unsigned DEFAULT NULL,
  `kpengab_model_id` bigint(20) unsigned DEFAULT NULL,
  `kpenel_model_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `anggotap3m_models_ajupengab_model_id_foreign` (`ajupengab_model_id`),
  KEY `anggotap3m_models_ajupenel_model_id_foreign` (`ajupenel_model_id`),
  KEY `anggotap3m_models_kpengab_model_id_foreign` (`kpengab_model_id`),
  KEY `anggotap3m_models_kpenel_model_id_foreign` (`kpenel_model_id`),
  CONSTRAINT `anggotap3m_models_ajupenel_model_id_foreign` FOREIGN KEY (`ajupenel_model_id`) REFERENCES `ajuan_penelitian_models` (`id`) ON DELETE CASCADE,
  CONSTRAINT `anggotap3m_models_ajupengab_model_id_foreign` FOREIGN KEY (`ajupengab_model_id`) REFERENCES `ajupengabdian` (`id`) ON DELETE CASCADE,
  CONSTRAINT `anggotap3m_models_kpenel_model_id_foreign` FOREIGN KEY (`kpenel_model_id`) REFERENCES `kum_penelitian_models` (`id`) ON DELETE CASCADE,
  CONSTRAINT `anggotap3m_models_kpengab_model_id_foreign` FOREIGN KEY (`kpengab_model_id`) REFERENCES `kum_pengabdian_models` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anggotap3m_models`
--

LOCK TABLES `anggotap3m_models` WRITE;
/*!40000 ALTER TABLE `anggotap3m_models` DISABLE KEYS */;
INSERT INTO `anggotap3m_models` VALUES (87,'Nila Ayu Kusuma W. M.E','202101010101010','R','KP','2026-01-24 00:57:54','2026-01-24 00:57:54',20,NULL,NULL,NULL),(90,'Nila Ayu Kusuma W. M.E','1212121212','R','MHS','2026-01-24 01:10:45','2026-01-24 01:10:45',NULL,NULL,11,NULL),(91,'mualin','1212121212','A','MHS','2026-01-24 01:12:20','2026-01-24 01:12:20',NULL,NULL,10,NULL),(93,'mualin','202101010101010','A','MHS','2026-01-24 01:44:01','2026-01-24 01:44:01',NULL,NULL,NULL,13),(98,'Nila Ayu Kusuma W. M.E','1212121212','A','LT','2026-01-24 01:59:19','2026-01-24 01:59:19',NULL,8,NULL,NULL),(99,'Nur Ahmad Budi Yulianto, M.M','111111','AB','MHS','2026-01-24 01:59:19','2026-01-24 01:59:19',NULL,8,NULL,NULL),(100,'Khoirun','212907367','R','KP','2026-01-24 02:17:52','2026-01-24 02:17:52',21,NULL,NULL,NULL),(101,'Nuriana Mislahoulina','1234535754','AP','MHS','2026-01-24 02:17:52','2026-01-24 02:17:52',21,NULL,NULL,NULL),(102,'suji','98765678','A','MHS','2026-01-24 02:45:14','2026-01-24 02:45:14',NULL,9,NULL,NULL),(103,'suji','2222222222','A','DS','2026-01-24 02:50:12','2026-01-24 02:50:12',NULL,10,NULL,NULL),(104,'sadsadsad','112321321','AB','LT','2026-01-24 02:55:03','2026-01-24 02:55:03',NULL,11,NULL,NULL),(105,'Jiji','11987770','AP','MHS','2026-01-26 17:51:39','2026-01-26 17:51:39',NULL,NULL,NULL,14),(106,'Kali','12255654889','R','DS','2026-01-26 17:51:39','2026-01-26 17:51:39',NULL,NULL,NULL,14),(107,'Sujiyani Murtati','98765678','AB','MHS','2026-01-26 19:59:06','2026-01-26 19:59:06',22,NULL,NULL,NULL),(108,'Gibran Raka','220917493','AK','LT','2026-01-26 20:01:18','2026-01-26 20:01:18',NULL,12,NULL,NULL),(109,'Jiji','11987770','AK','DS','2026-01-26 20:38:00','2026-01-26 20:38:00',23,NULL,NULL,NULL),(110,'Jiji','11987770','A','KP','2026-01-26 21:00:16','2026-01-26 21:00:16',NULL,NULL,12,NULL),(111,'Jiji','121212121212','A','KP','2026-01-26 21:08:43','2026-01-26 21:08:43',NULL,NULL,13,NULL),(112,'Jiji','121212121212','AK','LT','2026-01-26 21:10:12','2026-01-26 21:10:12',NULL,NULL,14,NULL);
/*!40000 ALTER TABLE `anggotap3m_models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dokumen_models`
--

DROP TABLE IF EXISTS `dokumen_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dokumen_models` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `originalname` varchar(255) NOT NULL,
  `namefile` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dokumen_models`
--

LOCK TABLES `dokumen_models` WRITE;
/*!40000 ALTER TABLE `dokumen_models` DISABLE KEYS */;
INSERT INTO `dokumen_models` VALUES (1,'20250123061008.pdf','Dokumen Unggah Jurnal','2025-01-22 23:10:08','2025-01-22 23:10:08'),(2,'20250329071901.pdf','Pedoman Dua','2025-03-29 00:19:01','2025-03-29 00:19:01');
/*!40000 ALTER TABLE `dokumen_models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dosen_models`
--

DROP TABLE IF EXISTS `dosen_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dosen_models` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dosen_models`
--

LOCK TABLES `dosen_models` WRITE;
/*!40000 ALTER TABLE `dosen_models` DISABLE KEYS */;
/*!40000 ALTER TABLE `dosen_models` ENABLE KEYS */;
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
-- Table structure for table `jurnal_models`
--

DROP TABLE IF EXISTS `jurnal_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jurnal_models` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `jurnalname` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jurnal_models`
--

LOCK TABLES `jurnal_models` WRITE;
/*!40000 ALTER TABLE `jurnal_models` DISABLE KEYS */;
INSERT INTO `jurnal_models` VALUES (1,'IMPLEMENTASI METODE PROTOTYPE PADA PEMBUATAN WEBSITE DESTINATION BRANDING PARIWISATA “PANTAITELUKAWUR. ID” DI DESA TELUK AWUR','https://scholar.google.com/citations?view_op=view_citation&hl=id&user=eQkJBa8AAAAJ&citation_for_view=eQkJBa8AAAAJ:eMMeJKvmdy0C','2025-02-03 22:11:51','2025-02-03 22:57:16');
/*!40000 ALTER TABLE `jurnal_models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kum_penelitian_models`
--

DROP TABLE IF EXISTS `kum_penelitian_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kum_penelitian_models` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `bidang` varchar(255) NOT NULL,
  `jeniskategori` varchar(255) NOT NULL,
  `ketua` varchar(255) NOT NULL,
  `jeniskelamin` enum('L','P') NOT NULL,
  `nidn` varchar(255) DEFAULT NULL,
  `jabatan` enum('DR','RK','KP','DS') DEFAULT NULL,
  `prodi` enum('R','A','AK','AB','AP') DEFAULT NULL,
  `telp` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `lamapenelitian` varchar(255) DEFAULT NULL,
  `biaya` double(15,2) DEFAULT NULL,
  `uppdf` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'proses',
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kum_penelitian_models_user_id_foreign` (`user_id`),
  CONSTRAINT `kum_penelitian_models_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kum_penelitian_models`
--

LOCK TABLES `kum_penelitian_models` WRITE;
/*!40000 ALTER TABLE `kum_penelitian_models` DISABLE KEYS */;
INSERT INTO `kum_penelitian_models` VALUES (13,'Lambang Daerah','Bisnis UKM','Laporan Penelitian','Agusinanda','P','909009090','KP','A','085727772079','semarang','Mayong',NULL,1290000.00,'24-01-2026examplepdf.pdf','24-01-2026research_2086924.png',520,'2026-01-24 00:04:26','2026-01-24 01:44:01','proses','2026-01-24','2026-01-24','2026-01-26 17:48:13'),(14,'Pencegahan DBD','Kesehatan','Laporan Penelitian Masyarakat','Saudianianing','P','0986876333','KP','AB','082364759726','dimanasaja','Jepara, Mayong',NULL,20000000.00,'27-01-2026Admin P3M POLIBANG.pdf','27-01-20261000364464.jpg',520,'2026-01-26 17:51:39','2026-01-26 17:51:39','proses','2026-01-27','2026-01-30','2026-01-26 17:51:52');
/*!40000 ALTER TABLE `kum_penelitian_models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kum_pengabdian_models`
--

DROP TABLE IF EXISTS `kum_pengabdian_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kum_pengabdian_models` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bidang` varchar(255) NOT NULL,
  `jeniskategori` varchar(255) NOT NULL,
  `ketua` varchar(255) NOT NULL,
  `jeniskelamin` enum('L','P') NOT NULL,
  `nidn` varchar(255) DEFAULT NULL,
  `jabatan` enum('DR','LT','KP','DS') DEFAULT NULL,
  `prodi` enum('R','A','AK','AB','AP') DEFAULT NULL,
  `telp` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `lamapenelitian` varchar(255) DEFAULT NULL,
  `biaya` double(15,2) DEFAULT NULL,
  `uppdf` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'proses',
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kum_pengabdian_models_user_id_foreign` (`user_id`),
  CONSTRAINT `kum_pengabdian_models_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kum_pengabdian_models`
--

LOCK TABLES `kum_pengabdian_models` WRITE;
/*!40000 ALTER TABLE `kum_pengabdian_models` DISABLE KEYS */;
INSERT INTO `kum_pengabdian_models` VALUES (10,'Lambang Daerah','2026-01-24 00:42:44','2026-01-24 00:49:53','Digitalisasi','Proposal Pengabdian Masyarakat','Nur Hikmah','P','909009090','DS','A','09875467864321','asa','Laboratorium Komputer SMA Negeri 1 Nalumsari',NULL,1290000.00,'24-01-2026Lap PKM konten kreator 2.pdf','24-01-2026Pusat Penelitian (1).png',520,'proses','2026-01-24','2026-01-24','2026-01-26 17:48:13'),(11,'Sejarah Kudus','2026-01-24 01:09:48','2026-01-24 01:10:44','Bisnis UKM','Proposal Pengabdian Masyarakat','Agusinanda','L','20210101010','LT','R','085727772079','jepara','paguyuban',NULL,1500000.00,'24-01-2026Lap PKM konten kreator 2.pdf','24-01-2026Pusat Penelitian (1).png',520,'proses','2026-01-24','2026-01-24','2026-01-26 17:48:13'),(12,'Penelitian Jagung pada','2026-01-26 21:00:16','2026-01-26 21:00:16','politik','Laporan Pengabdian Masyarakat','gibran','L','0986876333','LT','AK','082364759726','dimanasaja','Jepara, Mayong',NULL,20000000.00,'27-01-2026lecture note_2-2.pdf','27-01-202617-02-2025Cuplikan layar 2025-02-17 225632.png',520,'proses','2026-01-27','2026-01-27','2026-01-26 21:04:54'),(13,'Penelitian Jagung pada Tanah Kosong','2026-01-26 21:08:43','2026-01-26 21:08:43','politik','Laporan Pengabdian Masyarakat','gibran','P','0986876333','LT','A','082364759726','dimanasaja','Jepara, Mayong',NULL,20000000.00,'27-01-2026lecture note_1-3.pdf','27-01-202617-02-2025Cuplikan layar 2025-02-17 225632.png',520,'proses','2026-01-27','2026-01-27','2026-01-26 21:09:09'),(14,'Penelitian Jagung pada Tanah Kosong','2026-01-26 21:10:12','2026-01-26 21:10:12','politik','Laporan Pengabdian Masyarakat','gibran','P','0986876333','KP','AK','082364759726','dimanasaja','Jepara, Mayong',NULL,20000000.00,'27-01-2026lecture note_1-4.pdf','27-01-20261000364464.jpg',520,'proses','2026-01-27','2026-01-27','2026-01-26 21:10:29');
/*!40000 ALTER TABLE `kum_pengabdian_models` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m__pengelolas`
--

LOCK TABLES `m__pengelolas` WRITE;
/*!40000 ALTER TABLE `m__pengelolas` DISABLE KEYS */;
INSERT INTO `m__pengelolas` VALUES (15,'17-02-2025Casual Girl 3D Character (AI style).png','Sofia Ulfah M.Kom','06190990045','Ketua Pusat Penelitian dan Pengabdian Masyarakat','sofiaulfah16@gmail.com','2024-10-28 22:16:19','2025-06-08 22:35:11'),(21,'29-10-2024Casual Girl 3D Character (AI style).png','Ahmad Afendy Susanto, M.M','0628079202','Koordinator Pusat Penelitian dan Pengabdian Masyarakat','afendysusanto13@gmail.com','2024-10-28 22:30:48','2025-03-28 07:20:36');
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
INSERT INTO `m_categories` VALUES (1,'Pengabdian Masyarakat','pengabdian masyarakat','2024-09-11 21:55:55','2025-01-21 06:03:51'),(2,'Penelitian Masyarakat','penelitian masyarakat','2024-09-12 00:55:19','2025-01-21 06:04:11');
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
INSERT INTO `m_dashboards` VALUES (1,'2025-02-17Pusat_Penelitian__1_-removebg-preview (1).png','Pusat Penelitian dan Pengabdian Kepada Masyarakat','Pusat Penelitian dan Pengabdian kepada masyarakat','2024-10-14 20:29:18','2025-05-13 23:04:18');
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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_news`
--

LOCK TABLES `m_news` WRITE;
/*!40000 ALTER TABLE `m_news` DISABLE KEYS */;
INSERT INTO `m_news` VALUES (27,'2024-11-05','17-02-2025-16-08-02-67b35ee231081.png','Pelatihan Content Creator batch 2  Fotografi dan Penulisan Berita sebagai Optimalisasi media  dakwah digital Dalam Meningkatkan  Kapasitas Kader PAC Fatayat NU Tahunan”','<p style=\"text-align: justify; \">Perkembangan teknologi digital membawa perubahan di berbagai sektor kehidupan manusia terutama di bidang komunikasi. Pada bidang komunikasi, teknologi digital ini telah melahirkan juga berbagai jenis media komunikasi dari yang mudah seperti telepon genggam (smartphone) yang digunakan sehari-hari sampai hal yang paling rumit seperti komunikasi luar angkasa dan sistem komunikasi kemiliteran. Teknologi digital membantu memenuhi kebutukan masyarakat dan dapat dipergunakan sebagai peningkatan kualitas diri seperti mengembangkan kompetensi diri melalui platform-platform yang ada pada era digital ini.</p><figure class=\"image\"><img src=\"/storage/photo-news/17-02-2025-16-08-02-67b35ee231081.png\"></figure><p style=\"text-align: justify; \">Kegiatan pelaksanaan dilakukan di PAC Fatayat NU Tahunan, dengan memberikan pelatihan sebagai solusi dari permasalahan yang ada. Pelaksanaan dilakukan pada hari sabtu tanggal 30 November 2024. Kegiatan dilakukan dengan cara metode ceramah dan praktik, serta mendampingi pada saat pelatihan.&nbsp;</p>',1,'2025-02-17 09:08:02','2025-02-17 09:13:47',504),(28,'2025-01-20','17-02-2025-16-21-49-67b3621d02e1e.png','Persiapan Menuju Dunia Kerja dan Pendidikan Tinggi  Melalui Pengembangan Keterampilan Office untuk  Siswa SMA Negeri 1 Nalumsari','<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><body><p class=\"MsoListParagraph\" style=\"text-align: justify; margin-left: 0cm; text-indent: 36pt;\">Dalam era digital saat ini, penguasaan\r\nMicrosoft Office, khususnya <span lang=\"EN-US\">Microsoft </span>Word, telah menjadi salah satu keterampilan dasar yang\r\nsangat dibutuhkan, baik dalam konteks pendidikan maupun dunia kerja. Keterampilan\r\nmenggunakan Microsoft Word bukan hanya penting untuk menunjang kegiatan belajar\r\ndi sekolah, tetapi juga memiliki manfaat jangka panjang bagi masa depan siswa. <span style=\"mso-bidi-font-size:12.0pt;line-height:150%;mso-ansi-language:IN\">Di era digital,\r\nMicrosoft Office telah menjadi standar industri dalam sebagian besar organisasi\r\ndan perusahaan.</span><span style=\"mso-bidi-font-size:12.0pt;line-height:150%\">\r\n</span><span style=\"mso-bidi-font-size:12.0pt;line-height:150%;mso-ansi-language:\r\nIN\">Hampir semua pekerjaan membutuhkan kemampuan dalam menggunakan setidaknya satu\r\natau lebih program Microsoft Office. Dengan menguasai Microsoft Office, kita memenuhi\r\npersyaratan dasar yang diperlukan di banyak bidang pekerjaan</span><span lang=\"EN-US\" style=\"mso-bidi-font-size:12.0pt;line-height:150%\">.</span></p><p class=\"MsoListParagraph\" style=\"text-align: justify; margin-left: 0cm; text-indent: 36pt;\"><span lang=\"EN-US\" style=\"mso-bidi-font-size:12.0pt;line-height:150%\"></span></p><p class=\"MsoNormal\" style=\"text-align: justify; text-indent: 36pt;\">Pelatihan Microsoft Word <span lang=\"EN-US\">untuk Pembuatan Karya Ilmiah\r\n</span>yang diselenggarakan di SMA Negeri 1 Nalumsari\r\ndimulai dengan proses seleksi peserta oleh pembina OSIS. Proses ini memastikan bahwa\r\npeserta yang terpilih merupakan siswa-siswi yang memiliki potensi dan komitmen tinggi.\r\nSebanyak 50 peserta terpilih mendapatkan kesempatan untuk mengikuti pelatihan ini.</p><p class=\"MsoNormal\" style=\"text-align: justify; text-indent: 36pt;\"><img src=\"/storage/photo-news/17-02-2025-16-21-49-67b3621d02e1e.png\" style=\"width: 409px;\" data-filename=\"image.png\"></p><p class=\"MsoListParagraph\" style=\"text-align: justify; margin-left: 0cm; text-indent: 36pt;\">Kebutuhan akan pelatihan Microsoft <span lang=\"EN-US\">W</span>ord yang lebih mendalam, terutama\r\nuntuk keperluan pembuatan <span lang=\"EN-US\">tugas maupun</span><span lang=\"EN-US\"> </span>karya ilmiah, semakin mendesak. Kemampuan menyusun laporan, makalah, atau skripsi\r\ndengan format yang benar dan profesional merupakan salah satu syarat penting dalam\r\nproses pembelajaran dan pengembangan diri siswa. Oleh karena itu, pelatihan ini\r\ndiharapkan dapat memberikan bekal yang cukup bagi siswa SMA N<span lang=\"EN-US\">egeri</span><span lang=\"EN-US\"> </span>1 Nalumsari untuk menghasilkan karya tulis yang berkualitas. Pelatihan ini diharapkan\r\ndapat memberikan bekal yang komprehensif bagi siswa sehingga mereka siap menghadapi\r\ntantangan di masa depan.<p></p></p></body></html>\n',1,'2025-02-17 09:21:49','2025-02-17 09:21:49',504),(29,'2025-02-03','17-02-2025Cuplikan layar 2025-02-17 225632.png','Pelatihan Accurate Online Untuk  Meningkatkan Kemampuan Pengelolaan  Keuangan Siswa SMK','<p style=\"text-align: justify; \">Politeknik Balekambang Jepara sebagai lembaga vokasi dalam dunia \r\nPendidikan tinggi mengemban tugas Tri Dharma Perguruan Tinggi yang meliputi \r\nkegiatan pendidikan, penelitian, dan pengabdian. Politeknik Balekambang Jepara \r\nmemiliki program pengabdian kepada masyarakat yang diselenggarakan oleh Tim \r\nsesuai dengan Visi dan Misi Politeknik Balekambang. Dalam program pengabdian \r\nmasyarakat kali ini bekerja sama dengan SMK Al Hikmah 2 Kecamatan Welahan \r\nKabupaten Jepara dengan mengangkat judul yakni: â€œPelatihan Accurate Online \r\nUntuk Meningkatkan Kemampuan Pengelolaan Keuangan Siswa SMK.</p><p style=\"text-align: justify; \">Tujuan dari pelatihan ini yaitu dapat meningkatan \r\nkemampuan pengelolaan keuangan siswa SMK  khususnya siswa dalam bidang \r\nakuntansi, dengan tujuan untuk mendalami program pembukuan keuangan berbasis \r\nteknologi secara tepat, cepat dan rapih. Selain itu pelatihan Software Accounting \r\nAccurate ini juga memberikan pengetahuan dan keterampilan dalam menggunakan \r\nsoftware akuntansi dalam hal kegiatan  pencatatan laporan keuangan, mulai dari \r\nkegiatan pengenalan jenis-jenis dokumen transaksi, input, jurnal sampai dengan \r\nanalisa laporan keuangan.</p>',1,'2025-02-17 09:24:23','2026-01-27 01:48:07',504);
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
  `namefile` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `generated_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_panduans`
--

LOCK TABLES `m_panduans` WRITE;
/*!40000 ALTER TABLE `m_panduans` DISABLE KEYS */;
INSERT INTO `m_panduans` VALUES (8,'Panduan P3M Terbaru','20250121113554.pdf','20250121113554.pdf','2025-01-21 04:35:54','2025-01-21 04:35:54'),(11,'Panduan P3K','20250417055737.pdf','20250417055737.pdf','2025-04-16 22:57:37','2025-04-16 22:57:37');
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
INSERT INTO `m_tentangs` VALUES (1,'<p class=\"MsoNormal\" style=\"text-align: justify; margin-top: 0cm; margin-bottom: 0cm; margin-right: 0cm; line-height: normal;\">Menjadi pusat unggulan dalam penelitian, pengabdian kepada masyarakat, dan pengembangan yang berkontribusi signifikan terhadap peningkatan kualitas hidup masyarakat dan kemajuan ilmu pengetahuan.</p><p class=\"MsoNormal\" style=\"text-align: justify; margin-top: 0cm; margin-bottom: 0cm; margin-right: 0cm; line-height: normal;\">larirarira lariri darindurim</p>','<ul><li>mengembangkan penelitian yang inovatif dan berkualitas tinggi</li><li>menyelenggarakan pengabdian kepada masyarakat</li><li>membangun kolaborasi yang kuat&nbsp;</li><li>meningkatkan kapasitas dan kompetensi sumber daya manusia</li><li>mengimplementasi hasil penelititan dan pengembangan</li></ul>','<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><body><p class=\"MsoNormal\" style=\"text-align: justify; margin-top: 0cm; margin-bottom: 0cm; margin-right: 0cm; line-height: normal;\"><span style=\'font-size: 12pt; font-family: \"system-ui\";\'>Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) adalah lembaga di kampus yang berfokus pada pengembangan penelitian dan pelaksanaan kegiatan pengabdian kepada masyarakat sebagai bentuk nyata kontribusi kampus terhadap kemajuan ilmu pengetahuan, teknologi, dan kesejahteraan masyarakat. P3M bertujuan untuk menjadi jembatan antara dunia akademik dan kebutuhan masyarakat dengan mengaplikasikan hasil penelitian dalam bentuk program-program pemberdayaan yang relevan dan bermanfaat.</span></p><p></p><p></p><p></p><p class=\"MsoNormal\" style=\"text-align: justify; margin-top: 0cm; margin-bottom: 0cm; margin-right: 0cm; line-height: normal;\"><span style=\'font-size: 12pt; font-family: \"system-ui\";\'>Melalui kolaborasi dengan dosen, mahasiswa, dan mitra eksternal, P3M berupaya menciptakan inovasi-inovasi berkelanjutan yang mendukung pengembangan masyarakat di berbagai bidang, seperti pendidikan, kesehatan, lingkungan, teknologi, dan ekonomi. Dengan pendekatan yang inklusif dan partisipatif, P3M berkomitmen untuk menciptakan solusi yang berdampak nyata, relevan dengan kebutuhan lokal, serta mendukung pembangunan nasional.</span></p><p class=\"MsoNormal\" style=\"text-align: justify; margin-top: 0cm; margin-bottom: 0cm; margin-right: 0cm; line-height: normal;\"><span style=\'font-size: 12pt; font-family: \"system-ui\";\'><br></span></p><p class=\"MsoNormal\" style=\"text-align: justify; margin-top: 0cm; margin-bottom: 0cm; margin-right: 0cm; line-height: normal;\"><span style=\'font-size: 12pt; font-family: \"system-ui\";\'><br></span></p><p class=\"MsoNormal\" style=\"text-align: justify; margin-top: 0cm; margin-bottom: 0cm; margin-right: 0cm; line-height: normal;\"><br></p><p></p><p></p></body></html>\n','2024-11-12 19:29:15','2025-02-17 06:15:29');
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
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2024_08_27_005353_add_column_image_to_users_table',2),(6,'2024_09_10_010543_create_permission_tables',3),(7,'2024_09_11_023706_create_m_ktps_table',4),(8,'2024_09_11_034332_create_m_rumahs_table',5),(9,'2024_09_12_025922_create_m_categories_table',6),(10,'2024_09_12_025930_create_m_news_table',7),(11,'2024_09_12_031815_create_table_add_category_id_to_m_news',7),(12,'2024_09_17_081619_create_image_to_m_news_table',8),(13,'2024_10_07_061132_add_date_to_m_news_table',9),(14,'2024_10_08_020634_add_user_id_to_m_news_table',10),(15,'2024_10_14_035552_create_m_dashboards_table',11),(16,'2024_10_15_003443_add_image_to_m_dashboard_table',12),(17,'2024_10_18_030906_create_m_panduans_table',13),(18,'2024_10_28_005034_create_m__pengelolas_table',14),(19,'2024_10_28_023110_add_image_to_m__pengelolas_table',15),(20,'2024_11_07_020623_change_content_type_in_m_news_table',16),(21,'2024_11_12_041139_create_m_tentangs_table',17),(22,'2024_11_20_053359_create_agenda_models_table',18),(23,'2025_01_21_111339_add_namefile_to_m_panduans_table',19),(24,'2025_01_23_051357_create_dokumen_models_table',20),(25,'2025_02_04_035320_create_jurnal_models_table',21),(26,'2025_03_03_035355_add_roles_users_table',22),(27,'2025_03_28_130553_create_dosen_models_table',23),(28,'2025_04_11_044158_create_p3m_models_table',23),(29,'2025_04_11_051906_create_anggotap3m_models_table',23),(30,'2025_04_11_052919_change_jeniskategori_to_kategori_id_in_p3m_models_table',24),(31,'2025_04_11_084703_add_user_id_to_p3m_models_table',25),(32,'2025_06_09_124354_create_kum_pengabdian_models_table',26),(33,'2025_06_09_124408_create_kum_penelitian_models_table',26),(34,'2025_06_09_124432_create_ajuan_penelitian_models_table',26),(35,'2025_06_13_105154_create_ajupengabdian_table',27),(36,'2025_06_13_115557_add_to_kum_pengabdian_models_table',28),(37,'2025_06_13_124128_add_to_kum_penelitian_models_table',29),(38,'2025_06_13_142652_add_to_anggotap3m_models_table',30),(39,'2025_06_13_143643_add_to_anggotap3m_models_table',30),(40,'2025_09_29_041516_add_status_to_p3m_models_table',31),(41,'2025_09_29_044055_add_status_to_ajupengabdian_table',32),(42,'2025_10_05_040528_add_status_to_ajuan_penelitian_models_table',33),(43,'2025_10_05_040555_add_status_to_kum_penelitian_models_table',33),(44,'2025_10_05_040621_add_status_to_kum_pengabdian_models_table',33),(45,'2025_10_07_061611_add_tanggal_mulai_selesai_to_ajupengabdian_table',34),(46,'2025_10_22_152931_add_tanggal_mulai_selesai_to_kum_pengabdian_models_table',35),(47,'2025_10_22_153200_add_tanggal_mulai_selesai_to_ajuan_penelitian_models_table',35),(48,'2025_10_22_153332_add_tanggal_mulai_selesai_to_kum_penelitian_models_table',35),(49,'2025_12_11_074122_add_nim_to_anggotap3m_models_table',36);
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
-- Table structure for table `p3m_models`
--

DROP TABLE IF EXISTS `p3m_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `p3m_models` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `bidang` varchar(255) NOT NULL,
  `ketua` varchar(255) NOT NULL,
  `jeniskelamin` enum('L','P') NOT NULL,
  `nidn` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `prodi` varchar(255) DEFAULT NULL,
  `telp` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `lamapenelitian` varchar(255) DEFAULT NULL,
  `biaya` varchar(255) DEFAULT NULL,
  `uppdf` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kategori_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'proses',
  PRIMARY KEY (`id`),
  KEY `p3m_models_kategori_id_foreign` (`kategori_id`),
  KEY `p3m_models_user_id_foreign` (`user_id`),
  CONSTRAINT `p3m_models_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `m_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `p3m_models_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `p3m_models`
--

LOCK TABLES `p3m_models` WRITE;
/*!40000 ALTER TABLE `p3m_models` DISABLE KEYS */;
/*!40000 ALTER TABLE `p3m_models` ENABLE KEYS */;
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
INSERT INTO `roles` VALUES (1,'admin','web','2024-09-09 18:21:12','2024-09-09 18:21:12'),(3,'dosen','web','2024-09-09 18:31:11','2024-09-09 18:31:11'),(4,'guest','web','2024-09-09 18:31:11','2024-09-09 18:31:11');
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
  `role` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=523 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (504,'Pengelola P3M 1','test@gmail.com','admin',NULL,'$2y$10$AxBCZR3cWQnc7aJJwHCmf.jlCa/k0Y.6UTsZLzNl.2WyeOyf.ReA.',NULL,'2025-02-17Pusat_Penelitian-removebg-preview.png','2024-09-10 01:23:09','2025-02-16 22:22:12'),(505,'Pengelola P2M 7','sujiwotejo1@gmail.com','admin',NULL,'$2y$10$ZGzCgMIlKCJHk2FEteA5FO7y/B7KPShq1Q.aJRypnvIKX9wNzfJxS',NULL,'2024-09-11SMK ROUDLOTUL MUBTADIIN.jpg','2024-09-10 01:27:10','2025-06-08 23:01:48'),(519,'Khodija','halooo@gmail.com','dosen',NULL,'$2y$10$hdzxV37G8KRli/Zv8PLMKulq.Y7XuMTq1R3A2KQykyM5Z2GXcHLyK',NULL,NULL,'2025-06-08 22:48:05','2025-06-08 22:48:05'),(520,'Khodijah','sujiwotejo@gmail.com','dosen',NULL,'$2y$10$lqqSjP6WTjNf3zGkHTrH2.gSbkauxy8KibKKT.WgmNKFy6KutSek2',NULL,'2025-06-13Logo_Politbang.png','2025-06-09 06:51:12','2025-07-09 06:57:49');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'p3mpolibang'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-07  9:27:39
