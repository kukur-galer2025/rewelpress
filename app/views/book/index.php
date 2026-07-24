<!-- Page Header -->
<div class="bg-unsoed-darkblue py-12 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-unsoed-darkblue to-unsoed-blue opacity-90"></div>
    <!-- Abstract pattern overlay -->
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="container mx-auto px-4 relative z-10 text-center">
        <?php if(isset($data['is_promo_page']) && $data['is_promo_page']): ?>
            <div class="inline-flex items-center gap-2 bg-red-500 text-white text-xs font-black px-3 py-1 rounded-full uppercase tracking-wider mb-3 animate-bounce shadow-lg">
                <i class="fas fa-bolt"></i> Flash Sale & Promo Spesial
            </div>
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-white mb-4">SUPER SALE BUKU</h1>
            <p class="text-blue-100 max-w-2xl mx-auto">Nikmati penawaran diskon terbaik untuk literatur akademik pilihan. Waktu terbatas!</p>
        <?php else: ?>
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-white mb-4"><?= !empty($data['active_category']) && $data['active_category'] !== 'promo' ? htmlspecialchars($data['judul']) : 'Katalog Buku' ?></h1>
            <p class="text-blue-100 max-w-2xl mx-auto">Jelajahi koleksi literatur akademik dan referensi terbaik yang diterbitkan oleh Unsoed Press.</p>
        <?php endif; ?>
    </div>
</div>

