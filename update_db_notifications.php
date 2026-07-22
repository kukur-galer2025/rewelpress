<?php
require_once 'config/database.php';

try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Buat tabel notifications
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS notifications (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NULL DEFAULT 0 COMMENT '0/NULL untuk admin, >0 untuk user',
            title VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            link VARCHAR(255) NULL,
            is_read TINYINT(1) DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");

    echo "SUCCESS: Tabel notifications berhasil dibuat/diverifikasi.\n";

    // Cek apakah ada notifikasi
    $stmt = $pdo->query("SELECT COUNT(*) FROM notifications");
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        // Contoh notif untuk admin (user_id = 0)
        $pdo->exec("INSERT INTO notifications (user_id, title, message, link, is_read, created_at) VALUES 
        (0, 'Pesanan Baru #INV-1001', 'Pesanan baru masuk dari pengguna seharga Rp 125.000 menunggu konfirmasi.', '" . BASEURL . "/admin/orders', 0, NOW() - INTERVAL 2 HOUR),
        (0, 'Bukti Pembayaran Diunggah #INV-1001', 'Pelanggan telah mengunggah bukti transfer untuk pesanan #INV-1001.', '" . BASEURL . "/admin/orders', 0, NOW() - INTERVAL 1 HOUR)");

        // Contoh notif untuk user ID 1 (atau user lain yang mungkin ada)
        $pdo->exec("INSERT INTO notifications (user_id, title, message, link, is_read, created_at) VALUES 
        (1, 'Selamat Datang di Unsoed Press', 'Akun Anda berhasil didaftarkan. Nikmati kemudahan berbelanja buku akademik & publikasi ilmiah.', '" . BASEURL . "/profile', 1, NOW() - INTERVAL 1 DAY),
        (1, 'Pembayaran Diverifikasi!', 'Pembayaran untuk pesanan #INV-1001 telah diverifikasi oleh Admin. Pesanan segera diproses.', '" . BASEURL . "/book', 0, NOW() - INTERVAL 30 MINUTE)");

        echo "SUCCESS: Ditambahkan contoh notifikasi awal untuk Admin dan Pengguna.\n";
    } else {
        echo "INFO: Sudah ada $count notifikasi di database.\n";
    }

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
