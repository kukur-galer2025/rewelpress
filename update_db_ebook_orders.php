<?php
require_once 'config/database.php';

try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE TABLE IF NOT EXISTS `ebook_orders` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `user_id` int(11) NOT NULL,
      `ebook_id` int(11) NOT NULL,
      `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
      `status` enum('pending','paid','confirmed','rejected') NOT NULL DEFAULT 'pending',
      `payment_receipt` varchar(500) DEFAULT NULL,
      `note` text DEFAULT NULL,
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `user_id` (`user_id`),
      KEY `ebook_id` (`ebook_id`),
      CONSTRAINT `fk_ebook_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
      CONSTRAINT `fk_ebook_orders_ebook` FOREIGN KEY (`ebook_id`) REFERENCES `ebooks` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $pdo->exec($sql);
    echo "SUCCESS: Tabel 'ebook_orders' berhasil dibuat.\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
