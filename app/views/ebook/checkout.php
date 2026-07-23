<?php $ebook = $data['ebook']; ?>
<!-- Header Banner -->
<div class="bg-gradient-to-r from-unsoed-darkblue to-blue-900 py-12 text-white relative overflow-hidden shadow-md">
    <div class="container mx-auto px-4 max-w-4xl relative z-10">
        <div class="flex items-center gap-3 mb-2">
            <h1 class="text-3xl font-serif font-bold tracking-tight text-white">Konfirmasi Pesanan Anda</h1>
            <span class="bg-indigo-500/80 backdrop-blur border border-indigo-400 text-white text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-widest shadow-sm"><i class="fas fa-laptop-code mr-1"></i> Beli E-Book Digital</span>
        </div>
        <p class="text-blue-200 text-sm mt-1">Periksa kembali rincian publikasi e-book dan terapkan kode promo jika tersedia.</p>
    </div>
</div>

<!-- Main Content -->
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 max-w-4xl">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Detail E-Book -->
            <div class="md:col-span-2 space-y-6">
                
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-200 flex flex-col sm:flex-row gap-6 items-start">
                    <?php $cover = !empty($ebook['cover_image']) ? BASEURL . '/assets/uploads/covers/' . $ebook['cover_image'] : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=400'; ?>
                    <img src="<?= esc($cover) ?>" alt="<?= htmlspecialchars($ebook['title']) ?>" class="w-28 sm:w-36 rounded-2xl shadow-lg object-cover aspect-[3/4] flex-shrink-0 mx-auto sm:mx-0">
                    
                    <div class="flex-1">
                        <span class="inline-block px-2.5 py-0.5 bg-blue-50 text-unsoed-blue font-bold text-[11px] rounded-md mb-2 border border-blue-100 uppercase">
                            <i class="fas fa-tablet-alt mr-1"></i> E-Book Digital (PDF)
                        </span>
                        <h2 class="text-xl font-bold text-gray-900 leading-snug"><?= htmlspecialchars($ebook['title']) ?></h2>
                        <p class="text-xs text-gray-500 mt-1">Oleh: <span class="font-semibold text-gray-700"><?= htmlspecialchars($ebook['author'] ?? 'Unsoed Press') ?></span></p>
                        
                        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-xs text-gray-500">Harga Normal:</span>
                            <span class="font-extrabold text-lg text-gray-800">Rp <?= number_format($ebook['ebook_price'], 0, ',', '.') ?></span>
                        </div>
                    </div>
                </div>

                <!-- Kotak Voucher & Promo -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-200">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2 mb-4 text-base">
                        <i class="fas fa-ticket-alt text-amber-500 text-lg"></i> Kode Voucher & Promo
                    </h3>

                    <?php if(isset($_GET['voucher_err']) || isset($data['voucher_error'])): ?>
                        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 rounded-2xl text-xs flex items-center justify-between">
                            <span><i class="fas fa-exclamation-circle mr-1"></i> <?= htmlspecialchars($_GET['voucher_err'] ?? $data['voucher_error']) ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if(!empty($data['applied_voucher'])): ?>
                        <!-- Voucher Terpasang -->
                        <div class="p-4 bg-green-50 border-2 border-green-300 rounded-2xl flex items-center justify-between gap-2">
                            <div>
                                <span class="text-[10px] font-extrabold text-green-600 uppercase tracking-wider block">Voucher Digunakan:</span>
                                <span class="font-mono font-bold text-sm text-green-900"><?= htmlspecialchars($data['applied_voucher']['code']) ?></span>
                                <p class="text-xs text-green-700 font-semibold mt-0.5">Hemat Rp <?= number_format($data['applied_voucher']['discount_amount'], 0, ',', '.') ?></p>
                            </div>
                            <a href="<?= BASEURL; ?>/ebook/remove_voucher_checkout/<?= esc($ebook['id']) ?>" class="p-2 text-red-500 hover:bg-red-100 rounded-xl transition font-bold text-xs" title="Hapus Voucher">
                                <i class="fas fa-times text-base"></i>
                            </a>
                        </div>
                    <?php else: ?>
                        <!-- Form Input Voucher -->
                        <form action="<?= BASEURL; ?>/ebook/apply_voucher_checkout/<?= esc($ebook['id']) ?>" method="POST" class="flex gap-2 mb-4">
