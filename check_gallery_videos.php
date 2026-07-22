<?php
require_once 'config/database.php';

try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT COUNT(*) FROM gallery_videos");
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        $sampleVideos = [
            [
                'title' => 'Profil dan Layanan Unsoed Press - Badan Penerbit & Publikasi Universitas Jenderal Soedirman',
                'youtube_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=800&q=80'
            ],
            [
                'title' => 'Bedah Buku Akademik & Pameran Literasi Unsoed Press 2026',
                'youtube_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1507842229356-51c615040f6f?auto=format&fit=crop&w=800&q=80'
            ]
        ];

        $insert = $pdo->prepare("INSERT INTO gallery_videos (title, youtube_url, thumbnail_url) VALUES (?, ?, ?)");
        foreach ($sampleVideos as $v) {
            $insert->execute([$v['title'], $v['youtube_url'], $v['thumbnail_url']]);
        }
        echo "SUCCESS: $count video ditemukan di database. Ditambahkan sampel video default untuk pengujian.\n";
    } else {
        echo "INFO: Sudah ada $count video di database gallery_videos.\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
