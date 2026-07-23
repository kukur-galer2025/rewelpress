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
            <div class="rounded-3xl overflow-hidden shadow-2xl border border-gray-200 aspect-[3/4] bg-gray-100 relative group cursor-pointer">
                <img src="<?= esc($coverSrc) ?>" alt="<?= htmlspecialchars($e['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <?php if($isFree): ?>
                    <div class="absolute top-4 left-4 z-10 bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-extrabold px-4 py-1.5 rounded-full shadow-lg uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fas fa-gift"></i> Gratis
                    </div>
                <?php else: ?>
                    <div class="absolute top-4 left-4 z-10 bg-gradient-to-r from-unsoed-blue to-blue-600 text-white text-xs font-extrabold px-4 py-1.5 rounded-full shadow-lg uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fas fa-file-pdf"></i> PDF E-Book
                    </div>
                <?php endif; ?>
                
                <!-- Quick Look Button on Hover -->
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 pointer-events-none">
                    <?php if(!empty($e['preview_pdf'])): ?>
                    <span class="bg-white/90 backdrop-blur-sm text-unsoed-darkblue font-bold px-5 py-2.5 rounded-full shadow-2xl flex items-center gap-2 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 pointer-events-auto">
                        <i class="fas fa-book-open text-unsoed-yellow"></i> Lihat Sampel
                    </span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Spesifikasi File -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm space-y-4 hover:shadow-md transition-shadow">
                <h4 class="font-bold text-gray-800 text-xs uppercase tracking-widest border-b border-gray-100 pb-3 flex items-center gap-2">
                    <i class="fas fa-info-circle text-unsoed-blue"></i> Spesifikasi File
                </h4>
                <div class="space-y-1 text-sm">
                    <div class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <span class="text-gray-500 flex items-center gap-2"><i class="fas fa-file-pdf text-red-400 w-4"></i> Format</span>
                        <span class="font-bold text-gray-800 bg-gray-100 px-2 py-0.5 rounded-md text-[11px]">PDF</span>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <span class="text-gray-500 flex items-center gap-2"><i class="fas fa-hdd text-blue-400 w-4"></i> Ukuran</span>
                        <span class="font-bold text-gray-800 bg-blue-50 text-blue-700 px-2 py-0.5 rounded-md text-[11px]"><?= htmlspecialchars($e['file_size'] ?? '–') ?></span>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <span class="text-gray-500 flex items-center gap-2"><i class="fas fa-book-open text-green-500 w-4"></i> Halaman</span>
                        <span class="font-bold text-gray-800"><?= ($e['page_count'] ?? '–') ?> Hal</span>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <span class="text-gray-500 flex items-center gap-2"><i class="fas fa-cloud-download-alt text-purple-400 w-4"></i> Diunduh</span>
                        <span class="font-bold text-gray-800"><?= number_format($e['downloads_count'] ?? 0) ?> Kali</span>
                    </div>
                    <div class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <span class="text-gray-500 flex items-center gap-2"><i class="fas fa-eye text-indigo-400 w-4"></i> Dilihat</span>
                        <span class="font-bold text-gray-800"><?= number_format($e['views_count'] ?? 0) ?> Kali</span>
                    </div>
                    <?php if(!empty($e['isbn'])): ?>
                    <div class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 transition-colors mt-2 border-t border-dashed border-gray-200 pt-3">
                        <span class="text-gray-500 flex items-center gap-2"><i class="fas fa-barcode text-gray-400 w-4"></i> ISBN</span>
                        <span class="font-bold text-gray-800 text-xs font-mono tracking-wider"><?= htmlspecialchars($e['isbn']) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Detail + Aksi -->
        <div class="md:col-span-2 space-y-6">

            <!-- Judul & Penulis -->
            <div>
                <span class="text-[10px] font-bold uppercase tracking-widest text-unsoed-blue bg-unsoed-blue/5 px-3 py-1.5 rounded-full border border-unsoed-blue/10 flex inline-flex items-center gap-1.5 w-fit">
                    <i class="fas fa-laptop-code"></i> Publikasi Digital · Unsoed Press
                </span>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-5 leading-tight">
                    <?= htmlspecialchars($e['title']) ?>
                </h1>
                <?php if(!empty($e['book_author'])): ?>
                <div class="mt-4 flex items-start gap-2 text-gray-600 bg-gray-50 p-3 rounded-xl border border-gray-100 inline-flex max-w-full">
                    <i class="fas fa-user-edit text-unsoed-blue text-sm mt-0.5 shrink-0"></i>
                    <div class="flex flex-col">
                        <span class="text-xs text-gray-400 uppercase tracking-widest font-bold mb-0.5">Penulis</span>
                        <span class="font-medium text-gray-800 leading-relaxed"><?= htmlspecialchars(str_replace(';', ', ', $e['book_author'])) ?></span>
                    </div>
                </div>
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

            <!-- Ulasan Produk -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-serif font-bold text-gray-900 border-l-4 border-unsoed-yellow pl-4">Ulasan Pembeli</h3>
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-bold text-gray-900"><?= number_format($e['avg_rating'] ?? 0, 1) ?></span>
                        <div class="text-unsoed-yellow text-xl">
                            <?php
                            $rating = round($e['avg_rating'] ?? 0);
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $rating) echo '<i class="fas fa-star"></i>';
                                else echo '<i class="far fa-star"></i>';
                            }
                            ?>
                        </div>
                        <span class="text-gray-500 ml-2">(<?= $e['review_count'] ?? 0 ?> ulasan)</span>
                    </div>
                </div>

                <?php if (isset($_SESSION['flash_success'])): ?>
                    <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-200 flex items-center gap-3">
                        <i class="fas fa-check-circle"></i> <?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['flash_error'])): ?>
                    <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200 flex items-center gap-3">
                        <i class="fas fa-exclamation-circle"></i> <?= $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?>
                    </div>
                <?php endif; ?>

                <div class="mb-8">
                    <?php if (isset($data['can_review']) && $data['can_review']['can_review']): ?>
                        <button onclick="document.getElementById('reviewModal').classList.remove('hidden')" class="btn-primary flex items-center gap-2">
                            <i class="fas fa-edit"></i> Tulis Ulasan
                        </button>
                    <?php else: ?>
                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-600 flex items-start gap-3">
                            <i class="fas fa-info-circle text-unsoed-blue mt-0.5"></i>
                            <p>Anda hanya dapat memberikan ulasan pada produk yang telah Anda beli dan pesanan telah selesai.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="space-y-6">
                    <?php if (empty($data['reviews'])): ?>
                        <p class="text-gray-500 italic text-center py-8">Belum ada ulasan untuk produk ini.</p>
                    <?php else: ?>
                        <?php foreach ($data['reviews'] as $rev): ?>
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex gap-4">
                                <div class="w-12 h-12 rounded-full bg-unsoed-blue text-white flex items-center justify-center font-bold text-xl shrink-0">
                                    <?= strtoupper(substr(htmlspecialchars($rev['user_name']), 0, 1)) ?>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h4 class="font-bold text-gray-900"><?= htmlspecialchars($rev['user_name']) ?></h4>
                                            <span class="text-xs text-gray-500"><?= date('d M Y', strtotime($rev['created_at'])) ?></span>
                                        </div>
                                        <div class="text-unsoed-yellow text-sm">
                                            <?php
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $rev['rating']) echo '<i class="fas fa-star"></i>';
                                                else echo '<i class="far fa-star"></i>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 leading-relaxed"><?= nl2br(htmlspecialchars($rev['comment'])) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Review Modal -->
