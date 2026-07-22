<!-- Header Title Banner -->
<div class="bg-[#f3f4f6] border-b border-gray-200 py-8">
    <div class="container mx-auto px-4 max-w-[1200px] flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h1 class="text-3xl md:text-4xl font-serif font-light text-gray-600 uppercase tracking-wide">E-BOOK & DIGITAL PUBLICATION</h1>
        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-2">
            <a href="<?= BASEURL; ?>" class="hover:text-unsoed-blue transition">HOME</a>
            <span>/</span>
            <span class="text-gray-700 font-bold">E-BOOK</span>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 max-w-[1200px] py-14 space-y-16">

    <?php if(isset($_GET['msg'])): ?>
        <div class="rounded-2xl border p-4 flex items-center gap-3 font-semibold text-sm shadow-sm
            <?= $_GET['msg'] == 'file_not_ready' ? 'bg-yellow-50 border-yellow-300 text-yellow-800' : '' ?>
            <?= $_GET['msg'] == 'not_free' ? 'bg-red-50 border-red-300 text-red-700' : '' ?>
            <?= $_GET['msg'] == 'download_success' ? 'bg-green-50 border-green-300 text-green-700' : '' ?>
        ">
            <?php if($_GET['msg'] == 'file_not_ready'): ?>
                <i class="fas fa-clock text-yellow-500 text-lg flex-shrink-0"></i>
                <span>File e-book ini sedang disiapkan oleh admin. Silakan coba beberapa saat lagi atau hubungi kami melalui WhatsApp.</span>
            <?php elseif($_GET['msg'] == 'not_free'): ?>
                <i class="fas fa-lock text-red-500 text-lg flex-shrink-0"></i>
                <span>E-Book ini bukan versi gratis. Silakan lakukan pembelian terlebih dahulu untuk mendapatkan akses unduhan.</span>
            <?php elseif($_GET['msg'] == 'download_success'): ?>
                <i class="fas fa-check-circle text-green-500 text-lg flex-shrink-0"></i>
                <span>Terima kasih! Unduhan Anda sedang diproses.</span>
            <?php endif; ?>
        </div>
    <?php endif; ?>


    <!-- Hero / Intro Ebook -->
    <div class="bg-gradient-to-r from-[#0f3460] via-blue-900 to-indigo-900 rounded-3xl p-8 md:p-12 text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8">
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-unsoed-yellow/10 rounded-full blur-3xl"></div>
        <div class="space-y-4 max-w-xl relative z-10">
            <div class="inline-block px-3.5 py-1.5 bg-white/10 backdrop-blur-md rounded-full text-unsoed-yellow font-bold text-xs tracking-wider uppercase border border-white/10">
                <i class="fas fa-tablet-alt mr-1"></i> Perpustakaan Digital Masa Kini
            </div>
            <h2 class="text-3xl md:text-4xl font-serif font-bold leading-tight">
                Akses Ilmu Pengetahuan <span class="text-unsoed-yellow">Kapan Saja & Di Mana Saja</span>
            </h2>
            <p class="text-sm md:text-base text-blue-100 leading-relaxed">
                Nikmati kemudahan membaca buku referensi, buku ajar, dan monograf terbitan Unsoed Press dalam format E-Book resmi bermutu tinggi yang dilindungi watermarking digital.
            </p>
        </div>
        <div class="grid grid-cols-2 gap-4 relative z-10 w-full md:w-auto">
            <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/10 text-center">
                <i class="fas fa-bolt text-2xl text-yellow-400 mb-2"></i>
                <h4 class="font-bold text-sm">Akses Instan</h4>
                <p class="text-[11px] text-gray-300 mt-1">Langsung baca setelah transaksi selesai</p>
            </div>
            <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/10 text-center">
                <i class="fas fa-tags text-2xl text-green-400 mb-2"></i>
                <h4 class="font-bold text-sm">Hemat 30%</h4>
                <p class="text-[11px] text-gray-300 mt-1">Lebih terjangkau dibanding buku cetak</p>
            </div>
            <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/10 text-center">
                <i class="fas fa-shield-alt text-2xl text-blue-400 mb-2"></i>
                <h4 class="font-bold text-sm">Legal & ISBN</h4>
                <p class="text-[11px] text-gray-300 mt-1">E-Book ber-ISBN resmi Perpusnas</p>
            </div>
            <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/10 text-center">
                <i class="fas fa-leaf text-2xl text-teal-400 mb-2"></i>
                <h4 class="font-bold text-sm">Paperless</h4>
                <p class="text-[11px] text-gray-300 mt-1">Ramah lingkungan & praktis dibawa</p>
            </div>
        </div>
    </div>

    <!-- Katalog E-Book Grid -->
    <div class="space-y-8">
        <?php 
            $koleksiList = !empty($data['ebooks']) ? $data['ebooks'] : $data['books'];
        ?>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-200 pb-5">
            <div>
                <h3 class="text-2xl font-serif font-bold text-gray-900">Katalog E-Book & Edisi Digital</h3>
                <p class="text-sm text-gray-500 mt-1">Pilih judul e-book untuk mengunduh sampel bab gratis atau membeli edisi digitalnya.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs bg-blue-50 text-unsoed-blue font-bold px-3 py-1.5 rounded-full border border-blue-100">
                    Menampilkan <?= count($koleksiList) ?> dari <?= esc($data['total_ebooks']) ?> Koleksi
                </span>
            </div>
        </div>

        <!-- Filter Bar -->
        <form action="<?= BASEURL; ?>/ebook" method="GET" id="filterEbookForm" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200 flex flex-col md:flex-row items-center gap-4">
            <div class="flex-1 relative w-full">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="q" value="<?= htmlspecialchars($data['keyword'] ?? '') ?>" placeholder="Cari judul e-book..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue outline-none text-sm transition-all">
            </div>
            
            <div class="w-full md:w-48 relative">
                <i class="fas fa-user-edit absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <select name="author" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue outline-none text-sm transition-all appearance-none cursor-pointer">
                    <option value="">Semua Penulis</option>
                    <?php foreach($data['authors'] as $auth): ?>
                        <option value="<?= htmlspecialchars($auth['author']) ?>" <?= ($data['active_author'] ?? '') == $auth['author'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($auth['author']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 pointer-events-none"></i>
            </div>
            
            <div class="w-full md:w-auto flex items-center gap-2">
                <span class="text-xs text-gray-500 font-bold uppercase tracking-wider hidden md:block">Tampil:</span>
                <select name="per_page" class="w-full md:w-auto px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue outline-none text-sm transition-all appearance-none cursor-pointer">
                    <option value="5" <?= ($data['per_page'] == 5) ? 'selected' : '' ?>>5</option>
                    <option value="10" <?= ($data['per_page'] == 10) ? 'selected' : '' ?>>10</option>
                    <option value="15" <?= ($data['per_page'] == 15) ? 'selected' : '' ?>>15</option>
                    <option value="20" <?= ($data['per_page'] == 20) ? 'selected' : '' ?>>20</option>
                </select>
            </div>
            
            <button type="submit" class="w-full md:w-auto bg-unsoed-blue text-white px-6 py-2.5 rounded-xl font-bold shadow-sm hover:bg-blue-800 transition">
                Terapkan
            </button>
        </form>

        <?php if(empty($koleksiList)): ?>
            <div class="bg-white rounded-3xl p-16 text-center border border-gray-200 text-gray-400">
                <i class="fas fa-book-open text-5xl mb-4 block text-gray-200"></i>
                Belum ada buku e-book yang ditampilkan.
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach($koleksiList as $book): ?>
                    <?php 
                        $isRealEbook = isset($book['file_size']);
                        // Selalu gunakan ID ebook untuk link, bukan book_id
                        $ebookId   = $isRealEbook ? $book['id'] : null;
                        $judulEbook = $isRealEbook ? $book['title'] : $book['title'] . ' (E-Book)';
                        $penulis    = $isRealEbook ? ($book['book_author'] ?? 'Unsoed Press') : $book['author'];
                        $cover      = $isRealEbook ? ($book['cover_image'] ?? '') : ($book['image'] ?? $book['cover_image'] ?? '');
                        
                        $isFree      = $isRealEbook && ($book['is_free'] == 1 || floatval($book['ebook_price']) == 0);
                        $hargaEbook  = $isRealEbook ? $book['ebook_price'] : round(($book['price'] ?? 0) * 0.7, -2);
                        $hargaNormal = $isRealEbook ? ($book['normal_price'] ?? 0) : ($book['price'] ?? 0);
                    ?>
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden group">
                        <!-- Cover & E-book Badge -->
                        <div class="aspect-[3/4] w-full bg-gray-100 relative overflow-hidden">
                            <?php
                                $coverSrc = 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80';
                                if(!empty($cover)) {
                                    $coverSrc = (strpos($cover, 'http') === 0) ? $cover : BASEURL . '/uploads/covers/' . $cover;
                                }
                            ?>
                            <img src="<?= esc($coverSrc) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            <div class="absolute top-3 right-3 bg-unsoed-blue/90 backdrop-blur-sm text-white font-bold text-[10px] px-2.5 py-1 rounded-full uppercase tracking-wider shadow">
                                <i class="fas fa-file-pdf mr-1"></i> E-BOOK EDITION
                            </div>

                            <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-3 pt-8 flex items-end justify-between">
                                <?php if($isFree): ?>
                                    <span class="text-xs font-extrabold text-green-400 bg-black/60 px-2 py-0.5 rounded-lg border border-green-400/30">
                                        <i class="fas fa-gift mr-1"></i> OPEN ACCESS
                                    </span>
                                <?php else: ?>
                                    <span class="text-xs font-bold text-yellow-300">
                                        <i class="fas fa-tag"></i> Rp <?= number_format($hargaEbook, 0, ',', '.') ?>
                                    </span>
                                    <?php if($hargaNormal > $hargaEbook): ?>
                                        <span class="text-[10px] text-gray-300 line-through">
                                            Rp <?= number_format($hargaNormal, 0, ',', '.') ?>
                                        </span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Book Details -->
                        <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm line-clamp-2 group-hover:text-unsoed-blue transition leading-snug">
                                    <a href="<?= $ebookId ? BASEURL . '/ebook/detail/' . $ebookId : BASEURL . '/ebook' ?>">
                                        <?= htmlspecialchars($judulEbook) ?>
                                    </a>
                                </h4>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-1 font-medium">
                                    <?= htmlspecialchars($penulis) ?>
                                </p>
                                
                                <?php if($isRealEbook): ?>
                                <div class="flex items-center gap-2.5 text-[11px] text-gray-400 font-semibold mt-2 pt-2 border-t border-gray-100">
                                    <span><i class="fas fa-file-pdf text-red-400"></i> <?= $book['file_size'] ?? '15 MB' ?></span>
                                    <span>•</span>
                                    <span><?= $book['page_count'] ?? 150 ?> Hal</span>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="pt-3 border-t border-gray-100 flex flex-col gap-2">
                                <?php if(!$ebookId): ?>
                                    <!-- Bukan real ebook, skip -->
                                <?php elseif($isFree): ?>
                                    <a href="<?= BASEURL ?>/ebook/download/<?= esc($ebookId) ?>" class="w-full py-2 bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 text-white rounded-xl text-xs font-bold text-center transition shadow-sm flex items-center justify-center gap-1.5">
                                        <i class="fas fa-cloud-download-alt"></i> Unduh Gratis
                                    </a>
                                <?php else: ?>
                                    <div class="flex items-center gap-2">
                                        <a href="<?= BASEURL ?>/ebook/detail/<?= esc($ebookId) ?>" class="flex-1 py-2 bg-[#0f3460] hover:bg-blue-900 text-white rounded-xl text-xs font-bold text-center transition shadow-sm flex items-center justify-center gap-1.5">
                                            <i class="fas fa-shopping-cart"></i> Beli E-Book
                                        </a>
                                        <a href="<?= BASEURL ?>/ebook/detail/<?= esc($ebookId) ?>" class="w-9 h-9 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl flex items-center justify-center text-xs transition" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Pagination -->
        <?php if($data['total_pages'] > 1): ?>
        <div class="mt-12 flex items-center justify-center gap-2">
            <?php 
                $qs = $_GET;
                unset($qs['url']);
            ?>
            
            <!-- Prev -->
            <?php if($data['current_page'] > 1): ?>
                <?php $qs['page'] = $data['current_page'] - 1; ?>
                <a href="<?= BASEURL; ?>/ebook?<?= http_build_query($qs) ?>" class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-unsoed-blue transition shadow-sm">
                    <i class="fas fa-chevron-left text-sm"></i>
                </a>
            <?php endif; ?>

            <!-- Page Numbers -->
            <?php for($i = 1; $i <= $data['total_pages']; $i++): ?>
                <?php if($i == $data['current_page']): ?>
                    <span class="w-10 h-10 flex items-center justify-center bg-unsoed-blue text-white font-bold rounded-lg shadow-md"><?= esc($i) ?></span>
                <?php else: ?>
                    <?php $qs['page'] = $i; ?>
                    <a href="<?= BASEURL; ?>/ebook?<?= http_build_query($qs) ?>" class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 text-gray-600 font-bold rounded-lg hover:bg-gray-50 hover:text-unsoed-blue transition shadow-sm">
                        <?= esc($i) ?>
                    </a>
                <?php endif; ?>
            <?php endfor; ?>

            <!-- Next -->
            <?php if($data['current_page'] < $data['total_pages']): ?>
                <?php $qs['page'] = $data['current_page'] + 1; ?>
                <a href="<?= BASEURL; ?>/ebook?<?= http_build_query($qs) ?>" class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-unsoed-blue transition shadow-sm">
                    <i class="fas fa-chevron-right text-sm"></i>
                </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Panduan Akses E-Book -->
    <div class="bg-gray-50 rounded-3xl p-8 md:p-12 border border-gray-200 space-y-6">
        <h3 class="text-xl font-serif font-bold text-gray-900 text-center">Bagaimana Cara Mengakses E-Book yang Dibeli?</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-2">
                <span class="w-8 h-8 rounded-lg bg-blue-100 text-unsoed-blue font-bold flex items-center justify-center text-sm mb-3">1</span>
                <h4 class="font-bold text-gray-900">Pilih Edisi Digital</h4>
                <p class="text-gray-600 text-xs leading-relaxed">Pilih buku pada katalog E-Book atau pada halaman detail buku, lalu selesaikan pemesanan.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-2">
                <span class="w-8 h-8 rounded-lg bg-yellow-100 text-yellow-700 font-bold flex items-center justify-center text-sm mb-3">2</span>
                <h4 class="font-bold text-gray-900">Verifikasi Pembayaran</h4>
                <p class="text-gray-600 text-xs leading-relaxed">Setelah pembayaran dikonfirmasi oleh tim admin, link akses digital akan terbuka di akun Anda.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-2">
                <span class="w-8 h-8 rounded-lg bg-green-100 text-green-700 font-bold flex items-center justify-center text-sm mb-3">3</span>
                <h4 class="font-bold text-gray-900">Unduh atau Baca Online</h4>
                <p class="text-gray-600 text-xs leading-relaxed">Buka menu pesanan untuk membaca langsung melalui browser atau mengunduh file PDF ber-watermark.</p>
            </div>
        </div>
    </div>

</div>