<?= csrf_field() ?><input type="text" name="voucher_code" placeholder="Ketik kode promo..." 
                                   class="flex-1 px-4 py-3 rounded-xl border border-gray-300 focus:border-unsoed-blue text-xs font-mono font-bold uppercase text-gray-800">
                            <button type="submit" class="bg-unsoed-blue hover:bg-blue-800 text-white px-5 py-3 rounded-xl font-bold text-xs shadow transition">
                                Pakai
                            </button>
                        </form>

                        <!-- Daftar Voucher Aktif -->
                        <?php if(!empty($data['active_vouchers'])): ?>
                            <div class="space-y-2 mt-4 pt-4 border-t border-gray-100">
                                <p class="text-[11px] font-extrabold text-gray-400 uppercase tracking-wider">Promo E-Book Tersedia:</p>
                                <div class="max-h-48 overflow-y-auto pr-1 space-y-2">
                                    <?php foreach($data['active_vouchers'] as $av): ?>
                                        <div class="p-3 bg-amber-50/60 border border-amber-200/80 rounded-2xl flex items-center justify-between gap-2 hover:bg-amber-50 transition">
                                            <div class="min-w-0">
                                                <span class="font-mono font-bold text-xs text-amber-900 bg-amber-100 px-2 py-0.5 rounded"><?= htmlspecialchars($av['code']) ?></span>
                                                <p class="text-[11px] font-bold text-gray-800 truncate mt-1"><?= htmlspecialchars($av['title']) ?></p>
                                                <p class="text-[10px] text-gray-500">Min. Belanja: Rp <?= number_format($av['min_purchase'], 0, ',', '.') ?></p>
                                            </div>
                                            <form action="<?= BASEURL; ?>/ebook/apply_voucher_checkout/<?= esc($ebook['id']) ?>" method="POST">
<?= csrf_field() ?><input type="hidden" name="voucher_code" value="<?= htmlspecialchars($av['code']) ?>">
                                                <button type="submit" class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-[10px] font-extrabold rounded-lg shadow-sm transition whitespace-nowrap">
                                                    Klaim
                                                </button>
                                            </form>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

            </div>

            <!-- Ringkasan & Konfirmasi -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-200 sticky top-24">
                    <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-4 mb-4 text-base">Ringkasan Tagihan</h3>

                    <?php 
                    $subtotal = floatval($ebook['ebook_price']);
                    $discount = !empty($data['applied_voucher']) ? floatval($data['applied_voucher']['discount_amount']) : 0;
                    $final_price = max(0, $subtotal - $discount);
                    ?>

                    <div class="space-y-3 mb-6 text-xs text-gray-600">
                        <div class="flex justify-between">
                            <span>Harga E-Book</span>
                            <span class="font-semibold text-gray-800">Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
                        </div>
                        <?php if($discount > 0): ?>
                        <div class="flex justify-between text-green-600 font-bold">
                            <span>Diskon Voucher</span>
                            <span>- Rp <?= number_format($discount, 0, ',', '.') ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="flex justify-between">
                            <span>Format File</span>
                            <span class="font-bold text-gray-800">PDF Digital</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-800 text-sm">Total Bayar</span>
                            <span class="font-extrabold text-xl text-unsoed-blue">Rp <?= number_format($final_price, 0, ',', '.') ?></span>
                        </div>
                    </div>

                    <form action="<?= BASEURL; ?>/ebook/order_ebook/<?= esc($ebook['id']) ?>" method="POST">
<?= csrf_field() ?><button type="submit" class="w-full bg-unsoed-blue hover:bg-blue-800 text-white font-bold py-4 px-6 rounded-2xl shadow-lg hover:shadow-xl transition flex items-center justify-center gap-2 text-sm">
                            <span>Buat Pesanan & Bayar</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>

                    <p class="text-[11px] text-gray-400 text-center mt-4 flex items-center justify-center gap-1.5">
                        <i class="fas fa-shield-alt text-green-500"></i> Akses terbuka di Riwayat Pesanan setelah bayar
                    </p>
                </div>
            </div>

        </div>

    </div>
</section>
<?= csrf_field() ?>
