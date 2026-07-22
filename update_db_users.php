<?php
require_once 'config/database.php';

try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Cek kolom phone
    $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'phone'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE users ADD COLUMN phone VARCHAR(50) NULL AFTER role");
        echo "SUCCESS: Kolom 'phone' berhasil ditambahkan ke tabel users.\n";
    } else {
        echo "INFO: Kolom 'phone' sudah ada.\n";
    }

    // Cek kolom address
    $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'address'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE users ADD COLUMN address TEXT NULL AFTER phone");
        echo "SUCCESS: Kolom 'address' berhasil ditambahkan ke tabel users.\n";
    } else {
        echo "INFO: Kolom 'address' sudah ada.\n";
    }

    // Cek jumlah user
    $count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    echo "INFO: Total pengguna saat ini di database: $count\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
