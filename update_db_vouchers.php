<?php
require_once 'config/database.php';

try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== MEMULAI MIGRASI FITUR VOUCHER & PROMO ===\n";

    // 1. Buat tabel vouchers
    $sqlVouchers = "
    CREATE TABLE IF NOT EXISTS vouchers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        code VARCHAR(50) UNIQUE NOT NULL,
        title VARCHAR(150) NOT NULL,
        description TEXT,
        discount_type ENUM('percent', 'nominal') NOT NULL DEFAULT 'nominal',
        discount_value DECIMAL(12, 2) NOT NULL,
        min_purchase DECIMAL(12, 2) DEFAULT 0.00,
        max_discount DECIMAL(12, 2) DEFAULT NULL,
        applicable_to ENUM('all', 'book', 'ebook') NOT NULL DEFAULT 'all',
        quota INT DEFAULT 0,
        used_count INT DEFAULT 0,
        start_date DATETIME NULL,
        end_date DATETIME NULL,
        is_active TINYINT(1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $pdo->exec($sqlVouchers);
    echo "[OK] Tabel 'vouchers' berhasil dibuat/dicek.\n";

    // 2. Tambahkan kolom voucher_code & discount_amount ke tabel orders jika belum ada
    $orderColumns = [
        'voucher_code' => "ALTER TABLE orders ADD COLUMN voucher_code VARCHAR(50) NULL AFTER total_amount",
        'discount_amount' => "ALTER TABLE orders ADD COLUMN discount_amount DECIMAL(12,2) DEFAULT 0.00 AFTER voucher_code"
    ];

    foreach ($orderColumns as $col => $sql) {
        $check = $pdo->query("SHOW COLUMNS FROM orders LIKE '$col'");
        if ($check->rowCount() == 0) {
            $pdo->exec($sql);
            echo "[OK] Kolom '$col' berhasil ditambahkan ke tabel orders.\n";
        } else {
            echo "[INFO] Kolom '$col' sudah ada di tabel orders.\n";
        }
    }

    // 3. Tambahkan kolom voucher_code & discount_amount ke tabel ebook_orders jika belum ada
    $ebookOrderColumns = [
        'voucher_code' => "ALTER TABLE ebook_orders ADD COLUMN voucher_code VARCHAR(50) NULL AFTER amount",
        'discount_amount' => "ALTER TABLE ebook_orders ADD COLUMN discount_amount DECIMAL(12,2) DEFAULT 0.00 AFTER voucher_code"
    ];

    foreach ($ebookOrderColumns as $col => $sql) {
        $check = $pdo->query("SHOW COLUMNS FROM ebook_orders LIKE '$col'");
        if ($check->rowCount() == 0) {
            $pdo->exec($sql);
            echo "[OK] Kolom '$col' berhasil ditambahkan ke tabel ebook_orders.\n";
        } else {
            echo "[INFO] Kolom '$col' sudah ada di tabel ebook_orders.\n";
        }
    }

    // 4. Seed contoh voucher aktif jika tabel masih kosong
    $count = $pdo->query("SELECT COUNT(*) FROM vouchers")->fetchColumn();
    if ($count == 0) {
        $seedSql = "
        INSERT INTO vouchers (code, title, description, discount_type, discount_value, min_purchase, max_discount, applicable_to, quota, is_active, start_date, end_date) VALUES
        ('UNSOED2026', 'Diskon Grand Launching Unsoed Press', 'Potongan Rp 15.000 untuk pembelian semua produk (buku fisik maupun e-book).', 'nominal', 15000.00, 20000.00, NULL, 'all', 100, 1, '2026-01-01 00:00:00', '2026-12-31 23:59:59'),
        ('EBOOKHEMAT', 'Diskon Spesial Publikasi Digital (E-Book)', 'Diskon 25% khusus untuk pembelian semua e-book digital tanpa minimum transaksi.', 'percent', 25.00, 0.00, 50000.00, 'ebook', 200, 1, '2026-01-01 00:00:00', '2026-12-31 23:59:59'),
        ('BUKUCETAK', 'Potongan Pengiriman & Belanja Buku Fisik', 'Potongan Rp 20.000 untuk setiap pembelian buku fisik cetak dengan minimum transaksi Rp 75.000.', 'nominal', 20000.00, 75000.00, NULL, 'book', 50, 1, '2026-01-01 00:00:00', '2026-12-31 23:59:59');
        ";
        $pdo->exec($seedSql);
        echo "[OK] 3 Contoh voucher default berhasil ditambahkan (UNSOED2026, EBOOKHEMAT, BUKUCETAK).\n";
    } else {
        echo "[INFO] Tabel vouchers sudah berisi data ($count voucher).\n";
    }

    echo "=== MIGRASI FITUR VOUCHER SELESAI DENGAN SUKSES ===\n";

} catch (PDOException $e) {
    echo "[ERROR] Migrasi gagal: " . $e->getMessage() . "\n";
}
