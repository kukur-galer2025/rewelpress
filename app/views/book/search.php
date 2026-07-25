<div class="bg-unsoed-darkblue py-16 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-unsoed-darkblue to-unsoed-blue"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-unsoed-yellow/20 rounded-full blur-3xl"></div>
    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-3xl md:text-5xl font-serif font-bold text-white mb-4">Hasil Pencarian</h1>
        <p class="text-lg text-gray-300">Menampilkan hasil untuk: <span class="text-unsoed-yellow font-bold">"<?= esc($data['keyword']) ?>"</span></p>
    </div>
</div>

<section class="py-16 bg-gray-50 min-h-[50vh]">
    <div class="container mx-auto px-4">
        
        <?php if(empty($data['buku']) && empty($data['ebooks'])): ?>
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-400 text-4xl">
                    <i class="fas fa-search-minus"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Pencarian Tidak Ditemukan</h3>
                <p class="text-gray-500 mb-8">Maaf, kami tidak dapat menemukan buku atau e-book dengan kata kunci tersebut.</p>
                <a href="<?= BASEURL; ?>" class="btn-primary inline-block"><i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda</a>
            </div>
        <?php else: ?>
            <p class="text-gray-600 mb-8 font-medium">Ditemukan total <span class="text-unsoed-blue font-bold"><?= count($data['buku']) + count($data['ebooks']) ?></span> hasil yang cocok.</p>
            
            <?php if(!empty($data['buku'])): ?>
            <div class="mb-12">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2 border-b border-gray-200 pb-3">
                    <i class="fas fa-book text-unsoed-blue"></i> Hasil Buku Fisik
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                    <?php foreach ($data['buku'] as $buku): 
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
                    <a href="<?= BASEURL; ?>/book/detail/<?= esc($buku['slug']) ?>" class="group flex flex-col bg-white rounded-2xl shadow-sm hover:shadow-2xl hover:shadow-unsoed-blue/20 hover:-translate-y-2 transition-all duration-500 border border-gray-100 hover:border-unsoed-blue/30 overflow-hidden relative h-full">
                        
                        <div class="absolute top-3 left-3 z-20 flex flex-col gap-1 pointer-events-none">
                            <?php if(isset($buku['is_flashsale']) && $buku['is_flashsale'] == 1): ?>
                                <span class="bg-gradient-to-r from-red-600 to-rose-500 text-white text-[9px] font-black px-2.5 py-1 rounded-full shadow-sm flex items-center gap-1 uppercase tracking-wider"><i class="fas fa-bolt"></i> Flash Sale</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="absolute top-3 right-3 z-20 pointer-events-none">
                            <?php if($discount > 0): ?>
                                <span class="bg-red-50 text-red-600 border border-red-200 text-[10px] font-bold px-2 py-1 rounded-lg shadow-sm">-<?= $discount ?>%</span>
                            <?php endif; ?>
                        </div>

                        <div class="relative w-full aspect-[3/4] bg-gray-50 overflow-hidden shrink-0">
                            <img src="<?= esc($img_src) ?>" alt="<?= htmlspecialchars($buku['title']) ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                            <?php if($stock <= 0): ?>
                                <div class="absolute inset-0 bg-white/70 backdrop-blur-[2px] flex items-center justify-center z-10">
                                    <span class="bg-gray-900 text-white font-bold text-xs px-4 py-1.5 rounded-full shadow-lg tracking-wider">HABIS</span>
                                </div>
                            <?php endif; ?>
                            <div class="absolute inset-0 bg-unsoed-darkblue/40 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 flex items-center justify-center">
                                <span class="bg-unsoed-yellow text-unsoed-darkblue hover:bg-white text-[11px] font-bold px-5 py-2.5 rounded-full shadow-2xl flex items-center gap-2 transform scale-75 group-hover:scale-100 transition-all duration-500 delay-75"><i class="fas fa-shopping-bag"></i> Lihat Detail</span>
                            </div>
                        </div>

                        <div class="p-4 flex flex-col flex-grow">
                            <div class="flex justify-between items-center mb-1">
                                <p class="text-[10px] text-unsoed-blue font-bold uppercase tracking-wider line-clamp-1 flex-1 pr-2"><?= esc($category) ?></p>
                                <div class="flex items-center gap-1 text-[11px] font-bold text-amber-500 shrink-0"><i class="fas fa-star"></i> <?= $avgRating ?></div>
                            </div>
                            
                            <h3 class="font-bold text-gray-900 text-sm md:text-[14px] leading-snug mb-1 line-clamp-2 group-hover:text-unsoed-blue transition-colors" title="<?= htmlspecialchars($buku['title']) ?>"><?= esc($buku['title']) ?></h3>
                            
                            <?php 
                                $authorStr = isset($buku['author']) ? $buku['author'] : 'Penulis';
                                $authors = explode(';', $authorStr);
                                $displayAuthor = trim($authors[0]);
                                if(count($authors) > 1) {
                                    $displayAuthor .= ' dkk.';
                                }
                            ?>
                            <p class="text-[11px] text-gray-500 mb-3 flex items-start gap-1.5"><i class="fas fa-user-edit text-gray-300 mt-0.5 shrink-0"></i> <span class="line-clamp-1" title="<?= esc($authorStr) ?>"><?= esc($displayAuthor) ?></span></p>
                            
                            <?php
                                $dynamicSold = (isset($buku['id']) ? ($buku['id'] * 13) % 150 : 0) + (isset($buku['review_count']) ? $buku['review_count'] * 5 : 0) + max(15, $stock * 2 + 7);
                            ?>
                            <div class="mt-auto pt-3 border-t border-gray-100/80 flex flex-col gap-0.5">
                                <div class="flex items-center justify-between h-[14px]">
                                    <?php if($discount > 0): ?>
                                        <span class="text-[10px] text-red-500 font-medium line-through decoration-red-500/60">Rp<?= number_format($buku['old_price'], 0, ',', '.') ?></span>
                                    <?php else: ?>
                                        <span></span>
                                    <?php endif; ?>
                                    <span class="text-[10px] text-gray-400 font-medium"><?= $dynamicSold ?>+ terjual</span>
                                </div>
                                <div class="flex items-baseline text-unsoed-darkblue font-extrabold leading-none">
                                    <span class="text-xs mr-0.5 font-bold">Rp</span><span class="text-base md:text-lg"><?= number_format($buku['price'], 0, ',', '.') ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if(!empty($data['ebooks'])): ?>
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2 border-b border-gray-200 pb-3">
                    <i class="fas fa-tablet-alt text-red-500"></i> Hasil E-Book Digital
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                    <?php foreach ($data['ebooks'] as $ebook): 
                        $judulEbook = !empty($ebook['title']) ? $ebook['title'] : $ebook['book_title'];
                        $isFree = (isset($ebook['is_free']) && $ebook['is_free'] == 1) || (isset($ebook['ebook_price']) && $ebook['ebook_price'] == 0);
                        $hargaEbook = $isFree ? 0 : (isset($ebook['ebook_price']) ? $ebook['ebook_price'] : 0);
                        $hargaNormal = isset($ebook['normal_price']) ? $ebook['normal_price'] : 0;
                        
                        $discount = 0;
                        if($hargaNormal > $hargaEbook && !$isFree) {
                            $discount = round((($hargaNormal - $hargaEbook) / $hargaNormal) * 100);
                        }

                        $coverSrc = 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=400';
                        if (!empty($ebook['cover_image'])) {
                            if (strpos($ebook['cover_image'], 'http') === 0) {
                                $coverSrc = $ebook['cover_image'];
                            } else if (strpos($ebook['cover_image'], 'cover_ebook_') === 0) {
                                $coverSrc = BASEURL . '/assets/uploads/covers/' . $ebook['cover_image'];
                            } else {
                                $coverSrc = BASEURL . '/assets/uploads/' . $ebook['cover_image'];
                            }
                        }

                        $penulis = !empty($ebook['book_author']) ? $ebook['book_author'] : 'Unsoed Press';
                        $penulisArr = explode(';', $penulis);
                        $displayPenulis = trim($penulisArr[0]);
                        if(count($penulisArr) > 1) $displayPenulis .= ' dkk.';
                        $avgRating = 5.0; 
                    ?>
                    <a href="<?= BASEURL; ?>/ebook/detail/<?= esc($ebook['id']) ?>" class="group flex flex-col bg-white rounded-2xl shadow-sm hover:shadow-2xl hover:shadow-red-500/20 hover:-translate-y-2 transition-all duration-500 border border-gray-100 hover:border-red-500/30 overflow-hidden relative h-full">
                        
                        <div class="absolute top-3 left-3 z-20 flex flex-col gap-1 pointer-events-none">
                            <span class="bg-red-500 text-white text-[9px] font-black px-2.5 py-1 rounded-full shadow-sm flex items-center gap-1 uppercase tracking-wider"><i class="fas fa-file-pdf"></i> E-Book</span>
                        </div>
                        
                        <div class="absolute top-3 right-3 z-20 pointer-events-none">
                            <?php if($discount > 0): ?>
                                <span class="bg-red-50 text-red-600 border border-red-200 text-[10px] font-bold px-2 py-1 rounded-lg shadow-sm">-<?= $discount ?>%</span>
                            <?php endif; ?>
                        </div>

                        <div class="relative w-full aspect-[3/4] bg-gray-50 overflow-hidden shrink-0">
                            <img src="<?= esc($coverSrc) ?>" alt="<?= htmlspecialchars($judulEbook) ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                            <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 flex items-center justify-center">
                                <span class="bg-white text-red-600 hover:bg-red-50 text-[11px] font-bold px-5 py-2.5 rounded-full shadow-2xl flex items-center gap-2 transform scale-75 group-hover:scale-100 transition-all duration-500 delay-75"><i class="fas fa-cloud-download-alt"></i> Lihat E-Book</span>
                            </div>
                        </div>

                        <div class="p-4 flex flex-col flex-grow">
                            <div class="flex justify-between items-center mb-1">
                                <p class="text-[10px] text-red-500 font-bold uppercase tracking-wider line-clamp-1 flex-1 pr-2"><?= esc($ebook['category_name'] ?? 'E-Book') ?></p>
                                <div class="flex items-center gap-1 text-[11px] font-bold text-amber-500 shrink-0"><i class="fas fa-star"></i> <?= $avgRating ?></div>
                            </div>
                            
                            <h3 class="font-bold text-gray-900 text-sm md:text-[14px] leading-snug mb-1 line-clamp-2 group-hover:text-red-600 transition-colors" title="<?= htmlspecialchars($judulEbook) ?>"><?= esc($judulEbook) ?></h3>
                            
                            <p class="text-[11px] text-gray-500 mb-3 flex items-start gap-1.5"><i class="fas fa-user-edit text-gray-300 mt-0.5 shrink-0"></i> <span class="line-clamp-1" title="<?= esc($penulis) ?>"><?= esc($displayPenulis) ?></span></p>
                            
                            <div class="mt-auto pt-3 border-t border-gray-100/80 flex flex-col gap-0.5">
                                <div class="flex items-center justify-between h-[14px]">
                                    <?php if($hargaNormal > $hargaEbook && !$isFree): ?>
                                        <span class="text-[10px] text-red-500 font-medium line-through decoration-red-500/60">Rp<?= number_format($hargaNormal, 0, ',', '.') ?></span>
                                    <?php else: ?>
                                        <span></span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex items-baseline text-red-600 font-extrabold leading-none mt-1">
                                    <?php if($isFree): ?>
                                        <span class="text-base md:text-lg">GRATIS</span>
                                    <?php else: ?>
                                        <span class="text-xs mr-0.5 font-bold">Rp</span><span class="text-base md:text-lg"><?= number_format($hargaEbook, 0, ',', '.') ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            
        <?php endif; ?>

    </div>
</section>
