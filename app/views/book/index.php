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
        
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Sidebar -->
            <aside class="w-full lg:w-1/4 flex-shrink-0 space-y-8">
                
                <!-- Filter & Search Box -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-16 h-16 bg-unsoed-yellow rounded-bl-full opacity-10 group-hover:scale-110 transition-transform"></div>
                    <h3 class="text-sm font-bold text-gray-800 tracking-widest uppercase mb-4 flex items-center gap-2">
                        <i class="fas fa-filter text-unsoed-yellow"></i> Filter Pencarian
                    </h3>
                    <?php
                            if (!empty($data['active_category'])) {
                                $formAction = BASEURL . '/book/category/' . esc($data['active_category_slug']);
                            } else {
                                $formAction = BASEURL . '/book';
                            }
                    ?>
                    <form action="<?= esc($formAction) ?>" method="GET" id="filterForm">
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
                            <a href="<?= BASEURL; ?>/book" class="flex items-center justify-between py-2 px-3 rounded-lg transition-all <?= empty($data['active_category']) ? 'bg-unsoed-blue text-white font-semibold shadow-md' : 'text-gray-600 hover:bg-gray-50 hover:text-unsoed-blue group' ?>">
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-angle-right text-xs <?= empty($data['active_category']) ? 'text-white' : 'text-gray-400 group-hover:text-unsoed-blue group-hover:translate-x-1 transition-transform' ?>"></i> 
                                    Semua Kategori
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= BASEURL; ?>/book/promo" class="flex items-center justify-between py-2 px-3 rounded-lg transition-all <?= (isset($data['active_category']) && $data['active_category'] === 'promo') ? 'bg-red-500 text-white font-semibold shadow-md' : 'text-red-600 hover:bg-red-50 group' ?>">
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
                                    <a href="<?= BASEURL; ?>/book/category/<?= esc($cat['slug']) ?>" class="flex-1 flex items-center gap-2">
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
                                                <a href="<?= BASEURL; ?>/book/category/<?= esc($child['slug']) ?>" class="flex items-center justify-between py-1.5 px-3 rounded-lg transition-all text-sm <?= ($data['active_category'] == $child['id']) ? 'bg-unsoed-yellow/10 text-unsoed-yellow font-bold' : 'text-gray-500 hover:bg-gray-50 hover:text-unsoed-blue' ?>">
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
            <div class="flex-1">
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
                    <div id="topBarInfo" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6 flex justify-between items-center">
                        <p class="text-sm text-gray-500 font-medium">Menampilkan <span id="bookCount" class="font-bold text-gray-800"><?= count($data['buku']) ?></span> dari <span class="font-bold"><?= esc($data['total_books']) ?></span> buku.</p>
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-gray-400 uppercase tracking-wider font-bold">Tampil:</span>
                            <select name="per_page" form="filterForm" onchange="document.getElementById('filterForm').submit();" class="text-sm border border-gray-200 rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-unsoed-blue/20 focus:border-unsoed-blue outline-none bg-gray-50">
                                <option value="5" <?= ($data['per_page'] == 5) ? 'selected' : '' ?>>5 per halaman</option>
                                <option value="10" <?= ($data['per_page'] == 10) ? 'selected' : '' ?>>10 per halaman</option>
                                <option value="15" <?= ($data['per_page'] == 15) ? 'selected' : '' ?>>15 per halaman</option>
                                <option value="20" <?= ($data['per_page'] == 20) ? 'selected' : '' ?>>20 per halaman</option>
                            </select>
                        </div>
                    </div>

                    <div id="bookGrid" class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        <?php foreach($data['buku'] as $buku): ?>
                            <a href="<?= BASEURL; ?>/book/detail/<?= esc($buku['slug']) ?>" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col group border border-gray-100 relative">
                                <!-- Badge Promo Overlay -->
                                <div class="absolute top-3 right-3 z-20 flex justify-end items-start pointer-events-none">
                                    <?php if(isset($buku['is_flashsale']) && $buku['is_flashsale'] == 1): ?>
                                        <span class="bg-red-600 text-white text-[10px] font-black px-2 py-1 rounded-md shadow-md animate-pulse flex items-center gap-1">
                                            <i class="fas fa-bolt"></i> FLASH SALE
                                        </span>
                                    <?php elseif($buku['old_price'] > $buku['price']): ?>
                                        <?php $disc = round((($buku['old_price'] - $buku['price']) / $buku['old_price']) * 100); ?>
                                        <span class="bg-red-500 text-white text-[10px] font-black px-2 py-1 rounded-md shadow-md animate-pulse">
                                            -<?= esc($disc) ?>%
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="relative w-full pt-[140%] bg-gray-100 overflow-hidden">
                                    <?php $img_src = !empty($buku['image']) ? $buku['image'] : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=400'; ?>
                                    <img src="<?= esc($img_src) ?>" alt="<?= htmlspecialchars($buku['title']) ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    <?php if(isset($buku['stock']) && $buku['stock'] <= 0): ?>
                                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center z-10">
                                            <span class="bg-black/80 text-white font-bold text-sm px-4 py-2 rounded-lg border border-gray-600 backdrop-blur-sm">STOK HABIS</span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>
                                
                                <div class="p-5 flex flex-col flex-grow">
                                    <p class="text-[10px] text-unsoed-yellow font-bold uppercase tracking-wider mb-2 line-clamp-1">
                                        <?= !empty($buku['parent_category_name']) ? $buku['parent_category_name'] . ' &bull; ' : '' ?><?= esc($buku['category_name']) ?>
                                    </p>
                                    <h3 class="font-bold text-gray-800 text-sm md:text-base leading-snug mb-1 line-clamp-2 group-hover:text-unsoed-blue transition-colors"><?= esc($buku['title']) ?></h3>
                                    <p class="text-xs text-gray-500 mb-4 line-clamp-1"><i class="fas fa-pen-nib mr-1 text-gray-300"></i> <?= esc($buku['author']) ?></p>
                                    
                                    <div class="mt-auto pt-4 border-t border-gray-50">
                                        <?php if($buku['old_price'] > 0): ?>
                                            <p class="text-[11px] text-gray-400 line-through mb-0.5 font-medium">Rp <?= number_format($buku['old_price'], 0, ',', '.') ?></p>
                                        <?php endif; ?>
                                        <div class="flex items-center justify-between">
                                            <p class="font-extrabold text-unsoed-blue text-base md:text-lg">Rp <?= number_format($buku['price'], 0, ',', '.') ?></p>
                                            <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-unsoed-blue group-hover:bg-unsoed-yellow group-hover:text-white transition-colors duration-300 shadow-sm">
                                                <i class="fas fa-shopping-cart text-xs"></i>
                                            </div>
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
                        
                        if (!empty($data['active_category'])) {
                            $pageBaseUrl = BASEURL . '/book/category/' . esc($data['active_category_slug']);
                        } else {
                            $pageBaseUrl = BASEURL . '/book';
                        }
                    ?>
                    
                    <!-- Prev -->
                    <?php if($data['current_page'] > 1): ?>
                        <?php $qs['page'] = $data['current_page'] - 1; ?>
                        <a href="<?= esc($pageBaseUrl) ?>?<?= http_build_query($qs) ?>" class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-unsoed-blue transition shadow-sm">
                            <i class="fas fa-chevron-left text-sm"></i>
                        </a>
                    <?php endif; ?>

                    <!-- Page Numbers -->
                    <?php for($i = 1; $i <= $data['total_pages']; $i++): ?>
                        <?php if($i == $data['current_page']): ?>
                            <span class="w-10 h-10 flex items-center justify-center bg-unsoed-blue text-white font-bold rounded-lg shadow-md"><?= esc($i) ?></span>
                        <?php else: ?>
                            <?php $qs['page'] = $i; ?>
                            <a href="<?= esc($pageBaseUrl) ?>?<?= http_build_query($qs) ?>" class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 text-gray-600 font-bold rounded-lg hover:bg-gray-50 hover:text-unsoed-blue transition shadow-sm">
                                <?= esc($i) ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <!-- Next -->
                    <?php if($data['current_page'] < $data['total_pages']): ?>
                        <?php $qs['page'] = $data['current_page'] + 1; ?>
                        <a href="<?= esc($pageBaseUrl) ?>?<?= http_build_query($qs) ?>" class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 hover:text-unsoed-blue transition shadow-sm">
                            <i class="fas fa-chevron-right text-sm"></i>
                        </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

        </div>

    </div>
</section>