<section class="py-16 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl">
        
        <div class="flex flex-col lg:flex-row gap-8" id="book-catalog-wrapper">
            
            <!-- Sidebar -->
            <aside id="katalog-sidebar" class="w-full lg:w-1/4 flex-shrink-0 space-y-8">
                
                <!-- Filter & Search Box -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-16 h-16 bg-unsoed-yellow rounded-bl-full opacity-10 group-hover:scale-110 transition-transform"></div>
                    <h3 class="text-sm font-bold text-gray-800 tracking-widest uppercase mb-4 flex items-center gap-2">
                        <i class="fas fa-filter text-unsoed-yellow"></i> Filter Pencarian
                    </h3>
                    <?php
                            if (!empty($data['active_category']) && $data['active_category'] === 'promo') {
                                $formAction = BASEURL . '/book/promo';
                            } elseif (!empty($data['active_category']) && !empty($data['active_category_slug'])) {
                                $formAction = BASEURL . '/book/category/' . esc($data['active_category_slug']);
                            } else {
                                $formAction = BASEURL . '/book';
                            }
                    ?>
                    <form action="<?= esc($formAction) ?>" method="GET" id="filterBookForm">
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
                            
                            <button type="submit" class="w-full bg-unsoed-blue text-white py-3 rounded-xl font-bold shadow-md hover:bg-blue-800 transition">
                                Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Categories -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-bold text-gray-800 tracking-widest uppercase mb-6 flex items-center gap-2">
                        <i class="fas fa-layer-group text-unsoed-blue"></i> Kategori Buku
                    </h3>
                    
                    <ul class="space-y-2">
                        <li>
                            <a href="<?= BASEURL; ?>/book" class="ajax-filter flex items-center justify-between py-2 px-3 rounded-lg transition-all <?= empty($data['active_category']) ? 'bg-unsoed-blue text-white font-semibold shadow-md' : 'text-gray-600 hover:bg-gray-50 hover:text-unsoed-blue group' ?>">
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-angle-right text-xs <?= empty($data['active_category']) ? 'text-white' : 'text-gray-400 group-hover:text-unsoed-blue group-hover:translate-x-1 transition-transform' ?>"></i> 
                                    Semua Kategori
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= BASEURL; ?>/book/promo" class="ajax-filter flex items-center justify-between py-2 px-3 rounded-lg transition-all <?= (isset($data['active_category']) && $data['active_category'] === 'promo') ? 'bg-red-500 text-white font-semibold shadow-md' : 'text-red-600 hover:bg-red-50 group' ?>">
                                <span class="flex items-center gap-2 font-bold">
                                    <i class="fas fa-bolt text-xs <?= (isset($data['active_category']) && $data['active_category'] === 'promo') ? 'text-white' : 'group-hover:scale-125 transition-transform animate-pulse' ?>"></i> 
                                    Flash Sale & Promo
                                </span>
                                <?php if(!isset($data['active_category']) || $data['active_category'] !== 'promo'): ?>
                                <span class="text-[10px] bg-red-100 text-red-600 px-2 py-0.5 rounded-full font-bold">HOT</span>
                                <?php endif; ?>
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
                                    <a href="<?= BASEURL; ?>/book/category/<?= esc($cat['slug']) ?>" class="ajax-filter flex-1 flex items-center gap-2">
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
                                                <a href="<?= BASEURL; ?>/book/category/<?= esc($child['slug']) ?>" class="ajax-filter flex items-center justify-between py-1.5 px-3 rounded-lg transition-all text-sm <?= ($data['active_category'] == $child['id']) ? 'bg-unsoed-yellow/10 text-unsoed-yellow font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-unsoed-blue' ?>">
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

            <!-- Main Content (Grid) -->
            <div id="katalog-container" class="flex-1 space-y-6 relative">
                <!-- Overlay loading (hidden by default) -->
                <div id="loading-overlay" class="absolute inset-0 bg-white/60 backdrop-blur-sm z-50 hidden flex-col items-center pt-32 rounded-2xl">
                    <div class="animate-spin w-12 h-12 border-4 border-unsoed-blue border-t-unsoed-yellow rounded-full mb-3"></div>
                    <p class="text-unsoed-blue font-bold tracking-widest text-sm uppercase">Memuat...</p>
                </div>
                <?php if(empty($data['buku'])): ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 text-center py-20 flex flex-col items-center justify-center">
                        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-book-open text-4xl text-gray-300"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">Buku tidak ditemukan</h3>
                        <p class="text-gray-500">Belum ada buku yang sesuai dengan pencarian Anda.</p>
                    </div>
                <?php else: ?>
                    <!-- Sorting/Top Bar -->
                    <div id="topBarInfo" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6 flex justify-between items-center relative z-10">
                        <p class="text-sm text-gray-500 font-medium">Menampilkan <span id="bookCount" class="font-bold text-gray-800"><?= count($data['buku']) ?></span> dari <span class="font-bold"><?= esc($data['total_books']) ?></span> buku.</p>
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-gray-400 uppercase tracking-wider font-bold">Tampil:</span>
                            <select name="per_page" form="filterBookForm" class="text-sm border border-gray-200 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-unsoed-blue/20 focus:border-unsoed-blue outline-none bg-gray-50">
                                <option value="5" <?= ($data['per_page'] == 5) ? 'selected' : '' ?>>5 per halaman</option>
                                <option value="10" <?= ($data['per_page'] == 10) ? 'selected' : '' ?>>10 per halaman</option>
                                <option value="15" <?= ($data['per_page'] == 15) ? 'selected' : '' ?>>15 per halaman</option>
                                <option value="20" <?= ($data['per_page'] == 20) ? 'selected' : '' ?>>20 per halaman</option>
                            </select>
                        </div>
                    </div>

                    <div id="bookGrid" class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        <?php foreach($data['buku'] as $buku): ?>
                            <?php 
                                $discount = 0;
                                if(isset($buku['old_price']) && $buku['old_price'] > $buku['price']) {
                                    $discount = round((($buku['old_price'] - $buku['price']) / $buku['old_price']) * 100);
                                }
                                $img_src = !empty($buku['image']) ? $buku['image'] : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=400';
                                $category = !empty($buku['category_name']) ? $buku['category_name'] : 'Umum';
                                $avgRating = isset($buku['avg_rating']) ? $buku['avg_rating'] : 4.8;
                                $stock = isset($buku['stock']) ? (int)$buku['stock'] : 0;
                                $soldCount = max(15, $stock * 3 + 12);
                            ?>
                            <a href="<?= BASEURL; ?>/book/detail/<?= !empty($buku['slug']) ? esc($buku['slug']) : esc($buku['id']) ?>" class="group flex flex-col bg-white rounded-xl border border-gray-200 hover:border-gray-800 hover:shadow-xl transition-all duration-300 overflow-hidden relative h-full">
                                
                                <!-- Badges -->
                                <div class="absolute top-3 left-3 z-20 flex flex-col gap-1 pointer-events-none">
                                    <?php if(isset($buku['is_flashsale']) && $buku['is_flashsale'] == 1): ?>
                                        <span class="bg-gradient-to-r from-red-600 to-rose-500 text-white text-[9px] font-black px-2.5 py-1 rounded shadow-sm flex items-center gap-1 uppercase tracking-wider"><i class="fas fa-bolt"></i> Flash Sale</span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="absolute top-3 right-3 z-20 pointer-events-none">
                                    <?php if($discount > 0): ?>
                                        <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm">-<?= $discount ?>%</span>
                                    <?php endif; ?>
                                </div>

                                <!-- Image Container -->
                                <div class="relative w-full aspect-[3/4] bg-gray-100 overflow-hidden shrink-0 border-b border-gray-100">
                                    <img src="<?= esc($img_src) ?>" alt="<?= htmlspecialchars($buku['title']) ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                                    <?php if($stock <= 0): ?>
                                        <div class="absolute inset-0 bg-white/70 backdrop-blur-[2px] flex items-center justify-center z-10">
                                            <span class="bg-gray-900 text-white font-bold text-xs px-4 py-1.5 rounded shadow-lg tracking-wider">HABIS</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Center button overlay -->
                                    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 flex items-center justify-center">
                                        <span class="bg-white text-gray-900 text-[11px] font-black uppercase tracking-widest px-6 py-3 rounded shadow-2xl flex items-center gap-2 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                            Lihat Detail
                                        </span>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="p-4 md:p-5 flex flex-col flex-grow bg-white">
                                    
                                    <!-- Title & Author -->
                                    <h3 class="font-extrabold text-gray-900 text-[15px] md:text-base leading-snug mb-2 line-clamp-2 tracking-tight group-hover:text-unsoed-blue transition-colors" title="<?= htmlspecialchars($buku['title']) ?>"><?= esc($buku['title']) ?></h3>
                                    
                                    <?php 
                                        $authorStr = isset($buku['author']) ? $buku['author'] : 'Penulis';
                                        $authors = explode(';', $authorStr);
                                        $displayAuthor = trim($authors[0]);
                                        if(count($authors) > 1) {
                                            $displayAuthor .= ' dkk.';
                                        }
                                    ?>
                                    <!-- Author & Rating -->
                                    <div class="flex items-center justify-between mb-4 gap-2">
                                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider line-clamp-1 flex-1" title="<?= esc($authorStr) ?>">
                                            <?= htmlspecialchars($displayAuthor) ?>
                                        </p>
                                        <div class="flex items-center gap-1 text-[11px] font-bold text-gray-900 shrink-0">
                                            <i class="fas fa-star text-amber-500"></i> <?= $avgRating ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Price Area -->
                                    <?php
                                        $dynamicSold = (isset($buku['id']) ? ($buku['id'] * 13) % 150 : 0) + (isset($buku['review_count']) ? $buku['review_count'] * 5 : 0) + max(15, $stock * 2 + 7);
                                    ?>
                                    <div class="mt-auto pt-3 border-t-2 border-gray-100 flex flex-col gap-1">
                                        <div class="flex items-center justify-between h-[14px]">
                                            <?php if($discount > 0): ?>
                                                <span class="text-[11px] text-red-500 font-bold line-through decoration-red-500/60">Rp<?= number_format($buku['old_price'], 0, ',', '.') ?></span>
                                            <?php else: ?>
                                                <span></span>
                                            <?php endif; ?>
                                            <span class="text-[10px] font-medium text-gray-400"><?= $dynamicSold ?>+ terjual</span>
                                        </div>
                                        <div class="flex items-baseline leading-none">
                                            <span class="text-xs mr-0.5 font-bold text-gray-900">Rp</span>
                                            <span class="text-base md:text-[18px] font-black text-gray-900 tracking-tight"><?= number_format($buku['price'], 0, ',', '.') ?></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Pagination -->
                <?php if($data['total_pages'] > 1): ?>
                <div class="mt-12 flex items-center justify-center gap-2">
                    <?php 
                        $qs = $_GET;
                        // Hapus parameter url (milik framework) jika ada
                        unset($qs['url']);
                        
                        if (!empty($data['active_category']) && $data['active_category'] === 'promo') {
                            $pageBaseUrl = BASEURL . '/book/promo';
                        } elseif (!empty($data['active_category']) && !empty($data['active_category_slug'])) {
                            $pageBaseUrl = BASEURL . '/book/category/' . esc($data['active_category_slug']);
                        } else {
                            $pageBaseUrl = BASEURL . '/book';
                        }
                    ?>
                    
                    <!-- Prev -->
                    <?php if($data['current_page'] > 1): ?>
                        <?php $qs['page'] = $data['current_page'] - 1; ?>
                        <a href="<?= esc($pageBaseUrl) ?>?<?= http_build_query($qs) ?>" class="ajax-filter w-10 h-10 flex items-center justify-center bg-white border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-unsoed-blue transition shadow-sm">
                            <i class="fas fa-chevron-left text-sm"></i>
                        </a>
                    <?php endif; ?>

                    <!-- Page Numbers -->
                    <?php for($i = 1; $i <= $data['total_pages']; $i++): ?>
                        <?php if($i == $data['current_page']): ?>
                            <span class="w-10 h-10 flex items-center justify-center bg-unsoed-blue text-white font-bold rounded-lg shadow-md"><?= esc($i) ?></span>
                        <?php else: ?>
                            <?php $qs['page'] = $i; ?>
                            <a href="<?= esc($pageBaseUrl) ?>?<?= http_build_query($qs) ?>" class="ajax-filter w-10 h-10 flex items-center justify-center bg-white border border-gray-200 text-gray-600 font-bold rounded-lg hover:bg-gray-50 hover:text-unsoed-blue transition shadow-sm">
                                <?= esc($i) ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <!-- Next -->
                    <?php if($data['current_page'] < $data['total_pages']): ?>
                        <?php $qs['page'] = $data['current_page'] + 1; ?>
                        <a href="<?= esc($pageBaseUrl) ?>?<?= http_build_query($qs) ?>" class="ajax-filter w-10 h-10 flex items-center justify-center bg-white border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-unsoed-blue transition shadow-sm">
                            <i class="fas fa-chevron-right text-sm"></i>
                        </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

        </div>

    </div>
</section>



<script>
document.addEventListener('DOMContentLoaded', function() {
    function attachAjaxListeners() {
        // Handle filter form submission
        const form = document.getElementById('filterBookForm');
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
        const wrapper = document.getElementById('book-catalog-wrapper');
        const overlay = document.getElementById('loading-overlay');
        if(overlay) overlay.style.display = 'flex';

        // Update URL bar without reloading
        window.history.pushState({ path: url }, '', url);

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newWrapper = doc.getElementById('book-catalog-wrapper');
                
                if(newWrapper) {
                    wrapper.innerHTML = newWrapper.innerHTML;
                }
                
                // Re-attach listeners to the new DOM elements
                attachAjaxListeners();
                
                // Smooth scroll to top of catalog if needed
                const containerForScroll = document.getElementById('book-catalog-wrapper');
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
