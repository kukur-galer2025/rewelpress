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
    <section class="py-8">
        <?php 
            $koleksiList = isset($data['ebooks']) ? $data['ebooks'] : (isset($data['books']) ? $data['books'] : []);
        ?>
        <div class="flex flex-col lg:flex-row gap-8" id="ebook-catalog-wrapper">
            
            <!-- Sidebar -->
            <aside id="katalog-sidebar" class="w-full lg:w-1/4 flex-shrink-0 space-y-8">
                <!-- Filter & Search Box -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-16 h-16 bg-unsoed-yellow rounded-bl-full opacity-10 group-hover:scale-110 transition-transform"></div>
                    <h3 class="text-sm font-bold text-gray-800 tracking-widest uppercase mb-4 flex items-center gap-2">
                        <i class="fas fa-filter text-unsoed-yellow"></i> Filter Pencarian
                    </h3>
                    <form action="<?= BASEURL; ?>/ebook" method="GET" id="filterEbookForm">
                        <div class="space-y-4">
                            <!-- Kata Kunci -->
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Kata Kunci</label>
                                <div class="relative">
                                    <input type="text" name="q" value="<?= htmlspecialchars($data['keyword'] ?? '') ?>" placeholder="Cari judul..." class="w-full pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue outline-none transition-all text-sm">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Penulis -->
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Penulis</label>
                                <select name="author" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue outline-none transition-all text-sm">
                                    <option value="">Semua Penulis</option>
                                    <?php foreach($data['authors'] as $auth): ?>
                                        <option value="<?= htmlspecialchars($auth['author']) ?>" <?= ($data['active_author'] ?? '') == $auth['author'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($auth['author']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Tampil -->
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Jumlah Tampil</label>
                                <select name="per_page" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-unsoed-blue/30 focus:border-unsoed-blue outline-none transition-all text-sm">
                                    <option value="5" <?= ($data['per_page'] == 5) ? 'selected' : '' ?>>5</option>
                                    <option value="10" <?= ($data['per_page'] == 10) ? 'selected' : '' ?>>10</option>
                                    <option value="15" <?= ($data['per_page'] == 15) ? 'selected' : '' ?>>15</option>
                                    <option value="20" <?= ($data['per_page'] == 20) ? 'selected' : '' ?>>20</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="w-full bg-unsoed-blue text-white py-3 rounded-xl font-bold shadow-md hover:bg-blue-800 transition">
                                Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>
                                <!-- Categories -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mt-6">
                    <h3 class="text-sm font-bold text-gray-800 tracking-widest uppercase mb-6 flex items-center gap-2">
                        <i class="fas fa-layer-group text-unsoed-blue"></i> Kategori E-Book
                    </h3>
                    
                    <ul class="space-y-2">
                        <li>
                            <a href="<?= BASEURL; ?>/ebook" class="ajax-filter flex items-center justify-between py-2 px-3 rounded-lg transition-all <?= empty($data['active_category']) ? 'bg-unsoed-blue text-white font-semibold shadow-md' : 'text-gray-600 hover:bg-gray-50 hover:text-unsoed-blue group' ?>">
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-angle-right text-xs <?= empty($data['active_category']) ? 'text-white' : 'text-gray-400 group-hover:text-unsoed-blue group-hover:translate-x-1 transition-transform' ?>"></i> 
                                    Semua Kategori
                                </span>
                            </a>
                        </li>
                        
                        <?php foreach($data['categories'] as $cat): ?>
                            <?php 
                                $isActiveParent = ($data['active_category'] == $cat['id']);
                                $hasActiveChild = false;
                                if(!empty($cat['children'])) {
                                    foreach($cat['children'] as $child) {
                                        if($data['active_category'] == $child['id']) {
                                            $hasActiveChild = true;
                                            break;
                                        }
                                    }
                                }
                                $isExpanded = $isActiveParent || $hasActiveChild;
                            ?>
                            <li>
                                <div class="flex items-center justify-between py-2 px-3 rounded-lg transition-all <?= $isActiveParent ? 'bg-unsoed-blue text-white font-semibold shadow-md' : 'text-gray-600 hover:bg-gray-50 hover:text-unsoed-blue group' ?>">
                                    <a href="<?= BASEURL; ?>/ebook/category/<?= esc($cat['slug']) ?>" class="ajax-filter flex-1 flex items-center gap-2">
                                        <i class="fas fa-angle-right text-xs <?= $isActiveParent ? 'text-white' : 'text-gray-400 group-hover:text-unsoed-blue group-hover:translate-x-1 transition-transform' ?>"></i> 
                                        <?= esc($cat['name']) ?>
                                    </a>
                                    <?php if(!empty($cat['children'])): ?>
                                        <button type="button" class="ml-2 w-6 h-6 flex items-center justify-center rounded-full hover:bg-black/10 transition" onclick="document.getElementById('sub-cat-<?= esc($cat['id']) ?>').classList.toggle('hidden'); this.querySelector('i').classList.toggle('fa-chevron-down'); this.querySelector('i').classList.toggle('fa-chevron-up');">
                                            <i class="fas <?= $isExpanded ? 'fa-chevron-up' : 'fa-chevron-down' ?> text-xs <?= $isActiveParent ? 'text-white' : 'text-gray-400 group-hover:text-unsoed-blue' ?>"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Subcategories -->
                                <?php if(!empty($cat['children'])): ?>
                                    <ul id="sub-cat-<?= esc($cat['id']) ?>" class="pl-6 mt-1 space-y-1 relative border-l-2 border-gray-100 ml-5 <?= $isExpanded ? 'block' : 'hidden' ?>">
                                        <?php foreach($cat['children'] as $child): ?>
                                            <li>
                                                <a href="<?= BASEURL; ?>/ebook/category/<?= esc($child['slug']) ?>" class="ajax-filter flex items-center justify-between py-1.5 px-3 rounded-lg transition-all text-sm <?= ($data['active_category'] == $child['id']) ? 'bg-unsoed-yellow/10 text-unsoed-yellow font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-unsoed-blue' ?>">
                                                    <span class="flex items-center gap-2">
                                                        <span class="w-1.5 h-1.5 rounded-full <?= ($data['active_category'] == $child['id']) ? 'bg-unsoed-yellow' : 'bg-gray-300' ?>"></span>
                                                        <?= esc($child['name']) ?>
                                                    </span>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </aside>

            <!-- Main Content -->
            <div id="katalog-container" class="flex-1 space-y-6 relative">
                <!-- Overlay loading (hidden by default) -->
                <div id="loading-overlay" class="absolute inset-0 bg-white/60 backdrop-blur-sm z-50 hidden flex-col items-center pt-32 rounded-2xl">
                    <div class="animate-spin w-12 h-12 border-4 border-unsoed-blue border-t-unsoed-yellow rounded-full mb-3"></div>
                    <p class="text-unsoed-blue font-bold tracking-widest text-sm uppercase">Memuat...</p>
                </div>

                <!-- Header Katalog -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-200 pb-5">
                    <div>
                        <h3 class="text-2xl font-serif font-bold text-gray-900"><?= !empty($data['active_category']) ? htmlspecialchars($data['judul']) : 'Katalog E-Book & Edisi Digital' ?></h3>
                        <p class="text-sm text-gray-500 mt-1">Pilih judul e-book untuk mengunduh sampel bab gratis atau membeli edisi digitalnya.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xs bg-blue-50 text-unsoed-blue font-bold px-3 py-1.5 rounded-full border border-blue-100">
                            Menampilkan <?= is_array($koleksiList) ? count($koleksiList) : 0 ?> dari <?= esc($data['total_ebooks'] ?? 0) ?> Koleksi
                        </span>
                    </div>
                </div>

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

                                $ebookSlug = isset($ebook['slug']) ? $ebook['slug'] : '';
                                $detailLink = $ebookSlug ? BASEURL . '/ebook/detail/' . $ebookSlug : BASEURL . '/ebook';
                            ?>
                            <a href="<?= $detailLink ?>" class="max-w-[280px] mx-auto w-full group flex flex-col bg-white rounded-xl border border-gray-200 hover:border-gray-800 hover:shadow-xl transition-all duration-300 overflow-hidden relative h-full">
                                
                                <?php if($discount > 0): ?>
                                <div class="absolute top-3 right-3 z-20 pointer-events-none">
                                    <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm">-<?= $discount ?>%</span>
                                </div>
                                <?php endif; ?>

                                <!-- Image Container -->
                                <div class="relative w-full aspect-[3/4] bg-gray-100 overflow-hidden shrink-0 border-b border-gray-100">
                                    <img src="<?= esc($coverSrc) ?>" alt="<?= htmlspecialchars($judulEbook) ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                                    
                                    <!-- Center button overlay -->
                                    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 flex items-center justify-center">
                                        <span class="bg-white text-gray-900 text-[11px] font-black uppercase tracking-widest px-6 py-3 rounded shadow-2xl flex items-center gap-2 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                            Lihat Detail
                                        </span>
                                    </div>
                                </div>

                                <!-- Content Area -->
                                <div class="p-4 md:p-5 flex flex-col flex-grow bg-white">
                                    
                                    <!-- Title -->
                                    <h3 class="font-extrabold text-gray-900 text-[15px] md:text-base leading-snug mb-2 line-clamp-2 tracking-tight group-hover:text-unsoed-blue transition-colors" title="<?= htmlspecialchars($judulEbook) ?>">
                                        <?= htmlspecialchars($judulEbook) ?>
                                    </h3>
                                    
                                    <!-- Author & Rating -->
                                    <div class="flex items-center justify-between mb-4 gap-2">
                                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider line-clamp-1 flex-1" title="<?= esc($penulis) ?>">
                                            <?= htmlspecialchars($displayPenulis) ?>
                                        </p>
                                        <div class="flex items-center gap-1 text-[11px] font-bold text-gray-900 shrink-0">
                                            <i class="fas fa-star text-amber-500"></i> <?= $avgRating ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Price Area -->
                                    <div class="mt-auto pt-3 border-t-2 border-gray-100 flex flex-col gap-1">
                                        <div class="flex items-center justify-between h-[14px]">
                                            <?php if($hargaNormal > $hargaEbook && !$isFree): ?>
                                                <span class="text-[11px] text-red-500 font-bold line-through decoration-red-500/60">Rp<?= number_format($hargaNormal, 0, ',', '.') ?></span>
                                            <?php else: ?>
                                                <span></span>
                                            <?php endif; ?>
                                            <span class="text-[10px] font-medium text-gray-400"><?= $dynamicSold ?>+ terjual</span>
                                        </div>
                                        <div class="flex items-baseline leading-none">
                                            <?php if($isFree): ?>
                                                <span class="text-base md:text-[18px] font-black text-emerald-600 uppercase tracking-wider">GRATIS</span>
                                            <?php else: ?>
                                                <span class="text-xs mr-0.5 font-bold text-gray-900">Rp</span>
                                                <span class="text-base md:text-[18px] font-black text-gray-900 tracking-tight"><?= number_format($hargaEbook, 0, ',', '.') ?></span>
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
        <div class="mt-12 flex justify-center">
            <nav class="inline-flex rounded-xl overflow-hidden shadow-sm border border-gray-200">
                <?php 
                    $current = $data['current_page'];
                    $total = $data['total_pages'];
                    $start = max(1, $current - 2);
                    $end = min($total, $current + 2);

                    $baseUrl = BASEURL . '/ebook';
                    if(!empty($data['active_category_slug'])) {
                        $baseUrl .= '/category/' . $data['active_category_slug'];
                    }

                    $queryParams = [];
                    if(!empty($data['keyword'])) $queryParams['q'] = $data['keyword'];
                    if(!empty($data['active_author'])) $queryParams['author'] = $data['active_author'];
                    if($data['per_page'] != 10) $queryParams['per_page'] = $data['per_page'];
                    
                    function buildPageUrlEbook($base, $params, $page) {
                        $p = $params;
                        if($page > 1) $p['page'] = $page;
                        return $base . (!empty($p) ? '?' . http_build_query($p) : '');
                    }
                ?>
                
                <?php if($current > 1): ?>
                    <a href="<?= buildPageUrlEbook($baseUrl, $queryParams, $current - 1) ?>" class="ajax-filter px-4 py-2 bg-white text-gray-500 hover:bg-gray-50 hover:text-unsoed-blue font-bold border-r border-gray-200 transition-colors">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                <?php endif; ?>

                <?php if($start > 1): ?>
                    <a href="<?= buildPageUrlEbook($baseUrl, $queryParams, 1) ?>" class="ajax-filter px-4 py-2 bg-white text-gray-500 hover:bg-gray-50 hover:text-unsoed-blue font-bold border-r border-gray-200 transition-colors">1</a>
                    <?php if($start > 2): ?>
                        <span class="px-4 py-2 bg-white text-gray-400 border-r border-gray-200">...</span>
                    <?php endif; ?>
                <?php endif; ?>

                <?php for($i = $start; $i <= $end; $i++): ?>
                    <?php if($i == $current): ?>
                        <span class="px-4 py-2 bg-unsoed-blue text-white font-bold border-r border-unsoed-blue"><?= $i ?></span>
                    <?php else: ?>
                        <a href="<?= buildPageUrlEbook($baseUrl, $queryParams, $i) ?>" class="ajax-filter px-4 py-2 bg-white text-gray-500 hover:bg-gray-50 hover:text-unsoed-blue font-bold border-r border-gray-200 transition-colors"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if($end < $total): ?>
                    <?php if($end < $total - 1): ?>
                        <span class="px-4 py-2 bg-white text-gray-400 border-r border-gray-200">...</span>
                    <?php endif; ?>
                    <a href="<?= buildPageUrlEbook($baseUrl, $queryParams, $total) ?>" class="ajax-filter px-4 py-2 bg-white text-gray-500 hover:bg-gray-50 hover:text-unsoed-blue font-bold border-r border-gray-200 transition-colors"><?= $total ?></a>
                <?php endif; ?>

                <?php if($current < $total): ?>
                    <a href="<?= buildPageUrlEbook($baseUrl, $queryParams, $current + 1) ?>" class="ajax-filter px-4 py-2 bg-white text-gray-500 hover:bg-gray-50 hover:text-unsoed-blue font-bold transition-colors">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                <?php endif; ?>
            </nav>
        </div>
        <?php endif; ?>
        
            </div>
        </div>    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function attachAjaxListeners() {
        // Handle filter form submission
        const form = document.getElementById('filterEbookForm');
        if(form && !form.dataset.ajaxAttached) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const url = new URL(form.action);
                const formData = new FormData(form);
                const searchParams = new URLSearchParams();
                for (const pair of formData) {
                    if (pair[1]) searchParams.append(pair[0], pair[1]);
                }
                url.search = searchParams.toString();
                fetchCatalog(url.toString());
            });
            form.dataset.ajaxAttached = 'true';
        }

        // Handle select dropdown changes in the form to auto-submit
        if (form) {
            form.querySelectorAll('select').forEach(select => {
                if(!select.dataset.ajaxAttached) {
                    select.addEventListener('change', () => form.dispatchEvent(new Event('submit')));
                    select.dataset.ajaxAttached = 'true';
                }
            });
        }

        // Handle category links and pagination links
        document.querySelectorAll('a.ajax-filter').forEach(link => {
            if(!link.dataset.ajaxAttached) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    fetchCatalog(this.href);
                });
                link.dataset.ajaxAttached = 'true';
            }
        });
    }

    function fetchCatalog(url) {
        // Find main wrapper so we can replace EVERYTHING inside it including sidebar
        const wrapper = document.getElementById('ebook-catalog-wrapper');
        const overlay = document.getElementById('loading-overlay');
        if(overlay) overlay.style.display = 'flex';

        // Update URL bar without reloading
        window.history.pushState({ path: url }, '', url);

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newWrapper = doc.getElementById('ebook-catalog-wrapper');
                
                if(newWrapper) {
                    wrapper.innerHTML = newWrapper.innerHTML;
                }
                
                // Re-attach listeners to the new DOM elements
                attachAjaxListeners();
                
                // Smooth scroll to top of catalog if needed
                const containerForScroll = document.getElementById('ebook-catalog-wrapper');
                if(containerForScroll) {
                    window.scrollTo({ top: containerForScroll.offsetTop - 100, behavior: 'smooth' });
                }
            })
            .catch(err => {
                console.error('Error fetching catalog:', err);
                if(overlay) overlay.style.display = 'none';
            });
    }

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function() {
        fetchCatalog(window.location.href);
    });

    attachAjaxListeners();
});
</script>

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
