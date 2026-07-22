<!-- Header Banner -->
<div class="bg-gradient-to-br from-unsoed-darkblue via-unsoed-blue to-blue-800 py-16 relative overflow-hidden text-white shadow-xl">
    <div class="absolute -right-20 -top-20 w-80 h-80 bg-unsoed-yellow/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-blue-400/10 rounded-full blur-3xl pointer-events-none"></div>
    
    <div class="container mx-auto px-4 max-w-[1100px] relative z-10 text-center">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-unsoed-yellow font-extrabold text-xs uppercase tracking-widest mb-4 backdrop-blur-md">
            <i class="fas fa-gift animate-bounce"></i> Promo & Penawaran Terbatas
        </span>
        <h1 class="text-3xl md:text-5xl font-serif font-extrabold tracking-tight mb-4 leading-tight">
            Voucher Diskon Spesial Unsoed Press
        </h1>
        <p class="text-blue-100 text-sm md:text-lg max-w-2xl mx-auto font-normal leading-relaxed">
            Nikmati potongan harga eksklusif untuk pembelian buku fisik cetakan maupun publikasi e-book digital. Salin kode vouchernya dan gunakan saat proses pembayaran!
        </p>
    </div>
</div>

<!-- Main Content -->
<section class="py-16 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 max-w-[1100px]">

        <?php if (empty($data['vouchers'])): ?>
            <!-- EMPTY STATE -->
            <div class="bg-white rounded-3xl p-14 text-center shadow-sm border border-gray-200 max-w-xl mx-auto my-6">
                <div class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-6 text-amber-500">
                    <i class="fas fa-ticket-alt text-3xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Promo Aktif</h2>
                <p class="text-gray-500 text-sm max-w-sm mx-auto mb-6">Saat ini belum ada kode voucher atau promo diskon yang tersedia. Nantikan penawaran spesial kami berikutnya!</p>
                <a href="<?= BASEURL ?>" class="px-6 py-3 bg-unsoed-blue hover:bg-blue-800 text-white rounded-xl font-bold text-sm shadow-md transition inline-flex items-center gap-2">
                    <i class="fas fa-book"></i> Jelajahi Katalog Buku
                </a>
            </div>
        <?php else: ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($data['vouchers'] as $v): ?>
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-200 transition-all duration-300 flex flex-col justify-between group relative">
                    
                    <!-- Top Badge & Decor -->
                    <div class="p-6 pb-4 border-b border-gray-100 relative">
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <?php if($v['applicable_to'] === 'ebook'): ?>
                                <span class="bg-red-50 text-red-600 border border-red-200 text-[11px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fas fa-tablet-alt"></i> Khusus E-Book
                                </span>
                            <?php elseif($v['applicable_to'] === 'book'): ?>
                                <span class="bg-amber-50 text-amber-700 border border-amber-200 text-[11px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fas fa-book"></i> Khusus Buku Fisik
                                </span>
                            <?php else: ?>
                                <span class="bg-blue-50 text-unsoed-blue border border-blue-200 text-[11px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fas fa-layer-group"></i> Semua Produk
                                </span>
                            <?php endif; ?>

                            <span class="text-[11px] font-bold text-green-600 bg-green-50 px-2.5 py-1 rounded-lg">
                                <i class="fas fa-check-circle mr-1"></i> Aktif
                            </span>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-unsoed-blue transition leading-snug">
                            <?= htmlspecialchars($v['title']) ?>
                        </h3>
                        <p class="text-xs text-gray-500 mt-2 line-clamp-2 leading-relaxed">
                            <?= htmlspecialchars($v['description']) ?>
                        </p>
                    </div>

                    <!-- Discount Detail & Terms -->
                    <div class="p-6 py-4 bg-gray-50/70 space-y-2 text-xs flex-1">
                        <div class="flex justify-between items-center text-gray-600">
                            <span>Nilai Potongan:</span>
                            <span class="font-extrabold text-base text-unsoed-blue">
                                <?php if($v['discount_type'] === 'percent'): ?>
                                    Diskon <?= floatval($v['discount_value']) ?>%
                                    <?php if(!empty($v['max_discount']) && $v['max_discount'] > 0): ?>
                                        <span class="text-[10px] text-gray-400 font-normal block text-right">(Maks. Rp <?= number_format($v['max_discount'], 0, ',', '.') ?>)</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    Rp <?= number_format($v['discount_value'], 0, ',', '.') ?>
                                <?php endif; ?>
                            </span>
                        </div>

                        <div class="flex justify-between items-center text-gray-600">
                            <span>Min. Pembelian:</span>
                            <span class="font-bold text-gray-800">
                                <?= $v['min_purchase'] > 0 ? 'Rp ' . number_format($v['min_purchase'], 0, ',', '.') : 'Tanpa Minimum' ?>
                            </span>
                        </div>

                        <?php if(!empty($v['end_date'])): ?>
                        <div class="flex justify-between items-center text-gray-600">
                            <span>Berlaku Hingga:</span>
                            <span class="font-semibold text-gray-700">
                                <i class="far fa-clock text-orange-500 mr-1"></i> <?= date('d M Y', strtotime($v['end_date'])) ?>
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Voucher Code Box + Copy Button -->
                    <div class="p-6 pt-4 bg-white border-t border-dashed border-gray-200">
                        <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-widest mb-1.5">Kode Voucher</p>
                        <div class="flex items-center gap-2">
                            <div class="flex-1 bg-blue-50/60 border-2 border-dashed border-blue-300 rounded-2xl px-4 py-3 font-mono font-extrabold text-lg text-unsoed-blue tracking-wider text-center select-all">
                                <?= htmlspecialchars($v['code']) ?>
                            </div>
                            <button onclick="copyVoucherCode('<?= htmlspecialchars($v['code']) ?>', this)" 
                                    class="p-3.5 bg-unsoed-blue hover:bg-blue-800 text-white rounded-2xl transition shadow-md flex items-center justify-center font-bold text-xs gap-1.5 flex-shrink-0" title="Salin Kode Voucher">
                                <i class="fas fa-copy text-base"></i>
                                <span>Salin</span>
                            </button>
                        </div>
                    </div>

                </div>
                <?php endforeach; ?>
            </div>

            <!-- Cara Penggunaan -->
            <div class="mt-16 bg-white rounded-3xl p-8 md:p-10 border border-gray-200 shadow-sm">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <i class="fas fa-info-circle text-unsoed-blue"></i> Cara Menggunakan Kode Voucher
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-blue-50 text-unsoed-blue font-bold flex items-center justify-center flex-shrink-0 text-base">1</div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-sm mb-1">Pilih & Salin Kode</h4>
                            <p class="text-xs text-gray-500 leading-relaxed">Temukan voucher yang sesuai dengan pembelian Anda (Buku Fisik/E-Book), lalu klik tombol <strong>Salin</strong>.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-blue-50 text-unsoed-blue font-bold flex items-center justify-center flex-shrink-0 text-base">2</div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-sm mb-1">Tempel Saat Checkout</h4>
                            <p class="text-xs text-gray-500 leading-relaxed">Pada halaman keranjang belanja atau konfirmasi pembelian E-Book, tempelkan kode pada kotak input voucher.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-green-50 text-green-600 font-bold flex items-center justify-center flex-shrink-0 text-base">3</div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-sm mb-1">Diskon Otomatis Dipotong</h4>
                            <p class="text-xs text-gray-500 leading-relaxed">Total belanja Anda akan langsung dikurangi sesuai nilai promo yang berlaku. Selesaikan pembayaran dan hemat lebih banyak!</p>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>
</section>

<!-- Script Copy to Clipboard -->
<script>
function copyVoucherCode(code, btnElement) {
    navigator.clipboard.writeText(code).then(function() {
        const originalHTML = btnElement.innerHTML;
        btnElement.innerHTML = '<i class="fas fa-check"></i> <span>Tersalin!</span>';
        btnElement.classList.remove('bg-unsoed-blue', 'hover:bg-blue-800');
        btnElement.classList.add('bg-green-600', 'hover:bg-green-700');
        
        setTimeout(function() {
            btnElement.innerHTML = originalHTML;
            btnElement.classList.remove('bg-green-600', 'hover:bg-green-700');
            btnElement.classList.add('bg-unsoed-blue', 'hover:bg-blue-800');
        }, 2000);
    }).catch(function(err) {
        alert('Gagal menyalin kode: ' + code);
    });
}
</script>
