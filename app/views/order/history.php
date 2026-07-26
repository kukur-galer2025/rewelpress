<!-- Page Header -->
<div class="bg-unsoed-darkblue py-12 relative overflow-hidden shadow-md">
    <div class="absolute inset-0 bg-gradient-to-r from-unsoed-darkblue to-unsoed-blue"></div>
    <div class="container mx-auto px-4 max-w-6xl relative z-10">
        <span class="text-xs font-bold uppercase tracking-widest text-unsoed-yellow bg-white/10 px-3 py-1 rounded-full border border-white/10 mb-3 inline-block">
            Pusat Pesanan & Digital Library
        </span>
        <h1 class="text-3xl md:text-4xl font-serif font-bold text-white mb-2">Riwayat Pesanan Anda</h1>
        <p class="text-gray-300 text-sm md:text-base max-w-2xl">Pantau status pengiriman buku fisik serta unduh file e-book yang telah terverifikasi pembayarannya di sini.</p>
    </div>
</div>

<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 max-w-6xl">
        
        <!-- Flash Messages -->
        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'success_upload'): ?>
            <div class="bg-green-50 border border-green-300 p-4 mb-8 rounded-2xl flex items-center gap-3 shadow-sm">
                <i class="fas fa-check-circle text-green-600 text-xl flex-shrink-0"></i>
                <div>
                    <p class="text-sm font-bold text-green-800">Bukti pembayaran berhasil diunggah!</p>
                    <p class="text-xs text-green-600 font-normal">Pesanan Anda sedang dalam tahap verifikasi admin. Anda akan mendapatkan akses begitu verifikasi selesai.</p>
                </div>
            </div>
        <?php endif; ?>

        <?php 
        $hasEbooks = !empty($data['ebook_orders']);
        $hasBooks  = !empty($data['orders']);
        ?>

        <?php if(!$hasEbooks && !$hasBooks): ?>
            <!-- EMPTY STATE -->
            <div class="bg-white rounded-3xl p-14 text-center shadow-sm border border-gray-200 max-w-2xl mx-auto my-8">
                <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6 text-unsoed-blue">
                    <i class="fas fa-shopping-bag text-4xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Pesanan</h2>
                <p class="text-gray-500 mb-8 text-sm leading-relaxed max-w-md mx-auto">Anda belum pernah melakukan pemesanan buku fisik maupun e-book digital. Temukan berbagai publikasi ilmiah terbaik di katalog kami.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="<?= BASEURL ?>/ebook" class="px-6 py-3 bg-unsoed-blue hover:bg-blue-800 text-white rounded-xl font-bold text-sm shadow-md transition flex items-center justify-center gap-2">
                        <i class="fas fa-tablet-alt"></i> Lihat E-Book
                    </a>
                    <a href="<?= BASEURL ?>" class="px-6 py-3 border border-gray-300 hover:border-unsoed-blue text-gray-700 hover:text-unsoed-blue rounded-xl font-bold text-sm transition flex items-center justify-center gap-2">
                        <i class="fas fa-book"></i> Katalog Buku Fisik
                    </a>
                </div>
            </div>
        <?php else: ?>

            <div class="space-y-12">

                <!-- ================== SECTION: RIWAYAT PESANAN ================== -->
                <div>
                    <div class="flex items-center gap-3 mb-6 pb-3 border-b border-gray-200">
                        <div class="w-10 h-10 rounded-xl bg-unsoed-blue text-white flex items-center justify-center font-bold text-lg">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Daftar Pesanan Anda</h2>
                            <p class="text-xs text-gray-500">Semua pesanan buku fisik cetakan maupun e-book digital Anda berada di sini.</p>
                        </div>
                    </div>

                    <?php if(!$hasBooks): ?>
                        <div class="bg-white rounded-2xl p-8 text-center border border-dashed border-gray-300 text-gray-400 text-sm">
                            Belum ada pesanan yang dibuat. <a href="<?= BASEURL ?>" class="text-unsoed-blue font-bold underline hover:text-blue-800">Mulai Belanja</a>
                        </div>
                    <?php else: ?>
                        <div class="space-y-6">
                            <?php foreach($data['orders'] as $order): ?>
                            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 hover:shadow-md transition">
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-100 pb-4 mb-4 gap-4">
                                    <div class="flex items-center gap-3">
                                        <span class="bg-gray-100 text-gray-700 text-xs font-mono font-bold px-3 py-1 rounded-lg border border-gray-200">
                                            Pesanan #<?= esc($order['id']) ?>
                                        </span>
                                        <span class="text-xs text-gray-400">
                                            <i class="far fa-calendar-alt mr-1"></i> <?= date('d M Y, H:i', strtotime($order['created_at'])) ?>
                                        </span>
                                    </div>
                                    
                                    <div>
                                        <?php if($order['status'] == 'pending'): ?>
                                            <span class="px-3.5 py-1 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-full text-xs font-bold uppercase tracking-wider">
                                                <i class="fas fa-hourglass-half mr-1"></i> Menunggu Pembayaran
                                            </span>
                                        <?php elseif($order['status'] == 'paid'): ?>
                                            <span class="px-3.5 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-full text-xs font-bold uppercase tracking-wider">
                                                <i class="fas fa-clock mr-1 animate-pulse"></i> Menunggu Konfirmasi
                                            </span>
                                        <?php elseif($order['status'] == 'confirmed'): ?>
                                            <span class="px-3.5 py-1 bg-green-50 text-green-700 border border-green-200 rounded-full text-xs font-bold uppercase tracking-wider">
                                                <i class="fas fa-check-circle mr-1"></i> Selesai / Diproses
                                            </span>
                                        <?php elseif($order['status'] == 'rejected'): ?>
                                            <span class="px-3.5 py-1 bg-red-50 text-red-700 border border-red-200 rounded-full text-xs font-bold uppercase tracking-wider">
                                                <i class="fas fa-times-circle mr-1"></i> Ditolak
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php 
                                $hasPhysical = false;
                                if(!empty($order['items'])) {
                                    foreach($order['items'] as $item) {
                                        if($item['item_type'] === 'book') $hasPhysical = true;
                                    }
                                }
                                ?>
                                
                                <!-- Detail Pengiriman -->
                                <div class="mt-2 mb-4 p-4 bg-gray-50 rounded-xl border border-gray-100 text-sm">
                                    <div class="mb-2">
                                        <span class="text-gray-500 block text-xs font-bold uppercase mb-1">Metode Penerimaan</span>
                                        <span class="font-medium text-gray-800">
                                            <?php if(!$hasPhysical): ?>
                                                <i class="fas fa-cloud-download-alt text-green-500 mr-1"></i> Pengiriman Digital (Unduhan E-Book)
                                            <?php else: ?>
                                                <?= $order['delivery_method'] == 'shipping' ? '<i class="fas fa-truck text-unsoed-blue mr-1"></i> Kirim via Kurir (J&T/JNE)' : '<i class="fas fa-store text-amber-500 mr-1"></i> Ambil di Kantor Unsoed Press' ?>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <?php if($hasPhysical && $order['delivery_method'] == 'shipping' && !empty($order['shipping_address'])): ?>
                                    <div class="mt-3 pt-3 border-t border-gray-200">
                                        <span class="text-gray-500 block text-xs font-bold uppercase mb-1">Alamat Pengiriman (Ongkir DFOD)</span>
                                        <span class="font-medium text-gray-800 break-words"><?= nl2br(htmlspecialchars($order['shipping_address'])) ?></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Daftar Buku & Ulasan -->
                                <?php if(!empty($order['items'])): ?>
                                <div class="mt-4 mb-4 space-y-3">
                                    <p class="text-xs text-gray-500 font-bold uppercase">Item Pesanan</p>
                                    <?php foreach($order['items'] as $item): ?>
                                    <div class="flex items-center justify-between bg-white p-3 rounded-xl border border-gray-100 shadow-sm">
                                        <div class="flex items-center gap-3 w-full sm:w-auto">
                                            <div class="w-10 h-14 bg-gray-100 border border-gray-200 rounded flex-shrink-0 overflow-hidden shadow-[0_2px_4px_rgba(0,0,0,0.05)] relative">
                                                <?php if($item['item_type'] === 'ebook'): ?>
                                                    <div class="absolute bottom-0 inset-x-0 bg-red-600 text-white text-[6px] font-extrabold text-center py-0.5 uppercase z-10">PDF</div>
                                                <?php endif; ?>
                                                <?php 
                                                    $itemImg = 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=400';
                                                    if (!empty($item['image'])) {
                                                        $itemImg = (strpos($item['image'], 'http') === 0) ? $item['image'] : BASEURL . '/assets/uploads/' . (strpos($item['image'], 'cover_ebook_') === 0 ? 'covers/' : '') . $item['image'];
                                                    }
                                                ?>
                                                <img src="<?= esc($itemImg) ?>" class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex-grow">
                                                <a href="<?= BASEURL ?>/<?= $item['item_type'] ?>/detail/<?= $item['item_type'] === 'ebook' ? $item['ebook_id'] : $item['book_id'] ?>" class="text-sm font-bold text-gray-800 hover:text-unsoed-blue line-clamp-1">
                                                    <?= htmlspecialchars($item['title']) ?>
                                                </a>
                                                <p class="text-xs text-gray-500 mt-0.5"><?= $item['quantity'] ?> x Rp <?= number_format($item['price'], 0, ',', '.') ?></p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center gap-2 mt-3 sm:mt-0">
                                            <?php if($order['status'] == 'confirmed'): ?>
                                                <?php if($item['item_type'] === 'ebook'): ?>
                                                    <a href="<?= BASEURL ?>/ebook/download/<?= esc($item['ebook_id']) ?>" class="px-4 py-2 bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 text-white rounded-lg text-xs font-bold transition flex items-center gap-2 shadow-sm whitespace-nowrap">
                                                        <i class="fas fa-cloud-download-alt"></i> Unduh
                                                    </a>
                                                <?php endif; ?>
                                                <a href="<?= BASEURL ?>/<?= $item['item_type'] ?>/detail/<?= $item['item_type'] === 'ebook' ? $item['ebook_id'] : $item['book_id'] ?>#reviews-section" onclick="sessionStorage.setItem('openReviewModal', '1');" class="px-4 py-2 bg-unsoed-yellow hover:bg-yellow-500 text-gray-900 rounded-lg text-xs font-bold transition flex items-center gap-2 shadow-sm whitespace-nowrap">
                                                    <i class="fas fa-star"></i> Ulas
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                                
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mt-6 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase font-bold mb-1">Total Belanja</p>
                                        <p class="text-xl font-extrabold text-unsoed-blue">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></p>
                                    </div>
                                    
                                    <?php if($order['status'] == 'pending'): ?>
                                        <a href="<?= BASEURL; ?>/order/pay/<?= esc($order['id']) ?>" class="bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white px-6 py-2.5 rounded-xl font-bold shadow-md transition text-sm flex items-center gap-2">
                                            <i class="fas fa-credit-card"></i> Bayar Sekarang
                                        </a>
                                    <?php elseif($order['status'] == 'paid'): ?>
                                        <span class="text-xs text-gray-500 bg-gray-100 px-4 py-2.5 rounded-xl font-medium border border-gray-200">
                                            <i class="fas fa-user-clock text-blue-500 mr-1.5"></i> Sedang disiapkan & dikemas
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

        <?php endif; ?>

    </div>
</section>
