<?php
require_once 'config/database.php';

try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. Buat tabel gallery_albums
    $pdo->exec("CREATE TABLE IF NOT EXISTS gallery_albums (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 2. Buat tabel gallery_photos
    $pdo->exec("CREATE TABLE IF NOT EXISTS gallery_photos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        album_id INT NOT NULL,
        title VARCHAR(255) NOT NULL,
        image_url TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (album_id) REFERENCES gallery_albums(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 3. Buat tabel gallery_videos
    $pdo->exec("CREATE TABLE IF NOT EXISTS gallery_videos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        youtube_url TEXT NOT NULL,
        thumbnail_url TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // Cek apakah data album sudah ada
    $stmt = $pdo->query("SELECT COUNT(*) FROM gallery_albums");
    if ($stmt->fetchColumn() == 0) {
        // Insert sample albums persis seperti contoh UGM Press
        $albums = [
            ['Idul Fitri 1439 H', 'idul-fitri-1439-h'],
            ['Bazar Buku Online 2018', 'bazar-buku-online-2018'],
            ['Silaturahmi Manajer dan Koordinator ke Redaksi Tribun', 'silaturahmi-manajer-ke-redaksi-tribun'],
            ['Di Balik Lensa Kata', 'di-balik-lensa-kata'],
            ['Clearance Sale Pameran Buku', 'clearance-sale-pameran-buku'],
            ['Bedah Buku Mengembangkan Profesi Analisis Kebijakan', 'bedah-buku-profesi-analisis-kebijakan'],
            ['New Springer Nature co publishing agreements', 'springer-nature-co-publishing']
        ];

        $stmtInsertAlbum = $pdo->prepare("INSERT INTO gallery_albums (title, slug) VALUES (?, ?)");
        foreach ($albums as $alb) {
            $stmtInsertAlbum->execute($alb);
        }

        // Insert sample photos
        $photos = [
            // Album 1 (Idul Fitri - 2 photos)
            [1, 'Selamat Idul Fitri 1439 H Banner 1', 'https://images.unsplash.com/photo-1564507592333-c60657eea523?auto=format&fit=crop&w=600&q=80'],
            [1, 'Selamat Idul Fitri 1439 H Banner 2', 'https://images.unsplash.com/photo-1542816417-0983c9c9ad53?auto=format&fit=crop&w=600&q=80'],
            // Album 2 (Bazar Buku Online 2018 - 3 photos)
            [2, 'Bazar Buku Online Promo 70% Off', 'https://images.unsplash.com/photo-1507842229356-51c6150fe11c?auto=format&fit=crop&w=600&q=80'],
            [2, 'Vlog Competition Bazar Buku', 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=600&q=80'],
            [2, 'Bazar Buku Online April Promo', 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=600&q=80'],
            // Album 3 (Silaturahmi Tribun - 4 photos)
            [3, 'Wawancara Eksklusif Liputan Buku', 'https://images.unsplash.com/photo-1557804506-669a67965ba0?auto=format&fit=crop&w=600&q=80'],
            [3, 'Diskusi Redaksi Media & Penerbitan', 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=600&q=80'],
            [3, 'Foto Bersama Tim Redaksi', 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=600&q=80'],
            [3, 'Penyerahan Buku Cinderamata', 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=600&q=80'],
            // Album 4 (Di Balik Lensa Kata - 1 photo)
            [4, 'Suasana Pameran & Bedah Buku', 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=600&q=80'],
            // Album 5 (Clearance Sale - 4 photos)
            [5, 'Pengunjung Memilih Buku Clearance Sale 1', 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=600&q=80'],
            [5, 'Pengunjung Memilih Buku Clearance Sale 2', 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=600&q=80'],
            [5, 'Antusiasme Mahasiswa di Stand Buku 1', 'https://images.unsplash.com/photo-1568667256549-094345857637?auto=format&fit=crop&w=600&q=80'],
            [5, 'Antusiasme Mahasiswa di Stand Buku 2', 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80']
        ];

        $stmtInsertPhoto = $pdo->prepare("INSERT INTO gallery_photos (album_id, title, image_url) VALUES (?, ?, ?)");
        foreach ($photos as $pho) {
            $stmtInsertPhoto->execute($pho);
        }
    }

    // Cek apakah data video sudah ada
    $stmtVid = $pdo->query("SELECT COUNT(*) FROM gallery_videos");
    if ($stmtVid->fetchColumn() == 0) {
        // Insert sample videos persis seperti contoh UGM Press (input_file_2.png)
        $videos = [
            [
                'Cara Belanja Online di Unsoed Press',
                'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'Get Your Book Easier - Video Teaser',
                'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'Ayo Beli Buku Asli - Kampanye Literasi',
                'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'Nantikan Cuci Gudang Buku Lewat Online 8-22 Desember',
                'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'Mau Tau Penerbitan Akademik? Simak Alurnya',
                'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&w=600&q=80'
            ],
            [
                'Liputan Khusus Pameran Buku Nasional',
                'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'https://images.unsplash.com/photo-1507842229356-51c6150fe11c?auto=format&fit=crop&w=600&q=80'
            ]
        ];

        $stmtInsertVideo = $pdo->prepare("INSERT INTO gallery_videos (title, youtube_url, thumbnail_url) VALUES (?, ?, ?)");
        foreach ($videos as $vid) {
            $stmtInsertVideo->execute($vid);
        }
    }

    echo "SUCCESS: Tabel gallery_albums, gallery_photos, dan gallery_videos berhasil dibuat dan diisi data!\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
