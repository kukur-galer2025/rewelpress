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
        <div class="grid grid-cols-2 gap-3 md:gap-4 relative z-10 w-full md:w-auto">
            <div class="bg-white/10 backdrop-blur-md p-3 md:p-4 rounded-2xl border border-white/10 text-center hover:bg-white/20 transition-colors">
                <i class="fas fa-bolt text-xl md:text-2xl text-yellow-400 mb-1.5 md:mb-2"></i>
                <h4 class="font-bold text-xs md:text-sm">Akses Instan</h4>
                <p class="text-[10px] md:text-[11px] text-gray-300 mt-0.5 md:mt-1">Langsung baca setelah transaksi selesai</p>
            </div>
            <div class="bg-white/10 backdrop-blur-md p-3 md:p-4 rounded-2xl border border-white/10 text-center hover:bg-white/20 transition-colors">
                <i class="fas fa-tags text-xl md:text-2xl text-green-400 mb-1.5 md:mb-2"></i>
                <h4 class="font-bold text-xs md:text-sm">Hemat 30%</h4>
                <p class="text-[10px] md:text-[11px] text-gray-300 mt-0.5 md:mt-1">Lebih terjangkau dibanding buku cetak</p>
            </div>
            <div class="bg-white/10 backdrop-blur-md p-3 md:p-4 rounded-2xl border border-white/10 text-center hover:bg-white/20 transition-colors">
                <i class="fas fa-shield-alt text-xl md:text-2xl text-blue-400 mb-1.5 md:mb-2"></i>
                <h4 class="font-bold text-xs md:text-sm">Legal & ISBN</h4>
                <p class="text-[10px] md:text-[11px] text-gray-300 mt-0.5 md:mt-1">E-Book ber-ISBN resmi Perpusnas</p>
            </div>
            <div class="bg-white/10 backdrop-blur-md p-3 md:p-4 rounded-2xl border border-white/10 text-center hover:bg-white/20 transition-colors">
                <i class="fas fa-leaf text-xl md:text-2xl text-teal-400 mb-1.5 md:mb-2"></i>
                <h4 class="font-bold text-xs md:text-sm">Paperless</h4>
                <p class="text-[10px] md:text-[11px] text-gray-300 mt-0.5 md:mt-1">Ramah lingkungan & praktis dibawa</p>
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
        <form action="<?= BASEURL; ?>/ebook" method="GET" id="filterEbookForm" class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200 flex flex-col md:flex-row items-center gap-3 md:gap-4">
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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php foreach($koleksiList as $book): ?>
                    <?php 
                        $isRealEbook = isset($book['file_size']);
                        $ebookId   = $isRealEbook ? $book['id'] : null;
                        $judulEbook = $isRealEbook ? $book['title'] : $book['title'] . ' (E-Book)';
                        $penulis    = $isRealEbook ? ($book['book_author'] ?? 'Unsoed Press') : $book['author'];
                        $cover      = $isRealEbook ? ($book['cover_image'] ?? '') : ($book['image'] ?? $book['cover_image'] ?? '');
                        
                        $isFree      = $isRealEbook && ($book['is_free'] == 1 || floatval($book['ebook_price']) == 0);
                        $hargaEbook  = $isRealEbook ? $book['ebook_price'] : round(($book['price'] ?? 0) * 0.7, -2);
                        $hargaNormal = $isRealEbook ? ($book['normal_price'] ?? 0) : ($book['price'] ?? 0);
                        $discount    = ($hargaNormal > 0 && $hargaNormal > $hargaEbook) ? round((1 - $hargaEbook / $hargaNormal) * 100) : 0;
                        $avgRating   = isset($book['avg_rating']) ? number_format($book['avg_rating'], 1) : '4.9';
                        $reviewCount = isset($book['review_count']) ? $book['review_count'] : 0;
                        $dynamicSold = (isset($book['id']) ? ($book['id'] * 17) % 120 : 0) + ($reviewCount * 4) + 23;

                        $coverSrc = 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80';
                        if(!empty($cover)) {
                            $coverSrc = (strpos($cover, 'http') === 0) ? $cover : BASEURL . '/uploads/covers/' . $cover;
                        }
                        
                        $penulisArr = explode(';', $penulis);
                        $displayPenulis = trim($penulisArr[0]);
                        if(count($penulisArr) > 1) $displayPenulis .= ' dkk.';

                        $detailLink = $ebookId ? BASEURL . '/ebook/detail/' . $ebookId : BASEURL . '/ebook';
                    ?>
                    <a href="<?= $detailLink ?>" class="group flex flex-col bg-white rounded-2xl shadow-sm hover:shadow-2xl hover:shadow-unsoed-blue/15 hover:-translate-y-2 transition-all duration-500 border border-gray-100 hover:border-unsoed-blue/30 overflow-hidden relative h-full">
                        
                        <!-- Badges -->
                        <div class="absolute top-3 left-3 z-20 flex flex-col gap-1.5 pointer-events-none">
                            <?php if($isFree): ?>
                                <span class="bg-gradient-to-r from-green-500 to-emerald-500 text-white text-[9px] font-black px-2.5 py-1 rounded-full shadow-md flex items-center gap-1 uppercase tracking-wider">
                                    <i class="fas fa-gift"></i> Gratis
                                </span>
                            <?php else: ?>
                                <span class="bg-gradient-to-r from-unsoed-blue to-blue-600 text-white text-[9px] font-black px-2.5 py-1 rounded-full shadow-md flex items-center gap-1 uppercase tracking-wider">
                                    <i class="fas fa-file-pdf"></i> E-Book
                                </span>
                            <?php endif; ?>
                        </div>

                        <?php if($discount > 0): ?>
                        <div class="absolute top-3 right-3 z-20 pointer-events-none">
                            <span class="bg-red-50 text-red-600 border border-red-200 text-[10px] font-bold px-2 py-1 rounded-lg shadow-sm">-<?= $discount ?>%</span>
                        </div>
                        <?php endif; ?>

                        <!-- Image Container -->
                        <div class="relative w-full aspect-[3/4] bg-gray-50 overflow-hidden shrink-0">
                            <img src="<?= esc($coverSrc) ?>" alt="<?= htmlspecialchars($judulEbook) ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                            
                            <!-- Center button overlay -->
                            <div class="absolute inset-0 bg-unsoed-darkblue/40 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 flex items-center justify-center">
                                <span class="bg-unsoed-yellow text-unsoed-darkblue text-[11px] font-bold px-5 py-2.5 rounded-full shadow-2xl flex items-center gap-2 transform scale-75 group-hover:scale-100 transition-all duration-500 delay-75">
                                    <i class="fas fa-shopping-bag"></i> Lihat Detail
                                </span>
                            </div>
                        </div>

                        <!-- Content Area -->
                        <div class="p-4 flex flex-col flex-grow">
                            
                            <!-- Category & Rating -->
                            <div class="flex justify-between items-center mb-1">
                                <?php if($isRealEbook): ?>
                                    <p class="text-[10px] text-unsoed-blue font-bold uppercase tracking-wider line-clamp-1 flex-1 pr-2">
                                        <i class="fas fa-file-pdf text-red-400 mr-0.5"></i> <?= $book['file_size'] ?? '15 MB' ?> · <?= $book['page_count'] ?? 150 ?> Hal
                                    </p>
                                <?php else: ?>
                                    <p class="text-[10px] text-unsoed-blue font-bold uppercase tracking-wider">Digital</p>
                                <?php endif; ?>
                                <div class="flex items-center gap-1 text-[11px] font-bold text-amber-500 shrink-0">
                                    <i class="fas fa-star"></i> <?= $avgRating ?>
                                </div>
                            </div>
                            
                            <!-- Title -->
                            <h3 class="font-bold text-gray-900 text-sm md:text-[14px] leading-snug mb-1 line-clamp-2 group-hover:text-unsoed-blue transition-colors" title="<?= htmlspecialchars($judulEbook) ?>">
                                <?= htmlspecialchars($judulEbook) ?>
                            </h3>
                            
                            <!-- Author -->
                            <p class="text-[11px] text-gray-500 mb-3 flex items-start gap-1.5">
                                <i class="fas fa-user-edit text-gray-300 mt-0.5 shrink-0"></i>
                                <span class="line-clamp-1" title="<?= esc($penulis) ?>"><?= htmlspecialchars($displayPenulis) ?></span>
                            </p>
                            
                            <!-- Price Area -->
                            <div class="mt-auto pt-3 border-t border-gray-100/80 flex flex-col gap-0.5">
                                <div class="flex items-center justify-between h-[14px]">
                                    <?php if($hargaNormal > $hargaEbook && !$isFree): ?>
                                        <span class="text-[10px] text-red-500 font-medium line-through decoration-red-500/60">Rp<?= number_format($hargaNormal, 0, ',', '.') ?></span>
                                    <?php else: ?>
                                        <span></span>
                                    <?php endif; ?>
                                    <span class="text-[10px] text-gray-400 font-medium"><?= $dynamicSold ?>+ terjual</span>
                                </div>
                                <div class="flex items-baseline leading-none">
                                    <?php if($isFree): ?>
                                        <span class="text-base md:text-lg font-extrabold text-green-600">GRATIS</span>
                                    <?php else: ?>
                                        <span class="text-xs mr-0.5 font-bold text-unsoed-darkblue">Rp</span>
                                        <span class="text-base md:text-lg font-extrabold text-unsoed-darkblue"><?= number_format($hargaEbook, 0, ',', '.') ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Pagination -->
        <?php if($data['total_pages'] > 1): ?>
        <div class="mt-12 flex items-center justify-center gap-2 flex-wrap">
            <?php 
                $qs = $_GET;
                unset($qs['url']);
            ?>
            
            <!-- Prev -->
            <?php if($data['current_page'] > 1): ?>
                <?php $qs['page'] = $data['current_page'] - 1; ?>
                <a href="<?= BASEURL; ?>/ebook?<?= http_build_query($qs) ?>" class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 text-gray-600 rounded-xl hover:bg-unsoed-blue hover:text-white hover:border-unsoed-blue transition-all shadow-sm">
                    <i class="fas fa-chevron-left text-sm"></i>
                </a>
            <?php endif; ?>

            <!-- Page Numbers -->
            <?php for($i = 1; $i <= $data['total_pages']; $i++): ?>
                <?php if($i == $data['current_page']): ?>
                    <span class="w-10 h-10 flex items-center justify-center bg-unsoed-blue text-white font-bold rounded-xl shadow-md text-sm"><?= esc($i) ?></span>
                <?php else: ?>
                    <?php $qs['page'] = $i; ?>
                    <a href="<?= BASEURL; ?>/ebook?<?= http_build_query($qs) ?>" class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-unsoed-blue hover:text-white hover:border-unsoed-blue transition-all shadow-sm text-sm">
                        <?= esc($i) ?>
                    </a>
                <?php endif; ?>
            <?php endfor; ?>

            <!-- Next -->
            <?php if($data['current_page'] < $data['total_pages']): ?>
                <?php $qs['page'] = $data['current_page'] + 1; ?>
                <a href="<?= BASEURL; ?>/ebook?<?= http_build_query($qs) ?>" class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 text-gray-600 rounded-xl hover:bg-unsoed-blue hover:text-white hover:border-unsoed-blue transition-all shadow-sm">
                    <i class="fas fa-chevron-right text-sm"></i>
                </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Panduan Akses E-Book -->
    <div class="bg-gray-50 rounded-3xl p-6 md:p-12 border border-gray-200 space-y-6">
        <h3 class="text-xl font-serif font-bold text-gray-900 text-center">Bagaimana Cara Mengakses E-Book yang Dibeli?</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 text-sm">
            <div class="bg-white p-5 md:p-6 rounded-2xl border border-gray-200 shadow-sm space-y-2 hover:shadow-md transition-shadow">
                <span class="w-8 h-8 rounded-lg bg-blue-100 text-unsoed-blue font-bold flex items-center justify-center text-sm mb-3">1</span>
                <h4 class="font-bold text-gray-900">Pilih Edisi Digital</h4>
                <p class="text-gray-600 text-xs leading-relaxed">Pilih buku pada katalog E-Book atau pada halaman detail buku, lalu selesaikan pemesanan.</p>
            </div>
            <div class="bg-white p-5 md:p-6 rounded-2xl border border-gray-200 shadow-sm space-y-2 hover:shadow-md transition-shadow">
                <span class="w-8 h-8 rounded-lg bg-yellow-100 text-yellow-700 font-bold flex items-center justify-center text-sm mb-3">2</span>
                <h4 class="font-bold text-gray-900">Verifikasi Pembayaran</h4>
                <p class="text-gray-600 text-xs leading-relaxed">Setelah pembayaran dikonfirmasi oleh tim admin, link akses digital akan terbuka di akun Anda.</p>
            </div>
            <div class="bg-white p-5 md:p-6 rounded-2xl border border-gray-200 shadow-sm space-y-2 hover:shadow-md transition-shadow">
                <span class="w-8 h-8 rounded-lg bg-green-100 text-green-700 font-bold flex items-center justify-center text-sm mb-3">3</span>
                <h4 class="font-bold text-gray-900">Unduh atau Baca Online</h4>
                <p class="text-gray-600 text-xs leading-relaxed">Buka menu pesanan untuk membaca langsung melalui browser atau mengunduh file PDF ber-watermark.</p>
            </div>
        </div>
    </div>

</div>
