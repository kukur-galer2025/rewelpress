<?php
require_once 'config/database.php';

try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Cek jumlah berita
    $stmt = $pdo->query("SELECT COUNT(*) FROM news");
    $count = $stmt->fetchColumn();

    // Jika berita masih sedikit (kurang dari 5), kita masukkan atau update dengan data persis UGM Press
    if ($count < 5) {
        $samples = [
            [
                'title' => 'DORONG MUTU PENDIDIKAN KEDOKTERAN, FK-KMK UGM KUPAS TUNTAS BUKU "PROGRAMMATIC ASSESSMENT" BERBASIS OBE',
                'slug' => 'dorong-mutu-pendidikan-kedokteran-fk-kmk-ugm-kupas-tuntas-buku-programmatic-assessment',
                'content' => '<p><strong>YOGYAKARTA</strong> — Dalam upaya merespons dinamika pendidikan tinggi saat ini, Fakultas Kedokteran, Kesehatan Masyarakat, dan Keperawatan (FK-KMK) Universitas Gadjah Mada (UGM) kembali menggelar diskusi akademik strategis. Bertempat di Auditorium Gedung Tahir Foundation pada Rabu (4/6/2026), FK-KMK UGM menyelenggarakan <em>talkshow</em> bedah buku yang menyoroti transformasi asesmen pendidikan kedokteran dalam kerangka <em>Outcome-Based Education</em> (OBE).</p>
<p>Acara ini secara khusus membedah karya terbaru dari Prof. dr. Mora Claramita, MHPE., Ph.D., Sp.KKLP beserta tim penulis. Menariknya, buku berukuran standar 15.5 x 23 cm ini tidak sekadar memaparkan teori, melainkan dirancang secara spesifik sebagai panduan operasional bagi institusi pendidikan kesehatan.</p>
<p>Untuk menggali isi buku secara mendalam, acara yang dipandu oleh dr. Rachmadya Nur Hidayah, M.Sc., Ph.D. ini menghadirkan dua pakar utama sebagai pembedah, yaitu:</p>
<p><strong>Prof. dr. Rr. Titi Savitri Prihatiningsih, MA, M.Med.Ed., Ph.D.</strong> (Pakar Kurikulum)<br><strong>Prof. dr. Eggi Arguni, M.Sc., Ph.D., Sp.A(K).</strong> (Pakar Pembelajaran Klinis)</p>
<h3 class="font-bold text-xl mt-6 mb-3">Tantangan Kurikulum Dan Evaluasi Berkelanjutan</h3>
<p>Wakil Dekan Bidang Akademik dan Kemahasiswaan FK-KMK UGM, dr. Ahmad Hamim Sadewa, Ph.D., menegaskan bahwa fakultasnya terus berkomitmen memelopori inovasi pendidikan. Ia menyoroti bahwa penerapan <em>Programmatic Assessment</em> pada kurikulum yang sudah mapan bukanlah proses yang instan.</p>
<p>"Membutuhkan pemahaman yang utuh terkait konsep, mekanisme, hingga tahap eksekusinya. Harapannya, inovasi asesmen ini dapat berdampak langsung pada peningkatan kualitas pendidikan kedokteran di Indonesia dari waktu ke waktu," jelas dr. Hamim.</p>
<p>Dukungan serupa disampaikan oleh Dr. I Wayan Mustika, S.T., M.Eng., Manajer UGM Press selaku penerbit. Menurutnya, penerapan kurikulum berbasis OBE di Indonesia saat ini berisiko kehilangan potensinya jika tidak dibarengi dengan sistem evaluasi yang mumpuni. Ia menyebut buku ini sebagai solusi komprehensif bagi institusi untuk melakukan perbaikan kurikulum yang berkesinambungan.</p>
<h3 class="font-bold text-xl mt-6 mb-3">Implementasi Dari Ruang Kuliah Hingga Rumah Sakit</h3>
<p>Dalam sesi pemaparan, Prof. Mora menguraikan lima elemen krusial dalam <em>Programmatic Assessment</em> yang menjadi tulang punggung bukunya. Diskusi kemudian diperkaya oleh tinjauan Prof. Titi yang membedah keunggulan sistem asesmen tersebut dari kacamata literatur pendidikan kedokteran dan integrasinya dengan OBE.</p>
<p>Sebagai pamungkas, Prof. Eggi membawa diskusi ke ranah yang lebih praktis, yakni bagaimana sistem evaluasi ini diterapkan di lapangan, khususnya terkait tantangan nyata di rumah sakit pendidikan dan rotasi klinis mahasiswa.</p>
<p>Kegiatan bedah buku ini bukan sekadar agenda rutin kampus, melainkan wujud kontribusi nyata FK-KMK UGM terhadap Tujuan Pembangunan Berkelanjutan (SDGs). Terutama pada pilar Pendidikan Berkualitas (SDG 4), Kehidupan Sehat dan Sejahtera (SDG 3) melalui proyeksi kualitas layanan kesehatan yang lebih baik, serta Kemitraan untuk Mencapai Tujuan (SDG 17) lewat kolaborasi apik antara akademisi, fakultas, dan penerbit.</p>',
                'image' => json_encode(['https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1000&q=80']),
                'created_at' => '2026-06-04 10:00:00'
            ],
            [
                'title' => 'FK-KMK UGM Menggelar Bedah Buku Prinsip-Prinsip Riset Implementasi Untuk Tekankan Komitmen Diseminasi',
                'slug' => 'fk-kmk-ugm-menggelar-bedah-buku-prinsip-prinsip-riset-implementasi',
                'content' => '<p>Fakultas Kedokteran, Kesehatan Masyarakat, dan Keperawatan UGM kembali menggelar forum akademik melalui kegiatan bedah buku bertajuk Prinsip-Prinsip Riset Implementasi pada Selasa (18/2). Agenda ini dilaksanakan secara bauran dengan partisipasi 76 peserta hadir langsung di Auditorium Lantai 1 Gedung Tahir Foundation FK-KMK UGM serta 69 peserta mengikuti secara daring melalui Zoom.</p><p>Riset implementasi memegang peranan sangat vital dalam menjembatani kesenjangan antara temuan ilmiah laboratorium dengan penerapan kebijakan kesehatan nyata di masyarakat.</p>',
                'image' => json_encode(['https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1000&q=80']),
                'created_at' => '2026-02-18 09:30:00'
            ],
            [
                'title' => 'Tutup 2025, Fikrul Hanif Sufyan Luncurkan Buku Fort De Kock Dan Depresi Ekonomi',
                'slug' => 'tutup-2025-fikrul-hanif-sufyan-luncurkan-buku-fort-de-kock',
                'content' => '<p>Padang — Menutup rangkaian kegiatan akhir tahun 2025, peneliti sekaligus dosen sejarah Fikrul Hanif Sufyan resmi meluncurkan buku terbarunya berjudul Fort de Kock dan Depresi Ekonomi pada Minggu malam (28/12/2025). Peluncuran buku ini digelar dalam Festival Akhir Tahun yang berlangsung di Toko Buku Steva, Padang, dan dirangkai dengan agenda bedah buku bersama para sejarawan nasional.</p>',
                'image' => json_encode(['https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&w=1000&q=80']),
                'created_at' => '2025-12-28 19:00:00'
            ],
            [
                'title' => 'GELARAN PESTA BUKU JOGJA 2025 BERLANGSUNG SANGAT MERIAH',
                'slug' => 'gelaran-pesta-buku-jogja-2025-berlangsung-sangat-meriah',
                'content' => '<p>UGM Press bekerja sama dengan IKAPI DIY dengan penuh semangat mengadakan event bazar buku supermeriah dan supermurah, yang bertempat di GIK UGM Zona D Art Gallery. Acara ini berlangsung pada 26 November hingga 09 Desember 2025, dan diikuti lebih dari 60 penerbit di Yogyakarta. Pesta Buku Jogja 2025 resmi dibuka dengan antusiasme tinggi dari ribuan pecinta literasi.</p>',
                'image' => json_encode(['https://images.unsplash.com/photo-1507842229356-51c615040f6f?auto=format&fit=crop&w=1000&q=80']),
                'created_at' => '2025-12-05 14:00:00'
            ],
            [
                'title' => 'MEP FEB UGM Luncurkan Buku Inovasi Berdampak Pada Pembangunan Ekonomi Berkelanjutan',
                'slug' => 'mep-feb-ugm-luncurkan-buku-inovasi-berdampak-ekonomi',
                'content' => '<p>Yogyakarta, 13 Juni 2025 — Program Studi Magister Ekonomika Pembangunan (MEP) FEB UGM sukses menyelenggarakan Seminar Nasional dalam rangka memperingati Dies Natalis ke-30, Jumat (13/6). Bertempat di kampus FEB UGM, seminar ini mengangkat tema "Mewujudkan Inovasi Berdampak pada Pembangunan Ekonomi Berkelanjutan" dan menjadi momen penting peluncuran buku terbaru karya dosen MEP.</p>',
                'image' => json_encode(['https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1000&q=80']),
                'created_at' => '2025-06-13 11:00:00'
            ]
        ];

        $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM news WHERE slug = ?");
        $stmtInsert = $pdo->prepare("INSERT INTO news (title, slug, content, image, created_at) VALUES (?, ?, ?, ?, ?)");

        foreach ($samples as $s) {
            $stmtCheck->execute([$s['slug']]);
            if ($stmtCheck->fetchColumn() == 0) {
                $stmtInsert->execute([$s['title'], $s['slug'], $s['content'], $s['image'], $s['created_at']]);
            }
        }
        echo "SUCCESS: Data sampel berita persis UGM Press (Event & Agenda) berhasil ditambahkan!\n";
    } else {
        echo "INFO: Data berita sudah tersedia di database.\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
