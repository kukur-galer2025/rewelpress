<?php
require_once 'config/database.php';
require_once 'core/Database.php';

echo "Memulai migrasi tabel authors (Tokoh Penulis)...\n";

try {
    $db = new Database();

    // Buat tabel authors
    $queryCreateTable = "
    CREATE TABLE IF NOT EXISTS `authors` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(150) NOT NULL,
      `photo` varchar(255) DEFAULT NULL,
      `affiliation` varchar(255) DEFAULT NULL,
      `bio` text DEFAULT NULL,
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    $db->query($queryCreateTable);
    $db->execute();
    echo "Tabel 'authors' berhasil dibuat atau sudah ada.\n";

    // Cek apakah tabel authors masih kosong
    $db->query("SELECT COUNT(*) as count FROM authors");
    $result = $db->single();

    if ($result['count'] == 0) {
        echo "Mengisi data awal Tokoh Penulis Unsoed Press...\n";
        
        $initialAuthors = [
            [
                'name' => 'Prof. Dr. Ir. Suwarto, M.S.',
                'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=400&h=400&q=80',
                'affiliation' => 'Guru Besar Ilmu Pertanian Tropis UNSOED',
                'bio' => 'Pakar pertanian tropis dan agroteknologi dengan fokus pada pengembangan varietas unggul tahan perubahan iklim.'
            ],
            [
                'name' => 'Dr. Hibnu Nugroho, S.H., M.H.',
                'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&h=400&q=80',
                'affiliation' => 'Pakar Hukum & Dosen Fakultas Hukum UNSOED',
                'bio' => 'Pakar hukum pidana dan acara pidana Indonesia yang aktif menulis berbagai buku referensi hukum modern.'
            ],
            [
                'name' => 'Dr. Agus Hery Susanto, M.S.',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&h=400&q=80',
                'affiliation' => 'Ahli Biologi & Bioteknologi UNSOED',
                'bio' => 'Peneliti di bidang bioteknologi molekuler dan genetika tumbuhan pada Fakultas Biologi UNSOED.'
            ],
            [
                'name' => 'Prof. Wiwiek Rabiatul Adawiyah',
                'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&h=400&q=80',
                'affiliation' => 'Guru Besar Ekonomi & Bisnis UNSOED',
                'bio' => 'Dekan FEB UNSOED yang konsen dalam bidang manajemen pemasaran, kewirausahaan, dan ekonomi pembangunan daerah.'
            ],
            [
                'name' => 'Dr. Tyas Retno Wulan',
                'photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=400&h=400&q=80',
                'affiliation' => 'Sosiolog & Peneliti Masyarakat Desa UNSOED',
                'bio' => 'Sosiolog FISIP UNSOED yang mengkaji pemberdayaan perempuan, sosiologi pedesaan, dan kajian gender.'
            ],
            [
                'name' => 'Dr. dr. Eman Sutrisna, M.Kes.',
                'photo' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=400&h=400&q=80',
                'affiliation' => 'Dosen Kedokteran & Kesehatan Masyarakat UNSOED',
                'bio' => 'Dosen Fakultas Kedokteran UNSOED dengan spesialisasi kedokteran umum dan farmakologi medis.'
            ]
        ];

        foreach ($initialAuthors as $author) {
            $db->query("INSERT INTO authors (name, photo, affiliation, bio) VALUES (:name, :photo, :affiliation, :bio)");
            $db->bind(':name', $author['name']);
            $db->bind(':photo', $author['photo']);
            $db->bind(':affiliation', $author['affiliation']);
            $db->bind(':bio', $author['bio']);
            $db->execute();
        }
        echo "6 Tokoh Penulis awal berhasil ditambahkan ke database.\n";
    } else {
        echo "Tabel 'authors' sudah berisi " . $result['count'] . " data penulis.\n";
    }

    echo "Migrasi selesai dengan sukses!\n";
} catch (Exception $e) {
    echo "Gagal melakukan migrasi: " . $e->getMessage() . "\n";
}
