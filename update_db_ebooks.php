<?php
require_once 'config/database.php';

try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Buat tabel ebooks
    $sql = "CREATE TABLE IF NOT EXISTS `ebooks` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `book_id` int(11) NULL,
      `title` varchar(255) NOT NULL,
      `file_pdf` varchar(255) NULL,
      `preview_pdf` varchar(255) NULL,
      `file_size` varchar(50) DEFAULT '15 MB',
      `page_count` int(11) DEFAULT 200,
      `ebook_price` decimal(12,2) DEFAULT 0.00,
      `is_free` tinyint(1) DEFAULT 0,
      `status` enum('active','inactive') DEFAULT 'active',
      `downloads_count` int(11) DEFAULT 0,
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `book_id` (`book_id`),
      CONSTRAINT `fk_ebooks_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $pdo->exec($sql);
    echo "SUCCESS: Tabel 'ebooks' berhasil dibuat atau sudah ada.\n";

    // Cek jumlah data di ebooks
    $count = $pdo->query("SELECT COUNT(*) FROM ebooks")->fetchColumn();
    if ($count == 0) {
        // Ambil beberapa buku dari tabel books untuk dijadikan e-book awal
        $books = $pdo->query("SELECT id, title, price FROM books LIMIT 4")->fetchAll(PDO::FETCH_ASSOC);
        
        $insert = $pdo->prepare("INSERT INTO ebooks (book_id, title, file_pdf, preview_pdf, file_size, page_count, ebook_price, is_free, status, downloads_count) VALUES (:book_id, :title, :file_pdf, :preview_pdf, :file_size, :page_count, :ebook_price, :is_free, 'active', :downloads)");
        
        $i = 1;
        foreach ($books as $b) {
            $hargaEbook = round($b['price'] * 0.7, -2);
            $isFree = ($i == 4) ? 1 : 0;
            if ($isFree) $hargaEbook = 0;

            $insert->execute([
                ':book_id' => $b['id'],
                ':title' => $b['title'] . ' (Edisi Digital)',
                ':file_pdf' => 'sample_ebook_' . $i . '.pdf',
                ':preview_pdf' => 'preview_bab1_' . $i . '.pdf',
                ':file_size' => (10 + $i*3) . '.5 MB',
                ':page_count' => (150 + $i*40),
                ':ebook_price' => $hargaEbook,
                ':is_free' => $isFree,
                ':downloads' => ($i * 12 + 5)
            ]);
            $i++;
        }
        echo "SUCCESS: Berhasil menambahkan $i data e-book awal sebagai sampel.\n";
    } else {
        echo "INFO: Tabel 'ebooks' sudah berisi $count data.\n";
    }

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
