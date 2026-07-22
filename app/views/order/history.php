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

                <!-- ================== SECTION 1: PESANAN E-BOOK (DIGITAL) ================== -->
                <div>
                    <div class="flex items-center gap-3 mb-6 pb-3 border-b border-gray-200">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-unsoed-blue flex items-center justify-center font-bold text-lg">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Pesanan E-Book & Publikasi Digital</h2>
                            <p class="text-xs text-gray-500">Akses unduhan PDF E-Book Anda tersedia langsung pada kartu pesanan yang telah terverifikasi.</p>
                        </div>
                    </div>

                    <?php if(!$hasEbooks): ?>
                        <div class="bg-white rounded-2xl p-8 text-center border border-dashed border-gray-300 text-gray-400 text-sm">
                            Belum ada pesanan e-book. <a href="<?= BASEURL ?>/ebook" class="text-unsoed-blue font-bold underline hover:text-blue-800">Jelajahi E-Book Sekarang</a>
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-1 gap-6">
                            <?php foreach($data['ebook_orders'] as $eo): ?>
                            <?php
                                $coverSrc = 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=300&q=80';
                                if (!empty($eo['cover_image'])) {
                                    $coverSrc = (strpos($eo['cover_image'], 'http') === 0) ? $eo['cover_image'] : BASEURL . '/uploads/covers/' . $eo['cover_image'];
                                }
                            ?>
                            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 hover:shadow-md transition">
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-100 pb-4 mb-5 gap-4">
                                    <div class="flex items-center gap-3">
                                        <span class="bg-blue-50 text-unsoed-blue text-xs font-mono font-bold px-3 py-1 rounded-lg border border-blue-100">
                                            #EBO-<?= esc($eo['id']) ?>
                                        </span>
                                        <span class="text-xs text-gray-400">
                                            <i class="far fa-calendar-alt mr-1"></i> <?= date('d M Y, H:i', strtotime($eo['created_at'])) ?>
                                        </span>
                                    </div>

                                    <div>
                                        <?php if($eo['status'] == 'pending'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-full text-xs font-bold uppercase tracking-wider">
                                                <i class="fas fa-hourglass-half text-yellow-500"></i> Menunggu Pembayaran
                                            </span>
                                        <?php elseif($eo['status'] == 'paid'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-full text-xs font-bold uppercase tracking-wider">
                                                <i class="fas fa-clock text-blue-500 animate-pulse"></i> Menunggu Verifikasi Admin
                                            </span>
                                        <?php elseif($eo['status'] == 'confirmed'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-green-50 text-green-700 border border-green-200 rounded-full text-xs font-bold uppercase tracking-wider shadow-2xs">
                                                <i class="fas fa-check-circle text-green-600"></i> Terverifikasi — Siap Diunduh
                                            </span>
                                        <?php elseif($eo['status'] == 'rejected'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-50 text-red-700 border border-red-200 rounded-full text-xs font-bold uppercase tracking-wider">
                                                <i class="fas fa-times-circle text-red-500"></i> Pembayaran Ditolak
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="flex flex-col md:flex-row gap-6 items-center md:items-start justify-between">
                                    <div class="flex gap-4 items-center md:items-start w-full md:w-auto">
                                        <div class="w-16 h-20 rounded-xl overflow-hidden bg-gray-100 border border-gray-200 flex-shrink-0 shadow-sm relative">
                                            <img src="<?= esc($coverSrc) ?>" alt="Cover" class="w-full h-full object-cover">
                                            <div class="absolute bottom-0 inset-x-0 bg-red-600 text-white text-[8px] font-extrabold text-center py-0.5 uppercase">PDF</div>
                                        </div>
                                        <div>
                                            <a href="<?= BASEURL ?>/ebook/detail/<?= esc($eo['ebook_id']) ?>" class="text-base md:text-lg font-bold text-gray-800 hover:text-unsoed-blue transition line-clamp-1">
                                                <?= htmlspecialchars($eo['ebook_title']) ?>
                                            </a>
                                            <p class="text-xs text-gray-500 mt-1 flex items-center gap-3">
                                                <span><i class="fas fa-file-pdf text-red-500 mr-1"></i> Format PDF</span>
                                                <?php if(!empty($eo['file_size'])): ?>
                                                    <span>• <?= htmlspecialchars($eo['file_size']) ?></span>
                                                <?php endif; ?>
                                                <?php if(!empty($eo['page_count'])): ?>
                                                    <span>• <?= esc($eo['page_count']) ?> Halaman</span>
                                                <?php endif; ?>
                                            </p>

                                            <?php if($eo['status'] == 'rejected' && !empty($eo['note'])): ?>
                                                <div class="mt-3 bg-red-50 border border-red-200 rounded-xl p-2.5 text-xs text-red-700 flex items-center gap-2">
                                                    <i class="fas fa-info-circle flex-shrink-0"></i>
                                                    <span><strong>Catatan Admin:</strong> <?= htmlspecialchars($eo['note']) ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Kanan: Nominal & Tombol Unduh/Bayar -->
                                    <div class="flex flex-col sm:flex-row md:flex-col items-center sm:items-end justify-between md:justify-end w-full md:w-auto border-t md:border-t-0 pt-4 md:pt-0 gap-4">
                                        <div class="text-center sm:text-right">
                                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block">Nominal Pembayaran</span>
                                            <span class="text-xl font-extrabold text-unsoed-blue">Rp <?= number_format($eo['amount'], 0, ',', '.') ?></span>
                                        </div>

                                        <div class="flex items-center gap-2.5 w-full sm:w-auto">
                                            <?php if($eo['status'] == 'confirmed'): ?>
                                                <!-- TOMBOL UNDUH E-BOOK (UTAMA Sesuai Permintaan User) -->
                                                <a href="<?= BASEURL ?>/ebook/download/<?= esc($eo['ebook_id']) ?>"
                                                   class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 text-white font-bold rounded-xl shadow-md transition flex items-center justify-center gap-2 text-sm whitespace-nowrap">
                                                    <i class="fas fa-cloud-download-alt text-lg"></i> Unduh File E-Book
                                                </a>
                                            <?php elseif($eo['status'] == 'pending'): ?>
                                                <a href="<?= BASEURL ?>/ebook/pay/<?= esc($eo['id']) ?>"
                                                   class="w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-bold rounded-xl shadow-md transition flex items-center justify-center gap-2 text-sm whitespace-nowrap">
                                                    <i class="fas fa-credit-card"></i> Bayar Sekarang
                                                </a>
                                            <?php elseif($eo['status'] == 'paid'): ?>
                                                <div class="px-4 py-2.5 bg-gray-100 text-gray-500 rounded-xl font-medium text-xs flex items-center gap-2 whitespace-nowrap border border-gray-200">
                                                    <i class="fas fa-user-check text-blue-500"></i> Menunggu Verifikasi Admin
                                                </div>
                                            <?php endif; ?>

                                            <a href="<?= BASEURL ?>/ebook/detail/<?= esc($eo['ebook_id']) ?>" title="Lihat Detail E-Book"
                                               class="p-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl transition flex items-center justify-center">
                                                <i class="fas fa-external-link-alt text-sm"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- ================== SECTION 2: PESANAN BUKU FISIK (CETAKAN) ================== -->
                <div>
                    <div class="flex items-center gap-3 mb-6 pb-3 border-b border-gray-200">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-lg">
                            <i class="fas fa-book"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Pesanan Buku Fisik (Cetakan)</h2>
                            <p class="text-xs text-gray-500">Informasi pembelian buku cetak fisik yang dikirim melalui kurir ke alamat Anda.</p>
                        </div>
                    </div>

                    <?php if(!$hasBooks): ?>
                        <div class="bg-white rounded-2xl p-8 text-center border border-dashed border-gray-300 text-gray-400 text-sm">
                            Belum ada pesanan buku cetak fisik. <a href="<?= BASEURL ?>" class="text-unsoed-blue font-bold underline hover:text-blue-800">Mulai Belanja Buku Fisik</a>
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

                                <!-- Detail Pengiriman -->
                                <div class="mt-2 mb-4 p-4 bg-gray-50 rounded-xl border border-gray-100 text-sm">
                                    <div class="mb-2">
                                        <span class="text-gray-500 block text-xs font-bold uppercase mb-1">Metode Penerimaan</span>
                                        <span class="font-medium text-gray-800">
                                            <?= $order['delivery_method'] == 'shipping' ? '<i class="fas fa-truck text-unsoed-blue mr-1"></i> Kirim via Kurir (J&T/JNE)' : '<i class="fas fa-store text-amber-500 mr-1"></i> Ambil di Kantor Unsoed Press' ?>
                                        </span>
                                    </div>
                                    <?php if($order['delivery_method'] == 'shipping' && !empty($order['shipping_address'])): ?>
                                    <div class="mt-3 pt-3 border-t border-gray-200">
                                        <span class="text-gray-500 block text-xs font-bold uppercase mb-1">Alamat Pengiriman (Ongkir DFOD)</span>
                                        <span class="font-medium text-gray-800 break-words"><?= nl2br(htmlspecialchars($order['shipping_address'])) ?></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mt-6 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-400 uppercase font-bold mb-1">Total Belanja Buku Fisik</p>
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
