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
(4, 'Arsitektur', 'arsitektur', 1),
(5, 'Biologi', 'biologi', 1),
(6, 'Fisika', 'fisika', 1),
(7, 'Teknik Kimia', 'teknik-kimia', 1),
(8, 'Hukum', 'hukum', 2),
(9, 'Ekonomi', 'ekonomi', 2),
(10, 'Sosial', 'sosial', 2),
(11, 'Kedokteran', 'kedokteran', 3),
(12, 'Keperawatan', 'keperawatan', 3),
(13, 'Pertanian', 'pertanian', 1);

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
