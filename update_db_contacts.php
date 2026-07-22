<?php
require_once 'config/database.php';

try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Buat tabel contact_messages
    $pdo->exec("CREATE TABLE IF NOT EXISTS contact_messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        subject VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        is_read TINYINT(1) DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // Cek apakah data pesan sudah ada
    $stmt = $pdo->query("SELECT COUNT(*) FROM contact_messages");
    if ($stmt->fetchColumn() == 0) {
        $samples = [
            [
                'Dr. Budi Santoso, S.H., M.H.',
                'budi.santoso@unsoed.ac.id',
                'Pertanyaan Prosedur Penerbitan Buku Ajar Hukum',
                'Selamat pagi Tim Unsoed Press, saya dosen dari Fakultas Hukum bermaksud mengajukan naskah buku ajar untuk diproses penerbitannya dan ber-ISBN. Mohon informasi syarat lengkap dan estimasi waktu proses layout hingga cetak. Terima kasih.'
            ],
            [
                'Rina Wulandari (Mahasiswa Pertanian)',
                'rina.wulandari@mhs.unsoed.ac.id',
                'Ketersediaan Buku Budidaya Tanaman Organik',
                'Halo admin Unsoed Press, apakah buku Budidaya Tanaman Organik karya Prof. Suwarto tersedia di toko offline Grendeng? Saya butuh untuk referensi skripsi minggu ini.'
            ],
            [
                'Ahmad Fauzi (Perpustakaan Daerah)',
                'ahmad.fauzi@banyumaskab.go.id',
                'Kerjasama Pengadaan Koleksi Buku Lokal',
                'Yth. Pimpinan Unsoed Press, kami dari Dinas Kearsipan dan Perpustakaan Daerah Kabupaten Banyumas ingin menjalin kerjasama pengadaan koleksi terbitan lokal Unsoed Press untuk perpustakaan kami. Mohon dikirimkan katalog harga instansi terbaru.'
            ]
        ];

        $stmtInsert = $pdo->prepare("INSERT INTO contact_messages (full_name, email, subject, message, is_read, created_at) VALUES (?, ?, ?, ?, 0, NOW() - INTERVAL FLOOR(RAND()*48) HOUR)");
        foreach ($samples as $s) {
            $stmtInsert->execute($s);
        }
    }

    echo "SUCCESS: Tabel contact_messages berhasil dibuat dan diisi data sampel pesan kontak!\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