<div id="reviewModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden transform transition-all">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900">Tulis Ulasan</h3>
            <button type="button" onclick="document.getElementById('reviewModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-6">
            <form action="<?= BASEURL; ?>/review/submit" method="POST" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                <input type="hidden" name="item_type" value="ebook">
                <input type="hidden" name="item_id" value="<?= $e['id'] ?>">
                <input type="hidden" name="slug" value="<?= htmlspecialchars($e['slug'] ?? '') ?>">
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Penilaian Anda</label>
                    <select name="rating" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-unsoed-blue/20 outline-none">
                        <option value="5">5 Bintang - Sangat Bagus</option>
                        <option value="4">4 Bintang - Bagus</option>
                        <option value="3">3 Bintang - Cukup</option>
                        <option value="2">2 Bintang - Kurang</option>
                        <option value="1">1 Bintang - Sangat Kurang</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ulasan</label>
                    <textarea name="comment" rows="4" placeholder="Bagaimana pendapat Anda tentang ebook ini?" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-unsoed-blue/20 outline-none resize-none"></textarea>
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="document.getElementById('reviewModal').classList.add('hidden')" class="w-1/2 py-3 px-4 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition text-center">Batal</button>
                    <button type="submit" class="w-1/2 btn-primary py-3 text-center">Kirim Ulasan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (sessionStorage.getItem('openReviewModal') === '1') {
            sessionStorage.removeItem('openReviewModal');
            <?php if (isset($data['can_review']) && $data['can_review']['can_review']): ?>
                document.getElementById('reviewModal').classList.remove('hidden');
                setTimeout(() => {
                    document.getElementById('reviewModal').scrollIntoView({ behavior: 'smooth' });
                }, 100);
            <?php endif; ?>
        }
    });
</script>
