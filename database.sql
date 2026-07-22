CREATE DATABASE IF NOT EXISTS `press_unsoed_db`;
USE `press_unsoed_db`;

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`id`, `name`, `slug`, `parent_id`) VALUES
(1, 'Sains & Teknologi', 'sains-teknologi', NULL),
(2, 'Sosial & Humaniora', 'sosial-humaniora', NULL),
(3, 'Kesehatan & Kedokteran', 'kesehatan-kedokteran', NULL),
(14, 'Agro & Fauna', 'agro-fauna', NULL),
(4, 'Arsitektur', 'arsitektur', 1),
(5, 'Biologi', 'biologi', 1),
(6, 'Fisika', 'fisika', 1),
(7, 'Teknik Kimia', 'teknik-kimia', 1),
(15, 'Geografi', 'geografi', 1),
(16, 'Geologi', 'geologi', 1),
(17, 'Kimia', 'kimia', 1),
(18, 'Lingkungan', 'lingkungan', 1),
(19, 'Matematika', 'matematika', 1),
(20, 'Statistika', 'statistika', 1),
(21, 'Teknik Sipil', 'teknik-sipil', 1),
(22, 'Teknologi Informasi', 'teknologi-informasi', 1),
(23, 'Teknik Elektro', 'teknik-elektro', 1),
(24, 'Geodesi', 'geodesi', 1),
(25, 'Teknik Mesin', 'teknik-mesin', 1),
(8, 'Hukum', 'hukum', 2),
(9, 'Ekonomi & Bisnis', 'ekonomi-bisnis', 2),
(10, 'Sosial & Politik', 'sosial-politik', 2),
(26, 'Budaya', 'budaya', 2),
(27, 'Monografi', 'monografi', 2),
(28, 'Sejarah', 'sejarah', 2),
(29, 'Filsafat', 'filsafat', 2),
(30, 'Kamus', 'kamus', 2),
(31, 'Pariwisata', 'pariwisata', 2),
(32, 'Psikologi', 'psikologi', 2),
(11, 'Kedokteran Umum', 'kedokteran-umum', 3),
(12, 'Keperawatan', 'keperawatan', 3),
(33, 'Farmasi', 'farmasi', 3),
(34, 'Kedokteran Hewan', 'kedokteran-hewan', 3),
(35, 'Kedokteran Gigi', 'kedokteran-gigi', 3),
(36, 'Kesehatan', 'kesehatan', 3),
(13, 'Pertanian', 'pertanian', 14),
(37, 'Kehutanan', 'kehutanan', 14),
(38, 'Perikanan', 'perikanan', 14),
(39, 'Peternakan', 'peternakan', 14),
(40, 'Teknologi Pertanian', 'teknologi-pertanian', 14);

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(150) NOT NULL,
  `synopsis` text DEFAULT NULL,
  `isbn` varchar(50) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `old_price` int(11) DEFAULT '0',
  `pages` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `publication_year` int(4) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `books` (`category_id`, `title`, `author`, `price`, `old_price`, `image`, `views`) VALUES
(1, 'Pengantar Ilmu Pertanian Tropis', 'Prof. Dr. Ir. Suwarto, M.S.', 85000, 100000, 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80&w=400', 120),
(2, 'Metodologi Penelitian Hukum Modern', 'Dr. Hibnu Nugroho, S.H., M.H.', 95000, 0, 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?auto=format&fit=crop&q=80&w=400', 450),
(3, 'Dasar-Dasar Bioteknologi', 'Dr. Agus Hery Susanto, M.S.', 110000, 135000, 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&q=80&w=400', 300),
(4, 'Ekonomi Pembangunan Daerah', 'Prof. Wiwiek Rabiatul Adawiyah', 75000, 0, 'https://images.unsplash.com/photo-1611095966426-17b5f16805d7?auto=format&fit=crop&q=80&w=400', 150),
(5, 'Sosiologi Masyarakat Desa', 'Dr. Tyas Retno Wulan', 65000, 80000, 'https://images.unsplash.com/photo-1526958097901-5e6d742d3371?auto=format&fit=crop&q=80&w=400', 200),
(6, 'Kesehatan Masyarakat Pedesaan', 'Dr. dr. Eman Sutrisna, M.Kes.', 120000, 150000, 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&q=80&w=400', 500);

-- Table: authors
CREATE TABLE IF NOT EXISTS `authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `affiliation` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `authors` (`id`, `name`, `photo`, `affiliation`, `bio`) VALUES
(1, 'Prof. Dr. Ir. Suwarto, M.S.', 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=400&h=400&q=80', 'Guru Besar Ilmu Pertanian Tropis UNSOED', 'Pakar pertanian tropis dan agroteknologi dengan fokus pada pengembangan varietas unggul tahan perubahan iklim.'),
(2, 'Dr. Hibnu Nugroho, S.H., M.H.', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&h=400&q=80', 'Pakar Hukum & Dosen Fakultas Hukum UNSOED', 'Pakar hukum pidana dan acara pidana Indonesia yang aktif menulis berbagai buku referensi hukum modern.'),
(3, 'Dr. Agus Hery Susanto, M.S.', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&h=400&q=80', 'Ahli Biologi & Bioteknologi UNSOED', 'Peneliti di bidang bioteknologi molekuler dan genetika tumbuhan pada Fakultas Biologi UNSOED.'),
(4, 'Prof. Wiwiek Rabiatul Adawiyah', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&h=400&q=80', 'Guru Besar Ekonomi & Bisnis UNSOED', 'Dekan FEB UNSOED yang konsen dalam bidang manajemen pemasaran, kewirausahaan, dan ekonomi pembangunan daerah.'),
(5, 'Dr. Tyas Retno Wulan', 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=400&h=400&q=80', 'Sosiolog & Peneliti Masyarakat Desa UNSOED', 'Sosiolog FISIP UNSOED yang mengkaji pemberdayaan perempuan, sosiologi pedesaan, dan kajian gender.'),
(6, 'Dr. dr. Eman Sutrisna, M.Kes.', 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=400&h=400&q=80', 'Dosen Kedokteran & Kesehatan Masyarakat UNSOED', 'Dosen Fakultas Kedokteran UNSOED dengan spesialisasi kedokteran umum dan farmakologi medis.');

-- Table: users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Administrator', 'admin@unsoed.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'), -- password: password
(2, 'Mahasiswa', 'mahasiswa@mhs.unsoed.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer'); -- password: password

-- Table: password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(150) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qris_image` varchar(255) DEFAULT NULL,
  `bank_accounts` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `settings` (`id`, `qris_image`, `bank_accounts`) VALUES (1, NULL, 'BCA 1234567890 a.n Unsoed Press');

-- Table: orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','confirmed','rejected') NOT NULL DEFAULT 'pending',
  `payment_receipt` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`book_id`) REFERENCES `books`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: news
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` text DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: gallery_albums
CREATE TABLE IF NOT EXISTS `gallery_albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: gallery_photos
CREATE TABLE IF NOT EXISTS `gallery_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_url` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`album_id`) REFERENCES `gallery_albums`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: gallery_videos
CREATE TABLE IF NOT EXISTS `gallery_videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `youtube_url` text NOT NULL,
  `thumbnail_url` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: contact_messages
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


