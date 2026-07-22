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
        
        <?php if(empty($data['buku'])): ?>
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-400 text-4xl">
                    <i class="fas fa-search-minus"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Buku Tidak Ditemukan</h3>
                <p class="text-gray-500 mb-8">Maaf, kami tidak dapat menemukan buku dengan kata kunci tersebut. Coba gunakan kata kunci yang berbeda.</p>
                <a href="<?= BASEURL; ?>" class="btn-primary inline-block"><i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda</a>
            </div>
        <?php else: ?>
            <p class="text-gray-600 mb-8 font-medium">Ditemukan <span class="text-unsoed-blue font-bold"><?= count($data['buku']) ?></span> buku yang cocok dengan pencarian Anda.</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                <?php foreach ($data['buku'] as $buku): 
                    $discount = 0;
                    if($buku['old_price'] > $buku['price']) {
                        $discount = round((($buku['old_price'] - $buku['price']) / $buku['old_price']) * 100);
                    }
                ?>
                <a href="<?= BASEURL; ?>/book/detail/<?= esc($buku['slug']) ?>" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-card transition-all duration-500 flex flex-col group cursor-pointer border border-gray-100 relative h-full">
                    
                    <?php if($discount > 0): ?>
                    <div class="absolute top-3 right-3 z-20 w-10 h-10 bg-red-500 text-white rounded-full flex flex-col items-center justify-center font-bold text-[10px] shadow-md transform group-hover:scale-110 transition-transform">
                        <span><?= esc($discount) ?>%</span>
                    </div>
                    <?php endif; ?>

                    <div class="relative overflow-hidden pt-[140%] bg-gray-100">
                        <?php $img_src = !empty($buku['image']) ? $buku['image'] : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=400'; ?>
                        <img src="<?= esc($img_src) ?>" alt="<?= esc($buku['title']) ?>" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                    </div>
                    
                    <div class="p-5 flex flex-col flex-grow relative z-10 bg-white">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1 line-clamp-1"><?= esc($buku['category_name']) ?></span>
                        <h3 class="text-sm md:text-md font-bold text-gray-800 leading-snug mb-1 group-hover:text-unsoed-blue transition-colors line-clamp-2">
                            <?= esc($buku['title']) ?>
                        </h3>
                        
                        <!-- Rating Bar & Tag (Shopee Style) -->
                        <?php 
                            $avgRating = isset($buku['avg_rating']) ? $buku['avg_rating'] : 4.8;
                            $stock = isset($buku['stock']) ? (int)$buku['stock'] : 0;
                            $soldCount = max(15, $stock * 3 + 12);
                        ?>
                        <div class="flex items-center gap-1.5 mt-1.5">
                            <div class="flex items-center gap-1 text-[11px] font-bold text-amber-500"><i class="fas fa-star"></i> <span><?= $avgRating ?></span></div>
                            <?php if($buku['old_price'] > 0): ?>
                                <?php $disc = round((($buku['old_price'] - $buku['price']) / $buku['old_price']) * 100); ?>
                                <span class="px-1 py-[1px] border border-red-500 text-red-600 rounded-[2px] text-[8px] font-medium leading-tight tracking-tight">Hemat <?= $disc ?>%</span>
                            <?php elseif($stock <= 5 && $stock > 0): ?>
                                <span class="px-1 py-[1px] border border-amber-500 text-amber-600 rounded-[2px] text-[8px] font-medium leading-tight tracking-tight">Stok Terbatas</span>
                            <?php endif; ?>
                        </div>

                        <!-- Shopee style bottom price row (with Unsoed Blue color) & sold count -->
                        <div class="flex items-baseline justify-between mt-auto pt-2 border-t border-gray-100/60">
                            <?php if($buku['old_price'] > 0): ?>
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-gray-400 line-through leading-none">Rp<?= number_format($buku['old_price'], 0, ',', '.') ?></span>
                                    <div class="flex items-baseline text-unsoed-blue font-extrabold leading-none mt-0.5">
                                        <span class="text-xs font-bold mr-0.5">Rp</span><span class="text-base md:text-lg"><?= number_format($buku['price'], 0, ',', '.') ?></span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="flex items-baseline text-unsoed-blue font-extrabold leading-none">
                                    <span class="text-xs font-bold mr-0.5">Rp</span><span class="text-base md:text-lg"><?= number_format($buku['price'], 0, ',', '.') ?></span>
                                </div>
                            <?php endif; ?>
                            <span class="text-[11px] text-gray-500 font-medium"><?= $soldCount ?>+ terjual</span>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
