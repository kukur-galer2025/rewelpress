<?php
$e        = $data['ebook'];
$isFree   = ($e['is_free'] == 1 || floatval($e['ebook_price']) == 0);
$hasAccess    = $data['has_access'];
$userLoggedIn = $data['user_logged_in'];
$existingOrder = $data['existing_order']; // order pending/paid yang sudah ada

$coverSrc = 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80';
if (!empty($e['cover_image'])) {
    $coverSrc = (strpos($e['cover_image'], 'http') === 0)
        ? $e['cover_image']
        : BASEURL . '/uploads/covers/' . $e['cover_image'];
}
?>

<!-- Breadcrumb -->
<div class="bg-[#f3f4f6] border-b border-gray-200 py-5">
    <div class="container mx-auto px-4 max-w-[1200px] flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wider flex-wrap">
        <a href="<?= BASEURL ?>" class="hover:text-unsoed-blue transition">Home</a>
        <span>/</span>
        <a href="<?= BASEURL ?>/ebook" class="hover:text-unsoed-blue transition">E-Book</a>
        <span>/</span>
        <span class="text-gray-700 font-bold truncate max-w-xs"><?= htmlspecialchars($e['title']) ?></span>
    </div>
</div>

<div class="container mx-auto px-4 max-w-[1100px] py-12">

    <!-- Flash Messages -->
    <?php if(isset($_GET['msg'])): ?>
        <?php
        $msgMap = [
            'need_purchase'     => ['bg-red-50 border-red-200 text-red-700',    'fas fa-lock',         'Anda belum memiliki akses. Silakan beli dan tunggu verifikasi admin.'],
            'file_not_ready'    => ['bg-yellow-50 border-yellow-300 text-yellow-800', 'fas fa-clock', 'File e-book sedang disiapkan oleh admin. Coba lagi nanti.'],
            'already_confirmed' => ['bg-green-50 border-green-200 text-green-700', 'fas fa-check-circle', 'Pembayaran Anda sudah terverifikasi. Silakan unduh e-book di bawah!'],
            'order_error'       => ['bg-red-50 border-red-200 text-red-700',    'fas fa-exclamation-circle', 'Gagal membuat pesanan. Silakan coba lagi.'],
        ];
        $m = $_GET['msg'];
        if (isset($msgMap[$m])): [$cls, $icon, $text] = $msgMap[$m]; ?>
        <div class="mb-8 rounded-2xl border p-4 flex items-center gap-3 text-sm font-semibold <?= esc($cls) ?>">
            <i class="<?= esc($icon) ?> text-lg flex-shrink-0"></i>
            <span><?= esc($text) ?></span>
        </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 items-start">

        <!-- Kolom Kiri: Cover + Spesifikasi -->
        <div class="md:col-span-1 flex flex-col gap-5">
            <div class="rounded-3xl overflow-hidden shadow-2xl border border-gray-200 aspect-[3/4] bg-gray-100 relative">
                <img src="<?= esc($coverSrc) ?>" alt="<?= htmlspecialchars($e['title']) ?>" class="w-full h-full object-cover">
                <?php if($isFree): ?>
                    <div class="absolute top-4 left-4 bg-green-500 text-white text-xs font-extrabold px-3 py-1 rounded-full shadow uppercase">
                        <i class="fas fa-gift mr-1"></i> Gratis
                    </div>
                <?php else: ?>
                    <div class="absolute top-4 left-4 bg-unsoed-blue text-white text-xs font-extrabold px-3 py-1 rounded-full shadow uppercase">
                        <i class="fas fa-file-pdf mr-1"></i> PDF E-Book
                    </div>
                <?php endif; ?>
            </div>

            <!-- Spesifikasi File -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm space-y-3">
                <h4 class="font-bold text-gray-700 text-xs uppercase tracking-wider border-b border-gray-100 pb-2">Spesifikasi File</h4>
                <div class="space-y-2.5 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500 flex items-center gap-2"><i class="fas fa-file-pdf text-red-400 w-4"></i> Format</span>
                        <span class="font-bold text-gray-800">PDF</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500 flex items-center gap-2"><i class="fas fa-hdd text-blue-400 w-4"></i> Ukuran</span>
                        <span class="font-bold text-gray-800"><?= htmlspecialchars($e['file_size'] ?? '–') ?></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500 flex items-center gap-2"><i class="fas fa-book-open text-green-500 w-4"></i> Halaman</span>
                        <span class="font-bold text-gray-800"><?= ($e['page_count'] ?? '–') ?> Hal</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500 flex items-center gap-2"><i class="fas fa-cloud-download-alt text-purple-400 w-4"></i> Diunduh</span>
                        <span class="font-bold text-gray-800"><?= number_format($e['downloads_count'] ?? 0) ?> Kali</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500 flex items-center gap-2"><i class="fas fa-eye text-indigo-400 w-4"></i> Dilihat</span>
                        <span class="font-bold text-gray-800"><?= number_format($e['views_count'] ?? 0) ?> Kali</span>
                    </div>
                    <?php if(!empty($e['isbn'])): ?>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500 flex items-center gap-2"><i class="fas fa-barcode text-gray-400 w-4"></i> ISBN</span>
                        <span class="font-bold text-gray-800 text-xs font-mono"><?= htmlspecialchars($e['isbn']) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Detail + Aksi -->
        <div class="md:col-span-2 space-y-6">

            <!-- Judul & Penulis -->
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-unsoed-blue bg-blue-50 px-3 py-1 rounded-full border border-blue-100">
                    Publikasi Digital · Unsoed Press
                </span>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mt-4 leading-snug">
                    <?= htmlspecialchars($e['title']) ?>
                </h1>
                <?php if(!empty($e['book_author'])): ?>
                <p class="text-base text-gray-600 mt-2 flex items-center gap-2">
                    <i class="fas fa-user-edit text-unsoed-blue text-sm"></i>
                    <span class="font-semibold"><?= htmlspecialchars($e['book_author']) ?></span>
                </p>
                <?php endif; ?>

                <?php if(!empty($e['book_id'])): ?>
                <div class="mt-4">
                    <a href="<?= BASEURL ?>/book/detail/<?= esc($e['book_slug'] ?? $e['book_id']) ?>" class="inline-flex items-center gap-2 text-sm font-semibold bg-indigo-50 text-indigo-700 px-4 py-2 rounded-xl hover:bg-indigo-100 transition-colors border border-indigo-200 shadow-sm">
                        <i class="fas fa-book"></i>
                        Tersedia Edisi Cetak (Buku Fisik) &rarr;
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <!-- Harga -->
            <div class="bg-gradient-to-br from-gray-50 to-white rounded-3xl p-6 border border-gray-200 shadow-sm">
                <?php if($isFree): ?>
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Harga</p>
                    <p class="text-3xl font-extrabold text-green-600 mt-1">GRATIS</p>
                    <p class="text-xs text-gray-400 mt-1">Open Access — Tidak memerlukan pembayaran</p>
                <?php else: ?>
                    <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Harga E-Book</p>
                    <p class="text-3xl font-extrabold text-unsoed-blue mt-1">
                        Rp <?= number_format($e['ebook_price'], 0, ',', '.') ?>
                    </p>
                    <?php if(!empty($e['normal_price']) && $e['normal_price'] > $e['ebook_price']): ?>
                        <p class="text-sm text-gray-400 line-through mt-0.5">Rp <?= number_format($e['normal_price'], 0, ',', '.') ?></p>
                        <span class="text-xs font-bold bg-red-100 text-red-600 px-2 py-0.5 rounded-full">
                            Hemat <?= round((1 - $e['ebook_price']/$e['normal_price']) * 100) ?>%
                        </span>
                    <?php endif; ?>

                    <!-- Status akses -->
                    <?php if($hasAccess): ?>
                    <div class="mt-4 flex items-center gap-3 bg-green-50 border border-green-200 rounded-2xl px-5 py-4">
                        <i class="fas fa-check-circle text-green-600 text-2xl flex-shrink-0"></i>
                        <div>
                            <p class="font-bold text-green-800 text-sm">Pembayaran Terverifikasi — E-Book Dimiliki!</p>
                            <p class="text-xs text-green-600 mt-0.5">Sesuai prosedur profesional, file PDF e-book dikelola dan diunduh langsung melalui halaman <strong>Riwayat Pesanan</strong>.</p>
                        </div>
                    </div>
                    <?php elseif($existingOrder): ?>
                        <?php if($existingOrder['status'] === 'paid'): ?>
                        <div class="mt-4 flex items-center gap-2 bg-yellow-50 border border-yellow-300 rounded-2xl px-4 py-3">
                            <i class="fas fa-clock text-yellow-500 text-lg"></i>
                            <div>
                                <p class="font-bold text-yellow-700 text-sm">Menunggu Verifikasi Admin</p>
                                <p class="text-xs text-yellow-600">Bukti bayar sudah diunggah. Admin sedang memproses verifikasi Anda.</p>
                            </div>
                        </div>
                        <?php elseif($existingOrder['status'] === 'pending'): ?>
                        <div class="mt-4 flex items-center gap-2 bg-blue-50 border border-blue-200 rounded-2xl px-4 py-3">
                            <i class="fas fa-info-circle text-blue-500 text-lg"></i>
                            <div>
                                <p class="font-bold text-blue-700 text-sm">Pesanan Menunggu Pembayaran</p>
                                <p class="text-xs text-blue-600">Pesanan #EBO-<?= esc($existingOrder['id']) ?> sudah dibuat, silakan selesaikan pembayaran.</p>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- ===== TOMBOL AKSI UTAMA ===== -->
            <div class="flex flex-col sm:flex-row gap-3">

                <?php if($isFree): ?>
                    <!-- GRATIS: langsung unduh -->
                    <a href="<?= BASEURL ?>/ebook/download/<?= esc($e['id']) ?>"
                       class="flex-1 py-4 bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 text-white rounded-2xl font-bold text-center transition shadow-lg flex items-center justify-center gap-2">
                        <i class="fas fa-cloud-download-alt text-xl"></i> Unduh Gratis Sekarang
                    </a>

                <?php elseif($hasAccess): ?>
                    <!-- BERBAYAR + TERVERIFIKASI: arahkan ke halaman Pesanan -->
                    <a href="<?= BASEURL ?>/order"
                       class="flex-1 py-4 bg-gradient-to-r from-unsoed-blue to-blue-700 hover:from-blue-800 hover:to-blue-900 text-white rounded-2xl font-bold text-center transition shadow-lg flex items-center justify-center gap-2">
                        <i class="fas fa-shopping-bag text-xl"></i> Buka Pesanan Saya & Unduh E-Book
                    </a>

                <?php elseif($existingOrder && $existingOrder['status'] === 'pending'): ?>
                    <!-- ADA ORDER PENDING: tombol selesaikan pembayaran -->
                    <a href="<?= BASEURL ?>/ebook/pay/<?= esc($existingOrder['id']) ?>"
                       class="flex-1 py-4 bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white rounded-2xl font-bold text-center transition shadow-lg flex items-center justify-center gap-2">
                        <i class="fas fa-credit-card text-xl"></i> Selesaikan Pembayaran — #EBO-<?= esc($existingOrder['id']) ?>
                    </a>

                <?php elseif($existingOrder && $existingOrder['status'] === 'paid'): ?>
                    <!-- ORDER SUDAH BAYAR: tunggu verifikasi -->
                    <a href="<?= BASEURL ?>/order"
                       class="flex-1 py-4 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-2xl font-bold text-center transition flex items-center justify-center gap-2">
                        <i class="fas fa-hourglass-half text-xl text-yellow-600"></i> Cek Status di Pesanan Saya
                    </a>

                <?php elseif(!$userLoggedIn): ?>
                    <!-- BELUM LOGIN -->
                    <a href="<?= BASEURL ?>/auth/login"
                       class="flex-1 py-4 bg-gradient-to-r from-unsoed-blue to-blue-700 hover:from-blue-800 hover:to-blue-900 text-white rounded-2xl font-bold text-center transition shadow-lg flex items-center justify-center gap-2">
                        <i class="fas fa-sign-in-alt text-xl"></i> Login untuk Membeli E-Book
                    </a>

                <?php else: ?>
                    <!-- LOGIN + BELUM BELI: tombol beli sekarang menuju checkout -->
                    <a href="<?= BASEURL ?>/ebook/checkout/<?= esc($e['id']) ?>"
                       class="flex-1 py-4 bg-gradient-to-r from-unsoed-blue to-blue-700 hover:from-blue-800 hover:to-blue-900 text-white rounded-2xl font-bold text-center transition shadow-lg flex items-center justify-center gap-2">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        Beli E-Book — Rp <?= number_format($e['ebook_price'], 0, ',', '.') ?>
                    </a>
                <?php endif; ?>

                <!-- Tombol Pratinjau Sampel (jika ada file preview) -->
                <?php if(!empty($e['preview_pdf'])): ?>
                    <?php
                        $rootPath = dirname(dirname(dirname(__FILE__)));
                        $previewPath = $rootPath . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'ebooks' . DIRECTORY_SEPARATOR . $e['preview_pdf'];
                    ?>
                    <?php if(file_exists($previewPath)): ?>
                    <a href="<?= BASEURL ?>/assets/uploads/ebooks/<?= htmlspecialchars($e['preview_pdf']) ?>" target="_blank"
                       class="px-6 py-4 border-2 border-gray-300 hover:border-unsoed-blue text-gray-700 hover:text-unsoed-blue rounded-2xl font-bold text-center transition flex items-center justify-center gap-2 whitespace-nowrap">
                        <i class="fas fa-eye"></i> Baca Sampel
                    </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- Panduan Pembelian (hanya jika belum punya akses & belum ada order) -->
            <?php if(!$isFree && !$hasAccess && !$existingOrder): ?>
            <div class="bg-blue-50/70 rounded-2xl border border-blue-100 p-5 space-y-3">
                <h4 class="font-bold text-gray-800 flex items-center gap-2 text-sm">
                    <i class="fas fa-info-circle text-unsoed-blue"></i> Cara Mendapatkan Akses E-Book
                </h4>
                <ol class="space-y-2.5 text-sm text-gray-600 pl-1">
                    <li class="flex items-start gap-3">
                        <span class="w-5 h-5 rounded-full bg-unsoed-blue text-white text-[10px] font-bold flex items-center justify-center flex-shrink-0 mt-0.5">1</span>
                        Klik <strong>"Beli E-Book"</strong> di atas. Sistem akan membuat pesanan untuk Anda.
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="w-5 h-5 rounded-full bg-unsoed-blue text-white text-[10px] font-bold flex items-center justify-center flex-shrink-0 mt-0.5">2</span>
                        Lakukan transfer ke rekening yang tertera, lalu <strong>unggah bukti pembayaran</strong>.
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="w-5 h-5 rounded-full bg-green-600 text-white text-[10px] font-bold flex items-center justify-center flex-shrink-0 mt-0.5">3</span>
                        Setelah admin <strong>memverifikasi pembayaran</strong>, tombol unduhan PDF otomatis aktif di menu <strong>Riwayat Pesanan</strong> Anda.
                    </li>
                </ol>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>
