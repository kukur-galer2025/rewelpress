<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/Database.php';

$db = new Database();

$sql = "
CREATE TABLE IF NOT EXISTS `reviews` (
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
";

$db->query($sql);
$db->execute();

$insertSql = "
INSERT INTO `reviews` VALUES (1,NULL,'Dr. Hendra Saputra, M.P.','book',7,5,'Buku referensi pertanian tropis terbaik yang pernah saya baca. Sangat komprehensif untuk mahasiswa dan peneliti.','2026-07-22 10:20:00'),(2,NULL,'Siti Nurhaliza','book',7,5,'Bahasa mudah dipahami, kualitas cetakan sangat baik.','2026-07-22 10:20:00'),(3,NULL,'Ahmad Fauzi, S.H.','book',8,5,'Metodologinya dijelaskan sangat terstruktur dan aplikatif untuk tesis hukum modern.','2026-07-22 10:20:00'),(4,NULL,'Rina Wati','book',8,4,'Sangat membantu penelitian hukum saya. Terimakasih Unsoed Press!','2026-07-22 10:20:00'),(5,NULL,'Prof. Budi Santoso','book',9,5,'Bioteknologi dijelaskan dengan contoh nyata di Indonesia. Luar biasa.','2026-07-22 10:20:00'),(6,NULL,'Dani Kurniawan','book',9,5,'Buku wajib untuk mahasiswa biologi sains!','2026-07-22 10:20:00'),(7,NULL,'Farah Diba','book',10,5,'Analisis ekonomi daerahnya sangat mendalam dan kritis.','2026-07-22 10:20:00'),(8,NULL,'Gunawan Wibisono','book',11,5,'Sosiologi pedesaan dijelaskan secara akurat dengan data lapangan UGM & Unsoed.','2026-07-22 10:20:00'),(9,NULL,'dr. Anisa Rahma','book',12,5,'Sangat direkomendasikan untuk tenaga medis di wilayah pedesaan.','2026-07-22 10:20:00'),(10,NULL,'Mahasiswa Kedokteran','book',12,4,'Buku saku yang sangat informatif dan padat ilmunya.','2026-07-22 10:20:00'),(11,NULL,'Bambang Pamungkas','ebook',1,5,'E-Book sangat jernih, bisa dibaca lewat HP maupun laptop kapan saja!','2026-07-22 10:20:00'),(12,NULL,'Intan Permatasari','ebook',1,5,'Download cepat, materinya persis versi cetak. Praktis sekali!','2026-07-22 10:20:00'),(13,NULL,'Drs. Haryanto, M.H.','ebook',2,5,'Fitur ebook sangat membantu riset hukum saya saat di luar kota.','2026-07-22 10:20:00'),(14,NULL,'Maya Amelia','ebook',3,5,'PDF full color, diagram bioteknologinya jelas banget!','2026-07-22 10:20:00'),(15,NULL,'Rizky Pratama','ebook',4,5,'Harga e-book hemat dan berkualitas dari Unsoed Press.','2026-07-22 10:20:00');
";
$db->query($insertSql);
$db->execute();

echo "Table reviews created and populated successfully.\n";
